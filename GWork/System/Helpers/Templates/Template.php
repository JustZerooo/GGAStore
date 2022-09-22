<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Helpers\Templates {
		use GWork\System\Configurations\Paths;

	    final class Template {
			private $paths,
					$dirname;

			/**
			 * Template constructor.
			 * @param Paths  $paths
			 * @param string $dirname
			 */
			public function __construct(Paths $paths, string $dirname) {
				$this->paths = $paths;
				$this->dirname = $dirname;
			}

			/**
			 * Returns the directory name.
			 * @return string
			 */
			public function getDirectoryName(): string {
				return $this->dirname;
			}

			/**
			 * Checks if template directory is exists.
			 * @return bool
			 */
			public function exists(): bool {
				if(is_dir($this->paths->getTemplatesPath() . $this->getDirectoryName())) {
					return true;
				}

				return false;
			}
	    }
	}
