<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Templates\Variables {
	    final class NullTemplateVariableCallback extends NullVariable {
	        private $var,
					$file,
					$arguments;

			/**
			 * NullTemplateVariableCallback constructor.
			 * @param string 	$var
			 * @param string 	$file
			 * @param array 	$arguments
			 */
	        public function __construct(string $var, string $file, array $arguments) {
	            $this->var = $var;
	            $this->file = $file;
	            $this->arguments = $arguments;
	        }

			/**
			 * @return string
			 */
	        public function __toString(): string {
	            return '{' . $this->file . '->' . $this->var . '(' . implode(',', $this->arguments) . ')}';
	        }
	    }
	}
