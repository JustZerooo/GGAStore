<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	use \GWork\System\Helpers\ViewHelper\ViewHelper;
	use \Plugins\gwork\gwork\acp\Utils\CSRF\CSRF;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;

	$errorMessage = !$this->errorMessage->isNull() ? $this->errorMessage->getValue() : null;
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
		<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
			<div class="container aside-xl">
				<a class="navbar-brand block" href="<?php echo SITE_PATH; ?>/admin"><?php echo $language['Header']['Title']; ?></a>
				<section class="m-b-lg">
					<header class="wrapper text-center">
						<strong><?php echo $language['Login']['PageName']; ?></strong>
					</header>
					
					<?php
						if(!$this->errorMessage->isNull()) {
					?>
					<div class="alert alert-danger"><?php echo $this->errorMessage->getValue(); ?></div>
					<?php
						}
					?>
					
					<form action="<?php echo SITE_PATH; ?>/admin/login" method="post">
						<input type="hidden" name="csrf_token" value="<?php echo CSRF::getCSRFToken($controller); ?>" />
					
						<div class="list-group">
							<div class="list-group-item">
								<input type="text" name="login_username" value="<?php echo !$this->postUsername->isNull() ? $this->postUsername->getValue() : ''; ?>" placeholder="<?php echo $language['Login']['Username']['Placeholder']; ?>" class="form-control no-border">
							</div>
							<div class="list-group-item">
								<input type="password" name="login_password" placeholder="<?php echo $language['Login']['Password']['Placeholder']; ?>" class="form-control no-border">
							</div>
							<div class="list-group-item">
								<div class="g-recaptcha" data-sitekey="<?php echo htmlspecialchars($settings->RecaptchaSiteKey); ?>"></div>
							</div>
						</div>
						
						<button type="submit" class="btn btn-lg btn-primary btn-block"><?php echo $language['Login']['Button']; ?></button>
					</form>
				</section>
			</div>
		</section>
		
		<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/jquery.min.js"></script>
		
		<!-- Bootstrap -->
		<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/bootstrap.js"></script>
		
		<!-- App -->
		<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/app.js"></script>  
		<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/app.plugin.js"></script>
		
		<script src="https://www.google.com/recaptcha/api.js" type="text/javascript"></script>
	</body>
</html>
