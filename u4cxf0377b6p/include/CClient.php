<?
/**
* 
* @copyright    Copyright (c) 2019, Studio Webmaster, https://www.webmaster.md
* @author       Cusnir Simion
* @version      1.0 Date: 2019-02-06
*/
class CClient extends CDb
{
    
    var $id;
    var $name;
    var $type;
    var $email;
    var $auth;
    var $Db;
    
    
    function __construct() {
        
        global $Db;
        $this->Db = $Db;
        
        $this->auth = false;
        
        if( isset($_SESSION['user']['crypt']) ){
            
            $userData = $this->Db->getone("
            SELECT * FROM ws_clients WHERE `crypt` = '".$_SESSION['user']['crypt']."'  AND active = 1 "); 

            if( $userData != NULL ){
                $this->setUserData($userData);
            }
        }
    }
    
    
    
    private function setUserData($userData)
    {
        $this->auth = true;
        $this->id = $userData['id'];
        $this->name = $userData['name'];
        $this->email = $userData['email'];
        
        $crypt = hash('sha512', uniqid() . time());
        
        $_SESSION['user']['crypt'] = $crypt;
        $this->Db->q("UPDATE ws_clients SET crypt = '".$crypt."' WHERE id = ".$this->id." LIMIT 1");
        return true;
    }
    
    
    
    public function getHash($password)
    {
        $hash = hash('sha512', trim($password));
        $hash = hash('sha512', $hash.$GLOBALS['security_salt']);
        return $hash;
    }
    
    
    
    public function auth( $login, $password )
    {
        $passwordHash = $this->getHash($password); 
        $arFieldsCondition = array();
        foreach ($GLOBALS['auth_fields'] as $field) {
            $arFieldsCondition[]=" `".$field."` = '".$login."' ";
        }
        $filedsCondition = implode(" OR ", $arFieldsCondition); 
        
        $userData = $this->Db->getone("SELECT * FROM ws_clients WHERE (".$filedsCondition.") AND password = '".$passwordHash."' AND active = 1 ");

        if( $userData != NULL ){
            $this->setUserData($userData);
            $now = date("Y-m-d H:i:s", time());
            $this->Db->q("UPDATE ws_clients SET last_auth_date = '".$now."' WHERE id = ".$this->id);
            return true;
        }else{
            return false;
        }
        
    }
    
    
    
    public function register($arFields, $arData, $login, $password)
    {
        $passwordHash = $this->getHash($password);
        $now = date("Y-m-d H:i:s", time()); 
            
        $arFields = array_merge($arFields, array("password","registration_date"));
        $strFields = implode(",", $arFields);
        
        $arData = array_merge($arData, array("'".$passwordHash."'","NOW()"));
        $strData = implode(",", $arData); 
            
        $addResult = $this->Db->add("INSERT INTO ws_clients (".$strFields.") VALUES (".$strData.") ");  
        if( $addResult!=0 && $addResult!=false && $addResult!=NULL ){
            return $this->auth($login, $password);
        }else{
            return false;
        }
        

    }
    
    /*
    CREATE TABLE `ws_clients` (
      `id` int(11) NOT NULL,
      `active` tinyint(1) NOT NULL DEFAULT '1',
      `name` varchar(130) NOT NULL,
      `email` varchar(130) NOT NULL,
      `password` varchar(384) NOT NULL,
      `last_auth_date` datetime NOT NULL,
      `auth_ip` int(11) NOT NULL,
      `date` datetime NOT NULL,
      `crypt` varchar(128) NOT NULL,
      `registration_date` datetime NOT NULL
    ) ENGINE=MyISAM DEFAULT CHARSET=utf8;
    
    ALTER TABLE `ws_clients`
      ADD PRIMARY KEY (`id`);
    
    ALTER TABLE `ws_clients`
      MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
    COMMIT;
    
        
    */
    
    
}