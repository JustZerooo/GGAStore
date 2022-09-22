<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Templates {
	    use GWork\System\Patterns\MVC\Templates\Variables\TemplateVariableString;
	    use GWork\System\Patterns\MVC\Templates\Variables\TemplateVariableCallable;
	    use GWork\System\Patterns\MVC\Templates\Variables\NullViewVariable;
	    use GWork\System\Patterns\MVC\Templates\Variables\NullViewVariableCallback;

	    final class View {
	        private $vars = [];

			/**
			 * View constructor.
			 * @param 	Template 	$tpl
			 * @param 	bool		$display
			 * @return 	string|null
			 */
	        public function display(Template $tpl, bool $display = true) {
	            $tpl->setView($this);

				if($display) {
					$tpl->display($display);
				} else {
					return $tpl->display($display);
				}
	        }

			/**
			 * Sets a variable.
			 * @param string $var
			 * @param mixed $val
			 */
	        public function __set(string $var, $val) {
	            if(is_callable($val)) {
	                $this->vars[$var] = new TemplateVariableCallable($var, $val);
	            } else {
	                $this->vars[$var] = new TemplateVariableString($var, $val);
	            }
	        }

			/**
			 * Returns a variable.
			 * @param  string $var
			 * @return mixed
			 */
	        public function __get(string $var) {
	            foreach($this->vars as $_var) {
	                if($_var->getVariable() == $var) {
						return $_var;
	                }
	            }

	            return new NullViewVariable($var);
	        }

			/**
			 * Calls a variable if is callable.
			 * @param 	string 	$var
			 * @param  	array 	$arguments
			 * @return 	mixed
			 */
	        public function __call(string $var, array $arguments) {
	            $variable = $this->$var;

	            if($variable instanceof NullViewVariable) {
	                return new NullViewVariableCallback($var, $arguments);
	            } else if($variable instanceof TemplateVariableCallable) {
	                return $variable->call($arguments);
	            }
	        }
	    }
	}
