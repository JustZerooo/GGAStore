<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Plugin {
		use GWork\System\Plugin\Interfaces\IPlugin;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

	    class BasePlugin implements IPlugin {
			protected 	$pluginData,
						$pluginInfo,
						$modelsManager,
			 			$templateListeners,
						$eventListeners;

			/**
			 * @see GWork\System\Plugin\Interfaces\IPlugin::__construct()
			 */
	        public function __construct(array $pluginData, ModelsManager $modelsManager) {
				$this->pluginData = $pluginData;
				$this->pluginInfo = new PluginInfo($this->pluginData);

				$this->modelsManager = $modelsManager;
	        }

			/**
			 * @see GWork\System\Plugin\Interfaces\IPlugin::onConstructed()
			 */
	        public function onConstructed() { }

			/**
			 * @see GWork\System\Plugin\Interfaces\IPlugin::getPluginData()
			 */
			public function getPluginData() {
				return $this->pluginData;
			}

			/**
			 * @see GWork\System\Plugin\Interfaces\IPlugin::getPluginInfo()
			 */
			public function getPluginInfo() {
				return $this->pluginInfo;
			}

			/**
			 * @see GWork\System\Plugin\Interfaces\IPlugin::getModelsManager()
			 */
			public function getModelsManager() {
				return $this->modelsManager;
			}
	    }
	}
