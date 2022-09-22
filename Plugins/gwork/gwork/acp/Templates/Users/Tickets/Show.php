<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;
	use \Plugins\gwork\gwork\shop\Models\TicketAnswer\TicketAnswerFactory;
	use \GWork\System\Models\User\UserFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$userFactory = $controller->getControllerParameters()->getModelsManager()->get(UserFactory::class);
	$ticketAnswerFactory = $controller->getControllerParameters()->getModelsManager()->get(TicketAnswerFactory::class);

	$ticket = $this->ticket->getValue();

	$ticketAnswers = $ticketAnswerFactory->getAllByColumn('ticket_id', $ticket->getRow()->id, false, 0, '=', 'timestamp', OrderTypes::NONE);

	$postAnswerText = !$this->postAnswerText->isNull() ? $this->postAnswerText->getValue() : '';
?>

			<section class="panel panel-default">
				<div class="row wrapper">
					<div class="col-sm-5 m-b-xs">
						<?php
							if(strtolower($ticket->getRow()->status) != 'closed' && strtolower($ticket->getRow()->status) != 'completed') {
						?>
						<a href="<?php echo SITE_PATH; ?>/admin/users/tickets/close/<?php echo $ticket->getRow()->id; ?>" class="btn btn-danger">
							<?php echo $language['Users']['Tickets']['Show']['Close']; ?>
						</a>
						<?php
							} else {
						?>
						<a href="<?php echo SITE_PATH; ?>/admin/users/tickets/open/<?php echo $ticket->getRow()->id; ?>" class="btn btn-success">
							<?php echo $language['Users']['Tickets']['Show']['Open']; ?>
						</a>
						<?php
							}
						?>

						<?php
							if(strtolower($ticket->getRow()->status) != 'completed') {
						?>
						<a href="<?php echo SITE_PATH; ?>/admin/users/tickets/complete/<?php echo $ticket->getRow()->id; ?>" class="btn btn-info">
							<?php echo $language['Users']['Tickets']['Show']['Complete']; ?>
						</a>
						<?php
							}
						?>
					</div>
				</div>

				<div class="wrapper">
					<b><?php echo $language['Users']['Tickets']['Show']['Text']; ?></b>

					<p>
						<?php echo htmlspecialchars($ticket->getRow()->text); ?>
					</p>

					<hr />

					<div class="row">
						<table class="table">
							<thead>
								<tr>
									<th><?php echo $language['Users']['Tickets']['Show']['User']; ?></th>
									<th><?php echo $language['Users']['Tickets']['Show']['Message']; ?></th>
									<th><?php echo $language['Users']['Tickets']['Show']['Timestamp']; ?></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($ticketAnswers as $ticketAnswer) {
								?>
								<tr>
									<td>
										<?php
											if($ticketAnswer->getRow()->user_id != $controller->getUser()->getRow()->id) {
										?>
										<span>
											<?php
												$supporter = $userFactory->getByColumn('id', $ticketAnswer->getRow()->user_id);
												if($supporter != null) {
													echo htmlspecialchars($supporter->getRow()->username);
												} else {
													echo $language['Account']['Tickets']['Supporter'];
												}
											?>
										</span>
										<?php
											} else {
										?>
										<span class="text-primary">
											<?php
												$ticketAnswerUser = $userFactory->getByColumn('id', $ticketAnswer->getRow()->user_id);
												echo htmlspecialchars($ticketAnswerUser->getRow()->username);
											?>
										</span>
										<?php
											}
										?>
									</td>
									<td><?php echo htmlspecialchars($ticketAnswer->getRow()->text); ?></td>
									<td><?php echo date('d.m.Y H:i', $ticketAnswer->getRow()->timestamp); ?></td>
								</tr>
								<?php
									}
								?>
							</tbody>
						</table>
					</div>

					<hr />

					<div>
						<form method="post" action="<?php echo SITE_PATH; ?>/admin/users/tickets/show/<?php echo $ticket->getRow()->id; ?>">
							<div class="form-group">
								<textarea class="noresize form-control" placeholder="<?php echo htmlspecialchars($language['Users']['Tickets']['Show']['Placeholder']); ?>" name="ticket_answer_text"><?php echo $postAnswerText; ?></textarea>
							</div>

							<input type="submit" class="btn btn-success" value="<?php echo htmlspecialchars($language['Users']['Tickets']['Show']['Answer']); ?>" />

							<a href="<?php echo SITE_PATH; ?>/admin/users/tickets" class="btn btn-primary">
								<?php echo $language['Users']['Tickets']['Show']['Back']; ?>
							</a>
						</form>
					</div>
				</div>
			</section>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
