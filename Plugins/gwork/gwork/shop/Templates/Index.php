<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;

	use \GWork\System\Helpers\OrderTypes\OrderTypes;
	use \Plugins\gwork\gwork\shop\Models\Product\ProductFactory;
	use \Plugins\gwork\gwork\shop\Models\ProductItem\ProductItemFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$productFactory = $controller->getControllerParameters()->getModelsManager()->get(ProductFactory::class);
	$productItemFactory = $controller->getControllerParameters()->getModelsManager()->get(ProductItemFactory::class);
?>
				<h2 class="page-title"><?php echo $language['Index']['LastProducts']; ?></h2>
				<div class="row">
					<?php
						$products = $productFactory->getAll(false, 20, 'id', OrderTypes::DESC);

						$configuration = $controller->getControllerParameters()->getApplication()->getConfiguration();

						foreach($products as $product) {
							$productAvailability = $productItemFactory->getRowCountByColumn('product_id', $product->getRow()->id, 10);
							$productImage = $configuration->getUploadPaths()->products . htmlspecialchars($product->getRow()->image);

							if(strlen($product->getRow()->image) <= 0 || !file_exists($configuration->getPaths()->phpPath . $productImage)) {
								$productImage = WEB_PATH . '/' . $settings->Style . '/assets/images/product.png';
							} else {
								$productImage = SITE_PATH . $productImage;
							}
					?>
					<div class="col-lg-3 col-md-4 col-xs-12">
						<div class="product-item">
							<div class="image-container">
								<img src="<?php echo $productImage; ?>" class="image" />
							</div>
							<div class="product-desc">
								<h3><?php echo htmlspecialchars($product->getRow()->title); ?></h3>
								<p>
									<?php echo substr(htmlspecialchars($product->getRow()->short_description), 0, 100); if(strlen($product->getRow()->short_description) > 100) echo '...'; ?>
								</p>
							</div>
							
							<form action="<?php echo SITE_PATH; ?>/buy" method="post">
								<input type="hidden" name="product_id" value="<?php echo $product->getRow()->id; ?>" />
								<div class="row p-left-right-15">
									<div class="col-xs-4 col-lg-4 only-p-right">
										<div class="form-control">
											<?php echo number_format(intval($product->getRow()->price)/100, 2, ',', '.'); ?>
										</div>
									</div>
									<div class="col-xs-8 col-lg-8 only-p-left">
										<select name="product_amount" class="form-control"<?php if($productAvailability <= 0) { ?> readonly disabled<?php } ?>>
											<?php
												if($productAvailability > 0) {
											?>
											<?php
												for($amount = 1; $amount < ($productAvailability + 1); $amount++) {
											?>
											<option value="<?php echo $amount; ?>"><?php echo htmlspecialchars(str_replace('%amount%', $amount, $language['Index']['Amount'])); ?></option>
											<?php
												}
											?>

											<?php
												} else {
											?>
											<option value="0"><?php echo htmlspecialchars($language['Index']['SoldOut']); ?></option>
											<?php
												}
											?>
										</select>
									</div>
								</div>

								<div class="row p-left-right-15 margin-top">
									<div class="col-xs-4 col-lg-4 only-p-right">
										<button type="submit" class="btn btn-block"<?php if($productAvailability <= 0) { ?> disabled<?php } ?>>
											<i class="ion ion-ios-cart"></i>
										</button>
									</div>
									<div class="col-xs-8 col-lg-8 only-p-left">
										<a href="<?php echo SITE_PATH; ?>/product/<?php echo $product->getRow()->id; ?>" class="btn btn-secondary btn-block">
											<?php echo $language['Index']['MoreInfos']; ?>
										</a>
									</div>
								</div>
							</form>
						</div>
					</div>
					<?php
						}
					?>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
