<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Helpers\Redirects\Interfaces {
	    interface IRedirect {
			/**
			 * Checks if redirect is needed.
			 * @return bool
			 */
	        public function onCheck(): bool;

			/**
			 * Redirects the user.
			 * @param string $url
			 */
	        public function redirect(string $url);
	    }
	}
