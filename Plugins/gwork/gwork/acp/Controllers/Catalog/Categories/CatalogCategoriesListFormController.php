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

	    final class CatalogCategoriesListFormController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_CATALOG', false);

				if($route->getName() == 'admin-catalog-categories-list-form') {
					if(isset($_POST['categories']) && !empty($_POST['categories'])) {
						if((isset($_POST['action']) && strtolower($_POST['action']) == 'delete') || (isset($_POST['action2']) && strtolower($_POST['action2']) == 'delete')) {
							$categoryFactory = $this->getControllerParameters()->getModelsManager()->get(CategoryFactory::class);
							
							foreach($_POST['categories'] as $categoryId) {
								$category = $categoryFactory->getByColumn('id', $categoryId);
								
								if($category != null) {
									$category->remove();
								}
							}
						}
					}
						
					GWORK::redirect('/admin/catalog/categories');
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/catalog/categories/form', $this, 'admin-catalog-categories-list-form', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
