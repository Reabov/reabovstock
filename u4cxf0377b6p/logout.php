<?
	session_start();
	
	unset($_SESSION['login']);
	unset($_SESSION['pass']);
	unset($_SESSION['mem']);
	
	setcookie( "mem", "", time()-2592000, "/" );
	
	session_unset();
	session_destroy();
	
	header("Location: ".$_SERVER['HTTP_REFERER']);
?>