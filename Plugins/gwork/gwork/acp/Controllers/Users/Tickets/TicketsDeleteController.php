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

	    final class TicketsDeleteController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-users-tickets-delete') {
					$ticketFactory = $this->getControllerParameters()->getModelsManager()->get(TicketFactory::class);
					$ticket = $ticketFactory->getByColumn('id', $vars['id']);
								
					if($ticket != null) {
						$ticket->remove();
					}
						
					GWORK::redirect('/admin/users/tickets');
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/users/tickets/delete/{int:id}', $this, 'admin-users-tickets-delete', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
