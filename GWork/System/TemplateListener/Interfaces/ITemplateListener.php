<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\TemplateListener\Interfaces {
	    interface ITemplateListener {
			/**
			 * onListenerCall
			 * @param  string 	$eventName
			 * @param  string 	$eventClass
			 * @param  array 	$data
			 */
			public function onListenerCall(string $eventName, string $eventClass, array $data = []);
	    }
	}
