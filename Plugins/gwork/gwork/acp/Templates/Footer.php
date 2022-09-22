<?php
	if(!defined('GWORK_FRAMEWORK')) exit;

	$settings = $this->settings->getValue();
	$controller = $this->this->getValue();
	
	$language = $controller->getLanguage()->json();
?>

							</section>
						</section>
						<a href="#" class="hide nav-off-screen-block" data-toggle="class:nav-off-screen" data-target="#nav"></a>
					</section>
				</section>
			</section>
		</section>
		
		<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/jquery.min.js"></script>
		
		<!-- Bootstrap -->
		<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/bootstrap.js"></script>
		
		<!-- App -->
		<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/app.js"></script>  
		<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/slimscroll/jquery.slimscroll.min.js"></script>
		<script src="<?php echo WEB_PATH; ?>/gwork/acp/js/app.plugin.js"></script>
	</body>
</html>