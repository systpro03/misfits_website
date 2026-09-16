
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cors
{
    function handle_cors_preflight()
    {
        // This API is public, so allow browser clients from any origin.
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization');
        if ($_SERVER[ 'REQUEST_METHOD' ] === 'OPTIONS') {
            http_response_code(204);
            exit();
        }
    }
}