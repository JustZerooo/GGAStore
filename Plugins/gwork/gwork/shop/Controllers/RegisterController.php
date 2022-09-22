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
		use GWork\System\Models\Settings\SettingsFactory;

		use Plugins\gwork\gwork\shop\Utils\CSRF\CSRF;

		use Plugins\gwork\gwork\shop\Redirects\UserRedirect;

		use Plugins\gwork\gwork\shop\Libraries\ReCaptchaNS;

	    final class RegisterController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				$this->getRedirectsManager()->get(UserRedirect::class)->redirect('/');
				
				if($route->getName() == 'register') {
					$view = ViewHelper::create($this, 'Register.php', 'registerView', ['pageName' => $this->getLanguage()->json()['Register']['PageName']], [], true);

					if(isset($_POST['csrf_token']) &&  CSRF::validateCSRFToken($_POST['csrf_token'], $this)) {
						if(isset($_POST['register_username'], $_POST['register_mail'], $_POST['register_password'], $_POST['register_password_confirm'], $_POST['register_jabber'])) {
							$view->postUsername = $_POST['register_username'];
							$view->postMail = $_POST['register_mail'];
							$view->postJabber = $_POST['register_jabber'];

							$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);

							if(isset($_POST['g-recaptcha-response']) || $settings->RecaptchaEnabled == '0' || strtolower($settings->RecaptchaEnabled) == 'false') {
								$response = null;
								if($settings->RecaptchaEnabled == '1' || strtolower($settings->RecaptchaEnabled) == 'true') {
									$response = json_decode(file_get_contents('https://www.google.com/recaptcha/api/siteverify?secret=' . $settings->RecaptchaPrivateKey . '&response=' . $_POST['g-recaptcha-response'] . '&remoteip=' . Common::getIp()));
								}

								if(($response != null && $response->success) || $settings->RecaptchaEnabled == '0' || strtolower($settings->RecaptchaEnabled) == 'false') {
									$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);

									if(strlen($_POST['register_username']) >= 3) {
										if(strlen($_POST['register_username']) <= 20) {
											if(Common::isValidUsername($_POST['register_username'])) {
												if($userFactory->getByColumn('username', $_POST['register_username']) == null) {
													if(!empty($_POST['register_mail']) && Common::isValidMail($_POST['register_mail'])) {
														if($userFactory->getByColumn('mail', $_POST['register_mail']) == null) {
															if(strlen($_POST['register_password']) >= 6) {
																if($_POST['register_password'] === $_POST['register_password_confirm']) {
																	if(strlen($_POST['register_jabber']) > 0 && !Common::isValidMail($_POST['register_jabber'])) {
																		$error = true;
																		$view->errorMessage = $this->getLanguage()->json()['Register']['Errors']['JabberInvalid'];
																	}
																	
																	if(strlen($_POST['register_jabber']) > 0 && $userFactory->getByColumn('jabber', $_POST['register_jabber']) != null) {
																		$error = true;
																		$view->errorMessage = $this->getLanguage()->json()['Register']['Errors']['JabberExists'];
																	}

																	if(!$error) {
																		CSRF::setCSRFToken($this);

																		$user = $userFactory->_create([
																			'username' 				=> $_POST['register_username'],
																			'password' 				=> $userFactory->getPasswordHash($userFactory->getPasswordSalt($_POST['register_password_confirm'])),
																			'mail'					=> $_POST['register_mail'],
																			'account_created'		=> time(),
																			'balance'				=> 0,
																			'language'				=> '',
																			'can_redeem_coupons'	=> 1,
																			'can_read_tutorials'	=> 0,
																			'jabber'				=> $_POST['register_jabber']
																		]);
																		
																		if(isset($_POST['register_newsletter'])) {
																			$user->set('newsletter', 1);
																		}
							
																		$this->setSession('USERID', (string) $user->getRow()->id);
																		$this->setSession('PASSWORD', $userFactory->getPasswordSalt($_POST['register_password_confirm']));

																		GWORK::redirect('/');
																	}
																} else {
																	$view->errorMessage = $this->getLanguage()->json()['Register']['Errors']['PasswordRepeat'];
																}
															} else {
																$view->errorMessage = $this->getLanguage()->json()['Register']['Errors']['PasswordShort'];
															}
														} else {
															$view->errorMessage = $this->getLanguage()->json()['Register']['Errors']['AlreadyMail'];
														}
													} else {
														$view->errorMessage = $this->getLanguage()->json()['Register']['Errors']['MailInvalid'];
													}
												} else {
													$view->errorMessage = $this->getLanguage()->json()['Register']['Errors']['AlreadyUsername'];
												}
											} else {
												$view->errorMessage = $this->getLanguage()->json()['Register']['Errors']['UsernameInvalid'];
											}
										} else {
											$view->errorMessage = $this->getLanguage()->json()['Register']['Errors']['UsernameLong'];
										}
									} else {
										$view->errorMessage = $this->getLanguage()->json()['Register']['Errors']['UsernameShort'];
									}
								} else {
									$view->errorMessage = $this->getLanguage()->json()['Register']['Errors']['Captcha'];
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
		            new Route('/register', $this, 'register', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
