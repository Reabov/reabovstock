
<!DOCTYPE html>
<html>
	<head>
		<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
	</head>
	<body>
		<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
		
		<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
		
		<?//include($_SERVER['DOCUMENT_ROOT']."/lib/mobile_detect/Mobile_Detect.php")?>
		
		<?
		$f_video = $Db->getone("SELECT * FROM `ws_video` WHERE id = 1 ");
		$s_video = $Db->getone("SELECT * FROM `ws_video` WHERE id = 2 ");
		$s_video_link = $Db->getone("SELECT * FROM `ws_main_link` WHERE id = 1 ");
		?>
		
		<?
		//$detect = new Mobile_Detect;
		?>
		<style>
			.video_desc.video_1 {
				display: block;
			}
			.video_mob.video_1 {
				display: none;
			}
			@media(max-width: <?=$f_video['mob_size']?>px){
				.video_desc.video_1 {
					display: none;
				}
				.video_mob.video_1 {
					display: block;
				}
			}
		</style>
		<section class="promo">
        	<div class="promo__wrapper">
				<video class="video-homepage video_desc video_1" loop autoplay muted  playsinline >
					<source src="/upload/video/<?=$f_video['video']?>" type="video/mp4"></source>
            	</video>
            	<video class="video-homepage video_mob video_1" loop autoplay muted  playsinline >
            		<source src="/upload/video/<?=$f_video['mob_video']?>" type="video/mp4"></source>
            	</video>
        	</div>
    	</section>
		
		<form class="join" onsubmit="check_categories(); return false;" action="<?=$CCpu->writelink(77)?>">
        <div class="join__wrapper">
            <div class="join__title"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_JOIN_AND_DOWNLOAD']?></div>
            <div class="join__descr"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_FIND_AND_DOWNLOAD_A_THOUSANDS_HIGH_QUALITY_JEWELRY_3D_PRINTABLE_FILES']?></div>

        <div class="join__search">
            <div class="join__search_wrapper">
               <input id="search_tags" type="text" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_MAIN_SEARCH_3D_MODELS']?>" class="join__input">
               <span></span>
               <div class="tag_filtr_list_block">
               </div>
            </div>
            <button class="search__btn"><img src="/images/icons/search.png" alt=""></button>
        </div>
        
        <div class="join__list_wrapper">
            <?
            $categories = $Db->getall("SELECT * FROM `ws_categories` WHERE active = 1 ");
			//show(count($categories));
			
			$count_of_repet = count($categories)%5;
			$count_of_repet = count($categories)-$count_of_repet;
			$count_of_repet = $count_of_repet+5;
			//show($count_of_repet);
			for ($c=0; $c < $count_of_repet; $c+=5) {
				?>
			<div class="join__list_wr">
				<? //show($c); ?>
				<?
				for ($i=$c; $i < $c+5; $i++) {
					if($categories[$i] != array()){
						?>
				<a href="<?=$CCpu->writelink(77)?>?search=&categories=<?=$categories[$i]['id']?>" class="join__link join_<?=$categories[$i]['id']?>" data-id="<?=$categories[$i]['id']?>" >#<?=$categories[$i]['title_'.$CCpu->lang]?></a>		
						<?
					}
				}
				?>
			</div>
				<?
			}
			
            ?>
        </div>
        </div>
    	</form>
		
		
		
		<div class="join_mob-wr_space">
			<form class="join_mob-wr" onsubmit="check_categories(); return false;" action="<?=$CCpu->writelink(77)?>">
                <div class="filter_active_header">
                    <span href="" class="mobile_fiter_close" onclick="setFilterClose(this)">
                        <img src="/images/icons/Group 453.png" alt="">
                    </span>
                    <button  class="done_close" onclick="setFilterClose(this)"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_DONE']?></button>
                </div>
                <div class="filter_title"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_FILTER']?></div>
                <div class="filter_descr"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_SEARCH_BY_WORDS']?></div>
                <div class="filter_subdescr"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_ON_ALL_CATEGORIES_OR_JUST_ON_SELECTED']?></div>

                <div class="modal_tag_block">
                	<input type="text" class="mob_filter_search" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_MAIN_SEARCH_3D_MODELS']?>">
                	<div class="tag_filtr_list_block">
               		</div>
                </div>
                

                <div class="mob-list_wrapper">
                	<?
                	foreach ($categories as $key => $cat) {
                		?>
                	<a href="<?=$CCpu->writelink(77)?>?search=&categories=<?=$cat['id']?>" class="join-mob__link join_<?=$cat['id']?>" data-id="<?=$cat['id']?>" >#<?=$cat['title_'.$CCpu->lang]?></a>	
                		<?
                	}
                	?>
                </div>
                <div class="mob-fil-down">
                    <div class="mob-filter-hr"></div>
                    <button class="mob-filter-btn">
                        <img src="/images/icons/filter-grey.svg" alt="">
                    </button>
                </div>
			</form>
		</div>
		
		
		
		
		<section class="collection">
        <div class="collection__wrapper wr1420">
            <div class="collection__start">
                <div class="collection__title"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_JEWELRY_3D_MODELS_COLLECTION']?></div>
                <a href="<?=$CCpu->writelink(76)?>" class="collection__link">
                    <?=$GLOBALS['ar_define_langterms']['MSG_MAIN_EXPLORE_COLLECTIONS']?>
                    <span></span>
                </a>
            </div>

            <div class="container collection__item_wr">
                <div class="col-sm-12">
                    <div class="space-row-50 collection__row_wr">
                    	<?
                    	$top_col = $Db->getall("SELECT * FROM `ws_collections` WHERE active = 1 AND main = 1 ORDER BY sort DESC LIMIT 4 ");
						foreach ($top_col as $key => $col) {
							?>
						<div class="col-lg-3 col-sm-6 col-md-4 df">
                            <div class="collection__item">
                                <a href="<?=$CCpu->writelink(73,$col['id'])?>">
                                    <img src="/upload/collections/<?=$col['image']?>" alt="" class="collection__img">
                                </a>
                                <div class="collection__name">
                                	<a href="<?=$CCpu->writelink(73,$col['id'])?>">
                                		<?=$col['title_'.$CCpu->lang]?>
                                	</a>
                                </div>
                            </div>
                        </div>
							<?
						}
                    	?>
                    	<div class="col-lg-3 col-sm-6 col-md-4 df empty"></div>
                    	<div class="col-lg-3 col-sm-6 col-md-4 df empty"></div>
                    </div>
                </div>
            </div>
        </div>
            <div class="collection__wrapper-mob">
                <div class="collection__title"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_JEWELRY_3D_MODELS_COLLECTION']?></div>

                <div class="mobile-slider-wr">
                    <div class="mobile-slider">
                    	<?
                    	foreach ($top_col as $key => $col) {
                    		?>
                    	<div class="slide mobile-slide">
                            <a href="<?=$CCpu->writelink(73,$col['id'])?>">
                                <img src="/upload/collections/<?=$col['image']?>" alt="" class="collection__img">
                            </a>
                            <div class="collection-mob_name"><?=$col['title_'.$CCpu->lang]?></div>
                        </div>
                    		<?
                    	}
                    	?>
                    </div>
                    <div class="slider-nav">
                        <div class="slider-arrow mob-arrow"></div>
                    </div>
                </div>
                <a href="<?=$CCpu->writelink(76)?>" class="collection__link">
                    <?=$GLOBALS['ar_define_langterms']['MSG_MAIN_EXPLORE_COLLECTIONS']?>
                    <span></span>
                </a>
            </div>
    	</section>
    	
    	
    	<section class="sculptures">
        <div class="sculptures__wrapper wr1420 video_2_wrapper">
        	<style>
			.video_desc.video_2 {
				display: block;
			}
			.video_mob.video_2 {
				display: none;
			}
			@media(max-width: <?=$s_video['mob_size']?>px){
				.video_desc.video_2 {
					display: none;
				}
				.video_mob.video_2 {
					display: block;
				}
			}
			</style>
            <video class="video-homepage2 video_desc video_2" loop autoplay muted  playsinline>
            	<source src="/upload/video/<?=$s_video['video']?>" type="video/mp4"></source>
            </video>
            <video class="video-homepage2 video_mob video_2" loop autoplay muted  playsinline>
            	<source src="/upload/video/<?=$s_video['mob_video']?>" type="video/mp4"></source>
            </video>
                <div class="sculptures__container">
                    <div class="sculptures__title"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_3D_MODELS_SCULPTURES']?></div>
                    <div class="sculptures__descr"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_OBJ_AND_STL_FORMATS_PRINTABLE_AND_FOR_CUTTING_MACHINE_MODELS']?></div>
                    <a href="<?=$s_video_link['link_'.$CCpu->lang]?>" class="sculptures__link"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_EXPLORE']?></a>
                </div>
        </div> 
    	</section>
    	
    	
    	<section class="collection collection_main_page">
        <div class="collection__wrapper wr1420">
            <div class="collection__start">
                <div class="collection__title"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_JEWELRY_3D_MODELS']?> </div>
                <a href="<?=$CCpu->writelink(77)?>" class="collection__link">
                    <?=$GLOBALS['ar_define_langterms']['MSG_MAIN_EXPLORE_MORE']?>
                    <span></span>
                </a>
            </div>

            <div class="container collection__item_wr">
                <div class="col-sm-12">
                    <div class="space-row-50 collection__row_wr">
                    	<?
                    	$bottom_col = $Db->getall("SELECT * FROM `ws_collections` WHERE active = 1 AND next_main = 1 ORDER BY sort DESC LIMIT 4 ");
						foreach ($bottom_col as $key => $col) {
							?>
						<div class="col-lg-3 col-sm-6 col-md-4 df">
                            <div class="collection__item">
                                <a href="<?=$CCpu->writelink(73,$col['id'])?>">
                                    <img src="/upload/collections/<?=$col['image']?>" alt="" class="collection__img">
                                </a>
                            </div>
                            <div class="collection__name">
                            	<a href="<?=$CCpu->writelink(73,$col['id'])?>">
                            		<?=$col['title_'.$CCpu->lang]?>
                            	</a>
                            </div>
                        </div>	
							<?
						}
                    	?>
                    	<div class="col-lg-3 col-sm-6 col-md-4 df empty"></div>
                    	<div class="col-lg-3 col-sm-6 col-md-4 df empty"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="collection__wrapper-mob">
            <div class="collection__title"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_JEWELRY_3D_MODELS']?> </div>
    
            <div class="mobile-slider-wr2">
                <div class="mobile-slider2">
                    <?
                    foreach ($bottom_col as $key => $col) {
                    	?>
                    <div class="slide mobile-slide2">
                        <a href="<?=$CCpu->writelink(73,$col['id'])?>">
                            <img src="/upload/collections/<?=$col['image']?>" alt="" class="collection__img">
                        </a>
                        <div class="collection-mob2_name"><?=$col['title_'.$CCpu->lang]?></div>
                    </div>	
                    	<?
                    }
                    ?>
                </div>
                <div class="slider-nav2">
                    <div class="slider-arrow2 mob-arrow2"></div>
                </div>
            </div>
    
            <a href="<?=$CCpu->writelink(77)?>" class="collection__link">
                <?=$GLOBALS['ar_define_langterms']['MSG_MAIN_EXPLORE_MORE']?>
                <span></span>
            </a>
        </div>
    	</section>



    	<section class="subscription">
        <div class="subscription__wrapper wrapper_hr">
        	<div class="subscribe_wrapper_line"></div>
            <div class="subscription__title">
                <?=$GLOBALS['ar_define_langterms']['MSG_MAIN_GET_A_SUBSCRIPTION_NOW_AND_START_DOWNLOAD']?> 
            </div>
            <div class="subscription__descr">
                <?=$GLOBALS['ar_define_langterms']['MSG_MAIN_THOUSANDS_OF_JEWELRY_PRINTABLE_3D_MODELS']?> 
            </div>
            <div class="subscription__choice">
                <?=$GLOBALS['ar_define_langterms']['MSG_MAIN_SELECT_YOUR_PLAN_AND_START_DOWNLOAD_YOUR_3D_MODELS']?>
            </div>
            <a href="<?=$CCpu->writelink(79)?>" class="subscription__link">
                <?=$GLOBALS['ar_define_langterms']['MSG_MAIN_GET_A_PLAN']?>
            </a>
        </div>
    	</section>
		
		
		<section class="quest">
        <div class="quest__wrapper">
            <div class="quest__title"><?=$GLOBALS['ar_define_langterms']['MSG_MAIN_HAVE_SOME_QUESTIONS_FEEL_FREE_TO_CONTACT_US']?></div>
            <a class="quest__link"><?=$GLOBALS['ar_define_settings']['EMAIL']?></a>
        </div>
    	</section>
    	
    	<section class="social">
        <div class="social__wrapper">
            <div class="social__title">
                <?=$GLOBALS['ar_define_langterms']['MSG_MAIN_FOLLOW_US_ON_SOCIAL_MEDIA']?>
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
		
		
	
		
		<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
		
		<script>
		$('.join__input').keyup(function(){
			var v = $(this).val();
			$('.mob_filter_search').val(v);
			
			if(v.length >= 3){
				$.ajax({
					type: 'POST',
					url: '<?=$CCpu->writelink(3)?>',
					data: 'task=get_tag_list&search='+v,
					success: function(msg){
						console.log(msg);
						if($.trim(msg) != 'err'){
							$('.tag_filtr_list_block').html(msg);
							$('.tag_filtr_list_block').css('border','1px solid rgba(184,184,184,0.4)');
						}else{
							$('.tag_filtr_list_block').html('');
							$('.tag_filtr_list_block').css('border','');
						}
					}
				})
			}else{
				$('.tag_filtr_list_block').html('');
				$('.tag_filtr_list_block').css('border','');
			}
		});
		$('.mob_filter_search').keyup(function(){
			var v = $(this).val();
			$('.join__input').val(v);
			if(v.length >= 3){
				$.ajax({
					type: 'POST',
					url: '<?=$CCpu->writelink(3)?>',
					data: 'task=get_tag_list&search='+v,
					success: function(msg){
						if($.trim(msg) != 'err'){
							$('.tag_filtr_list_block').html(msg);
							$('.tag_filtr_list_block').css('border','1px solid rgba(184,184,184,0.4)');
						}else{
							$('.tag_filtr_list_block').html('');
							$('.tag_filtr_list_block').css('border','');
						}
					}
				})
			}else{
				$('.tag_filtr_list_block').html('');
				$('.tag_filtr_list_block').css('border','');
			}
		});
		
		$(document).click(function(e){
			if ($(e.target).closest(".tag_filtr_list_block").length) {
        		return;
    		}
    		
    		$(".tag_filtr_list_block").html('');
    		$(".tag_filtr_list_block").css('border','');
		})
		
        $('.join__link').on('click',function(){
    		var join_id = $(this).data('id');
    		$('.join_'+join_id).toggleClass('active');
    	});
    	$('.join-mob__link').on('click',function(){
    		var join_id = $(this).data('id');
    		$('.join_'+join_id).toggleClass('active');
    	});
    	
    	function select_tag(tag){
    		$('.mob_filter_search').val(tag);
    		$('.join__input').val(tag);
    		$(".tag_filtr_list_block").html('');
    		$(".tag_filtr_list_block").css('border','');
    	}
    	
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
        $(document).ready(function() {
            $('.mob-list_wrapper').scrollLeft('100')
        });
       


        /* function setFilterClose(){
            $('.join_mob-wr').hide();
        }
        function setFilter(){
            $('.join_mob-wr').show()
        } */
        
        /* $('.mobile-slider').slick({
        dots: false,
        infinite: true,
        speed: 1000,
        slidesToShow: 2,
        slidesToScroll: 1,
        appendArrows: '.slider-arrow',
        prevArrow: '<button class="slider-arrows arrowMobPrev"></button>',
        nextArrow: '<button class="slider-arrows arrowMobNext"></button>',
        responsive: [
            {
              breakpoint: 768,
              settings: {
                  arrows: true,
                  centerMode: true,
                  slidesToShow: 2,
              }
            },
            {
              breakpoint: 375,
              settings: {
                  arrows: true,
                  centerMode: true,
                  slidesToShow: 1,
              }
            }
        ]       
        });
        
        $('.mobile-slider2').slick({
        dots: false,
        infinite: true,
        speed: 1000,
        slidesToShow: 2,
        slidesToScroll: 1,
        appendArrows: '.slider-arrow2',
        prevArrow: '<button class="slider-arrows2 arrowMob2Prev"></button>',
        nextArrow: '<button class="slider-arrows2 arrowMob2Next"></button>',
        responsive: [
            {
              breakpoint: 768,
              settings: {
                  arrows: true,
                  centerMode: true,
                  slidesToShow: 2,
              }
            },
            {
              breakpoint: 375,
              settings: {
                  arrows: true,
                  centerMode: true,
                  slidesToShow: 1,
              }
            }
        ]    
        }); */
        
        function check_categories(){
        	var cat_arr = [];
        	
        	$('.join__link.active').each(function(k,v){
        		var cat_id = $(v).data('id');
        		cat_arr.push(cat_id);
        	});
        	
        	var cat_str = cat_arr.toString();
        	//console.log(cat_str);
        	var search = $('#search_tags').val();
        	//console.log(search);
        	
        	var search_link = '<?=$CCpu->writelink(77)?>'+'?search='+search+'&categories='+cat_str;
        	//console.log(search_link);
        	
        	location.href = search_link;
        }
        
    </script>
		
	</body>
</html>