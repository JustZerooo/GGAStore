<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers\Account {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
		use GWork\System\Common;
		use GWork\System\GWORK;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use GWork\System\Models\User\UserFactory;

		use Plugins\gwork\gwork\shop\Utils\CSRF\CSRF;

		use Plugins\gwork\gwork\shop\Redirects\UserNullRedirect;

	    final class AccountPasswordController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				$this->getRedirectsManager()->get(UserNullRedirect::class)->redirect('/login');

				if($route->getName() == 'account-settings-password') {
					$view = ViewHelper::create($this, 'Account/Settings.php', 'accountSettingsView', ['pageName' => $this->getLanguage()->json()['Account']['Settings']['PageName']], [], true);

					if(isset($_POST['csrf_token']) && CSRF::validateCSRFToken($_POST['csrf_token'], $this)) {
						if(isset($_POST['settings_password_old'])) {
							$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);

							if($userFactory->passwordVerify($userFactory->getPasswordSalt($_POST['settings_password_old']), $this->getUser()->getRow()->password)) {
								if(isset($_POST['settings_password_new'], $_POST['settings_password_new_confirm'])) {
									if(strlen($_POST['settings_password_new']) >= 6) {
										if($_POST['settings_password_new'] === $_POST['settings_password_new_confirm']) {
											$this->getUser()->set('password', $userFactory->getPasswordHash($userFactory->getPasswordSalt($_POST['settings_password_new_confirm'])));
											$this->setSession('PASSWORD', $userFactory->getPasswordSalt($_POST['settings_password_new_confirm']));

											$view->successPassword = $this->getLanguage()->json()['Account']['Settings']['Password']['Success'];
										} else {
											$view->errorPassword = $this->getLanguage()->json()['Account']['Settings']['Password']['Errors']['Confirmation'];
										}
									} else {
										$view->errorPassword = $this->getLanguage()->json()['Account']['Settings']['Password']['Errors']['Short'];
									}
								}
							} else {
								$view->errorPassword = $this->getLanguage()->json()['Account']['Settings']['Password']['Errors']['Invalid'];
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
			        new Route('/account/settings/password', $this, 'account-settings-password', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
