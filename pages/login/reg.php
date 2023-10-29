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
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
		
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
   	<div class="all__hr reg-hr"></div>
   
    <section  class="register">
        <div class="register__wrapper">
            <a href="<?=$CCpu->writelink(1)?>" class="register__close">
                <img src="/images/icons/Group 453.png" alt="">
            </a>
            <div class="register__menu">
                <a href="<?=$CCpu->writelink(1)?>" class="register__close_menu">
                    <img src="/images/icons/Group 453.png" alt="">
                </a>
                <a href="<?=$CCpu->writelink(81)?>" class="cabin">
                    <img src="/images/icons/log-mobile.png" alt="">
                </a>
            </div>
            <div class="register__title">
                <a href="<?=$CCpu->writelink(82)?>" class="log activ-colorgrey"><?=$GLOBALS['ar_define_langterms']['MSG_REG_LOG_IN']?></a>
                <span></span>
                <div class="forget vs"></div>
                <a href="<?=$CCpu->writelink(81)?>" class="reg activ-colorgreen"><?=$GLOBALS['ar_define_langterms']['MSG_REG_REGISTER']?></a>
            </div>

            

            <div action="" class="register__form">
            	<div>
            		<input type="text" id="fullname" class="fullname register__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_REG_FULL_NAME']?>">
            	</div>
                <div class="blocksel">
                    <!-- <div class="placeholder" data-text="Country">Country</div> -->
                    <input autocomplete="nope" id="country_search" class="register__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_REG_COUNTRY']?>" >
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
                	<input type="text" id="email" class="email register__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_REG_EMAIL']?>">
                </div>
                <div>
                	<input type="password" id="password" class="password register__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_REG_PASSWORD']?>">
                </div>
                <div>
                	<input type="password" id="re_password" class="password register__input" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_REG_CONFIRM_PASSWORD']?>">
                </div>
            </div>
            <button class="accept" id="accept_btn">
                <span class="a"><span class="s"></span></span>
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
            <a href="<?=$CCpu->writelink(1)?>" class="logo-black-mob logo-reg">
                <img src="/images/elements/logo/logo-black.svg" alt="">
            </a>
        </div>
    </section>
    
    
    
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
    
    <script>
    	
    	$('#country_search').on('focus',function(){
    		$('.register__select').addClass('hard_open');
    		$('.register__select').addClass('open');
    		//$('#country').focus();
    	})
    	$('#country_search').keyup(function(){
    		var v = $(this).val();
    		
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=get_countries&search='+v,
    			success: function(msg){
    				$('.country_select_block').html(msg);
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
    				
    				$('.register__select').addClass('hard_open');
    				$('.register__select').addClass('open');
    			}
    		})
    	})
    	
    	$(document).on('click',function(e) {
        	if (!$('.register__select').is(e.target) && $('.register__select').has(e.target).length === 0 
        		&& !$('#country_search').is(e.target) && $('#country_search').has(e.target).length === 0 ) {
            	$('.register__select').removeClass('hard_open');
            	$('.register__select').removeClass('open');
        	}
        	if($('.register__select.hard_open').is(e.target)){
        		$('.register__select').removeClass('hard_open');
    			$('.register__select').removeClass('open');
        	}
		})
    	
    	function select_country(){
    		$('.register__select').addClass('open');
    		$('.register__select').removeClass('hard_open');
    		//var v = $(this).val();
    		var id = $('#country').val();
    		var v = $('.register__select.nice-select').find('.option.selected').text();
    		v = $.trim(v);
    		
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=get_countries&search='+v,
    			success: function(msg){
    				$('.country_select_block').html(msg);
    				$('.nice-select').niceSelect();
    				$('.nice-select list').scrollLeft('100');
    				
    				$('#country').val(id);
    				$('.register__select').addClass('checked');
    				check_reg_values();
    			}
    		});
    		
    		$('#country_search').val(v);
    	}
    	
    	
    
    	function check_reg_values(){
    		var check_name = $('#fullname').hasClass('checked');
    		var check_email = $('#email').hasClass('checked');
    		var check_pass = $('#password').hasClass('checked');
    		var check_re_pass = $('#re_password').hasClass('checked');
    		var check_country = $('.register__select').hasClass('checked');
    		var check_accept = $('#accept_btn').find('.s').hasClass('s-activ');
    		
    		if(check_name && check_email && check_pass && check_re_pass && check_country && check_accept){
    			$('.register__btn').prop('disabled',false);
    		}else{
    			$('.register__btn').prop('disabled',true);
    		}
    	}
    	
    	
    	
    	$('#fullname').keyup(function(){
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
    		check_reg_values();
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
    		check_reg_values();
    	})
    	
    	$('#re_password').keyup(function(){
    		var v = $(this).val();
    		if(v != ''){
    			var pass = $('#password').val();
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
    	
    	
    	$('#country').on('change',function(){
    		$('.register__select').addClass('checked');
    		check_reg_values();
    	})
    	
    	$('#accept_btn').on('click',function(){
        	$(this).find('.s').toggleClass('s-activ');
        	check_reg_values();
        })
    	
    	function register(){
    		var name = $('#fullname').val();
    		var email = $('#email').val();
    		var country_id = $('#country').val();
    		var password = $('#password').val();
    		
    		//console.log(name);
    		//console.log(email);
    		console.log(country_id);
    		//console.log(password);
    		
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=pre_reg&name='+name+'&email='+email+'&country_id='+country_id+'&password='+password,
    			success: function(msg){
    				console.log(msg);
    				if($.trim(msg) == 'ok'){
    					//show('На ваш электронный адрес отправлено письмо с подтверждением');
    					location.href = "<?=$CCpu->writelink(93)?>";
    				}else{
    					show_not(msg);
    				}
    			}
    		})
    		
    	}
    	
        // function selPlaceholder(block) {
        //     var placeholder = block.find('.placeholder'),
        //         select = block.find('select');
        //     placeholder.text(placeholder.attr('data-text') + select.find('option:selected').text());
        //     }

            // $('.block').each(function() {
            // selPlaceholder($(this));
            // });

            // $('.block select').on('change', function() {
            // selPlaceholder($(this).closest('.block'));
            // });
            
        
        
        
        function setAll1(){
            $('.ac1').children().toggleClass('s-activ');
            // $(btn).children('.a').children().toggleClass('s-activ');
            // $('.a').children().toggleClass('s-activ');
        }
        function setAll2(){
            $('.ac2').children().toggleClass('s-activ');
        }




       (function($){
            $(window).load(function(){

                $(".list").mCustomScrollbar({
                axis:"y",
                advanced:{autoExpandHorizontalScroll:true}, 
                callbacks:{
                    onOverflowY:function(){
                    var opt=$(this).data("mCS").opt;
                    if(opt.mouseWheel.axis!=="y") opt.mouseWheel.axis="y";
                    },
                    // onOverflowX:function(){
                    // var opt=$(this).data("mCS").opt;
                    // if(opt.mouseWheel.axis!=="x") opt.mouseWheel.axis="x";
                    // },
                }
                });

            });
		})(jQuery);





       $(document).ready(function() {
       $('.nice-select').niceSelect();
       $('.nice-select list').scrollLeft('100')
       });
       
    </script>
</body>
</html>