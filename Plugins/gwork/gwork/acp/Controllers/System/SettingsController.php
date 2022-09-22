<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp\Controllers\System {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;

		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Redirects\PermissionRedirect;

		use GWork\System\Models\Settings\SettingsFactory;

		use GWork\System\Helpers\ViewHelper\ViewHelper;

	    final class SettingsController extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin/login', 'ACCESS_ADMIN_PANEL', false);
				$this->getRedirectsManager()->get(PermissionRedirect::class)->redirectByPermission('/admin', 'ACCESS_SETTINGS', false);

				if($route->getName() == 'admin-system-settings') {
					$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);

					$view = ViewHelper::create($this, 'System/Settings.php', 'systemView', ['pageName' => $this->getLanguage()->json()['System']['Settings']['PageName']], [], true);

					$success = false;
					$error = false;

					if(isset($_POST['settings_site_name'])) {
						if(strlen($_POST['settings_site_name']) > 0) {
							$settings->set('SiteName', $_POST['settings_site_name']);

							$success = true;
						} else {
							$error = true;
						}
					}

					if(isset($_POST['settings_infobox_title'])) {
						$settings->set('InfoBoxTitle', $_POST['settings_infobox_title']);

						$success = true;
					}

					if(isset($_POST['settings_infobox_text'])) {
						$settings->set('InfoBoxText', $_POST['settings_infobox_text']);

						$success = true;
					}

					if(isset($_POST['settings_currency'])) {
						if(strlen($_POST['settings_currency']) > 0) {
							$settings->set('Currency', $_POST['settings_currency']);

							$success = true;
						} else {
							$error = true;
						}
					}

					if(isset($_POST['settings_language'])) {
						if(strlen($_POST['settings_language']) > 0) {
							$settings->set('Language', $_POST['settings_language']);

							$success = true;
						} else {
							$error = true;
						}
					}

					if(isset($_POST['settings_btc_jrpc_password'])) {
						$settings->set('BitcoinPassword', $_POST['settings_btc_jrpc_password']);
						$success = true;
					}

					if(isset($_POST['settings_btc_jrpc_username'])) {
						$settings->set('BitcoinUsername', $_POST['settings_btc_jrpc_username']);
						$success = true;
					}

					if(isset($_POST['settings_btc_jrpc_port'])) {
						$settings->set('BitcoinPort', $_POST['settings_btc_jrpc_port']);
						$success = true;
					}

					if(isset($_POST['settings_btc_jrpc_host'])) {
						$settings->set('BitcoinHost', $_POST['settings_btc_jrpc_host']);
						$success = true;
					}

					if(isset($_POST['settings_recaptcha_site_key'])) {
						$settings->set('RecaptchaSiteKey', $_POST['settings_recaptcha_site_key']);
						$success = true;
					}

					if(isset($_POST['settings_recaptcha_private_key'])) {
						$settings->set('RecaptchaPrivateKey', $_POST['settings_recaptcha_private_key']);
						$success = true;
					}

					if(isset($_POST['settings_homepagenews'])) {
						$settings->set('HomepageNews', $_POST['settings_homepagenews'] == 1 ? 1 : 0);
						$success = true;
					}

					if(isset($_POST['settings_jabber_host'])) {
						$settings->set('JabberHost', $_POST['settings_jabber_host']);
						$success = true;
					}

					if(isset($_POST['settings_jabber_username'])) {
						$settings->set('JabberUsername', $_POST['settings_jabber_username']);
						$success = true;
					}

					if(isset($_POST['settings_jabber_password'])) {
						$settings->set('JabberPassword', $_POST['settings_jabber_password']);
						$success = true;
					}

					if(isset($_POST['settings_jabber_port'])) {
						$settings->set('JabberPort', $_POST['settings_jabber_port']);
						$success = true;
					}

					if(isset($_POST['settings_jabber_id'])) {
						$settings->set('JabberID', $_POST['settings_jabber_id']);
						$success = true;
					}

					if(isset($_POST['settings_recaptchaenabled'])) {
						$settings->set('RecaptchaEnabled', $_POST['settings_recaptchaenabled'] == 1 ? 1 : 0);
						$success = true;
					}

					if($error) {
						$view->errorMessage = $this->getLanguage()->json()['System']['Settings']['Error'];
					} else if($success) {
						$view->successMessage = $this->getLanguage()->json()['System']['Settings']['Success'];
					}

					$view->display();
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/admin/system/settings', $this, 'admin-system-settings', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
