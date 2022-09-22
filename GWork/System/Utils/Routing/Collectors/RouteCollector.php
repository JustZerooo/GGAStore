<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Utils\Routing\Collectors {
	    use GWork\System\Exceptions\GWorkException;
	    use GWork\System\Utils\Routing\Route;

	    final class RouteCollector {
	        private $routes = [];

	        /**
	         * Adds a route.
	         * @param Route $route
	         */
	        public function add(Route $route) {
	            if(!$this->exists($route)) {
	                $this->routes[] = $route;
	            } else if($route->isOverride()) {
					$this->replace($route);
				} else {
					throw new GWorkException(__DIR__ . '\RouteCollector.php', 16, 'Cannot add an already existing route.', $route);
	            }
	        }

	        /**
	         * Replaces a route.
	         * @param 	Route $route
	         * @return	bool
	         */
	        private function replace(Route $route): bool {
	            foreach($this->routes as $key => $_route) {
	                if($route === $_route || $route->getURL() == $_route->getURL()) {
	                    $this->routes[$key] = $route;

						return true;
	                }
	            }

	            return false;
	        }

	        /**
	         * Checks if a route is exists.
	         * @param 	Route $route
	         * @return	bool
	         */
	        private function exists(Route $route): bool {
	            foreach($this->routes as $_route) {
	                if($route === $_route || $route->getURL() == $_route->getURL()) {
	                    return true;
	                }
	            }

	            return false;
	        }

	        /**
	         * Returns all routes.
	         * @return array
	         */
	        public function getRoutes(): array {
	            return $this->routes;
	        }
	    }
	}
