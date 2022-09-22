<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;
	use \Plugins\gwork\gwork\shop\Models\CouponLog\CouponLogFactory;
	use \GWork\System\Models\User\UserFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$userFactory = $controller->getControllerParameters()->getModelsManager()->get(UserFactory::class);
	$couponLogFactory = $controller->getControllerParameters()->getModelsManager()->get(CouponLogFactory::class);

	$coupon = $this->coupon->getValue();

	$couponLogs = $couponLogFactory->getAllByColumn('couponid', $coupon->getRow()->id, false, 0, '=', 'timestamp', OrderTypes::DESC);

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
							<h3><?php echo $language['Users']['Coupons']['Edit']['Title']; ?></h3>
							
							<div class="row">
								<div class="col-sm-12 col-md-6">
									<form method="POST">
										<div class="form-group">
											<span><?php echo $language['Users']['Coupons']['Edit']['Code']; ?></span>
											<input type="text" name="coupon_code" class="form-control" value="<?php echo htmlspecialchars($coupon->getRow()->code); ?>" />
										</div>
										<div class="form-group">
											<span><?php echo $language['Users']['Coupons']['Edit']['Value']; ?></span>
											<input type="text" name="coupon_value" class="form-control" value="<?php echo htmlspecialchars($coupon->getRow()->value); ?>" />
										</div>
										<div class="form-group">
											<span><?php echo $language['Users']['Coupons']['Edit']['Type']; ?></span>
											<select class="form-control" name="coupon_type">
												<option value="balance"><?php echo $language['Users']['Coupons']['Edit']['Balance']; ?></option>
											</select>
										</div>
										<div class="form-group">
											<span><?php echo $language['Users']['Coupons']['Edit']['MaxUsable']; ?></span>
											<input type="number" name="coupon_max_usable" class="form-control" value="<?php echo htmlspecialchars($coupon->getRow()->max_usable); ?>" />
										</div>
										<div class="form-group">
											<span><?php echo $language['Users']['Coupons']['Edit']['Used']; ?></span>
											<input type="number" name="coupon_used" class="form-control" value="<?php echo htmlspecialchars($coupon->getRow()->used); ?>" />
										</div>
										
										<input type="submit" class="btn btn-primary" value="<?php echo $language['Users']['Coupons']['Edit']['Submit']; ?>" />
									</form>
								</div>
							</div>
						</div>
						
						<hr />
						
						<div class="padder">
							<h3><?php echo $language['Users']['Coupons']['Edit']['Logs']['Used']; ?></h3>
						</div>
						
						<table class="table">
							<thead>
								<tr>
									<th><?php echo $language['Users']['Coupons']['Edit']['Logs']['User']; ?></th>
									<th><?php echo $language['Users']['Coupons']['Edit']['Logs']['Timestamp']; ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($couponLogs as $couponLog) {
										$user = $userFactory->getByColumn('id', $couponLog->getRow()->userid);
										if($user == null) continue;
								?>
								<tr>
									<td><?php echo htmlspecialchars($user->getRow()->username); ?></td>
									<td><?php echo date('d.m.Y H:i', $couponLog->getRow()->timestamp); ?></td>
								</tr>
								<?php
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</section>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
