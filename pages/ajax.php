<?
$ar_clean = filter_input_array( INPUT_POST , FILTER_SANITIZE_SPECIAL_CHARS);
if ( !isset( $_POST ) || empty( $_POST ) || !isset( $_POST['task'] ) ) { exit; }



/* авторизация на сайте */
if($ar_clean['task'] === 'authorization'){
    $user = $User->auth( $ar_clean['login'], $ar_clean['password'] );
    if($user){
        echo "ok";
    }else{
        echo "Неверные данные";
    }
}



/* регитрация */
if($ar_clean['task'] === "registration"){
    
    if( !filter_var($ar_clean['email'], FILTER_VALIDATE_EMAIL) ){
        exit("Неверный e-mail");
    }
    
    $getemail = $Db->getone("SELECT id FROM ws_clients WHERE email = '".$ar_clean['email']."' LIMIT 1");
    if($getemail){
        exit("Этот e-mail уже занят");
    }

    $arFields = array('name','email');
    $arData = array("'".$ar_clean['name']."'", "'".$ar_clean['email']."'");

    if( $User->register($arFields, $arData, $ar_clean['email'], $ar_clean['password'])  ){
        echo "ok";
    }else{
        echo "Не удалось зарегистрироваться. Попробуйте еще раз";
    }
    
}

if($ar_clean['task'] === "get_variations_sizes"){
	$id = $ar_clean['var_id'];
	$sizes = $Db->getall("SELECT * FROM `ws_categories_elements_size` WHERE var_id = ".$id." ORDER BY sort DESC ");
	foreach ($sizes as $key => $size) {
		?>
	<button class="size_btn" data-link="<?=$size['link_en']?>" data-id="<?=$size['id']?>" onclick="setChoiceSize(this,'/upload/categories/products/size/<?=$size['image']?>','<?=$size['id']?>')"><?=$size['title_'.$CCpu->lang]?></button>
		<?
	}
}



if($ar_clean['task'] === "get_carusel"){
	$id = $ar_clean['id'];
	$product = $Db->getone("SELECT * FROM `ws_categories_elements` WHERE id = ".$id);
	$gallery = $Db->getall("SELECT * FROM `ws_photogallery` WHERE elem_id = ".$id);
	if($product['type'] == '1'){
		$variations = $Db->getall("SELECT * FROM `ws_categories_variation` WHERE section_id = ".$id);
		$var_arr = array();
		foreach ($variations as $key => $var) {
			$var_arr[] = $var['id'];
		}
		$var_arr = implode(',', $var_arr);
		$sizes = $Db->getall("SELECT * FROM `ws_categories_elements_size` WHERE var_id IN (".$var_arr.") ORDER BY sort DESC ");
	}else{
		$sizes = $Db->getall("SELECT * FROM `ws_categories_elements_size` WHERE elem_id = ".$id." ORDER BY sort DESC ");
	}
	
	
	$total_gallery = array();
	foreach ($gallery as $key => $value) {
		$total_gallery[] = '/upload/gallery/'.$value['image'];
	}
	foreach ($sizes as $key => $value) {
		$total_gallery[] = '/upload/categories/products/size/'.$value['image'];
	}
	?>
	<section class="carul">
            <div class="slider__wrapper">
                <div class="slider__close">
                    <?/* <a onclick="close_carusel()">
                        <img src="/images/icons/Group 453.png" alt="">
                    </a> */?>
                </div>
                <div class="carul-slider">
                	<?
                	foreach ($total_gallery as $key => $gal) {
                		?>
                	<div class="slide carul-slide" >
                		<div class="slide_img_relative">
                			<a onclick="close_carusel()">
                        		<img src="/images/icons/Group 453.png" alt="">
                    		</a>
                			<img class="carul_img" src="<?=$gal?>" alt="">
                		</div>
                    </div>	
                		<?
                	}
                	?>
                </div>
                <div class="slider-nav">
                    <div class="slider-arrow"></div>
                </div>
            </div>
            </div>
    </section>
	<?
}


if($ar_clean['task'] === 'get_more_search'){
	
	$query = $ar_clean['query'];
	$start = $ar_clean['start'];
	
	//print_r($query);
	$catalog = $Db->getall($query);
	
	foreach ($catalog as $key => $prod) {
    	if($key >= 0 && $key < $start){
        	?>
            <div class="col-lg-20 col-md-3 col-sm-4 col-xs-6 col_filter_prod" data-key="<?=$key?>">
            	<div class="filter__item">
                    <a href="<?=$CCpu->writelink(74,$prod['id'])?>" class="filter__link">
                    	<img src="/upload/categories/products/<?=$prod['image']?>" alt="">
                	</a>
                </div>
            </div>		
            <?
    	}
	}
	
}


if($ar_clean['task'] === 'get_tag_list'){
	$search = $ar_clean['search'];
	
	$tags = $Db->getall("SELECT DISTINCT title_".$CCpu->lang." FROM `ws_tags` WHERE title_".$CCpu->lang." LIKE '".$search."%' ORDER BY title_".$CCpu->lang." ASC ");
	if($tags != array()){
	?>
	<ul>
		<?
		foreach ($tags as $key => $tag) {
			?>
		<li onclick="select_tag('<?=$tag['title_'.$CCpu->lang]?>')">
        	#<?=$tag['title_'.$CCpu->lang]?>
        </li>	
			<?
		}
		?>
	</ul>
	<?
	}else{
		echo "err";
	}
	
}


if($ar_clean['task'] == 'pre_reg'){
	$name = $ar_clean['name'];
	$country_id = $ar_clean['country_id'];
	$country = $Db->getone("SELECT * FROM `ws_country` WHERE id = ".$country_id);
	$country = $country['title_'.$CCpu->lang];
	$email = $ar_clean['email'];
	$password = $ar_clean['password'];
	
	$pass = hash('sha512', trim($password));
    $pass = hash('sha512', $pass.$GLOBALS['security_salt']);
	
	$check_email = $Db->getone("SELECT * FROM `ws_clients` WHERE email = '".$email."' ");
	
	if($check_email == array()){
		$client_query = $Db->q("INSERT INTO `ws_clients` (email,password,full_name,countrye,active,activated,image,crypt,registration_date,last_auth_date,elem_id)
											VALUES ('".$email."','".$pass."','".$name."','".$country."',1,0,'','',NOW(),'',".$country_id.") ");
		
		$client_id = mysqli_insert_id($db);
		if($client_query){
			
			//$logo_path = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/images/elements/logo/logo-black.png';
			$logo_path = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/images/icons/logo.png';
			
			
			$Text =  <<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" ></head>
<body><table border="0" cellpadding="0" cellspacing="0" style="max-width:600px !important;width: 100%;margin: 0 auto;" ><tbody>
<tr><td><table border="0" cellpadding="0" cellspacing="0" style="max-width: 600px !important;width: 100%;padding: 0 20px"><tr><td>
                        <img src="{$logo_path}" style="margin: 0 auto; display: block; margin-top: 50px; max-width: 565px; width: 100%;" alt="logo">
</td></tr></table></td></tr >
<tr ><td style="font-family: 'Tahoma';font-size: 50px;font-weight: 500;font-style: normal; text-transform: uppercase; text-align: center; padding-top: 88px; max-width: 434px; width: 100%;color: #000;">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_HI]} {$name}
</td></tr>
<tr><td colspan="2" ><table border="0" cellpadding="0" cellspacing="0"  style="width: 100%;max-width: 600px;"><tr><div style="font-size: 27px; font-weight: 300; text-align: center; color: #000;line-height: 38px; margin: 0 auto;font-family: 'Tahoma'">
			{$GLOBALS[ar_define_langterms][MSG_LETTER_CONFIRM_YOUR_EMAIL_TO_CONTINUE_YOUR_REGISTRATION]}
</div></tr></table></td></tr>
<tr><td colspan="2"><div style="font-family: 'Tahoma';font-size: 50px;font-weight: 500;max-width: 497px;margin: 0 auto;text-align: center;padding-bottom: 28px; padding-top: 47px; color: #44CE00; ">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_CONFIRM_EMAIL]}
</div></td></tr>
<tr><td colspan="2"><a href="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}{$CCpu->writelink(86)}?id={$client_id}" style="display: block; margin: 0 auto; text-align: center; text-decoration: none; max-width: 210px; width: 100%; padding: 10px 0; background-color: #44CE00; color: #fff;border-radius: 19px;font-size: 21px; font-weight: 500; font-family: 'Tahoma'">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_CLICK_HERE]}
</a></td></tr>
<tr><td colspan="2" style="font-size: 27px; font-weight: 500;color: #000; text-align: center;padding-top: 67px; padding-bottom: 13px; font-family: 'Tahoma'">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_IF_BUTTON_DOESNT_WORK_CLICK_ON_LINK_BELLOW]}
</td></tr>
<tr><td colspan="2" style="font-size: 27px;color: #000; font-weight: 300; text-align: center; padding-bottom: 102px; font-family: 'Tahoma'">
        	{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}{$CCpu->writelink(84)} {$GLOBALS[ar_define_langterms][MSG_LETTER_EMAIL_CONFIRM_LEA_LEA_LEA]}
</td></tr>
<tr><td colspan="2" ><table  cellpadding="0" cellspacing="0" style="width: 100%;margin: 0 auto"><tr>
<td><a href="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}{$CCpu->writelink(1)}" style="text-decoration: none;font-size: 29px; font-weight: 300;color: #000;font-family: 'Tahoma'">
			{$_SERVER[SERVER_NAME]}
</a></td>
<td align="right" valign="bottom" style="font-size: 29px; font-weight: 300;color: #000;font-family: 'Tahoma'">
			{$GLOBALS[ar_define_langterms][MSG_LETTER_ALL_RIGHTS_C_2023]}
</td></tr></table></td></tr>
</tbody></table></body></html>
HTML;
			
			
			//$Text = file_get_contents($_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$CCpu->writelink(90));
			//$Text = $Main->GetPageIncData('CHECKED_CODE' , $CCpu->lang);
			//$Text = str_replace('{link}', $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$CCpu->writelink(86).'?id='.$client_id, $Text);
			//$Text = str_replace('{user_full_name}', $name, $Text);
			
			include_once $_SERVER['DOCUMENT_ROOT'].'/lib/libmail/libmail.php';
    		$m= new Mail();
    		$m->From( $GLOBALS['ar_define_settings']['SMTP_MAIL'] );
    		$m->To( $email );
    		$m->Subject( $GLOBALS['ar_define_langterms']['MSG_LETTER_PODTVERDITE_SVOJ_EMEJL'] );
    		$m->Body($Text, "html");
    		$m->Priority(4);
			
    		$m->smtp_on($GLOBALS['ar_define_settings']['SMTP_SERVER'], $GLOBALS['ar_define_settings']['SMTP_MAIL'], $GLOBALS['ar_define_settings']['SMTP_PASS'], $GLOBALS['ar_define_settings']['SMTP_PORT']);
    		$m->log_on(true);
    		$a = $m->Send();
			
			echo "ok";
			
		}else{
			echo $GLOBALS['ar_define_langterms']['MSG_MESSAGE_NE_UDALOSI_SOZDATI_KLIENTA'];
		}
		
	}else{
		echo $GLOBALS['ar_define_langterms']['MSG_MESSAGE_ETOT_EMEJL_UZHE_ZAREGISTRIROVAN_V_BAZE_DANNYH'];
	}
	
}

if($ar_clean['task'] === "login"){
	
	$email = $ar_clean['email'];
	$password = $ar_clean['password'];
	
	if($ar_clean['check_save'] == '1'){
		$_SESSION['for_cookies'] = $email;
	}
	
	
	
	$pass = hash('sha512', trim($password));
    $pass = hash('sha512', $pass.$GLOBALS['security_salt']);
	
	$check_email = $Db->getone("SELECT * FROM `ws_clients` WHERE email = '".$email."' ");
	if($check_email != array()){
		if($check_email['activated'] == '1'){
			if($pass == $check_email['password']){
			
				$auth = $Client->auth($email,$password);
				if($auth){
					echo "ok";
				}else{
					echo $GLOBALS['ar_define_langterms']['MSG_MESSAGE_PROIZOSHLA_OSHIBKA_POVTORITE_POPYTKU_POZZHE'];
				}
			}else{
				echo $GLOBALS['ar_define_langterms']['MSG_MESSAGE_NEVERNYJ_PAROLI'];
			}
			
		}else{
			echo $GLOBALS['ar_define_langterms']['MSG_MESSAGE_ETA_ELEKTRONNAYA_POCHTA_NE_PODTVERZHDENA'];
			
		}
	}else{
		echo $GLOBALS['ar_define_langterms']['MSG_MESSAGE_V_BAZE_DANNYH_NET_POLIZOVATELYA_S_TAKIM_ELEKTRONNYM_ADRESOM'];
	}
	
}

if($ar_clean['task'] === "send_forgot"){
	$email = $ar_clean['email'];
	
	$get_client = $Db->getone("SELECT * FROM `ws_clients` WHERE email = '".$email."' ");
	if($get_client != array()){
		
		//$new_password = uniqid();
		$new_password = file_name(12);
		$name = $get_client['full_name'];
		
		$logo_path = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/images/icons/logo.png';
		
		$soc = $Db->getall("SELECT * FROM `ws_soc` ORDER BY id ASC ");
		$facebook = $soc[0];
		$facebook_link = $facebook['link_'.$CCpu->lang];
		$instagram = $soc[1];
		$instagram_link = $instagram['link_'.$CCpu->lang];
		$telegram = $soc[2];
		$telegram_link = $telegram['link_'.$CCpu->lang];
		
		
		
		$Text = <<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" ></head>
<body><table border="0" cellpadding="0" cellspacing="0" style="max-width:600px !important;width: 100%;margin: 0 auto;" ><tbody><tr><td><table border="0" cellpadding="0" cellspacing="0" style="max-width: 600px !important;width: 100%;padding: 0 20px"><tr><td>
			<img src="{$logo_path}" style="margin: 0 auto; display: block; margin-top: 50px; max-width: 565px; width: 100%;" alt="logo">
</td></tr></table></td></tr >
<tr ><td style="font-family: 'Tahoma';font-size: 50px;font-weight: 500;font-style: normal; text-transform: uppercase; text-align: center; padding-top: 88px; max-width: 434px; width: 100%;color: #000;">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_HI]} {$name}
</td></tr>
<tr><td colspan="2" ><table border="0" cellpadding="0" cellspacing="0"  style="width: 100%;max-width: 600px;"><tr><div style="font-size: 30px; font-weight: 300; text-align: center; color: #000;line-height: 38px; margin: 0 auto;font-family: 'Tahoma'">
			{$GLOBALS[ar_define_langterms][MSG_LETTER_YOUR_NEW_PASSWORD]}
</div></tr></table></td></tr>
<tr><td colspan="2"><div style="font-family: 'Tahoma';font-size: 50px;font-weight: 500;max-width: 497px;margin: 0 auto;text-align: center;padding-bottom: 59px; padding-top: 39px; color: #44CE00; ">
            {$new_password}
</div></td></tr>
<tr style="margin-bottom: 45px;"><td colspan="2"><a href="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}{$CCpu->writelink(1)}" style="display: block; margin: 0 auto; text-align: center; text-decoration: none; max-width: 210px; width: 100%; padding: 10px 0; background-color: #44CE00; color: #fff;border-radius: 19px;font-size: 21px; font-weight: 500; font-family: 'Tahoma'">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_BACK_TO_LOGIN]}
</a></td></tr>
<tr><td colspan="2" style="font-size: 27px;color: #7B7B7B; font-weight: 500; text-align: center; padding-top: 87px;padding-bottom: 58px; font-family: 'Tahoma'">
        	{$GLOBALS[ar_define_langterms][MSG_LETTER_FOLLOW_US_ON_SOCIAL_MEDIA]}
</td></tr>
<tr><td colspan="2" ><table border="0" cellpadding="0" cellspacing="0" style="max-width: 234px;width: 100%;margin: 0 auto;padding-bottom: 136px;"><tr><td align="start" width="24" height="46"  >
<a href="{$facebook_link}"  style="display: inline-block; height: 100%;">
			<img src="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}/images/icons/facebook-activ.png" alt="" style="width: 100%;height: 100%;">
</a></td>
<td align="middle" width="46" height="46"  >
<a href="{$instagram_link}"  style="display: inline-block; height: 100%;" >
			<img src="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}/images/icons/insta-activ.png" alt="" style="width: 100%;height: 100%;">
</a></td>
<td align="end" height="46" width="20">
<a href="{$telegram_link}"  style="display: inline-block; height: 100%;">
            <img src="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}/images/icons/telega-activ.png" alt="" style="width: 100%;height: 100%;">
</a></td></tr></table></td></tr>
<tr><td colspan="2" ><table  cellpadding="0" cellspacing="0" style="width: 100%;padding: 80px 0;margin: 0 auto"><tr><td>
<a href="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}{$CCpu->writelink(1)}" style="text-decoration: none;font-size: 29px; font-weight: 300;color: #000;font-family: 'Tahoma'">
			{$_SERVER[SERVER_NAME]}
</a></td>
<td align="right" valign="bottom" style="font-size: 29px; font-weight: 300;color: #000;font-family: 'Tahoma'">        
			all rights C 2023
</td></tr></table></td></tr></tbody></table></body></html>
HTML;
		
		
		
		//$Text = $Main->GetPageIncData('FORGOT_TEXT' , $CCpu->lang);
		//$Text = str_replace('{pass}', $new_password, $Text);
		//$Text = str_replace('{name}', $get_client['full_name'], $Text);
		
		$pass = hash('sha512', trim($new_password));
		$pass = hash('sha512', $pass.$GLOBALS['security_salt']);
		
		include_once $_SERVER['DOCUMENT_ROOT'].'/lib/libmail/libmail.php';
    	$m= new Mail();
    	$m->From( $GLOBALS['ar_define_settings']['SMTP_MAIL'] );
    	$m->To( $email );
    	$m->Subject( $GLOBALS['ar_define_langterms']['MSG_MESSAGE_NOVYJ_PAROLI'] );
    	$m->Body($Text, "html");
    	$m->Priority(4);
		
    	$m->smtp_on($GLOBALS['ar_define_settings']['SMTP_SERVER'], $GLOBALS['ar_define_settings']['SMTP_MAIL'], $GLOBALS['ar_define_settings']['SMTP_PASS'], $GLOBALS['ar_define_settings']['SMTP_PORT']);
    	$m->log_on(true);
    	$a = $m->Send();
		
		if($a){
			$update = $Db->q(" UPDATE `ws_clients` SET password = '".$pass."' WHERE id = ".$get_client['id']);
			if($update){
				echo "ok";
			}else{
				echo $GLOBALS['ar_define_langterms']['MSG_MESSAGE_NOVYJ_PAROLI_BYL_VYSLAN_NO_IZMENITI_EGO_NE_UDALOSI_POPROBUJTE_ESCHYO_RAZ'];
			}
		}else{
			echo $GLOBALS['ar_define_langterms']['MSG_MESSAGE_IZMENITI_PAROLI_NE_UDALOSI_NOVYJ_PAROLI_NE_BYL_VYSLAN'];
		}
		
	}else{
		echo $GLOBALS['ar_define_langterms']['MSG_MESSAGE_V_BAZE_DANNYH_NET_POLIZOVATELYA_S_TAKIM_ELEKTRONNYM_ADRESOM'];
	}
	
	
}


if($ar_clean['task'] == 'change_client_image'){
	
	$id = $ar_clean['client_id'];
	$client = $Db->getone("SELECT * FROM `ws_clients` WHERE id = ".$id);
	$old_img = $client['image'];
	if(isset($_FILES['file']) && $_FILES['file']['tmp_name'] != ''){
		print_r($_FILES);
		
	}
	if( isset($_FILES['file']['tmp_name']) && $_FILES['file']['tmp_name']!='' ){ 
		$FileName = file_name(10, $_FILES['file']['name'] );
        $uploadfile = $_SERVER["DOCUMENT_ROOT"]."/upload/userfiles/images/".$FileName;
		
        move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile);
		unlink($_SERVER["DOCUMENT_ROOT"]."/upload/userfiles/images/".$old_img);
		
		$Db->q("UPDATE `ws_clients` SET image = '".$FileName."' WHERE id = ".$id);
		
	}
	
}

if($ar_clean['task'] == 'edit_personal'){
	$id = $ar_clean['id'];
	$name = $ar_clean['name'];
	$country_id = $ar_clean['country_id'];
	$password = $ar_clean['password'];
	
	$client = $Db->getone("SELECT * FROM `ws_clients` WHERE id = ".$id);
	
	if($password == ''){
		$pass = $client['password'];
	}else{
		$pass = hash('sha512', trim($password));
		$pass = hash('sha512', $pass.$GLOBALS['security_salt']);
	}
	
	$update_query = $Db->q(" UPDATE `ws_clients` SET full_name = '".$name."', 
													elem_id = '".$country_id."', 
													password = '".$pass."' 
													WHERE id = ".$id);
	
	
	if($update_query){
		echo 'ok';
	}else{
		echo 'err';
	}
	
}

if($ar_clean['task'] == 'subscribe'){
	
	$price_id = $ar_clean['elem_id'];
	$client_id = $ar_clean['client_id'];
	
	$start = strtotime($ar_clean['from_date']);
	$end = strtotime($ar_clean['to_date']);
	$days = $ar_clean['days'];
	
	$period = $end - $start;
	
	$period = $days*24*60*60;
	
	$date_start = date('Y-m-d H:s:i',time());
	$date_end = date('Y-m-d H:s:i',time()+$period);
	
	
	$insert = $Db->q("INSERT INTO `ws_abonament_client` (client_id,ab_id,ab_start,ab_end,is_paid) VALUES 
												('".$client_id."','".$price_id."','".$date_start."','".$date_end."',0) ");
	
	if($insert){
		echo mysqli_insert_id($db);
	}else{
		echo "err";
	}
	
}


if($ar_clean['task'] == 'pay_subscribe'){
	$id = $ar_clean['id'];
	$update = $Db->q("UPDATE `ws_abonament_client` SET is_paid = 1 WHERE id = ".$id);
	$ab = $Db->getone("SELECT * FROM `ws_abonament_client` WHERE id = ".$id);
	$price = $Db->getone("SELECT * FROM `ws_abonament` WHERE id = ".$ab['ab_id']);
	$price = $price['price'];
	$price_number = $price;
	if($price < 100){
		$price_number = '0'.$price_number;
	}
	if($price < 10){
		$price_number = '0'.$price_number;
	}
	$client = $Db->getone("SELECT * FROM `ws_clients` WHERE id = ".$ab['client_id']);
	
	if($update){
		
		$not_insert = $Db->q(" INSERT INTO `ws_notifications` (is_read,client_id,type,rang,created) VALUES 
															(0,".$Client->id.",'pay_success',1,NOW()) ");
		
		$months['ru'] = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
		$months['en'] = array('january','february','march','april','may','june','july','august','september','october','november','december');
		
		$day_start = date('d', strtotime($ab['ab_start']));
		$day_end = date('d', strtotime($ab['ab_end']));
		
		$month_start = date('n', strtotime($ab['ab_start']));
		$month_start = $month_start-1;
		$month_start = $months[$CCpu->lang][$month_start];
		$month_end = date('n', strtotime($ab['ab_end']));
		$month_end = $month_end-1;
		$month_end = $months[$CCpu->lang][$month_end];
		
		$year_start = date('Y', strtotime($ab['ab_start']));
		$year_end = date('Y', strtotime($ab['ab_end']));
		
		//$logo_path = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/images/elements/logo/logo-black.png';
		$logo_path = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/images/icons/logo.png';
		
		
		$soc = $Db->getall("SELECT * FROM `ws_soc` ORDER BY id ASC ");
		$facebook = $soc[0];
		$facebook_link = $facebook['link_'.$CCpu->lang];
		$instagram = $soc[1];
		$instagram_link = $instagram['link_'.$CCpu->lang];
		$telegram = $soc[2];
		$telegram_link = $telegram['link_'.$CCpu->lang];
		
		$Text = <<<HTML
		<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd"><html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" ></head>
<body><table border="0" cellpadding="0" cellspacing="0" style="max-width:600px !important;width: 100%;margin: 0 auto;" ><tbody>
<tr><td><table border="0" cellpadding="0" cellspacing="0" style="max-width: 600px !important;width: 100%;padding: 0 20px"><tr><td>
                        <img src="{$logo_path}" style="margin: 0 auto; display: block; margin-top: 50px; max-width: 565px; width: 100%;" alt="logo">
</td></tr></table></td></tr >            
<tr ><td style="font-family: 'Tahoma';font-size: 50px;font-weight: 500;font-style: normal; text-transform: uppercase; text-align: center; padding-top: 88px; max-width: 434px; width: 100%;color: #000;">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_HI]} {$client[full_name]}
</td></tr>
<tr><td colspan="2" ><table border="0" cellpadding="0" cellspacing="0"  style="width: 100%;max-width: 600px;"><tr><div style="font-size: 27px; font-weight: 300; text-align: center; color: #000;line-height: 38px; margin: 0 auto;font-family: 'Tahoma'">
			{$GLOBALS[ar_define_langterms][MSG_LETTER_YOUR_PAYMENT_WAS_SUCCEFUL]}
</div></tr></table></td></tr><tr>
<td colspan="2"><div style="font-family: 'Tahoma';font-size: 50px;font-weight: 500;max-width: 211px;margin: 0 auto;text-align: center;padding: 24px 0;color: #44CE00; ">
            {$price_number} {$GLOBALS[ar_define_langterms][MSG_LETTER_EUR]}
</div></td></tr>
<tr><td colspan="2" style="font-size: 30px; font-weight: 500;color: #000;line-height: 38px; text-align: center; font-family: 'Tahoma'">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_YOUR_SUBSCRIPTION_PERIOD_IS_AVAILABLE_FROM_TO]} 
<span>
            {$day_start} {$month_start} {$year_start} - {$day_end} {$month_end} {$year_end}
</span></td></tr>
<tr><td colspan="2" style="font-size: 27px;color: #7B7B7B; font-weight: 500; text-align: center; padding-top: 87px;padding-bottom: 58px; font-family: 'Tahoma'">
        	{$GLOBALS[ar_define_langterms][MSG_LETTER_FOLLOW_US_ON_SOCIAL_MEDIA]}
</td></tr> 
<tr><td colspan="2" ><table border="0" cellpadding="0" cellspacing="0" style="max-width: 234px;width: 100%;margin: 0 auto;padding-bottom: 136px;">
<tr><td align="start" width="24" height="46"  ><a target="_blank" href="{$facebook_link}" style="display: inline-block; height: 100%;">
			<img src="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}/images/icons/facebook-activ.png" alt="" style="width: 100%;height: 100%;">
</a></td>                
<td align="middle" width="46" height="46"  ><a target="_blank" href="{$instagram_link}" style="display: inline-block; height: 100%;" >
            <img src="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}/images/icons/insta-activ.png" alt="" style="width: 100%;height: 100%;">
</a></td>
<td align="end" height="46" width="20"><a target="_blank" href="{$telegram_link}" style="display: inline-block; height: 100%;">
            <img src="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}/images/icons/telega-activ.png" alt="" style="width: 100%;height: 100%;">
</a></td></tr></table></td></tr>
<tr><td colspan="2" ><table  cellpadding="0" cellspacing="0" style="width: 100%;margin: 0 auto"><tr><td><a href="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}{$CCpu->writelink(1)}" style="text-decoration: none;font-size: 29px; font-weight: 300;color: #000;font-family: 'Tahoma'">
            {$_SERVER[SERVER_NAME]}
</a></td><td align="right" valign="bottom" style="font-size: 29px; font-weight: 300;color: #000;font-family: 'Tahoma'">                                    
            {$GLOBALS[ar_define_langterms][MSG_LETTER_ALL_RIGHTS_C_2023]}
</td></tr></table></td></tr></tbody></table></body></html>
HTML;
		
		
		
		include_once $_SERVER['DOCUMENT_ROOT'].'/lib/libmail/libmail.php';
    	$m= new Mail();
    	$m->From( $GLOBALS['ar_define_settings']['SMTP_MAIL'] );
    	$m->To( $client['email'] );
    	$m->Subject( $GLOBALS['ar_define_langterms']['MSG_LETTER_OPLATA_PROSHLA_USPESHNO'] );
    	$m->Body($Text, "html");
    	$m->Priority(4);
		
    	$m->smtp_on($GLOBALS['ar_define_settings']['SMTP_SERVER'], $GLOBALS['ar_define_settings']['SMTP_MAIL'], $GLOBALS['ar_define_settings']['SMTP_PASS'], $GLOBALS['ar_define_settings']['SMTP_PORT']);
    	$m->log_on(true);
    	$a = $m->Send();
		
		
		
		echo "ok";
	}else{
		echo "err";
		
		$insert_not = $Db->q("INSERT INTO `ws_notifications` (is_read,client_id,type,rang,created) 
														VALUES (0,".$Client->id.",'pay_error',2,NOW()) ");
		
	}
}

if($ar_clean['task'] == 'add_download'){
	$product_id = $ar_clean['product_id'];
	$client_id = $ar_clean['client_id'];
	$link = $ar_clean['link'];
	
	$today = date('Y-m-d');
	
	$active_client_subscribe = $Db->getone("SELECT * FROM `ws_abonament_client` WHERE client_id = ".$Client->id." AND ab_end >= NOW() AND is_paid = 1 ");
	$get_ab = $Db->getone("SELECT * FROM `ws_abonament` WHERE id = ".$active_client_subscribe['ab_id']);
	
	
	$down_limit = (int)$GLOBALS['ar_define_settings']['MAX_DOWNLOAD_PER_DAY'];
	$down_limit = (int)$get_ab['max'];
	$check_down_load = $Db->getall("SELECT * FROM `ws_client_downloads` WHERE client_id = ".$client_id." AND date_create LIKE '".$today."%' ");
	
	//print_r($down_limit);
	//print_r(count($check_down_load));
	
	if(count($check_down_load) < $down_limit){
		$insert_query = $Db->q("INSERT INTO `ws_client_downloads` (client_id,product_id,link,date_create) VALUES 
																(".$client_id.",".$product_id.",'".$link."',NOW()) ");
		
		if($insert_query){
			echo 'ok';
			
			$insert_not = $Db->q("INSERT INTO `ws_notifications` (is_read,client_id,type,rang,created) 
														VALUES (0,".$Client->id.",'download_success',1,NOW()) ");
			
			
		}else{
			echo $GLOBALS['ar_define_langterms']['MSG_MESSAGE_NE_UDALOSI_NACHATI_SKACHIVANIE'];
			
			$insert_not = $Db->q("INSERT INTO `ws_notifications` (is_read,client_id,type,rang,created) 
														VALUES (0,".$Client->id.",'download_error',2,NOW()) ");
		}
		
	}else{
		//echo $GLOBALS['ar_define_langterms']['MSG_MESSAGE_NA_SEGODNYA_PREVYSHEN_LIMIT_ZAGRUZOK'];
		
		$insert_not = $Db->q("INSERT INTO `ws_notifications` (is_read,client_id,type,rang,created) 
														VALUES (0,".$Client->id.",'download_limit',2,NOW()) ");
		
	}
	
}

if($ar_clean['task'] == 'send_msg'){
	$text = $ar_clean['text'];
	if($Client->auth){
		$client = $Db->getone("SELECT * FROM `ws_clients` WHERE id = ".$Client->id);
		$email = $client['email'];
		$client_id = $client['id'];
	}else{
		$email = '';
		$client_id = '0';
	}
	
	
	$query = $Db->q(" INSERT INTO `ws_msg` (active,email,message,date) VALUES (1,'".$email."','".$text."',NOW()) ");
	if($query){
		echo "ok";
		if($Client->auth){
			$insert_not = $Db->q("INSERT INTO `ws_notifications` (is_read,client_id,type,rang,created) 
														VALUES (0,".$Client->id.",'msg_success',1,NOW()) ");
		}
		
	}else{
		echo "err";
		
		if($Client->auth){
			$insert_not = $Db->q("INSERT INTO `ws_notifications` (is_read,client_id,type,rang,created) 
														VALUES (0,".$Client->id.",'msg_error',2,NOW()) ");
		}
		
	}
}


if($ar_clean['task'] == 'check_save'){
	//$try = setcookie("saved_pass", $value, time()+3600);  /* expire in 1 hour */	
}

if($ar_clean['task'] == 'send_request'){
	$name = $ar_clean['name'];
	$surname = $ar_clean['surname'];
	$email = $ar_clean['email'];
	$country = $ar_clean['country'];
	$text = $ar_clean['text'];
	
	$insert = $Db->q(" INSERT INTO `ws_messages` (active,country,name,surname,email,message,date) VALUES 
											(1,'".$country."','".$name."','".$surname."','".$email."','".$text."',NOW()) ");
	
	if($insert){
		echo 'ok';
		
		$logo_path = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/images/icons/logo.png';
		
		$soc = $Db->getall("SELECT * FROM `ws_soc` ORDER BY id ASC ");
		$facebook = $soc[0];
		$facebook_link = $facebook['link_'.$CCpu->lang];
		$instagram = $soc[1];
		$instagram_link = $instagram['link_'.$CCpu->lang];
		$telegram = $soc[2];
		$telegram_link = $telegram['link_'.$CCpu->lang];
		
		$Text = <<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" ></head><body><table border="0" cellpadding="0" cellspacing="0" style="max-width:600px !important;width: 100%;margin: 0 auto;" ><tbody>
<tr><td><table border="0" cellpadding="0" cellspacing="0" style="max-width: 600px !important;width: 100%;padding: 0 20px"><tr><td>
			<img src="{$logo_path}" style="margin: 0 auto; display: block; margin-top: 50px; max-width: 565px; width: 100%;" alt="logo">
</td></tr></table></td></tr >
<tr ><td style="font-family: 'Tahoma';font-size: 50px;font-weight: 500;font-style: normal; text-transform: uppercase; text-align: center; padding-top: 88px; max-width: 434px; width: 100%;color: #000;">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_NEW_REQUEST_TITLE]}
</td></tr>
<tr><td colspan="2" ><table border="0" cellpadding="0" cellspacing="0"  style="width: 100%;max-width: 600px;"><tr><div style="font-size: 30px; font-weight: 300; text-align: center; color: #000;line-height: 38px; margin: 0 auto;font-family: 'Tahoma'">
			{$GLOBALS[ar_define_langterms][MSG_LETTER_INFORMATION_ABOUT_REQUEST]}
</div></tr></table></td></tr>
<tr><td colspan="2" ><table border="0" cellpadding="0" cellspacing="0"  style="width: 100%;max-width: 600px; font-size: 30px; font-weight: 300; color: #000; line-height: 38px; margin: 0 auto;font-family: 'Tahoma'; margin-top: 35px; margin-bottom: 75px;">
<tr><td>
                    	{$GLOBALS[ar_define_langterms][MSG_LETTER_NAME]}
</td><td style="text-align: right">
                    	{$name}
</td></tr>
<tr><td>
                    	{$GLOBALS[ar_define_langterms][MSG_LETTER_SURNAME]}
</td><td style="text-align: right">
                    	{$surname}
</td></tr>
<tr><td>
                    	{$GLOBALS[ar_define_langterms][MSG_LETTER_EMAIL]}
</td><td style="text-align: right">
                    	{$email}
</td></tr>
<tr><td>
                    	{$GLOBALS[ar_define_langterms][MSG_LETTER_COUNTRY]}
</td><td style="text-align: right">
                    	{$country}
</td></tr>
<tr><td style="vertical-align: baseline;">
                    	{$GLOBALS[ar_define_langterms][MSG_LETTER_TEXT]}
</td><td style="text-align: right; width: 350px; font-size: 24px;">
                    	{$text} 
</td></tr></table></td></tr>
<tr><td colspan="2" ><table  cellpadding="0" cellspacing="0" style="width: 100%;padding: 80px 0;margin: 0 auto"><tr><td><a href="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}{$CCpu->writelink(1)}" style="text-decoration: none;font-size: 29px; font-weight: 300;color: #000;font-family: 'Tahoma'">
                {$_SERVER[SERVER_NAME]}
</a></td><td align="right" valign="bottom" style="font-size: 29px; font-weight: 300;color: #000;font-family: 'Tahoma'">        
				{$GLOBALS[ar_define_langterms][MSG_LETTER_ALL_RIGHTS_C_2023]}
</td></tr></table></td></tr></tbody></table></body></html>
HTML;
		
		
		
		
		
		
		
		
		
		
		//$Text = $Main->GetPageIncData('NEW_REQUEST' , $CCpu->lang);
		//$Text = str_replace('{name}', $name, $Text);
		//$Text = str_replace('{surname}', $surname, $Text);
		//$Text = str_replace('{email}', $email, $Text);
		//$Text = str_replace('{country}', $country, $Text);
		//$Text = str_replace('{text}', $text, $Text);
		
		include_once $_SERVER['DOCUMENT_ROOT'].'/lib/libmail/libmail.php';
    	$m= new Mail();
    	$m->From( $GLOBALS['ar_define_settings']['SMTP_MAIL'] );
    	$m->To( $GLOBALS['ar_define_settings']['ADMIN_EMAIL'] );
    	$m->Subject( $GLOBALS['ar_define_langterms']['MSG_LETTER_NEW_REQUEST'] );
    	$m->Body($Text, "html");
    	$m->Priority(4);
		
    	$m->smtp_on($GLOBALS['ar_define_settings']['SMTP_SERVER'], $GLOBALS['ar_define_settings']['SMTP_MAIL'], $GLOBALS['ar_define_settings']['SMTP_PASS'], $GLOBALS['ar_define_settings']['SMTP_PORT']);
    	$m->log_on(true);
    	
		$a = $m->Send();
		
		
	}else{
		echo 'err';
	}
	
}

if($ar_clean['task'] == 'get_header_notifications'){
	$client_id = $ar_clean['client_id'];
	if($client_id != 0){
		$notifications_for_header = $Db->getall("SELECT * FROM `ws_notifications` WHERE client_id = ".$client_id." AND is_read = 0 AND is_show = 0 ");
	}else{
		$notifications_for_header = $Db->getall("SELECT * FROM `ws_notifications` WHERE client_id = ".$client_id." AND is_read = 0 AND is_show = 0 AND session_id = '".$_SESSION['not_id']."' ");
	}
	
	foreach ($notifications_for_header as $key => $not) {
		$class_color = '';
		switch($not['rang']){
			case '0':
				$class_color = 'mod-grey';
				break;
			case '1':
				$class_color = '';
				break;
			case '2':
				$class_color = 'mod-red';
				break;
		}
		
		switch($not['type']){
			case 'msg_success':
				$text = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_YOUR_MESSAGE_WAS_SENT_SUCCEFULLY'];
				break;
			case 'msg_error':
				$text = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_MESSAGE_ERROR'];
				break;
			case 'pay_error':
				$text = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_PAYMENT_ERROR'];
				break;
			case 'pay_success':
				$text = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_YOUR_PAYMENT_IS_SUCCEFULLY'];
				break;
			case 'download_success':
				$text = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_DOWNLOAD_IN_PROGRESS'];
				break;
			case 'download_limit':
				$text = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_DOWNLOAD_LIMIT'];
				break;
			case 'just_text':
				$text = $not['not_text'];
				break;
		}
		
		?>
				<div class="not_modal <?=$class_color?>">
                    <span><?=$text?></span>
                    <button class="not_modal_close" onclick="setCloseNotMod(this,'<?=$not['id']?>')">
                        <img src="/images/icons/Close Icon.svg" alt="">
                    </button>
                </div>
		<?
	}
	
}
if($ar_clean['task'] == 'read_header_notifications'){
	$client_id = $ar_clean['client_id'];
	if($client_id != 0){
		$Db->q("UPDATE `ws_notifications` SET is_show = 1 WHERE client_id = ".$client_id." AND is_read = 0 AND is_show = 0 ");
	}else{
		$Db->q("UPDATE `ws_notifications` SET is_show = 1 WHERE client_id = ".$client_id." AND is_read = 0 AND is_show = 0 AND session_id = '".$_SESSION['not_id']."' ");
	}
}

if($ar_clean['task'] == 'show_notification'){
	$id = $ar_clean['id'];
	
	$update = $Db->q(" UPDATE `ws_notifications` SET is_show = 1 WHERE id = ".$id);
	
}

if($ar_clean['task'] == 'get_count_header_notifications'){
	$client_id = $ar_clean['client_id'];
	
	$notifications_for_header = $Db->getall("SELECT * FROM `ws_notifications` WHERE client_id = ".$client_id." AND is_read = 0 AND session_id = '' AND type != 'just_text' ");
	
	echo count($notifications_for_header);
	
}
if($ar_clean['task'] == 'read_notification'){
	$client_id = $ar_clean['client_id'];
	$update = $Db->q(" UPDATE `ws_notifications` SET is_read = 1 WHERE client_id = ".$client_id);
	
}

if($ar_clean['task'] == 'close_cookies'){
	$_SESSION['cookies'] = 'ok';
}

if($ar_clean['task'] == 'get_hash'){
	
	$password = $ar_clean['pass'];
	$pass = hash('sha512', trim($password));
    $pass = hash('sha512', $pass.$GLOBALS['security_salt']);
	
	echo $pass;
	
}

if($ar_clean['task'] == 'get_countries'){
	
	$search = $ar_clean['search'];
	if($search != ''){
		$countries = $Db->getall(" SELECT * FROM `ws_country` WHERE active = 1 AND title_".$CCpu->lang." LIKE '".$search."%' ORDER BY sort DESC ");
	}else{
		$countries = $Db->getall(" SELECT * FROM `ws_country` WHERE active = 1 ORDER BY sort DESC ");
	}
	
	?>
	<select name="type" id="country" class="register__select nice-select " onchange="select_country()">
		<option data-display="<?=$GLOBALS['ar_define_langterms']['MSG_REG_COUNTRY']?>"></option>
        <?
		foreach ($countries as $key => $country) {
			?>
		<option value="<?=$country['id']?>"><?=$country['title_'.$CCpu->lang]?></option>	
			<?
		}
        ?>
	</select>
	<?
	
}


if($ar_clean['task'] == 'get_countries_personal'){
	$search = $ar_clean['search'];
	if($search != ''){
		$countries = $Db->getall(" SELECT * FROM `ws_country` WHERE active = 1 AND title_".$CCpu->lang." LIKE '".$search."%' ORDER BY sort DESC ");
	}else{
		$countries = $Db->getall(" SELECT * FROM `ws_country` WHERE active = 1 ORDER BY sort DESC ");
	}
	?>
	<select id="country_id" class="nice-select select_country register__select" onchange="select_country()" >
                        		<?
								foreach ($countries as $key => $country) {
									?>
								<option <?if($country['id'] == $client_info['elem_id']){?> selected <?}?> value="<?=$country['id']?>" >
									<?=$country['title_'.$CCpu->lang]?>
								</option>
									<?
								}
                        		?>
	</select>
	<?
	
}

if($ar_clean['task'] == 'add_notification_text'){
	$text = $ar_clean['text'];
	
	$rang = 0; //1,2
	
	$session = '';
	if(!$Client->auth){
		$session = $_SESSION['not_id'];
	}
	
	$client_id = $ar_clean['client_id'];
	if($client_id != 0){
	    $session = '';
	}else{
	    $session = $ar_clean['session'];
	}
	
	
	
	
	switch ($text) {
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_VASH_ZAPROS_OSTAVLEN']:
			$rang = 1;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_SOOBSCHENIE_OSTAVLENO']:
			$rang = 1;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_DANNYE_UDALOSI_IZMENITI']:
			$rang = 1;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_ZAPROS_OSTAVITI_NE_UDALOSI']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_SOOBSCHENIE_NE_UDALOSI_OSTAVITI']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_V_BAZE_DANNYH_NET_POLIZOVATELYA_S_TAKIM_ELEKTRONNYM_ADRESOM']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_ETA_ELEKTRONNAYA_POCHTA_NE_PODTVERZHDENA']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_NEVERNYJ_PAROLI']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_PROIZOSHLA_OSHIBKA_POVTORITE_POPYTKU_POZZHE']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_NE_UDALOSI_SOZDATI_KLIENTA']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_ETOT_EMEJL_UZHE_ZAREGISTRIROVAN_V_BAZE_DANNYH']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_V_BAZE_DANNYH_NET_POLIZOVATELYA_S_TAKIM_ELEKTRONNYM_ADRESOM']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_NOVYJ_PAROLI_BYL_VYSLAN_NO_IZMENITI_EGO_NE_UDALOSI_POPROBUJTE_ESCHYO_RAZ']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_IZMENITI_PAROLI_NE_UDALOSI_NOVYJ_PAROLI_NE_BYL_VYSLAN']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_V_BAZE_DANNYH_NET_POLIZOVATELYA_S_TAKIM_ELEKTRONNYM_ADRESOM']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_VVEDITE_PRAVILINO_STARYJ_PAROLI']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_CHTOBY_IZMENITI_PAROLI_NUZHNO_PRAVILINO_VVESTI_STARYJ_PAROLI']:
			$rang = 2;
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_DANNYE_NE_UDALOSI_IZMENITI']:
			$rang = 2;
			break;
		default:
			$rang = 0;
			break;
	}
	
	$rang = 0;
	
	$insert_not = $Db->q("INSERT INTO `ws_notifications` (is_read,client_id,type,rang,session_id,not_text,created) 
												VALUES (0,".$client_id.",'just_text',".$rang.",'".$session."','".$text."',NOW()) ");
	
}

if($ar_clean['task'] == 'add_ext_notification_text'){
	
	$text = $ar_clean['text'];
	$rang = 2;
	
	
	$client_id = $ar_clean['client_id'];
	if($client_id != 0){
	    $session = '';
	}else{
	    $session = $ar_clean['session'];
	}
	
	
	$type = '';
	switch ($text) {
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_OPLATU_NE_UDALOSI_ZAVERSHITI']:
			$type = 'pay_error';
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_PROIZOSHLA_OSHIBKA_V_SISTEME_OPLATY']:
			$type = 'pay_error';
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_PODPISKU_NE_UDALOSI_OFORMITI']:
			$type = 'subscribe_error';
			break;
		case $GLOBALS['ar_define_langterms']['MSG_MESSAGE_OPLATU_PROIZVESTI_NE_UDALOSI']:
			$type = 'pay_error';
			break;
	}
	
	if($client_id != '0'){
		$insert_not = $Db->q("INSERT INTO `ws_notifications` (is_read,client_id,type,rang,session_id,not_text,created) 
												VALUES (0,".$client_id.",'".$type."',".$rang.",'','".$text."',NOW()) ");
	}
		
}

if($ar_clean['task'] == 'get_pay_prices'){
	
	$id = $ar_clean['id'];
	$price_client_id = $id;
	$client_info = $Db->getone("SELECT * FROM `ws_clients` WHERE id = ".$Client->id);
	
	include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/prices_block.php");
	
}

if($ar_clean['task'] == 'get_pay_prices_script'){
	
	$id = $ar_clean['id'];
	$price_client_id = $id;
	$client_info = $Db->getone("SELECT * FROM `ws_clients` WHERE id = ".$Client->id);
	
	include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/pay_script.php");
	
}






