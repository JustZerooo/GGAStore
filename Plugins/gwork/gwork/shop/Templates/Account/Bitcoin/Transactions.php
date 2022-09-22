<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;

	use \Plugins\gwork\gwork\shop\Models\BitcoinTransaction\BitcoinTransactionFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$bitcoinTransactionFactory = $controller->getControllerParameters()->getModelsManager()->get(BitcoinTransactionFactory::class);

	$limit = 25;
	
	$bitcoinTransactions = $bitcoinTransactionFactory->getAllByColumns(['userid', 'received'], [intval($controller->getUser()->getRow()->id), 1], ['AND'], false, $limit, 'timestamp', OrderTypes::DESC, ['=', '=']);
?>
				<div class="alert alert-info">
					<div class="ion ion-ios-information"></div>
					<p>
						<?php echo str_replace('%amount%', $limit, $language['Account']['BTC']['Transactions']['Info']); ?>
					</p>
				</div>

				<div class="box p-15">
					<h1 class="section-title"><?php echo $language['Account']['BTC']['Transactions']['PageName']; ?></h1>
					<hr class="hr" />

						<?php
							if(count($bitcoinTransactions) > 0) {
								foreach($bitcoinTransactions as $bitcoinTransaction) {
						?>
						<div class="btc-transaction-box">
							<div class="pull-left">
								<span>
									<?php echo date('d.m.Y H:i', $bitcoinTransaction->getRow()->timestamp); ?>
								</span>
							</div>
							<div class="pull-right">
								<?php
									if($bitcoinTransaction->getRow()->confirmed == 1) {
								?>
								<span class="label label-success inline-block"><?php echo $language['Account']['BTC']['Transactions']['Status']['Completed']; ?></span>
								<?php
									} else {
								?>
								<span class="label label-primary inline-block"><?php echo $language['Account']['BTC']['Transactions']['Status']['Pending']; ?></span>
								<?php
									}
								?>
							</div>
							<div class="clearfix"></div>
							
							<span class="btc-tx-info">
								<i class="ion ion-social-bitcoin"></i>
								<?php echo htmlspecialchars($bitcoinTransaction->getRow()->amount); ?>
								
								<a href="https://blockchain.info/tx/<?php echo htmlspecialchars($bitcoinTransaction->getRow()->txid); ?>" target="_tx_<?php echo $bitcoinTransaction->getRow()->id; ?>" class="btn btc-open-tx"><?php echo $language['Account']['BTC']['Transactions']['OpenTX']; ?></a>
							</span>
						</div>
						
						<hr class="hr hr-small" />
						<?php
								}
							} else {
						?>
						<div class="alert alert-danger">
							<p>
								<?php echo $language['Account']['BTC']['Transactions']['NoTransactions']; ?>
							</p>
						</div>
						<?php
							}
						?>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
