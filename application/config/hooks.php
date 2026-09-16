<?php

defined('BASEPATH') OR exit('No direct script access allowed');

$hook['pre_system'][] = array(
    'function' => 'handle_cors_preflight',
    'filename' => 'Cors.php',
    'filepath' => 'hooks'
);