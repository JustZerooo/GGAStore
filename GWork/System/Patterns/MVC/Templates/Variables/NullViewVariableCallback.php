<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Templates\Variables {
	    final class NullViewVariableCallback extends NullVariable {
	        private $var,
					$args;

			/**
			 * NullViewVariableCallback constructor.
			 * @param string 	$var
			 * @param array 	$args
			 */
	        public function __construct(string $var, array $args) {
	            $this->var = $var;
	            $this->args = $args;
	        }

			/**
			 * @return string
			 */
	        public function __toString(): string {
	            return '{$this->getView()->' . $this->var . '(' . implode(',', $this->args) . ')}';
	        }
	    }
	}
