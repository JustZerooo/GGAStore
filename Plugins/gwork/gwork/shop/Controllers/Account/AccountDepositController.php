<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers\Account {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use Plugins\gwork\gwork\shop\Redirects\UserNullRedirect;

	    final class AccountDepositController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				$this->getRedirectsManager()->get(UserNullRedirect::class)->redirect('/login');

				if($route->getName() == 'account-deposit') {
					$view = ViewHelper::create($this, 'Account/Deposit.php', 'accountDepositView', ['pageName' => $this->getLanguage()->json()['Account']['Deposit']['PageName']], [], true);

					$view->display();
				} else if($route->getName() == 'account-deposit-btc') {
					$view = ViewHelper::create($this, 'Account/Deposit.php', 'accountDepositView', ['pageName' => $this->getLanguage()->json()['Account']['Deposit']['PageName']], [], true);

					$view->hideButton = true;
					
					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/account/deposit', $this, 'account-deposit', true),
		            new Route('/account/deposit/btc', $this, 'account-deposit-btc', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
