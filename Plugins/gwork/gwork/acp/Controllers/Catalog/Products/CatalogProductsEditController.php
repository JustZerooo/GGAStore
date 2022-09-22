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

		use GWork\System\Helpers\ViewHelper\ViewHelper;

	    final class CatalogProductsEditController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_CATALOG', false);

				if($route->getName() == 'admin-catalog-products-edit') {
					$productFactory = $this->getControllerParameters()->getModelsManager()->get(ProductFactory::class);
					$product = $productFactory->getByColumn('id', $vars['id']);

					if($product == null) {
						GWORK::redirect('/admin/catalog/products');
					}

					$view = ViewHelper::create($this, 'Catalog/Products/Edit.php', 'catalogView', ['pageName' => $this->getLanguage()->json()['Catalog']['Products']['Edit']['PageName']], [], true);

					$view->product = $product;

					if(isset($_POST['product_title'], $_POST['product_short_description'], $_POST['product_description'], $_POST['product_info_tag'], $_POST['product_price'])) {
						if(strlen($_POST['product_title']) > 0 && strlen($_POST['product_short_description']) > 0 && strlen($_POST['product_description']) > 0) {
							$unlimited = 'false';
							
							if(isset($_POST['product_is_unlimited'])) {
								$unlimited = true;
							}
							
							$category = $_POST['product_category'] ?? 0;
							
							$product->set('title', $_POST['product_title']);
							$product->set('short_description', $_POST['product_short_description']);
							$product->set('description', $_POST['product_description']);
							$product->set('price', intval($_POST['product_price']));
							$product->set('unlimited', $unlimited);
							$product->set('category_id', $category);
							$product->set('info_tag', $_POST['product_info_tag']);
							
							if(isset($_POST['product_img_select']) && strlen($_POST['product_img_select']) > 3) {
								$product->set('image', $_POST['product_img_select']);
							}

							if(isset($_POST['product_unlimited_content'])) {
								$product->set('unlimited_content', $_POST['product_unlimited_content']);
							}

							if(file_exists($_FILES['product_image']['tmp_name'])) {
								$imgInfo = getimagesize($_FILES['product_image']['tmp_name']);

								if($imgInfo !== false) {
									if($imgInfo[2] == IMAGETYPE_GIF || $imgInfo[2] == IMAGETYPE_JPEG || $imgInfo[2] == IMAGETYPE_PNG) {
										$paths = $this->getControllerParameters()->getApplication()->getConfiguration();

										$path = SYS_PATH . $paths->getUploadPaths()->products;

										@mkdir($path);

										$fileName = intval($product->getRow()->id) . '_' . time() . '.png';
										if(move_uploaded_file($_FILES['product_image']['tmp_name'], $path . $fileName)) {
											$product->set('image', $fileName);
										}
									}
								}
							}

							$view->successMessage = $this->getLanguage()->json()['Catalog']['Products']['Edit']['Success'];
						} else {
							$view->errorMessage = $this->getLanguage()->json()['Catalog']['Products']['Edit']['Error'];
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
		            new Route('/admin/catalog/products/edit/{int:id}', $this, 'admin-catalog-products-edit', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
