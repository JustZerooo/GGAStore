<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use GWork\System\Models\Settings\SettingsFactory;

	    final class IndexController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				
				if($route->getName() == 'index') {
					$view = ViewHelper::create($this, 'Index.php', 'indexView', ['pageName' => $this->getLanguage()->json()['Index']['PageName']], [], true);

					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
				$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);

				$routes = [
					new Route('/index', $this, 'index', true)
				];

				if(strtolower($settings->HomepageNews) != 'true' && (int) $settings->HomepageNews != 1) {
					$routes[] = new Route('/', $this, 'index', true);
				}

	            return $routes;
	        }
	    }

		return __NAMESPACE__;
	}
