<?
$arachis_req_files = array(
	'arachis-func-post-types.php',
	'arachis-functions.php',
	'widgets/tasks-due-soon.php',
	'widgets/tasks-overdue.php'
);

foreach ( $arachis_req_files as $include ) :
	require_once( $include );
endforeach;