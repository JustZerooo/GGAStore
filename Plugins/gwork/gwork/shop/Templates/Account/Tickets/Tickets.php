<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;
	use \Plugins\gwork\gwork\shop\Models\Ticket\TicketFactory;
	use \Plugins\gwork\gwork\shop\Models\TicketAnswer\TicketAnswerFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();
	
	$ticketFactory = $controller->getControllerParameters()->getModelsManager()->get(TicketFactory::class);
	$ticketAnswerFactory = $controller->getControllerParameters()->getModelsManager()->get(TicketAnswerFactory::class);
	
	$tickets = $ticketFactory->getAllByColumn('user_id', $controller->getUser()->getRow()->id, false, 100, '=', 'timestamp', OrderTypes::DESC);
?>
				<div class="box p-15">
					<h1 class="section-title"><?php echo $language['Account']['Tickets']['PageName']; ?></h1>
					<hr class="hr" />

					<a href="<?php echo SITE_PATH; ?>/account/tickets/add" class="btn"><?php echo $language['Account']['Tickets']['Create']; ?></a>
					
					<hr />
					
					<?php
						if(count($tickets) > 0) {
					?>
					<table class="table">
						<thead>
							<tr>
								<th><?php echo $language['Account']['Tickets']['Title']; ?></th>
								<th><?php echo $language['Account']['Tickets']['Status']; ?></th>
								<th><?php echo $language['Account']['Tickets']['Date']; ?></th>
								<th width="30"></th>
							</tr>
						</thead>
						<tbody>
					<?php
							foreach($tickets as $ticket) {
								$lastAnswers = $ticketAnswerFactory->getAllByColumn('ticket_id', $ticket->getRow()->id, false, 1, '=', 'timestamp', OrderTypes::DESC);
								$lastAnswer = count($lastAnswers) > 0 ? $lastAnswers[0] : null;
					?>
						<tr>
							<td style="vertical-align: middle;font-size:12px;"><?php echo substr(htmlspecialchars($ticket->getRow()->title), 0, 150); ?></td>
							<td style="vertical-align: middle;">
								<?php
									if(strtolower($ticket->getRow()->status) == 'closed') {
								?>
								<span class="label label-danger inline-block"><?php echo $language['Account']['Tickets']['Closed']; ?></span>
								<?php
									} else if(strtolower($ticket->getRow()->status) == 'completed') {
								?>
								<span class="label label-success inline-block"><?php echo $language['Account']['Tickets']['Completed']; ?></span>
								<?php
									} else if($lastAnswer == null || $lastAnswer->getRow()->user_id == $ticket->getRow()->user_id) {
								?>
								<span class="label label-warning inline-block"><?php echo $language['Account']['Tickets']['Waiting']; ?></span>
								<?php
									} else {
								?>
								<span class="label label-info inline-block"><?php echo $language['Account']['Tickets']['Answered']; ?></span>
								<?php
									}
								?>
							</td>
							<td style="vertical-align: middle;font-size:12px;"><?php echo date('d.m.Y', $ticket->getRow()->timestamp); ?></td>
							<td style="vertical-align: middle;">
								<a class="btn btn-secondary" href="<?php echo SITE_PATH; ?>/account/tickets/<?php echo $ticket->getRow()->id; ?>"><?php echo $language['Account']['Tickets']['Show']; ?></a>
							</td>
						</tr>
					<?php
							}
					?>
						</tbody>
					</table>
					<?php
						}
					?>
				</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
