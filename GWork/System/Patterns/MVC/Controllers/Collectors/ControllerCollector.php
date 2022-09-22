<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Controllers\Collectors {
	    use GWork\System\Patterns\MVC\Controllers\Controller;

	    final class ControllerCollector {
	        private $controllers = [];

			/**
			 * Adds a collector.
			 * @param Controller $controller
			 */
	        public function add($controller) {
	            $this->controllers[] = $controller;
	        }

			/**
			 * Returns the controllers.
			 * @return array
			 */
	        public function getAll(): array {
	            return $this->controllers;
	        }

			/**
			 * @param	mixed $instance
			 * @return	array
			 */
	        public function getByInstance($instance):array {
	            $result = [];

	            foreach($this->controllers as $controller) {
	                if($controller instanceof $instance) {
	                    $result[] = $controller;
	                }
	            }

	            return $result;
	        }
	    }
	}
