<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System {
		use GWork\System\Exceptions\GWorkException;
		use stdClass;

		final class Configuration {
			private $configuration = [];

			/**
			 * Configuration constructor.
			 * @param array $config
			 */
			public function __construct(stdClass $configuration) {
				if(is_object($configuration)) {
					$this->configuration = $configuration;
				} else {
					throw new GWorkException(__DIR__ . '\Configuration.php', 17, '$configuration has to be an object, ' . gettype($configuration) . ' given.');
				}
			}

			/**
			 * Returns the mode.
			 * @return string
			 */
			public function getMode(): string {
				return $this->configuration->mode;
			}

			/**
			 * Returns the save path for the temps.
			 * @return string
			 */
			public function getSessionSavePath(): string {
				return (bool) $this->configuration->session_save_path;
			}

			/**
			 * Returns the prefix for the sessions.
			 * @return string
			 */
			public function getSessionPrefix(): string {
				return $this->configuration->session_prefix;
			}

			/**
			 * Returns the file upload paths.
			 * @return stdClass
			 */
			public function getUploadPaths(): stdClass {
				return $this->configuration->paths->uploads;
			}

			/**
			 * Returns the application paths.
			 * @return stdClass
			 */
			public function getPaths(): stdClass {
				return $this->configuration->paths;
			}

			/**
			 * Returns the database settings.
			 * @return stdClass
			 */
			public function getDatabaseSettings(): stdClass {
				return $this->configuration->database;
			}
		}
	}
