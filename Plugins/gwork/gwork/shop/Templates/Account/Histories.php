<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;

	use \Plugins\gwork\gwork\shop\Models\History\HistoryFactory;
	use \Plugins\gwork\gwork\shop\Models\Product\ProductFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$historyFactory = $controller->getControllerParameters()->getModelsManager()->get(HistoryFactory::class);
	$productFactory = $controller->getControllerParameters()->getModelsManager()->get(ProductFactory::class);

	$limit = 100;

	$histories = $historyFactory->getAllByColumn('user_id', intval($controller->getUser()->getRow()->id), false, $limit, '=', 'timestamp', OrderTypes::DESC);
?>
				<div class="alert alert-info">
					<div class="ion ion-ios-information"></div>
					<p>
						<?php echo str_replace('%amount%', $limit, $language['Account']['Histories']['Info']); ?>
					</p>
				</div>

				<div class="box p-15">
					<h1 class="section-title"><?php echo $language['Account']['Histories']['PageName']; ?></h1>
					<hr class="hr" />

					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<?php
							if(count($histories) > 0) {
								foreach($histories as $history) {
									$product = $productFactory->getByColumn('id', intval($history->getRow()->product_id));
						?>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#history-collapse-<?php echo $history->getRow()->id; ?>" aria-expanded="false" aria-controls="history-collapse-<?php echo $history->getRow()->id; ?>">
										<?php
											if($product != null) {
										?>
										<?php echo htmlspecialchars($product->getRow()->title); ?>

										<div>
											<?php
												if(strtolower($history->getRow()->status) == 'pending') {
											?>
											<label class="label label-warning mt-10"><?php echo $language['Account']['Histories']['Status']['Pending']; ?></label>
											<?php
												} else if(strtolower($history->getRow()->status) == 'completed') {
											?>
											<label class="label label-success mt-10 inline-block"><?php echo $language['Account']['Histories']['Status']['Completed']; ?></label>
											<?php
												}
											?>
										</div>

										<span class="news-date mt-10">
											<?php echo date('d.m.Y H:i', $history->getRow()->timestamp); ?>
										</span>
										<?php
											} else {
										?>
										<span class="news-date">
											<?php echo date('d.m.Y H:i', $history->getRow()->timestamp); ?>
										</span>
										<?php
											}
										?>
									</a>
								</h4>
							</div>
							<div id="history-collapse-<?php echo $history->getRow()->id; ?>" class="panel-collapse collapse out" role="tabpanel" aria-labelledby="history-heading-<?php echo $history->getRow()->id; ?>">
								<div class="panel-body news-text">
									<?php echo nl2br(htmlspecialchars($history->getRow()->content)); ?>

									<hr class="hr-light" />

									<?php
										if($product != null) {
											echo $product->getRow()->description;
										} else {
											echo $language['Account']['Histories']['Removed'];
										}
									?>
								</div>
							</div>
						</div>
						<hr class="hr" />
						<?php
								}
							} else {
						?>
						<div class="alert alert-danger">
							<p>
								<?php echo $language['Account']['Histories']['NoOrders']; ?>
							</p>
						</div>
						<?php
							}
						?>
					</div>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
