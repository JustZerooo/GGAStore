<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \Plugins\gwork\gwork\shop\Models\ProductItem\ProductItemFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$productItemFactory = $controller->getControllerParameters()->getModelsManager()->get(ProductItemFactory::class);

	$product = !$this->product->isNull() ? $this->product->getValue() : null;
	
	$productItems = $productItemFactory->getAllByColumn('product_id', $product->getRow()->id);
?>

			<section class="panel panel-default">
				<form method="post" action="<?php echo SITE_PATH; ?>/admin/catalog/products/items/form/<?php echo $product->getRow()->id; ?>">
					<header class="panel-heading">
						<?php echo str_replace('%productName%', htmlspecialchars($product->getRow()->title), $language['Catalog']['Products']['Items']['List']['PageName']); ?>
					</header>
					
					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<a href="<?php echo SITE_PATH; ?>/admin/catalog/products" class="btn btn-danger">
								<?php echo $language['Catalog']['Products']['Items']['List']['Back']; ?>
							</a>
							
							<a href="<?php echo SITE_PATH; ?>/admin/catalog/products/items/add/<?php echo $product->getRow()->id; ?>" class="btn btn-primary">
								<?php echo $language['Catalog']['Products']['Items']['List']['Add']; ?>
							</a>
						</div>
					</div>
					
					<?php
						if(count($productItems) > 0) {
					?>
					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<select name="action" class="input-sm form-control input-s-sm inline v-middle">
								<option><?php echo $language['Catalog']['Products']['Items']['List']['Menu']['Choose']; ?></option>
								<option value="delete"><?php echo $language['Catalog']['Products']['Items']['List']['Menu']['Delete']; ?></option>
							</select>
							<button type="submit" class="btn btn-sm btn-default"><?php echo $language['Catalog']['Products']['Items']['List']['Menu']['Submit']; ?></button>                
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
									<th><?php echo $language['Catalog']['Products']['Items']['List']['Table']['Content']; ?></th>
									<th width="30"></th>
									<th width="30"></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($productItems as $productItem) {
								?>
								<tr>
									<td>
										<label class="checkbox m-n i-checks">
											<input type="checkbox" name="productItems[]" value="<?php echo $productItem->getRow()->id; ?>" /><i></i>
										</label>
									</td>
									<td>
										<?php
											echo substr(htmlspecialchars($productItem->getRow()->content), 0, 100);
											if(strlen(htmlspecialchars($productItem->getRow()->content)) > 100) {
												echo '...';
											}
										?>
									</td>
									<td>
										<a href="<?php echo SITE_PATH; ?>/admin/catalog/products/items/edit/<?php echo $productItem->getRow()->id; ?>">
											<i class="i i-pencil text-primary"></i>
										</a>
									</td>
									<td>
										<a href="<?php echo SITE_PATH; ?>/admin/catalog/products/items/delete/<?php echo $productItem->getRow()->id; ?>">
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
									<option><?php echo $language['Catalog']['Products']['Items']['List']['Menu']['Choose']; ?></option>
									<option value="delete"><?php echo $language['Catalog']['Products']['Items']['List']['Menu']['Delete']; ?></option>
								</select>
								<button type="submit" class="btn btn-sm btn-default"><?php echo $language['Catalog']['Products']['Items']['List']['Menu']['Submit']; ?></button>                
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
