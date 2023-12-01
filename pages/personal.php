<?
if(!$Client->auth){
	header('Location: '.$CCpu->writelink(1));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
		
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
	<?
	$months['ru'] = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
	$months['en'] = array('january','february','march','april','may','june','july','august','september','october','november','december');
	?>
	
    
    <div class="all__hr"></div>

    <section class="area">
        <div class="area__wrapper">
            <div class="area__img-wr">
                <div class="u">
                    <?
                    if($client_info['image'] != ''){
                		?>
                	<img src="/upload/userfiles/images/<?=$client_info['image']?>" alt="pic" class="area__title_img2" >	
                		<?
                	}else{
                		?>
                	<img src="/upload/userfiles/images/default.jpg" alt="pic" class="area__title_img2" >	
                		<?
                	}
                    ?>
                    <button class="z hidden">
                    	<label for="client_image">
                    		<img src="/images/icons/CompositeLayer.png" alt="">
                    	</label>
                    	<input type="file" hidden id="client_image" onchange="change_image()">
                    </button>
                </div>
            </div>
            <div class="area__name"><?=$client_info['full_name']?></div>
            <?
            $today = date('Y-m-d',time());
            $today_downloads = $Db->getall("SELECT `client_id`, `product_id`, `link`, DATE(`date_create`) as created 
                    							FROM `ws_client_downloads` WHERE client_id = ".$Client->id." AND date_create LIKE '".$today."%' ");
			
			$act_client_subscribe = $Db->getone("SELECT * FROM `ws_abonament_client` WHERE client_id = ".$Client->id." AND ab_end >= NOW() AND is_paid = 1 ");
			$get_ab = $Db->getone("SELECT * FROM `ws_abonament` WHERE id = ".$act_client_subscribe['ab_id']);
			$down_limit = (int)$get_ab['max'];
			
            ?>
            
            <div class="area__choice_wr">
                <button class="area__download" onclick="setChangeArea(this),setDownload(this)" ><span><?=count($today_downloads)?>/<?=$down_limit?></span><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_DOWNLOADS']?></button>
                <button class="area__notification" onclick="setChangeArea(this),setNot(this)" ><span class="count_not"></span><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_NOTIFICATIONS']?></button>
                <button class="area__subscription <?/* activ-colorgreen */?>" onclick="setChangeArea(this),setSub(this)" ><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_SUBSCRIPTIONS']?></button>
                <button class="area__sittings" onclick="setChangeArea(this),setS(this)" ><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_SETTINGS']?></button>
            </div>
        </div>
    </section>
    <div class="personal-min-height">
        <section class="download">
            <div class="download__wr">
                <div class="accordion accordion-download">
                    
                    <?
                    $downloads = $Db->getall("SELECT `client_id`, `product_id`, `link`, DATE(`date_create`) as created 
                    							FROM `ws_client_downloads` WHERE client_id = ".$Client->id."  GROUP BY created ORDER BY created DESC ");
					
					foreach ($downloads as $key => $down) {
						$day_downloads = $Db->getall("SELECT * FROM `ws_client_downloads` WHERE date_create LIKE '".$down['created']."%' ");
						$day_count = count($day_downloads);
						
						$day = date('d', strtotime($down['created']));
						$month = date('n', strtotime($down['created']));
						$month = $month-1;
						$month = $months[$CCpu->lang][$month];
						$year = date('Y', strtotime($down['created']));
						
						?>
					<div class="accordion__item download-elem">
                            <div class="accordion__title download_title">
                                <div class="title-wr title-wr-download">
                                    <span class="accordion__subtitle-text fw300"><?=$day?> <?=$month?> <?=$year?></span>
                                </div>
                                <div class="accordion__arrow download_arrow">
                                    <span class="accordion__arrow-item ">
                                        <img src="/images/icons/arrow-accordion.png" alt="">
                                    </span>
                                </div> 
                            </div>
                            
                            <div class="accordion__content accordion__content-download ">
                            <?
                            $c = $day_count;
                            foreach ($day_downloads as $key => $day_down) {
                            	$product = $Db->getone("SELECT * FROM `ws_categories_elements` WHERE id = ".$day_down['product_id']);
								
								?>
								<div class="accordion__item2">
                                    <div class="accordion__title2 download_title2">
                                        <div class="title-wr-download2">
                                            <span class="subtitle_number"><?=$c?>/<?=$down_limit?></span>
                                            <span class="download__title-text fwnorm"><?=$product['title_'.$CCpu->lang]?></span>
                                            <span>
                                            	<span class="download__subtitle-text"><?=$day?> <?=$month?> <?=$year?></span>
                                            	<span class="accordion__arrow-item ">
                                                	<img src="/images/icons/arrow-accordion.png" alt="">
                                            	</span>
                                            </span>
                                        </div>
                                    </div>
                                    <?
                                    if($client_subscribe == array()){
                                    	?>
                                    	<div class="accordion__content3 download-content-red">
                                            <div class="download_btn-wr ">
                                            	<img src="/images/icons/download-red.png" alt="" onclick="show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_NELIZYA_SKACHIVATI_ZAGRUZKI_IZ_ISTORII_ESLI_SROK_VASHEJ_PODPISKI_ISTYOK']?>');" >
                                        		<button class="click_down-btn click_down-red" onclick="show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_NELIZYA_SKACHIVATI_ZAGRUZKI_IZ_ISTORII_ESLI_SROK_VASHEJ_PODPISKI_ISTYOK']?>');" ><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_CLICK_TO_DOWNLOAD']?></button>
                                            </div>
                                        </div>
                                    	<?
                                    }else{
                                    	?>
                                    	<div class="accordion__content3 download-content-green">
                                            <div class="download_btn-wr">
                                            	<img src="/images/icons/download.svg" alt="" onclick="download_history('<?=$day_down['id']?>','<?=$day_down['link']?>','<?=$product['title_'.$CCpu->lang]?>')" >
                                        		<button class="click_down-btn" onclick="download_history('<?=$day_down['id']?>','<?=$day_down['link']?>','<?=$product['title_'.$CCpu->lang]?>')"><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_CLICK_TO_DOWNLOAD']?></button>
                                            </div>
                                        </div>
                                    	<?
                                    }
                                    ?>
                            	</div>
								<?
								$c--;
							}
                            ?>
                            </div>
                    </div>	
						<?
					}
					
                    ?>
                </div>
            </div>
        </section>

        <section class="notification">
            <div class="notification_wr">
                <div class="accordion">
                	<?
                	$notifications = $Db->getall("SELECT * FROM `ws_notifications` WHERE client_id = ".$Client->id." ORDER BY created DESC ");
					foreach ($notifications as $key => $not) {
						if($not['type'] == 'just_text'){
							continue;
						}
						
						switch($not['type']){
							case 'msg_success':
								$title = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_YOUR_MESSAGE_WAS_SENT_SUCCEFULLY'];
								break;
							case 'msg_error':
								$title = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_MESSAGE_ERROR'];
								break;
							case 'pay_error':
								$title = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_PAYMENT_ERROR'];
								break;
							case 'pay_success':
								$title = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_YOUR_PAYMENT_IS_SUCCEFULLY'];
								break;
							case 'download_success':
								$title = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_DOWNLOAD_IN_PROGRESS'];
								break;
							case 'download_limit':
								$title = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_DOWNLOAD_LIMIT'];
								break;
							case 'download_error':
								$title = $GLOBALS['ar_define_langterms']['MSG_MESSAGE_NE_UDALOSI_NACHATI_SKACHIVANIE'];
								break;
							case 'subscribe_error':
								$title = $GLOBALS['ar_define_langterms']['MSG_MESSAGE_PODPISKU_NE_UDALOSI_OFORMITI'];
								break;
						}
						
						switch($not['type']){
							case 'msg_success':
								$text = $Main->GetPageIncData('NOT_MSG_SUCCESS' , $CCpu->lang);
								break;
							case 'msg_error':
								$text = $Main->GetPageIncData('NOT_MSG_ERROR' , $CCpu->lang);
								break;
							case 'pay_error':
								$text = $Main->GetPageIncData('NOT_PAY_ERROR' , $CCpu->lang);
								break;
							case 'pay_success':
								$text = $Main->GetPageIncData('NOT_PAY_SUCCESS' , $CCpu->lang);
								break;
							case 'download_success':
								$text = $Main->GetPageIncData('NOT_DOWNLOAD_SUCCESS' , $CCpu->lang);
								break;
							case 'download_limit':
								$text = $Main->GetPageIncData('NOT_DOWNLOAD_LIMIT' , $CCpu->lang);
								break;
							case 'download_error':
								$text = $Main->GetPageIncData('DOWNLOAD_ERROR' , $CCpu->lang);
								break;
							case 'subscribe_error':
								$text = $Main->GetPageIncData('SUBSCRIBE_ERROR' , $CCpu->lang);
								break;
						}
						
						
						
						$not_day = date('d',strtotime($not['created']));
						$not_month = date('n', strtotime($not['created']));
						$not_month = $not_month-1;
						$not_month = $months[$CCpu->lang][$not_month];
						$not_year = date('Y',strtotime($not['created']));
						?>
					<div class="accordion__item">
                        <div class="accordion__title">
                            <div class="accordion__arrow">
                                <span class="accordion__arrow-item ">
                                    <img src="/images/icons/arrow-accordion.png" alt="">
                                </span>
                            </div> 
                                <div class="title-wr">
                                    <span class="accordion__title-text"><?=$not_day?> <?=$not_month?> <?=$not_year?></span>
                                    <span class="accordion__subtitle-text"><?=$title?></span>
                                </div>
                    	</div>
                        <div class="accordion__content">
                        	<?=$text?>
                        </div>
                    </div>	
						<?
					}
					//$read_not = $Db->q("UPDATE `ws_notifications` SET is_read = 1 WHERE is_read = 0 AND client_id = ".$Client->id);
                	?>
                </div>
            </div>
        </section>
       
        <section class="subscription subset <?/* settings-act */?>">
            <div class="subscription__wrapper">
            	<?
            	$client_subscribe = $Db->getone("SELECT * FROM `ws_abonament_client` WHERE client_id = ".$Client->id." AND is_paid = 1 ");
				if($client_subscribe == array()){
					?>
				<div class="subscription__title subset_title">
                    <?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_GET_A_SUBSCRIPTION_NOW_AND_START_DOWNLOAD']?> 
                </div>
                <div class="subscription__descr subset_descr">
                    <?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_THOUSANDS_OF_JEWELRY_PRINTABLE_3D_MODELS_']?> 
                </div>
                <div class="subscription__choice subset_choice">
                    <?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_SELECT_YOUR_PLAN_AND_START_DOWNLOAD_YOUR_3D_MODELS']?>
                </div>
                <a href="<?=$CCpu->writelink(79)?>" class="subscription__link">
                    <?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_GET_A_PLAN']?>
                </a>
					<?
				}else{
					$months['ru'] = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
					$months['en'] = array('January','February','March','April','May','June','July','August','September','October','November','December');
					
					$active_client_subscribe = $Db->getone("SELECT * FROM `ws_abonament_client` WHERE client_id = ".$Client->id." AND ab_end >= NOW() AND is_paid = 1 ");
					
				if($active_client_subscribe == array()){
					$day_start = date('d', strtotime($client_subscribe['ab_start']));
					$day_end = date('d', strtotime($client_subscribe['ab_end']));
					
					$month_start = date('n', strtotime($client_subscribe['ab_start']));
					$month_start = $month_start-1;
					$month_start = $months[$CCpu->lang][$month_start];
					$month_end = date('n', strtotime($client_subscribe['ab_end']));
					$month_end = $month_end-1;
					$month_end = $months[$CCpu->lang][$month_end];
					
					$year_start = date('Y', strtotime($client_subscribe['ab_start']));
					$year_end = date('Y', strtotime($client_subscribe['ab_end']));
					?>
				<div class="subset__wr-expired">
                    <img src="/images/icons/expired.png" alt="" class="subset__wr-active-img">
                	<div class="subset_active-title"><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_EXPIRED']?></div>
                	<div class="subset_active-period">
                    	<div class="subset_active-period-start"><?=$day_start?> <?=$month_start?> <?=$year_start?></div>
                    	<span></span>
                    	<div class="subset_active-period-end"><?=$day_end?> <?=$month_end?> <?=$year_end?></div>
                	</div>
                	<div class="subset_expired-title"><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_EXTEND_YOUR_SUBSCRIPTION']?></div>
                	<a href="<?=$CCpu->writelink(79)?>" class="subscription__link">
                    	<?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_GET_A_PLAN']?>
                	</a>    
            	</div>	
					<?
				}else{
					$day_start = date('d', strtotime($active_client_subscribe['ab_start']));
					$day_end = date('d', strtotime($active_client_subscribe['ab_end']));
					
					$month_start = date('n', strtotime($active_client_subscribe['ab_start']));
					$month_start = $month_start-1;
					$month_start = $months[$CCpu->lang][$month_start];
					$month_end = date('n', strtotime($active_client_subscribe['ab_end']));
					$month_end = $month_end-1;
					$month_end = $months[$CCpu->lang][$month_end];
					
					$year_start = date('Y', strtotime($active_client_subscribe['ab_start']));
					$year_end = date('Y', strtotime($active_client_subscribe['ab_end']));
					?>
				<div class="subset__wr-active" >
                    <img src="/images/icons/correct.png" alt="" class="subset__wr-active-img">
                	<div class="subset_active-title"><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_ACTIVE']?></div>
                	<div class="subset_active-period">
                    	<div class="subset_active-period-start"><?=$day_start?> <?=$month_start?> <?=$year_start?></div>
                    	<span></span>
                    	<div class="subset_active-period-end"><?=$day_end?> <?=$month_end?> <?=$year_end?></div>
                	</div>
                </div>	
					<?
				}
					
				}
            	?>
            </div>
        </section>
    
        <section class="settings" >
            <div class="settings__wr">
                <div class="settings__title" onclick="start_edit()" ><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_EDIT']?></div>
                <div class="settings__content_wr">
                    <div class="settings__content_name">
                        <div class="settings__content_descr"><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_FULL_NAME']?></div>
                        <div class="settings__content_data">
                        	<input id="full_name" value="<?=$client_info['full_name']?>" readonly />
                        </div>
                    </div>
                    <div class="settings__content_contry">
                        <div class="settings__content_descr"><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_COUNTRY']?></div>
                        <div class="settings__content_data personal_select">
                        	<?/* <input value="Republic of Moldova"> */?>
                        	<?
                        	$country = $Db->getone("SELECT * FROM `ws_country` WHERE id = ".$client_info['elem_id']);
                        	?>
                        	<input autocomplete="off" id="country_search" data-old="<?=$country['title_en']?>" value="<?=$country['title_en']?>" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_REG_COUNTRY']?>" readonly >
                        	<div class="country_select_block">
                        		<select id="country_id" class="nice-select select_country register__select" disabled  onchange="select_country()" >
                        		<?
                        		$countries = $Db->getall("SELECT * FROM `ws_country` WHERE active = 1 AND title_$CCpu->lang LIKE '".$country['title_en']."%' ORDER BY sort DESC ");
								foreach ($countries as $key => $country) {
									?>
								<option <?if($country['id'] == $client_info['elem_id']){?> selected <?}?> value="<?=$country['id']?>" >
									<?=$country['title_'.$CCpu->lang]?>
								</option>
									<?
								}
                        		?>
                        		</select>
                        	</div>
                        </div>
                    </div>
                    <form onsubmit="return false;">
                    	<div class="settings__content__mail">
                        	<div class="settings__content_descr"><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_EMAIL']?></div>
                        	<div class="settings__content_data">
                        		<input id="email" value="<?=$client_info['email']?>" readonly >
                        	</div>
                    	</div>
                    	<?/* <div class="settings__content_oldpas">
                        <div class="settings__content_descr"><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_OLD_PASSWORD']?></div>
                        <div class="settings__content_data">
                        	<input id="old_password" type="password" value="************" readonly >
                        </div>
                    	</div> */?>
                    	<div class="settings__content_newpas">
                        	<div class="settings__content_descr"><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_NEW_PASSWORD']?></div>
                        	<div class="settings__content_data">
                        		<input id="password" type="password" value="************" readonly >
                        	</div>
                    	</div>
                    	<div class="settings__content_pas">
                        	<div class="settings__content_descr"><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_REPEAT_NEW_PASSWORD']?></div>
                        	<div class="settings__content_data">
                        		<input id="re_password" type="password" value="************" readonly >
                        	</div>
                    	</div>
                    </form>
                    
                </div>  

                <button class="btn_setting_hide settings__content_btn" onclick="save_changes()"><?=$GLOBALS['ar_define_langterms']['MSG_PERSONAL_SAVE_CHANGES']?></button>
            </div>
        </section>
    </div>
    
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
    
    
    <input id="old_pass" value="<?=$client_info['password']?>" hidden >
    
    <script>
    	
    	
    	$('.settings__content_contry #country_search').on('focus',function(){
    		if(!$(this).prop('readonly')){
    			<?/*
    			$('.settings__content_contry #country_search').val('');
    			$.ajax({
    				type: 'POST',
    				url: '<?=$CCpu->writelink(3)?>',
    				data: 'task=get_countries_personal&search=',
    				success: function(msg){
    					$('.settings__content_contry .country_select_block').html(msg);
    					return_scrollbar();
    					select_open();
    				}
    			})
    			*/?>
    		}
    	})
    	$('.settings__content_contry #country_search').keyup(function(e){
    		var v = $(this).val();
    		var letters = ['Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M','(',')',' ',
    						'q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m','Backspace','Delete'];
    		
    		if( $.inArray(e.key,letters) != -1 ){
    			$.ajax({
    				type: 'POST',
    				url: '<?=$CCpu->writelink(3)?>',
    				data: 'task=get_countries_personal&search='+v,
    				success: function(msg){
    					$('.settings__content_contry .country_select_block').html(msg);
    					return_scrollbar();
    					select_open();
    				}
    			})
    		}else{
    			switch(e.key){
    				case 'ArrowRight':
    					select_option_country('next');
    					break;
    				case 'ArrowLeft':
    					select_option_country('prev');
    					break;
    				case 'ArrowUp':
    					select_option_country('prev');
    					break;
    				case 'ArrowDown':
    					select_option_country('next');
    					break;
    				case 'Enter':
    					select_arrow_country();
    					break;
    			}
    		}
    		
    	})
    	
    	
    	function select_arrow_country(){
    		if( $('.country_select_block .option').hasClass('arrow_selected') ){
    			var id = $('.arrow_selected').data('value');
    			var country = $('.arrow_selected').text();
    			country = $.trim(country);
    			console.log($('.arrow_selected'));
    			console.log(country);
    			
    			//$('.settings__content_contry #country_search').val('');
    			//$('.settings__content_contry #country_search').val(country);
    			$('#country_id').val(id);
    			
    			$('.selected').removeClass('selected');
    			$('.arrow_selected').addClass('selected');
    			
    			select_country();
    		}
    	}
    	
    	function select_option_country(type){
    		var check_selected = false;
    		var count = $('.country_select_block .option').length;
    		count = count-1;
    		$('.country_select_block .option').each(function(key, value){
    			if(key == 0){
    				$(value).addClass('firsth');
    			}
    			if(key == count){
    				$(value).addClass('last');
    			}
    			if( $(value).data('value') != '' ){
    				$(value).addClass('has_value');
    			}
    			if( $(value).hasClass('arrow_selected') ){
    				check_selected = true;
    			}
    		})
    		
    		
    		$(".nice-select .list").mCustomScrollbar('destroy');
    		$(".nice-select .list").addClass('no_scroll');
    		
    		if(!check_selected){
    			$('.has_value').first().addClass('arrow_selected');
    		}else{
    			var old = $('.arrow_selected');
    			if(type == 'prev'){
    				if(!old.hasClass('firsth')){
    					old.prev().addClass('arrow_selected');
    					old.removeClass('arrow_selected');
    				}
    			}
    			if(type == 'next'){
    				if(!old.hasClass('last')){
    					old.next().addClass('arrow_selected');
    					old.removeClass('arrow_selected');
    				}
    			}
    			var list = $('.country_select_block .list');
    			var option = document.querySelector('.arrow_selected');
    			option.scrollIntoView(true);
    		}
    	}
    	
    	
    	
    	
    	
    	function select_open(){
    		$('.settings__content_contry .register__select').addClass('hard_open');
    		$('.settings__content_contry .register__select').addClass('open');
    	}
    	function select_close(){
    		$('.settings__content_contry .register__select').removeClass('hard_open');
            $('.settings__content_contry .register__select').removeClass('open');
    	}
    	
    	$(document).on('click',function(e) {
        	if (!$('.register__select').is(e.target) && $('.register__select').has(e.target).length === 0 
        		&& !$('.settings__content_contry #country_search').is(e.target) && $('.settings__content_contry #country_search').has(e.target).length === 0 ) {
            	select_close();
        	}
        	if($('.register__select.hard_open').is(e.target)){
        		select_close();
        	}
		})
    	
    	function select_country(){
    		select_close();
    		//var v = $(this).val();
    		var v = $('.register__select.nice-select').find('.option.selected').text();
    		v = $.trim(v);
    		
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=get_countries_personal&search='+v,
    			success: function(msg){
    				$('.settings__content_contry .country_select_block').html(msg);
    				return_scrollbar();
    			}
    		})
    		
    		$('.settings__content_contry #country_search').val(v);
    	}
    	
    	
        
    	
    </script>
    
    
    <script>
    	$(function() {
	
	$(".accordion__title").on("click", function(e) {
		e.preventDefault();
		var $this = $(this);
		if (!$this.hasClass("accordion-active")) {
			$(".accordion__content").slideUp(400);
			$(".accordion__title").removeClass("accordion-active");
			$('.accordion__arrow').removeClass('accordion__rotate');
		}
		$this.toggleClass("accordion-active");
		$this.next().slideToggle();
		$('.accordion__arrow',this).toggleClass('accordion__rotate');
	});
		});
    	
    	
    	
    	function download_history(id,link,title){
    		var a = document.createElement('a');
    		a.href = link;
            a.id = 'download_link_'+id;
            a.download = title;
            a.style.display = 'none';
            
            
            $('.download').append(a);
            $('#download_link_'+id)[0].click();
            $('#download_link_'+id).remove();
    	}
    	
    	$('#full_name').keyup(function(){
    		var numbers_symbols = ['0','1','2','3','4','5','6','7','8','9','!','@','#','$','%','^','&','*','(',')',
    							'{','}','[',']','`','~','+','=','_','"',"'",'\\','|','/',';',':','.',',','?','<','>']; 
    		
    		var v = $(this).val();
    		$.each(numbers_symbols,function(k,s){
    			v = v.replace(s,'');
    		});
    		$(this).val(v);
    		
    	})
    	
    	function return_scrollbar(){
    		
    		$('.settings__content_contry .nice-select').niceSelect();
    				$(".settings__content_contry .list").mCustomScrollbar({
                		axis:"y",
                		advanced:{autoExpandHorizontalScroll:true}, 
                		callbacks:{
                    		onOverflowY:function(){
                    			var opt=$(this).data("mCS").opt;
                    			if(opt.mouseWheel.axis!=="y") opt.mouseWheel.axis="y";
                    		},
                		}
            });
    		
    	}
    	
    	function start_edit(){
    		
    		if( $('.settings__title').hasClass('disabled') ){
    			return false;
    		}
    		
    		$('#full_name').prop('readonly',false);
    		$('#full_name').css('border','solid thin #CECECE');
    		
    		$('.settings__content_contry #country_search').prop('readonly',false);
    		$('.settings__content_contry #country_search').css('border','solid thin #CECECE');
    		
    		$('#country_id').prop('disabled',false);
    		$('.select_country').removeClass('disabled');
    		$('.select_country').addClass('actived');
    		$('.select_country').parent().css('width','215px');
    		
    		$('#email').parent().parent().find('.settings__content_descr').css('color','#CECECE');
    		
    		$('#old_password').prop('readonly',false);
    		$('#old_password').css('border','solid thin #CECECE');
    		$('#old_password').val('');
    		$('#old_password').parent().parent().find('.settings__content_descr').css('color','#000');
    		
    		$('#password').prop('readonly',false);
    		$('#password').css('border','solid thin #CECECE');
    		$('#password').val('');
    		$('#password').parent().parent().find('.settings__content_descr').css('color','#000');
    		
    		$('#re_password').prop('readonly',false);
    		$('#re_password').css('border','solid thin #CECECE');
    		$('#re_password').val('');
    		
    		$('.settings__content_btn').removeClass('btn_setting_hide');
    		$('.settings__title').addClass('disabled');
    		
    		$('.z').removeClass('hidden');
    		$('.z img').css('display','block');
    	}
    	
    	function finish_edit(){
    		$('#full_name').prop('readonly',true);
    		$('#full_name').css('border','');
    		
    		$('.settings__content_contry #country_search').prop('readonly',true);
    		$('.settings__content_contry #country_search').css('border','');
    		//var country = $('.settings__content_contry #country_search').data('old');
    		//$('.settings__content_contry #country_search').val(country);
    		
    		$('#country_id').prop('disabled',true);
    		$('.select_country').addClass('disabled');
    		$('.select_country').removeClass('actived');
    		$('.select_country').parent().css('width','');
    		
    		$('#email').parent().parent().find('.settings__content_descr').css('color','');
    		
    		$('#old_password').prop('readonly',true);
    		$('#old_password').css('border','');
    		$('#old_password').val('************');
    		$('#old_password').parent().parent().find('.settings__content_descr').css('color','');
    		
    		$('#password').prop('readonly',true);
    		$('#password').css('border','');
    		$('#password').val('************');
    		$('#password').parent().parent().find('.settings__content_descr').css('color','');
    		
    		$('#re_password').prop('readonly',true);
    		$('#re_password').css('border','');
    		$('#re_password').val('************');
    		
    		$('.settings__content_btn').addClass('btn_setting_hide');
    		$('.settings__title').removeClass('disabled');
    		
    		$('.z').addClass('hidden');
    		$('.z img').css('display','');
    	}
    	
    	function save_changes(){
    		var name = $('#full_name').val();
    		var country_id = $('#country_id').val();
    		var email = $('#email').val();
    		var password = $('#password').val();
    		var re_password = $('#re_password').val();
    		var old_password = $('#old_password').val();
    		var err = 0;
    		
    		var old_pass_hash = '';
    		$.ajax({
    			type: 'POST',
    			async: false,
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=get_hash&pass='+old_password,
    			success: function(msg){
    				old_pass_hash = $.trim(msg);
    			}
    		})
    		
    		
    		var true_old_pass = $('#old_pass').val();
    		
    		if(old_password != ''){
    			if(old_pass_hash != true_old_pass){
    				//err = 1;
    				<?/* show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_VVEDITE_PRAVILINO_STARYJ_PAROLI']?>'); */?>
    			}
    		}else{
    			if(password != ''){
    				//err = 1;
    				<?/* show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_CHTOBY_IZMENITI_PAROLI_NUZHNO_PRAVILINO_VVESTI_STARYJ_PAROLI']?>'); */?>
    			}
    		}
    		
    		
    		if(name == ''){
    			err = 1;
    			show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_IMYA_NE_DOLZHNO_BYTI_PUSTYM']?>');
    		}
    		if(password != ''){
    			if(password != re_password){
    				show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_NOVYE_PAROLI_DOLZHNY_SOVPADATI']?>');
    				err = 1;
    			}
    		}
    		
    		
    		if(err == 0){
    			$.ajax({
    				type: 'POST',
    				url: '<?=$CCpu->writelink(3)?>',
    				data: 'task=edit_personal&name='+name+'&country_id='+country_id+'&password='+password+'&id=<?=$Client->id?>',
    				success: function(msg){
    					//console.log(msg);
    					if($.trim(msg) == 'ok'){
    						show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_DANNYE_UDALOSI_IZMENITI']?>');
    						$('#password').val('');
    						$('#re_password').val('');
    						finish_edit();
    					}else{
    						show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_DANNYE_NE_UDALOSI_IZMENITI']?>');
    					}
    				}
    			})
    		}
    	}
    	
    	$(document).ready(function(){
    		
    		<?
    		if(isset($_GET['section'])){
    			if($_GET['section'] == 'download'){
    				?>
    			setChangeArea($('.area__download'));
    			setDownload($('.area__download'));
    				<?
    			}
				if($_GET['section'] == 'settings'){
    				?>
    			setChangeArea($('.area__sittings'));
    			setS($('.area__sittings'));
    				<?
    			}
				if($_GET['section'] == 'subscription'){
    				?>
    			setChangeArea($('.area__subscription'));
    			setSub($('.area__subscription'));
    				<?
    			}
				if($_GET['section'] == 'notifications'){
					?>
				setChangeArea($('.area__notification'));
				setNot($('.area__notification'));
					<?
				}
    			?>
    		history.pushState(null, '', '<?=$_SERVER['REQUEST_URI']?>');
    			<?
    		}
    		?>
    	})
    	
    	function change_image(){
    		var file = $('#client_image')[0].files[0];
    		console.log($('#client_image')[0].files[0]);
    		
    		var form = new FormData();
    		console.log(form);
    		form.append('task','change_client_image');
    		form.append('file',file);
    		form.append('client_id','<?=$Client->id?>');
    		
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			processData:false,
				contentType:false,
    			data: form,
    			success: function(msg){
    				//console.log(msg);
    				location.reload();
    			}
    		})
    		
    	}
        
        
        
        
        function setDownload(){
            $('.settings').removeClass('settings-act');
            $('.subscription').removeClass('settings-act');
            $('.notification').removeClass('settings-act');
            $('.download').addClass('settings-act');
        }


        function setNot(){
            $('.settings').removeClass('settings-act');
            $('.subscription').removeClass('settings-act');
            $('.download').removeClass('settings-act');
            $('.notification').addClass('settings-act');
            
            //console.log('notifications?');
            $.ajax({
            	type: 'POST',
            	url: '<?=$CCpu->writelink(3)?>',
            	data: 'task=read_notification&client_id=<?=$Client->id?>',
            	success: function(msg){
            		check_notifications();
            	}
            })
        }
        function setSub(){
            $('.settings').removeClass('settings-act');
            $('.notification').removeClass('settings-act');
            $('.download').removeClass('settings-act');
            $('.subscription').addClass('settings-act');
        }
        
        function setS(){
            $('.subscription').removeClass('settings-act');
            $('.notification').removeClass('settings-act');
            $('.download').removeClass('settings-act');
            $('.settings').addClass('settings-act');
        }
        


        function setChangeArea(btn){
            $('.area__choice_wr').children().removeClass('activ-colorgreen');
            $(btn).addClass('activ-colorgreen');
        }
        
        
        
        
        
    </script>
</body>