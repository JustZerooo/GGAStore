<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \Plugins\gwork\gwork\shop\Models\FAQ\FAQFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();
?>
				<div class="box p-15">
					<h1 class="section-title"><?php echo $language['FAQ']['PageName']; ?></h1>
					<hr class="hr" />

					<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
						<?php
							$first = true;

							$faqFactory = $controller->getControllerParameters()->getModelsManager()->get(FAQFactory::class);
							foreach($faqFactory->getAll() as $faq) {
						?>
						<div class="panel panel-default">
							<div class="panel-heading" role="tab" id="faq-heading-<?php echo $faq->getRow()->id; ?>">
								<h4 class="panel-title">
									<a role="button" data-toggle="collapse" data-parent="#accordion" href="#faq-collapse-<?php echo $faq->getRow()->id; ?>" aria-expanded="<?php echo $first ? 'true' : 'false'; ?>" aria-controls="faq-collapse-<?php echo $faq->getRow()->id; ?>">
										<?php echo htmlspecialchars($faq->getRow()->question); ?>
										<i class="icon-slide icon-slide-down ion ion-arrow-down-b"></i>
										<i class="icon-slide icon-slide-up ion ion-arrow-up-b"></i>
									</a>
								</h4>
							</div>
							<div id="faq-collapse-<?php echo $faq->getRow()->id; ?>" class="panel-collapse collapse <?php echo $first ? 'in' : 'out'; ?>" role="tabpanel" aria-labelledby="faq-heading-<?php echo $faq->getRow()->id; ?>">
								<div class="panel-body faq-text">
									<?php echo $faq->getRow()->answer; ?>
								</div>
							</div>
						</div>
						<hr class="hr" />
						<?php
								$first = false;
							}
						?>
					</div>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
