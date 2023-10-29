<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
		
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
	
	
    
    <div class="all__hr"></div>
    <section class="contact">
        <div class="contact__wrapper">
            <div class="contact__title"><?=$page_data['title']?></div>
            <div class="contact__descr">
            	<?=$page_data['text']?>
            </div>
            <?
            if(!$Client->auth){
            	?>
            <textarea style="display: none;" class="contact__message" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_CONTACTS_TYPE_YOUR_TEXT']?>"></textarea>
            <div class="contact__error"><?=$GLOBALS['ar_define_langterms']['MSG_CONTACTS_YOU_MUST_TO_BE_LOGGED_TO_SENT_THE_EMAIL']?></div>
            <button class="contact__btn " <?/* onclick="open_send()" */?> ><?=$GLOBALS['ar_define_langterms']['MSG_CONTACTS_SEND_EMAIL']?></button>
            	<?
            }else{
            	?>
            <textarea class="contact__message" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_CONTACTS_TYPE_YOUR_TEXT']?>"></textarea>
            <button class="contact__btn contact__green-btn " onclick="send_msg()" ><?=$GLOBALS['ar_define_langterms']['MSG_CONTACTS_SEND_EMAIL']?></button>
            	<?
            }
            ?>
        </div>
    </section>
    
    
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
    
    
    <script>
    	function open_send(){
    		$('.contact__btn').addClass('contact__green-btn');
    		$('.contact__error').hide();
    		$('.contact__message').css('display','');
    		$('.contact__btn').attr('onclick','send_msg()');
    	}
    	function send_msg(){
    		var text = $('.contact__message').val();
    		
    		if(text == ''){
    			show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_NAPISHITE_CHTO-NIBUDI']?>');
    		}else{
    			$.ajax({
    				type: 'POST',
    				url: '<?=$CCpu->writelink(3)?>',
    				data: 'task=send_msg&text='+text,
    				success: function(msg){
    					if( $.trim(msg) == 'ok' ){
    						$('.contact__message').val('');
    					}
    					check_notifications();
    				}
    			})
    		}
    	}
    
        function setActive(btn){
            $('.forget span').toggleClass('active-color');
        }
    </script>
</body>
</html>