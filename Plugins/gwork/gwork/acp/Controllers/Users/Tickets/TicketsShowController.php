<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers\Users\Tickets {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Redirects\PermissionRedirect;

		use GWork\System\Helpers\ViewHelper\ViewHelper;
		
		use GWork\System\Models\Settings\SettingsFactory;
		use GWork\System\Models\User\UserFactory;
		
		use \Plugins\gwork\gwork\shop\Models\Ticket\TicketFactory;
		use \Plugins\gwork\gwork\shop\Models\TicketAnswer\TicketAnswerFactory;

		use Fabiang\Xmpp\Options;
		use Fabiang\Xmpp\Client;
		use Fabiang\Xmpp\Protocol\Message;

	    final class TicketsShowController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-users-tickets-id') {
					$ticketFactory = $this->getControllerParameters()->getModelsManager()->get(TicketFactory::class);
					
					$ticket = $ticketFactory->getByColumn('id', $vars['id']);
					
					if($ticket == null) {
						GWORK::redirect('/admin/users/tickets');
						return;
					}
					
					$view = ViewHelper::create($this, 'Users/Tickets/Show.php', 'usersView', ['pageName' => $this->getLanguage()->json()['Users']['Tickets']['PageName']], [], true);

					$view->ticket = $ticket;
					
					if(isset($_POST['ticket_answer_text'])) {
						$view->postAnswerText = $_POST['ticket_answer_text'];
						
						if(strlen($_POST['ticket_answer_text']) >= 3) {
							if(strlen($_POST['ticket_answer_text']) <= 15000) {
								$ticketAnswerFactory = $this->getControllerParameters()->getModelsManager()->get(TicketAnswerFactory::class);
								$ticketAnswerFactory->_create([
									'user_id' => $this->getUser()->getRow()->id,
									'timestamp' => time(),
									'text' => $_POST['ticket_answer_text'],
									'ticket_id' => $ticket->getRow()->id
								]);
											
								$view->postAnswerText = null;
								
								$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);
								$ticketUser = $userFactory->getByColumn('id', $ticket->getRow()->user_id);
								if($ticketUser != null) {
									if($ticketUser->getRow()->newsletter == 1 && strlen($ticketUser->getRow()->jabber) > 0) {
										$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);
										
										$options = new Options('tcp://' . $settings->JabberHost . ':' . $settings->JabberPort);
										$options->setUsername($settings->JabberUsername)->setPassword($settings->JabberPassword);
										$options->setContextOptions([
											'ssl' => [
												'allow_self_signed' => true,
												'verify_peer_name' => false,
												'verify_peer' => false
											]
										]);
										
										$client = new Client($options);
										
										$client->connect();
										
										$message = new Message();
										$message->setMessage(str_replace('%id%', $ticket->getRow()->id, $this->getLanguage()->json()['Users']['Tickets']['Show']['JabberSubject']) . $_POST['ticket_answer_text']);
										$message->setTo($ticketUser->getRow()->jabber);
										
										$client->send($message);
										
										$client->disconnect();
									}
								}
							}
						}
					}	
								
					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/users/tickets/show/{int:id}', $this, 'admin-users-tickets-id', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
