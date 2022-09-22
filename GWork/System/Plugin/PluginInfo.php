<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Plugin {
		final class PluginInfo {
			private $data;

			/**
			 * PluginsInfo constructor.
			 * @param array $data
			 */
			public function __construct(array $data) {
				$this->data = $data;
			}

			/**
			 * Returns the plugin data.
			 * @return array
			 */
			public function getData(): array {
				return $this->data;
			}

			/**
			 * Returns the plugin id.
			 * @return int
			 */
			public function getId(): int {
				return intval($this->data['id']);
			}

			/**
			 * Returns the plugin package.
			 * @return string
			 */
			public function getPackage(): string {
				return $this->data['package'];
			}

			/**
			 * Returns the plugin name.
			 * @return string
			 */
			public function getName(): string {
				return $this->data['name'];
			}

			/**
			 * Returns the plugin version.
			 * @return string
			 */
			public function getVersion(): string {
				return $this->data['version'];
			}

			/**
			 * Returns the plugin author.
			 * @return string
			 */
			public function getAuthor(): string {
				return $this->data['author'];
			}

			/**
			 * Returns the plugin contributors.
			 * @return array
			 */
			public function getContributors(): array {
				return explode(',', str_replace(', ', ',', $this->data['contributors']));
			}

			/**
			 * Returns the plugin contributors.
			 * @return array
			 */
			public function getRequiredPlugins(): array {
				return explode(',', str_replace(', ', ',', $this->data['requiredPlugins']));
			}

			/**
			 * Returns the plugin path.
			 * @return string
			 */
			public function getPath(): string {
				return str_replace('.', DIR_SPLITTER, $this->getPackage());
			}
		}
	}
