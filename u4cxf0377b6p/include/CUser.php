<?
/**
* Class for work on users
* 
* @author       Barcov Vadim <barkov.vadim@webmaster.md>  Cisnir Simion <cusnir.simion@webmaster.md>
* @copyright    Copyright (c) 2012, Webmaster Studio, https://www.webmaster.md
* @version      4.1 Date: 2016-10-12
* @link         /ws/include.php
*/
class CUser
{
    var $lang;
    var $langs;
    var $ar_lang;
    var $user_id;
    var $user_group;
    var $user_name;
    var $auth_date;
    var $skin;
	var $image;
    var $interface_lang;
    
    function __construct(){
        global $db;
        $getCurrentLangs = mysqli_query($db, " SELECT * FROM ws_site_languages ORDER BY sort DESC ");
        while( $cLang = mysqli_fetch_assoc($getCurrentLangs) ){
            $this->langs[$cLang['code']] = $cLang;
        }
        if( isset($_SESSION['admin']['login']) ){
            $getMyLang = mysqli_query($db, " SELECT `lang`,`interface_lang` FROM ws_users WHERE login = '".$_SESSION['admin']['login']."' ");
            $myLang = mysqli_fetch_assoc($getMyLang);
            $this->lang = $myLang['lang'];
            $this->interface_lang = $myLang['interface_lang'];
            $this->ar_lang = array_keys($this->langs);
        }else{
            $getMyLang = mysqli_query($db," SELECT `code` FROM ws_site_languages WHERE is_default = 1 ");
            $myLang = mysqli_fetch_assoc($getMyLang);
            $this->lang = $myLang['value'];
            $this->ar_lang = array_keys($this->langs);
        }
        $this->user_id = $this->GetID();
		if( isset($_SESSION['admin']['mem']) ){
			$_mem = $_SESSION['admin']['mem'];
		}else{
			$_mem = '';
		}
        $getGroup = mysqli_query($db, "SELECT * FROM ws_users WHERE login_crypt='".$_mem."' LIMIT 1");
        $userGroup = mysqli_fetch_assoc($getGroup);
        $this->user_group = $userGroup['usergroup'];
        $this->user_name = $userGroup['user_name'];
        $this->auth_date = $userGroup['auth_date'];
        $this->skin = $userGroup['skin'];
        $this->image = $userGroup['image'];
        $this->interface_lang = $userGroup['interface_lang'];
    }
    
    
       
    public function GetID(){ 
        global $db;
    
        $id = 0;
        $mem = false;
        if( isset( $_SESSION["admin"]["mem"] ) ){
            $mem = $_SESSION["admin"]["mem"];
        }
        if ( $mem )
        {
            $user_id_res = mysqli_query($db, "SELECT id FROM ws_users WHERE login_crypt='".$mem."' LIMIT 1");
            if( $user_id = mysqli_fetch_array($user_id_res) )
            {
                $id  = $user_id['id'];
            }
        }
        return $id;
    }  

    // Проверка, авторизован ли пользователь
    public function IsAuthorized(){
        global $db; 
        if( isset($_SESSION['admin']["mem"]) && $_SESSION['admin']["mem"] )
        {
            $s_mem = mysqli_query($db, "SELECT * FROM ws_users WHERE login_crypt='".$_SESSION['admin']['mem']."' LIMIT 1");
            if( mysqli_num_rows($s_mem) )
            {
                $ar_mem = mysqli_fetch_array($s_mem);
                if( $ar_mem['block'] )
                    return false;
                else
                {
                    $_SESSION['admin']['login']  = $ar_mem['login'];                    
                    $_SESSION['admin']['mem']    = $ar_mem['login_crypt'];
                    return true;
                }            
            }
            else
            {
                unset($_SESSION['admin']['mem']);
                return false;
            }
        }
        else
        {
            return false;
        }
    }


    public function InGroup ( $group_id ){
    
        global $db;
        if( isset( $_SESSION['admin']['mem'] ) && $_SESSION['admin']['mem'] )
        {
            $mem = $_SESSION['admin']['mem'];
            
            if( is_array($group_id) )
            {
                $group =  implode(',', array_filter($group_id, "is_abs")); 
                $user_group_res = mysqli_query($db, "SELECT id FROM ws_users WHERE login_crypt='".$mem."' AND usergroup IN (".$group.")");
            }
            else
            {
                // проверим, ежели это не склееный массив
                if( substr_count($group_id, ',')>0 ){
                	$group_id = preg_replace('/[^\d,]/','',$group_id); 
                	$user_group_res = mysqli_query($db, "SELECT id FROM ws_users WHERE login_crypt='".$mem."' AND usergroup IN (".$group_id.")");
					if( mysqli_num_rows($user_group_res) ){
						return true;
					}else{
						return false;
					}
					
                }else{
                	$user_group_res = mysqli_query($db, "SELECT id FROM ws_users WHERE login_crypt='".$mem."' AND usergroup='".(int)$group_id."'");
                }	
					
                
            }
			
            if( mysqli_num_rows($user_group_res) )            
                return true;
            else
                return false;
        }    
        else
            return false;
    }


    /*
	public function GetDefineLangTerms($Userlang)
	{
		global $db;
		// проверим, если есть языковая версия для языка пользователя
		$getLangVer = mysqli_query($db, " SELECT id FROM ws_site_languages WHERE code = '".mb_substr($Userlang, 0, 2)."' AND active = 1 "); 
		if( mysqli_num_rows($getLangVer)!==1 ){ 
			$getDefaultLang = mysqli_query($db, "SELECT code FROM ws_inteface_lang ORDER BY id ASC LIMIT 1");
			$DL = mysqli_fetch_assoc($getDefaultLang); 
			$Userlang = $DL['code']; 
		}
		$arLang = array();
		$getLangValues = mysqli_query($db, "SELECT code, text FROM ws_inteface_lang_content WHERE lang = '".$Userlang."' "); 
		return array_column(mysqli_fetch_all($getLangValues, MYSQLI_ASSOC), 'text','code' ); 
	}*/

    public function GetDefineLangTerms($Userlang)
    {
        global $db;
        // проверим, если есть языковая версия для языка пользователя
        $getLangVer = mysqli_query($db, " SELECT id FROM ws_site_languages WHERE code = '".mb_substr($Userlang, 0, 2)."' AND active = 1 ");
        if( mysqli_num_rows($getLangVer)!==1 ){
            $getDefaultLang = mysqli_query($db, "SELECT code FROM ws_inteface_lang ORDER BY id ASC LIMIT 1");
            $DL = mysqli_fetch_assoc($getDefaultLang);
            $Userlang = $DL['code'];
        }
        // $arLang = array();
        // $getLangValues = mysqli_query($db, "SELECT code, text FROM ws_inteface_lang_content WHERE lang = '".$Userlang."' ");
        // return array_column(mysqli_fetch_all($getLangValues, MYSQLI_ASSOC), 'text','code' );

        $getLangValues = mysqli_query($db, "SELECT code, text FROM ws_inteface_lang_content WHERE lang = '".$Userlang."' ");
        $a=0;
        $array=array();
        while ( $t = mysqli_fetch_assoc($getLangValues) ){
            $array[$t['code']]=$t['text'];
            $a++;
        }
        return $array;
    }
	
	
}
?>