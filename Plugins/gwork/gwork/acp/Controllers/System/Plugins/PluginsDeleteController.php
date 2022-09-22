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

	    final class PluginsDeleteController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-system-plugins-delete') {
					$pluginFactory = $this->getControllerParameters()->getModelsManager()->get(PluginFactory::class);
					$plugin = $pluginFactory->getByColumn('id', $vars['id']);
								
					if($plugin != null) {
						$plugin->remove();
					}
						
					GWORK::redirect('/admin/system/plugins');
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/system/plugins/delete/{int:id}', $this, 'admin-system-plugins-delete', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
