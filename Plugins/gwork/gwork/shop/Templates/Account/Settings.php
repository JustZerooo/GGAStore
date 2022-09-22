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
?>
				<div class="box p-15">
					<div class="form-width">
						<h1 class="section-title"><?php echo $language['Account']['Settings']['Newsletter']['Title']; ?></h1>
						<hr class="hr-title hr-small" />
						
						<?php
							if(!$this->errorNewsletter->isNull()) {
						?>
						<div class="alert alert-danger alert-border"><?php echo $this->errorNewsletter->getValue(); ?></div>
						<?php
							}
						?>

						<?php
							if(!$this->successNewsletter->isNull()) {
						?>
						<div class="alert alert-success alert-border"><?php echo $this->successNewsletter->getValue(); ?></div>
						<?php
							}
						?>
						
						<form method="post" action="<?php echo SITE_PATH; ?>/account/settings/newsletter">
							<input type="hidden" name="csrf_token" value="<?php echo CSRF::getCSRFToken($controller); ?>" />

							<div class="form-group">
								<span class="form-label">
									<?php echo $language['Account']['Settings']['Newsletter']['Placeholder']; ?>
								</span>
								<input type="text" class="form-control" value="<?php echo htmlspecialchars($controller->getUser()->getRow()->jabber); ?>" name="settings_jabber" />
								<span class="form-label">
									<label>
										<input type="checkbox" name="settings_newsletter" <?php if($controller->getUser()->getRow()->newsletter == 1) { echo 'checked '; } ?>/>
										<?php echo $language['Account']['Settings']['Newsletter']['Text']; ?>
									</label>
								</span>
							</div>
							
							<input type="submit" class="btn btn-default" value="<?php echo $language['Account']['Settings']['Newsletter']['Button']; ?>" />
						</form>
						
						<hr class="hr-light" />
						
						<h1 class="section-title"><?php echo $language['Account']['Settings']['Mail']['Title']; ?></h1>
						<hr class="hr-title hr-small" />
						
						<?php
							if(!$this->errorMail->isNull()) {
						?>
						<div class="alert alert-danger alert-border"><?php echo $this->errorMail->getValue(); ?></div>
						<?php
							}
						?>

						<?php
							if(!$this->successMail->isNull()) {
						?>
						<div class="alert alert-success alert-border"><?php echo $this->successMail->getValue(); ?></div>
						<?php
							}
						?>

						<form method="post" action="<?php echo SITE_PATH; ?>/account/settings/mail">
							<input type="hidden" name="csrf_token" value="<?php echo CSRF::getCSRFToken($controller); ?>" />

							<div class="form-group">
								<span class="form-label"><?php echo $language['Account']['Settings']['Mail']['Placeholder']; ?></span>
								<input type="text" class="form-control" value="<?php echo htmlspecialchars($controller->getUser()->getRow()->mail); ?>" name="settings_mail" />
							</div>

							<input type="submit" class="btn btn-default" value="<?php echo $language['Account']['Settings']['Mail']['Button']; ?>" />
						</form>

						<hr class="hr-light" />

						<h1 class="section-title"><?php echo $language['Account']['Settings']['Password']['Title']; ?></h1>
						<hr class="hr-title hr-small" />
						
						<?php
							if(!$this->errorPassword->isNull()) {
						?>
						<div class="alert alert-danger alert-border"><?php echo $this->errorPassword->getValue(); ?></div>
						<?php
							}
						?>

						<?php
							if(!$this->successPassword->isNull()) {
						?>
						<div class="alert alert-success alert-border"><?php echo $this->successPassword->getValue(); ?></div>
						<?php
							}
						?>

						<form method="post" action="<?php echo SITE_PATH; ?>/account/settings/password">
							<input type="hidden" name="csrf_token" value="<?php echo CSRF::getCSRFToken($controller); ?>" />

							<div class="form-group">
								<span class="form-label"><?php echo $language['Account']['Settings']['Password']['Placeholder']['Current']; ?></span>
								<input type="password" class="form-control" value="" name="settings_password_old" />
							</div>

							<div class="form-group">
								<span class="form-label"><?php echo $language['Account']['Settings']['Password']['Placeholder']['New']; ?></span>
								<input type="password" class="form-control" value="" name="settings_password_new" />
							</div>

							<div class="form-group">
								<span class="form-label"><?php echo $language['Account']['Settings']['Password']['Placeholder']['Confirm']; ?></span>
								<input type="password" class="form-control" value="" name="settings_password_new_confirm" />
							</div>

							<input type="submit" class="btn btn-default" value="<?php echo $language['Account']['Settings']['Password']['Button']; ?>" />
						</form>
					</div>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
