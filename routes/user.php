<?php

respond ('/', function( $request, $response, $app){
$app->tpl->assign('step', $_SESSION['cts']['step']);
$app->tpl->display( 'user-home.tpl' );

});

respond ('/delete', function( $request, $response, $app){
	unset($_SESSION['cts']);
	$response->redirect($GLOBALS['BASE_URL'] . '/user/'); 
});
