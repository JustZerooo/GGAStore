<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System {
		use GWork\System\Helpers\Templates\TplManager;

		use \PDO;

		final class Application {
			private $configuration;
			private $connection;
			private $tplManager;

			/**
			 * @param Configuration $config
			 * @param PDO 			$connection
			 * @param TplManager 	$tplManager
			 */
			public function __construct(Configuration $configuration, PDO $connection, TplManager $tplManager) {
				$this->configuration = $configuration;
				$this->connection = $connection;
				$this->tplManager = $tplManager;
			}

			/**
			 * Returns the tpl manager.
			 * @return TplManager
			 */
			public function getTplManager(): TplManager {
				return $this->tplManager;
			}

			/**
			 * Returns the configuration.
			 * @return Configuration
			 */
			public function getConfiguration(): Configuration {
				return $this->configuration;
			}

			/**
			 * Returns the connection.
			 * @return PDO
			 */
			public function getConnection(): PDO {
				return $this->connection;
			}
		}
	}
