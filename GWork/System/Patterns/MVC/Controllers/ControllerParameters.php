<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Controllers {
	    use GWork\System\Application;
	    use GWork\System\Patterns\MVC\Controllers\Collectors\ControllerCollector;
	    use GWork\System\Patterns\MVC\Templates\Managers\TemplateManager;
	    use GWork\System\Patterns\MVC\Templates\View;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;
	    use GWork\System\EventListener\Managers\EventManager;
		use GWork\System\TemplateListener\Managers\TemplateListenerManager;

	    final class ControllerParameters {
	        private	$application,
					$controllerCollector,
					$templateManager,
					$view,
					$modelsManager,
					$eventManager,
					$templateListenerManager;

			/**
			 * ControllerParameters constructor.
			 * @param Application             $application
			 * @param ControllerCollector     $controllerCollector
			 * @param TemplateManager         $templateManager
			 * @param View                    $view
			 * @param ModelsManager           $modelsManager
			 * @param EventManager            $eventManager
			 * @param TemplateListenerManager $templateListenerManager
			 */
	        public function __construct(Application $application, ControllerCollector $controllerCollector, TemplateManager $templateManager, View $view, ModelsManager $modelsManager, EventManager $eventManager, TemplateListenerManager $templateListenerManager) {
	            $this->application = $application;
	            $this->controllerCollector = $controllerCollector;
	            $this->templateManager = $templateManager;
	            $this->view = $view;
	            $this->modelsManager = $modelsManager;
				$this->eventManager = $eventManager;
				$this->templateListenerManager = $templateListenerManager;
	        }

			/**
			 * Returns the template listener manager.
			 * @return TemplateListenerManager
			 */
			public function getTemplateListenerManager(): TemplateListenerManager {
				return $this->templateListenerManager;
			}

			/**
			 * Returns the event listener manager.
			 * @return EventManager
			 */
			public function getEventManager(): EventManager {
				return $this->eventManager;
			}

			/**
			 * Returns the application.
			 * @return Application
			 */
	        public function getApplication(): Application {
	            return $this->application;
	        }

			/**
			 * Returns the controller collector.
			 * @return ControllerCollector
			 */
	        public function getControllerCollector(): ControllerCollector {
	            return $this->controllerCollector;
	        }

			/**
			 * Returns the template manager.
			 * @return TemplateManager
			 */
	        public function getTemplateManager(): TemplateManager {
	            return $this->templateManager;
	        }

			/**
			 * Returns the view.
			 * @return View
			 */
	        public function getView():View {
	            return $this->view;
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
