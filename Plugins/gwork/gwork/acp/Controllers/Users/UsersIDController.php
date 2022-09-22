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

	    final class UsersIDController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_EDIT_USER', false);

				if($route->getName() == 'admin-users-id') {
					$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);
					
					$user = $userFactory->getByColumn('id', $vars['id']);
					
					if($user == null) {
						return GWORK::redirect('/admin/users/' . $user->getRow()->id);
					}
					
					$view = ViewHelper::create($this, 'Users/User.php', 'usersView', ['pageName' => htmlspecialchars($user->getRow()->username)], [], true);
					
					if(isset($_POST['user_new_password']) && strlen($_POST['user_new_password']) >= 6) {
						$pw = $userFactory->getPasswordHash($userFactory->getPasswordSalt($_POST['user_new_password']));
						
						$user->set('password', $pw);
					}
					
					if(isset($_POST['user_submit'])) {
						if(isset($_POST['user_jabber'])) {
							$user->set('jabber', $_POST['user_jabber']);
						}
						
						if(isset($_POST['user_balance'])) {
							$user->set('balance', $_POST['user_balance']);
						}
						
						if(isset($_POST['user_can_redeem_coupons'])) {
							$user->set('can_redeem_coupons', 1);
						} else {
							$user->set('can_redeem_coupons', 0);
						}
						
						if(isset($_POST['user_can_read_tutorials'])) {
							$user->set('can_read_tutorials', 1);
						} else {
							$user->set('can_read_tutorials', 0);
						}
					}
					
					$view->user = $user;
					
					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/users/{int:id}', $this, 'admin-users-id', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
