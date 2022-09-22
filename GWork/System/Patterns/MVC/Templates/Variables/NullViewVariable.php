<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Templates\Variables {
	    final class NullViewVariable extends NullVariable {
	        private $var;

			/**
			 * NullViewVariable constructor.
			 * @param string $var
			 */
	        public function __construct(string $var) {
	            $this->var = $var;
	        }

			/**
			 * @return string
			 */
	        public function __toString(): string {
	            return '{$this->getView()->' . $this->var . '}';
	        }
	    }
	}
