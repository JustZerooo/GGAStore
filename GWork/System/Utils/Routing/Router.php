<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Utils\Routing {

	    use GWork\System\Exceptions\GWorkException;
	    use GWork\System\Utils\Routing\Managers\RouteManager;
	    use GWork\System\Utils\Routing\Helpers\RouteHelper;
	    use GWork\System\Utils\Routing\RouteInfoResults;

	    final class Router {
	        private $routeManager;

			/**
			 * Router constructor.
			 * @param RouteManager $routeManager
			 */
	        public function __construct(RouteManager $routeManager) {
	            $this->routeManager = $routeManager;
	        }

	        /**
	         * @param string 	$route
	         * @param callable	$callback
	         */
	        public function listenOn(string $route, callable $callback) {
	            if(is_callable($callback)) {
	                $routerInfo = new RouterInfo();

	                foreach($this->routeManager->getCollector()->getRoutes() as $_route) {
	                    if($route == $_route->getURL()) {
	                        $routerInfo->setState(RouteInfoResults::ACCESS_ALLOWED);
	                        $routerInfo->setRoute($_route);

	                        return $this->prepareRoute($routerInfo, $callback);
	                    } else {
	                        $comparedUrl = RouteHelper::compareURLtoPattern($route, $_route->getURL());
	                        if($comparedUrl['matches'] == true) {
	                            foreach($comparedUrl['parameters'] as $param) {
	                                $routerInfo->setParameter($param['name'], $param['value']);
	                            }

	                            $routerInfo->setState(RouteInfoResults::ACCESS_ALLOWED);
	                            $routerInfo->setRoute($_route);

	                            return $this->PrepareRoute($routerInfo, $callback);
	                        }
	                    }
	                }

	                $routerInfo->setState(RouteInfoResults::NOT_FOUND);
	                return $this->prepareRoute($routerInfo, $callback);
	            } else {
	                throw new GWorkException(__DIR__ . '\Route.php', 27, '$callback has to be an instance of object, ' . gettype($callback) . ' given.');
	            }
	        }

			/**
			 * Returns the url parameter.
			 * @param 	string $key
			 * @return 	string
			 */
	        public function getUrlParameter(string $key): string {
	            return RouteHelper::getUrl($key);
	        }

			/**
			 * @param 	RouterInfo 	$routerInfo
			 * @param 	callable 	$callback
			 * @return 	callable
			 */
	        private function prepareRoute(RouterInfo $routerInfo, callable $callback) {
	            $routerResult = new RouterResult($routerInfo);
	            return $callback($routerResult);
	        }
	    }
	}
