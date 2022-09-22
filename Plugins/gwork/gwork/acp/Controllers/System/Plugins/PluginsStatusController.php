<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers\System\Plugins {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;
	
		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Redirects\PermissionRedirect;
		
		use GWork\System\Models\Plugin\PluginFactory;

	    final class PluginsStatusController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				$pluginFactory = $this->getControllerParameters()->getModelsManager()->get(PluginFactory::class);
				
				$plugin = $pluginFactory->getByColumn('id', $vars['id']);
				if($plugin != null) {
					if($route->getName() == 'admin-system-plugins-disable') {
						$plugin->set('enabled', '0');
					} else if($route->getName() == 'admin-system-plugins-enable') {
						$plugin->set('enabled', '1');
					}
				}
				
				GWORK::redirect('/admin/system/plugins');
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/system/plugins/disable/{int:id}', $this, 'admin-system-plugins-disable', true),
		            new Route('/admin/system/plugins/enable/{int:id}', $this, 'admin-system-plugins-enable', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
