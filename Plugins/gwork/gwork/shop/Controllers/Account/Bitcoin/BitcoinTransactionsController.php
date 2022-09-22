<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers\Account\Bitcoin {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use Plugins\gwork\gwork\shop\Redirects\UserNullRedirect;

	    final class BitcoinTransactionsController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				$this->getRedirectsManager()->get(UserNullRedirect::class)->redirect('/login');

				if($route->getName() == 'account-btc-transactions') {
					$view = ViewHelper::create($this, 'Account/Bitcoin/Transactions.php', 'accountBitcoinTransactionsView', ['pageName' => $this->getLanguage()->json()['Account']['BTC']['Transactions']['PageName']], [], true);

					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/account/btc/transactions', $this, 'account-btc-transactions', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
