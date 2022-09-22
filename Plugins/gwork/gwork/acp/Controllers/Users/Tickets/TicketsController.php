<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers\Users\Tickets {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Redirects\PermissionRedirect;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

	    final class TicketsController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-users-tickets') {
					$view = ViewHelper::create($this, 'Users/Tickets/Tickets.php', 'usersView', ['pageName' => $this->getLanguage()->json()['Users']['Tickets']['PageName']], [], true);

					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/users/tickets', $this, 'admin-users-tickets', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
