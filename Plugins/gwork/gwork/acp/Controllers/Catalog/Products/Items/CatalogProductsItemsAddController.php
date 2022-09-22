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
		use Plugins\gwork\gwork\shop\Models\ProductItem\ProductItemFactory;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

	    final class CatalogProductsItemsAddController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_CATALOG', false);

				if($route->getName() == 'admin-catalog-products-items-add') {
					$productFactory = $this->getControllerParameters()->getModelsManager()->get(ProductFactory::class);
					$product = $productFactory->getByColumn('id', $vars['id']);

					if($product == null) {
						GWORK::redirect('/admin/catalog/products');
					}

					$productItemFactory = $this->getControllerParameters()->getModelsManager()->get(ProductItemFactory::class);

					$view = ViewHelper::create($this, 'Catalog/Products/Items/Add.php', 'catalogView', ['pageName' => $this->getLanguage()->json()['Catalog']['Products']['Items']['Add']['PageName']], [], true);

					$view->product = $product;

					if(isset($_POST['product_item_content'], $_POST['product_item_format'])) {
						$view->postContent = $_POST['product_item_content'];

						$format = $_POST['product_item_format'];
						if($format == 1) {
							if(strlen($_POST['product_item_content']) > 0) {
								$productItem = $productItemFactory->_create([
									'product_id' => $product->getRow()->id,
									'content' => $_POST['product_item_content']
								]);

								GWORK::redirect('/admin/catalog/products/items/' . $product->getRow()->id);
							} else {
								$view->errorMessage = $this->getLanguage()->json()['Catalog']['Products']['Add']['Error'];
							}
						} else if($format == 2 && isset($_POST['product_item_seperator'])) {
							if(strlen($_POST['product_item_content']) > 0) {
								$items = explode($_POST['product_item_seperator'], $_POST['product_item_content']);
								$items = array_filter($items, 'trim');

								foreach($items as $item) {
									$productItem = $productItemFactory->_create([
										'product_id' => $product->getRow()->id,
										'content' => $item
									]);
								}

								GWORK::redirect('/admin/catalog/products/items/' . $product->getRow()->id);
							} else {
								$view->errorMessage = $this->getLanguage()->json()['Catalog']['Products']['Add']['Error'];
							}
						} else if($format == 3) {
							if(strlen($_POST['product_item_content']) > 0) {
								$items = explode("\n", $_POST['product_item_content']);
								$items = array_filter($items, 'trim');

								foreach($items as $item) {
									$productItem = $productItemFactory->_create([
										'product_id' => $product->getRow()->id,
										'content' => $item
									]);
								}

								GWORK::redirect('/admin/catalog/products/items/' . $product->getRow()->id);
							} else {
								$view->errorMessage = $this->getLanguage()->json()['Catalog']['Products']['Add']['Error'];
							}
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
		            new Route('/admin/catalog/products/items/add/{int:id}', $this, 'admin-catalog-products-items-add', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
