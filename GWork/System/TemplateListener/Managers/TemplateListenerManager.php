<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\TemplateListener\Managers {
		use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

		use GWork\System\TemplateListener\Handlers\TemplateListenerHandler;
		use GWork\System\TemplateListener\TemplateListenerData;

		use GWork\System\Plugin\PluginManager;

		use GWork\System\Models\TemplateListener\TemplateListenerFactory;
		use GWork\System\Models\Plugin\PluginFactory;

	    final class TemplateListenerManager {
			protected 	$templateListenerHandler,
						$modelsManager,
						$pluginManager,
						$templateListenersData;

			/**
			 * TemplateListenerManager constructor.
			 * @param ModelsManager $modelsManager
			 * @param PluginManager $pluginManager
			 */
			public function __construct(ModelsManager $modelsManager, PluginManager $pluginManager) {
				$this->modelsManager = $modelsManager;
				$this->pluginManager = $pluginManager;

				$this->templateListenersData = [];
			}

			/**
			 * Loads the template listeners.
			 */
			public function loadTemplateListeners() {
				$this->templateListenersData = [];

				$templateListenerFactory = $this->getModelsManager()->get(TemplateListenerFactory::class);
				$pluginFactory = $this->getModelsManager()->get(PluginFactory::class);

				$templateListeners = $templateListenerFactory->getAll();

				foreach($templateListeners as $templateListener) {
					$plugin = $pluginFactory->getByColumn('id', $templateListener->getRow()->pluginId);

					if($this->getPluginManager()->isPluginLoaded($plugin->getRow()->package)) {
						$this->templateListenersData[] = new TemplateListenerData(
							$templateListener->getRow()->eventName,
							$templateListener->getRow()->templateName,
							$templateListener->getRow()->listenerClass
						);
					}
				}
			}

			/**
			 * Creates the template listener handler.
			 */
			public function createTemplateListenerHandler() {
				$this->templateListenerHandler = new TemplateListenerHandler($this->templateListenersData);
			}

			/**
			 * Returns the template listener handler.
			 * @return TemplateListenerHandler
			 */
			public function getTemplateListenerHandler(): TemplateListenerHandler {
				return $this->templateListenerHandler;
			}

			/**
			 * Returns the models manager.
			 * @return PluginManager
			 */
			public function getPluginManager(): PluginManager {
				return $this->pluginManager;
			}

			/**
			 * Returns the models manager.
			 * @return ModelsManager
			 */
			public function getModelsManager(): ModelsManager {
				return $this->modelsManager;
			}
	    }
	}
