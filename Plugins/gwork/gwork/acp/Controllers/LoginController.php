<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
		use GWork\System\Common;
		use GWork\System\GWORK;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use GWork\System\Models\User\UserFactory;

		use Plugins\gwork\gwork\acp\Utils\CSRF\CSRF;

		use GWork\System\Redirects\PermissionRedirect;
		use GWork\System\Models\Settings\SettingsFactory;

		use Plugins\gwork\gwork\acp\Libraries\ReCaptchaNS;

	    final class LoginController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_ADMIN_PANEL', true);

				if($route->getName() == 'admin-login') {
					$view = ViewHelper::create($this, 'Login.php', 'loginView', ['pageName' => $this->getLanguage()->json()['Login']['PageName']], [], true);

					if(isset($_POST['csrf_token']) && CSRF::validateCSRFToken($_POST['csrf_token'], $this)) {
						if(isset($_POST['login_username'], $_POST['login_password'])) {
							$view->postUsername = $_POST['login_username'];

							$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);

							if(isset($_POST['g-recaptcha-response'])) {
								$response = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $settings->RecaptchaPrivateKey . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . Common::getIp()));

								if($response != null && $response->success) {
									$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);

									$user = $userFactory->getByColumn('username', $_POST['login_username']);
									if($user != null) {
										if($userFactory->passwordVerify($userFactory->getPasswordSalt($_POST['login_password']), $user->getRow()->password)) {
											if($user->hasPermissionByName('ACCESS_ADMIN_PANEL')) {
												CSRF::setCSRFToken($this);

												$this->setSession('USERID', (string) $user->getRow()->id);
												$this->setSession('PASSWORD', $userFactory->getPasswordSalt($_POST['login_password']));

												GWORK::redirect('/admin/dashboard');
											} else {
												$view->errorMessage = $this->getLanguage()->json()['Login']['Errors']['Permission'];
											}
										} else {
											$view->errorMessage = $this->getLanguage()->json()['Login']['Errors']['Credentials'];
										}
									} else {
										$view->errorMessage = $this->getLanguage()->json()['Login']['Errors']['Credentials'];
									}
								} else {
									$view->errorMessage = $this->getLanguage()->json()['Login']['Errors']['Captcha'];
								}
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
		            new Route('/admin/login', $this, 'admin-login', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
