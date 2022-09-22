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

	$product = !$this->product->isNull() ? $this->product->getValue() : null;

	$postContent = !$this->postContent->isNull() ? $this->postContent->getValue() : '';
?>

				<section class="panel panel-default">
					<header class="panel-heading">
						<?php echo $language['Catalog']['Products']['Items']['Add']['PageName']; ?>
					</header>

					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<?php
								if(!$this->errorMessage->isNull()) {
							?>
							<div class="alert alert-danger"><?php echo $this->errorMessage->getValue(); ?></div>
							<?php
								}
							?>

							<form method="post" action="<?php echo SITE_PATH; ?>/admin/catalog/products/items/add/<?php echo $product->getRow()->id; ?>">
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Items']['Add']['Content']; ?></span>
									</label>
									<textarea name="product_item_content" class="form-control noresize"><?php echo htmlspecialchars($postContent); ?></textarea>
								</div>

								<div class="form-group">
									<label>
										<input type="radio" name="product_item_format" value="1" checked />
										<span><?php echo $language['Catalog']['Products']['Items']['Add']['Format1']; ?></span>
									</label>
								</div>

								<div class="form-group">
									<label>
										<input type="radio" name="product_item_format" value="2" />
										<span><?php echo $language['Catalog']['Products']['Items']['Add']['Format2']; ?></span>
									</label>
									<input type="text" name="product_item_seperator" class="form-control" placeholder="<?php echo $language['Catalog']['Products']['Items']['Add']['Seperator']; ?>" />
								</div>

								<div class="form-group">
									<label>
										<input type="radio" name="product_item_format" value="3" />
										<span><?php echo $language['Catalog']['Products']['Items']['Add']['Format3']; ?></span>
									</label>
								</div>

								<input type="submit" class="btn btn-primary" value="<?php echo $language['Catalog']['Products']['Items']['Add']['Add']; ?>" />
							</form>
						</div>
					</div>
				</section>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
