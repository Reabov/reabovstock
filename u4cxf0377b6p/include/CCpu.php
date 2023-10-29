<?
/**
* Класс для работы с ЧПУ
* 
* @author       Cusnir Simion <cusnir.simion@webmaster.md>
* @copyright    Copyright (c) 2015, Webmaster Studio, https://www.webmaster.md
* @version      1.1 Date: 2015-6-23
* @link         /ws/include.php
*/

class CCpu {
	
	var $lang;
	var $langList;
	var $langkeys;
	var $base;
	var $mainLang;
	
	/**
    * @method   LastSlash - Анализ адреса, при отсутствии слэша в конце - добавляем его
    * @return   $page - или подключаемая страница, или 404 ошибка - false
    */ 
    
    function __construct(){
    	global $db;
		$this->base = $db; 

		/*  2022.05.01
		$getCurrentLangs = mysqli_query($this->base, " SELECT `code`,`title` FROM ws_site_languages WHERE active = 1 ");
		$t = mysqli_fetch_all($getCurrentLangs, MYSQLI_ASSOC);
		$this->langkeys = array_column($t, 'code');
		$this->langList = array_column($t, 'title','code' );
        */

        $getCurrentLangs = mysqli_query($this->base, " SELECT `code`,`title` FROM ws_site_languages WHERE active = 1 ");
        $a=0;
        while ( $t = mysqli_fetch_assoc($getCurrentLangs) ){
            $this->langkeys[$a]=$t['code'];
            //$this->langList[$a]['code']=$t['code'];
            $this->langList[$t['code']]=$t['title'];
            $a++;
        }
		
		$getMainLang = mysqli_query($this->base, " SELECT `code` FROM  ws_site_languages WHERE is_default = 1 LIMIT 1");
		$ML = mysqli_fetch_assoc($getMainLang);
		$this->mainLang = $ML['code'];
    }
   
    
       
    public function LastSlash($string){
    	$string = strval($string);
		if(!$string || $string==''){
			return "";
		}else{
			$lastSymbol = $string[strlen($string)-1];
			return $lastSymbol;
		}
    }
	
	public function FirstSlash($string){
		$string = strval($string);
		if(!$string || $string==''){
			return "";
		}else{
			$lastSymbol = $string[0];
			return $lastSymbol;
		}
	}
	
	
	
	
	
    /**
    * @method   GetCPU - Анализ адреса
    * @return   или масив с данными и статусом - проавильный урл, нужен 301 редирект или 404 ошибка
    */    
    public function GetCPU(){
		
        $url = $_SERVER['REQUEST_URI'];
		//очистка
		$url = filter_var($url, FILTER_SANITIZE_URL);
		$url = preg_replace("/[^\x20-\xFF]/","",strval($url));
		$url = str_replace("%22", "", $url);
		$urlR = explode("?", $url);
		$url = $urlR[0];
		
		/* Вариант со слэшем */
		if( $GLOBALS['last_slash'] ){
				
			if( $this->LastSlash($url)!=="/" ){
			    
	            $get404 = mysqli_query($this->base, " SELECT id FROM ws_cpu WHERE cpu = '".$url."/' ");
				// страница не найдена
	            if(mysqli_num_rows($get404)==0){
	                return array(
						'status'=>'404',
						'data'=>false
					);
	            }
	            // редирект 301 на версию со слэшем
				return array(
					'status'=>'redirect',
					'data'=>$url."/"
				);
			}
			
			$realurl = $url;
			
		/* Вариант без слэша в конце */	
		}else{
			
			if( $this->LastSlash($url)==="/" && $url!=="/" ){
	            $get404 = mysqli_query($this->base, " SELECT id FROM ws_cpu WHERE cpu = '".$url."' ");
	            if(mysqli_num_rows($get404)==0){
	                return array(
						'status'=>'404',
						'data'=>false
					);
	            }
	            
				return array(
					'status'=>'redirect',
					'data'=>mb_substr($url, 0, -1)
				);
			}
			
			$realurl = ($url!=="/") ?  $url."/" : "/"; 
			
		}
		
		
		$getpage = mysqli_query($this->base, " SELECT * FROM ws_cpu WHERE cpu = '".$realurl."' LIMIT 1 ");
		$cpu = mysqli_fetch_assoc($getpage);
		$getPage = mysqli_query($this->base, "SELECT page FROM ws_pages WHERE id = ".$cpu['page_id']);
		$page_data = mysqli_fetch_assoc($getPage);
		if(!$page_data){
			return array(
				'status'=>'404',
				'data'=>false
			);
		}
		
		$this->lang = $cpu['lang'];
		return array("lang"=>$cpu['lang'], "page"=>$page_data['page'], "page_id"=>$cpu['page_id'], "cpu"=>$url, "elem_id"=>$cpu['elem_id'], 'status'=>'ok');

    }

	
	
	/**
    * @method   GetPageData - Получаем данные страницы
    * @return   или масив с данными, или 404 ошибка - false
    */ 
	public function GetPageData($pageData)
	{
		$pageId = intval($pageData['page_id']); 
		$lang = $pageData['lang'];
		if(!$pageId|| $pageId<1){
			return false;
		}
		$getpagedata = mysqli_query($this->base, " 
			SELECT id, id as page_id, title_".$lang." AS title , page_title_".$lang." AS page_title, meta_d_".$lang." AS meta_d, 
			meta_k_".$lang." AS meta_k, assoc_table, text_".$lang." AS `text`
			FROM ws_pages WHERE id = ".$pageId." LIMIT 1");  


		if($PAGE = mysqli_fetch_assoc($getpagedata))
		{
			
			// проверим, если данные не нужно тянуть с другой таблицы
			if( $PAGE['assoc_table']!='' )
			{
				$getRealData = mysqli_query($this->base, " 
				SELECT id, title_".$lang." AS title , page_title_".$lang." AS page_title, meta_d_".$lang." AS meta_d, 
				meta_k_".$lang." AS meta_k, text_".$lang." AS `text`, '' AS image
				FROM `".$PAGE['assoc_table']."` WHERE  `id` = '".$pageData['elem_id']."' LIMIT 1 "); //echo mysql_error();
				 
				 if( mysqli_num_rows($getRealData)===1 ){
					$RealPAGE = mysqli_fetch_assoc($getRealData); 
					$RealPAGE['assoc_table']=$PAGE['assoc_table'];
					$RealPAGE['page_id']=$PAGE['id'];
					return $RealPAGE; 
				 }else{
				 	return false;
				 }
			}
			else
			{
				return $PAGE;
			}
		}
		else
		{
			return false;
		}
	}
	
	
	
	/**
    * @method   GetPageData - Получаем данные страницы
    * @return   или масив с данными, или 404 ошибка - false
    */ 
	public function GetPageTitle($pageData)
	{
		$pageId = intval($pageData['page_id']); 
		$lang = $pageData['lang'];
		if(!$pageId|| $pageId==0){
			return false;
		}
		$getpagedata = mysqli_query($this->base, " 
			SELECT id,id as page_id, title_".$lang." AS title , page_title_".$lang." AS page_title, meta_d_".$lang." AS meta_d, 
			meta_k_".$lang." AS meta_k, assoc_table, text_".$lang." AS `text`
			FROM ws_pages WHERE id = ".$pageId." LIMIT 1");
		if($PAGE = mysqli_fetch_assoc($getpagedata))
		{
			return $PAGE;
		}
		else
		{
			return false;
		}
	}
	
	public function go404()
	{
		header('HTTP/1.0 404 Not Found');
		include($_SERVER['DOCUMENT_ROOT']."/pages/404.php");
		exit;
	}
	
	
	
	
	
	/*
	 * Проверим при обновлении для текстовых страниц 
	 * */
	public function unicPageURL($url, $lng, $pageID, $elem_id = 0)
	{
		$pageID = (int)$pageID;
		// проверим - если он вообще существует	
		$getCPU = mysqli_query($this->base, " SELECT id FROM ws_cpu WHERE `cpu` = '".$url."' ");
		if(mysqli_num_rows($getCPU)==0){
			//адрес уникален, возвращаем как есть
			return $url;
		}elseif(mysqli_num_rows($getCPU)==1){ 
			// проверим, если это не он сам
			$getCPU = mysqli_query($this->base, " SELECT id FROM ws_cpu WHERE `cpu` = '".$url."' AND  page_id = ".$pageID." AND lang = '".$lng."' AND elem_id =  ".(int)$elem_id);
			if(mysqli_num_rows($getCPU)==1){  // это просто обновление существующего
				return $url;
			}else{ // такой где-то уже есть
				$url = $url.$GLOBALS['ar_define_settings']['CPU_KEYWORD']."/";
				//$this->unicPageURL($url,$lng,$pageID);
				if($url===$this->unicPageURL($url,$lng,$pageID)){
					return $url;
				}else{
					return $this->unicPageURL($url,$lng,$pageID);
				}
			}
		}else{
			// такого не может быть
			exit("Уведомление: в системе найдено 2 идентичных адреса: ".$url);
		}
	}
	
	
	
	
	/*
	 * Только для обчных текстовых
	 * */
	public function updateCpu($arr,$pageId)
	{
		 if(!$pageId || !is_numeric($pageId) || $pageId==0){
		 	echo "No page for editing";
		 }
		 //show($this);
		 foreach ($this->langkeys as $key => $Lang){
		    
            if( $arr[$Lang]!=='' && $arr[$Lang]==NULL ){
                continue;
            }
             
            // anti-tormoz
            if( $arr[$Lang]==''  ){
                $arr[$Lang] = '/'.md5(microtime()).'/';
            } 
             
		 	// проверим уникальность		
		 	$arr[$Lang] = $this->unicPageURL($arr[$Lang],$Lang,$pageId);	
		 	
		 	$controlIfExist = mysqli_query($this->base, " SELECT `id` FROM `ws_cpu` WHERE `page_id` = '".$pageId."' AND lang = '".$Lang."' LIMIT 1 ");
		 	if(mysqli_num_rows($controlIfExist)===0){
		 		$addRecord = mysqli_query($this->base, " INSERT INTO `ws_cpu` (`page_id`,`cpu`,`lang`) VALUES ('".$pageId."','".$arr[$Lang]."','".$Lang."') ");
		 	}else{
                $controlI = mysqli_fetch_assoc($controlIfExist);

		 		$result_cpu = mysqli_query($this->base, "UPDATE `ws_cpu` SET cpu =  '".$arr[$Lang]."' WHERE id = '". $controlI['id'] ."'");
				if(!$result_cpu){
					echo "Error editing table ws_cpu. ".mysqli_error($this->base);
				}
		 	}

		 }	
	}
	
	
	
	/*
	 * Для элементов типа новостей
	 * 
	 * $arr - 		массив УРЛ-ов
	 * $pageId - 	ид страницы из ws_pages
	 * $db_table - 	имя таблицы, где хранится редактируемый элемент
	 * $elem_id - 	ид элемента в таблице $db_table
	 * 
	 * */
	
	public function updateElementCpu($arr,$pageId,$elem_id)
	{
		 if(!$pageId || !is_numeric($pageId) || $pageId==0){
		 	echo "No page for editing";
			 return false;
		 }
		 
		 foreach ($this->langkeys as $Lang){ 
		 	// проверим уникальность		
		 	$arr[$Lang] = $this->unicElementURL($arr[$Lang], $Lang, $pageId, $elem_id); 
	 	
		 	$result_cpu = mysqli_query($this->base, "UPDATE `ws_cpu` SET cpu =  '".$arr[$Lang]."' WHERE `page_id` = '".$pageId."' AND lang = '".$Lang."' AND elem_id = ".$elem_id);
			
			// update
			$getElem = mysqli_query($this->base, " SELECT * FROM `ws_cpu` WHERE `page_id` = '".$pageId."' AND lang = '".$Lang."' AND elem_id = ".$elem_id);
			if(mysqli_num_rows($getElem)==0){
				$add = mysqli_query($this->base, "INSERT INTO `ws_cpu` (`page_id`,`cpu`,`lang`,`elem_id`) VALUES ('".$pageId."','".$arr[$Lang]."','".$Lang."','".$elem_id."')");
			}

		 }	
	}


	
	/*
	 * проверям на уникальность ЧПУ при добавлении
	 * */
	public function unicURL($url)
	{ 
		$getCPU = mysqli_query($this->base, " SELECT id FROM ws_cpu WHERE `cpu` = '".$url."' ");
		if( mysqli_num_rows($getCPU)!==0 ){
			$url = $url.$GLOBALS['ar_define_settings']['CPU_KEYWORD']."/";
			//$url = $this->unicURL($url);
			return $this->unicURL($url);
		}
		// Проверим, если у нас в массиве уже не свормировался дудликат
		return $url;
	}
	
	
	
	/*
	 * проверям на уникальность ЧПУ при редактировании элемента
	 * */
	public function unicElementURL($url, $Lang, $pageId, $elem_id)
	{
		$getCPU = mysqli_query($this->base, " SELECT id FROM ws_cpu WHERE `cpu` = '".$url."' AND (`page_id` <> '".$pageId."' OR  lang <> '".$Lang."' OR elem_id <> ".$elem_id." ) ");
		if( mysqli_num_rows($getCPU)!=0 ){
			$url = $url.$GLOBALS['ar_define_settings']['CPU_KEYWORD']."/";
			return $this->unicElementURL($url, $Lang, $pageId, $elem_id);
		}
		return $url;
	}
    
    public function unicPromoElementURL($url, $Lang, $pageId, $elem_id)
    {
        $getCPU = mysqli_query($this->base, " SELECT id FROM ws_promo_cpu WHERE `cpu` = '".$url."' AND (`page_id` <> '".$pageId."' OR  lang <> '".$Lang."' OR elem_id <> ".$elem_id." ) ");
        if( mysqli_num_rows($getCPU)!=0 ){
            $url = $url.$GLOBALS['ar_define_settings']['CPU_KEYWORD']."/";
            return $this->unicPromoElementURL($url, $Lang, $pageId, $elem_id);
        }
        return $url;
    }
	
	
	public function insertCpu($arr,$pageId,$elem_id = 0)
	{
		if(!$pageId || !is_numeric($pageId) || $pageId==0){
		 	exit('Не указана страница для редактирования');
		}
		foreach ($this->langkeys as $key => $Lang){ 
		 	$arr[$Lang] = $this->unicURL($arr[$Lang]);
		 	$result_cpu = mysqli_query($this->base, "INSERT INTO `ws_cpu` (`cpu`, `page_id`, `lang`, `elem_id`) VALUES ('".$arr[$Lang]."','".$pageId."', '".$Lang."', '".$elem_id."' ) ");
			if(!$result_cpu){
				echo "Ошибка редактирования таблицы ws_cpu. ".mysqli_error( $this->base );
			}
		}	
		 
		 return true;
	}

	
	
	public function translitURL($str) 
	{
		$tr = array(
          "А"=>"a","Б"=>"b","В"=>"v","Г"=>"g",
          "Д"=>"d","Е"=>"e","Ё"=>"yo","Ж"=>"zh","З"=>"z","И"=>"i",
          "Й"=>"j","К"=>"k","Л"=>"l","М"=>"m","Н"=>"n",
          "О"=>"o","П"=>"p","Р"=>"r","С"=>"s","Т"=>"t",
          "У"=>"u","Ф"=>"f","Х"=>"H","Ц"=>"c","Ч"=>"ch",
          "Ш"=>"sh","Щ"=>"sch","Ъ"=>"j","Ы"=>"y","Ь"=>"i",
          "Э"=>"e","Ю"=>"yu","Я"=>"ya","а"=>"a","б"=>"b",
          "в"=>"v","г"=>"g","д"=>"d","е"=>"e","ё"=>"yo","ж"=>"zh",
          "з"=>"z","и"=>"i","й"=>"j","к"=>"k","л"=>"l",
          "м"=>"m","н"=>"n","о"=>"o","п"=>"p","р"=>"r",
          "с"=>"s","т"=>"t","у"=>"u","ф"=>"f","х"=>"h",
          "ц"=>"c","ч"=>"ch","ш"=>"sh","щ"=>"sch","ъ"=>"j",
          "ы"=>"y","ь"=>"i","э"=>"e","ю"=>"yu","я"=>"ya", 
          " "=> "-", "."=> "", "І"=> "i", "'"=>"","39"=>"",
          "і"=> "i", "&#1186;"=> "n", "&#1187;"=> "n", 
          "&#1198;"=> "u", "&#1199;"=> "u", "&#1178;"=> "q", '""'=>'', '//'=>'/',
          "&#1179;"=> "q", "&#1200;"=> "u",
          "&#1201;"=> "u", "&#1170;"=> "g", "&#1171;"=> "g", 
          "&#1256;"=> "o", "&#1257;"=> "o", "&#1240;"=> "a", 'ă'=>'a','ț'=>'t','ș'=>'s',
          "&#1241;"=> "a" , 'Š'=>'S', 'š'=>'s', 'Ž'=>'Z', 'ž'=>'z', 'À'=>'A', 'Á'=>'A', 'Â'=>'A', 'Ã'=>'A', 'Ä'=>'A', 'Å'=>'A', 'Æ'=>'A', 'Ç'=>'C', 'È'=>'E', 'É'=>'E',
          'Ê'=>'E', 'Ë'=>'E', 'Ì'=>'I', 'Í'=>'I', 'Î'=>'I', 'Ï'=>'I', 'Ñ'=>'N', 'Ò'=>'O', 'Ó'=>'O', 'Ô'=>'O', 'Õ'=>'O', 'Ö'=>'O', 'Ø'=>'O', 'Ù'=>'U',
          'Ú'=>'U', 'Û'=>'U', 'Ü'=>'U', 'Ý'=>'Y', 'Þ'=>'B', 'ß'=>'Ss', 'à'=>'a', 'á'=>'a', 'â'=>'a', 'ã'=>'a', 'ä'=>'a', 'å'=>'a', 'æ'=>'a', 'ç'=>'c',
          'è'=>'e', 'é'=>'e', 'ê'=>'e', 'ë'=>'e', 'ì'=>'i', 'í'=>'i', 'î'=>'i', 'ï'=>'i', 'ð'=>'o', 'ñ'=>'n', 'ò'=>'o', 'ó'=>'o', 'ô'=>'o', 'õ'=>'o',
          'ö'=>'o', 'ø'=>'o', 'ù'=>'u', 'ú'=>'u', 'û'=>'u', 'ý'=>'y', 'þ'=>'b', 'ÿ'=>'y'                        
      );
      // Убираю тире, дефисы внутри строки
      $urlstr = str_replace('–'," ",$str);
      $urlstr = str_replace('-'," ",$urlstr); 
      $urlstr = str_replace('—'," ",$urlstr);
  
      // Убираю лишние пробелы внутри строки
      $urlstr=preg_replace('/\s+/',' ',$urlstr);
       if (preg_match('/[^A-Za-z0-9_\-]/', $urlstr)) {
          $urlstr = strtr($urlstr,$tr);
          $urlstr = preg_replace('/[^A-Za-z0-9_\-\/]/', '', $urlstr);
          $urlstr = strtolower($urlstr);
          return $urlstr;
      } else {
          return strtolower($str);
      }
  }	


	
	
	/*
	 * список адресов текущей страницы для всех языков
	 * */
	public function getURLs($page_id,$elem_id = 0)
	{		
		$URLs = array();
		$getUrl = mysqli_query($this->base, " SELECT * FROM ws_cpu WHERE page_id = $page_id AND elem_id = ".$elem_id);
		while( $u = mysqli_fetch_assoc($getUrl) )
		{
			$URLs[$u['lang']] = $u['cpu'];

		}
		return $URLs;
	}
	
    /*
     * вывести ссылку на страницу
     * */
    public function writelink($page_id, $elem_id = 0)
    {
        $Url = $this->getURLs($page_id,$elem_id); 
        return $Url[$this->lang];
    } 
     public function writelinkOne($page_id, $elem_id = 0){
         $getUrl = mysqli_query($this->base, " SELECT * FROM ws_cpu WHERE page_id = $page_id AND elem_id = ".$elem_id." AND lang = '". $this->lang ."' LIMIT 1 ");
         $u = mysqli_fetch_assoc($getUrl);

         return $u['cpu'];
     }
	
	/*
	 * выводит ссылки для альтернативных страниц
	 * */
	public function alterlinks($_page_id, $_elem_id)
	{
		 $URLs = $this->getURLs($_page_id, $_elem_id);
		 foreach ($URLs as $_lng => $_addr ) {
		 	if($_lng==$this->lang){continue;}
			 ?>
			 <link rel="alternate" hreflang="<?=$_lng?>" href="//<?=$_SERVER['SERVER_NAME'].$_addr?>" />
			 <?
		 }
	}
	
	
	
	
	
	/*
	 * проверяем, чтобы адреса в массиве имели нужный формат
	 * */
	public function controlURL($urlArr)
	{
		// почистим каждый адрес и проверим слэши в конце
		foreach ($urlArr as $key => $value) {
			$value = $this->translitURL($value);
			if( $this->LastSlash($value)!='/' ){
				$value = $value."/";
			}
			if( $this->FirstSlash($value)!='/' ){
				$value = "/".$value;
			}
			$urlArr[$key] = $value;
		}

		return $urlArr;
	}
	
	
	public function regionURL($urlArr)
	{
		// проверим, если есть совпадения
		
		$arMatchres = array_count_values($urlArr);
		foreach ($arMatchres as $key => $value) {
			if( $value == 1 ){
				unset($arMatchres[$key]);
			}
		}  
			
		foreach ($urlArr as $code => $value){  
			if( $code !== $this->mainLang  &&  array_key_exists($value, $arMatchres) ){
				$urlArr[$code] = "/".$code.$value;
			}
		}
		return $urlArr;
	}
	
	
	public function controlMainPageURL($urlArr)
	{
		foreach ($urlArr as $code => $url){
			if( $code == $this->mainLang ){
				$urlArr[$code] = '/';
			}elseif( $url =='/' || $url=='' ){
				$urlArr[$code] = $code;
			}
		}
		
		return $urlArr;
	}
	
	
	/* https://www.youtube.com/watch?v=BTV5Xpo4j3M&index=33&list=PLcA49Jlt0WvdNhxElE6FomSQw89isukAl
	 * базовые параметры для постраничной навигации
	 * 
	 * page - текущая страница
	 * per_page - кол-во на странице
	 * pages - кол-во страниц
	 * from - в запрос, с какого элемента начинать
	 * 
	 * */
	
	public function pagination($SQL_query, $perPage = 6)
	{
		$getCount = mysqli_query($this->base, $SQL_query);
		$pagesCount = mysqli_num_rows($getCount); 
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
			'page'=>$page,
			'per_page'=>$perPage,
			'pages'=>$pages,
			'from'=>$from,
			'prev'=>$PrevPage,
			'next'=>$NextPage
		);
	}
    
    public function writetitle($page_id, $elem_id = 0 )
    {
        $lang = $this->lang;  
        if( $elem_id == 0 ){
            $getTitle = mysqli_query($this->base, " SELECT title_".$lang." AS title FROM ws_pages WHERE id = ".(int)$page_id);
            if( mysqli_num_rows($getTitle)===1 ){
                $a = mysqli_fetch_assoc($getTitle);
                return $a['title'];
            }else{
                return "";
            }
        }else{
            $getTable = mysqli_query($this->base, " SELECT assoc_table AS `table` FROM ws_pages WHERE id = ".(int)$page_id);
            if( mysqli_num_rows($getTable)===1 ){
                $a = mysqli_fetch_assoc($getTable);
                $getTitle = mysqli_query($this->base, " SELECT title_".$lang." AS title FROM `".$a['table']."` WHERE id = ".(int)$elem_id);
                $pageName = mysqli_fetch_assoc($getTitle);
                return $pageName['title'];
            }else{
                return "";
            }
        }
        
    }
    
    
}
?>