<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;
	use \Plugins\gwork\gwork\shop\Models\Category\CategoryFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$categoryFactory = $controller->getControllerParameters()->getModelsManager()->get(CategoryFactory::class);
	
	$categories = $categoryFactory->getAll(false, null, $orderBy = 'order', OrderTypes::DESC, true);
?>

			<section class="panel panel-default">
				<form method="post" action="<?php echo SITE_PATH; ?>/admin/catalog/categories/form">
					<header class="panel-heading">
						<?php echo $language['Catalog']['Categories']['List']['PageName']; ?>
					</header>
					
					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<a href="<?php echo SITE_PATH; ?>/admin/catalog/categories/add" class="btn btn-primary">
								<?php echo $language['Catalog']['Categories']['List']['Add']; ?>
							</a>
						</div>
					</div>
					
					<?php
						if(count($categories) > 0) {
					?>
					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<select name="action" class="input-sm form-control input-s-sm inline v-middle">
								<option><?php echo $language['Catalog']['Categories']['List']['Menu']['Choose']; ?></option>
								<option value="delete"><?php echo $language['Catalog']['Categories']['List']['Menu']['Delete']; ?></option>
							</select>
							<button type="submit" class="btn btn-sm btn-default"><?php echo $language['Catalog']['Categories']['List']['Menu']['Submit']; ?></button>                
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
									<th width="70"><?php echo $language['Catalog']['Categories']['List']['Table']['Order']; ?></th>
									<th><?php echo $language['Catalog']['Categories']['List']['Table']['Name']; ?></th>
									<th width="30"></th>
									<th width="30"></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($categories as $category) {
								?>
								<tr>
									<td>
										<label class="checkbox m-n i-checks">
											<input type="checkbox" name="categories[]" value="<?php echo $category->getRow()->id; ?>" /><i></i>
										</label>
									</td>
									<td><?php echo htmlspecialchars($category->getRow()->order); ?></td>
									<td><?php echo htmlspecialchars($category->getRow()->name); ?></td>
									<td>
										<a href="<?php echo SITE_PATH; ?>/admin/catalog/categories/edit/<?php echo $category->getRow()->id; ?>">
											<i class="i i-pencil text-primary"></i>
										</a>
									</td>
									<td>
										<a href="<?php echo SITE_PATH; ?>/admin/catalog/categories/delete/<?php echo $category->getRow()->id; ?>">
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
									<option><?php echo $language['Catalog']['Categories']['List']['Menu']['Choose']; ?></option>
									<option value="delete"><?php echo $language['Catalog']['Categories']['List']['Menu']['Delete']; ?></option>
								</select>
								<button type="submit" class="btn btn-sm btn-default"><?php echo $language['Catalog']['Categories']['List']['Menu']['Submit']; ?></button>                
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
