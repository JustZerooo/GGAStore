<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\EventListener\Handlers {
	    final class EventHandler {
			private $eventListenersData;

			/**
			 * Event handler constructor.
			 * @param array $eventListenersData
			 */
			public function __construct(array $eventListenersData = []) {
				$this->eventListenersData = $eventListenersData;
			}

			/**
			 * Returns event listeners data.
			 * @param string 	eventName
			 * @param string 	eventClass
			 * @param array		$data
			 */
			public function callEvent(string $eventName, string $eventClass, array $data = []) {
				foreach($this->getEventListenersData() as $eventListenerData) {
					if($eventListenerData->getEventName() != $eventName) continue;
					if($eventListenerData->getEventClass() != $eventClass) continue;

					$listenerClass = $eventListenerData->getListenerClass();

					$listener = new $listenerClass();
					$listener->onListenerCall($eventName, $eventClass, $data);
				}
			}

			/**
			 * Returns event listeners data.
			 * @return array
			 */
			public function getEventListenersData(): array {
				return $this->eventListenersData;
			}
	    }
	}
