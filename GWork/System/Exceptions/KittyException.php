<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Exceptions {
		use \Exception;

		final class GWorkException extends Exception {
			private $object;

			/**
			 * GWorkException constructor.
			 * @param string 	$file
			 * @param int    	$line
			 * @param string 	$message
			 * @param mixed 	$object
			 */
			public function __construct(string $file, int $line, string $message, $object = null) {
				$this->object = $object;

				parent::__construct($file . ' on line ' . $line . ': ' . $message, 0, null);
			}

			/**
			 * Returns the object.
			 * @return mixed
			 */
			public function getObject() {
				return $this->object;
			}
		}
	}
