<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Configurations {
		use stdClass;

		final class Paths {
			private $paths;

			/**
			 * @param array $paths
			 */
			public function __construct($paths) {
				if(is_object($paths)) {
					$this->paths = $paths;
				}
			}

			/**
			 * Returns the base directory
			 * @return string
			 */
			public function getBaseDirectory(): string {
				return $this->paths->basedir;
			}

			/**
			 * Returns the application path.
			 * @return array
			 */
			public function getApplicationPath(): array {
				return $this->paths->application;
			}

			/**
			 * Returns the php path.
			 * @return string
			 */
			public function getPhpPath(): string {
				return $this->paths->phpPath;
			}

			/**
			 * Returns the plugins path.
			 * @return array
			 */
			public function getPluginsPath(): array {
				return $this->paths->plugins;
			}

			/**
			 * Returns the framework path.
			 * @return string
			 */
			public function getFrameworkPath(): string {
				return $this->paths->framework;
			}
		}
	}
