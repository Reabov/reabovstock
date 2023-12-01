<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
		
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
    
    <div class="all__hr"></div>
    
            <div class="accordion">
                <div class="accordion__item filter__item-acordion">
                    <div class="accordion__title accordion__fil-title accordion-active" style="padding-right: 0;">
                        <?/* <div class="accordion__arrow accordion__fil-arrow">
                            <span class="accordion__arrow-item">
                                <img src="/images/icons/green-fil-arrow.png" alt="">
                            </span>
                        </div>  */?>
                        <div class="title-wr title-wr-filter">
                        	<?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_FILTERS']?>
                        </div>
                    </div>
                    <div class="accordion__content" style="display: block;">
                    	<form class="join"  onsubmit="check_categories(); return false;" action="<?=$CCpu->writelink(77)?>">
                                <div class="join__wrapper">
                        
                                <div class="join__search">
                                    <div class="join__search_wrapper">
                                       <input id="search_tags" value="<?=$_GET['search']?>" type="text" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_SEARCH_3D_MODELS']?>" class="join__input">
                                       <span></span>
                                    </div>
                                       <button class="search__btn"><img src="/images/icons/search.png" alt=""></button>
                                </div>
                                
                                <div class="join__list_wrapper">
            <?
            $filtr_cat = array();
			if(isset($_GET['categories']) && $_GET['categories'] != ''){
				$filtr_cat = explode(',', $_GET['categories']);
			}
			
            $categories = $Db->getall("SELECT * FROM `ws_categories` WHERE active = 1 ");
            
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
				<a href="<?=$CCpu->writelink(77)?>?search=&categories=<?=$categories[$i]['id']?>" class="join__link join_<?=$categories[$i]['id']?> <? if(in_array($categories[$i]['id'], $filtr_cat)){?> active <?} ?>" data-id="<?=$categories[$i]['id']?>" >#<?=$categories[$i]['title_'.$CCpu->lang]?></a>		
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
                	</div>
                </div>

               
                
                
            </div>

    
    <div class="join_mob-wr_space">
    	<form class="join_mob-wr" onsubmit="check_categories(); return false;" action="<?=$CCpu->writelink(77)?>">
        	<div class="filter_active_header">
            	<span class="mobile_fiter_close" onclick="setFilterClose(this)">
                	<img src="/images/icons/Group 453.png" alt="">
            	</span>
            	<button class="done_close" onclick="setFilterClose(this)"><?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_DONE']?></button>
        	</div>
        	<div class="filter_title"><?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_FILTER']?></div>
        	<div class="filter_descr"><?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_SEARCH_BY_WORDS']?></div>
        	<div class="filter_subdescr"><?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_ON_ALL_CATEGORIES_OR_JUST_ON_SELECTED']?></div>

        	<input type="text" class="mob_filter_search" value="<?=$_GET['search']?>" placeholder="<?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_SEARCH_3D_MODELS']?>">

        	<div class="mob-list_wrapper">
            <?
                	foreach ($categories as $key => $cat) {
                		if($key < 20){
                			?>
                		<a href="<?=$CCpu->writelink(77)?>?search=&categories=<?=$cat['id']?>" data-id="<?=$cat['id']?>" class="join-mob__link join_<?=$cat['id']?> <? if(in_array($cat['id'], $filtr_cat)){?> active <?} ?>">#<?=$cat['title_'.$CCpu->lang]?></a>	
                			<?
                		}
                		
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
    
    
    
    <?
    switch($pageData['page_id']){
		case '77':
			$query = "SELECT * FROM `ws_categories_elements` WHERE active = 1 ";
			break;
		case '78':
			$query = "SELECT * FROM `ws_categories_elements` WHERE active = 1 AND section_id = ".$pageData['elem_id'];
			break;
    }
	$where_cat = "";
	$get_cat = explode(',', $_GET['categories']);
	foreach ($get_cat as $key => $cat_id) {
		if($key == 0){
			$where_cat = $where_cat." section_id = '$cat_id' OR section_id LIKE '$cat_id,%' OR section_id LIKE '%,$cat_id' OR section_id LIKE '%,$cat_id,%' ";
		}else{
			$where_cat = $where_cat." OR section_id = '$cat_id' OR section_id LIKE '$cat_id,%' OR section_id LIKE '%,$cat_id' OR section_id LIKE '%,$cat_id,%' ";
		}
	}
	
	if(isset($_GET['categories']) && $_GET['categories'] != ''){
		//$query = $query . " AND section_id IN (".$_GET['categories'].")";
		$query = $query." AND (".$where_cat.")";
	}
	
	if(isset($_GET['search']) && $_GET['search'] != ''){
		$tags = $Db->getall("SELECT * FROM `ws_tags` WHERE title_".$CCpu->lang." LIKE '".$_GET['search']."' ");
		$elem_arr = array();
		foreach ($tags as $key => $tag) {
			$elem_arr[$tag['elem_id']] = $tag['elem_id'];
		}
		
		$elem_arr = implode(',', $elem_arr);
		$query = $query . " AND id IN (".$elem_arr.") ";
	}
	
	
	$query = $query." ORDER BY sort DESC, id DESC ";
	$catalog = $Db->getall($query);
    ?>
    <section class="filter">
        <div class="filter__wrapper fil-wrap">
            <div class="container filter__container">
            	<input type="hidden" id="new_filtr_start" value="0">
                <div class="col-sm-12">
                    <div class="space-row-10 filter-row" id="product_filtr_space">
                    	<?
                    	foreach ($catalog as $key => $prod) {
                    		if($key >= 0 && $key < 20){
                    			?>
                    	<div class="col-lg-20 col-md-3 col-sm-4 col-xs-6 col_filter_prod">
                            <div class="filter__item">
                            	<?
                            	if($Client->auth){
                            		?>
                            	<a href="<?=$CCpu->writelink(74,$prod['id'])?>" class="filter__link">
                                    <img src="/upload/categories/products/<?=$prod['image']?>" alt="">
                                </a>
                            		<?
                            	}else{
                            		?>
                            	<a onclick="open_modal('login_space')" class="filter__link">
                                    <img src="/upload/categories/products/<?=$prod['image']?>" alt="">
                                </a>
                            		<?
                            	}
                            	?>
                            </div>
                        </div>		
                    			<?
                    		}
						}
                    	?>
                    </div>
                    	<?
                    	if(!$Client->auth){
                    		if(count($catalog) > 20){
                    			?>
                    	<div class="gardient"></div>
                    			<?
                    		}
                    		?>
                    		
                    		<?
                    	}
                    	?>
                </div>
            </div>
        </div>
    </section>
    
    <?
    if(!$Client->auth){
    	?>
    <div class="more" <?if(count($catalog) <= 20){?> style="margin-top: 104px;" <?}?>>
        <div class="for__more"><?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_FOR_MORE']?></div>
        <a onclick="open_modal('reg_space')" class="formore_link"><?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_REGISTER_NOW']?></a>
        <?/* <img src="/images/icons/smile.png" alt="" class="more__icons"> */?>
        <div class="for__more log_in"><a onclick="open_modal('login_space')">or Log in</a></div>
    </div>	
    	<?
    }else{
    	?>
    <div class="more more_empty">
    	<div class="more_empty_loader">
    		
    	</div>
    </div>
    	<?
    }
    ?>
    
    
    
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
    <script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
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
    
		$(window).scroll(function() {
        	var element = $('.accordion__content');
        	var scrollPosition = $(window).scrollTop();
        	
        	var position = $('.filter-row').find('.col_filter_prod').last();
        	var pos_top = position.offset().top;
        	pos_top = pos_top - 300;
        	
        	
        	if(scrollPosition > pos_top){
        		get_more_search();
        	}
        	
        	/* if (scrollPosition > 200) {
            	element.hide();
            	element.css({
        			'transition': 'opacity 0.5s ease 3s',
        		});
        	} */
        });
        <?
        if($Client->auth){
        	?>
        function get_more_search(){
        	
        	var start = $('#new_filtr_start').val();
        	start = start*1;
        	var new_start = start + 20;
        	
        	var query = '<?=$query?>';
        	var total_count = '<?=count($catalog)?>';
        	
        	if(start <= total_count){
        		$('.more_empty_loader').css('display','block');
        		$.ajax({
        			type: 'POST',
        			url: '<?=$CCpu->writelink(3)?>',
        			data: 'task=get_more_search&query='+query+"&start="+new_start,
        			success: function(msg){
        				$('#product_filtr_space').html(msg);
        				$('#new_filtr_start').val(new_start);
        				
        				//var pos_top = $('.footer').offset().top;
        				//$('html,body').animate({scrollTop:pos_top}, '200');
        				$('.more_empty_loader').css('display','none');
        			}
        		});
        	}
        	
        }
        	<?
        }else{
        	?>
        function get_more_search(){}
        	<?
        }
        ?>
        
        
        


        $(document).ready(function() {
            $('.mob-list_wrapper').scrollLeft('100')
        });
       
       
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