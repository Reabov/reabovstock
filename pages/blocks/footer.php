    <?
    //show($pageData);
    //show($_SERVER);
    //show($Client);
    //show($_COOKIE);
    //show($_SESSION);
    ?>
    <footer class="footer <?if($pageData['page_id'] == 80){?> footer__area <?}?>">
        <div class="footer__wrapper">
            <div class="part1">
                <div class="footer__start">
                    <a href="<?=$CCpu->writelink(1)?>" class="logo-white">
                        <img src="/images/elements/logo/logo-white.svg" alt="">
                    </a>
                </div>
                <span></span>
                <div class="footer__mid">
                    <a href="<?=$CCpu->writelink(79)?>" class="footer__link"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_PRICES']?></a>
                    <a href="<?=$CCpu->writelink(75)?>" class="footer__link"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_ABOUT_US']?></a>
                    <a href="<?=$CCpu->writelink(84)?>" class="footer__link"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_CONTACT_US']?></a>
                    <a href="<?=$CCpu->writelink(72)?>" class="footer__link"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_TERMS_AND_CONDITIONS']?></a>
                    <a href="<?=$CCpu->writelink(85)?>" class="footer__link"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_PRIVACY_POLICY']?></a>
                    
                </div>
                <?/* <span></span> */?>
            </div>
            <div class="part2">
                <div class="footer__mid-pay">
                    <img src="/images/other/visa.svg" alt="">
                    <img src="/images/other/master.svg" alt="">
                    <img src="/images/other/american.svg" alt="">
                    <img src="/images/other/paypal-logo-footer.svg" alt="">
                </div>
                <span></span>
                <div class="footer__end">
                    <div class="right"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_ALL_RIGHT_IS_RESERVED__2023']?></div>
                    <div class="designed">
                    	<span>
            				<?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_DESIGNED_BY_']?>
            			</span>
                    	<a href="<?=$GLOBALS['ar_define_settings']['FOOTER_LINK']?>">
                    		<?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_REABOV_STUDIO']?>
                    	</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    
<!--    --><?//
//    if(!isset($_SESSION['cookies'])){
//    	?>
<!--    <div class="cookies_space">-->
<!--    	<div class="cookies_block">-->
<!--    		<button class="cookies_close" onclick="hide_cookies()">-->
<!--    			<img src="/images/icons/Group 453.png" alt="">-->
<!--    		</button>-->
<!--    		<div class="cookies_title">-->
<!--    			--><?php //=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_WE_HAVE_A_COOKIES']?>
<!--    		</div>-->
<!--    		<div class="cookies_text">-->
<!--    			--><?php //=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_OUR_SITE_USING_COOKIES_FOR_BETTER_WORK_AND_YOUR_COMFORT']?><!-- -->
<!--    			<a href="--><?php //=$CCpu->writelink(85)?><!--">-->
<!--    				--><?php //=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_PRIVACY_POLICY']?>
<!--    			</a>-->
<!--    		</div>-->
<!--    		<div class="cookies_button">-->
<!--    			<button onclick="close_cookies()">-->
<!--    				--><?php //=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_ACCEPT']?>
<!--    			</button>-->
<!--    		</div>-->
<!--    	</div>-->
<!--    </div>-->
<!--    	--><?//
//    }
//    ?>
    

    <div class="scroll_up" onclick="scroll_up()">
        <div class="scroll_wr">
            <div class="scroll_back-item" onclick="history.back();" >
                <img class="icn_desc" src="/images/icons/arrow-back.png" alt="">
                <img class="icn_mob" src="/images/mob-back.png" >
                <span><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_BACK']?></span>
            </div>
            <div class="scroll_up-item">
                <img class="icn_desc" src="/images/icons/arrow-up.png" alt="">
                <img class="icn_mob" src="/images/mob-up.png" >
                <span><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_TOP']?></span>
            </div>
            <?
            if($pageData['page_id'] == 1 || $pageData['page_id'] == 77 || $pageData['page_id'] == 78){
            	?>
            <button class="scroll_filter" onclick="setFilter(this)">
                <img src="/images/icons/filter.svg" alt="">
            </button>	
            	<?
            }
            ?>
        </div>
    </div>
    <script src="/lib/jquery/jquery.2.2.2.js"></script>
    <script src="/lib/malihu-custom-scrollbar-plugin-master/jquery.mCustomScrollbar.concat.min.js"></script>
    <script src="/lib/nice-select/js/jquery.nice-select.min.js"></script>
    <script src="/lib/slick/slick.min.js"></script>
    
    <link href='https://fonts.googleapis.com/css?family=Open+Sans:400,600,300,700,800&subset=latin,cyrillic-ext,latin-ext,cyrillic' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" media="all" href="/lib/fa/css/font-awesome.min.css" />
    
    <script src="/lib/scroll_to/jquery.scrollTo.js"></script>

    <script src="/js/blocks.js"></script>
    
    <?
    if($pageData['page_id'] != 80){
    	?>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/log_blocks.php")?>	
    	<?
    }
	if($Client->auth){
		?>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/personal_block.php")?>	
		<?
	}
    ?>
    
    
    <?
    if(isset($_SESSION['paypal_msg'])){
    	?>
    <script>
    	$(document).ready(function(){
    		show_ext_not('<?=$_SESSION['paypal_msg']?>');
    	})
    </script>	
    	<?
		
    	unset($_SESSION['paypal_msg']);
    }
    ?>
    
    <script>
    	disableScroll = false;
		scrollPos = 0;
		
    	function show_ext_not(text){
    	    var session = '<?=$_SESSION['not_id']?>';
    	    var client_id = '<?=(int)$Client->id?>';
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=add_ext_notification_text&text='+text+'&session='+session+'&client_id='+client_id,
    			success: function(msg){
    				check_notifications();
    			}
    		});
    	}
    	function show_not(text){
    	    var session = '<?=$_SESSION['not_id']?>';
    	    var client_id = '<?=(int)$Client->id?>';
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=add_notification_text&text='+text+'&session='+session+'&client_id='+client_id,
    			success: function(msg){
    				check_notifications();
    			}
    		});
    	}
    	
    	function hide_cookies(){
    		$('.cookies_space').remove();
    	}
    	function close_cookies(){
    		$.ajax({
    			type: 'POST',
    			url: '<?=$CCpu->writelink(3)?>',
    			data: 'task=close_cookies',
    			success: function(msg){
    				$('.cookies_space').remove();
    			}
    		});
    	}
    	
    	$(document).ready(function(){
            check_scroll();
            check_notifications();
            setInterval(function(){
            	//check_notifications();
            },30000);
        })

        $(window).on('scroll',function(){
            check_scroll();
        })
        
        $(document).ready(function(){
        	play_video();
        	ios_play_video()
        })
        $(window).on('load', function() {
        	play_video();
		});
		
		function ios_play_video(){
			var btn = document.createElement('button');
			btn.id="btn_id";
			$('body').append(btn);
			$('#btn_id').text('test');
			$('#btn_id').attr('onclick','play_video()');
			$('#btn_id').trigger('click');
			$('#btn_id').remove();
		}
		
		function play_video(){
			if( $('video').length > 0 ){
        		$('video')[0].play();
        		$('video').attr('playsinline', true);
        		$('video').trigger('play');
        	}
		}

        function check_notifications(){
        	$.ajax({
        		type: 'POST',
        		url: '<?=$CCpu->writelink(3)?>',
        		data: 'task=get_count_header_notifications&client_id=<?=(int)$Client->id?>',
        		success: function(msg){
        			$('.count_not').text(msg);
        		}
        	})
        	$.ajax({
        		type: 'POST',
        		url: '<?=$CCpu->writelink(3)?>',
        		data: 'task=get_header_notifications&client_id=<?=(int)$Client->id?>',
        		success: function(msg){
        			console.log(msg);
        			$('#showed_not_block').css('display','none');
        			$('#showed_not_block').html(msg);
        			$('#showed_not_block').fadeIn();
        			
        			$('#showed_not_block_mob').css('display','none');
        			$('#showed_not_block_mob').html(msg);
        			$('#showed_not_block_mob').fadeIn();
        			
        			setTimeout(function(){
        				read_notification();
        			},3500);
        			
        		}
        	})
        }
        
        function read_notification(){
        	$.ajax({
        		type: 'POST',
        		url: '<?=$CCpu->writelink(3)?>',
        		data: 'task=read_header_notifications&client_id=<?=(int)$Client->id?>',
        		success: function(msg){
        			$('#showed_not_block').find('.not_modal').fadeOut();
        			$('#showed_not_block_mob').find('.not_modal').fadeOut();
        		}
        	})
        }
        
        
        function setCloseNotMod(btn,id){
            
            $.ajax({
            	type: 'POST',
            	url: '<?=$CCpu->writelink(3)?>',
            	data: 'task=show_notification&id='+id,
            	success: function(msg){
            		$(btn).parent().hide();
            	}
            })
            
        }
        

        function check_scroll(){
            var w = $(window).scrollTop();
            $('.scroll_up-item').css('display','block');
        }

        function scroll_up(){
            $('html,body').animate({scrollTop:0}, '500');
        }

        function setMobileActive(){
            $('.header__mobile_active').css('display','flex');
            unscroll_body();
        }

        function setMobileClose(){
            $('.header__mobile_active').hide();
            rescroll_body();
        }
        
        function setFilterClose(){
        	$('.join_mob-wr_space').removeClass('space_active');
            $('.join_mob-wr').hide();
            rescroll_body();
        }
        function setFilter(){
        	$('.join_mob-wr_space').addClass('space_active');
            $('.join_mob-wr').show();
            unscroll_body();
        }
        
        function setAreaProfile(){
            $('.area__detals').toggleClass('area-profile');
        }
        $(function() {
        	$('.team__modal__wr input, .team__modal__wr textarea').on('focus',function(){
        		if( $('.team__modal').css('display') == 'block' && $(window).width() < 420 ){
        			$('.team__modal__wr').css('padding-bottom','25vh');
        			$('body').css("position", "");
        			$(window).scrollTop(scrollPos);
        		}
        	})
        	$('.team__modal__wr input, .team__modal__wr textarea').on('focusout',function(){
        		if( $('.team__modal').css('display') == 'block' && $(window).width() < 420){
        			$('.team__modal__wr').css('padding-bottom','');
        			$('body').css("position", "fixed");
        		}
        	})
        	$('.modal_space input').on('focus',function(){
        		if( $('.modal_space').css('display') == 'flex' && $(window).width() < 420){
        			$('.modal_block').css('padding-bottom','25vh');
        			$('body').css("position", "");
        			$(window).scrollTop(scrollPos);
        		}
        	})
        	$('.modal_space input').on('focusout',function(){
        		if( $('.modal_space').css('display') == 'flex' && $(window).width() < 420){
        			$('.modal_block').css('padding-bottom','');
        			$('body').css("position", "fixed");
        		}
        	})
        	
        });
        
$(function() {
	
	/* $(".accordion__title").on("click", function(e) {
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
	}); */
    
    (function($){
            $(window).load(function(){
                $(".mob-list_wrapper").mCustomScrollbar({
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
    
});
    
$(function() {
	
	$(".accordion__title2").on("click", function(e) {
		e.preventDefault();
		var $this = $(this);
		if (!$this.hasClass("accordion-active2")) {
			$(".accordion__content2").slideUp(400);
			$(".accordion__title2").removeClass("accordion-active2");
		}
		$this.toggleClass("accordion-active2");
		$this.next().slideToggle();
		$('.accordion__arrow-item ',this).toggleClass('accordion__rotate');
	});
    
	
});

function unscroll_body(){
	$('body').css("overflow", "hidden");
	if( $(window).width() <= 400 ){}
	disableScroll = true;
	scrollPos = $(window).scrollTop();
	$('body').css("position", "fixed");
}
function rescroll_body(){
	$('body').css("overflow", "");
	$('body').css("position", "");
	disableScroll = false;
	$(window).scrollTop(scrollPos);
}

$(function(){
    $(window).bind('scroll', function(){
        if(disableScroll) $(window).scrollTop(scrollPos);
    });
    $(window).bind('touchmove', function(){
        $(window).trigger('scroll');
    });
});

        
        
        
    </script>
