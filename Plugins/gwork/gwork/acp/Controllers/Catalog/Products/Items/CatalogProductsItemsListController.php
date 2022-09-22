<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers\Catalog\Products\Items {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;
	
		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use GWork\System\Redirects\PermissionRedirect;
		
		use Plugins\gwork\gwork\shop\Models\Product\ProductFactory;

	    final class CatalogProductsItemsListController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_CATALOG', false);

				if($route->getName() == 'admin-catalog-products-items-list') {
					$productFactory = $this->getControllerParameters()->getModelsManager()->get(ProductFactory::class);
					$product = $productFactory->getByColumn('id', $vars['id']);
								
					if($product == null) {
						GWORK::redirect('/admin/catalog/products');
					}
					
					$view = ViewHelper::create($this, 'Catalog/Products/Items/List.php', 'catalogView', [
						'pageName' => str_replace('%productName%', htmlspecialchars($product->getRow()->title), $this->getLanguage()->json()['Catalog']['Products']['Items']['List']['PageName'])
					], [], true);

					$view->product = $product;
					
					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/catalog/products/items/{int:id}', $this, 'admin-catalog-products-items-list', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
