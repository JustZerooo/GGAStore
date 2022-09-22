<?php
	/**
	 * @author gwork
	 */

	 namespace GWork\System\TemplateListener {
	    use GWork\System\TemplateListener\Interfaces\ITemplateListenerData;

	    class TemplateListenerData implements ITemplateListenerData {
			protected 	$eventName,
						$templateName,
						$listenerClass;

			/**
			 * @see GWork\System\TemplateListener\Interfaces\ITemplateListenerData::__construct()
			 */
			public function __construct(string $eventName, string $templateName, string $listenerClass) {
				$this->eventName = $eventName;
				$this->templateName = $templateName;
				$this->listenerClass = $listenerClass;
			}

			/**
			 * @see GWork\System\TemplateListener\Interfaces\ITemplateListenerData::getEventName()
			 */
			public function getEventName(): string {
				return $this->eventName;
			}

			/**
			 * @see GWork\System\TemplateListener\Interfaces\ITemplateListenerData::getTemplateName()
			 */
			public function getTemplateName(): string {
				return $this->templateName;
			}

			/**
			 * @see GWork\System\TemplateListener\Interfaces\ITemplateListenerData::getListenerClass()
			 */
			public function getListenerClass(): string {
				return $this->listenerClass;
			}
	    }
	}
