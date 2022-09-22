<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$pageId = !$this->pageId->isNull() ? $this->pageId->getValue() : null;
	$pageName = !$this->pageName->isNull() ? $settings->SiteName . ' - ' . htmlspecialchars($this->pageName) : $settings->SiteName;
?>
		<!-- BEGIN Scripts -->

		<!-- Core -->
		<script src="<?php echo WEB_PATH; ?>/GWork/vendor/jquery/jquery.js" type="text/javascript"></script>

		<!-- Site -->
		<script src="<?php echo WEB_PATH; ?>/GWork/js/site.js" type="text/javascript"></script>

		<script>
			var site = new Site();
			$(document).ready(function() {
				site.run();
			});
		</script>
		<!-- END Scripts -->
	</body>
</html>
