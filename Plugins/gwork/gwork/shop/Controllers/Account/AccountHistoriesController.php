<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers\Account {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use Plugins\gwork\gwork\shop\Redirects\UserNullRedirect;

	    final class AccountHistoriesController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				$this->getRedirectsManager()->get(UserNullRedirect::class)->redirect('/login');

				if($route->getName() == 'account-histories') {
					$view = ViewHelper::create($this, 'Account/Histories.php', 'accountHistoriesView', ['pageName' => $this->getLanguage()->json()['Account']['Histories']['PageName']], [], true);

					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/account/histories', $this, 'account-histories', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
