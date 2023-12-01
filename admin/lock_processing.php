<?
/**
* Обработка формы авторизации
* 
* @copyright    Copyright (c) 2016, Studio Webmaster, https://www.webmaster.md
* @version      3.1 Date: 2017-06-04
* @link         /ws/lock.php
*/

include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include.php");
if( ( isset($_POST['login']) && $_POST['login'] ) and ( isset($_POST['pass']) && $_POST['pass'] ) )
{
	if(isset($_SESSION['captcha_keystring']) && $_SESSION['captcha_keystring'] == $_POST['keystring']){
	
		$ar_clean_post = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $login = str_replace(array(" ","`","'","\"","(",")","<",">","/*","--","\\"), "", $ar_clean_post['login']);
        
        $login = mb_substr( $login, 0, 25, 'UTF-8');
	
		$pass = hash('sha512', $ar_clean_post['pass']); 
        $pass = hash('sha512', $pass.$GLOBALS['security_salt']);
	
		
		$result = mysqli_query($db, "SELECT * FROM `ws_users` WHERE `login`='".$login."' AND `pass`='".$pass."' LIMIT 1");
		if ( mysqli_num_rows($result)!==1 )
		{
			$_SESSION['auth_error'] = '<div class="alert alert-danger">'.$GLOBALS['CPLANG']['INVALID_LOGIN_OR_PASS'].'</div>';
		}
		else
		{
			$us_data = mysqli_fetch_array($result);
			if( $us_data['block'] == 1 )
			{
				$_SESSION['auth_error'] = '<div class="alert alert-danger">'.$GLOBALS['CPLANG']['ACCOUNT_IS_BLOCKED'].'</div>';
			}
			else if ( $us_data['active'] == 0 )
			{

                $_SESSION['auth_error'] = '<div class="alert alert-danger">'.$GLOBALS['CPLANG']['ACCOUNT_IS_BLOCKED'].'</div>';
            }
			else
			{
				// запоминаем пользователя.
				$login_crypt = crypt($login);
				$res_mem = mysqli_query($db, "UPDATE ws_users SET login_crypt='".$login_crypt."', `auth_date` = NOW() WHERE login='".$login."'");
				
				$_SESSION['admin']['login']  = $login; 
				$_SESSION['admin']['mem']    = $login_crypt;
                $_SESSION['admin']['content_verification'] = $us_data['content_verification'];
			}       
		}
		
	}else{
	    $_SESSION['auth_error'] = '<div class="alert alert-danger">'.$GLOBALS['CPLANG']['INVALID_CAPTCHA'].'</div>';
	}  
}


unset($_SESSION['captcha_keystring']);

if( $_SERVER['HTTP_REFERER'] )
    header("Location: ".$_SERVER['HTTP_REFERER']);
else
    header("Location: /". WS_PANEL ."/");
?>