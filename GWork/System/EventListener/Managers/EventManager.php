<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\EventListener\Managers {
		use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

		use GWork\System\EventListener\Handlers\EventHandler;
		use GWork\System\EventListener\EventListenerData;

		use GWork\System\Plugin\PluginManager;

		use GWork\System\Models\EventListener\EventListenerFactory;
		use GWork\System\Models\Plugin\PluginFactory;

	    final class EventManager {
			protected 	$eventHandler,
						$modelsManager,
						$pluginManager,
						$eventListenersData;

			/**
			 * Event manager constructor.
			 * @param ModelsManager $modelsManager
			 * @param PluginManager $pluginManager
			 */
			public function __construct(ModelsManager $modelsManager, PluginManager $pluginManager) {
				$this->modelsManager = $modelsManager;
				$this->pluginManager = $pluginManager;

				$this->eventListenersData = [];
			}

			/**
			 * Loads the event listeners.
			 */
			public function loadEventListeners() {
				$this->eventListenersData = [];

				$eventListenerFactory = $this->getModelsManager()->get(EventListenerFactory::class);
				$pluginFactory = $this->getModelsManager()->get(PluginFactory::class);

				$eventListeners = $eventListenerFactory->getAll();

				foreach($eventListeners as $eventListener) {
					$plugin = $pluginFactory->getByColumn('id', $eventListener->getRow()->pluginId);

					if($this->getPluginManager()->isPluginLoaded($plugin->getRow()->package)) {
						$this->eventListenersData[] = new EventListenerData(
							$eventListener->getRow()->eventName,
							$eventListener->getRow()->eventClass,
							$eventListener->getRow()->listenerClass
						);
					}
				}
			}

			/**
			 * Creates the event handler.
			 */
			public function createEventHandler() {
				$this->eventHandler = new EventHandler($this->eventListenersData);
			}

			/**
			 * Returns the event handler.
			 * @return EventHandler
			 */
			public function getEventHandler(): EventHandler {
				return $this->eventHandler;
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
