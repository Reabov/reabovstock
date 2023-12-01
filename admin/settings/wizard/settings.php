<?

// полчим адрес раздела 
$pathSection = str_replace(basename($_SERVER['SCRIPT_NAME']), '', $_SERVER['SCRIPT_NAME']);
$pathSection = str_replace( WS_PANEL , '{WS_PANEL}' , $pathSection );
$getSection = mysqli_query($db,"SELECT * FROM ws_menu_admin WHERE link = '".$pathSection."'");
$Section = mysqli_fetch_assoc($getSection);
$_params['table'] = "ws_menu_admin";
$_params['title'] = $Section['title'];
// параметры раздела

$getSectionParams = mysqli_query($db,"SELECT * FROM ws_menu_admin_settings WHERE section_id = ".$Section['id']);
while($SectionParam = mysqli_fetch_assoc($getSectionParams)){
    $SectionParam['value'] = str_replace( '{WS_PANEL}' , WS_PANEL ,  $SectionParam['value'] );
    $_params[$SectionParam['param']] = $SectionParam['value'];
}
if (isset($_GET['id'])) {$id = (int)$_GET['id'];}else{$id = 0;} 

$standartparams = array('access_delete','num_page','page_id');

?>