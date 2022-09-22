<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Plugin\Interfaces {
		use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

	    interface IPlugin {
			/**
			 * IPlugin constructor.
			 * @param array         $pluginData
			 * @param ModelsManager $modelsManager
			 */
			public function __construct(array $pluginData, ModelsManager $modelsManager);

			/**
			 * Returns the plugin data.
			 * @return array
			 */
			public function getPluginData();

			/**
			 * Returns the plugin info.
			 * @return PluginInfo
			 */
			public function getPluginInfo();

			/**
			 * Calls when plugin constructed / loaded.
			 */
			public function onConstructed();

			/**
			 * Returns the models manager.
			 * @return ModelsManager
			 */
			public function getModelsManager();
	    }
	}
