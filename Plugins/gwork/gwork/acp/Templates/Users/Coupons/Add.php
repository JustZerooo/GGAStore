<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$postCode = !$this->postCode->isNull() ? $this->postCode->getValue() : '';
	$postValue = !$this->postValue->isNull() ? $this->postValue->getValue() : '';
	$postType = !$this->postType->isNull() ? $this->postType->getValue() : 'balance';
	$postMaxUsable = !$this->postMaxUsable->isNull() ? $this->postMaxUsable->getValue() : 1;
	$postUsed = !$this->postUsed->isNull() ? $this->postUsed->getValue() : 0;
?>

			<section class="panel panel-default">
				<div class="wrapper">
					<div class="row">
						<div class="padder">
							<h3><?php echo $language['Users']['Coupons']['Add']['Title']; ?></h3>
							
							<div class="row">
								<div class="col-sm-12 col-md-6">
									<form method="POST">
										<div class="form-group">
											<span><?php echo $language['Users']['Coupons']['Add']['Code']; ?></span>
											<input type="text" name="coupon_code" class="form-control" value="<?php echo htmlspecialchars($postCode); ?>" />
										</div>
										<div class="form-group">
											<span><?php echo $language['Users']['Coupons']['Add']['Value']; ?></span>
											<input type="text" name="coupon_value" class="form-control" value="<?php echo htmlspecialchars($postValue); ?>" />
										</div>
										<div class="form-group">
											<span><?php echo $language['Users']['Coupons']['Add']['Type']; ?></span>
											<select class="form-control" name="coupon_type">
												<option value="balance"><?php echo $language['Users']['Coupons']['Add']['Balance']; ?></option>
											</select>
										</div>
										<div class="form-group">
											<span><?php echo $language['Users']['Coupons']['Add']['MaxUsable']; ?></span>
											<input type="number" name="coupon_max_usable" class="form-control" value="<?php echo htmlspecialchars($postMaxUsable); ?>" />
										</div>
										<div class="form-group">
											<span><?php echo $language['Users']['Coupons']['Add']['Used']; ?></span>
											<input type="number" name="coupon_used" class="form-control" value="<?php echo htmlspecialchars($postUsed); ?>" />
										</div>
										
										<input type="submit" class="btn btn-primary" value="<?php echo $language['Users']['Coupons']['Add']['Submit']; ?>" />
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
