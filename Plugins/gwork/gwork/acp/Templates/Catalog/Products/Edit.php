<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \Plugins\gwork\gwork\shop\Models\Category\CategoryFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();
	
	$categoryFactory = $controller->getControllerParameters()->getModelsManager()->get(CategoryFactory::class);

	$product = !$this->product->isNull() ? $this->product->getValue() : null;
?>

				<section class="panel panel-default">
					<header class="panel-heading">
						<?php echo $language['Catalog']['Products']['Edit']['PageName']; ?>
					</header>

					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<a href="<?php echo SITE_PATH; ?>/admin/catalog/products/delete/<?php echo $product->getRow()->id; ?>" class="btn btn-danger">
								<i class="i i-trashcan"></i>
								<?php echo $language['Catalog']['Products']['Edit']['Delete']; ?>
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

							<form method="post" action="<?php echo SITE_PATH; ?>/admin/catalog/products/edit/<?php echo $product->getRow()->id; ?>" enctype="multipart/form-data">
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Edit']['Image']; ?></span>
									</label>
									<input type="file" name="product_image" class="file-loading" />
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Edit']['ImageSelect']; ?> <?php echo $language['Optional']; ?></span>
									</label>
									<select name="product_img_select" class="form-control">
										<option value="0"><?php echo $language['Catalog']['Products']['Edit']['Choose']; ?></option>
										<?php
											$configuration = $controller->getControllerParameters()->getApplication()->getConfiguration();
											
											$imgsPath = scandir(SYS_PATH . $configuration->getUploadPaths()->products);
											foreach($imgsPath as $fileName) {
												if($fileName == '.' || $fileName == '..') continue;
										?>
										<option value="<?php echo $fileName; ?>" <?php if($product->getRow()->image == $fileName) { echo 'selected'; } ?>><?php echo htmlspecialchars($fileName); ?></option>
										<?php
											}
										?>
									</select>
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Edit']['Title']; ?></span>
									</label>
									<input type="text" name="product_title" value="<?php echo htmlspecialchars($product->getRow()->title); ?>" class="form-control" />
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Edit']['InfoTag']; ?></span>
									</label>
									<input type="text" name="product_info_tag" value="<?php echo htmlspecialchars($product->getRow()->info_tag); ?>" class="form-control" />
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Edit']['ShortDescription']; ?></span>
									</label>
									<textarea name="product_short_description" class="form-control noresize"><?php echo htmlspecialchars($product->getRow()->short_description); ?></textarea>
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Edit']['Description']; ?></span>
									</label>
									<textarea name="product_description" class="form-control noresize"><?php echo htmlspecialchars($product->getRow()->description); ?></textarea>
								</div>

								<?php
									if(strtolower($product->getRow()->unlimited) == 'true') {
								?>
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Edit']['Content']; ?></span>
									</label>
									<textarea name="product_unlimited_content" class="form-control noresize"><?php echo htmlspecialchars($product->getRow()->unlimited_content); ?></textarea>
								</div>
								<?php
									}
								?>

								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Edit']['Price']; ?></span>
									</label>
									<input type="number" min="0" name="product_price" value="<?php echo intval($product->getRow()->price); ?>" class="form-control" />
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Edit']['Category']; ?></span>
									</label>
									<select name="product_category" class="form-control">
										<option value="0"><?php echo $language['Catalog']['Products']['Edit']['Choose']; ?></option>
										<?php
											foreach($categoryFactory->getAll() as $category) {
										?>
										<option value="<?php echo $category->getRow()->id; ?>" <?php if($product->getRow()->category_id == $category->getRow()->id) { echo 'selected'; } ?>><?php echo htmlspecialchars($category->getRow()->name); ?></option>
										<?php
											}
										?>
									</select>
								</div>
								
								<div class="form-group">
									<label>
										<input type="checkbox" name="product_is_unlimited" <?php if($product->getRow()->unlimited == 'true') { echo 'checked'; } ?> />
										<span><?php echo $language['Catalog']['Products']['Edit']['IsUnlimited']; ?></span>
									</label>
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
