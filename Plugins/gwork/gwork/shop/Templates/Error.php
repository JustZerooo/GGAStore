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
				<div class="box p-15 text-center">
					<h1 class="section-title"><?php echo $language['Error']['PageName']; ?></h1>
					<p class="section-text">
						<?php echo $language['Error']['Text']; ?>
					</p>

					<hr class="hr" />
					<a href="<?php echo SITE_PATH; ?>" class="btn">
						<?php echo $language['Error']['Button']; ?>
					</a>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
