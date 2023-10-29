<?

$client = $Db->getone("SELECT * FROM `ws_clients` WHERE id = ".(int)$_GET['id']);
$update = $Db->q("UPDATE `ws_clients` SET activated = 1 WHERE id = ".(int)$_GET['id']);

$email = $client['email'];
$password = $client['password'];

//$auth = $Client->auth($email,$password);
//$Client->setUserData($client);

//$logo_path = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/images/elements/logo/logo-black.png';
$logo_path = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/images/icons/logo.png';

$Text = <<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" ></head>
<body><table border="0" cellpadding="0" cellspacing="0" style="max-width:600px !important;width: 100%;margin: 0 auto;" >
<tbody><tr><td><table border="0" cellpadding="0" cellspacing="0" style="max-width: 600px !important;width: 100%;padding: 0 20px"><tr><td>
            <img src="{$logo_path}" style="margin: 0 auto; display: block; margin-top: 50px; max-width: 565px; width: 100%;" alt="logo">
</td></tr></table></td></tr >
<tr ><td style="font-family: 'Tahoma';font-size: 50px;font-weight: 500;font-style: normal; text-transform: uppercase; text-align: center; padding-top: 88px; max-width: 434px; width: 100%;color: #000;">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_HI]} {$client[full_name]}
</td></tr>
<tr><td colspan="2" ><table border="0" cellpadding="0" cellspacing="0"  style="width: 100%;max-width: 600px;"><tr><div style="font-size: 30px; font-weight: 300; text-align: center; color: #000;line-height: 38px; margin: 0 auto;font-family: 'Tahoma'">
			{$GLOBALS[ar_define_langterms][MSG_LETTER_WELLCOME_ON_REABOV_STOCK]}
</div></tr></table></td></tr>
<tr><td colspan="2"><div style="font-family: 'Tahoma';font-size: 50px;font-weight: 500;max-width: 497px;margin: 0 auto;text-align: center;padding-bottom: 59px; padding-top: 39px; color: #44CE00; ">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_YOU_ARE_REGISTRATED]}
</div></td></tr>
<tr><td colspan="2" style="font-size: 29px; font-weight: 500; text-align: center; padding-bottom: 38px; font-family: 'Tahoma'">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_LOG_IN_AND_GET_YOUR_SUBSCRIPTION_PLAN_NOW]}
</td></tr>
<tr><td colspan="2"><a href="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}{$CCpu->writelink(79)}" style="display: block; margin: 0 auto; text-align: center; text-decoration: none; max-width: 210px; width: 100%; padding: 10px 0; background-color: #44CE00; color: #fff;border-radius: 19px;font-size: 21px; font-weight: 500; font-family: 'Tahoma'">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_GET_SUBSCRIPTION]}
</a></td></tr>
<tr><td colspan="2" ><table  cellpadding="0" cellspacing="0" style="width: 100%;padding: 80px 0;margin: 0 auto"><tr><td>
<a href="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}{$CCpu->writelink(1)}" style="text-decoration: none;font-size: 29px; font-weight: 300;color: #000;font-family: 'Tahoma'">
            {$_SERVER[SERVER_NAME]}
</a></td><td align="right" valign="bottom" style="font-size: 29px; font-weight: 300;color: #000;font-family: 'Tahoma'">        
            {$GLOBALS[ar_define_langterms][MSG_LETTER_ALL_RIGHTS_C_2023]}
</td></tr></table></td></tr>
</tbody></table></body></html>
HTML;


$Client->auth = true;
$Client->id = $client['id'];
$Client->name = $client['name'];
$Client->email = $client['email'];
        
$crypt = hash('sha512', uniqid() . time());
$_SESSION['user']['crypt'] = $crypt;
$Db->q("UPDATE ws_clients SET crypt = '".$crypt."' WHERE id = ".$_GET['id']." LIMIT 1");


$now = date("Y-m-d H:i:s", time());
$Db->q("UPDATE ws_clients SET last_auth_date = '".$now."' WHERE id = ".$_GET['id']);



include_once $_SERVER['DOCUMENT_ROOT'].'/lib/libmail/libmail.php';
$m= new Mail();
$m->From( $GLOBALS['ar_define_settings']['SMTP_MAIL'] );
$m->To( $email );
$m->Subject( $GLOBALS['ar_define_langterms']['MSG_LETTER_REGISTRACIYA_USPESHNO_ZAVERSHENA'] );
$m->Body($Text, "html");
$m->Priority(4);

$m->smtp_on($GLOBALS['ar_define_settings']['SMTP_SERVER'], $GLOBALS['ar_define_settings']['SMTP_MAIL'], $GLOBALS['ar_define_settings']['SMTP_PASS'], $GLOBALS['ar_define_settings']['SMTP_PORT']);
$m->log_on(true);
$a = $m->Send();


if($a){
	header('Location: '.$CCpu->writelink(80));
}


?>