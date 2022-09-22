<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Utils\Routing {
	    final class RouterResult {
	        private $routerInfo;

			/**
			 * RouterResult constructor.
			 * @param RouterInfo $info
			 */
	        public function __construct(RouterInfo $info) {
	            $this->routerInfo = $info;
	        }

			/**
			 * Returns the route.
			 * @return Route
			 */
	        public function getRoute(): Route {
	            return $this->routerInfo->getRoute();
	        }

			/**
			 * Returns the state.
			 * @return int
			 */
	        public function getState(): int {
	            return $this->routerInfo->getState();
	        }

			/**
			 * Calls the controller.
			 * @return mixed
			 */
	        public function callController() {
	            return $this->routerInfo->getRoute()->getController()->onCall($this->routerInfo->getRoute(), $this->routerInfo->getParameters());
	        }
	    }
	}
