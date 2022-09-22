<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;

	use \Plugins\gwork\gwork\shop\Utils\CSRF\CSRF;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$postTitle = !$this->postTitle->isNull() ? $this->postTitle->getValue() : '';
	$postText = !$this->postText->isNull() ? $this->postText->getValue() : '';
?>
				<div class="box p-15">
					<h1 class="section-title"><?php echo $language['Account']['Tickets']['Add']['PageName']; ?></h1>
					<hr class="hr" />

					<?php
						if(!$this->errorMessage->isNull()) {
					?>
					<div class="alert alert-danger"><?php echo $this->errorMessage->getValue(); ?></div>
					<?php
						}
					?>

					<form method="post" action="<?php echo SITE_PATH; ?>/account/tickets/add">
						<input type="hidden" name="csrf_token" value="<?php echo CSRF::getCSRFToken($controller); ?>" />

						<div class="form-group">
							<input type="text" class="form-control" placeholder="<?php echo htmlspecialchars($language['Account']['Tickets']['Add']['Title']); ?>" name="ticket_add_title" value="<?php echo $postTitle; ?>" />
						</div>

						<div class="form-group">
							<textarea class="noresize form-control" placeholder="<?php echo htmlspecialchars($language['Account']['Tickets']['Add']['Text']); ?>" name="ticket_add_text"><?php echo $postText; ?></textarea>
						</div>

						<?php
							if($settings->RecaptchaEnabled == '1' || strtolower($settings->RecaptchaEnabled) == 'true') {
						?>
						<div class="form-group">
							<div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($settings->RecaptchaSiteKey); ?>"></div>
						</div>
						<?php
							}
						?>

						<input type="submit" class="btn btn-primary" value="<?php echo htmlspecialchars($language['Account']['Tickets']['Add']['Submit']); ?>" />
					</form>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
