<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \Plugins\gwork\gwork\shop\Models\FAQ\FAQFactory;
	use \Plugins\gwork\gwork\shop\Utils\CSRF\CSRF;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$errorMessage = !$this->errorMessage->isNull() ? $this->errorMessage->getValue() : null;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();
?>
				<div class="box p-15">
					<h1 class="section-title"><?php echo $language['Login']['PageName']; ?></h1>
					<hr class="hr" />

					<div class="form-width">
						<?php
							if(!$this->errorMessage->isNull()) {
						?>
						<div class="alert alert-danger alert-border"><?php echo $this->errorMessage->getValue(); ?></div>
						<?php
							}
						?>

						<form method="post" action="<?php echo SITE_PATH; ?>/login">
							<input type="hidden" name="csrf_token" value="<?php echo CSRF::getCSRFToken($controller); ?>" />

							<div class="form-group">
								<span class="form-label"><?php echo $language['Login']['Username']['Placeholder']; ?></span>
								<input type="text" class="form-control" value="<?php echo !$this->postUsername->isNull() ? $this->postUsername->getValue() : ''; ?>" name="login_username" />
							</div>

							<div class="form-group">
								<span class="form-label"><?php echo $language['Login']['Password']['Placeholder']; ?></span>
								<input type="password" class="form-control" name="login_password" />
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

							<input type="submit" class="btn btn-default" value="<?php echo $language['Login']['Button']; ?>" />
						</form>
					</div>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
