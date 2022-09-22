<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Utils\Routing {
	    final class RouterInfo {
	        private $route;
	        private $state;

	        private $parameters = [];

			/**
			 * Sets the state.
			 * @param int $state
			 */
	        public function setState(int $state) {
	            $this->state = $state;
	        }

			/**
			 * Sets the route.
			 * @param Route $route
			 */
	        public function setRoute(Route $route) {
	            $this->route = $route;
	        }

			/**
			 * Sets the parameter.
			 * @param string $key
			 * @param string $val
			 */
	        public function setParameter(string $key, $val) {
	            $this->parameters[$key] = $val;
	        }

			/**
			 * Returns the parameters.
			 * @return array
			 */
	        public function getParameters(): array {
	            return $this->parameters;
	        }

			/**
			 * Returns the route.
			 * @return Route
			 */
	        public function getRoute(): Route {
	            return $this->route;
	        }

			/**
			 * Returns the state.
			 * @return int
			 */
	        public function getState(): int {
	            return $this->state;
	        }
	    }
	}
