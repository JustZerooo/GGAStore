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
	
	$postName = !$this->postName->isNull() ? $this->postName->getValue() : null;
	$postOrder = !$this->postOrder->isNull() ? $this->postOrder->getValue() : 0;
?>

				<section class="panel panel-default">
					<header class="panel-heading">
						<?php echo $language['Catalog']['Categories']['Add']['PageName']; ?>
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
							
							<form method="post" action="<?php echo SITE_PATH; ?>/admin/catalog/categories/add">
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Categories']['Add']['Order']; ?></span>
									</label>
									<input type="text" name="category_order" value="<?php echo htmlspecialchars($postOrder); ?>" class="form-control" />
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['Catalog']['Categories']['Add']['Name']; ?></span>
									</label>
									<input type="text" name="category_name" value="<?php echo htmlspecialchars($postName); ?>" class="form-control" />
								</div>
								
								<input type="submit" class="btn btn-primary" value="<?php echo $language['Catalog']['Categories']['Add']['Add']; ?>" />
							</form>
						</div>
					</div>
				</section>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
