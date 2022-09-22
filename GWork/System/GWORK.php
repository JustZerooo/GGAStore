<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System {
		use GWork\System\Patterns\MVC\Controllers\ControllerParameters;
		use GWork\System\Plugin\PluginManager;

		use GWork\System\Configurations\Paths;

		use GWork\System\Configuration;
		use GWork\System\Models\Settings\SettingsFactory;

		final class GWORK {
			private static 	$controllerParameters,
							$plugins = [],
							$pluginManager,
							$configuration,
							$settings,
							$version = 'UNKNOWN';

			/**
			 * Redirects the user to an url.
			 * @param string $url
			 */
		   	public static function redirect(string $url) {
				header('Location: ' . SITE_PATH . $url);
				exit;
		   	}

			/**
			 * Sets the configuration.
			 * @param Configuration $configuration
			 */
			public static function setConfiguration(Configuration $configuration) {
				self::$configuration = $configuration;
			}

			/**
			 * Returns the configuration.
			 * @return Configuration
			 */
			public static function getConfiguration(): Configuration {
				return self::$configuration;
			}

			/**
			 * Sets the settings.
			 * @param SettingsFactory $settings
			 */
			public static function setSettings(SettingsFactory $settings) {
				self::$settings = $settings;
			}

			/**
			 * Returns the settings.
			 * @return SettingsFactory
			 */
			public static function getSettings(): SettingsFactory {
				return self::$settings;
			}

			/**
			 * Sets the plugin manager.
			 * @param PluginManager $pluginManager
			 */
			public static function setPluginManager(PluginManager $pluginManager) {
				self::$pluginManager = $pluginManager;
			}

			/**
			 * Returns the plugin manager.
			 * @return PluginManager
			 */
			public static function getPluginManager(): PluginManager {
				return self::$pluginManager;
			}

			/**
			 * Sets the controller parameters.
			 * @param ControllerParameters $controllerParameters
			 */
			public static function setControllerParameters(ControllerParameters $controllerParameters) {
				self::$controllerParameters = $controllerParameters;
			}

			/**
			 * Returns the controller parameters.
			 * @return ControllerParameters
			 */
			public static function getControllerParameters(): ControllerParameters {
				return self::$controllerParameters;
			}

			/**
			 * Sets a plugin data.
			 * @param string 	$package
			 * @param array		$pluginData
			 */
			public static function setPluginData(string $package, array $pluginData) {
				self::$plugins[$package] = $pluginData;
			}

			/**
			 * Returns a plugin data.
			 * @return array|null
			 */
			public static function getPluginData(string $package) {
				if(isset(self::$plugins[$package])) {
					return self::$plugins[$package];
				}
			}

			/**
			 * Sets the framework version.
			 * @param string $version
			 */
			public static function setVersion(string $version) {
				self::$version = $version;
			}

			/**
			 * Returns the framework version.
			 * @return string
			 */
			public static function getVersion(): string {
				return self::$version;
			}
		}
	}
