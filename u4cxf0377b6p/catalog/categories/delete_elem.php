<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include.php");
include("settings.php");

if( $User->InGroup($_params['access_delete']) )
{
   
    $old_page = $_SERVER['HTTP_REFERER'];
    
    if ( !isset($id) ):        
        header("Location: ".$old_page);
        exit;
    else:
	
		$get_elem = mysqli_query($db,"SELECT * FROM `".$_params['table']."` WHERE `id`='".$id."'");
		$el = mysqli_fetch_assoc($get_elem);
		
		unlink($_SERVER["DOCUMENT_ROOT"].$_params['image'].$el['image']);
		
		$get_elem = mysqli_query($db,"SELECT * FROM ws_catalog_elements WHERE section_id = ".$id);
        while( $elem = mysqli_fetch_assoc($get_elem) ){
        	$get_image = mysqli_query($db,"SELECT * FROM ws_catalog_elements_images WHERE elem_id = ".$elem['id']);
	        while( $image = mysqli_fetch_assoc($get_image) ){
	        	unlink($_SERVER["DOCUMENT_ROOT"].'/upload/catalog/products/'.$image['image']);
				unlink($_SERVER["DOCUMENT_ROOT"].'/upload/catalog/products/thumb/'.$image['image']);
			}		
             $delete = mysqli_query($db, "DELETE FROM `ws_catalog_elements_images` WHERE elem_id = '".$elem['id']."'");			
			$delete = mysqli_query($db, "DELETE FROM `ws_catalog_elements_reviews` WHERE elem_id = '".$elem['id']."'");
			 $delete = mysqli_query($db, "DELETE FROM `ws_catalog_element_tag` WHERE elem_id = '".$elem['id']."'");
        }
		$delete = mysqli_query($db, "DELETE FROM `ws_catalog_elements` WHERE section_id = '".$id."'");
		
		$get_elem = mysqli_query($db,"SELECT * FROM ws_tags WHERE catalog_id = ".$id);
        while( $elem = mysqli_fetch_assoc($get_elem) ){
			 $delete = mysqli_query($db, "DELETE FROM `ws_catalog_element_tag` WHERE tag_id = '".$elem['id']."'");
        }
		$delete = mysqli_query($db, "DELETE FROM `ws_tags` WHERE catalog_id = '".$id."'");
		
		
        // стандарные блоки удаления
        $del_elem = mysqli_query($db, "DELETE FROM `".$_params['table']."` WHERE `id`='".$id."'");
        $delete = mysqli_query($db, "DELETE FROM `ws_cpu` WHERE page_id = '".$_params['page_id']."' AND elem_id = '".$id."'");
        
		/*
        $get_elem = mysqli_query($db,"SELECT * FROM ws_photogallery WHERE page_id = ".$_params['page_id']." AND `elem_id`='".$id."'");
        while( $elem = mysqli_fetch_assoc($get_elem) ){
            unlink($_SERVER["DOCUMENT_ROOT"].'/upload/gallery/'.$elem['image']);
			unlink($_SERVER["DOCUMENT_ROOT"].'/upload/gallery/'.$elem['icon']);
            unlink($_SERVER["DOCUMENT_ROOT"].'/upload/gallery/thumb/'.$elem['image']);
        }
*/
        header("Location: ".$old_page);
        
		//	$delete = mysql_query("DELETE FROM `ws_mailer` WHERE news_id = '".$id."'");

        header("Location: ".$old_page);
        
    endif;
}
?>