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

		use \Plugins\gwork\gwork\shop\Models\Ticket\TicketFactory;
		use \Plugins\gwork\gwork\shop\Models\TicketAnswer\TicketAnswerFactory;

	    final class TicketsCompleteController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-users-tickets-complete') {
					$ticketFactory = $this->getControllerParameters()->getModelsManager()->get(TicketFactory::class);

					$ticket = $ticketFactory->getByColumn('id', $vars['id']);

					if($ticket == null) {
						GWORK::redirect('/admin/users/tickets');
						return;
					}

					$ticket->set('status', 'completed');

					GWORK::redirect('/admin/users/tickets/show/' . $ticket->getRow()->id);
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/users/tickets/complete/{int:id}', $this, 'admin-users-tickets-complete', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
