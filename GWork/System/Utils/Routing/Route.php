<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Utils\Routing {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;

	    final class Route {
	        private $url,
					$controller,
					$name,
					$override;

			/**
			 * Route constructor.
			 * @param string	$url
			 * @param IRoute 	$controller
			 * @param string 	$name
			 * @param bool	$override
			 */
	        public function __construct(string $url, IRoute $controller, string $name = '', bool $override = false) {
	            $this->url = $url;
	            $this->controller = $controller;
	            $this->name = $name;
				$this->override = $override;
	        }

			/**
			 * Checks if the route overrides an another route.
			 * @return bool
			 */
	        public function isOverride(): bool {
	            return $this->override;
	        }

			/**
			 * Returns the route url.
			 * @return string
			 */
	        public function getURL(): string {
	            return $this->url;
	        }

			/**
			 * Returns the route collector.
			 * @return IRoute
			 */
	        public function getController(): IRoute {
	            return $this->controller;
	        }

			/**
			 * Returns the route name.
			 * @return string
			 */
	        public function getName(): string {
	            return $this->name;
	        }
	    }
	}
