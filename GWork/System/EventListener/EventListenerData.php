<?php
	/**
	 * @author gwork
	 */

	 namespace GWork\System\EventListener {
	    use GWork\System\EventListener\Interfaces\IEventListenerData;

	    class EventListenerData implements IEventListenerData {
			protected 	$eventName,
						$eventClass,
						$listenerClass;

			/**
			 * @see GWork\System\EventListener\Interfaces\IEventListenerData::__construct()
			 */
			public function __construct(string $eventName, string $eventClass, string $listenerClass) {
				$this->eventName = $eventName;
				$this->eventClass = $eventClass;
				$this->listenerClass = $listenerClass;
			}

			/**
			 * @see GWork\System\EventListener\Interfaces\IEventListenerData::getEventName()
			 */
			public function getEventName(): string {
				return $this->eventName;
			}

			/**
			 * @see GWork\System\EventListener\Interfaces\IEventListenerData::getEventClass()
			 */
			public function getEventClass(): string {
				return $this->eventClass;
			}

			/**
			 * @see GWork\System\EventListener\Interfaces\IEventListenerData::getListenerClass()
			 */
			public function getListenerClass(): string {
				return $this->listenerClass;
			}
	    }
	}
