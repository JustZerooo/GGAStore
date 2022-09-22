<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop {
	    use GWork\System\Plugin\BasePlugin;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

	    final class Plugin extends BasePlugin {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Plugin\BasePlugin::__construct()
			 */
			public function __construct(array $pluginData, ModelsManager $modelsManager) {
				parent::__construct($pluginData, $modelsManager);
	        }

			/**
			 * @see GWork\System\Plugin\BasePlugin::onConstructed()
			 */
			public function onConstructed() {
				parent::onConstructed();
	        }

			public static function convertCurrency($amount, $fromCurrency, $toCurrency, $inCent = true) {
				$amount = urlencode($amount);

				$fromCurrency = trim(strtoupper(urlencode($fromCurrency)));
				$toCurrency = trim(strtoupper(urlencode($toCurrency)));

				if($fromCurrency == 'TRL')	$fromCurrency = 'TRY';
				if($fromCurrency == 'ZWD')	$fromCurrency = 'ZWL';
				if($fromCurrency == 'RIAL') $fromCurrency = 'IRR';

				$url = 'https://www.google.com/finance/converter?a=' . $amount . '&from=' . $fromCurrency . '&to=' . $toCurrency;

				$ch = curl_init();
				curl_setopt($ch, CURLOPT_URL, $url);
				curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE);
				curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
				curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 9.0; Windows NT 6.1; Trident/5.0)');
				curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20);
				curl_setopt($ch, CURLOPT_TIMEOUT, 20);
				$rawdata = curl_exec($ch);
				curl_close($ch);
				$data = explode('bld>', $rawdata);
				$data = explode($toCurrency, $data[1]);

				$rounded = round($data[0], ($toCurrency == 'BTC' ? 5 : 2));

				if($toCurrency == 'BTC') {
					$rounded = sprintf('%.6f', $data[0]);
				}

				if($toCurrency != 'BTC' && $inCent) {
					if(!strpos($rounded, '.') !== false) {
						return $rounded . '00';
					} else if(strlen(substr(strrchr($rounded, '.'), 1)) == 2) {
						return str_replace('.', '', $rounded);
					} else if(strlen(substr(strrchr($rounded, '.'), 1)) == 1) {
						return str_replace('.', '', $rounded . '0');
					}
				} else if($toCurrency != 'BTC') {
					if(!strpos($rounded, '.') !== false) {
						return $rounded . '.00';
					} else if(strlen(substr(strrchr($rounded, '.'), 1)) == 1) {
						return str_replace('.', '', $rounded . '0');
					}
				}

				return $rounded;
			}
	    }
	}
