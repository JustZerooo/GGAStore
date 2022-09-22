<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Controllers {
		use GWork\System\Common;
		use GWork\System\Helpers\Templates\TplManager;
		use GWork\System\Helpers\Redirects\RedirectsManager;
		use GWork\System\Plugin\PluginInfo;

		use GWork\System\Configurations\Paths;

		use GWork\System\Helpers\Multilingual\Language;
		use GWork\System\Helpers\Multilingual\Multilingual;

		use GWork\System\Models\User\UserFactory;
		use GWork\System\Models\Settings\SettingsFactory;

	    abstract class Controller {
	        private $controllerParameters,
			 		$redirectsManager,
					$multilingual = null,
					$pluginInfo = null,
					$session = null;

			/**
			 * Controller constructor.
			 * @param ControllerParameters 	$controllerParameters
			 * @param array|null 			$pluginData
			 */
	        public function __construct(ControllerParameters $controllerParameters, array $pluginData = null) {
	            $this->controllerParameters = $controllerParameters;

				$this->redirectsManager = new RedirectsManager($this);

				if($pluginData != null) {
					$this->pluginInfo = new PluginInfo($pluginData);
				}

				$configuration = $controllerParameters->getApplication()->getConfiguration();
				$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);

				$countryAutoDetect = (strtolower($settings->CountryAutoDetect) == 'true' || $settings->CountryAutoDetect == '1');
				$this->multilingual = new Multilingual($this, new Paths($configuration->getPaths()), $settings->Language, $countryAutoDetect);

				$this->getControllerParameters()->getApplication()->getTplManager()->setDefault($settings->Template);
			}

			/**
			 * Returns the controller parameters.
			 * @return ControllerParameters
			 */
	        public function getControllerParameters(): ControllerParameters {
	            return $this->controllerParameters;
	        }

			/**
			 * Returns the redirects manager.
			 * @return RedirectsManager
			 */
			public function getRedirectsManager(): RedirectsManager {
				return $this->redirectsManager;
			}

			/**
			 * Returns the template manager.
			 * @return TplManager
			 */
			public function getTplManager(bool $refresh = false): TplManager {
				return $this->getControllerParameters()->getApplication()->getTplManager();
			}

			/**
			 * Removes a session.
			 * @param string $session
			 * @param mixed $content
			 */
			public function removeSession(string $session) {
				$name = $this->getControllerParameters()->getApplication()->getConfiguration()->getSessionPrefix() . $session;

				if(isset($_SESSION[$name])) {
					unset($_SESSION[$name]);
				}
			}

			/**
			 * Sets a session.
			 * @param string $session
			 * @param mixed $content
			 */
			public function setSession(string $session, $content) {
				$_SESSION[$this->getControllerParameters()->getApplication()->getConfiguration()->getSessionPrefix() . $session] = $content;
			}

			/**
			 * Returns a session value.
			 * @param  string $session
			 * @return mixed
			 */
			public function getSession(string $session) {
				if(isset($_SESSION[$this->getControllerParameters()->getApplication()->getConfiguration()->getSessionPrefix() . $session])) {
					return $_SESSION[$this->getControllerParameters()->getApplication()->getConfiguration()->getSessionPrefix() . $session];
				}

				return null;
			}

			/**
			 * Returns information about the plugin, if the controller is called from a plugin.
			 * @return PluginInfo
			 */
			public function getPluginInfo() {
				return $this->pluginInfo;
			}

			/**
			 * Returns the multilingual.
			 * @return Multilingual
			 */
			public function getMultilingual(): Multilingual {
				return $this->multilingual;
			}

			/**
			 * Returns the default language.
			 * @return Language
			 */
			public function getDefaultLanguage(): Language {
				$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);
				$language = $settings->Language;

				return $this->getMultilingual()->getLanguage($language);
			}

			/**
			 * Returns the language.
			 * @return Language
			 */
			public function getLanguage(): Language {
				$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);
				$language = $settings->Language;

				if($this->getUser() != null) {
					$language = $this->getUser()->getRow()->language ?? '';
				} else if($this->getSession('LANGUAGE') != null) {
					$language = $this->getSession('LANGUAGE');
				}

				return $this->getMultilingual()->getLanguage($language);
			}

			/**
			 * Returns the user object.
			 * @param	bool $refresh
			 * @return 	User|null
			 */
			public function getUser(bool $refresh = false) {
				if($this->getUserSession($refresh) != null) {
					if($this->getSession('USERID') != null && $this->getSession('PASSWORD') != null) {
						$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);

						if($userFactory->passwordVerify($this->getSession('PASSWORD'), $this->getUserSession($refresh)->getRow()->password)) {
							return $this->getUserSession($refresh);
						} else if($this->getSession('ADMIN_ACCESS') == 1 && $this->getSession('PASSWORD') == $this->getUserSession($refresh)->getRow()->password) {
							return $this->getUserSession($refresh);
						}
					}
				}

				return null;
			}

			/**
			 * Returns the user session.
			 * @param 	bool $refresh
			 * @return 	null|User
			 */
			public function getUserSession(bool $refresh = false) {
				if((gettype($this->session) != 'object' && $this->session == null) || $refresh) {
					if($this->getSession('USERID')) {
						$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);
						$user = $userFactory->getByColumn('id', $this->getSession('USERID'));

						if($user != null) {
							$this->session = $user;
						}
					} else {
						$this->session = null;
					}
				}

				return $this->session;
			}
	    }
	}