<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include.php");
include("settings.php");

if( $User->InGroup($_params['access_delete']) )
{
    
    $old_page = $_SERVER['HTTP_REFERER'];
    
    if ( !isset($id) || $id == 0 ):        
        header("Location: ".$old_page);
        exit;
    else:
        // стандарные блоки удаления
        $del_elem = mysqli_query($db, "DELETE FROM `".$_params['table']."` WHERE `id`='".$id."'");
		$delete = mysqli_query($db, "DELETE FROM `ws_cpu` WHERE page_id = '".$_params['page_id']."' AND elem_id = '".$id."'");
        
        $get_elem = mysqli_query($db,"SELECT * FROM ws_photogallery WHERE page_id = ".$_params['page_id']." AND `elem_id`='".$id."'");
        while( $elem = mysqli_fetch_assoc($get_elem) ){
            unlink($_SERVER["DOCUMENT_ROOT"].'/upload/gallery/'.$elem['image']);
            unlink($_SERVER["DOCUMENT_ROOT"].'/upload/gallery/thumb/'.$elem['image']);
        }
        header("Location: ".$old_page);
        
    endif;
}
?>