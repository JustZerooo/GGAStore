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
		
		use Plugins\gwork\gwork\shop\Models\ProductItem\ProductItemFactory;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

	    final class CatalogProductsItemsEditController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_CATALOG', false);

				if($route->getName() == 'admin-catalog-products-items-edit') {
					$productItemFactory = $this->getControllerParameters()->getModelsManager()->get(ProductItemFactory::class);
					$productItem = $productItemFactory->getByColumn('id', $vars['id']);
								
					if($productItem == null) {
						GWORK::redirect('/admin/catalog/products');
					}
					
					$view = ViewHelper::create($this, 'Catalog/Products/Items/Edit.php', 'catalogView', ['pageName' => $this->getLanguage()->json()['Catalog']['Products']['Items']['Edit']['PageName']], [], true);

					$view->productItem = $productItem;
					
					if(isset($_POST['product_item_content'])) {
						if(strlen($_POST['product_item_content']) > 0) {
							$productItem->set('content', $_POST['product_item_content']);
							
							$view->successMessage = $this->getLanguage()->json()['Catalog']['Products']['Items']['Edit']['Success'];
						} else {
							$view->errorMessage = $this->getLanguage()->json()['Catalog']['Products']['Items']['Edit']['Error'];
						}
					}
					
					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/catalog/products/items/edit/{int:id}', $this, 'admin-catalog-products-items-edit', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
