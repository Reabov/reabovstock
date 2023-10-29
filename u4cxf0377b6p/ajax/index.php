<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER['DOCUMENT_ROOT']."/". WS_PANEL ."/include.php");

if(!isset($_POST) || empty($_POST) || !isset($_POST['task'])){exit;}

$ar_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

if( !$User->InGroup(array(1,2,3,4,5,6,7,8)) ){
    exit;
}




if($ar_clean['task']=="clear_name_param"){
    $val = $CCpu->translitURL($ar_clean['val']);

    $val = str_replace('-', '_', $val);

    echo $val;
}


if($ar_clean['task']=="refresh"){
    $elem_id = (int)$ar_clean['id'];
    $table = $ar_clean['table'];
    
    $get_data = mysqli_query($db, "SELECT active FROM `".$table."` WHERE `id`= ".$elem_id); 
    if ( $el = mysqli_fetch_array($get_data) )
    {
          
        if ( $el['active'] == 0 )
            $active = 1;
        if ( $el['active'] == 1 )
            $active = 0;               
            
        $ch_act = mysqli_query($db, "UPDATE `".$table."` SET active='$active' WHERE `id`= ".$elem_id); 
    }
    
}

if($ar_clean['task']=="block_elem"){
    $elem_id = (int)$ar_clean['id'];
    $table = $ar_clean['table'];
    
    $get_data = mysqli_query($db, "SELECT block FROM `".$table."` WHERE `id`='$elem_id'"); 
    if ( $el = mysqli_fetch_array($get_data) )
    {
        if ( $el['block'] == 0 )
            $block = 1;
        if ( $el['block'] == 1 )
            $block = 0;               
            
        $ch_act = mysqli_query($db, "UPDATE `".$table."` SET block='$block' WHERE `id`= ".$elem_id); 
    }
    
}

if($ar_clean['task']=="addfilesingallery"){ 
    $path = $_SERVER['DOCUMENT_ROOT']."/upload/gallery/";
    $resultFiles = array();
    $page_id = (int)$ar_clean['page_id'];
    $elem_id = (int)$ar_clean['elem_id'];

    $get_elem = mysqli_query($db,"SELECT * FROM ws_photogallery WHERE elem_id = 0 AND date <= '". date('Y-m-d H:i:s', strtotime('-1 days')) ."' ");
    while( $elem = mysqli_fetch_assoc($get_elem) ){
        unlink($_SERVER["DOCUMENT_ROOT"].'/upload/gallery/'.$elem['image']);
        unlink($_SERVER["DOCUMENT_ROOT"].'/upload/gallery/thumb/'.$elem['image']);
    }


    foreach ($_FILES as $key => $image) {  
        $file_info = getimagesize($image['tmp_name']);
        if(!$file_info){
            continue;
        }else{
        	
            $filename = file_name(10, $image['name']);
            $resultFiles[]=$filename; 
            
            // получим параметры для этой страницы
            $galleryParams = array();
            $getparams = mysqli_query($db," SELECT * FROM ws_photogallery_params WHERE page_id =  ".$page_id);
            if( mysqli_num_rows($getparams)==1 ){
            	
                $galleryParams = mysqli_fetch_assoc($getparams);
                	
                if( $galleryParams['resize_library'] == 0 ){
                	// --- СТАРАЯ ВЕРСИЯ
		                //thumbs
		                if( substr_count($galleryParams['thumb_width'], ",")==0 ){
		                    $width =  (int)$galleryParams['thumb_width'];
		                    $height = (int)$galleryParams['thumb_height'];
		                    make_thumb($_FILES[$key]['tmp_name'], $path."thumb/".$filename, $width,$height);
		                    if(trim($galleryParams['filter_gray'])==1){
		                        makefiler($path."thumb/".$filename, IMG_FILTER_GRAYSCALE);
		                        rename($path."thumb/".$filename, str_replace("1_", "", $path."thumb/".$filename));
		                    }
		                }else{
		                    $sizeArrWidth = explode(",", $galleryParams['thumb_width']);
		                    $sizeArrHeight = explode(",", $galleryParams['thumb_height']);
		                    foreach ($sizeArrWidth as $key => $Widthvalue) {
		                        if( !file_exists($path."thumb/".$Widthvalue."_".(int)$sizeArrHeight[$key]) ){
		                            mkdir( $path."thumb/".$Widthvalue."_".(int)$sizeArrHeight[$key] );
		                        }
		                        make_thumb($_FILES[$key]['tmp_name'], $path."thumb/".$Widthvalue."_".(int)$sizeArrHeight[$key]."/".$filename, $Widthvalue, (int)$sizeArrHeight[$key]);
		                            if(trim($galleryParams['filter_gray'])==1){
		                            makefiler($path."thumb/".$Widthvalue."_".(int)$sizeArrHeight[$key]."/".$filename, IMG_FILTER_GRAYSCALE);
		                            rename(
		                                $path."thumb/".$Widthvalue."_".(int)$sizeArrHeight[$key]."/".$filename, 
		                                str_replace("1_", "", $path."thumb/".$Widthvalue."_".(int)$sizeArrHeight[$key]."/".$filename)
		                                );
		                        }
		                    }
		                }
		
		                // big files
		                if( $galleryParams['image_width']!=0 && $galleryParams['image_height']!=0 ){
		                    make_thumb($_FILES[$key]['tmp_name'], $path.$filename, $galleryParams['image_width'], $galleryParams['image_height']);
		                }else{
		                        
		                    if( $galleryParams['image_width']!=0 ){// ресайз по ширине
		                        if( $galleryParams['save_original_image']==1 ){
		                            if($file_info[0]<$galleryParams['image_width']){
		                                move_uploaded_file($_FILES[$key]['tmp_name'], $path.$filename);
		                            }else{
		                                resize($_FILES[$key]['tmp_name'], $path.$filename, $galleryParams['image_width'], 0);
		                            }
		                        }else{
		                            resize($_FILES[$key]['tmp_name'], $path.$filename, $galleryParams['image_width'], 0);
		                        }
		                    }elseif($galleryParams['image_height']!=0){ // ресайз по высоте
		                        if( $galleryParams['save_original_image']==1 ){
		                            if($file_info[1]<$galleryParams['image_height']){
		                                move_uploaded_file($_FILES[$key]['tmp_name'], $path.$filename);
		                            }else{
		                                resize($_FILES[$key]['tmp_name'], $path.$filename, 0, $galleryParams['image_height']);
		                            }
		                        }else{
		                            resize($_FILES[$key]['tmp_name'], $path.$filename, 0, $galleryParams['image_height']);
		                        }
		                    }else{
		                        make_thumb($_FILES[$key]['tmp_name'], $path.$filename, 800,600);
		                    }
		
		                }
                    // --- СТАРАЯ ВЕРСИЯ - КОНЕЦ
                }else{

                    // -----
                    include_once( $_SERVER['DOCUMENT_ROOT'] . '/'. WS_PANEL .'/include/CImage.php' );
                    // -----

                    $uploadfile = $path."thumb/".$filename;
                    $tempPathImage = $_SERVER['DOCUMENT_ROOT'] . '/upload/'.$filename;

                    // загружаем нашу картинку а потом передаём в библиотеку путь до нее
                    $rmuf = copy( $_FILES[$key]['tmp_name'], $tempPathImage );
                    if( $rmuf ) {

                        // -----
                        $CImage = new CImage();
                        // -----

                        $params_image = array();
                        // $params_image['canvas'] = true; // белый холст // http://kartinki.moy.su/1/7/foto_smeshnye_belki.jpg
                        /*
                        $params_image['watermark'] = array(
                            'path' => '/desk2021path/templates/lte/dist/img/file_delete.png' ,  // полный путь с названием картинки
                            'position' => 'top_left' , // ( опции - top_left , bottom_left , top_right , bottom_right , center ) , по умолчанию - center
                            'coef_size' => 0.55 ,  // размер водяного знака относительно нашего изображения ( > 0 && < 1 )
                        );
                        */

                        // $params_image['cropped_mode'] = 'center'; // center если хотим обрезать изображение по центру (если mode = cropped)
                        // $params_image['save_original_image'] = true; // если вы задали ресайз по высоте или ширине но изображение меньше тогда просто сохраним (ожидает true)
                        $params_image['width'] = (int)$galleryParams['thumb_width'];
                        $params_image['height'] = (int)$galleryParams['thumb_height'];
                        $params_image['mode'] = 'cropped'; // resize , cropped
                        $CImage->create_image( $params_image, $uploadfile, $tempPathImage );

                        if( @file_exists( $tempPathImage ) ) { unlink( $tempPathImage ); }
                        unset($CImage);
                    }


                    $uploadfile = $path.$filename;
                    $tempPathImage = $_SERVER['DOCUMENT_ROOT'] . '/upload/'.$filename;

                    // загружаем нашу картинку а потом передаём в библиотеку путь до нее
                    $rmuf = copy( $_FILES[$key]['tmp_name'], $tempPathImage );
                    if( $rmuf ) {

                        // -----
                        $CImage = new CImage();
                        // -----

                        $params_image = array();
                        // $params_image['canvas'] = true; // белый холст // http://kartinki.moy.su/1/7/foto_smeshnye_belki.jpg
                        /*
                        $params_image['watermark'] = array(
                            'path' => '/desk2021path/templates/lte/dist/img/file_delete.png' ,  // полный путь с названием картинки
                            'position' => 'top_left' , // ( опции - top_left , bottom_left , top_right , bottom_right , center ) , по умолчанию - center
                            'coef_size' => 0.55 ,  // размер водяного знака относительно нашего изображения ( > 0 && < 1 )
                        );
                        */

                        // $params_image['cropped_mode'] = 'center'; // center если хотим обрезать изображение по центру (если mode = cropped)
                        // $params_image['save_original_image'] = true; // если вы задали ресайз по высоте или ширине но изображение меньше тогда просто сохраним (ожидает true)
                        $params_image['width'] = (int)$galleryParams['image_width'];
                        $params_image['height'] = 0; // (int)$galleryParams['thumb_height'];
                        $params_image['mode'] = 'resize'; // resize , cropped
                        $CImage->create_image( $params_image, $uploadfile, $tempPathImage );

                        if( @file_exists( $tempPathImage ) ) { unlink( $tempPathImage ); }
                        unset($CImage);
                    }


                    /*
                	include_once(  $_SERVER['DOCUMENT_ROOT'] .'/'. WS_PANEL .'/lib/image-toolkit/AcImage.php' );
					
                	$temp_path = $_SERVER['DOCUMENT_ROOT'] . '/upload/'.$filename;
					$res_copy = copy( $_FILES[$key]['tmp_name'] , $temp_path );
					$img = AcImage::createImage( $temp_path );
					$img->resize( (int)$galleryParams['thumb_width'] , (int)$galleryParams['thumb_height'] );
					$uploadfile = $path."thumb/".$filename;
					$img->save( $uploadfile );
					unlink( $temp_path );
					unset( $img );
					
					$temp_path = $_SERVER['DOCUMENT_ROOT'] . '/upload/'.$filename;
					$res_copy = copy( $_FILES[$key]['tmp_name'] , $temp_path );
					$img = AcImage::createImage( $temp_path );
					$img->resizeByWidth( (int)$galleryParams['image_width'] );
					$uploadfile = $path.$filename;
					$img->save( $uploadfile );
					unlink( $temp_path );
                    */
				}

            }
            else
            {
                make_thumb($_FILES[$key]['tmp_name'], $path."thumb/".$filename, 400,300);
                make_thumb($_FILES[$key]['tmp_name'], $path.$filename, 800,600);
            }
        }
        
        $addInBase = mysqli_query($db, "INSERT INTO ws_photogallery 
        	(`page_id`,`elem_id`,`image`,`date`) 
       	    VALUES 
       		('".$page_id."','".$elem_id."','".$filename."', NOW())");
        $last_id = mysqli_insert_id($db);

        if($elem_id==0){
            $_SESSION['photo_gallery_add_page'][] = $last_id;
        }

    }

    echo implode(",", $resultFiles);
}


/* удаление файла */
if($ar_clean['task']=="del"){
    
    $path = $_SERVER['DOCUMENT_ROOT']."/upload/gallery/";
    $del = mysqli_query($db, "DELETE FROM ws_photogallery WHERE `image` = '".$ar_clean['image']."' ");
    unlink($path.$ar_clean['image']);
    unlink($path."thumb/".$ar_clean['image']);
}
/* удаление файла */
if($ar_clean['task']=="del"){
    
    $path = $_SERVER['DOCUMENT_ROOT']."/upload/gallery/";
    $del = mysqli_query($db, "DELETE FROM ws_photogallery WHERE `image` = '".$ar_clean['image']."' ");
    unlink($path.$ar_clean['image']);
    unlink($path."thumb/".$ar_clean['image']);
}

if($ar_clean['task']=="save_sort_image"){
	
	$id = $ar_clean['id'];
	$sort = $ar_clean['sort'];
	
	$update = $Db->q(" UPDATE `ws_photogallery` SET sort = '".$sort."' WHERE id = '".$id."' ");
	
	
}

if($ar_clean['task'] == 'remove_ab'){
    $id = $ar_clean['id'];
    $Db->q("DELETE FROM `ws_abonament_client` WHERE id = ".$id);
}



?>