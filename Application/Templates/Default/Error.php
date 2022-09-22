<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;

	$variables = !$this->variables->isNull() ? $this->variables->getValue() : [];

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $variables);
	$header->display();
?>

		<div id="main">
			<?php
				echo htmlspecialchars($controller->getLanguage()->json()['Error']['Message']);
			?>
		</div>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $variables);
	$footer->display();
?>
