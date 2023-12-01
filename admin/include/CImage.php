<?
/**
*  работа с изображениями
*/

class CImage
{	
	var $root;
	var $temp_path;
	
	var $AcImage;
	var $AcImageWatermark;
	var $upload_path; // куда будет загружено новое изображение
	var $_params; // параметры из вне
	var $file_name = false; // имя файла
	var $move_uploaded = false; // тут поставим true если мы сделали move_uploaded_file файлу
	
	function __construct()
	{
		include_once( $_SERVER['DOCUMENT_ROOT'] . '/'.WS_PANEL.'/lib/image-toolkit/AcImage.php' );
		
		$this->root = $_SERVER['DOCUMENT_ROOT'];
		$this->temp_path = $this->root . '/upload/';
	}
	
	/*
	 * $file - передаваемый файл из $_FILES ( $_FILES['image'] )
	 * 
	 * $_params 
	 * 	mode 
	 * 		resize 	- ресайз по параметрам которые указаны в height , width
	 * 		cropped 	- обрезка изображения по размерам (по стандарту с лево верху)
	 * 
	 * 	cropped_mode - для ( cropped ) - по умолчнаю с левого верхнего угла 
	 * 		center - обрезка строго по центру
	 * 
	 * 	upload_path - путь куда должна попасть картинка
	 * $tempPathImage - временное расположение картинки
	 * 
	 * 	height , width - думаю тут ясно
	 * 	
	 * 	watermark = array() 
	 * 		path - путь до водяного знака ( полный путь до картинки т.е. папка и название картинки )
	 * 		position - в каком месте размещать водяной знак ( опции - top_left , bottom_left , top_right , bottom_right , center ) , по умолчанию - center
	 * 		coef_size - размер водяного знака относительно нашего изображения ( > 0 && < 1 )
	 * 
	 * 	canvas - если нужно поставить изображение на белый холст ( ожидает параметр TRUE )
	 */
	public function create_image( $_params = array() , $file_path , $tempPathImage )
	{
		$this->uploaded_file = $file_path;
		$this->upload_path = $tempPathImage;
		$this->_params = $_params;
		
		/* проверка параметров */
		if( (int)$this->_params['width'] == 0 && (int)$this->_params['height'] == 0 ) {
 			echo 'Не указаны размеры <b>(width X height)</b>';
			$this->clear();
			return false;
 		}
		
		/* эекземпляр вспомогательного класса с нашим изображением */
		$this->AcImage = AcImage::createImage( $this->upload_path );
		$this->AcImage->setQuality( 100 ); // устанавливаем качество 
		$this->AcImage->setTransparency( true ); // сохраняем прозрачность
		
		/* обрезка / ресайз (обработка файла) */
		$res_switch_mode = $this->switch_mode();
		if( !$res_switch_mode ) {
			echo 'Ошибка программы switch_mode()';
			$this->clear();
			return false;
		}
		
		/* сохраняем */
		if( $this->move_uploaded === false ) {
			$this->AcImage->save( $this->uploaded_file );
		}
		
		/* проверка если сохранилось */
		if( !file_exists( $this->uploaded_file ) ) {
			echo 'Не удалось сохранить изображение';
			$this->clear();
			return false;
		}
		
		/* проверим если нужно поставить изображение на белый холст */
		$this->canvas();
		
		/* смотрим что у нас с водяным знаком (если его нужно ставить и т.д.) */
		$this->watermark();
		
		$this->clear();
	}
	
	/* водяной знак
	* тут мы пересоздаем экземпляр с изображением что бы поставить на него знак
	*/
	public function watermark() {
	    if( isset( $this->_params['watermark'] ) && !empty( $this->_params['watermark'] ) ) {
			
			$this->path_watermark = $this->root . $this->_params['watermark']['path'];
			
			$verified_watermark = file_exists( $this->path_watermark );
			if( !$verified_watermark ) {
				echo 'Водяной знак не найден';
				return false;
			}
			
			$_COEF_SIZE_WATERMARK = 0.50; // НЕ МЕНЬШЕ ИЛИ РАВНО 0  И НЕ БОЛЬШЕ ИЛИ РАВНО 1
			if( isset( $this->_params['watermark']['coef_size'] ) && $this->_params['watermark']['coef_size'] > 0 && $this->_params['watermark']['coef_size'] < 1 ) {
				$_COEF_SIZE_WATERMARK = $this->_params['watermark']['coef_size'];
			}
			
			// $_PADDING_WATERMARK = 0.05; // 0.05 = 5% //AcImage::setPaddingProportionLogo( 0.05 ); // сдвиг в низ на 50%
			// выбор расположения водяного знака

            copy( $this->uploaded_file , $this->upload_path );

            $this->AcImageWatermark = AcImage::createImage( $this->upload_path );
            $this->AcImageWatermark->setQuality( 100 ); // устанавливаем качество
            $this->AcImageWatermark->setTransparency( true ); // сохраняем прозрачность

            // удалим наше изображение что бы потом туда же сохранить
            unlink( $this->uploaded_file );

			AcImage::setMaxProportionLogo( $_COEF_SIZE_WATERMARK );

			switch ( $this->_params['watermark']['position'] ) {
				// поместим водяной знак ( если это не центр )
					// TOP_LEFT , TOP_RIGHT , BOTTOM_RIGHT , BOTTOM_LEFT
				case 'top_left':
					$this->AcImageWatermark->drawLogo( $this->path_watermark , AcImage::TOP_LEFT );
				break;
				case 'bottom_left':
					$this->AcImageWatermark->drawLogo( $this->path_watermark , AcImage::BOTTOM_LEFT );
				break;
				case 'top_right':
					$this->AcImageWatermark->drawLogo( $this->path_watermark , AcImage::TOP_RIGHT );
				break;
				case 'bottom_right':
					$this->AcImageWatermark->drawLogo( $this->path_watermark , AcImage::BOTTOM_RIGHT );
				break;
				
				case 'center':
				default:
					$this->AcImageWatermark->drawLogo( $this->path_watermark , AcImage::CENTER );
				break;
			}

			$this->AcImageWatermark->save( $this->uploaded_file ); // и сохраним там же*/
		}
	}


	/*
	* создаем белый холст и ставим наше изображение на него
	*/
	public function canvas()
	{		
		if( @$this->_params['canvas'] === true ) {
			
			/* информация о загруженном изображении */
			$watermark = $uploadfile = $this->uploaded_file; // наше изображение выступает как водяной знак для белого фона
			$width = (int)$this->_params['width'];
			$height = (int)$this->_params['height'];
			
			// обработка нашего основого изображения
				$mime = mime_content_type( $uploadfile );
				if( $mime == "image/jpeg" ) {
					$watermark = imagecreatefromjpeg( $watermark );
				}elseif( $mime == "image/png" ) {
					$watermark = imagecreatefrompng( $watermark );
				}elseif( $mime == "image/gif" ) {
			        $watermark = imagecreatefromgif( $watermark );
			    }
			    imagealphablending( $watermark , true );
			// обработка нашего основого изображения - КОНЕЦ 
			
			// считаем координаты для центра
			$imginfoUpload = getimagesize( $uploadfile );
			$watermark_width = $imginfoUpload[0];
			$watermark_height = $imginfoUpload[1];
			$dest_x = ( ( $width ) / 2 ) - ( ( $watermark_width ) / 2 );
			$dest_y = ( ( $height) / 2 ) - ( ( $watermark_height ) / 2 );

			/* создаем холст */
			$img = imagecreate( $width , $height );
			imagecolorallocate( $img , 255 , 255 , 255 );
			$tempPath = $this->temp_path . 'canvas_' . $this->file_name( 10 );
			
			//обработка белый холста 
			imagejpeg( $img , $tempPath );
			$image = imagecreatefromjpeg( $tempPath );

			/* ставим наше изображение на холст по середине */
			imagecopy( $image , $watermark , $dest_x , $dest_y , 0 , 0 , $watermark_width , $watermark_height );
			
			//сохраняем его вместо оригинала 
			if( $mime == "image/jpeg" ) {
				imagejpeg( $image , $uploadfile );
			} else if ( $mime == "image/png" ) {
				imagepng( $image , $uploadfile );
			} else if ( $mime == "image/gif" ) {
				imagegif( $image , $uploadfile );
			}
			
			// чистка 
			if( $img ) { imagedestroy( $img ); }
			if( $image ) { imagedestroy( $image ); }
			if( $watermark ) { imagedestroy( $watermark ); }
			if( $tempPath ) { unlink( $tempPath ); }
			// -- --- -- 
		}
	}
	
	// обработка изображения по типу который передали в параметрах
	public function switch_mode() {
		switch ( $this->_params['mode'] ) {
			case 'resize':
				$this->resize_processing();
				return true;
			break;
			case 'cropped':
				if( (int)$this->_params['width'] == 0 || (int)$this->_params['height'] == 0 ) {
		 			echo 'Нужно указать параметры <b>(width X height)</b>';
					$this->clear();
					return false;
		 		}
				
				// сначало делаем ресайз картинки 
				$ratio = $this->AcImage->getWidth() / $this->AcImage->getHeight();
				if( $ratio > (int)$this->_params['width'] / (int)$this->_params['height'] ) {
			    	$this->resize( false , (int)$this->_params['height'] );
			    }else {
			    	$this->resize( (int)$this->_params['width'] , 0 );
			    }
				
				if( @$this->_params['cropped_mode'] == 'center' ) {
					$this->AcImage->cropCenter( (int)$this->_params['width'] , (int)$this->_params['height'] );
				} else if( @$this->_params['cropped_mode'] == 'big_center' ) {
					$this->AcImage->thumbnail( (int)$this->_params['width'] , (int)$this->_params['height'] );
				} else {
					$this->AcImage->crop( 0 , 0 , (int)$this->_params['width'] , (int)$this->_params['height'] );
				}
				
				return true;
			break;
			
			default:
				echo 'Не указан параметр mode для <b>' . $this->uploaded_file['name'] .'</b>';
				$this->clear();
				return false;
			break;
		}
	}
	
	/*
	*  обычный ресайз перед обрезкой изображения
	*/
	function resize( $w_o , $h_o , $percent = false )
	{
		// $this->get_upload_path();

		// $w_i = $this->AcImage->getWidth();
		// $h_i = $this->AcImage->getHeight();
		
	    // удалим наш экземпляр класса 
	    unset( $this->AcImage );
	    
		// move_uploaded_file( $this->uploaded_file['tmp_name'] , $this->upload_path );
		list( $w_i , $h_i , $type ) = getimagesize( $this->upload_path );
		
		$types = array( '', 'gif' , 'jpeg' , 'png' );
    	$ext = $types[$type];
		
		$func = 'imagecreatefrom'.$ext;
        $img = $func( $this->upload_path );
		
	    if ( $percent ) {
	        $w_o *= $w_i / 100;
	        $h_o *= $h_i / 100;
	    }
	    if ( !$h_o ) $h_o = $w_o / ( $w_i / $h_i );
	    if ( !$w_o ) $w_o = $h_o / ( $h_i / $w_i );
		
	    $img_o = imagecreatetruecolor( $w_o , $h_o );
	    imagealphablending( $img_o , false );
	    imagesavealpha( $img_o , true);
	    imagecopyresampled( $img_o , $img , 0, 0, 0, 0, $w_o , $h_o , $w_i , $h_i );
		if ( $type == 2 ) {
	        imagejpeg( $img_o , $this->upload_path , 100 );
	    } else {
	        $func = 'image'.$ext;
	        $func( $img_o , $this->upload_path );
	    }
		
		
		// теперь создадим класс с изображением что бы дальше работать
		$this->AcImage = AcImage::createImage( $this->upload_path );
		$this->AcImage->setQuality( 100 ); // устанавливаем качество 
		$this->AcImage->setTransparency( true ); // сохраняем прозрачность
		
		// unlink( $this->upload_path );
		
		/*
	    if ( $type == 2 ) {
	        return imagejpeg( $img_o , $file_output , 80 );
	    } else {
	        $func = 'image'.$ext;
	        return $func( $img_o , $file_output );
	    }
		*/
	}
	
	/*
	* проверки и сам ресайз
	*/
	public function resize_processing()
	{
		if( (int)$this->_params['width'] != 0 && (int)$this->_params['height'] != 0 ) { // ресайз по высота и ширине
				
			$this->AcImage->resize( (int)$this->_params['width'] , (int)$this->_params['height'] );
				
		} else if ( (int)$this->_params['width'] != 0 ) { // по ширине
		
			if( $this->_params['save_original_image'] === true && $this->AcImage->getWidth() < $this->_params['width'] ) { // если выбрали сохранить изображение и размер не подошел
				//$this->get_upload_path();
				move_uploaded_file( $this->upload_path , $this->uploaded_file );
				$this->move_uploaded = true;
			} else {
				$this->AcImage->resizeByWidth( (int)$this->_params['width'] );
			}
		
		} else if ( (int)$this->_params['height'] != 0 ) {
			
			if( $this->_params['save_original_image'] === true && $this->AcImage->getHeight() < $this->_params['height'] ) {
		    	//$this->get_upload_path();
				move_uploaded_file( $this->upload_path , $this->uploaded_file );
				$this->move_uploaded = true;
		    } else {
		    	$this->AcImage->resizeByHeight( (int)$this->_params['height'] );
			}
			
		}
	}

    /*
    * генерация названия файла
    */
	public function file_name($number = 10, $str = '')
	{
	    $arr = array('a','b','c','d','e','f',
	                 'g','h','i','j','k','l',
	                 'm','n','o','p','r','s',
	                 't','u','v','y','z',
	                 '1','2','3','4','5','6',
	                 '7','8','9','_');
	    $pass = "";
	    for($i = 0; $i < $number; $i++)
	    {
	      $index = rand(0, count($arr) - 1);
	      $pass .= $arr[$index];
	    }
	    if( $str=='' ) {
	        return $pass;
	    }else{
	        $ar = explode( ".", (string)$str );
			$end = mb_strtolower( end( $ar ) );//jpeg
			if( $end == 'jpeg' ){
				$end = 'jpg';
			}
	        $pass = $pass . "." . $end; // в нижний регистр
	        return 'c_'.$pass;
	    }
	}


	
	/*
	 * очистка переменных из памяти
	 * */
	public function clear()
	{
		if( file_exists( @$this->upload_path ) ) {
			unlink( $this->upload_path );
		}
		
		unset( $this->root );
		unset( $this->temp_path );
		unset( $this->AcImage );
		unset( $this->AcImageWatermark );
		unset( $this->upload_path );
		unset( $this->_params );
	}


    /*
    * проверка если изображение корректное
    */
    /*
	public function verified_image()
	{
		$file_info = getimagesize( $this->uploaded_file['tmp_name'] );
        if( !$file_info ) {
        	return false;
        } else {
        	return true;
        }
	}
	*/

    /*
    * создание временно файла для работы с ним из папки
    */
    /*
	public function create_temp_file()
	{
		$temp_path = $this->temp_path . $this->file_name( 10 , end( explode( '/' , $this->uploaded_file ) ) );
		$res_copy = copy( $this->uploaded_file , $temp_path );
		if( $res_copy ) {
			return $temp_path;
		} else {
			return false;
		}
	}
	*/




    /*
	 * получение пути куда будем загружать изображение + название файла
	 * 	 вызываем этот метод а дальше получаем переменную с названием  - upload_path
	 */
    /*
	public function get_upload_path()
	{
		$this->file_name = $this->file_name( 10 , end( explode( '/' , $this->uploaded_file ) ) );
		$this->upload_path = $this->upload_path . $this->file_name;
	}
    */

    // если сохранилось новое изображение то удалим старое изображение если оно есть
    /*
	public function delete_old_image()
	{
		$path = $this->root . $this->_params['upload_path'];
		if( isset( $this->_params['old_image'] ) ) {
			$path = $path . $this->_params['old_image'];
			if( file_exists( $path ) ) {
				unlink( $path );
			}
		}
	}
	*/

    // проверим если мы не должны просто пропустить обработку изображения
    // когда мы редактируем элемент и изображение не пришло
    /*
	public function verified_old_image()
	{
		if( isset( $this->_params['old_image'] ) ) {
			return $this->_params['old_image'];
		} else {
			return false;
		}
	}
	*/
    /*
	* создаем новый экземпляр нашего изображения для наложения водяного знака на него а потом опять сохраним
	*/
    /*
	public function create_image_watermark()
	{
        $this->AcImageWatermark = AcImage::createImage( $this->uploaded_file );
        $this->AcImageWatermark->setQuality( 100 ); // устанавливаем качество
        $this->AcImageWatermark->setTransparency( true ); // сохраняем прозрачность

        // удалим наше изображение что бы потом туда же сохранить
        unlink( $this->uploaded_file );
	}
    */
}