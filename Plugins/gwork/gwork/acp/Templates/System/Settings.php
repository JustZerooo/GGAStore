<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$currencies = [
		'EUR', 'USD'
	];
?>

				<section class="panel panel-default">
					<header class="panel-heading">
						<?php echo $language['System']['Settings']['PageName']; ?>
					</header>
					
					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<?php
								if(!$this->errorMessage->isNull()) {
							?>
							<div class="alert alert-danger"><?php echo $this->errorMessage->getValue(); ?></div>
							<?php
								}
							?>
							
							<?php
								if(!$this->successMessage->isNull()) {
							?>
							<div class="alert alert-success"><?php echo $this->successMessage->getValue(); ?></div>
							<?php
								}
							?>
							
							<form method="post" action="<?php echo SITE_PATH; ?>/admin/system/settings">
								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['SiteName']; ?></span>
									</label>
									<input type="text" name="settings_site_name" value="<?php echo htmlspecialchars($settings->SiteName); ?>" class="form-control" />
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['InfoBoxTitle']; ?></span>
									</label>
									<input type="text" name="settings_infobox_title" value="<?php echo htmlspecialchars($settings->InfoBoxTitle); ?>" class="form-control" />
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['InfoBoxText']; ?></span>
									</label>
									<textarea name="settings_infobox_text" class="form-control noresize"><?php echo htmlspecialchars($settings->InfoBoxText); ?></textarea>
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['Currency']; ?></span>
									</label>
									<select name="settings_currency" class="form-control">
										<?php
											foreach($currencies as $currency) {
												$selected = '';
												if(strtoupper($settings->Currency) == $currency) {
													$selected = ' selected';
												}
												
												echo '<option value="' . $currency . '"' . $selected . '>' . $currency . '</option>';
											}
										?>
									</select>
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['Language']; ?></span>
									</label>
									<select name="settings_language" class="form-control">
										<?php
											foreach($controller->getMultilingual()->getLanguages() as $lng) {
												$selected = '';
												if(strtoupper($settings->Language) == strtoupper($lng->getCode())) {
													$selected = ' selected';
												}
												
												echo '<option value="' . $lng->getCode() . '"' . $selected . '>' . $lng->getName() . '</option>';
											}
										?>
									</select>
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['HomepageNews']; ?></span>
									</label>
									<select name="settings_homepagenews" class="form-control">
										<option value="0" <?php if($settings->HomepageNews == 0) { echo 'selected'; } ?>><?php echo $language['System']['Settings']['Deactivated']; ?></option>
										<option value="1" <?php if($settings->HomepageNews == 1) { echo 'selected'; } ?>><?php echo $language['System']['Settings']['Activated']; ?></option>
									</select>
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['Maintenance']; ?></span>
									</label>
									<select name="settings_recaptchaenabled" class="form-control">
										<option value="0" <?php if($settings->Maintenance == 0) { echo 'selected'; } ?>><?php echo $language['System']['Settings']['Deactivated']; ?></option>
										<option value="1" <?php if($settings->Maintenance == 1) { echo 'selected'; } ?>><?php echo $language['System']['Settings']['Activated']; ?></option>
									</select>
								</div>

								<hr />

								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['BitcoinHost']; ?></span>
									</label>
									<input type="text" name="settings_btc_jrpc_host" value="<?php echo htmlspecialchars($settings->BitcoinHost); ?>" class="form-control" />
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['BitcoinPort']; ?></span>
									</label>
									<input type="text" name="settings_btc_jrpc_port" value="<?php echo htmlspecialchars($settings->BitcoinPort); ?>" class="form-control" />
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['BitcoinUsername']; ?></span>
									</label>
									<input type="text" name="settings_btc_jrpc_username" value="<?php echo htmlspecialchars($settings->BitcoinUsername); ?>" class="form-control" />
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['BitcoinPassword']; ?></span>
									</label>
									<input type="text" name="settings_btc_jrpc_password" value="<?php echo htmlspecialchars($settings->BitcoinPassword); ?>" class="form-control" />
								</div>

								<hr />
								
								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['RecaptchaEnabled']; ?></span>
									</label>
									<select name="settings_recaptchaenabled" class="form-control">
										<option value="0" <?php if($settings->RecaptchaEnabled == 0) { echo 'selected'; } ?>><?php echo $language['System']['Settings']['Deactivated']; ?></option>
										<option value="1" <?php if($settings->RecaptchaEnabled == 1) { echo 'selected'; } ?>><?php echo $language['System']['Settings']['Activated']; ?></option>
									</select>
								</div>
								
								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['RecaptchaSiteKey']; ?></span>
									</label>
									<input type="text" name="settings_recaptcha_site_key" value="<?php echo htmlspecialchars($settings->RecaptchaSiteKey); ?>" class="form-control" />
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['RecaptchaPrivateKey']; ?></span>
									</label>
									<input type="text" name="settings_recaptcha_private_key" value="<?php echo htmlspecialchars($settings->RecaptchaPrivateKey); ?>" class="form-control" />
								</div>

								<hr />

								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['JabberHost']; ?></span>
									</label>
									<input type="text" name="settings_jabber_host" value="<?php echo htmlspecialchars($settings->JabberHost); ?>" class="form-control" />
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['JabberPort']; ?></span>
									</label>
									<input type="text" name="settings_jabber_port" value="<?php echo htmlspecialchars($settings->JabberPort); ?>" class="form-control" />
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['JabberUsername']; ?></span>
									</label>
									<input type="text" name="settings_jabber_username" value="<?php echo htmlspecialchars($settings->JabberUsername); ?>" class="form-control" />
								</div>

								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['JabberPassword']; ?></span>
									</label>
									<input type="text" name="settings_jabber_password" value="<?php echo htmlspecialchars($settings->JabberPassword); ?>" class="form-control" />
								</div>

								<hr />

								<div class="form-group">
									<label>
										<span><?php echo $language['System']['Settings']['JabberID']; ?></span>
									</label>
									<input type="text" name="settings_jabber_id" value="<?php echo htmlspecialchars($settings->JabberID); ?>" class="form-control" />
								</div>
								
								<input type="submit" class="btn btn-primary" value="<?php echo $language['System']['Settings']['Save']; ?>" />
							</form>
						</div>
					</div>
				</section>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
