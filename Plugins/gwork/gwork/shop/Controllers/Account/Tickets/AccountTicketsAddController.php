<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers\Account\Tickets {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;
	    use GWork\System\Common;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use GWork\System\Models\Settings\SettingsFactory;

		use Plugins\gwork\gwork\shop\Redirects\UserNullRedirect;

		use Plugins\gwork\gwork\shop\Utils\CSRF\CSRF;

		use Plugins\gwork\gwork\shop\Models\Ticket\TicketFactory;

		use Plugins\gwork\gwork\shop\Libraries\ReCaptchaNS;

		use Fabiang\Xmpp\Options;
		use Fabiang\Xmpp\Client;
		use Fabiang\Xmpp\Protocol\Message;

	    final class AccountTicketsAddController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				$this->getRedirectsManager()->get(UserNullRedirect::class)->redirect('/login');

				if($route->getName() == 'account-tickets-add') {
					$view = ViewHelper::create($this, 'Account/Tickets/Add.php', 'accountTicketsView', [
						'pageName' => $this->getLanguage()->json()['Account']['Tickets']['Add']['PageName']
					], [], true);

					if(isset($_POST['csrf_token']) && CSRF::validateCSRFToken($_POST['csrf_token'], $this)) {
						$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);

						if(isset($_POST['g-recaptcha-response']) || $settings->RecaptchaEnabled == '0' || strtolower($settings->RecaptchaEnabled) == 'false') {
							$response = null;
							if($settings->RecaptchaEnabled == '1' || strtolower($settings->RecaptchaEnabled) == 'true') {
								$response = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $settings->RecaptchaPrivateKey . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . Common::getIp()));
							}

							if(($response != null && $response->success) || $settings->RecaptchaEnabled == '0' || strtolower($settings->RecaptchaEnabled) == 'false') {
								if(isset($_POST['ticket_add_title'], $_POST['ticket_add_text'])) {
									$view->postTitle = $_POST['ticket_add_title'];
									$view->postText = $_POST['ticket_add_text'];

									if(strlen($_POST['ticket_add_title']) >= 3) {
										if(strlen($_POST['ticket_add_title']) <= 150) {
											if(strlen($_POST['ticket_add_text']) >= 3) {
												if(strlen($_POST['ticket_add_text']) <= 500) {
													$ticketFactory = $this->getControllerParameters()->getModelsManager()->get(TicketFactory::class);
													$ticket = $ticketFactory->_create([
														'user_id' => $this->getUser()->getRow()->id,
														'timestamp' => time(),
														'title' => $_POST['ticket_add_title'],
														'text' => $_POST['ticket_add_text'],
														'status' => 'open'
													]);

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
													$message->setMessage(str_replace(['%username%', '%id%', '%subject%', '%message%'], [$this->getUser()->getRow()->username, $ticket->getRow()->id, $_POST['ticket_add_title'], $_POST['ticket_add_text']], $this->getLanguage()->json()['Account']['Tickets']['JabberMessageNew']));
														
													$message->setTo($settings->JabberIDNoReply);
													$client->send($message);
														
													$client->disconnect();
													
													GWORK::redirect('/account/tickets/' . $ticket->getRow()->id);
												} else {
													$view->errorMessage = $this->getLanguage()->json()['Account']['Tickets']['Add']['Errors']['TextLong'];
												}
											} else {
												$view->errorMessage = $this->getLanguage()->json()['Account']['Tickets']['Add']['Errors']['TextShort'];
											}
										} else {
											$view->errorMessage = $this->getLanguage()->json()['Account']['Tickets']['Add']['Errors']['TitleLong'];
										}
									} else {
										$view->errorMessage = $this->getLanguage()->json()['Account']['Tickets']['Add']['Errors']['TitleShort'];
									}
								}
							} else {
								$view->errorMessage = $this->getLanguage()->json()['Account']['Tickets']['Add']['Errors']['Captcha'];
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
			        new Route('/account/tickets/add', $this, 'account-tickets-add', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
