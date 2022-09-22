<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers\Tutorials {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use Plugins\gwork\gwork\shop\Redirects\UserNullRedirect;

	    final class TutorialsController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				$this->getRedirectsManager()->get(UserNullRedirect::class)->redirect('/login');

				if($route->getName() == 'tutorials') {
					if($this->getUser()->getRow()->can_read_tutorials == 1) {
						$view = ViewHelper::create($this, 'Tutorials/Tutorials.php', 'tutorialsView', ['pageName' => $this->getLanguage()->json()['Tutorials']['PageName']], [], true);
					} else {
						$view = ViewHelper::create($this, 'Tutorials/Buy.php', 'tutorialsView', ['pageName' => $this->getLanguage()->json()['Tutorials']['PageName']], [], true);

						if(isset($_POST['buy_tutorials_rank'])) {
							if($this->getUser()->getRow()->balance >= 1000) {
								$this->getUser()->set('can_read_tutorials', 1);

								$balance = $this->getUser()->getRow()->balance - 1000;
								$this->getUser()->set('balance', $balance);

								GWORK::redirect('/tutorials');
							} else {
								$view->errorMessage = $this->getLanguage()->json()['Tutorials']['Error'];
							}
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
					new Route('/tutorials', $this, 'tutorials', true)
				];
	        }
	    }

		return __NAMESPACE__;
	}
