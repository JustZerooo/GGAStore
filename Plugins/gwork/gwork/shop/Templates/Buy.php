<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \Plugins\gwork\gwork\shop\Models\Product\ProductFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$amount = !$this->amount->isNull() ? $this->amount->getValue() : null;
	$product = !$this->product->isNull() ? $this->product->getValue() : null;
	$total = !$this->total->isNull() ? $this->total->getValue() : null;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();
?>
				<div class="box">
					<?php
						if(!$this->errorMessage->isNull()) {
					?>
					<div class="p-15">
						<div class="alert alert-danger">
							<p>
								<?php echo htmlspecialchars($this->errorMessage->getValue()); ?>
							</p>
						</div>
					</div>
					<?php
						}
					?>

					<div class="hidden-mobile">
						<form action="<?php echo SITE_PATH; ?>/buy/submit" method="post">
							<input type="hidden" name="product_id" value="<?php echo $product->getRow()->id; ?>" />
							<input type="hidden" name="product_amount" value="<?php echo intval($amount); ?>" />

							<table class="table table-rspv table-cart">
								<thead>
									<tr>
										<th></th>
										<th>
											<h3 class="cart-title"><?php echo $language['Buy']['PageName']; ?></h3>
										</th>
										<th></th>
										<th></th>
										<th></th>
										<th></th>
									</tr>
									<tr>
										<th></th>
										<th><?php echo $language['Buy']['Product']; ?></th>
										<th><?php echo $language['Buy']['Price']; ?></th>
										<th class="text-right"><?php echo $language['Buy']['Amount']; ?></th>
										<th class="text-right"><?php echo $language['Buy']['Total']; ?></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									<tr>
										<td></td>
										<td>
											<div class="cart-product-name">
												<a target="_product" href="<?php echo SITE_PATH; ?>/product/<?php echo $product->getRow()->id; ?>" class="cart-link">
													<?php echo htmlspecialchars($product->getRow()->title); ?>
												</a>
											</div>
										</td>
										<td>
											<?php echo number_format(intval($product->getRow()->price)/100, 2, ',', '.'); ?>
											<?php echo strtoupper($settings->Currency); ?>
										</td>
										<td class="text-right"><?php echo intval($amount); ?></td>
										<td class="text-right">
											<?php echo number_format(intval($product->getRow()->price*intval($amount))/100, 2, ',', '.'); ?>
											<?php echo strtoupper($settings->Currency); ?>
										</td>
										<td></td>
									</tr>
								</tbody>
								<tfoot>
									<tr>
										<td></td>
										<td></td>
										<td></td>
										<td></td>
										<td class="text-right">
											<b>
												<?php echo number_format(intval($total)/100, 2, ',', '.'); ?>
												<?php echo strtoupper($settings->Currency); ?>
											</b>
											<input type="submit" class="btn btn-block margin-top" value="<?php echo htmlspecialchars($language['Buy']['Button']); ?>" />
										</td>
										<td></td>
									</tr>
								</tfoot>
							</table>
						</form>
					</div>

					<div class="hidden-desktop">
						<form action="<?php echo SITE_PATH; ?>/buy/submit" method="post">
							<input type="hidden" name="product_id" value="<?php echo $product->getRow()->id; ?>" />
							<input type="hidden" name="product_amount" value="<?php echo intval($amount); ?>" />

							<ul class="list-cart">
								<li>
									<h3 class="cart-title"><?php echo $language['Buy']['PageName']; ?></h3>
								</li>
								<li>
									<div class="cart-product-name">
										<a target="_product" href="<?php echo SITE_PATH; ?>/product/<?php echo $product->getRow()->id; ?>" class="cart-link">
											<?php echo htmlspecialchars($product->getRow()->title); ?>
										</a>
									</div>
									<div class="cart-info">
										<span class="cart-info-cell"><?php echo $language['Buy']['Price']; ?></span>
										<?php echo number_format(intval($product->getRow()->price)/100, 2, ',', '.'); ?>
										<?php echo strtoupper($settings->Currency); ?>
									</div>
									<div class="cart-info">
										<span class="cart-info-cell"><?php echo $language['Buy']['Amount']; ?></span>
										<?php echo intval($amount); ?>
									</div>
									<div class="cart-info">
										<span class="cart-info-cell"><?php echo $language['Buy']['Total']; ?></span>
										<?php echo number_format(intval($product->getRow()->price*intval($amount))/100, 2, ',', '.'); ?>
										<?php echo strtoupper($settings->Currency); ?>
									</div>
								</li>
								<li>
									<span class="cart-info-cell"><?php echo $language['Buy']['Total']; ?></span>
									<?php echo number_format(intval($product->getRow()->price*intval($amount))/100, 2, ',', '.'); ?>
									<?php echo strtoupper($settings->Currency); ?>

									<input type="submit" class="btn btn-block margin-top" value="<?php echo htmlspecialchars($language['Buy']['Button']); ?>" />
								</li>
							</ul>
						</form>
					</div>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
