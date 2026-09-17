<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$active_group = 'default';
$query_builder = TRUE;

$is_local = (
	isset($_SERVER['SERVER_NAME']) && 
	in_array($_SERVER['SERVER_NAME'], array('localhost', '127.0.0.1', '::1'))
) || (
	isset($_SERVER['HTTP_HOST']) && 
	(
		$_SERVER['HTTP_HOST'] === 'localhost' || 
		$_SERVER['HTTP_HOST'] === '127.0.0.1' || 
		preg_match('/\.test$/', $_SERVER['HTTP_HOST'])
	)
) || (
	php_sapi_name() === 'cli'
);

if ($is_local) {
	// Local Laragon Configuration
	$db_user = 'root';
	$db_pass = '';
	$db_name = 'jg_enterprise';
} else {
	// Hosting cPanel Configuration
	$db_user = 'masr2113_jurnalguru';
	$db_pass = 'jurnalguru2026.';
	$db_name = 'masr2113_jurnal';
}

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => 'localhost',
	'username' => $db_user,
	'password' => $db_pass,
	'database' => $db_name,
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8mb4',
	'dbcollat' => 'utf8mb4_unicode_ci',
	'swap_pre' => '',
	'encrypt'  => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);

