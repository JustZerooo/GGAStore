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

		use GWork\System\Helpers\OrderTypes\OrderTypes;

		use Plugins\gwork\gwork\shop\Models\Product\ProductFactory;
		use Plugins\gwork\gwork\shop\Models\ProductItem\ProductItemFactory;
		use Plugins\gwork\gwork\shop\Models\History\HistoryFactory;

		use Plugins\gwork\gwork\shop\Redirects\UserNullRedirect;

	    final class BuyController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				$this->getRedirectsManager()->get(UserNullRedirect::class)->redirect('/login');

				$productId = $_REQUEST['product_id'] ?? 0;
				$amount = $_REQUEST['product_amount'] ?? 0;
				$amount = intval($amount);

				$productFactory = $this->getControllerParameters()->getModelsManager()->get(ProductFactory::class);

				$product = $productFactory->getByColumn('id', $productId);

				if($product != null) {
					if(strtolower($product->getRow()->unlimited) == 'true') {
						$amount = 1;
					} else {
						$productItemFactory = $this->getControllerParameters()->getModelsManager()->get(ProductItemFactory::class);

						$productAvailability = $productItemFactory->getRowCountByColumn('product_id', $product->getRow()->id, 10);

						$amount = $amount > $productAvailability ? $productAvailability : $amount > 10 ? $productAvailability : $amount;
					}

					if($amount > 0) {
						if($route->getName() == 'buy') {
							$view = ViewHelper::create($this, 'Buy.php', 'buyView', ['pageName' => $this->getLanguage()->json()['Buy']['PageName']], [], true);

							$view->product = $product;
							$view->amount = $amount;

							$view->total = intval($product->getRow()->price * $amount);

							$view->display();
						} else if($route->getName() == 'buy-submit') {
							$total = intval($this->getUser()->getRow()->balance) - intval($product->getRow()->price * $amount);

							if($total >= 0) {
								$this->getUser()->set('balance', $total);

								if(strtolower($product->getRow()->unlimited) != 'true') {
									$productItems = $productItemFactory->getAllByColumn('product_id', $product->getRow()->id, false, $amount, '=', '', OrderTypes::RANDOM, false);
								}

								$historyFactory = $this->getControllerParameters()->getModelsManager()->get(HistoryFactory::class);

								if(strtolower($product->getRow()->unlimited) != 'true') {
									foreach($productItems as $productItem) {
										$historyFactory->_create([
											'user_id' 		=> $this->getUser()->getRow()->id,
											'content' 		=> $productItem->getRow()->content,
											'timestamp' 	=> time(),
											'product_id'	=> $product->getRow()->id,
											'status' 		=> 'completed'
										]);

										$productItem->remove();
									}
								} else {
									$historyFactory->_create([
										'user_id' 		=> $this->getUser()->getRow()->id,
										'content' 		=> $product->getRow()->unlimited_content,
										'timestamp' 	=> time(),
										'product_id'	=> $product->getRow()->id,
										'status' 		=> 'completed'
									]);
								}

								GWORK::redirect('/account/histories');
							} else {
								$view = ViewHelper::create($this, 'Buy.php', 'buyView', ['pageName' => $this->getLanguage()->json()['Buy']['PageName']], [], true);

								$view->product = $product;
								$view->amount = $amount;

								$view->total = intval($product->getRow()->price * $amount);

								$view->errorMessage = $this->getLanguage()->json()['Buy']['Errors']['Money'];

								$view->display();
							}
						}
					} else {
						GWORK::redirect('/');
					}
				} else {
					GWORK::redirect('/');
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/buy', $this, 'buy', true),
					new Route('/buy/submit', $this, 'buy-submit', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
