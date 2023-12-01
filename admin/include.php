<?
	ini_set('zlib.output_compression', 'On');
	ini_set('zlib.output_compression_level', '1');

	session_start();

    error_reporting( 0 );

    include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/config.php");
    
    date_default_timezone_set($GLOBALS['timezone']);

	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include/db.php");
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include/CMain.php");
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include/CCpu.php");
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include/CDb.php");
	
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include/functions.php");

	$CCpu = new CCpu();
	$Main = new CMain();
	$Db = new CDb();
	
	$GLOBALS['ar_define_settings'] = $Main->GetDefineSettings();
	
	
//	include($_SERVER['DOCUMENT_ROOT']."/". WS_PANEL ."/view_access/access.php");
	
	if( substr_count($_SERVER['REQUEST_URI'], "/". WS_PANEL ."/")>0 ){
	    include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include/CUser.php");
	    $User = new CUser(); 
	    $CCpu->lang = $User->lang;
		
	    $GLOBALS['CPLANG'] = $User->GetDefineLangTerms( $User->interface_lang );
	    $Admin = $User;
	}else{
		include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include/CClient.php");
		$Client = new CClient();
		
		if(!$Client->auth){
			if(isset($_COOKIE['saved_email'])){
				$userData = $Db->getone("SELECT * FROM ws_clients WHERE email = '".$_COOKIE['saved_email']."' AND active = 1 ");
				if($userData != array()){
					$Client->auth = true;
        			$Client->id = $userData['id'];
        			$Client->name = $userData['name'];
        			$Client->email = $userData['email'];
					
        			$crypt = hash('sha512', uniqid() . time());
					
        			$_SESSION['user']['crypt'] = $crypt;
        			$Db->q("UPDATE ws_clients SET crypt = '".$crypt."' WHERE id = ".$Client->id." LIMIT 1");
					
					$now = date("Y-m-d H:i:s", time());
        			$Db->q("UPDATE ws_clients SET last_auth_date = '".$now."' WHERE id = ".$Client->id);
					
				}
			}
		}
		
		
	}
	
	$GLOBALS['auth_fields'] = array('email');
	