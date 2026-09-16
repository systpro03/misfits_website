<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Base Site URL
|--------------------------------------------------------------------------
| IMPORTANT: When you upload this to InfinityFree, set this to your live
| domain, e.g. 'https://misfitsriders.infinityfreeapp.com/'
| Leave blank ('') to let CodeIgniter auto-detect it (works on most hosts).
*/
$config['base_url'] = 'https://misfits.lovestoblog.com/';

$config['index_page'] = '';

$config['uri_protocol'] = 'REQUEST_URI';

$config['url_suffix'] = '';

$config['language'] = 'english';

$config['charset'] = 'UTF-8';

$config['enable_hooks'] = TRUE;

$config['subclass_prefix'] = 'MY_';

$config['composer_autoload'] = FALSE;

$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

$config['log_threshold'] = 1;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';

$config['error_views_path'] = '';

$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;

$config['encryption_key'] = '07b746d55a75fee7547ea2c2e031fc773811b49d5095b0b03d42a0d397fc282c';
/*07b746d55a75fee7547ea2c2e031fc773811b49d5095b0b03d42a0d397fc282c*/

$config['session_driver'] = 'files';
$config['session_cookie_name'] = 'misfits_session';
$config['session_expiration'] = 7200;
$config['session_save_path'] = NULL;
$config['session_match_ip'] = FALSE;
$config['session_time_to_update'] = 300;
$config['session_regenerate_destroy'] = FALSE;

$config['cookie_prefix']   = '';
$config['cookie_domain']   = '';
$config['cookie_path']     = '/';

$config['cookie_secure'] = TRUE;
$config['cookie_httponly'] = TRUE;

$config['standardize_newlines'] = FALSE;

$config['global_xss_filtering'] = TRUE;

$config['csrf_protection'] = FALSE;
$config['csrf_token_name'] = 'csrf_token';
$config['csrf_cookie_name'] = 'csrf_cookie';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;
$config['csrf_exclude_uris'] = array();

$config['compress_output'] = FALSE;

$config['time_reference'] = 'local';

$config['rewrite_short_tags'] = FALSE;

$config['proxy_ips'] = '';
