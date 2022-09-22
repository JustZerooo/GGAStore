<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\OrderTypes\OrderTypes;
	use \Plugins\gwork\gwork\shop\Models\Category\CategoryFactory;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$categoryFactory = $controller->getControllerParameters()->getModelsManager()->get(CategoryFactory::class);
	
	$isMaintenance = ($settings->Maintenance == 1 || $settings->Maintenance == 'true') ? true : false;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de">
    <head>
		<!-- Title -->
		<title><?php echo htmlspecialchars($pageName); ?></title>

		<!-- Meta Tags -->
		<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no" />

		<meta name="language" content="de" />
		<meta name="audience" content="all" />
		<meta name="cache-control" content="no-cache" />
		<meta name="robots" content="noindex,nofollow" />
		<meta name="pragma" content="no-cache" />

		<!-- Favicon -->
  		<link rel="shortcut icon" href="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/favicon.ico?<?php echo rand(1000000, 99999999); ?>" />

		<!-- Fonts -->
		<link rel="stylesheet" type="text/css" href="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/fonts/ionicons/ionicons.min.css" />
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700italic,700,600italic,600,400italic,300italic,300,800italic,800" />

		<!-- Stylesheets -->
		<link rel="stylesheet" type="text/css" href="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/css/bootstrap/bootstrap.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/css/bootstrap/bootstrap-theme.min.css" />

		<!-- Site -->
		<link rel="stylesheet" type="text/css" href="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/css/style.css?<?php echo rand(1000000, 99999999); ?>" />

		<!--[if lt IE 9]>
			<script src="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/vendor/html5shiv/html5shiv.min.js"></script>
		<![endif]-->

		<!--[if lt IE 10]>
			<script src="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/vendor/media-match/media.match.min.js"></script>
    		<script src="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/vendor/respond/respond.min.js"></script>
		<![endif]-->

		<script src="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/vendor/modernizr/modernizr.min.js" type="text/javascript"></script>
	</head>
	<body>
		<nav class="navbar navbar-default navbar-secondary navbar-fixed">
			<div class="grid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#main-navbar-collapse" aria-expanded="false">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
				</div>

				<div class="collapse navbar-collapse" id="main-navbar-collapse">
					<ul class="nav navbar-nav">
						<?php
							if(!$isMaintenance) {
						?>
							<?php
								if(strtolower($settings->HomepageNews) != 'true' && (int) $settings->HomepageNews != 1) {
							?>
							<li<?php if($pageId == 'indexView') { ?> class="active"<?php } ?>>
								<a href="<?php echo SITE_PATH; ?>" class="text-uppercase"><?php echo $language['Menu']['Homepage']; ?></a>
							</li>
							<?php
								}
							?>

							<li<?php if($pageId == 'newsView') { ?> class="active"<?php } ?>>
								<a href="<?php echo SITE_PATH; ?>/news" class="text-uppercase"><?php echo $language['Menu']['News']; ?></a>
							</li>
							<li class="dropdown<?php if($pageId == 'categoryView') { ?> active<?php } ?>">
								<a href="#" class="dropdown-toggle text-uppercase" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
									<?php echo $language['Menu']['Categories']; ?> <span class="ion ion-android-arrow-dropdown"></span>
								</a>

								<ul class="dropdown-menu multi-level" role="menu" aria-labelledby="dropdownMenu">
									<?php
										$categories = $categoryFactory->getAll(false, null, 'order', OrderTypes::DESC);
										foreach($categories as $category) {
									?>
									<li>
										<a href="<?php echo SITE_PATH; ?>/category/<?php echo $category->getRow()->id; ?>">
											<?php echo htmlspecialchars($category->getRow()->name); ?>
										</a>
									</li>
									<?php
										}
									?>
								</ul>
							</li>
							<li<?php if($pageId == 'faqView') { ?> class="active"<?php } ?>>
								<a href="<?php echo SITE_PATH; ?>/faq" class="text-uppercase"><?php echo $language['Menu']['FAQ']; ?></a>
							</li>
							<li<?php if($pageId == 'tutorialsView') { ?> class="active"<?php } ?>>
								<a href="<?php echo SITE_PATH; ?>/tutorials" class="text-uppercase"><?php echo $language['Menu']['Tutorials']; ?></a>
							</li>
						<?php
							}
						?>
						
						<?php
							if(count($controller->getMultilingual()->getLanguages()) > 1) {
						?>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle text-uppercase" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
								<span class="a-link"><?php echo $language['Header']['Language']; ?></span>
								<?php echo $language['Language']; ?> <span class="ion ion-android-arrow-dropdown"></span>
							</a>

							<ul class="dropdown-menu">
								<?php
									foreach($controller->getMultilingual()->getLanguages() as $lang) {
										if($lang->getCode() == $controller->getLanguage()->getCode()) continue;
								?>
								<li>
									<a href="<?php echo SITE_PATH; ?>/language/<?php echo strtolower($lang->getCode()); ?>" class="text-uppercase"><?php echo $lang->getName(); ?></a>
								</li>
								<?php
									}
								?>
							</ul>
						</li>
						<?php
							}
						?>
					</ul>
					<ul class="nav navbar-nav navbar-right">
						<li>
							<a href="xmpp:<?php echo $settings->JabberID; ?>"><?php echo htmlspecialchars($settings->JabberID); ?> <i class="ion ion-ios-chatboxes"></i></span></a>
						</li>
						<li class="no-hover">
							<a>
								<?php echo $language['Header']['Rate']; ?>
								<span class="a-link-no-hover">
									<?php
										$rateJSON = json_decode(file_get_contents('https://bitpay.com/api/rates', false, stream_context_create(['http'=> [
											'timeout' => 3000
										]])), true);

										$rate = round($rateJSON[2]['rate'], 2) * 100;

										echo number_format(intval($rate)/100, 2, ',', '.') . ' ' . $rateJSON[2]['code'];
									?>
								</span>
							</a>
						</li>

						<?php
							if($controller->getUser() == null && !$isMaintenance) {
						?>
						<li<?php if($pageId == 'loginView') { ?> class="active"<?php } ?>>
							<a href="<?php echo SITE_PATH; ?>/login" class="text-uppercase"><?php echo $language['Header']['Login']; ?></a>
						</li>
						<li<?php if($pageId == 'registerView') { ?> class="active"<?php } ?>>
							<a href="<?php echo SITE_PATH; ?>/register" class="text-uppercase"><?php echo $language['Header']['Register']; ?></a>
						</li>
						<?php
							} else if(!$isMaintenance) {
						?>
						<li class="no-hover">
							<a>
								<?php echo $language['Header']['Balance']; ?>
								<span class="a-link-no-hover">
									<?php echo number_format(intval($controller->getUser()->getRow()->balance)/100, 2, ',', '.'); ?>
									<?php echo strtoupper($settings->Currency); ?>
								</span>
							</a>
						</li>

						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo htmlspecialchars($controller->getUser()->getRow()->username); ?> <span class="ion ion-android-arrow-dropdown"></span></a>

							<ul class="dropdown-menu">
								<li>
									<a href="<?php echo SITE_PATH; ?>/account">
										<i class="ion ion-person"></i>
										<?php echo $language['Header']['UserPanel']['MyAccount']; ?>
									</a>
								</li>
								<li>
									<a href="<?php echo SITE_PATH; ?>/account/histories">
										<i class="ion ion-ios-list"></i>
										<?php echo $language['Header']['UserPanel']['MyHistories']; ?>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a href="<?php echo SITE_PATH; ?>/account/deposit">
										<i class="ion ion-social-bitcoin"></i>
										<?php echo $language['Header']['UserPanel']['Deposit']; ?>
									</a>
								</li>
								<li>
									<a href="<?php echo SITE_PATH; ?>/account/btc/transactions">
										<i class="ion ion-document-text"></i>
										<?php echo $language['Header']['UserPanel']['BitcoinTransactions']; ?>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a href="<?php echo SITE_PATH; ?>/account/tickets">
										<i class="ion ion-help-buoy"></i>
										<?php echo $language['Header']['UserPanel']['MyTickets']; ?>
									</a>
								</li>
								<li role="separator" class="divider"></li>
								<li>
									<a href="<?php echo SITE_PATH; ?>/logout">
										<i class="ion ion-android-exit"></i>
										<?php echo $language['Header']['UserPanel']['Logout']; ?>
									</a>
								</li>
							</ul>
						</li>
						<?php
							}
						?>
					</ul>
				</div>
			</div>
		</nav>

		<div class="navbar-height"></div>

		<header>
			<div class="grid grid-p">
				<div class="header-content">
					<div class="row">
						<div class="col-md-4">
							<a href="<?php echo SITE_PATH; ?>">
								<div class="logo"></div>
							</a>
						</div>
						<?php
							if(!$isMaintenance) {
						?>
						<div class="col-md-4">
							<form action="<?php echo SITE_PATH; ?>/search" method="post" class="mobile-margin-top">
								<div class="input-group">
									<input type="text" class="form-control" name="search_input" placeholder="<?php echo $language['Header']['Search']['Placeholder']; ?>" />
									<span class="input-group-btn">
										<button class="btn btn-secondary" type="submit"><?php echo $language['Header']['Search']['Button']; ?></button>
									</span>
								</div>
							</form>
						</div>
						<?php
							}
						?>
					</div>
				</div>
			</div>
		</header>

		<main id="main">
			<div class="grid grid-p">
				<?php
					if(strlen($settings->InfoBoxText) > 0) {
				?>
				<div class="alert alert-warning">
					<div class="ion ion-ios-information-outline"></div>
					<p>
						<b class="title"><?php echo $settings->InfoBoxTitle; ?></b>
						<?php echo $settings->InfoBoxText; ?>
					</p>
				</div>
				<?php
					}
				?>