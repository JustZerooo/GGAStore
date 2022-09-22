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

	    final class CatalogCategoriesEditController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_CATALOG', false);

				if($route->getName() == 'admin-catalog-categories-edit') {
					$categoryFactory = $this->getControllerParameters()->getModelsManager()->get(CategoryFactory::class);
					$category = $categoryFactory->getByColumn('id', $vars['id']);
								
					if($category == null) {
						GWORK::redirect('/admin/catalog/categories');
					}
					
					$view = ViewHelper::create($this, 'Catalog/Categories/Edit.php', 'catalogView', ['pageName' => $this->getLanguage()->json()['Catalog']['Categories']['Edit']['PageName']], [], true);

					$view->category = $category;
					
					if(isset($_POST['category_name'], $_POST['category_order'])) {
						if(strlen($_POST['category_name']) > 0) {
							$category->set('name', $_POST['category_name']);
							$category->set('order', intval($_POST['category_order']));
							$view->successMessage = $this->getLanguage()->json()['Catalog']['Categories']['Edit']['Success'];
						} else {
							$view->errorMessage = $this->getLanguage()->json()['Catalog']['Categories']['Edit']['Error'];
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
		            new Route('/admin/catalog/categories/edit/{int:id}', $this, 'admin-catalog-categories-edit', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
