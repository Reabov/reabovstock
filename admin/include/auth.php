<?

/* if user is uthorised  - fast variant */
function auth()
{
	
	//return true;
	//exit;
	//$_SESSION['user_agent']!=$_SERVER['HTTP_USER_AGENT']
	
	if( 
		!isset($_SESSION['user_id']) || 
		!is_numeric($_SESSION['user_id']) || 
		!isset($_SESSION['user_addr']) || 
		$_SESSION['user_addr']!=ip2long($_SERVER['REMOTE_ADDR'])
		|| $_SESSION['user_agent']!=$_SERVER['HTTP_USER_AGENT'] ){
			
		return false;
		
	}else{
		
		return true;
		
	}
}

function authorize()
{
	global $_security_salt , $db;
	
	if( !isset($_POST['email']) || !isset($_POST['password']) || strlen($_POST['email'])<3 || strlen($_POST['password'])<4 ){
		return 'error';
	}
	
	$ar_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
	
	$pass = hash('sha512', trim($ar_clean['password']));
    $pass = hash('sha512', $pass.$_security_salt);

	
	$email = trim($ar_clean['email']);
	
	
	$getUser = mysqli_query( $db , " SELECT * FROM ws_clients WHERE email = '".$email."'
						AND password = '".$pass."' AND active = 1 LIMIT 1");
	
	if( mysqli_num_rows($getUser)===1 ){
		
		$User = mysqli_fetch_assoc($getUser);
		
		if($User['block']==1 || $User['active']==0 ){
			
			return $GLOBALS['ar_define_langterms']['MSG_ALL_OUNT_HAS_BEEN_SUSPENDED_OR_WAS_NOT_ACTIVATED'];
			
		}else{
			
			$crypt = hash('sha512', uniqid());
			$user_agent = $_SERVER['HTTP_USER_AGENT'];
			
			
			if(!isset($_SESSION['auth']['hash']) || $_SESSION['auth']['hash']=='' || !$_SESSION['auth']['hash']){
				$_SESSION['auth']['hash'] = $_COOKIE['PHPSESSID'];
			}
			
			$oldHash = $User['hash'];
			$hash = md5(time().$email);
			//control_basket_authorize( $oldHash , $hash );
			
			mysqli_query( $db , " 
			UPDATE ws_clients 
			SET logyn_crypt = '".$crypt."', auth_ip = '".ip2long($_SERVER['REMOTE_ADDR'])."', 
			user_agent = '".$user_agent."', hash = '".$hash."' , last_auth = NOW() 
			WHERE id = ".$User['id']);
			
			$_SESSION['user_id'] 	= $User['id'];
			$_SESSION['user_addr']	= ip2long($_SERVER['REMOTE_ADDR']);
			$_SESSION['user_agent'] = $user_agent;
			$_SESSION['user_crypt'] = $crypt;
			$_SESSION['auth']['hash'] = $hash;
			
			return '+';
			
		}
		
	}else{
		return $GLOBALS['ar_define_langterms']['MSG_ALL_INVALID_AUTHORIZATION_DATA'];
	}
	
	
}
