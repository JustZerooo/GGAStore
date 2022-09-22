<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Templates\Variables {
	    final class TemplateVariableCallable {
	        private $var,
					$callback;

			/**
			 * TemplateVariableCallable constructor.
			 * @param string 	$var
			 * @param callable 	$callback
			 */
	        public function __construct(string $var, callable $callback) {
	            $this->var = $var;
	            $this->callback = $callback;
	        }

			/**
			 * @return bool
			 */
			public function isNull(): bool {
				return false;
			}

			/**
			 * @return string
			 */
	        public function __toString(): string {
	            return (string) $this->callback;
	        }

			/**
			 * @return string
			 */
	        public function getValue(): string {
	            return $this->callback;
	        }

			/**
			 * @return string
			 */
	        public function getVariable(): string {
	            return $this->var;
	        }

			/**
			 * @param 	array $arguments
			 * @return 	mixed
			 */
	        public function call(array $arguments) {
	            return call_user_func_array($this->callback, $arguments);
	        }
	    }
	}
