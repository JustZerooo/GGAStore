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

	    final class UsersIDLoginController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_USER_LOGIN', false);

				if($route->getName() == 'admin-users-login') {
					$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);
					
					$user = $userFactory->getByColumn('id', $vars['id']);
					
					if($user == null) {
						return GWORK::redirect('/admin/users/' . $user->getRow()->id);
					}
					
					$this->setSession('USERID', (string) $user->getRow()->id);
					$this->setSession('PASSWORD', $user->getRow()->password);
					$this->setSession('ADMIN_ACCESS', 1);

					GWORK::redirect('/');
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/users/{int:id}/login', $this, 'admin-users-login', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
