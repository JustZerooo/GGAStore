<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;
		use GWork\System\Common;
		use GWork\System\GWORK;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

		use GWork\System\Models\User\UserFactory;

		use Plugins\gwork\gwork\shop\Utils\CSRF\CSRF;

		use Plugins\gwork\gwork\shop\Redirects\UserRedirect;
		use GWork\System\Models\Settings\SettingsFactory;

		use Plugins\gwork\gwork\shop\Libraries\ReCaptchaNS;

	    final class LoginController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				$this->getRedirectsManager()->get(UserRedirect::class)->redirect('/');

				if($route->getName() == 'login') {
					$view = ViewHelper::create($this, 'Login.php', 'loginView', ['pageName' => $this->getLanguage()->json()['Login']['PageName']], [], true);

					if(isset($_POST['csrf_token']) && CSRF::validateCSRFToken($_POST['csrf_token'], $this)) {
						if(isset($_POST['login_username'], $_POST['login_password'])) {
							$view->postUsername = $_POST['login_username'];

							$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);

							if(isset($_POST['g-recaptcha-response']) || $settings->RecaptchaEnabled == '0' || strtolower($settings->RecaptchaEnabled) == 'false') {
								$response = null;
								if($settings->RecaptchaEnabled == '1' || strtolower($settings->RecaptchaEnabled) == 'true') {
									$response = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $settings->RecaptchaPrivateKey . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . Common::getIp()));
								}

								if(($response != null && $response->success) || $settings->RecaptchaEnabled == '0' || strtolower($settings->RecaptchaEnabled) == 'false') {
									$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);

									$user = $userFactory->getByColumn('username', $_POST['login_username']);
									if($user != null) {
										if($userFactory->passwordVerify($userFactory->getPasswordSalt($_POST['login_password']), $user->getRow()->password)) {
											CSRF::setCSRFToken($this);

											$this->setSession('USERID', (string) $user->getRow()->id);
											$this->setSession('PASSWORD', $userFactory->getPasswordSalt($_POST['login_password']));

											GWORK::redirect('/');
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
		            new Route('/login', $this, 'login', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
