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

		use Plugins\gwork\gwork\shop\Models\Product\ProductFactory;

	    final class SearchController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				
				if($route->getName() == 'search') {
					$productFactory = $this->getControllerParameters()->getModelsManager()->get(ProductFactory::class);

					$products = [];
					
					if(isset($_POST['search_input']) && !empty($_POST['search_input'])) {
						$products = $productFactory->getAllByLikeColumn('title', $_POST['search_input'], false, 25);
					}
					
					$view = ViewHelper::create($this, 'Search.php', 'searchView', ['pageName' => $this->getLanguage()->json()['Search']['PageName']], [], true);

					$view->products = $products;
					
					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/search', $this, 'search', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
