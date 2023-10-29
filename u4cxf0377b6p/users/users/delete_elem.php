<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include.php");
include("settings.php");

$id = (int)$_GET['id'];
if( $User->InGroup($_params['access_delete']) ){
        
    $getUserImg = mysqli_query($db, "SELECT image FROM `".$_params['table']."` WHERE id = ".$id);    
    $USER = mysqli_fetch_assoc($getUserImg);
    
    $del = mysqli_query($db, "DELETE FROM `".$_params['table']."` WHERE `id`='".$id."'");
    unlink($_SERVER['DOCUMENT_ROOT'].$_params['image'].$USER['image']);
    
    header("Location: ".$_SERVER['HTTP_REFERER']);
    
    
}else{
    ?>
    <div class="alert alert-danger">ERROR. NO PERMISSIONS</div>
    <?
}
?>