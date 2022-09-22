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

	    final class PluginsListFormController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-system-plugins-form') {
					if(isset($_POST['plugins']) && !empty($_POST['plugins'])) {
						$pluginFactory = $this->getControllerParameters()->getModelsManager()->get(PluginFactory::class);
						
						if(isset($_POST['action'])) {
							foreach($_POST['plugins'] as $pluginId) {
								$plugin = $pluginFactory->getByColumn('id', $pluginId);
								
								if($plugin != null) {
									if(strtolower($_POST['action']) == 'delete') {
										$plugin->remove();
									} else if(strtolower($_POST['action']) == 'disable') {
										$plugin->set('enabled', '0');
									} else if(strtolower($_POST['action']) == 'enable') {
										$plugin->set('enabled', '1');
									}
								}
							}
						}
					}
						
					GWORK::redirect('/admin/system/plugins');
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/system/plugins/form', $this, 'admin-system-plugins-form', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
