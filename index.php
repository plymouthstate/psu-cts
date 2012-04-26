<?php

require_once 'autoload.php';

PSU::session_start(); // force ssl + start a session

$GLOBALS['BASE_URL'] = '/webapp/cts-new';
$GLOBALS['BASE_DIR'] = dirname(__FILE__);

$GLOBALS['TITLE'] = 'Classroom Technology Services Toolkit';
$GLOBALS['TEMPLATES'] = $GLOBALS['BASE_DIR'] . '/templates';

require_once $GLOBALS['BASE_DIR'] . '/includes/CTSAPI.class.php';
require_once $GLOBALS['BASE_DIR'] . '/includes/CTSemailAPI.class.php';
require_once $GLOBALS['BASE_DIR'] . '/includes/reserveDatabaseAPI.class.php';
require_once $GLOBALS['BASE_DIR'] . '/includes/CTSdatabaseAPI.class.php';
require_once 'klein/klein.php';

if( file_exists( $GLOBALS['BASE_DIR'] . '/debug.php' ) ) {
	include $GLOBALS['BASE_DIR'] . '/debug.php';
}

IDMObject::authN();

/*
if( ! IDMObject::authZ('permission', 'mis') ) {
	die('You do not have access to this application.');
}
*/

/**
 * Routing provided by klein.php (https://github.com/chriso/klein.php)
 * Make some objects available elsewhere.
 */
respond( function( $request, $response, $app ) {
	// initialize the template
	$app->tpl = new PSUTemplate;

	// get the logged in user
	$app->user = PSUPerson::get( $_SESSION['wp_id'] ); 

	// assign user to template
	$app->tpl->assign( 'user', $app->user );
	
});


// klein catch-all
respond( '[*]', function( $request, $response, $app ) {
	$app->tpl->assign('date_format','%m-%d-%Y');
	$app->tpl->assign('time_format','%l:%M %p');
});

respond( '/?', function( $request, $response, $app ) {
	$app->tpl->display('index.tpl');
});


$app_routes = array(
	'reserve',//user page for reservations
	'history',//pending and past reservations
	'admin',//admin page with all current reservations and equipment
	'user'
);

foreach( $app_routes as $base ) {
	with( "/{$base}", $GLOBALS['BASE_DIR'] . "/routes/{$base}.php" );
}//end foreach

dispatch( $_SERVER['PATH_INFO'] );
