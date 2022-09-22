<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers\Catalog\Categories {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	
		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use GWork\System\Redirects\PermissionRedirect;

	    final class CatalogCategoriesListController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_CATALOG', false);

				if($route->getName() == 'admin-catalog-categories-list') {
					$view = ViewHelper::create($this, 'Catalog/Categories/List.php', 'catalogView', ['pageName' => $this->getLanguage()->json()['Catalog']['Categories']['List']['PageName']], [], true);

					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/catalog/categories', $this, 'admin-catalog-categories-list', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
