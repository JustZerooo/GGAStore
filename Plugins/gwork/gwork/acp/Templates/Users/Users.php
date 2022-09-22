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
?>

				<section class="panel panel-default">
					<header class="panel-heading">
						<?php echo $language['Users']['Users']['PageName']; ?>
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

							<form method="post">
								<div class="input-group">
									<input type="text" name="user_search" class="form-control" placeholder="Nach Benutzernamen oder Jabber ID suchen" />
									<span class="input-group-btn">
										<button type="submit" class="btn btn-primary" type="button">Suchen</button>
									</span>
								</div>
							</form>
						</div>
					</div>
				</section>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
