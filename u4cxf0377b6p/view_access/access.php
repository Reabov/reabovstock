<?
$loactionAccess = array($GLOBALS['ar_define_settings']['DOMAIN']);
$paramHideSite = true;
foreach ($loactionAccess as $domainKey) {
	if( substr_count($_SERVER['HTTP_HOST'], $domainKey)>0 ){
	    $paramHideSite = false;
	}
}

if( isset($_POST['code']) && $paramHideSite && strtolower(trim($_POST['code']))==='captcha'){
    $_SESSION['view_control'] = 1;
}

/*if($paramHideSite && !isset($_SESSION['view_control'])){
    $arAccessList = file_get_contents($_SERVER['DOCUMENT_ROOT']."/access.ip");
    $arAccessList = explode("\n", $arAccessList); 
    foreach ($arAccessList as $key => $value) {
        $arAccessList[$key] = trim($value);
    }
    if( in_array($_SERVER['REMOTE_ADDR'], $arAccessList) ){
        $paramHideSite = false;
    }
}*/

if($paramHideSite && !isset($_SESSION['view_control'])){
    header('HTTP/1.0 403 Forbidden');
    include($_SERVER['DOCUMENT_ROOT']."/". WS_PANEL ."/view_access/get_access.php");
    exit;
}


