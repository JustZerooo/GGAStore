<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System {
		use GWork\System\Configurations\Paths;

		use \GEOIP_MEMORY_CACHE;
		use \FILTER_VALIDATE_EMAIL;

	    class Common {
	        private static $configuration;

			/**
			 * Initializes the class objects.
			 * @param Configuration $configuration
			 */
	        public static function init(Configuration $configuration) {
	            self::$configuration = $configuration;
	        }

			/**
			 * Returns the configuration.
			 * @return Configuration
			 */
			public static function getConfiguration(): Configuration {
				return self::$configuration;
			}

			/**
			 * Checks if the content is numeric.
			 * @param  mixed $val
			 * @return bool
			 */
			public static function isDecimal($val): bool {
				return is_numeric($val) && floor($val) != $val;
			}

			/**
			 * Returns the ip address of the visitor.
			 * @return string
			 */
			public static function getIp(): string {
				$ip = $_SERVER['REMOTE_ADDR'];

				if(!empty($_SERVER['HTTP_CLIENT_IP'])) {
					$ip = $_SERVER['HTTP_CLIENT_IP'];
				} else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
					$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
				} else if(isset($_SERVER['HTTP_CF_CONNECTING_IP'])) {
					$ip = $_SERVER['HTTP_CF_CONNECTING_IP'];
				}

				return $ip;
			}

			/**
			 * Returns the country code of the user.
			 * @return string
			 */
			public static function getCountryCode(): string {
				if(!function_exists('geoip_open')) return '';

				$paths = new Paths(self::$configuration->getPaths());

				$gi = geoip_open($paths->getFrameworkPath() . '\GeoIP.dat', GEOIP_MEMORY_CACHE);
				$country = geoip_country_code_by_addr($gi, self::getIp());
				geoip_close($gi);

				return strtoupper($country);
			}

			/**
	         * Checks if the string a valid username.
	         * @param 	string $username
	         * @return 	bool
	         */
			public static function isValidUsername(string $username): bool {
				if(ctype_alnum($username)) {
					return true;
				}

				return false;
			}

			/**
			 * Checks if the string a valid email.
			 * @param 	string $email
			 * @return 	bool
			 */
			public static function isValidMail(string $email): bool {
				if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
					return false;
				}

				return true;
			}

			/**
			 * @deprecated use GWork\System\Helpers\Pagers\Pager
			 * @param  int 		$items
			 * @param  int 		$page
			 * @param  int 		$itemsProPage
			 * @return array
			 */
			public static function getPaginationInfo(int $items = 0, int $page = 1, int $itemsProPage = 10): array {
				$invalid = false;

				if($page <= 0) {
					$page = 1;

					if($items > 0) {
						$invalid = true;
					}
				}

				$pages = ceil($items / $itemsProPage);
				if($pages <= 0) {
					$pages = 1;

					if($items > 0) {
						$invalid = true;
					}
				}

				if($page > $pages) {
					if($items > 0) {
						$invalid = true;
					}

					$page = 1;
				}

				$start = ($itemsProPage * ($page - 1));
				$limit = $start . ', ' . $itemsProPage;

				return [
					'limit'		=> $limit,
					'start'		=> $start,
					'items'		=> $itemsProPage,
					'pages'		=> $pages,
					'page'		=> $page,
					'invalid'	=> $invalid
				];
			}

			/**
			 * This closes html tags that's not closed.
			 * @param  string $html
			 * @return string
			 */
			public static function closeHTMLTags(string $html): string {
				preg_match_all('#<(?!meta|img|br|hr|input\b)\b([a-z]+)(?: .*)?(?<![/|/ ])>#iU', $html, $result);
				$openedtags = $result[1];

				preg_match_all('#</([a-z]+)>#iU', $html, $result);
			    $closedtags = $result[1];

			    if(count($closedtags) == count($openedtags)) {
			        return $html;
			    }

			    $openedtags = array_reverse($openedtags);
			    for($i = 0; $i < count($openedtags); $i++) {
			        if(!in_array($openedtags[$i], $closedtags)) {
			            $html .= '</' . $openedtags[$i] . '>';
			        } else {
			            unset($closedtags[array_search($openedtags[$i], $closedtags)]);
			        }
			    }

			    return $html;
			}
	    }
	}
