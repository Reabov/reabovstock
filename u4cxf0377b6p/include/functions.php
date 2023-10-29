<?

/*  Вывод корректных копирайтов в подвале сайта
 * выозов функции
 * 1 - список языков на сайте
 * 2 - ИД страницы
 * 3 - язык пользователя на сайте
 *
 * - - - get_correct_copyrights_links( $CCpu->langList , $pageData['page_id'] , $CCpu->lang );
 */
function get_correct_copyrights_links( $user_lang ) {
    global $CCpu , $page_data;

    $arr_lang = $CCpu->langList;

    $acces_lang = array(
        'ru' => 'ru',
        'ro' => 'ro',
        'en' => 'en'
    );

    $link = '';
    $cur_lang = '';
    $year = '2021';
    foreach ($arr_lang as $key => $lang_value ) {
        if( $lang_value == $user_lang && $user_lang != 'ru' ){
            $cur_lang = '/'.$user_lang.'/';
            if( !in_array($user_lang, $acces_lang) ){
                $cur_lang = '';
            }
        }
        $link = "href='https://webmaster.md".$cur_lang."'";
    }

    if( $page_data['id'] == 1 ){
        ?>
        <a <?=$link?> title="Studio WebMaster" target="_blank">
            &copy; Studio WebMaster, <?=$year?>
            <img src="/images/other/studio_webmaster.svg" alt="Studio WebMaster Logo">
        </a>
        <?php
    }else{
        ?>
        <span>
            &copy; Studio WebMaster, <?=$year?>
        </span>
        <?php
    }
}

/*
 * Список языков для публичной части
 *
 * Вызываем функцию
 *  получаем массив с языками
 *  выводим на публичной части
 *
 * 	- Вот такие данные приходят из базы в массиве - $Lang
 * 		если нужно берем и дополняем наш массив  - $ArrLangExport
 * Array
(
[ru] => Array
    (
        [id] => 1
        [code] => ru
        [title] => Русский
        [sort] => 500
        [active] => 1
        [is_default] => 1
    )

[ro] => Array
    (
        [id] => 18
        [code] => ro
        [title] => Română
        [sort] => 500
        [active] => 1
        [is_default] => 0
    )
)
*
* - $ArrLangs = get_list_lang_public();
*/
function get_list_lang_public() {

    global $pageData , $CCpu , $db;

    $ArrLangExport = array();
    $LangUrls = $CCpu->getURLs($pageData['page_id'], $pageData['elem_id']);
    if( isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING']) && $_SERVER['QUERY_STRING']!='' ){
        $get = "?".$_SERVER['QUERY_STRING'];
    }

    $getLangs = mysqli_query( $db , " SELECT * FROM ws_site_languages WHERE active = 1 ORDER BY sort DESC ");
    if( mysqli_num_rows($getLangs) === 0 ){
        return false;
        //exit;
    }else{
        $i = 0;
        while($Lang = mysqli_fetch_assoc($getLangs)){
            $ArrLangExport['lang'][$Lang['code']]['title'] = $Lang['title'];
            $ArrLangExport['lang'][$Lang['code']]['code'] = $Lang['code'];
            $ArrLangExport['lang'][$Lang['code']]['value'] = $Lang['value'];
            $ArrLangExport['lang'][$Lang['code']]['href'] = $LangUrls[$Lang['code']].$get;

            $cur_lang = 0;
            if( $CCpu->lang == $Lang['code'] ){
                $cur_lang = 1;
            }
            $ArrLangExport['lang'][$Lang['code']]['cur_lang'] = $cur_lang;
        }
    }

    /* сколько языков */
    $ArrLangExport['count'] = count($ArrLangExport['lang']);
    return $ArrLangExport;
}


function define_client_ip() {
    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
    ];

    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            @$ip = trim(end(explode(',', $_SERVER[$key])));
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
}

/* расчет записей для создания пагинации */
/*
 * в $SQL_query можно сразу указать кол-во элементов при необходимости
 * */
function pagination($SQL_query, $perPage = 6)
{
	global $db;

	if(!is_numeric($SQL_query)){
        $getCount = mysqli_query($db, $SQL_query);
        $pagesCount = mysqli_num_rows($getCount);
    }
	else {
        $pagesCount = (int)$SQL_query;
    }

    $pages = ceil($pagesCount / $perPage);
    if(isset($_GET['page'])){
        $page = (int)$_GET['page'];
    }else{
        $page = 1;
    }
    if($page>$pages){
        $page=$pages;
    }
    if($page<1){
        $page=1;
    }
    $from = $page * $perPage - $perPage;
    
    $NextPage = $page+1;
    if($NextPage>$pages){$NextPage=$pages;}
    $PrevPage = $page-1;
    if($PrevPage<1){$PrevPage=1;}
    
    return array(
    	'count_elem' => $pagesCount,
        'page'=>$page,
        'per_page'=>$perPage,
        'pages'=>$pages,
        'from'=>$from,
        'prev'=>$PrevPage,
        'next'=>$NextPage
    );
}
 
/* вывод пострничной навигации */
/**
через массив можно указать свои классы для элементов пагинации
$arrayClasses
 * ['backlink'] = для стрелки назад
 * ['forwardlink'] = для стрелки вперед
 *
 * ['activepage'] = для активной страницы
 *
 * ['allnumbers'] = для всхе цифровых обозначении
 */
function paginate($Paginator, $arrayClasses = array())
{

  $getdata = array();
  foreach ($_GET as $key => $value) {
      if($key=='page'){continue;}
      $getdata[] = $key."=".$value;
  }
  $getdata = implode("&", $getdata);
  if($getdata!=''){
      $getdata.="&";
  }

 if($Paginator['pages']>1){?>
 	<div class="pagination_area clear_end">
	     <ul class="pagination">
	
		      <li class="link backlink <?=@$arrayClasses['backlink']?> <?if($Paginator['page']==$Paginator['prev']){echo "backlink-disabled";}?> ">
		      	<a <?if($Paginator['page']>$Paginator['prev']){?>href="?<?=$getdata?>page=<?=$Paginator['prev']?>"<?}?>>  </a>
		  	  </li>
		      
		      <?
		      $dots = '<li><a>...</a></li>';
		      for($p=1;$p<=$Paginator['pages'];$p++){
		      if($Paginator['pages']>3 && $Paginator['page']!=$p && abs( $Paginator['page'] - $p )> 2 ){
		      	echo $dots;
		      	$dots = '';
		        continue;
		      }
		       ?>
		       <li>
		       		<a <?if($p==$Paginator['page']){?>class="activepage <?=@$arrayClasses['activepage']?> <?=@$arrayClasses['allnumbers']?>"<?}else{?>class="<?=@$arrayClasses['allnumbers']?>"<?}?> href="?<?=$getdata?>page=<?=$p?>"><?=$p?></a>
		       </li>
		       <?
		      }
		
		      ?>
		      <li class="link forwardlink <?=@$arrayClasses['forwardlink']?> <?if($Paginator['page']==$Paginator['next']){echo "forwardlink-disabled";}?>">
		      	<a <?if($Paginator['page']<$Paginator['next']){?>href="?<?=$getdata?>page=<?=$Paginator['next']?>"<?}?>>  </a>
		      </li>
	      
	     </ul>
     </div>
 <?}
}

/* вывод пострничной навигации для большлго кол-ва страниц и с дополнительными кнпками */
function paginateExtender($Paginator, $cpu = "/")
{
  $getdata = array();
  foreach ($_GET as $key => $value) {
      if($key=='page'){continue;}
      $getdata[] = $key."=".$value;
  }
  if(!empty($getdata)){
  	$getdata = implode("&", $getdata); 
  }else{
  	$getdata = '';
  }
  if($getdata!=''){
      $getdata="&".$getdata;
  }
    
 if($Paginator['pages']>1){

	$pagePrev = $Paginator['page']-1;
	if($pagePrev<1){$pagePrev = 1;}
	$pageNext = $Paginator['page']+1;
	if($pageNext>$Paginator['pages']){$pageNext = $Paginator['pages'];}


	// 1 block
	$Firstpart = '';
	$hrefFirstPage = $cpu;
	//show($Paginator['page']);
		if($getdata!=''){
			$hrefFirstPage = "?".mb_substr($getdata, 1,200);
		}
	if($Paginator['page']>4){
		$Firstpart = '<a class="pagelink" href="'.$hrefFirstPage.'">1</a> ... ';
	}
	
	// 3 block
	$Endpart = '';
	if( ($Paginator['pages'] - $Paginator['page']) > 3  ){
		$href = '?page='.$Paginator['pages'].$getdata;
		$Endpart = ' <span>...</span> <a class="pagelink" href="'.$href.'">'.$Paginator['pages'].'</a>';
	}
	
	// 2 block
	$begin_row = $Paginator['page'] - 2;
	if( ($Paginator['pages'] - $Paginator['page'])<2  ){
		$begin_row = $Paginator['page'] - 2 - (2 -($Paginator['pages'] - $Paginator['page']));
	}
	if($Paginator['pages']<5){$begin_row = 1;}
	if($begin_row < 1){
		$begin_row = 1;
		
		if($Paginator['pages'] - ($begin_row+4)<1){
			$Endpart = '';
		}
	}

	
	?>
	<div class="paginatorextendwrapper">
		<a class="backlink <?if($Paginator['page']==$Paginator['prev']){echo "disabled";}?>" href="<?=$hrefFirstPage?>"></a>
		<a class="prevlink <?if($Paginator['page']==$Paginator['prev']){echo "disabled";}?>" href="?page=<?=$pagePrev.$getdata?>"></a>
		
		<?=$Firstpart?>
		<? for($i=$begin_row;($i<$begin_row+5 && $i <= $Paginator['pages']);$i++) {
		$HREF = "?page=".$i.$getdata;
		if($i==1){
			$get = '';
			if($getdata!=''){
				$get = "?".mb_substr($getdata, 1,200);
			}
			$HREF = $cpu.$get;
		}
		?>
		<a class="pagelink <?if($Paginator['page']==$i){echo"activepage";}?>" href="<?=$HREF?>"><?=$i?></a>
		<?}?>
		<?=$Endpart?>
		
		<a class="nextlink <?if($Paginator['page']==$Paginator['next']){echo "disabled";}?>" href="?page=<?=$pageNext.$getdata?>"></a>
		<a class="endlink <?if($Paginator['next']==$Paginator['pages']){echo "disabled";}?>" href="?page=<?=$Paginator['pages'].$getdata?>"></a>
	</div>
 <?}
}




// вывод элемента с полем в редактировании 
/*
 * $name - имя поля, например - title, date
 * $lang - язык, если это языковая вкладка
 * $title - Наименование поля, например: Дата регистрации:
 * $type - тип: 1 - поле, 2 - выпадающий список, 3 - галочка, 4 - редактор
 * $action - edit/add
 * $tableElements - таблица для выпадающего списка
 * $elementsTitle - когда есть $tableElements - поле таблички, коорое нужно вывести в название
 * $required - 0 - поле не обязательно для заполнения, 1 - обязательно
 * $elementInfo - массив из таблички элемента
 * $size - длина поля
 * $default - значение по умолчанию
 * 
 * */
function editElem($name, $title, $type, $elementInfo, $lang = '', $action = 'add', $required = 0, $size = 8, $tableElements = '', $elementsTitle = '', $default = '')
{
	global $db;
	if($lang!=''){
		$name.="_".$lang;//языковая метка для полей, например - title_ru
	}
	if($action=='edit' && !isset($elementInfo[$name])){?><h3 class="red"> <?=$GLOBALS['CPLANG']['ELEMENT_WORD']?> <?=$name?>  <?=$GLOBALS['CPLANG']['NOT_FOUND_WORD']?> </h3><?return false;}
	if($size>10){$size = 10;}
	?>
	
	<div class="form-group">
        <label class="col-sm-3"><?=$title?> <?if($required==1){?><b class="red">*</b><?}?></label>
        	<?
        	switch($type){
        		case 1:
				?>
				<div class="col-sm-<?=$size?>">
					<input <?if($required==1){echo"required";}?> type="text" name="<?=$name?>" <?if($action=='edit'){?>value="<?=$elementInfo[$name]?>"<?}elseif($default!=''){?>value="<?=$default?>"<?}?> class="form-control input-sm">
				</div>
				
				<?
				break;
				
				case 2:
				?>
				<div class="col-sm-<?=$size?>">
					<select <?if($required==1){echo"required";}?> type="text" name="<?=$name?>" class="form-control input-sm">
						<?if($action=='add'){?>
							<option value=""> --- </option>
						<?}
						$getTableElements = mysqli_query($db, " SELECT `id`, `".$elementsTitle."` FROM `".$tableElements."`  ");
						while($ElemTable = mysqli_fetch_assoc($getTableElements)){
							?>
							<option <?if($action=='edit' && $ElemTable['id']==$elementInfo[$name]){echo"selected";}?> value="<?=$ElemTable['id']?>"><?=$ElemTable[$elementsTitle]?></option>
							<?
						}
						
						?>
					</select>
				</div>
				<?
				break;
				
				case 3: 
				?>
				<div class="checkbox col-sm-10 nopaddingtop">
					<label>
						<input type="checkbox" name="<?=$name?>" <?if($action=='edit' && 1==$elementInfo[$name]){echo"checked";}elseif($action=='add' && $default==1){echo "checked";}?> />
						<?=$title?>
					</label>
				</div>
				<?
				break;
				
				case 4:
				?>
				<div class="list_all">
                    <div class="col-sm-12">
                        <textarea name="<?=$name?>" ><?if($action=='edit'){echo $elementInfo[$name];}?></textarea>
                        <script type="text/javascript">
                                        CKEDITOR.replace( '<?=$name?>',
                                                         {
                             filebrowserBrowseUrl : '/<?=WS_PANEL?>/lib/ckeditor/ckfinder/ckfinder.html',
                             filebrowserImageBrowseUrl : '/<?=WS_PANEL?>/lib/ckeditor/ckfinder/ckfinder.html?Type=Images',
                             filebrowserFlashBrowseUrl : '/<?=WS_PANEL?>/lib/ckeditor/ckfinder/ckfinder.html?Type=Flash',
                             filebrowserUploadUrl : '/<?=WS_PANEL?>/lib/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Files',
                             filebrowserImageUploadUrl : '/<?=WS_PANEL?>/lib/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Images',
                             filebrowserFlashUploadUrl : '/<?=WS_PANEL?>/lib/ckeditor/ckfinder/core/connector/php/connector.php?command=QuickUpload&type=Flash'
                            }
                        );
                        </script>
                    </div>
                </div>
				<?	
				break;
                
                case 5:
                ?>
                <div class="col-sm-<?=$size?>">
                	<input <?if($required==1){echo"required";}?> type="file" name="<?=$name?>" class="<?=$sizeClass[$size]?>">
                </div>
                <?
                break;
                
                case 6:
                ?>
                <div class="col-sm-2">
                	<input <?if($required==1){echo"required";}?> type="text" autocomplete="off"  name="<?=$name?>" <?if($action=='edit'){?>value="<?=$elementInfo[$name]?>"<?}elseif($default!=''){?>value="<?=$default?>"<?}?> class="datepicker form-control input-sm">
                </div>
                <?    
                break;
                
                case 7:
                ?>
                <div class="col-sm-3">
                	<input <?if($required==1){echo"required";}?> type="text"  name="<?=$name?>" <?if($action=='edit'){?>value="<?=$elementInfo[$name]?>"<?}elseif($default!=''){?>value="<?=$default?>"<?}?> class="datetimepicker <?=$sizeClass[$size]?> form-control">
                </div>
                <?    
                break;
				
				
				case 8:
                ?>
                <div class="col-sm-7">
                	<textarea <?if($required==1){echo"required";}?> name="<?=$name?>" class="<?=$sizeClass[$size]?> form-control" style="resize: vertical;"><?if($action=='edit'){echo $elementInfo[$name];}elseif($default!=''){echo $default;}?></textarea>
                </div>
                <?    
                break;
				
				default: ?><div class="red"> <?=$GLOBALS['CPLANG']['INVALID_BLOCK_TYPE']?> </div><? 
        	}
        	?>

    </div>
<?
} 



/* ловим checkbox в админ панели */
function checkboxParam($name)
{
	$result = 0;
	if(isset($_POST[$name])){
		$result = 1;
	}
	return $result;
}



/* обновляем элемент
 * $checkboxFields - ключи для галочек, например: array('active'=>$active)
 * $textFields - имена полей для текстового редактора
 * $otherFields - данные файлов и пр., например - изображения. В таком случае указываем поле => имя файла, например: image=>$fileName
 * $exceptions - массив исключений, например - для раздичных скрытых полей
 * 
 * 
 */
function updateElement($id, $dbtable_elem, $checkboxFields = array(), $textFields = array(), $otherFields = array(), $exceptions = array())
{
	global $db;
	$fields = array();
	$set_data = array();
	$VAL = '';
	$ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
	foreach ($_POST as $key => $value) 
	{ 
		if( array_key_exists($key, $checkboxFields) || $key=='ok' || in_array($key, $exceptions) )
		{
			continue; // обработаем ниже 
		}
		if(is_array($_POST[$key])){
			
			$_POST[$key]=implode(',', $_POST[$key]);
		}
		if( in_array($key, $textFields) )
		{
			$VAL =  str_replace("'", '&#39;', $_POST[$key]);
		}
		else
		{
			$VAL = $ar_clean[$key]; 
		}
		$fields[$key] = $VAL;
	}
	// галочки
	foreach ($checkboxFields as $key => $value) 
	{
		$fields[$key] = $value;
	}
	// файлы и картинки
	foreach ($otherFields as $key => $value) 
	{
		$fields[$key] = $value;
	}
	
	foreach ($fields as $key => $value) 
	{
	
		$set_data[] = " `".$key."` = '".$value."' ";
	}
	$set_data = implode(",",$set_data);
	
	$result = mysqli_query ($db, "UPDATE `".$dbtable_elem."` SET ".$set_data." WHERE `id`='".$id."'"); 

	if($result){
		?>
		<div class="alert alert-success">
			<div><i class="icon fa fa-check"></i> <?=$GLOBALS['CPLANG']['DATA_UPDATED']?> </div>
		</div>
		<?
	}else{
		?>
		<div class="alert alert-danger"><?=$GLOBALS['CPLANG']['ERROR_OCCURED']?><br><pre><?echo mysqli_error($db)?></pre></div>
		<?
	}
	
}




/* Добавляем элемент
 * $checkboxFields - ключи для галочек, например: array('active'=>$active)
 * $textFields - имена полей для текстового редактора
 * $otherFields - данные файлов и пр., например - изображения. В таком случае указываем поле => имя файла, например: image=>$fileName
 * 
 */
function addElement($dbtable_elem, $checkboxFields = array(), $textFields = array(), $otherFields = array(), $exceptions = array())
{
	global $db;	
	$fields = array();
	$keys_data = array();
	$vals_data = array();
	$VAL = '';
	$ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
	foreach ($_POST as $key => $value) { 
		if( array_key_exists($key, $checkboxFields) || $key=='ok' || in_array($key, $exceptions)){
			continue; // обработаем ниже 
		}
		if( in_array($key, $textFields) ){
			$VAL =  str_replace("'", '&#39;', $_POST[$key]);
		}else{
			$VAL = $ar_clean[$key]; 
		}
		$fields[$key] = $VAL;
	}
	// галочки
	foreach ($checkboxFields as $key => $value) {
		$fields[$key] = $value;
	}
	// файлы и картинки
	foreach ($otherFields as $key => $value) {
		$fields[$key] = $value;
	}
	
	foreach ($fields as $key => $value) {
		$keys_data[] = " `".$key."` ";
        if( $value!=='NOW()' ){
            $vals_data[] = " '".$value."' ";
        }else{
            $vals_data[] = " NOW() ";
        }
	}
//show( "INSERT INTO `".$dbtable_elem."` ( ".implode(",", $keys_data)." ) VALUES ( ".implode(",", $vals_data)." ) " );
	$result = mysqli_query ($db, "INSERT INTO `".$dbtable_elem."` ( ".implode(",", $keys_data)." ) VALUES ( ".implode(",", $vals_data)." ) "); 
	//echo mysqli_error($db);
	if($result){

		?><div class="alert alert-success"><?=$GLOBALS['CPLANG']['DATA_UPDATED']?></div><?
	
	}else{
		
		?><div class="alert alert-danger"><?=$GLOBALS['CPLANG']['ERROR_OCCURED']?></div><?
	}
}

function isWebMasterOffice() {
    if( define_client_ip() == '89.28.56.188' ){
        return true;
    }
    else {
        return false;
    }
}

function show($Elem)
{
	if( isWebMasterOffice() ){
	    ?><pre style="font-family: Consolas,Courier;font-size: 12px;background: #ddd;border: 1px solid #bbb;padding: 4px 6px;color: #444;display: inline-block;border-radius: 3px;text-align: left;margin: 3px;line-height: 1.0;"><?
	    print_r($Elem);
	    ?></pre><?
	}
}


function dump($Elem)
{
    if( isWebMasterOffice() ){
    ?><pre style="font-family: Consolas,Courier;font-size: 12px;background: #ddd;border: 1px solid #bbb;padding: 4px 6px;color: #444;display: inline-block;border-radius: 3px;text-align: left;margin: 3px;line-height: 1.0;"><?
    var_dump($Elem);
    ?></pre><?
    }
}


function file_name($number = 10, $str = '')  
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
    if($str==''){
        return $pass;
    }else{
        $ar = explode(".", (string)$str);
        $pass = $pass.".".end($ar);
        return $pass;
    }
    
}


/**
    * @method  img_resize - Функция изменения размера изображения
    * @param   $src    -   исходное изображение 
    * @param   $dest   -   конечное изображение
    * @param   $width  -   необходимая ширина (Если 0, то без ограничений)
    * @param   $height -   необходимая высота (Если 0, то без ограничений)
    * @param   $quality -  качество
    * @return  TRUE если изменение размера прошло успешно 
    */
    function img_resize($src, $dest, $width, $height, $quality=100){
        if (!file_exists($src)) return false;
        
        $size = getimagesize($src);
        if ($size === false){
            return false;
        }else{
            $w_src = $size[0];
            $h_src = $size[1];
        }
        //echo $width.' x '.$height.' - '.$w_src.' x '.$h_src.' <br>';
        // Cоздаём изображение на основе исходного файла
        $format = strtolower(substr($size['mime'], strpos($size['mime'], '/')+1));        
        $icfunc = "imagecreatefrom".$format;        
        if (!function_exists($icfunc)){
            return false; 
        }else{
            $source = $icfunc($src);
        }
        
        $imagefunc = "image".$format;
        if (!function_exists($imagefunc)) 
            return false;   
        
        /*if ( $width == 0 || ( ($h_src > $w_src || $h_src == $w_src ) && ( $h_src > $height || $h_src == $height ) && $height > 0 ) ){*/   
        if ( ( $h_src > $height || $h_src == $height ) && $height > 0 ){
            // уменьшаем по высоте
            $ratio = $h_src/$height;                // Вычисление пропорций   
            
            $w_dest = round($w_src/$ratio);
            $h_dest = round($h_src/$ratio);
            //echo $width.' x '.$height.' - '.$w_dest.' x '.$h_dest.' <br>';
            
            if( $w_dest > $width && $width > 0 ){
                // уменьшаем по ширине
                $ratio = $w_dest/$width;                 // Вычисление пропорций
                
                $w_dest = round($w_dest/$ratio);
                $h_dest = round($h_dest/$ratio);   
            }        
            //echo $width.' x '.$height.' - '.$w_dest.' x '.$h_dest.' <br>';
        /*}elseif( $height == 0 || ( ( $w_src > $h_src || $h_src == $w_src ) && ( $w_src > $width || $w_src == $width ) && $width > 0  ) ){*/
        }elseif( ( $w_src > $width || $w_src == $width ) && $width > 0  ){
            // уменьшаем по ширине
            $ratio = $w_src/$width;                 // Вычисление пропорций        
            
            $w_dest = round($w_src/$ratio);
            $h_dest = round($h_src/$ratio);
            //echo $width.' x '.$height.' - '.$w_dest.' x '.$h_dest.' <br>';
            
            if( $h_dest > $height && $height > 0 ){
                // уменьшаем по высоте
                $ratio = $h_dest/$height;                 // Вычисление пропорций
                
                $w_dest = round($w_dest/$ratio);
                $h_dest = round($h_dest/$ratio);   
            }        
            //echo $width.' x '.$height.' - '.$w_dest.' x '.$h_dest.' <br>';
        }
        //echo $ratio.'<br>';
        if( isset($ratio) ){        
            // Создаём пустую картинку
            $idest = imagecreatetruecolor($w_dest, $h_dest);
            
            // Копируем старое изображение в новое с изменением параметров
            if( $format == "png" ){
                imagecolortransparent($idest, imagecolorallocate($idest, 0, 0, 0));
                imagealphablending($idest, false);
                imagesavealpha($idest, true);
                imagecopyresampled($idest, $source, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
            }else{
                imagecopyresampled($idest, $source, 0, 0, 0, 0, $w_dest, $h_dest, $w_src, $h_src);
            }            
            
            // Вывод картинки и очистка памяти
            if( $format == "png" ){
                $imagefunc($idest, $dest);
            }else{
                $imagefunc($idest, $dest, $quality);
            }
            imagedestroy($idest);
            imagedestroy($source);

            return true;
        }else{
            if( $format == "png" ){
                $imagefunc($source, $dest);
            }else{
                $imagefunc($source, $dest, $quality);
            }
            imagedestroy($source);
            
            return true;
        }
    }



function make_thumb($uploadfile1,$end_thumb,$width,$height,$width_big_image=0,$height_big_image=0)
{
    list($w_i, $h_i, $type) = getimagesize($uploadfile1);
    $ratio = $w_i/$h_i;
    if($ratio > $width/$height)
    {
        resize($uploadfile1, $end_thumb, false, $height);   
        $m = 1;
    }
    else
    {
        resize($uploadfile1, $end_thumb, $width, 0);    
        $m = 2;
    }
    
    crop($end_thumb, $end_thumb, array(0, 0, $width, $height));
}


function resize($file_input, $file_output, $w_o, $h_o, $percent = false) {
    list($w_i, $h_i, $type) = getimagesize($file_input);
    if (!$w_i || !$h_i) {
        echo 'Can not get the length and width of the image';
        return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
        $func = 'imagecreatefrom'.$ext;
        $img = $func($file_input);
    } else {
        echo 'Invalid file format';
        return;
    }
    if ($percent) {
        $w_o *= $w_i / 100;
        $h_o *= $h_i / 100;
    }
    if (!$h_o) $h_o = $w_o/($w_i/$h_i);
    if (!$w_o) $w_o = $h_o/($h_i/$w_i);
    $img_o = imagecreatetruecolor($w_o, $h_o);
    imagealphablending($img_o, false);
    imagesavealpha($img_o, true);
    imagecopyresampled($img_o, $img, 0, 0, 0, 0, $w_o, $h_o, $w_i, $h_i);
    if ($type == 2) {
        return imagejpeg($img_o,$file_output,80);
    } else {
        $func = 'image'.$ext;
        return $func($img_o,$file_output);
    }
}



/**
* Обрезка изображения
*
* Функция работает с PNG, GIF и JPEG изображениями.
* Обрезка идёт как с указанием абсоютной длины, так и относительной (отрицательной).
*
* @param string Расположение исходного файла
* @param string Расположение конечного файла
* @param array Координаты обрезки
* @param bool Размеры даны в пискелях или в процентах
* @return bool
*/
function crop($file_input, $file_output, $crop = 'square',$percent = false) {
    list($w_i, $h_i, $type) = getimagesize($file_input);
    if (!$w_i || !$h_i) {
        echo 'Can not get the length and width of the image';
        return;
    }
    $types = array('','gif','jpeg','png');
    $ext = $types[$type];
    if ($ext) {
        $func = 'imagecreatefrom'.$ext;
        $img = $func($file_input);
    } else {
        echo 'Invalid file format';
        return;
    }
    if ($crop == 'square') {
        $min = $w_i;
        if ($w_i > $h_i) $min = $h_i;
        $w_o = $h_o = $min;
    } else {
        list($x_o, $y_o, $w_o, $h_o) = $crop;
        if ($percent) {
            $w_o *= $w_i / 100;
            $h_o *= $h_i / 100;
            $x_o *= $w_i / 100;
            $y_o *= $h_i / 100;
        }
        if ($w_o < 0) $w_o += $w_i;
        $w_o -= $x_o;
        if ($h_o < 0) $h_o += $h_i;
        $h_o -= $y_o;
    }
    $img_o = imagecreatetruecolor($w_o, $h_o); 
    imagealphablending($img_o, false);
    imagesavealpha($img_o, true);
    imagecopy($img_o, $img, 0, 0, $x_o, $y_o, $w_o, $h_o);
    if ($type == 2) {
        return imagejpeg($img_o,$file_output,100);
    } else {
        $func = 'image'.$ext;
        return $func($img_o,$file_output);
    }
}



function trim_text($input, $length=200, $ellipses = true, $strip_html = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }
  
    //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }
  
    //find last space within length
    $last_space = strrpos(mb_substr($input, 0, $length), ' ');
    $trimmed_text = mb_substr($input, 0, $last_space);
  
    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }
  
    return $trimmed_text;
}



/*
 * Делает серую копию картиночки (для эффекта наведения и прочего)
 * Использует это: http://php.net/manual/ru/function.imagefilter.php
 * Обратите внимание, что функция принимает именно константуЮ, не строку, и она принмает участие в формировании имени файла как порядковый номер фильтра
 * 
 * */
function makefiler($image,$filter = IMG_FILTER_GRAYSCALE, $arg1=false, $arg2=false, $arg3=false, $arg4=false)
{
	$imginfo = getimagesize($image);
	if( !$imginfo ){
		return 'The uploaded image must be png or jpg';
	}
	$fileName = basename($image);
	$filePath = str_replace($fileName, '', $image);
	
	if( $imginfo[2]==2 ){
		$im = imagecreatefromjpeg($image);
		if($im && imagefilter($im, $filter, $arg1, $arg2, $arg3, $arg4))
		{
		    imagejpeg($im, $filePath.strval($filter)."_".$fileName, 100);
		}
		else
		{
		    return 'Error overlaying filter on image';
		}
		imagedestroy($im);
	}elseif($imginfo[2]==3){
		$im = imagecreatefrompng($image);
		if($im && imagefilter($im, $filter, $arg1, $arg2, $arg3))
		{
	    	imagealphablending($im, false);
    		imagesavealpha($im, true);
		    imagepng($im, $filePath.strtolower($filter)."_".$fileName);
		}
		else
		{
		    return 'Error overlaying filter on image';
		}
		imagedestroy($im);
		
	}else{
		return 'The uploaded image must be png or jpg';
	}
}



function CreateDump($fileNameBackup = 'backupDB')
{
	global $db;
	$return = '';
    $tables = array();
	$strDir = $_SERVER['DOCUMENT_ROOT'].'/'.WS_PANEL.'/service/backup/mysql/';
    if( !file_exists($strDir) ){
	    mkdir($strDir, 0755, true);
	}
	
    $result = mysqli_query($db,'SHOW TABLES');
    while($row = mysqli_fetch_row($result))
    {
       $tables[] = $row[0];
    }
 
    foreach($tables as $table)
    {
        $result = mysqli_query($db,'SELECT * FROM '.$table);
        $num_fields = mysqli_num_fields($result);
        $return.= 'DROP TABLE IF EXISTS '.$table.';';
        $row2 = mysqli_fetch_row(mysqli_query($db,'SHOW CREATE TABLE '.$table));
        $return.= "\n\n".$row2[1].";\n\n";
        for ($i = 0; $i < $num_fields; $i++)
        {
            while($row = mysqli_fetch_array($result))
            {
                $return.= 'INSERT INTO '.$table.' VALUES(';
                for($j=0; $j<$num_fields; $j++)
                {
                    $row[$j] = @addslashes($row[$j]);
                    $row[$j] = @str_replace("\n","\\n",$row[$j]);
					
                    if( $row[$j] ) {
                    	$return.= '"'.$row[$j].'"' ; 
					} else {
						$return.= '""'; 
					}
                    if ($j<($num_fields-1)) {
                    	$return.= ',';
					}
                }
                $return.= ");\n";
            }
        }
        $return.="\n\n\n";
    }

    if($return!=''){
    	
        $return = "--".date('Y-m-d H:i:s')."\n".$return;
        $strDumpName = $fileNameBackup.'.sql';
		//show( $strDir.$strDumpName );
        $handle = fopen( $strDir.$strDumpName , 'w+' );
        fwrite( $handle , $return );
        fclose( $handle );
        return $strDumpName;
		  
    }else{
    	
        return false;
		
    }
}



// из строки с цифрами через запятую в массив
function is_abs($val)
{
	return is_numeric($val) && $val>0; 
}


function make_explode( $arr_param ){
	return array_filter(explode(',', $arr_param ), "is_abs");
}

//цена в красивом виде 
function price_format($price, $zero = 0)
{
    return number_format($price, $zero, '.', ' ');
}

// массив иерархии страниц по section_id
function pp($pid)
{
    global $db , $arParentPages , $CCpu;  
    
    $getparentPage = mysqli_query($db, 
    "
    SELECT u.id, u.section_id, u.title_".$CCpu->lang." AS title, c.cpu FROM ws_pages u 
    INNER JOIN ws_cpu c ON c.page_id = u.id 
    WHERE u.id = ".(int)$pid." AND c.lang = '".$CCpu->lang."' ");
    if( mysqli_num_rows($getparentPage)>0 ){
        $pp = mysqli_fetch_assoc($getparentPage);
        $arParentPages[]=$pp;
        
        pp($pp['section_id']);
    }
}


function getErrorMessage( $params = array() ){

    $mess = '';

    if($params['text']!=''){
        $params['text'] = '<p style="   font-family: \'Open Sans\'; margin-bottom: 0;margin: 0 0 10px;"> '. $params['text'] .' </p>';
    }

    if(!empty($params)){
        $mess = '<div class="callout callout-danger" style="font-family: \'Open Sans\';border-radius: 3px;
            margin: 0 0 20px 0;
            padding: 15px 30px 15px 15px;
            border-left: 5px solid #eee;border-color: #c23321;    color: #fff !important;background-color: #dd4b39 !important;">
                <h4 style="    margin-bottom: 10px;margin-top: 0;
            font-weight: 600;font-size: 18px;line-height: 1.1;
            color: inherit;"> '. $params['title'] .' </h4>
        
                '. $params['text'] .'
            </div>';
    }

    return $mess;
}






/* ------------------------------ PROJECT ------------------------------------- */




?>