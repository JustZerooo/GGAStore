<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Helpers\Multilingual {
		use GWork\System\Configurations\Paths;
		use GWork\System\Patterns\MVC\Controllers\Controller;
		use GWork\System\Common;

	    final class Multilingual {
			private $controller,
					$paths,
					$files = [],
					$default,
					$autoDetect;

			/**
			 * Multilingual constructor.
			 * @param Controller 	$controller
			 * @param Paths      	$paths
			 * @param string     	$default
			 * @param bool     		$autoDetect
			 */
			public function __construct(Controller $controller, Paths $paths, string $default, bool $autoDetect = false) {
				$this->controller = $controller;
				$this->paths = $paths;

				if($this->controller->getPluginInfo() == null) {
					$path = $this->paths->getPhpPath() . $this->paths->getApplicationPath()['directory'] . $this->paths->getApplicationPath()['languages'];
				} else {
					$path = $this->paths->getPhpPath() . $this->paths->getPluginsPath()['directory'] . DIR_SPLITTER . $this->controller->getPluginInfo()->getPath() . $this->paths->getPluginsPath()['languages'];
				}

				$this->autoDetect = $autoDetect;
				$this->default = new Language($default, $path . DIR_SPLITTER . $default . '.json');

				if(is_dir($path)) {
					$files = scandir($path);
					foreach($files as $key => $value) {
						$pathinfo = pathinfo($value);

						if(strtolower($pathinfo['extension']) == 'json') {
							$this->add($pathinfo['filename'], new Language($pathinfo['filename'], $path . DIR_SPLITTER . $pathinfo['basename']));
						}
					}
				}

				if($autoDetect) {
					$language = Common::getCountryCode();

					if($this->exists($language)) {
						$this->default = new Language($language, $path . DIR_SPLITTER . $language . '.json');
					}
				}
			}

			/**
			 * Returns all languages.
			 * @return array
			 */
			public function getLanguages() {
				return $this->files;
			}

			/**
			 * Adds a language.
			 * @param string 	$key
			 * @param Language 	$language
			 */
	        public function add(string $key, Language $language) {
	            $this->files[strtolower($key)] = $language;
	        }

			/**
			 * Returns a language.
			 * @param 	string 	$key
			 * @return 	Language
			 */
	        public function getLanguage(string $key): Language {
				if($this->contains($key)) {
					return $this->files[strtolower($key)];
				}

				return $this->default;
	        }

			/**
			 * Checks if language is added.
			 * @param 	string $key
			 * @return 	bool
			 */
			public function contains(string $key): bool {
				if(array_key_exists(strtolower($key), $this->files)) {
					return true;
				}

				return false;
			}

			/**
			 * Checks if the language is exists.
			 * @param 	string $key
			 * @return 	bool
			 */
			public function exists(string $key): bool {
				if($this->contains($key)) {
					if($this->files[strtolower($key)]->exists()) {
						return true;
					}
				}

				return false;
			}
	    }
	}
