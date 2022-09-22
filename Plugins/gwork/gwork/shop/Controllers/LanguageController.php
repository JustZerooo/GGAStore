<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
		use GWork\System\GWORK;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

	    final class LanguageController extends Controller implements IRoute {
			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				if($route->getName() == 'language') {
					if($this->getMultilingual()->exists($vars['language'])) {
						$this->setSession('LANGUAGE', $vars['language']);

						if($this->getUser() != null) {
							$this->getUser()->set('language', $vars['language']);
						}
					}
				}

				GWORK::redirect('/');
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/language/{string:language}', $this, 'language')
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
