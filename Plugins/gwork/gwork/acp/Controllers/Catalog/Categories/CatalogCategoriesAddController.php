<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers\Catalog\Categories {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;
	
		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Redirects\PermissionRedirect;
		
		use Plugins\gwork\gwork\shop\Models\Category\CategoryFactory;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

	    final class CatalogCategoriesAddController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_CATALOG', false);

				if($route->getName() == 'admin-catalog-categories-add') {
					$categoryFactory = $this->getControllerParameters()->getModelsManager()->get(CategoryFactory::class);
					
					$view = ViewHelper::create($this, 'Catalog/Categories/Add.php', 'catalogView', ['pageName' => $this->getLanguage()->json()['Catalog']['Categories']['Add']['PageName']], [], true);

					if(isset($_POST['category_name'], $_POST['category_order'])) {
						$view->postName = $_POST['category_name'];
						
						if(strlen($_POST['category_name']) > 0) {
							$categoryFactory->_create([
								'name' => $_POST['category_name'],
								'order' => intval($_POST['category_order'])
							]);
							
							GWORK::redirect('/admin/catalog/categories');
						} else {
							$view->errorMessage = $this->getLanguage()->json()['Catalog']['Categories']['Add']['Error'];
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
		            new Route('/admin/catalog/categories/add', $this, 'admin-catalog-categories-add', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
