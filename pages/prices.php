<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
		
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
	
    <section class="promo">
        <div class="promo__wrapper">
        	<?
        	$video_price = $Db->getone("SELECT * FROM `ws_video` WHERE id = 5");
        	?>
        	<style>
			.video_desc.video_5 {
				display: block;
			}
			.video_mob.video_5 {
				display: none;
			}
			@media(max-width: <?=$video_price['mob_size']?>px){
				.video_desc.video_5 {
					display: none;
				}
				.video_mob.video_5 {
					display: block;
				}
			}
			</style>
            <video class="video-homepage video_desc video_5" loop autoplay muted preload playsinline>
            	<source src="/upload/video/<?=$video_price['video']?>" type="video/mp4"></source>
            </video>
            <video class="video-homepage video_mob video_5" loop autoplay muted preload playsinline>
            	<source src="/upload/video/<?=$video_price['mob_video']?>" type="video/mp4"></source>
            </video>
        </div>
    </section>

    <section class="plans">
        <div class="plans__wrapper">
            <div class="plans__wr">
                <div class="plans__title"><?=$GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_WINTER_3D_JEWELRY_MODELS_COLLECTION']?></div>
            <div class="plans__descr">
            	<a name="prices"></a>
            	<span><?=$GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_CAPTURE_THE_MAGIC_OF_WINTER_WITH_OUR_EXQUISITE_WINTER_JEWELRY_COLLECTION']?></span> 
            	<?=$GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_CREATE_YOUR_OWN_WINTER-INSPIRED_JEWELRY_WITH_OUR_WINTER_JEWELRY_3D_PRINTABLE_MODELS']?>
            </div>
            <div class="plans_mobile_desc">
            	<?=$GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_SELECT_YOUR_PLAN_AND_START_DOWNLOAD']?>
            </div>
            </div>

            <div class="col-sm-12">
                <div class="container plans__choice_wr">
                    <div class="space-row-5 chc prices_flex_list">
                    	
                    	<?
                    	if($Client->auth){
                    		$client_subscribe = $Db->getone("SELECT * FROM `ws_abonament_client` WHERE client_id = ".$Client->id." AND ab_end >= NOW() AND is_paid = 1 ");
                    	}else{
                    		$client_subscribe = array();
                    	}
                    	
                    	$prices = $Db->getall("SELECT * FROM `ws_abonament` WHERE active = 1");
                    	foreach ($prices as $key => $price) {
                    		$price_lines = $Db->getall("SELECT * FROM `ws_abonament_line` WHERE ab_id = ".$price['id']);
							$date_start = $price['from_date'];
							$date_end = $price['to_date'];
							?>
							<input id="from_date" value="<?=$date_start?>" hidden >
							<input id="to_date" value="<?=$date_end?>" hidden >
							<input id="days_<?=$price['id']?>" value="<?=$price['days']?>" hidden >
							<div class="col-lg-4 plans__choice_block month">
                                <a class="plan__choice_link">
                                    <div class="plan__choice_head">
                                        <div class="plans__choice_title">
                                        	<?=$price['title_'.$CCpu->lang]?>
                                        	<?
                                        	if($price['little_title_'.$CCpu->lang] != ''){
                                        		?>
                                        	<div class="plans__little_title">
                                        		<?=$price['little_title_'.$CCpu->lang]?>
                                        	</div>	
                                        		<?
                                        	}
                                        	?>
                                        </div>
                                    </div>
                                    <div class="subscribe_flex">
                                    	<div>
                                    		<div class="plans__choice_price"><?=$price['price']?> <?=$GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_EUR']?></div>
                                    		<div class="plans__choice_subprice"><?=$price['text_'.$CCpu->lang]?></div>
                                    		<div class="plans__choice_hr"></div>
            
                                    		<ul class="plans__choice_func">
                                    		<?
                                    		foreach ($price_lines as $key => $line) {
												?>
												<li class="plans__choice_li"><?=$line['title_'.$CCpu->lang]?></li>	
												<?
											}
                                    		?>
                                    		</ul>
                                    	</div>
                                    	
                                    
                                    	<div class="plans__choice_btn_block">
                                    		<?
                                    		if($client_subscribe == array()){
                                    			?>
                                    		<button onclick="subscribe('<?=$price['id']?>')" class="plans__choice_btn"><?=$GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_SUBSCRIBE_NOW']?></button>	
                                    			<?
                                    		}
                                    		?>
                                    	</div>
                                    </div>
                                    
                                    
                                </a>
                            </div>
							<?
						}
                    	?>
                            
                    </div>
                </div>
            </div>

            <div class="pay-gray" <?if($Client->auth){?> style="margin-bottom: 9rem;" <?}?>>
                <div class="pay-gray_wr">
                    <div class="pay-gray_descr"><?=$GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_CONTENT_MAKE_YOUR_PAYMENT_AICI_CEVA_IN_ENGLEZA_REFERITOR_LA_TRANSFER_DSSDUDUHUSHSUDHIUFH']?></div>
                    </div>
                    <div class="pay-gray-logowr">
                        <div class="pay-gray-item">
                            <img src="/images/other/pay-grey/visa.svg" alt="">
                        </div>
                        <div class="pay-gray-item">
                            <img src="/images/other/pay-grey/master.svg" alt="">
                        </div>
                        <div class="pay-gray-item">
                            <img src="/images/other/pay-grey/american.svg" alt="">
                        </div>
                        <div class="pay-gray-item">
                            <img src="/images/other/pay-grey/paypal-logo.svg" alt="">
                        </div>
                    </div>
            </div>
            <?
            if(!$Client->auth){
            	?>
            <div class="plans__registr wrapper_hr">
            	<div class="mobile_wrapper_header_line">
            	</div>
                <div class="plans__registr_text">
                    <?=$GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_DONT_HAVE_AN_ACCOUNT__SIGN_UP_NOW_FOR_FREE']?>
                </div>
                <a onclick="open_modal('reg_space')" class="plans__link_create"><?=$GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_CREATE_ACCOUNT']?></a>
            </div>	
            	<?
            }
            ?>
        </div>

        
    </section>
    
    
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
    <section class="method modal_method">
    </section>
    
    
    <script>
    	
    	function open_modal_prices(id){
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=get_pay_prices&id='+id,
    			success: function(msg){
    				unscroll_body();
    				$('.modal_method').html(msg);
    				$('.modal_method').addClass('modal_method_active');
    				$('.modal_method').css('display','flex');
    				
    				$.ajax({
    					type: 'POST',
    					url: '<?=$CCpu->writelink(3)?>',
    					data: 'task=get_pay_prices_script&id='+id,
    					success: function(msg){
    						$('.modal_method').append(msg);
    					}
    				})
    				
    			}
    		})
    	}
    	
    	function close_modal_prices(){
    		rescroll_body();
    		$('.modal_method').html('');
    		$('.modal_method').removeClass('modal_method_active');
    		$('.modal_method').css('display','none');
    	}
    	
    	
    	function subscribe(id){
    	    $('.area__detals').removeClass('area-profile');
    		<?
    		if($Client->auth){
    			?>
    		var client_id = '<?=$Client->id?>';
    		//var from_date = $('#from_date').val();
    		//var to_date = $('#to_date').val();
    		var days = $('#days_'+id).val();
    		
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=subscribe&client_id='+client_id+'&elem_id='+id+'&from_date='+from_date+'&to_date='+to_date+'&days='+days,
    			success: function(msg){
    				var pay_id = $.trim(msg);
    				if($.trim(msg) != 'err'){
    					open_modal_prices(pay_id);
    				}else{
    					show_ext_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_PODPISKU_NE_UDALOSI_OFORMITI']?>');
    				}
    			}
    		})
    			<?
    		}else{
    			?>
    		open_modal('login_space');
    			<?
    		}
    		?>
    	}
        function setActive(btn){
            $('.forget span').toggleClass('active-color');
        }
    </script>
</body>
</html>