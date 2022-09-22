<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Utils\Routing\Interfaces {
	    use GWork\System\Utils\Routing\Route;

	    interface IRoute {
			/**
			 * On route calls.
			 * @param Route  $route
			 * @param array  $vars
			 */
	        public function onCall(Route $route, array $vars);

			/**
			 * Returns the routes.
			 * @return array
			 */
	        public function getRoutes();
	    }
	}
