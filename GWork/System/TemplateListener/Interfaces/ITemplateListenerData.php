<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\TemplateListener\Interfaces {
	    interface ITemplateListenerData {
			/**
			 * ITemplateListenerData constructor.
			 * @param string $eventName
			 * @param string $templateName
			 * @param string $listenerClass
			 */
			public function __construct(string $eventName, string $templateName, string $listenerClass);

			/**
			 * Returns the event name.
			 * @return string
			 */
			public function getEventName(): string;

			/**
			 * Returns the template name.
			 * @return string
			 */
			public function getTemplateName(): string;

			/**
			 * Returns the listener class.
			 * @return string
			 */
			public function getListenerClass(): string;
	    }
	}
