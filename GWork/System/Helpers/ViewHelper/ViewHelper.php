<?php
	/**
	 * @author gwork
	 */

	namespace GWork\System\Helpers\ViewHelper {
		use GWork\System\Patterns\MVC\Controllers\Controller;

		use GWork\System\Patterns\MVC\Templates\Template;
		use GWork\System\Patterns\MVC\Templates\Managers\TemplateManager;

		use GWork\System\Models\Settings\SettingsFactory;

	    final class ViewHelper {
			/**
			 * @param Controller	$controller
			 * @param string 		$file
 			 * @param string 		$pageId
 			 * @param array			$vars
 			 * @param array			$viewVars
 			 * @param bool			$usePluginPath
			 */
			public static function create(Controller $controller, string $file, string $pageId = '', array $vars = [], array $viewVars = [], bool $usePluginPath = false): View {
				$settings = $controller->getControllerParameters()->getModelsManager()->get(SettingsFactory::class);

				if(!$usePluginPath) {
					$templateDir = $controller->getTplManager()->getTemplate($settings->Template)->getDirectoryName();

					$file = $templateDir . DIR_SPLITTER . $file;
				}

				$pluginInfo = $usePluginPath ? $controller->getPluginInfo() : null;
				$tpl = $controller->getControllerParameters()->getTemplateManager()->make($file, $pluginInfo);

				foreach($vars as $var => $val) {
					$tpl->{$var} = $val;
				}

				foreach($viewVars as $var => $val) {
					$tpl->{$var} = $val;
					$vars[$var] = $val;
				}

				$tpl->variables = $vars;

				$tpl->pageId = $pageId;
				$tpl->this = $controller;

				$tpl->settings = $settings;

				// Create view
				return new View($controller, $tpl);
			}
	    }
	}
