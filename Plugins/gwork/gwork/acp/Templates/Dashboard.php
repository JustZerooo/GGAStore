<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \GWork\System\Models\User\UserFactory;
	use \GWork\System\Models\Plugin\PluginFactory;
	use \GWork\System\Helpers\OrderTypes\OrderTypes;
	use \Plugins\gwork\gwork\acp\Models\Note\NoteFactory;
	use \Plugins\gwork\gwork\shop\Utils\Bitcoin\Bitcoin;

	use \Plugins\gwork\gwork\shop\Plugin;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$header = ViewHelper::create($controller, 'Header.php', $pageId, $this->variables->getValue(), [], true);
	$header->display();

	$btcSendToAddress = !$this->btcSendToAddress->isNull() ? $this->btcSendToAddress->getValue() : null;
	$btcSendAmount = !$this->btcSendAmount->isNull() ? $this->btcSendAmount->getValue() : null;
	$btcSendFees = !$this->btcSendFees->isNull() ? $this->btcSendFees->getValue() : null;
	
	$newsletterMessage = !$this->newsletterMessage->isNull() ? $this->newsletterMessage->getValue() : null;
	
	$noteMessage = !$this->noteMessage->isNull() ? $this->noteMessage->getValue() : null;

	$noteFactory = $controller->getControllerParameters()->getModelsManager()->get(NoteFactory::class);
	
	$userFactory = $controller->getControllerParameters()->getModelsManager()->get(UserFactory::class);
	$pluginFactory = $controller->getControllerParameters()->getModelsManager()->get(PluginFactory::class);
?>
			<section class="row m-b-md">
                <div class="col-sm-6">
                    <h3 class="m-n text-black"><?php echo $language['Dashboard']['PageName']; ?></h3>
                    <small><?php echo str_replace('%username%', htmlspecialchars($controller->getUser()->getRow()->username), $language['Dashboard']['Welcome']); ?></small>
                </div>
            </section>

			<div class="row">
				<div class="col-sm-6">
					<div class="panel b-a">
						<div class="row m-n">
							<div class="col-md-6 b-b b-r">
								<a class="block padder-v hover">
									<span class="i-s i-s-2x pull-left m-r-sm">
										<i class="i i-hexagon2 i-s-base text-info"></i>
										<i class="i i-cube i-sm text-white"></i>
									</span>
									<span class="clear">
										<span class="h3 block m-t-xs text-info"><?php echo $pluginFactory->getRowCount(); ?></span>
										<small class="text-muted text-u-c"><?php echo $language['Dashboard']['InfoBlocks']['Plugins']['Name']; ?></small>
									</span>
								</a>
							</div>
							<div class="col-md-6 b-b">
								<a class="block padder-v hover">
									<span class="i-s i-s-2x pull-left m-r-sm">
										<i class="i i-hexagon2 i-s-base text-success-lt"></i>
										<i class="i i-users2 i-sm text-white"></i>
									</span>
									<span class="clear">
										<span class="h3 block m-t-xs text-success"><?php echo $userFactory->getRowCount(); ?></span>
										<small class="text-muted text-u-c"><?php echo $language['Dashboard']['InfoBlocks']['Users']['Name']; ?></small>
									</span>
								</a>
							</div>
							<div class="col-md-6 b-b b-r">
								<a class="block padder-v hover">
									<span class="i-s i-s-2x pull-left m-r-sm">
										<i class="i i-hexagon2 i-s-base text-danger"></i>
										<i class="i i-chat3 i-1x text-white"></i>
									</span>
									<span class="clear">
										<span class="h3 block m-t-xs text-danger"><?php echo $controller->getDefaultLanguage()->getName(); ?> (<?php echo strtoupper($controller->getDefaultLanguage()->getCode()); ?>)</span>
										<small class="text-muted text-u-c"><?php echo $language['Dashboard']['InfoBlocks']['Language']['Name']; ?></small>
									</span>
								</a>
							</div>
							<div class="col-md-6 b-b">
								<a class="block padder-v hover">
									<span class="i-s i-s-2x pull-left m-r-sm">
										<i class="i i-hexagon2 i-s-base text-primary"></i>
										<i class="i i-clock2 i-sm text-white"></i>
									</span>
									<span class="clear">
										<span class="h3 block m-t-xs text-primary"><?php echo date('H:i', time()); ?></span>
										<small class="text-muted text-u-c"><?php echo $language['Dashboard']['InfoBlocks']['Time']['Name']; ?></small>
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>

				<div class="col-sm-6">
					<div class="panel b-a">
						<div class="row m-n">
							<div class="col-md-6 b-r">
								<a class="block padder-v hover">
									<span class="i-s i-s-2x pull-left m-r-sm">
										<i class="i i-hexagon2 i-s-base text-info"></i>
										<i class="fa fa-bitcoin i-sm text-white"></i>
									</span>
									<span class="clear">
										<span class="h3 block m-t-xs text-info">
											<?php
												$bitcoin = new Bitcoin($settings->BitcoinUsername, $settings->BitcoinPassword, $settings->BitcoinHost, (int) $settings->BitcoinPort);
												$btcConvertedAmount = Plugin::convertCurrency($bitcoin->getbalance(), 'BTC', strtoupper($settings->Currency), false);

												echo $bitcoin->getbalance() . ' (' . $btcConvertedAmount . ' ' . strtoupper($settings->Currency) . ')';
											?>
										</span>
										<small class="text-muted text-u-c"><?php echo $language['Dashboard']['InfoBlocks']['BitcoinsBalance']['Name']; ?></small>
									</span>
								</a>
							</div>
							<div class="col-md-6 b-r">
								<a class="block padder-v hover">
									<span class="i-s i-s-2x pull-left m-r-sm">
										<i class="i i-hexagon2 i-s-base text-info"></i>
										<i class="fa fa-paper-plane-o i-sm text-white"></i>
									</span>
									<span class="clear">
										<span class="h3 block m-t-xs text-info">
											<?php
												echo $userFactory->getRowCountByColumn('newsletter', 1);
											?>
										</span>
										<small class="text-muted text-u-c"><?php echo $language['Dashboard']['InfoBlocks']['NewsletterAbos']['Name']; ?></small>
									</span>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-12 col-md-12">
					<section class="panel panel-default">
						<header class="panel-heading">
							<?php echo $language['Dashboard']['Note']['Title']; ?>
						</header>

						<div class="row wrapper">
							<div class="col-sm-12 col-md-12 m-b-md">
								<form method="post">
									<div class="form-group">
										<input type="text" class="form-control" name="note_message" placeholder="<?php echo $language['Dashboard']['Note']['Message']; ?>" value="<?php echo $noteMessage; ?>" />
									</div>
									<input type="submit" class="btn btn-primary" value="<?php echo $language['Dashboard']['Note']['Submit']; ?>" />
								</form>
							</div>
							<div class="col-sm-12 col-md-12 m-b-xs">
								<div class="table-responsive">
									<table class="table table-striped b-t b-light">
										<thead>
											<tr>
												<th><?php echo $language['Dashboard']['Note']['Note']; ?></th>
												<th><?php echo $language['Dashboard']['Note']['Timestamp']; ?></th>
												<th></th>
											</tr>
										</thead>
										<tbody>
								<?php
									$notes = $noteFactory->getAll(false, null, 'timestamp', OrderTypes::DESC);
									foreach($notes as $note) {
										$noteUser = $userFactory->getByColumn('id', $note->getRow()->userid);
										$readed = $note->getRow()->readed == 1;
								?>
											<tr <?php if(!$readed) { ?>style="background:#fff6cf !important;"<?php } ?>>
												<td <?php if(!$readed) { ?>style="background:transparent !important;"<?php } ?>>
													<?php
														if($noteUser != null) {
													?>
													<b><?php echo htmlspecialchars($noteUser->getRow()->username); ?></b>
													<?php
														}
													?>
													<div>
														<?php echo htmlspecialchars($note->getRow()->note); ?>
													</div>
												</td>
												<td <?php if(!$readed) { ?>style="background:transparent !important;"<?php } ?>>
													<i><?php echo date('d.m.Y H:i', $note->getRow()->timestamp); ?></i>
												</td>
												<td <?php if(!$readed) { ?>style="background:transparent !important;"<?php } ?>>
													<a class="btn btn-primary" href="<?php echo SITE_PATH; ?>/admin/note/delete/<?php echo $note->getRow()->id; ?>">
														<i class="i i-trashcan"></i>
													</a>
													
													<?php
														if(!$readed) {
													?>
													<a class="btn btn-primary" href="<?php echo SITE_PATH; ?>/admin/note/read/<?php echo $note->getRow()->id; ?>">
														<i class="i i-eye"></i>
													</a>
													<?php
														}
													?>
												</td>
											</tr>
								<?php
									}
								?>
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</section>
				</div>
			</div>
			
			<div class="row">
				<?php
					if($controller->getUser()->hasPermissionByName('ACCESS_JABBER_NEWSLETTER')) {
				?>
				<div class="col-sm-12 col-md-6">
					<section class="panel panel-default">
						<header class="panel-heading">
							<?php echo $language['Dashboard']['SendNewsletter']['Title']; ?>
						</header>

						<div class="row wrapper">
							<div class="col-sm-12 col-md-12 m-b-xs">
								<?php
									if(!$this->newsletterErrorMessage->isNull()) {
								?>
								<div class="alert alert-danger"><?php echo $this->newsletterErrorMessage->getValue(); ?></div>
								<?php
									}
								?>

								<?php
									if(!$this->newsletterSuccessMessage->isNull()) {
								?>
								<div class="alert alert-success"><?php echo $this->newsletterSuccessMessage->getValue(); ?></div>
								<?php
									}
								?>

								<form method="post">
									<div class="form-group">
										<textarea class="form-control" name="newsletter_message" placeholder="<?php echo $language['Dashboard']['SendNewsletter']['Message']; ?>"><?php echo $newsletterMessage; ?></textarea>
									</div>
									<input type="submit" class="btn btn-primary" value="<?php echo $language['Dashboard']['SendNewsletter']['Submit']; ?>" />
								</form>
							</div>
						</div>
					</section>
				</div>
				<?php
					}
				?>
				<?php
					if($controller->getUser()->hasPermissionByName('ACCESS_BTC_SERVER')) {
				?>
				<div class="col-sm-12 col-md-6">
					<section class="panel panel-default">
						<header class="panel-heading">
							<?php echo $language['Dashboard']['SendBTC']['Title']; ?>
						</header>

						<div class="row wrapper">
							<div class="col-sm-12 col-md-12 m-b-xs">
								<?php
									if(!$this->btcSendErrorMessage->isNull()) {
								?>
								<div class="alert alert-danger"><?php echo $this->btcSendErrorMessage->getValue(); ?></div>
								<?php
									}
								?>

								<?php
									if(!$this->btcSendSuccessMessage->isNull()) {
								?>
								<div class="alert alert-success"><?php echo $this->btcSendSuccessMessage->getValue(); ?></div>
								<?php
									}
								?>

								<form method="post">
									<div class="form-group">
										<input type="text" class="form-control" name="btc_send_toaddress" placeholder="<?php echo $language['Dashboard']['SendBTC']['ToAddress']; ?>" value="<?php echo $btcSendToAddress; ?>" />
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="btc_send_amount" placeholder="<?php echo $language['Dashboard']['SendBTC']['Amount']; ?>" value="<?php echo $btcSendAmount; ?>" />
									</div>
									<div class="form-group">
										<input type="text" class="form-control" name="btc_send_fees" placeholder="<?php echo $language['Dashboard']['SendBTC']['Fees']; ?>" value="<?php echo $btcSendFees; ?>" />
									</div>
									<input type="submit" class="btn btn-primary" value="<?php echo $language['Dashboard']['SendBTC']['Submit']; ?>" />
								</form>
							</div>
						</div>
					</section>
				</div>
				<?php
					}
				?>
			</div>
<?php
	$footer = ViewHelper::create($controller, 'Footer.php', $pageId, $this->variables->getValue(), [], true);
	$footer->display();
?>
