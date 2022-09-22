<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();
	
	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;


	$user = !$this->user->isNull() ? $this->user->getValue() : null;
	
	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();
?>

				<section class="panel panel-default">
					<header class="panel-heading">
						<?php echo htmlspecialchars($user->getRow()->username); ?>
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

							Mitglied seit <i><?php echo date('d.m.Y', $user->getRow()->account_created); ?></i>
							
							<div style="margin-top: 8px;">
								<a href="<?php echo SITE_PATH; ?>/admin/user/<?php echo $user->getRow()->id; ?>/login" class="btn btn-info">Als <?php echo htmlspecialchars($user->getRow()->username); ?> einloggen</a>
							</div>
							
							<hr />
							
							<form method="post">
								<div class="form-group">
									<span>Neues Passwort (min. 6-stellig)</span>
									<input type="password" class="form-control" name="user_new_password" />
								</div>
								
								<input type="submit" class="btn btn-primary" value="Ändern" />
							</form>
							
							<hr />
								
							<form method="post">
								<div class="form-group">
									<span>Benutzername</span>
									<input type="text" class="form-control" value="<?php echo htmlspecialchars($user->getRow()->username); ?>" readonly />
								</div>
							
								<div class="form-group">
									<span>Jabber ID</span>
									<input type="text" class="form-control" name="user_jabber" value="<?php echo htmlspecialchars($user->getRow()->jabber); ?>" />
								</div>
							
								<div class="form-group">
									<span>Kontostand (in Cent, ohne Komma)</span>
									<input type="number" min="0" class="form-control" name="user_balance" value="<?php echo htmlspecialchars($user->getRow()->balance); ?>" />
								</div>
							
								<div class="form-group">
									<label>
										<input type="checkbox" name="user_can_redeem_coupons" <?php if($user->getRow()->can_redeem_coupons == '1') echo 'checked'; ?>/>
										<span>Kann Gutscheine einlösen</span>
									</label>
								</div>
							
								<div class="form-group">
									<label>
										<input type="checkbox" name="user_can_read_tutorials" <?php if($user->getRow()->can_read_tutorials == '1') echo 'checked'; ?>/>
										<span>Kann Tutorials lesen</span>
									</label>
								</div>
							
								
								<input type="submit" name="user_submit" class="btn btn-primary" value="Speichern" />
							</form>
						</div>
					</div>
				</section>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
