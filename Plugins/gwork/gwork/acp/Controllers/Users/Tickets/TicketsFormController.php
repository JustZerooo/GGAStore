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
		
		use Plugins\gwork\gwork\shop\Models\Ticket\TicketFactory;

	    final class TicketsFormController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-users-tickets-form') {
					if(isset($_POST['tickets']) && !empty($_POST['tickets'])) {
						if((isset($_POST['action']) && strtolower($_POST['action']) == 'delete') || (isset($_POST['action2']) && strtolower($_POST['action2']) == 'delete')) {
							$ticketFactory = $this->getControllerParameters()->getModelsManager()->get(TicketFactory::class);
							
							foreach($_POST['tickets'] as $ticketId) {
								$ticket = $ticketFactory->getByColumn('id', $ticketId);
								
								if($ticket != null) {
									$ticket->remove();
								}
							}
						}
					}
						
					GWORK::redirect('/admin/users/tickets');
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/users/tickets/form', $this, 'admin-users-tickets-form', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
