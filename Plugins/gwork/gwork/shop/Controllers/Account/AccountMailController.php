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

	    final class AccountMailController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				$this->getRedirectsManager()->get(UserNullRedirect::class)->redirect('/login');

				if($route->getName() == 'account-settings-mail') {
					$view = ViewHelper::create($this, 'Account/Settings.php', 'accountSettingsView', ['pageName' => $this->getLanguage()->json()['Account']['Settings']['PageName']], [], true);

					if(isset($_POST['csrf_token']) && CSRF::validateCSRFToken($_POST['csrf_token'], $this)) {
						if(isset($_POST['settings_mail']) && $_POST['settings_mail'] != $this->getUser()->getRow()->mail) {
							$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);

							if(Common::isValidMail($_POST['settings_mail'])) {
								if($userFactory->getByColumn('mail', $_POST['settings_mail']) == null) {
									$this->getUser()->set('mail', $_POST['settings_mail']);
									
									$view->successMail = $this->getLanguage()->json()['Account']['Settings']['Mail']['Success'];
								} else {
									$view->errorMail = $this->getLanguage()->json()['Account']['Settings']['Mail']['Errors']['Already'];
								}
							} else {
								$view->errorMail = $this->getLanguage()->json()['Account']['Settings']['Mail']['Errors']['Invalid'];
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
			        new Route('/account/settings/mail', $this, 'account-settings-mail', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
