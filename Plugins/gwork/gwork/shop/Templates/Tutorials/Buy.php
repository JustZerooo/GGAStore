<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;

	use \Plugins\gwork\gwork\shop\Models\Article\ArticleFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;
	
	$errorMessage = !$this->errorMessage->isNull() ? $this->errorMessage->getValue() : null;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();
?>
				<div class="box p-15">
					<h1 class="section-title"><?php echo $language['Tutorials']['PageName']; ?></h1>
					<hr class="hr" />

					<div class="form-width">
						<div class="alert alert-info alert-border">
							<?php echo $language['Tutorials']['AccessInfo']; ?>
						</div>
						
						<?php
							if($errorMessage) {
						?>
						<div class="alert alert-danger alert-border">
							<?php echo $errorMessage; ?>
						</div>
						<?php
							}
						?>
							
						<div class="btc-payment-box">
							<form method="POST">
								<input type="submit" class="btn btn-block" name="buy_tutorials_rank" value="<?php echo $language['Tutorials']['BuyButton']; ?>" />
							</form>
								
							<span class="btc-address no-break no-margin">
								<?php echo $language['Tutorials']['BuyInfo']; ?>
							</span>
						</div>
					</div>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
