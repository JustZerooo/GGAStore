<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers\Catalog\Products {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;
	
		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Redirects\PermissionRedirect;
		
		use Plugins\gwork\gwork\shop\Models\Product\ProductFactory;

	    final class CatalogProductsListFormController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_CATALOG', false);

				if($route->getName() == 'admin-catalog-products-list-form') {
					if(isset($_POST['products']) && !empty($_POST['products'])) {
						if((isset($_POST['action']) && strtolower($_POST['action']) == 'delete') || (isset($_POST['action2']) && strtolower($_POST['action2']) == 'delete')) {
							$productFactory = $this->getControllerParameters()->getModelsManager()->get(ProductFactory::class);
							
							foreach($_POST['products'] as $productId) {
								$product = $productFactory->getByColumn('id', $productId);
								
								if($product != null) {
									$product->remove();
								}
							}
						}
					}
						
					GWORK::redirect('/admin/catalog/products');
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/catalog/products/form', $this, 'admin-catalog-products-list-form', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
