<?php
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include.php");

if( define_client_ip() != '95.65.81.152' && define_client_ip() != '89.28.90.195' && define_client_ip() != '89.28.56.188' ) {
    exit();
}

if( isset( $_POST['pass'] ) ) {

    $ar_clean_post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

    $pass = hash('sha512', $ar_clean_post['pass']);
    $pass = hash('sha512', $pass.$GLOBALS['security_salt']);

    echo($pass);
}
?>

<form method="post" action="">
    <input type="text" placeholder="Пароль" autocomplete="off" name="pass">
    <input type="submit" value="Отправить">
</form>
