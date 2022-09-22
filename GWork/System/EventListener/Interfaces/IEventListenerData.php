<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\EventListener\Interfaces {
	    interface IEventListenerData {
			/**
			 * IEventListenerData constructor.
			 * @param  string 	$eventName
			 * @param  string 	$eventClass
			 * @param  string 	$listenerClass
			 */
			public function __construct(string $eventName, string $eventClass, string $listenerClass);

			/**
			 * Returns the event name.
			 * @return string
			 */
			public function getEventName(): string;

			/**
			 * Returns the event class.
			 * @return string
			 */
			public function getEventClass(): string;

			/**
			 * Returns the listener class.
			 * @return string
			 */
			public function getListenerClass(): string;
	    }
	}
