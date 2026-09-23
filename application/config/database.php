<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| InfinityFree database settings
|--------------------------------------------------------------------------
| Get these from your InfinityFree control panel > MySQL Databases.
| Hostname is usually something like sqlXXX.infinityfree.com
| Username/Database usually look like epiz_XXXXXXXX_misfits
*/
$active_group = 'default';
$query_builder = TRUE;

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => '',
	'username' => 'if0_42879278',
	'password' => 'Misfits2026',
	'database' => 'if0_42879278_misfits_data',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8mb4',
	'dbcollat' => 'utf8mb4_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
