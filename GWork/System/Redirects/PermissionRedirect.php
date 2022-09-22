<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Redirects {
		use GWork\System\Helpers\Redirects\Interfaces\IRedirect;

		use GWork\System\Patterns\MVC\Controllers\Controller;
		use GWork\System\GWORK;

	    final class PermissionRedirect implements IRedirect {
			private $controller;

			/**
			 * @see GWork\System\Helpers\Redirects\Interfaces\IRedirect::__construct()
			 */
			public function __construct(Controller $controller) {
				$this->controller = $controller;
			}

			/**
			 * @see GWork\System\Helpers\Redirects\Interfaces\IRedirect::onCheck()
			 */
			public function onCheck(): bool {
				return false;
	        }

			/**
			 * @see GWork\System\Helpers\Redirects\Interfaces\IRedirect::redirect()
			 */
			public function redirect(string $url) { }

			/**
			 * Checks if redirect is needed.
			 * @param  string  	$permission
			 * @param  bool 	$hasPermission
			 * @return bool
			 */
			public function onCheckByPermission(string $permission, bool $hasPermission = false): bool {
				$user = $this->controller->getUser();

				if($hasPermission) {
					if($user != null && $user->hasPermissionByName($permission)) {
						return true;
					}
				} else {
					if($user == null || !$user->hasPermissionByName($permission)) {
						return true;
					}
				}

				return false;
	        }

			/**
			 * Redirects the user.
			 * @param  string  	$url
			 * @param  string  	$permission
			 * @param  bool 	$hasPermission
			 * @return bool
			 */
			public function redirectByPermission(string $url, string $permission, bool $hasPermission = false) {
				if($this->onCheckByPermission($permission, $hasPermission)) {
					GWORK::redirect($url);
				}
			}
	    }
	}
