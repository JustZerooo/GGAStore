<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \Plugins\gwork\gwork\shop\Models\Product\ProductFactory;
	use \Plugins\gwork\gwork\shop\Models\ProductItem\ProductItemFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$productItemFactory = $controller->getControllerParameters()->getModelsManager()->get(ProductItemFactory::class);
	$productFactory = $controller->getControllerParameters()->getModelsManager()->get(ProductFactory::class);

	$products = $productFactory->getAll();
?>

			<section class="panel panel-default">
				<form method="post" action="<?php echo SITE_PATH; ?>/admin/catalog/products/form">
					<header class="panel-heading">
						<?php echo $language['Catalog']['Products']['List']['PageName']; ?>
					</header>

					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<a href="<?php echo SITE_PATH; ?>/admin/catalog/products/add" class="btn btn-primary">
								<?php echo $language['Catalog']['Products']['List']['Add']; ?>
							</a>
						</div>
					</div>

					<?php
						if(count($products) > 0) {
					?>
					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<select name="action" class="input-sm form-control input-s-sm inline v-middle">
								<option><?php echo $language['Catalog']['Products']['List']['Menu']['Choose']; ?></option>
								<option value="delete"><?php echo $language['Catalog']['Products']['List']['Menu']['Delete']; ?></option>
							</select>
							<button type="submit" class="btn btn-sm btn-default"><?php echo $language['Catalog']['Products']['List']['Menu']['Submit']; ?></button>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped b-t b-light">
							<thead>
								<tr>
									<th width="20">
										<label class="checkbox m-n i-checks">
											<input type="checkbox" /><i></i>
										</label>
									</th>
									<th><?php echo $language['Catalog']['Products']['List']['Table']['Title']; ?></th>
									<th><?php echo $language['Catalog']['Products']['List']['Table']['Availability']; ?></th>
									<th><?php echo $language['Catalog']['Products']['List']['Table']['Price']; ?></th>
									<th width="30"></th>
									<th width="30"></th>
									<th width="30"></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($products as $product) {
								?>
								<tr>
									<td>
										<label class="checkbox m-n i-checks">
											<input type="checkbox" name="products[]" value="<?php echo $product->getRow()->id; ?>" /><i></i>
										</label>
									</td>
									<td><?php echo htmlspecialchars($product->getRow()->title); ?></td>
									<td>
										<?php
											if(strtolower($product->getRow()->unlimited) == 'true') {
												echo '<span class="label label-info">' . $language['Catalog']['Products']['List']['Table']['Unlimited'] . '</span>';
											} else {
												$productAvailability = $productItemFactory->getRowCountByColumn('product_id', $product->getRow()->id);

												if($productAvailability <= 0) {
													echo '<span class="label label-danger">' . $productAvailability . '</span>';
												} else if($productAvailability < 10) {
													echo '<span class="label label-warning">' . $productAvailability . '</span>';
												} else {
													echo '<span class="label label-success">' . $productAvailability . '</span>';
												}
											}
										?>
									</td>
									<td><?php echo number_format(intval($product->getRow()->price)/100, 2, ',', '.'); ?> <?php echo strtoupper($settings->Currency); ?></td>
									<td>
										<?php
											if(strtolower($product->getRow()->unlimited) == 'true') {
										?>
										<a href="<?php echo SITE_PATH; ?>/admin/catalog/products/edit/<?php echo $product->getRow()->id; ?>">
											<i class="i i-data text-primary"></i>
										</a>
										<?php
											} else {
										?>
										<a href="<?php echo SITE_PATH; ?>/admin/catalog/products/items/<?php echo $product->getRow()->id; ?>">
											<i class="i i-data text-primary"></i>
										</a>
										<?php
											}
										?>
									</td>
									<td>
										<a href="<?php echo SITE_PATH; ?>/admin/catalog/products/edit/<?php echo $product->getRow()->id; ?>">
											<i class="i i-pencil text-primary"></i>
										</a>
									</td>
									<td>
										<a href="<?php echo SITE_PATH; ?>/admin/catalog/products/delete/<?php echo $product->getRow()->id; ?>">
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
									<option><?php echo $language['Catalog']['Products']['List']['Menu']['Choose']; ?></option>
									<option value="delete"><?php echo $language['Catalog']['Products']['List']['Menu']['Delete']; ?></option>
								</select>
								<button type="submit" class="btn btn-sm btn-default"><?php echo $language['Catalog']['Products']['List']['Menu']['Submit']; ?></button>
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
