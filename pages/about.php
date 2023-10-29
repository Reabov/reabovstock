<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
	
    <? include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php") ?>
    
    <section class="promo">
    	<?
    	$video = $Db->getone("SELECT * FROM `ws_video` WHERE id = 4");
    	?>
    	<style>
			.video_desc.video_4 {
				display: block;
			}
			.video_mob.video_4 {
				display: none;
			}
			@media(max-width: <?=$video['mob_size']?>px){
				.video_desc.video_4 {
					display: none;
				}
				.video_mob.video_4 {
					display: block;
				}
			}
		</style>
        <div class="promo__wrapper">
            <video class="video-homepage video_desc video_4" loop autoplay muted preload playsinline>
            	<source src="/upload/video/<?=$video['video']?>" type="video/mp4"></source>
            </video>
            <video class="video-homepage video_mob video_4" loop autoplay muted preload playsinline>
            	<source src="/upload/video/<?=$video['mob_video']?>" type="video/mp4"></source>
            </video>
        </div>
    </section>

    <section class="know">
        <div class="know__wrapper">
            <div class="know__title"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_GET_TO_KNOW_US']?></div>
            <div class="know__descr"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_WE_ARE_A_SKILLED_AND_PASSIONATE_3D_MODELING']?></div>
        </div>
    </section>

    <section class="carusel">
        <div class="carusel__title"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_SOME_OF_OUR_MILESTONES']?>
        </div>
        <div class="carusel__wrapper">
            
            <div class="carusel-slider">
            	<?
            	$timeline = $Db->getall("SELECT * FROM `ws_carousel` WHERE active = 1 ORDER BY sort DESC ");
				foreach ($timeline as $key => $time) {
					?>
				<div class="slide block-slide">
                    <p class="www"><?=$time['year']?></p>
                    <span class="ring <?if($time['green'] == '1'){?> green <?}?>"></span>
                    <div class="descr"><?=$time['text_'.$CCpu->lang]?></div>
                    <div class="mid_line"></div>
                </div>	
					<?
				}
            	?>
            </div>
            <div class="slider-nav">
                <div class="slider-arrow">
                    <!-- <span class="slider-line line-start"></span>
                    <span class="slider-line line-end"></span> -->
                </div>
            <!-- <div class="prog-wr">  
                <div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>    
            </div> -->
        </div>
        </div>

    
    </section>
       
    <section class="team">
        <div class="team__wrapper">
            <div class="team__img">
            	<?
            	$about = $Db->getone("SELECT * FROM `ws_about` WHERE id = 1");
            	?>
                <img src="/upload/about/<?=$about['image']?>" alt="">
            </div>

            <div class="team__title"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_OUR_TEAM']?></div>
            <div class="team__descr"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_WE_ARE_A_SKILLED_AND_PASSIONATE_3D_MODELING_DESIGN_STUDIO_TEAM_THAT_CREATES_HIGH-QUALITY_MODELS_FOR_VARIOUS_INDUSTRIES']?></div>

            <div class="team__subtitle"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_IF_YOU_ARE_IN_LOVE_OF_3D_MODELING']?></div>
            <button class="team__btn" ><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_JOIN_ON_OUR_TEAM']?></button>
            <div class="team__modal">
                <div class="team__modal__wr">
                   <div class="team_mod_head">
                    <button class="modal__close" onclick="setModalClose(this)">
                        <img src="/images/icons/Group 453.png" alt="">
                    </button>
                   </div>
                    <div class="team__modal__title"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_COMPLETE_INFORMATION']?></div>
                    <div class="team__modal__subtitle"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_AND_WE_WILL_LET_YOU_KNOW_LOREM_IPSUM']?></div>

                    <div action="" class="team__form">
                        <div class="modal_input-wr">
                            <input type="text" id="req_name" class="input__modal" placeholder="name">
                            <input type="text" id="req_surname" class="input__modal" placeholder="surname">
                            <input type="text" id="req_email" class="input__modal" placeholder="e-mail">
                            <input type="text" id="req_country" class="input__modal" placeholder="country">
                        </div>
       
                        <div class="text-wr">
                            <textarea class="input__message" id="req_text" placeholder="Describe yourself and your skills in a few words" oninput="document.querySelector('.charCount').textContent = this.value.length + '/200';" maxlength="200"></textarea>
                            <div class="charCount">0/200</div>
                        </div>
                    </div>
                    
                    <button class="send__btn" onclick="send_request()"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_SEND_EMAIL']?></button>
                </div>
            </div>
            <div class="team__subdescr"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_JOIN_OUR_DREAM_TEAM_AND_CREATE_AND_MODEL_3D_MODELS_FROM_ANYWHERE_IN_THE_WORLD']?></div>
            <div class="team__wr_link">
                <div><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_COMING_SOON']?></div>
                <button onclick="setModalOpen(this)"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_PRE-REGISTER']?></button>
            </div>
        </div>
    </section>

     <section class="clients">
        <div class="clients__wrapper">
            <div class="clients__title"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_OUR_CLIENTS_IS_FROM_AROUND_THE_WORLD']?></div>
            <div class="map-wrapper">
                <div class="clients__img tesst">
                    <img src="/images/elements/Map-foranimation.png" alt="">
                    <div class="el-green"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-1"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-2"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-3"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-4"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-5"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-6"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-7"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-8"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-9"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-10"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-11"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-12"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-13"><img src="/images/elements/Ellipse 35.png" alt=""></div>
    
                    <div class="el-green i-14"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-15"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-16"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-17"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-18"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-19"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-20"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-21"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-22"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-23"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-24"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-25"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-26"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-27"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-28"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-29"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-30"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-31"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-32"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-33"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-34"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-35"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-36"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-37"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-38"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-39"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-40"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-41"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-42"><img src="/images/elements/Ellipse 35.png" alt=""></div>
                    <div class="el-green i-43"><img src="/images/elements/Ellipse 35.png" alt=""></div>
    
                </div>
            </div>
        </div>
    </section>

    <section class="social social_about">
        <div class="socia__wrapper wrapper_hr">
            <div class="social__descr">
                <?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_IF_YOU_WANT_TO_KNOW_MORE_ABOUT_US_AND_OUR_TEAM']?>
            </div>
            <div class="social__title">
                <?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_FOLLOW_US_ON_SOCIAL_MEDIA']?>
            </div>
            <div class="social__icons">
                <a target="_blank" href="<?=$facebook_link?>" class="social__lick social__lick_facebook">
                	<img class="def_img" src="/upload/soc/<?=$facebook_image?>">
                	<img class="hov_img" src="/upload/soc/<?=$facebook_image_act?>">
                </a>
                <a target="_blank" href="<?=$instagram_link?>" class="social__lick social__lick_insta">
                	<img class="def_img" src="/upload/soc/<?=$instagram_image?>">
                	<img class="hov_img" src="/upload/soc/<?=$instagram_image_act?>">
                </a>
                <a target="_blank" href="<?=$telegram_link?>" class="social__lick social__lick_telegram">
                	<img class="def_img" src="/upload/soc/<?=$telegram_image?>">
                	<img class="hov_img" src="/upload/soc/<?=$telegram_image_act?>">
                </a>
            </div>
        </div>
    </section>
    
    <section class="support">
        <div class="support__wrapper">
            <div class="support__title"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_SUPPORT_OUR_PLATFORM']?></div>
            <div class="support__descr"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_IF_YOU_BELIEVE_IN_OUR_MISSION_AND_WANT_TO_SUPPORT_OUR_PLATFORM_WE_WELCOME_YOUR_DONATIONS']?></div>
            <div class="support__pay">
                <div class="support__pay_item patr">
                	<div>
                		<img src="/images/other/patreon.svg" alt="" class="support__pay_title">
                	</div>
                    <a href="<?=$GLOBALS['ar_define_settings']['PATREON_LINK']?>" target="_blank" class="support__pay_don"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_DONATE']?></a>
                </div>
                <div class="support__pay_item pay">
                	<div>
                		<img src="/images/other/paypal-logo.svg" alt="" class="support__pay_title">
                	</div>
                    <a href="<?=$GLOBALS['ar_define_settings']['PAYPAL_LINK']?>" target="_blank" class="support__pay_don"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_DONATE']?></a>
                </div>
                <div class="support__pay_item tip">
                	<div>
                		<img src="/images/other/tipeee-logo.svg" alt="" class="support__pay_title">
                	</div>
                    <a href="<?=$GLOBALS['ar_define_settings']['TIP']?>" target="_blank" class="support__pay_don"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_DONATE']?></a>
                </div>
            </div>
        </div>
    </section>
    <section class="by">
        <div class="wrapper_hr">
            <a href="<?=$GLOBALS['ar_define_settings']['REABOV_LINK']?>" target="_blank" class="by_des"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_DESIGNED_BY']?> <span><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_REABOVSTUDIO']?></span></a>
            <a href="https://webmaster.md/en/" target="_blank" class="by_dev"><?=$GLOBALS['ar_define_langterms']['MSG_ABOUT_DEVELOPED_BY']?> <span>Webmaster Studio</span></a>
        </div>
    </section>
    
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
    
    <script>
        $('.input__message').on('focus',function(){
        	$(this).css('border-color','');
        })
        $('.input__modal').on('focus',function(){
        	$(this).css('border-color','');
        })
        
        function send_request() {
        	var name = $('#req_name').val();
        	var surname = $('#req_surname').val();
        	var email = $('#req_email').val();
        	var country = $('#req_country').val();
        	var text = $('#req_text').val();
        	
        	var err = 0;
        	
        	if(name == ''){
        		err = 1;
        		$('#req_name').css('border-color','#c33434');
        	}
        	if(surname == ''){
        		err = 1;
        		$('#req_surname').css('border-color','#c33434');
        	}
        	if(email == ''){
        		err = 1;
        		$('#req_email').css('border-color','#c33434');
        	}else{
        		var email_arr = email.split('@');
    			if(email_arr.length == 2 && email_arr[0] != '' && email_arr[1] != ''){
    				var mail = email_arr[1];
    				var mail_arr = mail.split('.');
    				if(mail_arr.length < 2 || mail_arr[0] == '' || mail_arr[1] == ''){
    					err = 1;
    					$('#req_email').css('border-color','#c33434');
    				}
    			}else{
    				err = 1;
    				$('#req_email').css('border-color','#c33434');
    			}
        	}
        	if(country == ''){
        		err = 1;
        		$('#req_country').css('border-color','#c33434');
        	}
        	if(text == ''){
        		err = 1;
        		$('#req_text').css('border-color','#c33434');
        	}
        	
        	
        	if(err == 0){
        		$.ajax({
        			type: 'POST',
        			url: '<?=$CCpu->writelink(3)?>',
        			data: 'task=send_request&name='+name+'&surname='+surname+'&email='+email+'&country='+country+'&text='+text,
        			success: function(msg){
        				if($.trim(msg) == 'ok'){
        					$('#req_name').val('');
        					$('#req_surname').val('');
        					$('#req_email').val('');
        					$('#req_country').val('');
        					$('#req_text').val('');
        					show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_VASH_ZAPROS_OSTAVLEN']?>');
        					setModalClose();
        				}else{
        					show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_ZAPROS_OSTAVITI_NE_UDALOSI']?>');
        				}
        			}
        		});
        	}
        	
        	
        }
        
        
		function animateElements() {
			var counter = 0;
            $('.el-green').each(function(index, element) {
            	counter++;
            	if(counter == 4){
            		counter = 0;
            	}
            	var max_sec = 1500;
            	switch(counter){
            		case 0:
            			max_sec = 500;
            			break;
            		case 1:
            			max_sec = 500;
            			break;
            		case 2:
            			max_sec = 1000;
            			break;
            		case 3:
            			max_sec = 1500;
            			break;
            	}
            	
                const randomDelay = Math.random() * max_sec;
                $(element).css('animation-delay', `${randomDelay}ms`);
                $(element).css('animation-play-state', 'paused');
                setTimeout(() => {
                $(element).css('animation-play-state', 'running');
                }, randomDelay);
            });
        }
        animateElements();
        
        
        $(window).on('scroll',function(){
        	var w_top = $(window).scrollTop();
        	var w_height = $(window).height();
        	var map_top = $('.map-wrapper').offset().top;
        	var map_height = $('.map-wrapper').height();
        	var map_bottom = map_top + map_height;
        	
        	map_top = map_top-(w_height*0.75);
        	/* map_bottom = map_bottom+250; */
        	
        	if(!$('.clients__title').hasClass('firsth')){
        		if(w_top < map_bottom && w_top > map_top){
        			if($('.el-green').hasClass('hide')){
        				animateElements();
        				$('.el-green').removeClass('hide');
        				$('.clients__title').addClass('firsth');
        			}
        		}else{
        			if(!$('.el-green').hasClass('hide')){
        				$('.el-green').addClass('hide');
        			}
        		}
        	}
        	
        })
        
      
        function setModalOpen(){
            $('.team__modal').show();
            unscroll_body();
        }
        function setModalClose(){
            $('.team__modal').hide();
            rescroll_body();
        }
        
		
        $(document).ready(function() {
            var $slider = $('.carusel-slider');
            var $progressBar = $('.progress');
            var $progressBarLabel = $('.slider__label');

            $progressBar.css('width', '87%').attr('aria-valuenow', 0);
            $progressBarLabel.text('0% completed');

            $slider.on('beforeChange', function(event, slick, currentSlide, nextSlide) {
                var calc = (nextSlide + 1) * 20;
                $progressBar
                    .css('width', '100%', calc + '% 100%')
                    .attr('aria-valuenow', calc);

                $progressBarLabel.text(calc + '% completed');
            });

                $('.carusel-slider').slick({
                    infinite: false,
                    slidesToShow: 4,
                    slidesToScroll: 3,
                    arrows: true,
                    dots: false,
                    autoplay: false,
                    autoplaySpeed: 5000,
                    speed: 1000,
                    responsive: [
                            {
                                breakpoint: 1040,
                                    settings: {
                                        slidesToShow: 3,
                                        slidesToScroll: 2,

                                    }
                            },
                            {
                                breakpoint: 874,
                                    settings: {
                                        slidesToShow: 2,
                                        slidesToScroll: 1,

                                    }
                            },
                            {
                                breakpoint: 601,
                                    settings: {
                                        slidesToShow: 1,
                                        slidesToScroll: 1,

                                    }
                            },
                        ],
                    appendArrows: '.slider-arrow',
                    prevArrow: '<button class="slider-arrows arrowPrevAge"></button>',
                    nextArrow: '<button class="slider-arrows arrowNextAge"></button>',
                   
                }); 
        });

    </script>
</body>
</html>