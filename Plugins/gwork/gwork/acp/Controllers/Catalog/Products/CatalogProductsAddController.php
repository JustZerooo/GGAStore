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

	    final class CatalogProductsAddController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_CATALOG', false);

				if($route->getName() == 'admin-catalog-products-add') {
					$productFactory = $this->getControllerParameters()->getModelsManager()->get(ProductFactory::class);
					
					$view = ViewHelper::create($this, 'Catalog/Products/Add.php', 'catalogView', ['pageName' => $this->getLanguage()->json()['Catalog']['Products']['Add']['PageName']], [], true);

					if(isset($_POST['product_title'], $_POST['product_short_description'], $_POST['product_info_tag'], $_POST['product_description'], $_POST['product_price'])) {
						$view->postTitle = $_POST['product_title'];
						$view->postShortDescription = $_POST['product_short_description'];
						$view->postDescription = $_POST['product_description'];
						$view->postInfoTag = $_POST['product_info_tag'];
						$view->postPrice = intval($_POST['product_price']);
						$view->postUnlimited = isset($_POST['product_is_unlimited']) ? true : false;
						$view->postCategory = $_POST['product_category'] ?? 0;
						$view->postImage = $_POST['product_image'] ?? 0;
						
						if(strlen($_POST['product_title']) > 0 && strlen($_POST['product_short_description']) > 0 && strlen($_POST['product_description']) > 0) {
							$unlimited = 'false';
							
							if(isset($_POST['product_is_unlimited'])) {
								$unlimited = true;
							}
							
							$category = $_POST['product_category'] ?? 0;
							
							$image = '';
							if(isset($_POST['product_img_select']) && strlen($_POST['product_img_select']) > 3) {
								$image = $_POST['product_img_select'];
							}
							
							$product = $productFactory->_create([
								'title' => $_POST['product_title'],
								'short_description' => $_POST['product_short_description'],
								'description' => $_POST['product_description'],
								'info_tag' => $_POST['product_info_tag'],
								'price' => intval($_POST['product_price']),
								'unlimited' => $unlimited,
								'category_id' => $category,
								'image' => $image
							]);
							
							if(isset($_FILES['product_image']['tmp_name']) && file_exists($_FILES['product_image']['tmp_name']) && is_uploaded_file($_FILES['product_image']['tmp_name'])) {
								$imgInfo = getimagesize($_FILES['product_image']['tmp_name']);
								
								if($imgInfo !== false) {
									if($imgInfo[2] == IMAGETYPE_GIF || $imgInfo[2] == IMAGETYPE_JPEG || $imgInfo[2] == IMAGETYPE_PNG) {
										$paths = $this->getControllerParameters()->getApplication()->getConfiguration();
									
										$path = SYS_PATH . $paths->getUploadPaths()->products;

										@mkdir($path);

										$fileName = intval($product->getRow()->id) . '.png';
										if(move_uploaded_file($_FILES['product_image']['tmp_name'], $path . $fileName)) {
											$product->set('image', $fileName);
										}
									}
								}
							}
							
							GWORK::redirect('/admin/catalog/products');
						} else {
							$view->errorMessage = $this->getLanguage()->json()['Catalog']['Products']['Add']['Error'];
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
		            new Route('/admin/catalog/products/add', $this, 'admin-catalog-products-add', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
