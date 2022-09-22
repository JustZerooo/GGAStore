<?php
	/**
	 * @author gwork
	 */

	namespace Application\Controllers {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

	    final class ErrorController extends Controller implements IRoute {
			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				if($route->getName() == 'error') {
					$variables = [];

					$view = ViewHelper::create($this, 'Error.php', 'errorView', $variables);

					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
	                new Route('/error', $this, 'error')
	            ];
	        }
	    }
	
		return __NAMESPACE__;
	}
