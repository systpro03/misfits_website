<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route[ 'default_controller' ] = 'home';
$route[ 'translate_uri_dashes' ] = FALSE;
$route[ '404_override' ] = '';

/* -------------------- Public site -------------------- */
$route[ 'about' ] = 'home/about';
$route[ 'rides' ] = 'rides/index';
$route[ 'rides/upcoming' ] = 'rides/upcoming';
$route[ 'upcoming_api' ] = 'rides/upcoming_rides_api';
$route[ 'rides/past' ] = 'rides/past';
$route[ 'rides/(:num)' ] = 'rides/view/$1';
$route[ 'members' ] = 'members/index';
$route[ 'gallery' ] = 'gallery/index';
$route[ 'gallery/submit' ] = 'gallery/submit';
$route[ 'contact' ] = 'home/contact';
$route[ 'suggest_route' ] = 'home/suggested_route';
$route[ 'messages' ] = 'message/messages';
$route[ 'send' ] = 'message/send';

/* -------------------- Admin auth -------------------- */
$route[ 'admin' ] = 'admin_dashboard/index';
$route[ 'admin/login' ] = 'admin_auth/login';
$route[ 'admin/logout' ] = 'admin_auth/logout';
$route[ 'admin/dashboard' ] = 'admin_dashboard/index';

/* -------------------- Admin: rides -------------------- */
$route[ 'admin/rides' ] = 'admin_rides/index';
$route[ 'admin/rides/add' ] = 'admin_rides/add';
$route[ 'admin/rides/edit/(:num)' ] = 'admin_rides/edit/$1';
$route[ 'admin/rides/delete/(:num)' ] = 'admin_rides/delete/$1';




/* -------------------- Admin: routes -------------------- */
$route[ 'admin/routes' ] = 'admin_routes/index';
$route[ 'admin/routes/add' ] = 'admin_routes/add';
$route[ 'admin/routes/edit/(:num)' ] = 'admin_routes/edit/$1';
$route[ 'admin/routes/delete/(:num)' ] = 'admin_routes/delete/$1';


$route[ 'admin/vote_route/(:num)' ] = 'home/vote_route/$1';
$route[ 'admin/routes/approve/(:num)' ] = 'admin_routes/approve/$1';
$route[ 'admin/routes/reject/(:num)' ] = 'admin_routes/reject/$1';
$route[ 'admin/routes/undo/(:num)' ] = 'admin_routes/undo/$1';

/* -------------------- Admin: members -------------------- */
$route[ 'admin/members' ] = 'admin_members/index';
$route[ 'admin/members/add' ] = 'admin_members/add';
$route[ 'admin/members/edit/(:num)' ] = 'admin_members/edit/$1';
$route[ 'admin/members/delete/(:num)' ] = 'admin_members/delete/$1';

/* -------------------- Admin: gallery / requests -------------------- */
$route[ 'admin/gallery' ] = 'admin_gallery/index';
$route[ 'admin/gallery/add' ] = 'admin_gallery/add';
$route[ 'admin/gallery/delete/(:num)' ] = 'admin_gallery/delete/$1';
$route[ 'admin/requests' ] = 'admin_requests/index';
$route[ 'admin/requests/approve/(:num)' ] = 'admin_requests/approve/$1';
$route[ 'admin/requests/reject/(:num)' ] = 'admin_requests/reject/$1';
$route[ 'admin/requests/delete/(:num)' ] = 'admin_requests/delete/$1';
$route[ 'admin/requests/bulk-approve' ] = 'admin_requests/bulk_approve';
$route[ 'admin/requests/bulk-delete' ] = 'admin_requests/bulk_delete';

/* -------------------- Admin: chat -------------------- */
$route[ 'admin/index' ] = 'admin_chat/index';
$route[ 'admin/messages' ] = 'admin_chat/messages';
$route[ 'admin/send' ] = 'admin_chat/send';
$route[ 'admin/mark-read' ] = 'admin_chat/mark_read';
$route[ 'admin/delete/(:num)' ] = 'admin_chat/delete/$1';

/* -------------------- Admin: site settings -------------------- */
$route[ 'admin/settings' ] = 'admin_settings/index';
