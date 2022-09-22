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

	$productItem = !$this->productItem->isNull() ? $this->productItem->getValue() : null;
?>

				<section class="panel panel-default">
					<header class="panel-heading">
						<?php echo $language['Catalog']['Products']['Items']['Edit']['PageName']; ?>
					</header>
					
					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<a href="<?php echo SITE_PATH; ?>/admin/catalog/products/items/delete/<?php echo $productItem->getRow()->id; ?>" class="btn btn-danger">
								<i class="i i-trashcan"></i>
								<?php echo $language['Catalog']['Products']['Items']['Edit']['Delete']; ?>
							</a>
							
							<hr />
							
							<?php
								if(!$this->errorMessage->isNull()) {
							?>
							<div class="alert alert-danger"><?php echo $this->errorMessage->getValue(); ?></div>
							<?php
								}
							?>
							
							<?php
								if(!$this->successMessage->isNull()) {
							?>
							<div class="alert alert-success"><?php echo $this->successMessage->getValue(); ?></div>
							<?php
								}
							?>
							
							<form method="post" action="<?php echo SITE_PATH; ?>/admin/catalog/products/items/edit/<?php echo $productItem->getRow()->id; ?>">
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Items']['Edit']['Content']; ?></span>
									</label>
									<textarea name="product_item_content" class="form-control noresize"><?php echo htmlspecialchars($productItem->getRow()->content); ?></textarea>
								</div>
								
								<input type="submit" class="btn btn-primary" value="<?php echo $language['Catalog']['Products']['Edit']['Save']; ?>" />
							</form>
						</div>
					</div>
				</section>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
