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
        
		$get_var = $Db->getall("SELECT * FROM `ws_categories_variation` WHERE section_id = ".$id);
		foreach ($get_var as $key => $var) {
			$del_size = $Db->q("DELETE FROM `ws_categories_elements_size` WHERE var_id = ".$var['id']);
		}
		$del_var = $Db->q("DELETE FROM `ws_categories_variation` WHERE section_id = ".$id);
		$del_size = $Db->q("DELETE FROM `ws_categories_elements_size` WHERE elem_id = ".$id);
		$del_col = $Db->q("DELETE FROM `ws_collections_products` WHERE product_id = ".$id);
		$del_tag = $Db->q("DELETE FROM `ws_tags` WHERE elem_id = ".$id);
		
        $get_elem = mysqli_query($db,"SELECT * FROM ws_photogallery WHERE page_id = ".$_params['page_id']." AND `elem_id`='".$id."'");
        while( $elem = mysqli_fetch_assoc($get_elem) ){
            unlink($_SERVER["DOCUMENT_ROOT"].'/upload/gallery/'.$elem['image']);
            unlink($_SERVER["DOCUMENT_ROOT"].'/upload/gallery/thumb/'.$elem['image']);
        }
        header("Location: ".$old_page);
        
    endif;
}
?>