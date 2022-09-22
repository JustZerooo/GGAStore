<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;

	use \Plugins\gwork\gwork\shop\Models\Tutorial\TutorialFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();
?>
				<div class="box p-15">
					<h1 class="section-title"><?php echo $language['Tutorials']['PageName']; ?></h1>
					<hr class="hr" />

					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<?php
							$tutorialFactory = $controller->getControllerParameters()->getModelsManager()->get(TutorialFactory::class);
							foreach($tutorialFactory->getAll() as $tutorial) {
						?>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab">
								<h4 class="panel-title">
									<?php echo htmlspecialchars($tutorial->getRow()->title); ?>
								</h4>
							</div>
							<div class="panel-collapse collapse in" role="tabpanel">
								<div class="panel-body news-text">
									<?php echo $tutorial->getRow()->text; ?>
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
