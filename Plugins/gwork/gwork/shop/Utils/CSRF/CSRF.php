<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Utils\CSRF {
		use GWork\System\Patterns\MVC\Controllers\Controller;

	    final class CSRF {
			public static function getCSRFToken(Controller $controller) {
				$token = $controller->getSession('CSRF_TOKEN');

				if($token == null) {
					$token = self::generateCSRFToken();

					$controller->setSession('CSRF_TOKEN', $token);
					return $token;
				}

				return $token;
			}

			public static function validateCSRFToken($token, Controller $controller) {
				return $token === self::getCSRFToken($controller);
			}

			public static function setCSRFToken(Controller $controller) {
				$token = self::generateCSRFToken();

				$controller->setSession('CSRF_TOKEN', $token);

				return $token;
			}

			public static function generateCSRFToken() {
				if(version_compare(phpversion(), '7', '>=')) {
					$token = bin2hex(random_bytes(32));
				} else if(function_exists('mcrypt_create_iv')) {
					$token = bin2hex(mcrypt_create_iv(32, \MCRYPT_DEV_URANDOM));
				} else {
					$token = bin2hex(openssl_random_pseudo_bytes(32));
				}

				return $token;
			}
	    }

		return __NAMESPACE__;
	}
