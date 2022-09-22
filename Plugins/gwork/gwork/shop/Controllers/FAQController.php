<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

	    final class FAQController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				
				if($route->getName() == 'faq') {
					$view = ViewHelper::create($this, 'FAQ.php', 'faqView', ['pageName' => $this->getLanguage()->json()['FAQ']['PageName']], [], true);

					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/faq', $this, 'faq', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
