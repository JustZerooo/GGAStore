<?php
	/**
	 * @author gwork
	 */

	# Subfolder example:
	# $basedir = '/subfolder';
	$basedir = '';

	$phpPath = $_SERVER['DOCUMENT_ROOT'] . $basedir;
	$gworkPath = $phpPath . '/GWork';

	define('ONLY_SSL', false);
	
	function getProtocol() {
		return (strtolower(substr($_SERVER['SERVER_PROTOCOL'], 0, 5)) == 'https' || ONLY_SSL) ? 'https' : 'http';
	}
	
	define('SYS_PATH', $phpPath);

	define('SITE_PATH', getProtocol() . '://' . $_SERVER['HTTP_HOST']);
	define('WEB_PATH', '//' . $_SERVER['HTTP_HOST'] . '/web');

	# Choose a random key that contains alphanumeric characters with lower and uppercase.
	define('PRIVATE_KEY', 'da943mvjW399cMS219dw48gRWED8tfwao5hGKJHsdf5fg==');

	return (object) [
		# Production or Development
		'mode' => 'Production',

		# Default template
		'template' => 'Default',

		# PHP Settings
		'upload_max_filesize' => '5024M',
		'post_max_size' => '2048M',

		# Paths for temps (null to use the default path from php.ini)
		'session_save_path' => null,
		'upload_tmp_dir' => null,

		# Prefix for sessions
		'session_prefix' => 'GWORK_',

		# Application paths
		'paths' => (object) [
			# Without gwork or php path
			'uploads'		=> (object) [
				'products' => '/uploads/images/'
			],

			'framework' 	=> $gworkPath,
			'basedir'		=> $basedir,
			'phpPath'		=> $phpPath,

			'application'	=> [
				'directory'		=> '/Application',
				'controllers'	=> '/Controllers',
				'templates' 	=> '/Templates',
				'languages'		=> '/Languages'
			],

			'plugins' 		=> [
				'directory' 	=> '/Plugins',
				'controllers'	=> '/Controllers',
				'templates' 	=> '/Templates',
				'languages'		=> '/Languages'
			]
		],

		# Database connection
		'database' => (object) [
			'hostname'	=> 'localhost',
			'username'	=> 'root',
			'password'	=> 'kurd4life$',
			'database'	=> 'PSNStore',
			'prefix'	=> 'shop_',  # so lassen!
			'string'	=> 'mysql:host=%hostname%;dbname=%database%;charset=utf8'
		]
	];
