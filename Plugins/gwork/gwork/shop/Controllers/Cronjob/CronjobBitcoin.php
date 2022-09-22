<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\shop\Controllers\Cronjob {
	    use GWork\System\Utils\Routing\Interfaces\IRoute;
	    use GWork\System\Utils\Routing\Route;

		use GWork\System\Patterns\MVC\Controllers\Controller;
		use GWork\System\Models\User\UserFactory;

		use GWork\System\Models\Settings\SettingsFactory;
		use \Plugins\gwork\gwork\shop\Utils\Bitcoin\Bitcoin;
		use \Plugins\gwork\gwork\shop\Models\BitcoinTransaction\BitcoinTransactionFactory;

		use \Plugins\gwork\gwork\shop\Plugin;

	    final class CronjobBitcoin extends Controller implements IRoute {
			const PLUGIN_PACKAGE = 'gwork.gwork.shop';

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::onCall()
			 */
	        public function onCall(Route $route, array $vars) {
				if($route->getName() == 'cronjob-bitcoin') {
					$settings = $this->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);

					$bitcoinTransactionFactory = $this->getControllerParameters()->getModelsManager()->get(BitcoinTransactionFactory::class);
					$userFactory = $this->getControllerParameters()->getModelsManager()->get(UserFactory::class);

					$bitcoin = new Bitcoin($settings->BitcoinUsername, $settings->BitcoinPassword, $settings->BitcoinHost, (int) $settings->BitcoinPort);

					$bitcoinTransactions = $bitcoin->listtransactions();

					foreach($bitcoinTransactions as $bitcoinTransaction) {
						$transaction = $bitcoinTransactionFactory->getByColumn('address', $bitcoinTransaction['address']);

						if($transaction != null && $transaction->getRow()->confirmed == 0) {
							$transaction->set('txid', $bitcoinTransaction['txid']);
							$transaction->set('amount', sprintf('%.6f', $bitcoinTransaction['amount']));
							$transaction->set('received', 1);

							if($bitcoinTransaction['confirmations'] >= 1) {
								$transaction->set('confirmed', 1);

								$amount = Plugin::convertCurrency(sprintf('%.6f', $bitcoinTransaction['amount']), 'BTC', strtoupper($settings->Currency), true);

								$payer = $userFactory->getByColumn('id', $transaction->getRow()->userid);
								if($payer == null) continue;

								$balance = $payer->getRow()->balance;
								$balance += $amount;
								
								/* START BONUS */
								$bonusEnabled = false; // true = aktiviert | false = deaktiviert
								
								if($bonusEnabled) {
									$bonus = 0; // Bonus ist anfangs 0
									
									// Das größte muss immer unter dem niedrigeren Preis stehen
									// zB 200 unter 100 und 50 unter 100
									$bonusData = [
										100 => 0.15, 	// ab 100 Euro = 15%
										50 	=> 0.10, 	// ab 100 Euro = 10%
										25	=> 0.07, 	// ab 100 Euro = 7%
										10	=> 0.05 	// ab 100 Euro = 5%
									];
									
									foreach($bonusData as $minimum => $percent) {
										// Wenn eingezahlter Betrag (amount) größer oder gleich der benötigte Betrag ist
										if($amount >= ($minimum*100)) {
											// Wird der Bonus mit dem eingezahlten Betrag mit dem Bonus Prozent multipliziert
											$bonus = $amount * $percent;
											break;
										}
									}

									// Kontostand kriegt Bonus
									$balance += $bonus;
								}
								/* END BONUS */
								
								$payer->set('balance', $balance);
							}
						}
					}
				}
	        }

			/**
			 * @see GWork\System\Utils\Routing\Interfaces\IRoute::getRoutes()
			 */
	        public function getRoutes(): array {
	            return [
		            new Route('/cronjob/bitcoin', $this, 'cronjob-bitcoin', true)
	            ];
	        }
	    }

		return __NAMESPACE__;
	}
