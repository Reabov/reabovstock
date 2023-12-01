<?
if($Client->auth){
	header('Location: '.$CCpu->writelink(1));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
    <div class="all__hr log-hr"></div>
   
    <div class="back-black black-animation">
        <section  class="login">
            <div class="login__wrapper">
                <a href="<?=$CCpu->writelink(1)?>" class="login__close reset_close">
                    <img src="/images/icons/Group 453.png" alt="">
                </a>
                
                <div class="login__title">
                    <a href="<?=$CCpu->writelink(82)?>" class="log activ-colorgreen"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_LOG_IN']?></a>
                    <span></span>
                    <a href="<?=$CCpu->writelink(81)?>" class="reg activ-colorgrey"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_REGISTER']?></a>
                </div>
    
                <div class="login__subtitle"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_HI']?></div>
                <div class="login__descr"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_WE_ARE_HAPPY_TO_SEE_YOU_BACK_AGAIN']?></div>
    
                <div action="" class="login__form">
                    <input id="email" type="email" class="email login__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_AUTH_EMAIL']?>">
                    <input id="password" type="password" class="password login__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_AUTH_PASSWORD']?>">
                </div>

                <div class="login__error_pas"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_OPS_WRONG_PASSWORD_OR_EMAIL']?></div>
                <!--Текст появляется при неправильном вводе пароля(появляется при неправильном пароле)-->

                <div class="accept accept-log"></div>
                <button class="forget" id="accept_btn" >
                    <span class="e"><span class="w"></span></span><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_STAY_LOGGED_ON_THIS_COMPUTER']?>
                </button>
                
                
                <button onclick="login()" class="login__btn" disabled><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_LOG_IN_BTN']?></button>
                
                <div class="real_forget">
                	<button>
                		<?=$GLOBALS['ar_define_langterms']['MSG_AUTH_I_WANT_TO_']?> 
                		<a href="<?=$CCpu->writelink(83)?>">
                			<?=$GLOBALS['ar_define_langterms']['MSG_AUTH_FORGET_PASSWORD']?>
                		</a>
                	</button>
                </div>
                
                <a href="<?=$CCpu->writelink(1)?>" class="logo-black-mob logo-reg">
                    <img src="/images/elements/logo/logo-black.svg" alt="">
                </a>

                <!-- <a href="" class="login__reset">I want to <span>Reset my password</span></a> -->
                <!--Cылка для восстановления пароля(появляется при неправильном пароле)-->
            </div>
        </section>
        
    </div>
    
    
    
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
    
    <script>
    	function login(){
    		var email = $('#email').val();
    		var password = $('#password').val();
    		
    		var check_save = $('#accept_btn').find('.w').hasClass('s-activ');
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
    					$('.login__error_pas').css('display','block');
    					
    					if($.trim(msg) == '<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_V_BAZE_DANNYH_NET_POLIZOVATELYA_S_TAKIM_ELEKTRONNYM_ADRESOM']?>' || 
    					$.trim(msg) == '<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_ETA_ELEKTRONNAYA_POCHTA_NE_PODTVERZHDENA']?>'){
    						$('#email').css('border-color','#FF0000');
    					}else{
    						if($.trim(msg) == '<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_NEVERNYJ_PAROLI']?>'){
    							$('#password').css('border-color','#FF0000');
    						}else{
    							if($.trim(msg) == '<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_PROIZOSHLA_OSHIBKA_POVTORITE_POPYTKU_POZZHE']?>'){
    								$('#email').css('border-color','#FF0000');
    								$('#password').css('border-color','#FF0000');
    							}
    						}
    					}
    					
    				}
    			}
    		})
    		
    	}
    	function check_log_values(){
    		var check_email = $('#email').hasClass('checked');
    		var check_pass = $('#password').hasClass('checked');
    		//var check_accept = $('#accept_btn').find('.w').hasClass('s-activ');
    		
    		if( check_email && check_pass ){
    			$('.login__btn').prop('disabled',false);
    		}else{
    			$('.login__btn').prop('disabled',true);
    		}
    	}
    	
    	$('input').on('focus',function(){
    		$(this).css('border-color','');
    	})
    	
    	$('#email').keyup(function(){
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
    	
    	$('#password').keyup(function(){
    		var v = $(this).val();
    		if(v != ''){
    			$(this).addClass('checked');
    		}else{
    			$(this).removeClass('checked');
    		}
    		
    		var re_pass = $('#re_password').val();
    		if(re_pass == v){
    			$('#re_password').addClass('checked');
    		}else{
    			$('#re_password').removeClass('checked');
    		}
    		check_log_values();
    	})
    	
    	$('#accept_btn').on('click',function(){
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
</body>
</html>