<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Models\Plugin\PluginFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$pluginFactory = $controller->getControllerParameters()->getModelsManager()->get(PluginFactory::class);
	
	$plugins = $pluginFactory->getAll();
?>

			<section class="panel panel-default">
				<form method="post" action="<?php echo SITE_PATH; ?>/admin/system/plugins/form">
					<header class="panel-heading">
						<?php echo $language['System']['Plugins']['List']['PageName']; ?>
					</header>
					
					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<!--<a href="<?php echo SITE_PATH; ?>/admin/system/plugins/add" class="btn btn-primary">
								<?php echo $language['System']['Plugins']['List']['Add']; ?>
							</a>-->
							<input type="button" class="btn btn-primary" value="<?php echo $language['System']['Plugins']['List']['Add']; ?>" disabled />
						</div>
					</div>
					
					<?php
						if(count($plugins) > 0) {
					?>
					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<select name="action" class="input-sm form-control input-s-sm inline v-middle">
								<option><?php echo $language['System']['Plugins']['List']['Menu']['Choose']; ?></option>
								<option value="delete"><?php echo $language['System']['Plugins']['List']['Menu']['Delete']; ?></option>
								<option value="disable"><?php echo $language['System']['Plugins']['List']['Menu']['Disable']; ?></option>
								<option value="enable"><?php echo $language['System']['Plugins']['List']['Menu']['Enable']; ?></option>
							</select>
							<button type="submit" class="btn btn-sm btn-default"><?php echo $language['System']['Plugins']['List']['Menu']['Submit']; ?></button>                
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
									<th><?php echo $language['System']['Plugins']['List']['Table']['Name']; ?></th>
									<th><?php echo $language['System']['Plugins']['List']['Table']['Version']; ?></th>
									<th><?php echo $language['System']['Plugins']['List']['Table']['Package']; ?></th>
									<th><?php echo $language['System']['Plugins']['List']['Table']['Author']; ?></th>
									<th width="30"></th>
									<th width="30"></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($plugins as $plugin) {
										$canModify = strtolower($controller->getPluginInfo()->getPackage()) != $plugin->getRow()->package;
								?>
								<tr>
									<td>
										<label class="checkbox m-n i-checks">
											<?php
												if($canModify) {
											?>
											<input type="checkbox" name="plugins[]" value="<?php echo $plugin->getRow()->id; ?>" /><i></i>
											<?php
												} else {
											?>
											<input type="checkbox" disabled readonly /><i></i>
											<?php
												}
											?>
										</label>
									</td>
									<td><?php echo htmlspecialchars($plugin->getRow()->name); ?></td>
									<td><?php echo htmlspecialchars($plugin->getRow()->version); ?></td>
									<td><?php echo htmlspecialchars($plugin->getRow()->package); ?></td>
									<td><?php echo htmlspecialchars($plugin->getRow()->author); ?></td>
									<td>
									<?php
										if($plugin->getRow()->enabled == '0' && $canModify) {
									?>
										<a href="<?php echo SITE_PATH; ?>/admin/system/plugins/enable/<?php echo $plugin->getRow()->id; ?>">
											<i class="i i-cross2 text-primary"></i>
										</a>
									<?php
										} else if($plugin->getRow()->enabled != '0' && $canModify) {
									?>
										<a href="<?php echo SITE_PATH; ?>/admin/system/plugins/disable/<?php echo $plugin->getRow()->id; ?>">
											<i class="i i-checkmark2 text-primary"></i>
										</a>
									<?php
										} else if($plugin->getRow()->enabled == '0' && !$canModify) {
									?>
										<i class="i i-cross2"></i>
									<?php
										} else if($plugin->getRow()->enabled != '0' && !$canModify) {
									?>
										<i class="i i-checkmark2"></i>
									<?php
										}
									?>
									</td>
									<td>
										<?php
											if($canModify) {
										?>
										<a href="<?php echo SITE_PATH; ?>/admin/system/plugins/delete/<?php echo $plugin->getRow()->id; ?>">
											<i class="i i-trashcan text-primary"></i>
										</a>
										<?php
											} else {
										?>
										<i class="i i-trashcan"></i>
										<?php
											}
										?>
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
								<select name="action" class="input-sm form-control input-s-sm inline v-middle">
									<option><?php echo $language['System']['Plugins']['List']['Menu']['Choose']; ?></option>
									<option value="delete"><?php echo $language['System']['Plugins']['List']['Menu']['Delete']; ?></option>
									<option value="disable"><?php echo $language['System']['Plugins']['List']['Menu']['Disable']; ?></option>
									<option value="enable"><?php echo $language['System']['Plugins']['List']['Menu']['Enable']; ?></option>
								</select>
								<button type="submit" class="btn btn-sm btn-default"><?php echo $language['System']['Plugins']['List']['Menu']['Submit']; ?></button>                
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
