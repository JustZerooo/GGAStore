<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Utils\Routing\Managers {
	    use GWork\System\Utils\Routing\Collectors\RouteCollector;

	    final class RouteManager {
	        private $routeCollector;

			/**
			 * RouteManager constructor.
			 * @param RouteCollector $routeCollector
			 */
	        public function __construct(RouteCollector $routeCollector) {
	            $this->routeCollector = $routeCollector;
	        }

			/**
			 * Returns the route collector.
			 * @return RouteCollector
			 */
	        public function getCollector(): RouteCollector {
	            return $this->routeCollector;
	        }
	    }
	}
