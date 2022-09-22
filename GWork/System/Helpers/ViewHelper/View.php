<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Helpers\ViewHelper {
		use GWork\System\Patterns\MVC\Controllers\Controller;
		use GWork\System\Patterns\MVC\Templates\Template;

	    final class View {
			private $controller, $tpl;

			/**
			 * ViewHelper constructor.
			 * @param Controller $controller
			 * @param Template   $tpl
			 */
			public function __construct(Controller $controller, Template $tpl) {
				$this->controller = $controller;
				$this->tpl = $tpl;
			}

			/**
			 * Returns the controller.
			 * @return Controller
			 */
			public function getController(): Controller {
				return $this->controller;
			}

			/**
			 * Returns the template.
			 * @return Template
			 */
			public function getTemplate(): Template {
				return $this->tpl;
			}

			/**
			 * Display the template.
			 * @param  bool $display
			 * @return string|null
			 */
			public function display($display = true) {
				if($display) {
					$this->getController()->getControllerParameters()->getView()->display($this->tpl);
				} else {
					return $this->getController()->getControllerParameters()->getView()->display($this->tpl, $display);
				}
			}

			/**
			 * Sets a template variable.
			 * @param string 	$key
			 * @param mixed 	$value
			 */
			public function __set(string $key, $value) {
				$this->tpl->{$key} = $value;
			}
	    }
	}
