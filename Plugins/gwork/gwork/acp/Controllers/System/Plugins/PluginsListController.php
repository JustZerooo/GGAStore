<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\System\Controllers\Plugins {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	
		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Redirects\PermissionRedirect;
		
		use GWork\System\Helpers\ViewHelper\ViewHelper;

	    final class PluginsListController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-system-plugins') {
					$view = ViewHelper::create($this, 'System/Plugins/List.php', 'systemView', ['pageName' => $this->getLanguage()->json()['System']['Plugins']['List']['PageName']], [], true);
					
					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/system/plugins', $this, 'admin-system-plugins', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
