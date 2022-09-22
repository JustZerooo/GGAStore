<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;
	use \Plugins\gwork\gwork\shop\Models\Ticket\TicketFactory;
	use \Plugins\gwork\gwork\shop\Models\TicketAnswer\TicketAnswerFactory;
	use \GWork\System\Models\User\UserFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$ticketFactory = $controller->getControllerParameters()->getModelsManager()->get(TicketFactory::class);
	$userFactory = $controller->getControllerParameters()->getModelsManager()->get(UserFactory::class);
	$ticketAnswerFactory = $controller->getControllerParameters()->getModelsManager()->get(TicketAnswerFactory::class);

	$tickets = $ticketFactory->getAll(false, null, 'timestamp', OrderTypes::DESC);
?>

			<section class="panel panel-default">
				<form method="post" action="<?php echo SITE_PATH; ?>/admin/users/tickets/form">
					<header class="panel-heading">
						<?php echo $language['Users']['Tickets']['List']['PageName']; ?>
					</header>

					<?php
						if(count($tickets) > 0) {
					?>
					<div class="row wrapper">
						<div class="col-sm-5 m-b-xs">
							<select name="action" class="input-sm form-control input-s-sm inline v-middle">
								<option><?php echo $language['Users']['Tickets']['List']['Menu']['Choose']; ?></option>
								<option value="delete"><?php echo $language['Users']['Tickets']['List']['Menu']['Delete']; ?></option>
							</select>
							<button type="submit" class="btn btn-sm btn-default"><?php echo $language['Users']['Tickets']['List']['Menu']['Submit']; ?></button>
						</div>
					</div>
					<div class="table-responsive">
						<table class="table table-striped b-t b-light data-table">
							<thead>
								<tr>
									<th width="20">
										<label class="checkbox m-n i-checks">
											<input type="checkbox" /><i></i>
										</label>
									</th>
									<th><?php echo $language['Users']['Tickets']['List']['Table']['Title']; ?></th>
									<th><?php echo $language['Users']['Tickets']['List']['Table']['User']; ?></th>
									<th><?php echo $language['Users']['Tickets']['List']['Table']['Status']; ?></th>
									<th><?php echo $language['Users']['Tickets']['List']['Table']['Timestamp']; ?></th>
									<th width="30"></th>
									<th width="30"></th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($tickets as $ticket) {
								?>
								<tr>
									<td>
										<label class="checkbox m-n i-checks">
											<input type="checkbox" name="tickets[]" value="<?php echo $ticket->getRow()->id; ?>" /><i></i>
										</label>
									</td>
									<td><?php echo htmlspecialchars($ticket->getRow()->title); ?></td>
									<td>
										<?php
											$ticketUser = $userFactory->getByColumn('id', $ticket->getRow()->user_id);
											if($ticketUser != null) {
												echo htmlspecialchars($ticketUser->getRow()->username);
											} else {
												echo $language['Users']['Tickets']['List']['Table']['Unknown'];
											}
										?>
									</td>
									<td>
										<?php
											$lastAnswers = $ticketAnswerFactory->getAllByColumn('ticket_id', $ticket->getRow()->id, false, 1, '=', 'timestamp', OrderTypes::DESC);
											$lastAnswer = count($lastAnswers) > 0 ? $lastAnswers[0] : null;

											if(strtolower($ticket->getRow()->status) == 'closed') {
										?>
										<span class="label label-danger inline-block"><?php echo $language['Users']['Tickets']['Closed']; ?></span>
										<?php
											} else if(strtolower($ticket->getRow()->status) == 'completed') {
										?>
										<span class="label label-success inline-block"><?php echo $language['Users']['Tickets']['Completed']; ?></span>
										<?php
											} else if($lastAnswer == null || $lastAnswer->getRow()->user_id == $ticket->getRow()->user_id) {
										?>
										<span class="label label-warning inline-block"><?php echo $language['Users']['Tickets']['Waiting']; ?></span>
										<?php
											} else {
										?>
										<span class="label label-info inline-block"><?php echo $language['Users']['Tickets']['Answered']; ?></span>
										<?php
											}
										?>
									</td>
									<td>
										<?php echo date('d.m.Y H:i', $ticket->getRow()->timestamp); ?>
									</td>
									<td>
										<a href="<?php echo SITE_PATH; ?>/admin/users/tickets/show/<?php echo $ticket->getRow()->id; ?>">
											<i class="i i-eye text-primary"></i>
										</a>
									</td>
									<td>
										<a href="<?php echo SITE_PATH; ?>/admin/users/tickets/delete/<?php echo $ticket->getRow()->id; ?>">
											<i class="i i-trashcan text-primary"></i>
										</a>
									</td>
								</tr>
								<?php
									}
								?>
							</tbody>
						</table>
					</div>
					<footer class="panel-footer">
						<div class="row">
							<div class="col-sm-4 hidden-xs">
								<select name="action2" class="input-sm form-control input-s-sm inline v-middle">
									<option><?php echo $language['Users']['Tickets']['List']['Menu']['Choose']; ?></option>
									<option value="delete"><?php echo $language['Users']['Tickets']['List']['Menu']['Delete']; ?></option>
								</select>
								<button type="submit" class="btn btn-sm btn-default"><?php echo $language['Users']['Tickets']['List']['Menu']['Submit']; ?></button>
							</div>
						</div>
					</footer>
					<?php
						}
					?>
				</form>
			</section>

<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
