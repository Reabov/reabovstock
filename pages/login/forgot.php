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
   
   
    <div class="register <?/* back-black */?>">
        <section  class="login">
            <div class="login__wrapper reset_wrapper">
                <a href="<?=$CCpu->writelink(1)?>" class="login__close reset_close">
                    <img src="/images/icons/Group 453.png" alt="">
                </a>
                
                <div class="login__title">
                    <a href="<?=$CCpu->writelink(82)?>" class="log activ-colorgreen"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_LOG_IN']?></a>
                    <span></span>
                    <a href="<?=$CCpu->writelink(81)?>" class="reg activ-colorgrey"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_REGISTER']?></a>
                </div>
                
                <div class="reset__title"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_RESET_PASSWORD']?></div>
                <div class="reset__subtitle"><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_TYPE_HERE_YOUR_ACCOUNT_EMAIL_ADDRESS']?></div>
                
                <input id="email" type="emal" class="reset__input">
                <button class="accept" id="accept_btn">
                    <span class="a"><span class="s"></span></span><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_THIS_IS_MY_EMAIL_ADDRESS']?>
                </button>

                <button onclick="send_forgot_email()" class="reset__send" disabled><?=$GLOBALS['ar_define_langterms']['MSG_AUTH_SEND']?></button>
                
            </div>
        </section>
    </div>
    
    
    
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
    
    <script>
    	function send_forgot_email(){
    		var email = $('#email').val();
    		
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=send_forgot&email='+email,
    			success: function(msg){
    				//console.log(msg);
    				if($.trim(msg) == 'ok'){
    					location.href = '<?=$CCpu->writelink(93)?>';
    				}else{
    					show_not(msg);
    				}
    			}
    		})
    	}
    	
    	function check_forgot_values(){
    		var check_email = $('#email').hasClass('checked');
    		var check_accept = $('#accept_btn').find('.s').hasClass('s-activ');
    		
    		if( check_email && check_accept ){
    			$('.reset__send').prop('disabled',false);
    		}else{
    			$('.reset__send').prop('disabled',true);
    		}
    	}
    	
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
    		check_forgot_values();
    	})
        
        $('#accept_btn').on('click',function(){
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
</body>
</html>