<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Templates\Variables {
	    final class NullTemplateVariable extends NullVariable {
	        private $var,
					$file;

			/**
			 * NullTemplateVariable constructor.
			 * @param string $var
			 * @param string $file
			 */
	        public function __construct(string $var, string $file) {
	            $this->var = $var;
	            $this->file = $file;
	        }

			/**
			 * @return string
			 */
	        public function __toString(): string {
	            return '{' . $this->file . '->$' . $this->var . '}';
	        }
	    }
	}
