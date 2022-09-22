<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Helpers\Redirects {
		use GWork\System\Patterns\MVC\Controllers\Controller;

		final class RedirectsManager {
	        private $cachedRedirects = [];
			private $controller;

			/**
			 * RedirectsManager constructor.
			 * @param Controller $controller
			 */
			public function __construct(Controller $controller) {
				$this->controller = $controller;
			}

			/**
			 * Returns the controller.
			 * @return Controller
			 */
			public function getController(): Controller {
				return $this->controller;
			}

			/**
			 * @param 	mixed $instance
			 * @return 	mixed
			 */
			public function get($instance) {
				if(isset($this->cachedRedirects[$instance])) {
	                return $this->cachedRedirects[$instance];
	            } else {
	                $redirect = new $instance($this->getController());

	                $this->cachedRedirects[$instance] = $redirect;

	                return $redirect;
	            }
 			}
	    }
	}
