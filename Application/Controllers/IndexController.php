<?php
	/**
	 * @author gwork
	 */

	namespace Application\Controllers {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

	    final class IndexController extends Controller implements IRoute {
			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				if($route->getName() == 'index') {
					$variables = [];

					$view = ViewHelper::create($this, 'Index.php', 'indexView', $variables);

					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
	                new Route('/', $this, 'index'),
					new Route('/index', $this, 'index')
	            ];
	        }
	    }
	
		return __NAMESPACE__;
	}
