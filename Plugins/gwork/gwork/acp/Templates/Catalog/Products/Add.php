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
	
	$postTitle = !$this->postTitle->isNull() ? $this->postTitle->getValue() : '';
	$postPrice = !$this->postPrice->isNull() ? $this->postPrice->getValue() : 0;
	$postShortDescription = !$this->postShortDescription->isNull() ? $this->postShortDescription->getValue() : '';
	$postDescription = !$this->postDescription->isNull() ? $this->postDescription->getValue() : '';
	$postUnlimited = !$this->postUnlimited->isNull() ? $this->postUnlimited->getValue() : '';
	$postCategory = !$this->postCategory->isNull() ? $this->postCategory->getValue() : '';
	$postImage = !$this->postImage->isNull() ? $this->postImage->getValue() : '';
	$postInfoTag = !$this->postInfoTag->isNull() ? $this->postInfoTag->getValue() : '';
?>

				<section class="panel panel-default">
					<header class="panel-heading">
						<?php echo $language['Catalog']['Products']['Add']['PageName']; ?>
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
							
							<form method="post" action="<?php echo SITE_PATH; ?>/admin/catalog/products/add" enctype="multipart/form-data">
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Add']['Image']; ?></span>
									</label>
									<input type="file" name="product_image" class="file-loading" />
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Add']['ImageSelect']; ?> <?php echo $language['Optional']; ?></span>
									</label>
									<select name="product_img_select" class="form-control">
										<option value="0"><?php echo $language['Catalog']['Products']['Add']['Choose']; ?></option>
										<?php
											$configuration = $controller->getControllerParameters()->getApplication()->getConfiguration();
											
											$imgsPath = scandir(SYS_PATH . $configuration->getUploadPaths()->products);
											foreach($imgsPath as $fileName) {
												if($fileName == '.' || $fileName == '..') continue;
										?>
										<option value="<?php echo $fileName; ?>" <?php if($postImage == $fileName) { echo 'selected'; } ?>><?php echo htmlspecialchars($fileName); ?></option>
										<?php
											}
										?>
									</select>
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Add']['Title']; ?></span>
									</label>
									<input type="text" name="product_title" value="<?php echo htmlspecialchars($postTitle); ?>" class="form-control" />
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Add']['InfoTag']; ?></span>
									</label>
									<input type="text" name="product_info_tag" value="<?php echo htmlspecialchars($postInfoTag); ?>" class="form-control" />
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Add']['ShortDescription']; ?></span>
									</label>
									<textarea name="product_short_description" class="form-control noresize"><?php echo htmlspecialchars($postShortDescription); ?></textarea>
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Add']['Description']; ?></span>
									</label>
									<textarea name="product_description" class="form-control noresize"><?php echo htmlspecialchars($postDescription); ?></textarea>
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Add']['Price']; ?></span>
									</label>
									<input type="number" min="0" name="product_price" value="<?php echo intval($postPrice); ?>" class="form-control" />
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Products']['Add']['Category']; ?></span>
									</label>
									<select name="product_category" class="form-control">
										<option value="0"><?php echo $language['Catalog']['Products']['Add']['Choose']; ?></option>
										<?php
											foreach($categoryFactory->getAll() as $category) {
										?>
										<option value="<?php echo $category->getRow()->id; ?>" <?php if($postCategory == $category->getRow()->id) { echo 'selected'; } ?>><?php echo htmlspecialchars($category->getRow()->name); ?></option>
										<?php
											}
										?>
									</select>
								</div>
								
								<div class="form-group">
									<label>
										<input type="checkbox" name="product_is_unlimited" <?php if($postUnlimited) { echo 'checked'; } ?> />
										<span><?php echo $language['Catalog']['Products']['Add']['IsUnlimited']; ?></span>
									</label>
								</div>
								
								<input type="submit" class="btn btn-primary" value="<?php echo $language['Catalog']['Products']['Add']['Add']; ?>" />
							</form>
						</div>
					</div>
				</section>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
