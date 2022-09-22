<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\EventListener\Interfaces {
	    interface IEventListener {
			/**
			 * onListenerCall
			 * @param  string 	$eventName
			 * @param  string 	$eventClass
			 * @param  array 	$data
			 */
			public function onListenerCall(string $eventName, string $eventClass, array $data = []);
	    }
	}
