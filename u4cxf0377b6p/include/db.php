<?
	$db =  mysqli_connect($SERVER_NAME, $DB_LOGIN, $DB_PASS, $DB_NAME);
	mysqli_set_charset( $db , "utf8" );
	
	if(mysqli_connect_error($db)){
        exit( 'error code: 803' );
	}
?>