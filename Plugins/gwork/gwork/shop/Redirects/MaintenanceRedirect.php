<?php
	/**
	 * @author gwork
	 */

	 namespace Plugins\gwork\gwork\shop\Redirects {
	    use GWork\System\Helpers\Redirects\Interfaces\IRedirect;

		use GWork\System\Patterns\MVC\Controllers\Controller;
		use GWork\System\GWORK;
		
		use GWork\System\Models\Settings\SettingsFactory;

	    final class MaintenanceRedirect implements IRedirect {
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
				$settings = $this->controller->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);
				
				if($settings->Maintenance == 1 || strtolower($settings->Maintenance) == 'true') {
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
