<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;

	use \Plugins\gwork\gwork\shop\Models\Article\ArticleFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();
?>
				<div class="box p-15">
					<h1 class="section-title"><?php echo $language['News']['PageName']; ?></h1>
					<hr class="hr" />

					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<?php
							$articleFactory = $controller->getControllerParameters()->getModelsManager()->get(ArticleFactory::class);
							foreach($articleFactory->getAll(false, 20, 'timestamp', OrderTypes::DESC) as $article) {
						?>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab">
								<h4 class="panel-title">
									<?php echo htmlspecialchars($article->getRow()->title); ?>
									
									<?php
										if(strlen($article->getRow()->timestamp) > 5) {
									?>
									<span class="news-date mt-10">
										<?php echo date('d.m.Y', $article->getRow()->timestamp); ?>
									</span>
									<?php
										}
									?>
								</h4>
							</div>
							<div class="panel-collapse collapse in" role="tabpanel">
								<div class="panel-body news-text">
									<?php echo $article->getRow()->text; ?>
								</div>
							</div>
						</div>
						<hr class="hr" />
						<?php
							}
						?>
					</div>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
