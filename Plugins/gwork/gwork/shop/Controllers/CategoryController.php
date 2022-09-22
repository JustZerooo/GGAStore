<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use Plugins\gwork\gwork\shop\Models\Category\CategoryFactory;

	    final class CategoryController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				
				if($route->getName() == 'category') {
					$categoryFactory = $this->getControllerParameters()->getModelsManager()->get(CategoryFactory::class);

					$category = $categoryFactory->getByColumn('id', $vars['id']);

					if($category == null) {
						GWORK::redirect('/');

						return;
					}

					$categoryName = str_replace('%category%', htmlspecialchars($category->getRow()->name), $this->getLanguage()->json()['Category']['PageName']);
					$view = ViewHelper::create($this, 'Category.php', 'categoryView', ['pageName' => $categoryName], [], true);

					$view->category = $category;

					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/category/{int:id}', $this, 'category', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
