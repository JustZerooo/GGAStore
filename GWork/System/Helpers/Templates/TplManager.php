<?php
	/**
	 * @author gwork
	 */

	 namespace GWork\System\Helpers\Templates {
		use GWork\System\Helpers\Templates\Template;
		use GWork\System\Configurations\Paths;

	    final class TplManager {
			private $paths,
					$files = [],
					$default;

			/**
			 * TplManager constructor.
			 * @param Paths 	$paths
 			 * @param string 	$default
			 */
			public function __construct(Paths $paths, string $default) {
				$this->paths = $paths;
				$this->default = new Template($paths, $default);

				$applicationPath = $this->paths->getPhpPath() . $this->paths->getApplicationPath()['directory'];
				$templatesPath = $this->paths->getApplicationPath()['templates'];

				$files = scandir($applicationPath . $templatesPath);
				foreach($files as $key => $value) {
					if(is_dir($applicationPath . $templatesPath . DIR_SPLITTER . $value) && $value != '.' && $value != '..') {
						$this->add($value, new Template($paths, $value));
					}
				}
			}

			/**
			 * Sets the default template.
			 * @param string $default
			 */
			public function setDefault(string $default) {
				$this->default = new Template($this->paths, $default);
			}

			/**
			 * Adds a template.
			 * @param string 	$dirname
			 * @param Template 	$template
			 */
	        public function add(string $dirname, Template $template) {
	            $this->files[$dirname] = $template;
	        }

			/**
			 * Returns the template.
			 * @param 	string $dirname
			 * @return 	Template
			 */
	        public function getTemplate(string $dirname): Template {
	            if($this->contains($dirname)) {
					return $this->files[$dirname];
				}

				return $this->default;
	        }

			/**
			 * Checks if template is added.
			 * @param 	string $dirname
			 * @return 	bool
			 */
			public function contains(string $dirname): bool {
				if(array_key_exists($dirname, $this->files)) {
					return true;
				}

				return false;
			}

			/**
			 * Checks if template file is exists.
			 * @param 	string $dirname
			 * @return 	bool
			 */
			public function exists(string $dirname): bool {
				if($this->contains($dirname)) {
					if($this->files[$dirname]->exists()) {
						return true;
					}
				}

				return false;
			}
	    }
	}
