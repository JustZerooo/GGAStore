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

		use Plugins\gwork\gwork\shop\Models\Product\ProductFactory;

	    final class ProductController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				
				if($route->getName() == 'product') {
					$productFactory = $this->getControllerParameters()->getModelsManager()->get(ProductFactory::class);

					$product = $productFactory->getByColumn('id', $vars['id']);

					if($product == null) {
						GWORK::redirect('/');

						return;
					}

					$productName = str_replace('%product%', htmlspecialchars($product->getRow()->title), $this->getLanguage()->json()['Product']['PageName']);
					$view = ViewHelper::create($this, 'Product.php', 'productView', ['pageName' => $productName], [], true);

					$view->product = $product;

					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/product/{int:id}', $this, 'product', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
