<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Patterns\MVC\Templates\Managers {
	    use GWork\System\Patterns\MVC\Templates\Template;
		use GWork\System\Configurations\Paths;

	    final class TemplateManager {
	        private $cachedTemplates = [],
					$paths;

			/**
			 * TemplateManager constructor.
			 * @param Paths $paths
			 */
	        public function __construct(Paths $paths) {
	            $this->paths = $paths;
	        }

			/**
			 * Creates a template.
			 * @param	string 			$tpl
			 * @param	PluginInfo|null $pluginInfo
			 * @return 	Template
			 */
	        private function create(string $tpl, $pluginInfo): Template {
				if($pluginInfo == null) {
					$tpl = new Template($this->paths->getPhpPath() . $this->paths->getApplicationPath()['directory'] . $this->paths->getApplicationPath()['templates'], $tpl, $this);
				} else {
					$tpl = new Template($this->paths->getPhpPath() .$this->paths->getPluginsPath()['directory'] . DIR_SPLITTER . $pluginInfo->getPath() . $this->paths->getPluginsPath()['templates'], $tpl, $this);
				}

	            $this->cachedTemplates[] = $tpl;

	            return $tpl;
	        }

			/**
			 * Returns a template.
			 * @param  string $tpl
			 * @return Template|null
			 */
	        private function get(string $tpl) {
	            foreach($this->cachedTemplates as $template) {
	                if($template->getFile() == $tpl) {
	                    return $template;
	                }
	            }

	            return null;
	        }

			/**
			 * Checks if a template is exists.
			 * @param  string $tpl
			 * @return Template|null
			 */
	        private function exists(string $tpl) {
	            return $this->get($tpl) != null;
	        }

			/**
			 * Makes a template.
			 * @param  	string 			$file
			 * @param	PluginInfo|null $pluginInfo
			 * @return 	Template
			 */
	        public function make(string $file, $pluginInfo): Template {
	            if(!$this->exists($file)) {
	                $tpl = $this->create($file, $pluginInfo);
	            } else {
	                $tpl = $this->get($file);
	            }

	            return $tpl;
	        }
	    }
	}
