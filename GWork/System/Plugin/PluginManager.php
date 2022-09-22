<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Plugin {
		use GWork\System\Plugin\PluginInfo;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

		use GWork\System\Models\Plugin\PluginFactory;

	    final class PluginManager {
			private $loadedPlugins,
					$plugins,
					$modelsManager;

			/**
			 * PluginManager constructor.
			 * @param ModelsManager $modelsManager
			 */
			public function __construct(ModelsManager $modelsManager) {
				$this->modelsManager = $modelsManager;

				$this->loadedPlugins = [];
				$this->plugins = [];
			}

			/**
			 * Loads all plugins from the database.
			 */
			public function initialize() {
				$pluginFactory = $this->getModelsManager()->get(PluginFactory::class);

				foreach($pluginFactory->getAllByColumn('enabled', 1) as $plugin) {
					$this->plugins[] = (array) $plugin->getRow();
				}
			}

			/**
			 * Adds plugin in the array.
			 * @param array $plugin
			 */
			public function add(array $plugin) {
				$pluginInfo = new PluginInfo($plugin);

				foreach($pluginInfo->getRequiredPlugins() as $requiredPluginPackage) {
					if(!$this->isPluginLoaded($requiredPluginPackage)) {
						$requiredPlugin = $this->getPluginByPackage($requiredPluginPackage);

						if($requiredPlugin != null) {
							$this->loadedPlugins[] = $requiredPlugin;
						}
					}
				}

				if(!$this->isPluginLoaded($plugin['package'])) {
					$this->loadedPlugins[] = $plugin;
				}
			}

			/**
			 * Returns the models manager.
			 * @return ModelsManager
			 */
			public function getModelsManager(): ModelsManager {
				return $this->modelsManager;
			}

			/**
			 * Returns the loaded plugin packages as array.
			 * @return array
			 */
			public function getLoadedPlugins(): array {
				return $this->loadedPlugins;
			}

			/**
			 * Returns the plugin packages as array.
			 * @return array
			 */
			public function getPlugins(): array {
				return $this->plugins;
			}

			/**
			 * Checks if the plugin is loaded by package.
			 * @param  string $package
			 * @return bool
			 */
			public function isPluginLoaded(string $package) {
				foreach($this->getLoadedPlugins() as $plugin) {
					$pluginInfo = new PluginInfo($plugin);

					if($pluginInfo->getPackage() == $package) {
						return true;
					}
				}
			}

			/**
			 * Returns a plugin by package.
			 * @param  string $package
			 * @return array|null
			 */
			public function getPluginByPackage(string $package) {
				foreach($this->getPlugins() as $plugin) {
					$pluginInfo = new PluginInfo($plugin);

					if($pluginInfo->getPackage() == $package) {
						return $plugin;
					}
				}
			}
	    }
	}
