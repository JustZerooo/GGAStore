<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;
	use \GWork\System\Models\User\UserFactory;

	use \Plugins\gwork\gwork\shop\Models\TicketAnswer\TicketAnswerFactory;
	use \Plugins\gwork\gwork\shop\Utils\CSRF\CSRF;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$ticketAnswerFactory = $controller->getControllerParameters()->getModelsManager()->get(TicketAnswerFactory::class);
	$userFactory = $controller->getControllerParameters()->getModelsManager()->get(UserFactory::class);

	$ticket = !$this->ticket->isNull() ? $this->ticket->getValue() : null;

	$postAnswerText = !$this->postAnswerText->isNull() ? $this->postAnswerText->getValue() : '';

	$ticketAnswers = $ticketAnswerFactory->getAllByColumn('ticket_id', $ticket->getRow()->id, false, 20, '=', 'timestamp', OrderTypes::NONE);
?>
				<div class="box p-15">
					<h1 class="section-title"><?php echo htmlspecialchars($ticket->getRow()->title); ?></h1>

					<hr class="hr" />

					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<span class="label label-primary">
									<?php echo $language['Account']['Tickets']['You']; ?>
								</span>
								<span class="news-date mt-10">
									<?php echo date('d.m.Y', $ticket->getRow()->timestamp); ?>
								</span>
							</h4>
						</div>
						<div class="panel-collapse collapse in">
							<div class="panel-body news-text">
								<?php echo $ticket->getRow()->text; ?>
							</div>
						</div>
					</div>

					<hr class="hr" />

					<?php
						foreach($ticketAnswers as $ticketAnswer) {
					?>
					<div class="panel panel-default">
						<div class="panel-heading">
							<h4 class="panel-title">
								<?php
									if($ticketAnswer->getRow()->user_id != $controller->getUser()->getRow()->id) {
								?>
								<span class="label label-success">
									<?php
										$supporter = $userFactory->getByColumn('id', $ticketAnswer->getRow()->user_id);
										if($supporter != null) {
											echo htmlspecialchars($supporter->getRow()->username);
										} else {
											echo $language['Users']['Tickets']['Show']['Supporter'];
										}
									?>
								</span>
								<?php
									} else {
								?>
								<span class="label label-primary">
									<?php echo $language['Account']['Tickets']['You']; ?>
								</span>
								<?php
									}
								?>
								<span class="news-date mt-10">
									<?php echo date('d.m.Y', $ticketAnswer->getRow()->timestamp); ?>
								</span>
							</h4>
						</div>
						<div class="panel-collapse collapse in">
							<div class="panel-body news-text">
								<?php echo htmlspecialchars($ticketAnswer->getRow()->text); ?>
							</div>
						</div>
					</div>

					<hr class="hr" />
					<?php
						}
					?>

					<?php
						if(!$this->errorMessage->isNull()) {
					?>
					<div class="alert alert-danger"><?php echo $this->errorMessage->getValue(); ?></div>
					<?php
						}
					?>

					<form method="post" action="<?php echo SITE_PATH; ?>/account/tickets/<?php echo $ticket->getRow()->id; ?>">
						<input type="hidden" name="csrf_token" value="<?php echo CSRF::getCSRFToken($controller); ?>" />

						<div class="form-group">
							<textarea class="noresize form-control" placeholder="<?php echo htmlspecialchars($language['Account']['Tickets']['Placeholder']); ?>" name="ticket_answer_text"><?php echo $postAnswerText; ?></textarea>
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

						<input type="submit" class="btn btn-primary" value="<?php echo htmlspecialchars($language['Account']['Tickets']['Answer']); ?>" />
					</form>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
