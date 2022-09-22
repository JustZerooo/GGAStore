<?php
	/**
	 * @author gwork
	 */
	use GWork\System\GWORK;

	use GWork\System\Common;
	use GWork\System\Application;
	use GWork\System\Configuration;

	use GWork\System\Configurations\Database;
	use GWork\System\Configurations\Paths;

	use GWork\System\Helpers\Templates\TplManager;

	use GWork\System\Utils\Routing\Router;
	use GWork\System\Utils\Routing\Managers\RouteManager;
	use GWork\System\Utils\Routing\Collectors\RouteCollector;
	use GWork\System\Utils\Routing\RouterResult;
	use GWork\System\Utils\Routing\Interfaces\IRoute;
	use GWork\System\Utils\Routing\RouteInfoResults;

	use GWork\System\Patterns\MVC\Controllers\Collectors\ControllerCollector;
	use GWork\System\Patterns\MVC\Controllers\ControllerParameters;

	use GWork\System\Patterns\MVC\Templates\Managers\TemplateManager;
	use GWork\System\Patterns\MVC\Templates\View;

	use GWork\System\Patterns\MVC\Models\Handlers\ModelsManager;
	use GWork\System\EventListener\Managers\EventManager;
	use GWork\System\TemplateListener\Managers\TemplateListenerManager;

	use GWork\System\Plugin\PluginInfo;
	use GWork\System\Plugin\PluginManager;

	use GWork\System\Models\Settings\SettingsFactory;

	define('phpPath', $phpPath);
	define('gworkPath', $gworkPath);
	define('DIR_SPLITTER', '/');

	spl_autoload_register(function($className) {
		$classNameSplit = explode('\\', $className);
		$class = implode(DIR_SPLITTER, $classNameSplit);
		if(file_exists($class . '.php')) {
	    	require_once $class . '.php';
		} else {
			if(file_exists(gworkPath . DIR_SPLITTER . $class . '.php')) {
				require_once gworkPath . DIR_SPLITTER . $class . '.php';
			} else if(file_exists(phpPath . DIR_SPLITTER . 'Libraries' . DIR_SPLITTER . $class . '.php')) {
				require_once phpPath . DIR_SPLITTER . 'Libraries' . DIR_SPLITTER . $class . '.php';
			}
		}
 	});

	GWORK::setVersion(GWORK_VERSION);

	$template = $configuration->template;
	
	$configuration = new Configuration($configuration);
	$database = new Database($configuration->getDatabaseSettings());
	$paths = new Paths($configuration->getPaths());

	# Creates database connection
	$connection = new PDO(
		$database->getString(),
		$database->getUsername(),
		$database->getPassword()
	);

	$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	$connection->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND, "SET NAMES 'utf8' COLLATE 'utf8_general_ci'");
	$connection->exec('SET NAMES \'utf8\'');
	mb_internal_encoding('UTF-8');

	Common::init($configuration);
	GWORK::setConfiguration($configuration);
	
	# Loads templates
	$tplManager = new TplManager($paths, $template);

	# Creates main objects
	$application = new Application($configuration, $connection, $tplManager);

	$routeCollector = new RouteCollector();
	$controllerCollector = new ControllerCollector();
	$templateManager = new TemplateManager($paths);
	$modelsManager = new ModelsManager($connection);

	GWORK::setSettings($modelsManager->get(SettingsFactory::class));

	// Initialize plugins
	$pluginManager = new PluginManager($modelsManager);
	$pluginManager->initialize();

	// Adds plugins to the list
	foreach($pluginManager->getPlugins() as $plugin) {
		$pluginManager->add($plugin);
	}

	GWORK::setPluginManager($pluginManager);

	$templateListenerManager = new TemplateListenerManager($modelsManager, $pluginManager);
	$templateListenerManager->loadTemplateListeners();
	$templateListenerManager->createTemplateListenerHandler();

	$eventManager = new EventManager($modelsManager, $pluginManager);
	$eventManager->loadEventListeners();
	$eventManager->createEventHandler();

	$controllerParameters = new ControllerParameters(
		$application,
		$controllerCollector,
		$templateManager,
		new View(),
		$modelsManager,
		$eventManager,
		$templateListenerManager
	);

	GWORK::setControllerParameters($controllerParameters);

	# Loads controllers
	$applicationPath = $paths->getPhpPath() . $paths->getApplicationPath()['directory'];
	$controllersPath = $paths->getApplicationPath()['controllers'];

	if(is_dir($applicationPath . $controllersPath)) {
		loadControllers($applicationPath . $controllersPath, $controllersPath);
	}

	// Load plugins
	foreach($pluginManager->getPlugins() as $plugin) {
		if($pluginManager->isPluginLoaded($plugin['package'])) {
			loadPlugin($plugin, $paths->getPhpPath() . $paths->getPluginsPath()['directory']);
		}
	}

	function loadPlugin($plugin, $dir) {
		global $paths, $modelsManager;

		$pluginPackage = str_replace('.', DIR_SPLITTER, $plugin['package']);
		$dir .= DIR_SPLITTER . $pluginPackage;

		if(!is_dir($dir)) return;

		$pluginClass = $dir . DIR_SPLITTER . 'Plugin.php';
		if(file_exists($pluginClass)) {
			require_once $pluginClass;
			$pluginClassName = str_replace(DIR_SPLITTER, '\\', $paths->getPluginsPath()['directory']) . '\\' . str_replace(DIR_SPLITTER, '\\', $pluginPackage) . '\\Plugin';

			$pluginObject = new $pluginClassName($plugin, $modelsManager);

			loadPluginControllers($plugin, $paths->getPhpPath() . $paths->getPluginsPath()['directory']);

			$pluginObject->onConstructed();
		}
	}

	function loadPluginControllers($plugin, $dir) {
		global $paths;

		$pluginPackage = str_replace('.', DIR_SPLITTER, $plugin['package']);
		$dir = $dir . DIR_SPLITTER . $pluginPackage . $paths->getPluginsPath()['controllers'];

		if(!is_dir($dir)) return;
		loadControllers($dir, $pluginPackage, $plugin);
		GWORK::setPluginData($plugin['package'], $plugin);
	}

	function loadControllers($dir, $classPath, $plugin = null) {
		global $paths, $controllerCollector, $controllerParameters;

		$controllers = scandir($dir);
		foreach($controllers as $file) {
			$path = pathinfo($file);

			if(strtolower($path['extension']) == 'php') {
				$directory = explode($classPath, $dir);

				$namespace = require_once $dir . DIR_SPLITTER . $path['basename'];

				$controller =  str_replace(DIR_SPLITTER, '\\', $namespace . DIR_SPLITTER . $path['filename']);
				$controllerCollector->add(new $controller($controllerParameters, $plugin ?? null));
			} else if($file != '.' && $file != '..' && is_dir($dir . DIR_SPLITTER . $file)) {
				loadControllers($dir . DIR_SPLITTER . $file, $controllersPath . DIR_SPLITTER . $file, $plugin);
			}
		}
	}

	foreach($controllerCollector->getByInstance(IRoute::class) as $controller) {
	    foreach($controller->getRoutes() as $route) {
	        $routeCollector->add($route);
	    }
	}

	$routeManager = new RouteManager($routeCollector);
	$router = new Router($routeManager);

	define('BASE_DIR', $paths->getBaseDirectory());

	try {
	    $connection->exec('SET NAMES \'utf8\'');

	    $router->listenOn($router->getURLParameter('r'), function(RouterResult $routerResult) {
	        switch($routerResult->getState()) {
	            case RouteInfoResults::ACCESS_ALLOWED:
	                return $routerResult->callController();
	                break;

	            case RouteInfoResults::NOT_FOUND:
					$url = ((isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) == 'on')) ? 'https://' : 'http://' . $_SERVER['HTTP_HOST'];

					return header('Location: ' . $url . BASE_DIR . '/error');

	            break;
	        }
	    });
	} catch(Exception $ex) {
		echo $ex->getMessage();
	}
