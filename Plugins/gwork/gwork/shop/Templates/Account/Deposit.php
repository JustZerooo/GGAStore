<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \Plugins\gwork\gwork\shop\Utils\CSRF\CSRF;
	use \Plugins\gwork\gwork\shop\Utils\Bitcoin\Bitcoin;

	use \Plugins\gwork\gwork\shop\Models\BitcoinTransaction\BitcoinTransactionFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$hideButton = !$this->hideButton->isNull() ? $this->hideButton->getValue() : false;
	$depositAmount = !$this->depositAmount->isNull() ? $this->depositAmount->getValue() : 1;

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$bitcoinTransactionFactory = $controller->getControllerParameters()->getModelsManager()->get(BitcoinTransactionFactory::class);

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();
?>
				<div class="box p-15">
					<h1 class="section-title"><?php echo $language['Account']['Deposit']['PageName']; ?></h1>
					<hr class="hr" />

					<?php
						if(!$hideButton) {
					?>
					<a href="<?php echo SITE_PATH; ?>/account/deposit/btc" class="btn"><?php echo $language['Account']['Deposit']['Bitcoin']['Button']; ?></a>
					<?php
						} else {
					?>
					<div class="alert alert-info">
						<?php echo str_replace(['%confirmations%'], [1], $language['Account']['Deposit']['Bitcoin']['ConfirmationsInfo']); ?>
					</div>

					<?php
						$bitcoin = new Bitcoin($settings->BitcoinUsername, $settings->BitcoinPassword, $settings->BitcoinHost, (int) $settings->BitcoinPort);

						$address = $bitcoin->getnewaddress();

						if(strlen($address) > 0) {
							$bitcoinTransaction = $bitcoinTransactionFactory->_create([
								'userid' 	=> $controller->getUser()->getRow()->id,
								'address' 	=> $address,
								'timestamp' => time(),
								'received' 	=> 0
							]);
						}
					?>

					<div class="btc-payment-box">
						<span><?php echo $language['Account']['Deposit']['Bitcoin']['Address']; ?></span><br />
						<span class="btc-address"><?php echo $address; ?></span>
						<a href="bitcoin:<?php echo $address; ?>" class="btn btc-open-wallet"><?php echo $language['Account']['Deposit']['Bitcoin']['OpenWallet']; ?></a>

						<div class="text-center">
							<img src="https://chart.googleapis.com/chart?chs=150x150&cht=qr&chl=<?php echo $address; ?>" />
						</div>
					</div>
					<?php
						}
					?>


					<!-- Coupon -->
					<?php
						if(!$hideButton) {
					?>
						<hr class="hr" />

						<h1 class="section-title"><?php echo $language['Account']['Deposit']['Coupon']['Title']; ?></h1>
						<hr class="hr" />

						<div class="form-width">
							<?php
								if(!$this->errorCoupon->isNull()) {
							?>
							<div class="alert alert-danger"><?php echo $this->errorCoupon->getValue(); ?></div>
							<?php
								}
							?>

							<?php
								if(!$this->successCoupon->isNull()) {
							?>
							<div class="alert alert-success"><?php echo $this->successCoupon->getValue(); ?></div>
							<?php
								}
							?>

							<?php
								if(!$this->infoCoupon->isNull()) {
							?>
							<div class="alert alert-info"><?php echo $this->infoCoupon->getValue(); ?></div>
							<?php
								}
							?>

							<form method="post" action="<?php echo SITE_PATH; ?>/account/deposit/coupon">
								<input type="hidden" name="csrf_token" value="<?php echo CSRF::getCSRFToken($controller); ?>" />

								<div class="form-group">
									<input type="text" class="form-control" value="<?php echo !$this->postCoupon->isNull() ? $this->postCoupon->getValue() : ''; ?>" name="coupon_code" placeholder="<?php echo $language['Account']['Deposit']['Coupon']['Code']['Placeholder']; ?>" />
								</div>

								<input type="submit" class="btn btn-default" name="coupon_use" value="<?php echo $language['Account']['Deposit']['Coupon']['Button']; ?>" />
								<input type="submit" class="btn btn-secondary" name="coupon_check" value="<?php echo $language['Account']['Deposit']['Coupon']['ButtonCheck']; ?>" />
							</form>
						</div>
					<?php
						}
					?>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
