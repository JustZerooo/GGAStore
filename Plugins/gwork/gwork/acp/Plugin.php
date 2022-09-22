<?php
	/**
	 * @author gwork
	 */

	namespace Plugins\gwork\gwork\acp {
	    use GWork\System\Plugin\BasePlugin;
	    use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;

	    final class Plugin extends BasePlugin {
			const PLUGIN_PACKAGE = 'gwork.gwork.acp';

			/**
			 * @see GWork\System\Plugin\BasePlugin::__construct()
			 */
			public function __construct(array $pluginData, ModelsManager $modelsManager) {
				parent::__construct($pluginData, $modelsManager);
	        }

			/**
			 * @see GWork\System\Plugin\BasePlugin::onConstructed()
			 */
			public function onConstructed() {
				parent::onConstructed();
	        }
	    }
	}
