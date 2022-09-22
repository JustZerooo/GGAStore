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

	    final class AccountNewsletterController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(\Plugins\gwork\gwork\shop\Redirects\MaintenanceRedirect::class)->redirect('/maintenance');
				$this->getRedirectsManager()->get(UserNullRedirect::class)->redirect('/login');

				if($route->getName() == 'account-settings-newsletter') {
					$view = ViewHelper::create($this, 'Account/Settings.php', 'accountSettingsView', ['pageName' => $this->getLanguage()->json()['Account']['Settings']['PageName']], [], true);

					if(isset($_POST['csrf_token']) && CSRF::validateCSRFToken($_POST['csrf_token'], $this)) {
						if(isset($_POST['settings_jabber'])) {
							$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);

							if(Common::isValidMail($_POST['settings_jabber'])) {
								if($userFactory->getByColumn('jabber', $_POST['settings_jabber']) == null || strtolower($this->getUser()->getRow()->jabber) == strtolower($_POST['settings_jabber'])) {
									$this->getUser()->set('jabber', $_POST['settings_jabber']);
									
									if(isset($_POST['settings_newsletter'])) {
										$this->getUser()->set('newsletter', 1);
									} else {
										$this->getUser()->set('newsletter', 0);
									}
									
									$view->successNewsletter = $this->getLanguage()->json()['Account']['Settings']['Newsletter']['Success'];
								} else {
									$view->errorNewsletter = $this->getLanguage()->json()['Account']['Settings']['Newsletter']['Errors']['Already'];
								}
							} else {
								$view->errorNewsletter = $this->getLanguage()->json()['Account']['Settings']['Newsletter']['Errors']['Invalid'];
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
			        new Route('/account/settings/newsletter', $this, 'account-settings-newsletter', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
