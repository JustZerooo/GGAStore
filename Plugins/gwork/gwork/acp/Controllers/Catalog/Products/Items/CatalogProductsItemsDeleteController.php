<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers\Catalog\Products\Items {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;
	
		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Redirects\PermissionRedirect;
		
		use Plugins\gwork\gwork\shop\Models\ProductItem\ProductItemFactory;

	    final class CatalogProductsItemsDeleteController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_CATALOG', false);

				if($route->getName() == 'admin-catalog-products-items-delete') {
					$productItemFactory = $this->getControllerParameters()->getModelsManager()->get(ProductItemFactory::class);
					$productItem = $productItemFactory->getByColumn('id', $vars['id']);
								
					$productId = $productItem->getRow()->product_id;
					
					if($productItem != null) {
						$productItem->remove();
					}
						
					GWORK::redirect('/admin/catalog/products/items/' . $productId);
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/catalog/products/items/delete/{int:id}', $this, 'admin-catalog-products-items-delete', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
