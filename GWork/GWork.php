<?php
	/**
	 * @author 	gwork
	 */

	define('GWORK_FRAMEWORK', 1);
	define('GWORK_NAME', 'GWork');
	define('GWORK_VERSION', '2.3.1');

	$configuration = require_once __DIR__ . '/Configuration.php';

	@set_time_limit(0);
	@ini_set('memory_limit', -1);
	@ini_set('post_max_size', $configuration->post_max_size);
	@ini_set('upload_max_filesize', $configuration->upload_max_filesize);

	$mode = 'Production';
	if(strtolower($configuration->mode) == 'development') {
		$mode = 'Development';
	}

	if($configuration->upload_tmp_dir != null) {
		ini_set('upload_tmp_dir', $configuration->upload_tmp_dir);
	}

	if($configuration->session_save_path != null) {
		ini_set('session.save_path', $configuration->session_save_path);
	}

   	if(session_status() === PHP_SESSION_NONE) session_start();

	require_once __DIR__ . '/Modes/' . $mode . '.php';
	require_once __DIR__ . '/System/Setup.php';
