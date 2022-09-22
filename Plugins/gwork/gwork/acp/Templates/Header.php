<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="de" lang="de" class="app">
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
  		<link rel="shortcut icon" href="<?php echo WEB_PATH; ?>/gwork/acp/favicon.ico" />

		<!-- Stylesheets -->
		<link rel="stylesheet" href="<?php echo WEB_PATH; ?>/gwork/acp/css/bootstrap.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo WEB_PATH; ?>/gwork/acp/css/animate.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo WEB_PATH; ?>/gwork/acp/css/font-awesome.min.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo WEB_PATH; ?>/gwork/acp/css/icon.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo WEB_PATH; ?>/gwork/acp/css/font.css" type="text/css" />
		<link rel="stylesheet" href="<?php echo WEB_PATH; ?>/gwork/acp/css/app.css" type="text/css" />

		<!--[if lt IE 9]>
			<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/ie/html5shiv.js"></script>
			<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/ie/respond.min.js"></script>
			<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/ie/excanvas.js"></script>
		<![endif]-->
	</head>
	<body>
		<section class="vbox">
			<header class="bg-white header header-md navbar navbar-fixed-top-xs box-shadow">
				<div class="navbar-header aside-md dk">
					<a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav">
						<i class="fa fa-bars"></i>
					</a>
					<a href="<?php echo SITE_PATH; ?>/admin" class="navbar-brand">
						<img src="<?php echo WEB_PATH; ?>/gwork/acp/images/logo.png" class="m-r-sm" alt="logo" />
						<span class="hidden-nav-xs"><?php echo $language['Header']['Title']; ?></span>
					</a>
					<a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".user">
						<i class="fa fa-cog"></i>
					</a>
				</div>
				<ul class="nav navbar-nav hidden-xs">
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="i i-grid"></i>
						</a>
						<section class="dropdown-menu aside-lg bg-white on animated fadeInLeft">
							<div class="row m-l-none m-r-none m-t m-b text-center">
								<div class="col-xs-12">
									<div class="padder-v">
										<a href="<?php echo SITE_PATH; ?>/admin/system/settings">
											<span class="m-b-xs block">
												<i class="i i-cog2 i-2x text-warning"></i>
											</span>
											<small class="text-muted"><?php echo $language['Menu']['System']['Settings']['Name']; ?></small>
										</a>
									</div>
								</div>
							</div>
						</section>
					</li>
					<li>
						<a href="<?php echo SITE_PATH; ?>" target="_homepage">
							<span><?php echo $language['Header']['OpenHomepage']; ?></span>
						</a>
					</li>
				</ul>
				<ul class="nav navbar-nav navbar-right m-n hidden-xs nav-user user">
					<li class="hidden-xs">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<i class="i i-chat3"></i>
							<span class="badge badge-sm up bg-danger count">0</span>
						</a>
						<section class="dropdown-menu aside-xl animated flipInY">
							<section class="panel bg-white">
								<div class="panel-heading b-light bg-light">
									<strong>Benachrichtigungen <span class="count">0</span></strong>
								</div>
								<div class="list-group list-group-alt">
								</div>
								<!--<div class="panel-footer text-sm">
									<a href="#" class="pull-right"><i class="fa fa-cog"></i></a>
									<a href="#notes" data-toggle="class:show animated fadeInRight"></a>
								</div>-->
							</section>
						</section>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">
							<span class="thumb-sm avatar pull-left">
								<img src="<?php echo WEB_PATH; ?>/gwork/acp/images/a0.png" />
							</span>
							<?php echo htmlspecialchars($controller->getUser()->getRow()->username); ?> <b class="caret"></b>
						</a>
						<ul class="dropdown-menu animated fadeInRight">
							<li>
								<span class="arrow top"></span>
								<a href="<?php echo SITE_PATH; ?>/account">
									<?php echo $language['Header']['UserPanel']['Menu']['Settings']; ?>
								</a>
							</li>
							<li class="divider"></li>
							<li>
								<a href="<?php echo SITE_PATH; ?>/admin/logout">
									<?php echo $language['Header']['UserPanel']['Menu']['Logout']; ?>
								</a>
							</li>
						</ul>
					</li>
				</ul>
			</header>

			<section>
				<section class="hbox stretch">
					<aside class="bg-black aside-md hidden-print" id="nav">
						<section class="vbox">
							<section class="w-f scrollable">
								<div class="slim-scroll" data-height="auto" data-disable-fade-out="true" data-distance="0" data-size="10px" data-railOpacity="0.2">
									<div class="clearfix wrapper dk nav-user hidden-xs">
										<div class="dropdown">
											<a href="#" class="dropdown-toggle" data-toggle="dropdown">
												<span class="thumb avatar pull-left m-r">
													<img src="<?php echo WEB_PATH; ?>/gwork/acp/images/a0.png" class="dker" style="background-color: #ffffff;" />
													<i class="on md b-black"></i>
												</span>
												<span class="hidden-nav-xs clear">
													<span class="block m-t-xs">
														<strong class="font-bold text-lt">
															<?php echo htmlspecialchars($controller->getUser()->getRow()->username); ?>
														</strong>
														<b class="caret"></b>
													</span>
													<span class="text-muted text-xs block"><?php echo htmlspecialchars($controller->getUser()->getRow()->mail); ?></span>
												</span>
											</a>
											<ul class="dropdown-menu animated fadeInRight m-t-xs">
												<li>
													<span class="arrow top hidden-nav-xs"></span>
													<a href="<?php echo SITE_PATH; ?>/account">
														<?php echo $language['Header']['UserPanel']['Menu']['Settings']; ?>
													</a>
												</li>
												<li class="divider"></li>
												<li>
													<a href="<?php echo SITE_PATH; ?>/admin/logout">
														<?php echo $language['Header']['UserPanel']['Menu']['Logout']; ?>
													</a>
												</li>
											</ul>
										</div>
									</div>

									<nav class="nav-primary hidden-xs">
										<ul class="nav nav-main" data-ride="collapse">
											<li<?php if($pageId == 'dashboardView') echo ' class="active"'; ?>>
												<a href="<?php echo SITE_PATH; ?>/admin/dashboard" class="auto">
													<i class="i i-statistics icon"></i>
													<span class="font-bold"><?php echo $language['Dashboard']['PageName']; ?></span>
												</a>
											</li>
											<?php
												if($controller->getUser()->hasPermissionByName('ACCESS_CATALOG')) {
											?>
											<li<?php if($pageId == 'catalogView') echo ' class="active"'; ?>>
												<a href="#" class="auto">
													<span class="pull-right text-muted">
														<i class="i i-circle-sm-o text"></i>
														<i class="i i-circle-sm text-active"></i>
													</span>
													<i class="i i-cart icon"></i>
													<span class="font-bold"><?php echo $language['Menu']['Catalog']['Name']; ?></span>
												</a>
												<ul class="nav dk">
													<li>
														<a href="<?php echo SITE_PATH; ?>/admin/catalog/categories" class="auto">
															<i class="i i-dot"></i>
															<span><?php echo $language['Menu']['Catalog']['Categories']['Name']; ?></span>
														</a>
													</li>
													<li>
														<a href="<?php echo SITE_PATH; ?>/admin/catalog/products" class="auto">
															<i class="i i-dot"></i>
															<span><?php echo $language['Menu']['Catalog']['Products']['Name']; ?></span>
														</a>
													</li>
												</ul>
											</li>
											<?php
												}
											?>
											<li<?php if($pageId == 'systemView') echo ' class="active"'; ?>>
												<a href="#" class="auto">
													<span class="pull-right text-muted">
														<i class="i i-circle-sm-o text"></i>
														<i class="i i-circle-sm text-active"></i>
													</span>
													<i class="i i-cog2 icon"></i>
													<span class="font-bold"><?php echo $language['Menu']['System']['Name']; ?></span>
												</a>
												<ul class="nav dk">
													<li>
														<a href="<?php echo SITE_PATH; ?>/admin/system/plugins" class="auto">
															<i class="i i-dot"></i>
															<span><?php echo $language['Menu']['System']['Plugins']['Name']; ?></span>
														</a>
													</li>
													<?php
														if($controller->getUser()->hasPermissionByName('ACCESS_SETTINGS')) {
													?>
													<li>
														<a href="<?php echo SITE_PATH; ?>/admin/system/settings" class="auto">
															<i class="i i-dot"></i>
															<span><?php echo $language['Menu']['System']['Settings']['Name']; ?></span>
														</a>
													</li>
													<?php
														}
													?>
												</ul>
											</li>
											<li<?php if($pageId == 'usersView') echo ' class="active"'; ?>>
												<a href="#" class="auto">
													<span class="pull-right text-muted">
														<i class="i i-circle-sm-o text"></i>
														<i class="i i-circle-sm text-active"></i>
													</span>
													<i class="i i-users2 icon"></i>
													<span class="font-bold"><?php echo $language['Menu']['Users']['Name']; ?></span>
												</a>
												<ul class="nav dk">
													<li>
														<a href="<?php echo SITE_PATH; ?>/admin/users" class="auto">
															<i class="i i-dot"></i>
															<span><?php echo $language['Menu']['Users']['Name']; ?></span>
														</a>
													</li>
													<li>
														<a href="<?php echo SITE_PATH; ?>/admin/users/tickets" class="auto">
															<i class="i i-dot"></i>
															<span><?php echo $language['Menu']['Users']['Tickets']['Name']; ?></span>
														</a>
													</li>
													<li>
														<a href="<?php echo SITE_PATH; ?>/admin/users/coupons" class="auto">
															<i class="i i-dot"></i>
															<span><?php echo $language['Menu']['Users']['Coupons']['Name']; ?></span>
														</a>
													</li>
												</ul>
											</li>
										</ul>
										<div class="line dk hidden-nav-xs"></div>
									</nav>
								</div>
							</section>
							<footer class="footer hidden-xs no-padder text-center-nav-xs">
								<a href="#nav" data-toggle="class:nav-xs" class="btn btn-icon icon-muted btn-inactive m-l-xs m-r-xs">
									<i class="i i-circleleft text"></i>
									<i class="i i-circleright text-active"></i>
								</a>
							</footer>
						</section>
					</aside>

					<section id="content">
						<section class="vbox">
							<header class="header bg-light dk">
								<p><?php echo htmlspecialchars($this->pageName); ?></p>
							</header>
							<section class="scrollable wrapper">
