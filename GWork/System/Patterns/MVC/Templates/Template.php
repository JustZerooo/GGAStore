<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Templates {

	    use GWork\System\Patterns\MVC\Templates\Managers\TemplateManager;
	    use GWork\System\Patterns\MVC\Templates\Variables\TemplateVariableString;
	    use GWork\System\Patterns\MVC\Templates\Variables\NullTemplateVariable;
	    use GWork\System\Patterns\MVC\Templates\Variables\TemplateVariableCallable;
	    use GWork\System\Patterns\MVC\Templates\Variables\NullTemplateVariableCallback;

	    final class Template {
	        private $file;
	        private $path;
	        private $vars = [];
	        private $templateManager;

	        private $view = null;

			/**
			 * Template constructor.
			 * @param string         	$path
			 * @param string         	$file
			 * @param TemplateManager 	$templateManager
			 */
	        public function __construct(string $path, string $file, TemplateManager $templateManager) {
	            $this->file = $file;
	            $this->path = $path;
	            $this->templateManager = $templateManager;
	        }

			/**
			 * Returns the full path of the template.
			 * @return string
			 */
	        public function getFullPath(): string {
	            return $this->path . '\\' . $this->file;
	        }

			/**
			 * Returns the template manager.
			 * @return TemplateManager
			 */
	        public function getTemplateManager(): TemplateManager {
	            return $this->templateManager;
	        }

			/**
			 * Sets the view.
			 * @param View $view
			 */
	        public function setView(View $view) {
	            $this->view = $view;
	        }

			/**
			 * Returns the view.
			 * @return View
			 */
	        public function getView(): View {
	            return $this->view;
	        }

			/**
			 * Sets the variable.
			 * @param string 	$var
			 * @param mixed 	$val
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

	            return new NullTemplateVariable($var, $this->file);
	        }

			/**
			 * Calls a variable if is callable.
			 * @param  string 	$var
			 * @param  array 	$arguments
			 * @return mixed
			 */
	        public function __call(string $var, array $arguments) {
	            $variable = $this->$var;

	            if($variable instanceof NullTemplateVariable) {
	                return new NullTemplateVariableCallback($var, $this->file, $arguments);
	            } else if($variable instanceof TemplateVariableCallable) {
	                return $variable->call($arguments);
	            }
	        }

			/**
			 * Displays the template.
			 * @param  bool $display
			 * @return string|null
			 */
	        public function display(bool $display = true) {
				if($display) {
					require $this->path . DIR_SPLITTER . $this->file;
				} else {
					return require $this->path . DIR_SPLITTER . $this->file;
				}
	        }
	    }
	}
