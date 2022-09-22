<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Helpers\Multilingual {
		final class Language {
			private $code,
					$file,
					$content;

			/**
			 * Language constructor.
			 * @param string $code
			 * @param string $file
			 */
			public function __construct(string $code, string $file) {
				$this->code = $code;
				$this->file = $file;
				$this->content = '{}';

				if($this->exists()) {
					$this->content = file_get_contents($this->getFile());
				}
			}

			/**
			 * Returns the file path.
			 * @return string
			 */
			public function getFile(): string {
				return $this->file;
			}

			/**
			 * Returns the language name.
			 * @return string
			 */
			public function getName(): string {
				if(isset($this->json()['Language'])) {
					return $this->json()['Language'];
				}

				return '';
			}

			/**
			 * Returns the language code.
			 * @return string
			 */
			public function getCode(): string {
				return $this->code;
			}

			/**
			 * Checks if the language is exists.
			 * @return bool
			 */
			public function exists(): bool {
				if(file_exists($this->getFile())) {
					return true;
				}

				return false;
			}

			/**
			 * Returns an array as json from the language file.
			 * @return array
			 */
			public function json(array $placeholders = [], array $replacements = []): array {
				return json_decode(str_replace($placeholders, $replacements, $this->content), true);
			}
	    }
	}
