<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();

	$language = $controller->getLanguage()->json();
?>
			</div>
		</main>

		<footer id="footer">
			<div class="footer-bg">
				<div class="grid grid-p">
					<p>
						<?php echo $language['Footer']['PaymentMethods']; ?>
					</p>

					<p>
						<img class="payment-method" src="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/images/bitcoin.png" />
						<img class="payment-method" src="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/images/paysafecard.png" />
					</p>
				</div>
			</div>
			<?php
				if(!defined('HIDE_COPYRIGHT')) {
			?>
			<div class="footer">
				<div class="grid grid-p">
					<p class="copyright">
						<?php
							$year = (int) $settings->StartYear;
							if($year < date('Y')) {
								$year .= ' - ' . date('Y');
							}

							echo str_replace(['%year%', '%url%', '%site_name%'], [$year, SITE_PATH, $settings->SiteName], $language['Footer']['Copyright']);
							echo ' ';
							echo str_replace(['%pluginName%', '%version%'], [$controller->getPluginInfo()->getName(), $controller->getPluginInfo()->getVersion()], $language['Footer']['Version']);
						?>
					</p>
				</div>
			</div>
			<?php
				}
			?>
		</footer>

		<!-- BEGIN Scripts -->

		<!-- Core -->
		<script src="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/vendor/jquery/jquery.min.js" type="text/javascript"></script>
		<script src="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/vendor/bootstrap/bootstrap.min.js" type="text/javascript"></script>
		<script src="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/vendor/mousewheel/jquery.mousewheel.min.js" type="text/javascript"></script>
		<script src="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/vendor/breakpoints/breakpoints.js" type="text/javascript"></script>

		<script type="text/javascript">
			$(window).setBreakpoints();
		</script>

		<!-- Site -->
		<script src="<?php echo WEB_PATH; ?>/<?php echo $settings->Style; ?>/assets/js/site.js" type="text/javascript"></script>

		<script type="text/javascript">
			var site = new Site();
			$(document).ready(function() {
				site.run();
			});
		</script>

		<script src="https://www.google.com/recaptcha/api.js" type="text/javascript"></script>
		<!-- END Scripts -->
	</body>
</html>
