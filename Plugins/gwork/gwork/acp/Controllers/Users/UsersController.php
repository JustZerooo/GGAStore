<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers\Users {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
	    use GWork\System\GWORK;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Redirects\PermissionRedirect;

		use GWork\System\Models\User\UserFactory;
		use GWork\System\Helpers\ViewHelper\ViewHelper;

	    final class UsersController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);

				if($route->getName() == 'admin-users') {
					$view = ViewHelper::create($this, 'Users/Users.php', 'usersView', ['pageName' => $this->getLanguage()->json()['Users']['Users']['PageName']], [], true);

					if(isset($_POST['user_search'])) {
						$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);
						
						$user = $userFactory->getByColumn('username', $_POST['user_search']) ?? $userFactory->getByColumn('jabber', $_POST['user_search']);
						if($user != null) {
							GWORK::redirect('/admin/users/' . $user->getRow()->id);
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
		            new Route('/admin/users', $this, 'admin-users', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
