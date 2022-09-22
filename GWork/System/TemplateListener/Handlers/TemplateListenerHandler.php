<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\TemplateListener\Handlers {
	    final class TemplateListenerHandler {
			private $templateListenersData;

			/**
			 * Template listener handler constructor.
			 * @param array $templateListenersData
			 */
			public function __construct(array $templateListenersData = []) {
				$this->templateListenerData = $templateListenersData;
			}

			/**
			 * On template listener calls.
			 * @param  string 	$eventName
			 * @param  string 	$templateName
			 * @param  array 	$data
			 */
			public function callTemplateListener(string $eventName, string $templateName, array $data = []) {
				foreach($this->getTemplateListenerData() as $templateListenerData) {
					if($templateListenerData->getEventName() != $eventName) continue;
					if($templateListenerData->getTemplateName() != $templateName) continue;

					$listenerClass = $templateListenerData->getListenerClass();

					$listener = new $listenerClass();
					$listener->onListenerCall($eventName, $templateName, $data);
				}
			}

			/**
			 * Returns template listeners data.
			 * @return array
			 */
			public function getTemplateListenerData(): array {
				return $this->templateListenerData;
			}
	    }
	}
