<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;
	use \Plugins\gwork\gwork\shop\Models\Coupon\CouponFactory;
	use \GWork\System\Models\User\UserFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$couponFactory = $controller->getControllerParameters()->getModelsManager()->get(CouponFactory::class);
	$userFactory = $controller->getControllerParameters()->getModelsManager()->get(UserFactory::class);

	$coupons = $couponFactory->getAll(false, null, 'id', OrderTypes::DESC);
?>

			<section class="panel panel-default">
				<form method="post" action="<?php echo SITE_PATH; ?>/admin/users/coupons/form">
					<header class="panel-heading">
						<?php echo $language['Users']['Coupons']['List']['PageName']; ?>
					</header>
					
					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<a href="<?php echo SITE_PATH; ?>/admin/users/coupons/add" class="btn btn-primary">
								<?php echo $language['Users']['Coupons']['List']['Add']; ?>
							</a>
						</div>
					</div>

					<?php
						if(count($coupons) > 0) {
					?>
					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<select name="action" class="input-sm form-control input-s-sm inline v-middle">
								<option><?php echo $language['Users']['Coupons']['List']['Menu']['Choose']; ?></option>
								<option value="delete"><?php echo $language['Users']['Coupons']['List']['Menu']['Delete']; ?></option>
							</select>
							<button type="submit" class="btn btn-sm btn-default"><?php echo $language['Users']['Coupons']['List']['Menu']['Submit']; ?></button>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped b-t b-light data-table">
							<thead>
								<tr>
									<th width="20">
										<label class="checkbox m-n i-checks">
											<input type="checkbox" /><i></i>
										</label>
									</th>
									<th><?php echo $language['Users']['Coupons']['List']['Table']['Code']; ?></th>
									<th><?php echo $language['Users']['Coupons']['List']['Table']['Value']; ?></th>
									<th><?php echo $language['Users']['Coupons']['List']['Table']['Type']; ?></th>
									<th><?php echo $language['Users']['Coupons']['List']['Table']['Used']; ?></th>
									<th width="30"></th>
									<th width="30"></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($coupons as $coupon) {
								?>
								<tr>
									<td>
										<label class="checkbox m-n i-checks">
											<input type="checkbox" name="coupons[]" value="<?php echo $coupon->getRow()->id; ?>" /><i></i>
										</label>
									</td>
									<td><?php echo htmlspecialchars($coupon->getRow()->code); ?></td>
									<td><?php echo htmlspecialchars($coupon->getRow()->value); ?></td>
									<td><?php echo htmlspecialchars($coupon->getRow()->type); ?></td>
									<td><?php echo htmlspecialchars($coupon->getRow()->used) . '/' . htmlspecialchars($coupon->getRow()->max_usable); ?></td>
									<td>
										<a href="<?php echo SITE_PATH; ?>/admin/users/coupons/edit/<?php echo $coupon->getRow()->id; ?>">
											<i class="i i-pencil text-primary"></i>
										</a>
									</td>
									<td>
										<a href="<?php echo SITE_PATH; ?>/admin/users/coupons/delete/<?php echo $coupon->getRow()->id; ?>">
											<i class="i i-trashcan text-primary"></i>
										</a>
									</td>
								</tr>
								<?php
									}
								?>
							</tbody>
						</table>
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-sm-4 hidden-xs">
								<select name="action2" class="input-sm form-control input-s-sm inline v-middle">
									<option><?php echo $language['Users']['Coupons']['List']['Menu']['Choose']; ?></option>
									<option value="delete"><?php echo $language['Users']['Coupons']['List']['Menu']['Delete']; ?></option>
								</select>
								<button type="submit" class="btn btn-sm btn-default"><?php echo $language['Users']['Coupons']['List']['Menu']['Submit']; ?></button>
							</div>
						</div>
					</footer>
					<?php
						}
					?>
				</form>
			</section>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
