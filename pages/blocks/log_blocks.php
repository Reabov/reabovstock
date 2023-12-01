<div class="modal_space <?/* back-black */?>">
    	<section class="login modal_block" id="login_space">
    		<div class="login__wrapper">
                <a onclick="close_modal()" class="login__close <?/* reset_close */?>">
                    <img src="/images/icons/Group 453.png" alt="">
                </a>
                <div class="register__menu">
                	<a onclick="close_modal()" class="register__close_menu">
                    	<img src="/images/icons/Group 453.png" alt="">
                	</a>
                </div>
                
                <div class="login__title">
                    <a class="log activ-colorgreen"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_LOG_IN']?></a>
                    <span></span>
                    <a onclick="open_modal('reg_space')" class="reg activ-colorgrey"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_REGISTER']?></a>
                </div>
    
                <div class="login__subtitle"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_HI']?></div>
                <div class="login__descr"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_WE_ARE_HAPPY_TO_SEE_YOU_BACK_AGAIN']?></div>
    
                <div action="" class="login__form">
                    <input id="email" type="email" class="email login__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_AUTH_EMAIL']?>">
                    <input id="password" type="password" class="password login__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_AUTH_PASSWORD']?>">
                </div>

                <div class="login__error_pas"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_OPS_WRONG_PASSWORD_OR_EMAIL']?></div>
                <!--Текст появляется при неправильном вводе пароля(появляется при неправильном пароле)-->

                <?/* <div class="accept accept-log"></div> */?>
                <button class="forget" id="accept_btn" >
                    <span class="e">
                    	<span class="w"></span>
                    </span>
                    <?=$GLOBALS['ar_define_langterms']['MSG_AUTH_STAY_LOGGED_ON_THIS_COMPUTER']?>
                </button>
                
                
                <button onclick="login()" class="login__btn" disabled><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_LOG_IN_BTN']?></button>
                
                <div class="real_forget">
                	<button>
                		<?=$GLOBALS['ar_define_langterms']['MSG_AUTH_I_WANT_TO_']?> 
                		<a onclick="open_modal('forgot_space')">
                			<?=$GLOBALS['ar_define_langterms']['MSG_AUTH_FORGET_PASSWORD']?>
                		</a>
                	</button>
                </div>
                <?/* <a href="<?=$CCpu->writelink(1)?>" class="logo-black-mob logo-reg">
                	<img src="/images/elements/logo/logo-black.svg" alt="">
            	</a> */?>

                <!-- <a href="" class="login__reset">I want to <span>Reset my password</span></a> -->
                <!--Cылка для восстановления пароля(появляется при неправильном пароле)-->
            </div>
    	</section>
    	
    <section  class="register modal_block" id="reg_space">
        <div class="register__wrapper">
            <a onclick="close_modal()" class="register__close">
                <img src="/images/icons/Group 453.png" alt="">
            </a>
            <div class="register__menu">
                <a onclick="close_modal()" class="register__close_menu">
                    <img src="/images/icons/Group 453.png" alt="">
                </a>
                <?/* <a onclick="open_modal('reg_space')" class="cabin">
                    <img src="/images/icons/log-mobile.png" alt="">
                </a> */?>
            </div>
            <div class="register__title">
                <a onclick="open_modal('login_space')" class="log activ-colorgrey"><?=$GLOBALS['ar_define_langterms']['MSG_REG_LOG_IN']?></a>
                <span></span>
                <div class="forget vs"></div>
                <a class="reg activ-colorgreen"><?=$GLOBALS['ar_define_langterms']['MSG_REG_REGISTER']?></a>
            </div>

            

            <div action="" class="register__form">
            	<div>
            		<input autocomplete="off" type="text" id="fullname" class="fullname register__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_REG_FULL_NAME']?>">
            	</div>
                <div class="blocksel">
                    <!-- <div class="placeholder" data-text="Country">Country</div> -->
                    <input autocomplete="off" id="country_search" class="register__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_REG_COUNTRY']?>" >
                    <div class="country_select_block">
                    	<select name="type" id="country" class="register__select nice-select " onchange="select_country()">
                        <option data-display="<?=$GLOBALS['ar_define_langterms']['MSG_REG_COUNTRY']?>"></option>
                        <?
                        $countries = $Db->getall(" SELECT * FROM `ws_country` WHERE active = 1 ORDER BY sort DESC ");
						foreach ($countries as $key => $country) {
							?>
						<option value="<?=$country['id']?>"><?=$country['title_'.$CCpu->lang]?></option>	
							<?
						}
                        ?>
                		</select>
                    </div>
            	</div>
                <div>
                	<input autocomplete="off" type="text" id="email" class="email register__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_REG_EMAIL']?>">
                </div>
                <form onsubmit="return false;">
                	<div>
                		<input type="password" id="password" class="password register__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_REG_PASSWORD']?>">
                	</div>
                	<div>
                		<input type="password" id="re_password" class="password register__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_REG_CONFIRM_PASSWORD']?>">
                	</div>
                </form>
                
            </div>
            <button class="accept" id="accept_btn">
                <span class="circle_checkbox a">
                	<span class="s circle"></span>
                </span>
                <?=$GLOBALS['ar_define_langterms']['MSG_REG_I_ACCEPT_ALL_']?>
                <a class="accept_text" target="_blank" href="<?=$CCpu->writelink(72)?>" ><?=$GLOBALS['ar_define_langterms']['MSG_REG_TERMS_AND_CONDITION']?></a> <?=$GLOBALS['ar_define_langterms']['MSG_REG_AND']?> 
                <a class="accept_text" target="_blank" href="<?=$CCpu->writelink(85)?>" ><?=$GLOBALS['ar_define_langterms']['MSG_REG_PRIVACY_POLICY']?></a>
            </button>
            <!-- <div class="method__accept">
                <button class="accept" onclick="setAll1(this)">
                    <span class="ac ac1"><span class="s"></span></span>I accept all <a href="terms.html" class="underline">Terms and Condition</a>
                </button>
                <button class="accept method-accept-btn2" onclick="setAll2(this)">
                    <span class="ac ac2"><span class="s"></span></span>I accept <a href="privacy.html" class="underline">Privacy Policy</a>
                </button>
            </div> -->


            <button class="register__btn" disabled onclick="register()" ><?=$GLOBALS['ar_define_langterms']['MSG_REG_CREATE_ACCOUNT']?></button>
            <?/* <a href="<?=$CCpu->writelink(1)?>" class="logo-black-mob logo-reg">
                <img src="/images/elements/logo/logo-black.svg" alt="">
            </a> */?>
        </div>
    </section>
    
    
    
        <section class="login modal_block" id="forgot_space">
            <div class="login__wrapper reset_wrapper">
                <a onclick="close_modal()" class="login__close reset_close">
                    <img src="/images/icons/Group 453.png" alt="">
                </a>
                
                <div class="login__title">
                    <a onclick="open_modal('login_space')" class="log activ-colorgreen"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_LOG_IN']?></a>
                    <span></span>
                    <a onclick="open_modal('reg_space')" class="reg activ-colorgrey"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_REGISTER']?></a>
                </div>
                
                <div class="reset__title"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_RESET_PASSWORD']?></div>
                <div class="reset__subtitle"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_TYPE_HERE_YOUR_ACCOUNT_EMAIL_ADDRESS']?></div>
                
                <input id="email" type="emal" class="reset__input">
                <button class="accept" id="accept_btn">
                    <span class="a circle_checkbox">
                    	<span class="s circle"></span>
                    </span>
                    <?=$GLOBALS['ar_define_langterms']['MSG_AUTH_THIS_IS_MY_EMAIL_ADDRESS']?>
                </button>

                <button onclick="send_forgot_email()" class="reset__send" disabled><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_SEND']?></button>
                
                <?/* <a href="<?=$CCpu->writelink(1)?>" class="logo-black-mob logo-reg">
                	<img src="/images/elements/logo/logo-black.svg" alt="">
            	</a> */?>
                
            </div>
        </section>
    
    
    <section  class="login success modal_block" id="success_space">
            <div class="login__wrapper success_wrapper">
                <a onclick="close_modal()" class="login__close reset_close">
                    <img src="/images/icons/Group 453.png" alt="">
                </a>
                
                <div class="login__title">
                    <a onclick="open_modal('login_space')" class="log activ-colorgreen"><?=$GLOBALS['ar_define_langterms']['MSG_REG_LOG_IN']?></a>
                    <span></span>
                    <a onclick="open_modal('reg_space')" class="reg activ-colorgrey"><?=$GLOBALS['ar_define_langterms']['MSG_REG_REGISTER']?></a>
                </div>
                
                <img src="/images/icons/correct.png" alt="" class="reset__correct-img">
                
                <div class="reset__correct-title"><?=$GLOBALS['ar_define_langterms']['MSG_REG_EMAIL_WAS_SEND']?></div>
                <div class="reset__correct-subtitle"><?=$GLOBALS['ar_define_langterms']['MSG_REG_CHECK_YOUR_E-MAIL']?></div>
                                
                <a onclick="open_modal('login_space')" class="backtologin"><?=$GLOBALS['ar_define_langterms']['MSG_REG_BACK_TO_LOG_IN']?></a>
            </div>
	</section>
    	
    	
    	
    	
    	
    	
    	
    	
</div>
    
    <script>
    	function open_modal(modal){
    		clear_all_modal_fields();
    		$('.modal_block').css('display','none');
    		$('.modal_space').css('display','flex');
    		$('#'+modal).css('display','block');
    		unscroll_body();
    	}
    	function close_modal(){
    		$('.modal_block').css('display','none');
    		$('.modal_space').css('display','none');
    		rescroll_body();
    	}
    	function clear_all_modal_fields(){
    		$('input').val('');
    		$('#country_search').val('');
    		$('input').removeClass('checked');
    		
    		
    		$('.real_forget').css('display','');
    		$('.real_forget').css('margin-top','');
    		$('.login__error_pas').css('display','');
    		$('#login_space #accept_btn').removeClass('wrong_log');
    		
    		
    		$('#login_space #email').css('border-color','');
    		$('#login_space #password').css('border-color','');
    		$('#login_space #email').css('border-color','');
    		$('#login_space #password').css('border-color','');
    		
    		
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=get_countries&search=',
    			success: function(msg){
    				$('#reg_space .country_select_block').html(msg);
    				$('.nice-select').niceSelect();
    				$('.nice-select list').scrollLeft('100');
    				$(".nice-select .list").mCustomScrollbar({
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
    		});
    		
    		
    		check_forgot_values();
    		check_log_values();
    		check_reg_values();
    	}
    </script>
    
    <!--- forgot --->
    <script>
    	function send_forgot_email(){
    		var email = $('#forgot_space #email').val();
    		
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=send_forgot&email='+email,
    			success: function(msg){
    				//console.log(msg);
    				if($.trim(msg) == 'ok'){
    					<?/* location.href = '<?=$CCpu->writelink(93)?>'; */?>
    					open_modal('success_space');
    				}else{
    					show_not(msg);
    				}
    			}
    		})
    	}
    	
    	function check_forgot_values(){
    		var check_email = $('#forgot_space #email').hasClass('checked');
    		var check_accept = $('#forgot_space #accept_btn').find('.s').hasClass('s-activ');
    		
    		if( check_email && check_accept ){
    			$('.reset__send').prop('disabled',false);
    		}else{
    			$('.reset__send').prop('disabled',true);
    		}
    	}
    	
        $('#forgot_space #email').keyup(function(){
    		var v = $(this).val();
    		var err = 0;
    		
    		if(v == ''){
    			err = 1;
    		}
    		
    		var email_arr = v.split('@');
    		if(email_arr.length == 2 && email_arr[0] != '' && email_arr[1] != ''){
    			var mail = email_arr[1];
    			var mail_arr = mail.split('.');
    			if(mail_arr.length < 2 || mail_arr[0] == '' || mail_arr[1] == ''){
    				err = 1;
    			}
    		}else{
    			err = 1;
    		}
    		
    		if(err == 0){
    			$(this).addClass('checked');
    		}else{
    			$(this).removeClass('checked');
    		}
    		check_forgot_values();
    	})
        
        $('#forgot_space #accept_btn').on('click',function(){
        	$(this).find('.s').toggleClass('s-activ');
        	check_forgot_values();
        })
        
        function setActivRing(){
            if ($('w') === hide()) {
            $('w').show();
            } else {
            $('w') === hide();
            }
        }
    </script>
    <!--- forgot --->
    
    
    
    
    <!--- login --->
    <script>
    	
    	function login(){
    		var email = $('#login_space #email').val();
    		var password = $('#login_space #password').val();
    		
    		var check_save = $('#login_space #accept_btn').find('.w').hasClass('s-activ');
    		if(check_save){
    			check_save = '1';
    		}else{
    			check_save = '0';
    		}
    		
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=login&email='+email+'&password='+password+'&check_save='+check_save,
    			success: function(msg){
    				if($.trim(msg) == 'ok'){
    					location.href = "<?=$CCpu->writelink(80)?>";
    				}else{
    					show_not(msg);
    					$('.real_forget').css('display','block');
    					$('.real_forget').css('margin-top','39px');
    					$('.login__error_pas').css('display','block');
    					$('#login_space #accept_btn').addClass('wrong_log');
    					$('#login_space .login__btn').addClass('wrong_log');
    					
    					
    					if($.trim(msg) == '<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_V_BAZE_DANNYH_NET_POLIZOVATELYA_S_TAKIM_ELEKTRONNYM_ADRESOM']?>' || 
    					$.trim(msg) == '<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_ETA_ELEKTRONNAYA_POCHTA_NE_PODTVERZHDENA']?>'){
    						$('#login_space #email').css('border-color','#FF0000');
    					}else{
    						if($.trim(msg) == '<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_NEVERNYJ_PAROLI']?>'){
    							$('#login_space #password').css('border-color','#FF0000');
    						}else{
    							if($.trim(msg) == '<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_PROIZOSHLA_OSHIBKA_POVTORITE_POPYTKU_POZZHE']?>'){
    								$('#login_space #email').css('border-color','#FF0000');
    								$('#login_space #password').css('border-color','#FF0000');
    							}
    						}
    					}
    					
    				}
    			}
    		})
    		
    	}
    	function check_log_values(){
    		var check_email = $('#login_space #email').hasClass('checked');
    		var check_pass = $('#login_space #password').hasClass('checked');
    		//var check_accept = $('#accept_btn').find('.w').hasClass('s-activ');
    		
    		if( check_email && check_pass ){
    			$('#login_space .login__btn').prop('disabled',false);
    		}else{
    			$('#login_space .login__btn').prop('disabled',true);
    		}
    	}
    	
    	$('#login_space input').on('focus',function(){
    		$(this).css('border-color','');
    	})
    	
    	$('#login_space #email').keyup(function(){
    		var v = $(this).val();
    		var err = 0;
    		
    		if(v == ''){
    			err = 1;
    		}
    		
    		var email_arr = v.split('@');
    		if(email_arr.length == 2 && email_arr[0] != '' && email_arr[1] != ''){
    			var mail = email_arr[1];
    			var mail_arr = mail.split('.');
    			if(mail_arr.length < 2 || mail_arr[0] == '' || mail_arr[1] == ''){
    				err = 1;
    			}
    		}else{
    			err = 1;
    		}
    		
    		if(err == 0){
    			$(this).addClass('checked');
    		}else{
    			$(this).removeClass('checked');
    		}
    		check_log_values();
    	})
    	
    	$('#login_space #password').keyup(function(){
    		var v = $(this).val();
    		if(v != ''){
    			$(this).addClass('checked');
    		}else{
    			$(this).removeClass('checked');
    		}
    		
    		var re_pass = $('#login_space #re_password').val();
    		if(re_pass == v){
    			$('#login_space #re_password').addClass('checked');
    		}else{
    			$('#login_space #re_password').removeClass('checked');
    		}
    		check_log_values();
    	})
    	
    	$('#login_space #accept_btn').on('click',function(){
        	$(this).find('.w').toggleClass('s-activ');
        	check_log_values();
        })
    	
        function setActivRing(){
            if ($('w') === hide()) {
            $('w').show();
            } else {
            $('w') === hide();
            }
        }
    </script>
    <!--- login --->
    
    
    
    
    
    <!--- reg --->
    <script>
    	$('#reg_space #country_search').on('focus',function(){
    		var check_country = $('#reg_space #country').val();
    		if(check_country != ''){
    			$(this).val('');
    			
    			$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=get_countries&search=',
    			success: function(msg){
    				$('#reg_space .country_select_block').html(msg);
    				$('.nice-select').niceSelect();
    				$(".nice-select .list").mCustomScrollbar({
                		axis:"y",
                		advanced:{autoExpandHorizontalScroll:true}, 
                		callbacks:{
                    		onOverflowY:function(){
                    			var opt=$(this).data("mCS").opt;
                    			if(opt.mouseWheel.axis!=="y") opt.mouseWheel.axis="y";
                    		},
                		}
                	});
    				
    				$('#reg_space .register__select').addClass('hard_open');
    				$('#reg_space .register__select').addClass('open');
    			}
    			})
    		}else{
    			$('#reg_space .register__select').addClass('hard_open');
    			$('#reg_space .register__select').addClass('open');
    		}
    		
    		/*$('#country').focus();*/
    	});
    	
    	$('#reg_space #country_search').keyup(function(e){
    		var letters = ['Q','W','E','R','T','Y','U','I','O','P','A','S','D','F','G','H','J','K','L','Z','X','C','V','B','N','M','(',')',' ',
    						'q','w','e','r','t','y','u','i','o','p','a','s','d','f','g','h','j','k','l','z','x','c','v','b','n','m','Backspace','Delete'];
    		
    		if( $.inArray(e.key,letters) != -1 ){
    			var v = $(this).val();
    			$.ajax({
    				type: 'POST',
    				url: '<?=$CCpu->writelink(3)?>',
    				data: 'task=get_countries&search='+v,
    				success: function(msg){
    					$('#reg_space .country_select_block').html(msg);
    					$('.nice-select').niceSelect();
    					$(".nice-select .list").mCustomScrollbar({
                			axis:"y",
                			advanced:{autoExpandHorizontalScroll:true}, 
                			callbacks:{
                    			onOverflowY:function(){
                    				var opt=$(this).data("mCS").opt;
                    				if(opt.mouseWheel.axis!=="y") opt.mouseWheel.axis="y";
                    			},
                			}
                		});
    				
    					$('#reg_space .register__select').addClass('hard_open');
    					$('#reg_space .register__select').addClass('open');
    				}
    			});
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
    		
    	});
    	
    	function select_arrow_country(){
    		if( $('.country_select_block .option').hasClass('arrow_selected') ){
    			var id = $('.arrow_selected').data('value');
    			var country = $('.arrow_selected').text();
    			country = $.trim(country);
    			
    			$('#reg_space #country_search').val(country);
    			$('#reg_space #country').val(id);
    			
    			$('.arrow_selected').addClass('selected');
    			
    			select_country()
    		}
    	}
    	
    	function select_option_country(type){
    		var check_selected = false;
    		var count = $('.country_select_block .option').length;
    		count = count-1;
    		$('.country_select_block .option').each(function(key, value){
    			if(key == 1){
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
    	
    	$(document).on('click',function(e) {
        	if (!$('#reg_space .register__select').is(e.target) && $('#reg_space .register__select').has(e.target).length === 0 
        		&& !$('#reg_space #country_search').is(e.target) && $('#reg_space #country_search').has(e.target).length === 0 ) {
            	$('#reg_space .register__select').removeClass('hard_open');
            	$('#reg_space .register__select').removeClass('open');
            	$('#reg_space .arrow_selected').removeClass('arrow_selected');
            	return_scrollbar();
            	
        	}
        	if($('#reg_space .register__select.hard_open').is(e.target)){
        		$('#reg_space .register__select').removeClass('hard_open');
    			$('#reg_space .register__select').removeClass('open');
    			$('#reg_space .arrow_selected').removeClass('arrow_selected');
    			return_scrollbar();
    			
        	}
		})
    	
    	function select_country(){
    		$('#reg_space .register__select').addClass('open');
    		$('#reg_space .register__select').removeClass('hard_open');
    		$('#reg_space .arrow_selected').removeClass('arrow_selected');
    		
    		var id = $('#reg_space #country').val();
    		var v = $('#reg_space .register__select.nice-select').find('.option.selected').text();
    		v = $.trim(v);
    		
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=get_countries&search='+v,
    			success: function(msg){
    				$('#reg_space .country_select_block').html(msg);
    				$('.nice-select').niceSelect();
    				$('.nice-select list').scrollLeft('100');
    				
    				$('#reg_space #country').val(id);
    				$('#reg_space .register__select').addClass('checked');
    				check_reg_values();
    			}
    		});
    		
    		$('#reg_space #country_search').val(v);
    	}
    	
    	function return_scrollbar(){
    		
    		$("#reg_space .nice-select .list").mCustomScrollbar({
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
    	
    	function check_reg_values(){
    		var check_name = $('#reg_space #fullname').hasClass('checked');
    		var check_email = $('#reg_space #email').hasClass('checked');
    		var check_pass = $('#reg_space #password').hasClass('checked');
    		var check_re_pass = $('#reg_space #re_password').hasClass('checked');
    		var check_country = $('#reg_space .register__select').hasClass('checked');
    		var check_accept = $('#reg_space #accept_btn').find('.s').hasClass('s-activ');
    		
    		if(check_name && check_email && check_pass && check_re_pass && check_country && check_accept){
    			$('.register__btn').prop('disabled',false);
    		}else{
    			$('.register__btn').prop('disabled',true);
    		}
    	}
    	
    	
    	
    	$('#reg_space #fullname').keyup(function(){
    		var numbers_symbols = ['0','1','2','3','4','5','6','7','8','9','!','@','#','$','%','^','&','*','(',')',
    							'{','}','[',']','`','~','+','=','_','"',"'",'\\','|','/',';',':','.',',','?','<','>']; 
    		
    		var v = $(this).val();
    		$.each(numbers_symbols,function(k,s){
    			v = v.replace(s,'');
    		});
    		$(this).val(v);
    		
    		if(v != ''){
    			$(this).addClass('checked');
    		}else{
    			$(this).removeClass('checked');
    		}
    		check_reg_values();
    	})
    	
    	$('#reg_space #email').keyup(function(){
    		var v = $(this).val();
    		var err = 0;
    		
    		if(v == ''){
    			err = 1;
    		}
    		
    		var email_arr = v.split('@');
    		if(email_arr.length == 2 && email_arr[0] != '' && email_arr[1] != ''){
    			var mail = email_arr[1];
    			var mail_arr = mail.split('.');
    			if(mail_arr.length < 2 || mail_arr[0] == '' || mail_arr[1] == ''){
    				err = 1;
    			}
    		}else{
    			err = 1;
    		}
    		
    		if(err == 0){
    			$(this).addClass('checked');
    		}else{
    			$(this).removeClass('checked');
    		}
    		check_reg_values();
    	})
    	
    	$('#reg_space #password').keyup(function(){
    		var v = $(this).val();
    		if(v != ''){
    			$(this).addClass('checked');
    		}else{
    			$(this).removeClass('checked');
    		}
    		
    		var re_pass = $('#reg_space #re_password').val();
    		if(re_pass == v){
    			$('#reg_space #re_password').addClass('checked');
    		}else{
    			$('#reg_space #re_password').removeClass('checked');
    		}
    		check_reg_values();
    	})
    	
    	$('#reg_space #re_password').keyup(function(){
    		var v = $(this).val();
    		if(v != ''){
    			var pass = $('#reg_space #password').val();
    			if(pass == v){
    				$(this).addClass('checked');
    			}else{
    				$(this).removeClass('checked');
    			}
    		}else{
    			$(this).removeClass('checked');
    		}
    		check_reg_values();
    	})
    	
    	
    	$('#reg_space #country').on('change',function(){
    		$('#reg_space .register__select').addClass('checked');
    		check_reg_values();
    	})
    	
    	$('#reg_space #accept_btn').on('click',function(){
        	$(this).find('.s').toggleClass('s-activ');
        	check_reg_values();
        })
    	
    	function register(){
    		var name = $('#reg_space #fullname').val();
    		var email = $('#reg_space #email').val();
    		var country_id = $('#reg_space #country').val();
    		var password = $('#reg_space #password').val();
    		
    		
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=pre_reg&name='+name+'&email='+email+'&country_id='+country_id+'&password='+password,
    			success: function(msg){
    				if($.trim(msg) == 'ok'){
    					<?/* location.href = "<?=$CCpu->writelink(93)?>"; */?>
    					open_modal('success_space');
    				}else{
    					show_not(msg);
    				}
    			}
    		})
    		
    	}
    	
        
        function setAll1(){
            $('#reg_space .ac1').children().toggleClass('s-activ');
        }
        function setAll2(){
            $('#reg_space .ac2').children().toggleClass('s-activ');
        }


       (function($){
            $(window).load(function(){
                $("#reg_space .list").mCustomScrollbar({
                axis:"y",
                advanced:{autoExpandHorizontalScroll:true}, 
                callbacks:{
                    onOverflowY:function(){
                    var opt=$(this).data("mCS").opt;
                    if(opt.mouseWheel.axis!=="y") opt.mouseWheel.axis="y";
                    },
                }
                });

            });
		})(jQuery);



       $(document).ready(function() {
       $('#reg_space .nice-select').niceSelect();
       $('#reg_space .nice-select list').scrollLeft('100')
       });
    </script>
    <!--- reg --->
    
    
    
    