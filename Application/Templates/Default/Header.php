<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;
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

		<!--
		<meta name="description" content="" />
		<meta name="keywords" content="" />
		-->
				
		<!--
		<meta property="og:image" content="" />
		-->
		<meta property="og:locale" content="de_DE" />
		<meta property="og:type" content="website" />
		<meta property="og:title" content="<?php echo htmlspecialchars($pageName); ?>" />
		<!--
		<meta property="og:description" content="" />
		-->
		<meta property="og:url" content="<?php echo SITE_PATH; ?>" />
		<meta property="og:site_name" content="<?php echo htmlspecialchars($pageName); ?>" />
		
		<meta name="twitter:card" content="summary" />
		<!--
		<meta name="twitter:description" content="" />
		-->
		<meta name="twitter:title" content="<?php echo htmlspecialchars($pageName); ?>" />

		<meta name="language" content="de" />
		<meta name="audience" content="all" />
		<meta name="cache-control" content="no-cache" />
		<meta name="robots" content="index,follow" />
		<meta name="pragma" content="no-cache" />

		<link rel="canonical" href="<?php echo SITE_PATH; ?>" />

		<!-- Favicon -->
  		<link rel="shortcut icon" href="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/favicon.ico" />

		<!-- Fonts -->
		<link rel="stylesheet" type="text/css" href="<?php echo WEB_PATH; ?>/GWork/fonts/ionicons/ionicons.css" />
		<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:400,700italic,700,600italic,600,400italic,300italic,300,800italic,800" />

		<!-- Site -->
		<link rel="stylesheet" type="text/css" href="<?php echo WEB_PATH; ?>/GWork/css/site/style.css" />

		<!--[if lt IE 9]>
			<script src="<?php echo WEB_PATH; ?>/GWork/vendor/html5shiv/html5shiv.min.js"></script>
		<![endif]-->

		<!--[if lt IE 10]>
			<script src="<?php echo WEB_PATH; ?>/GWork/vendor/media-match/media.match.min.js"></script>
    		<script src="<?php echo WEB_PATH; ?>/GWork/vendor/respond/respond.min.js"></script>
		<![endif]-->

		<script src="<?php echo WEB_PATH; ?>/GWork/vendor/modernizr/modernizr.js" type="text/javascript"></script>
	</head>
	<body>
		<!--[if lt IE 8]>
			<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
		<![endif]-->
