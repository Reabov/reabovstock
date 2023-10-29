<?
unset($_SESSION['user']['crypt']);
setcookie("saved_email", '', time()-3600,'/');  /* expire in 1 hour */
header('Location:'.$CCpu->writelink(1));
?>