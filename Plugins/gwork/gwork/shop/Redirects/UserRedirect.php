<?php
	/**
	 * @author gwork
	 */

	 namespace Plugins\gwork\gwork\shop\Redirects {
	    use GWork\System\Helpers\Redirects\Interfaces\IRedirect;

		use GWork\System\Patterns\MVC\Controllers\Controller;
		use GWork\System\GWORK;

	    final class UserRedirect implements IRedirect {
			private $controller;

			/**
			 * @see GWork\System\Helpers\Redirects\Interfaces\IRedirect::__construct()
			 */
			public function __construct(Controller $controller) {
				$this->controller = $controller;
			}

			/**
			 * @see GWork\System\Helpers\Redirects\Interfaces\IRedirect::onCheck()
			 */
			public function onCheck(): bool {
				if($this->controller->getUser() != null) {
					return true;
				}

				return false;
	        }

			/**
			 * @see GWork\System\Helpers\Redirects\Interfaces\IRedirect::redirect()
			 */
			public function redirect(string $url) {
				if($this->onCheck()) {
					GWORK::redirect($url);
				}
			}
	    }
	}
