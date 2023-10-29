<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
		
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
	
	<?
	$product = $Db->getone("SELECT * FROM `ws_categories_elements` WHERE id = ".$pageData['elem_id']);
	if($product['type'] == '0'){
		$sizes = $Db->getall("SELECT * FROM `ws_categories_elements_size` WHERE elem_id = ".$product['id']." ORDER BY sort DESC ");
	}else{
		$variations = $Db->getall("SELECT * FROM `ws_categories_variation` WHERE section_id = ".$product['id']);
	}
	$tags = $Db->getall("SELECT * FROM `ws_tags` WHERE elem_id = ".$product['id']);
	$gallery = $Db->getall("SELECT * FROM `ws_photogallery` WHERE elem_id = ".$product['id']." ORDER BY sort DESC ");
	?>
    
   <div class="all__hr product__hr-mob"></div>
    <section class="product">
        <div class="product__wrapper">
            <div class="product__descrip_title-mob"><?=$product['title_'.$CCpu->lang]?></div>
            <div class="product__descrip_descr-mob"><?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_AVAILABLE_FORMATS']?></div>
            <div class="product__descrip_subdescr-mob"><?=$product['format']?></div>
            <div class="product__start_wr">
                <div class="product-for">
                    <div class="slide  large">
                        <a onclick="get_carusel('<?=$product['id']?>')">
                            <img id="large_img" src="/upload/gallery/<?=$gallery[0]['image']?>" alt="">
                        </a>
                    </div>
                </div>
                <div class="product-nav">
                	<?
                	foreach ($gallery as $key => $gal) {
						?>
					<div class="slide small" onclick="change_nav_slide($(this))" data-src="/upload/gallery/<?=$gal['image']?>" >
                        <img src="/upload/gallery/<?=$gal['image']?>" alt="">
                    </div>
						<?
					}
                	?>
                </div>
                
            </div>
            <div class="product__descrip_wr">
               <div class="desprip__wrapper">
                <div class="product__descrip_title"><?=$product['title_'.$CCpu->lang]?></div>
                <div class="product__descrip_descr"><?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_AVAILABLE_FORMATS']?></div>
                <div class="product__descrip_subdescr <?if($product['type'] == '1'){?>ext<?}else{?>standart<?}?> "><?=$product['format']?></div>

                <?
                if($product['type'] == '1'){
                	?>
                <div class="product__descrip_select_title">
                	<?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_SELECT_VARIATION']?>
                </div>
                <div class="product__descrip_select_wr">
                <?
                foreach ($variations as $key => $var) {
                    ?>
                    <button class="women" onclick="setChoice(this,'<?=$var['id']?>')"><?=$var['title_'.$CCpu->lang]?></button>
                    <?
                }
                ?>
                </div>	
                	<?
                }
                ?>
                <input id="var_id" value="0" hidden />
                
                
                <div class="product__descrip_select_size">
                    <?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_SELECT_SIZE_AND_CLICK_TO_DOWNLOAD']?>
                </div>
                <div class="select_size_wr">
                	<?
                	if($product['type'] == '0'){
                		foreach ($sizes as $key => $size) {
                			?>
                	<button class="size_btn" data-link="<?=$size['link_en']?>" data-id="<?=$size['id']?>" onclick="setChoiceSize(this,'/upload/categories/products/size/<?=$size['image']?>','<?=$size['id']?>')"><?=$size['title_'.$CCpu->lang]?></button>		
                			<?
                		}
                	}
                	?>
                </div>
                <input id="size_id" value="0" hidden />
                
                
                <button class="download__btn  <?if($product['type'] == '1'){?>ext<?}else{?>standart<?}?> " onclick="download('<?=$product['link_'.$CCpu->lang]?>')" ><?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_DOWNLOAD']?></button>
               </div>

                <div class="tags__wrapper">
                    <div class="product__descrip_tags">
                        <div class="product__descrip_tags_title"><?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_TAGS']?></div>
                        <div class="product__descrip_tags_hr"></div>
                    </div>
                    <div class="product__descrip_tags_choice">
                    	<?
                    	$cat_arr = explode(',',$product['section_id']);
						foreach ($cat_arr as $key => $cat) {
							$category = $Db->getone("SELECT * FROM `ws_categories` WHERE id = ".$cat);
							if($category != array()){
								?>
						<div onclick="location.href='<?=$CCpu->writelink(77)?>?search=&categories=<?=$cat?>'" class="product__descrip_tags_item">#<?=$category['title_'.$CCpu->lang]?></div>		
								<?
							}
						}
						$collections = $Db->getall("SELECT * FROM `ws_collections_products` WHERE product_id = ".$product['id']);
						foreach ($collections as $key => $col) {
							$collection = $Db->getone("SELECT * FROM `ws_collections` WHERE id = ".$col['elem_id']);
							if($collection != array()){
								?>
						<div onclick="location.href='<?=$CCpu->writelink(73,$collection['id'])?>'" class="product__descrip_tags_item">#<?=$collection['title_'.$CCpu->lang]?></div>	
								<? 
							}
						}
                    	$title_tags = array();
                    	foreach ($tags as $key => $tag) {
                    		$title_tags[] = $tag['title_'.$CCpu->lang];
							?>
						<div onclick="location.href='<?=$CCpu->writelink(77)?>?search=<?=$tag['title_'.$CCpu->lang]?>&categories='" class="product__descrip_tags_item">#<?=$tag['title_'.$CCpu->lang]?></div>	
							<?
						}
                    	?>
                    </div>
                </div>


            </div>
           
        </div>
    </section>
    <div class="product__hr">
    	<span>
    		...
    	</span>
    </div>

    <section class="similar">
        <div class="similar__wrapper">
            <?
            			$same_products = array();
                        foreach ($tags as $key => $tag) {
                            $same_tags_prod = $Db->getall("SELECT * FROM `ws_tags` WHERE title_".$CCpu->lang." = '".$tag['title_'.$CCpu->lang]."' ");
							foreach ($same_tags_prod as $key => $same_prod) {
								$the_same_prod = $Db->getone("SELECT * FROM `ws_categories_elements` WHERE id = ".$same_prod['elem_id']);
								$counter = 0;
								$the_tags = $Db->getall("SELECT * FROM `ws_tags` WHERE elem_id = ".$same_prod['elem_id']);
								foreach ($the_tags as $key => $the_t) {
									$the_title = $the_t['title_'.$CCpu->lang];
									if(in_array($the_title, $title_tags)){
										$counter++;
									}
								}
								$same_products[$counter][$same_prod['elem_id']] = $the_same_prod;
							}
                        }
            ?>
            <div class="similar__title_mobwr">
                <div class="similar__mob-title"><?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_SIMILAR_MODELS']?></div>
                <!-- <button class="similar__mob-title-hide" style="display: none;"  onclick="setHideAll(this)">Hide all</button> -->
            </div>
            
            <div class="similar__title">
            	<?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_SIMILAR_MODELS_TITLE']?>
            </div>
            
            <div class="container similar__container">
                <div class="col-sm-12">
                    <div class="space-row-10 similar-row">
                        <?
						//show($same_products);
						
						//для максимального счётчика совпадений
						$total_tags = $Db->getall("SELECT DISTINCT title_".$CCpu->lang." FROM `ws_tags` ");
						$max_counter = count($total_tags);
						$last_counter = 0;
						$tlast_counter = 0;
						$tot_count = 0;
						//надо убрать систему see all и показывать только шесть похожих
						$max_counter = 6;
						for ($i=1; $i <= $max_counter; $i++) {
							$similar = $same_products[$i];
							foreach ($similar as $key => $similar_prod) {
								$tot_count++;
								$last_counter++;
								$tlast_counter++;
								?>
						<div class=" col-xs-4 col-md-2 col-lg-2 similar__item_block ">
                            <div class="similar__item">
                                <a href="<?=$CCpu->writelink(74,$similar_prod['id'])?>">
                                    <img src="/upload/categories/products/<?=$similar_prod['image']?>" alt="">
                                </a>
                            </div>
                        </div>		
								<?
								if($tlast_counter == 6){
									$tlast_counter = 0;
								}
								if($last_counter == 5){
									$last_counter = 0;
								}
							}
						}
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div id="carusel">
    	
    </div>
    
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
    
    <script>
        
        function see_more(){
        	$('.similar__item').parent().removeClass('similar_hide');
        	$('.similar_btn').remove();
        	$('#mob-title-more').remove();
        	square_img();
        }
        
        function square_img(){
        	$('.similar__item img').each(function(){
        		var w = $(this).width();
        		$(this).css('height',w+'px');
        	})
        }
        
        $(window).resize(function(){
        	square_img();
        })
        $(document).ready(function(){
        	square_img();
        })
        
        	/* $('.product-for').slick({
            infinite: true,
            slidesToShow: 1,
            slidesToScroll: 1,
            arrows: false,
            fade: true,
            asNavFor: '.product-nav'
           	}); */
            $('.product-nav').slick({
            infinite: true,
            slidesToShow: 4,
            slidesToScroll: 1,
            arrows: false,
            dots: false,
            centerMode: false,
            focusOnSelect: true
            });

            function setChoice(btn,id){
            	console.log(btn);
                $('.product__descrip_select_wr').children().removeClass('activ-colorgreenbor')
                $(btn).toggleClass('activ-colorgreenbor');
                $.ajax({
                	type: 'POST',
                	url: '<?=$CCpu->writelink(3)?>',
                	data: 'task=get_variations_sizes&var_id='+id,
                	success: function(msg){
                		$('.select_size_wr').html(msg);
                	}
                })
                $('#var_id').val(id);
            }
            function setChoiceSize(btn,src,id){
                $('.select_size_wr').children().removeClass('activ-colorgreenbor')
                $(btn).toggleClass('activ-colorgreenbor');
                var link = $(btn).data('link');
                $('.download__btn').attr('onclick',"download('"+link+"')");
                $('#large_img').attr('src',src);
                $('#size_id').val(id);
            }
            
            function change_nav_slide(the){
            	var src = the.data('src');
            	$('#large_img').attr('src',src);
            }
            
            function download(link){
            	var elem_id = '<?=$product['id']?>';
            	var var_id = $('#var_id').val();
            	var size_id = $('#size_id').val();
            	
            	
            	var err = 0;
            	
            	<?
            	if($client_subscribe == array()){
            		?>
            		err = 1;
            		location.href="<?=$CCpu->writelink(79)?>#prices";
            		return false;
            		<?
            	}
            	?>
            	
            	
            	<?
            	if($product['type'] == '1'){
            		?>
            		if(var_id == 0){
            			err = 1;
            			show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_VYBERITE_VARIACIYU']?>');
            		}
            		<?
            	}
            	?>
            	if(size_id == 0){
            		err = 1;
            		show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_VYBERITE_RAZMER']?>');
            	}
            	
            	
            	
            	
            	if(err == 0){
            		var a = document.createElement('a');
            		a.href = link;
            		a.id = 'download_link';
            		a.download = '<?=$product['title_'.$CCpu->lang]?>';
            		a.style.display = 'none';
            		
            		$.ajax({
            			type: 'POST',
            			url: '<?=$CCpu->writelink(3)?>',
            			data: {
            				'task':'add_download',
            				'client_id':'<?=$Client->id?>',
            				'product_id':elem_id,
            				'link':link
            			},
            			success: function(msg){
            				if($.trim(msg) == 'ok'){
            					$('.desprip__wrapper').append(a);
            					$('#download_link')[0].click();
            					$('#download_link').remove();
            				}else{
            					//show_not(msg);
            				}
            				check_notifications();
            			}
            		});
            	}
            	
            }
            
            function get_carusel(id){
            	
            	var src = $('#large_img').attr('src');
            	
            	$.ajax({
            		type: 'POST',
            		url: '<?=$CCpu->writelink(3)?>',
            		data: 'task=get_carusel&id='+id,
            		success: function(msg){
            			$('#carusel').css('opacity','0');
            			$('#carusel').css('display','block');
            			$('#carusel').html(msg);
            			
            			$('.carul-slider').slick({
        					dots: false,
        					infinite: true,
        					speed: 300,
        					slidesToShow: 1,
        					adaptiveHeight: true,
        					appendArrows: '.slider-arrow',
        					prevArrow: '<button class="slider-arrows arrowPrev"></button>',
        					nextArrow: '<button class="slider-arrows arrowNext"></button>'
        				});
            			
            			var index = 0;
            			$('.carul-slide').each(function(){
            				var the_src = $(this).find('.carul_img').attr('src');
            				
            				if(the_src == src){
            					index = $(this).data('slick-index');
            				}
            			})
            			
            			$('.carul-slider').slick('slickGoTo',index);
            			
            			
            			setTimeout(function(){
            				unscroll_body();
            				$('#carusel').css('opacity','1');
            			},350);
            			
            			
            		}
            	})
            }
            
            function close_carusel(){
            	$('#carusel').css('display','');
            	$('#carusel').css('z-index','');
            	rescroll_body();
            }
            
            
    		$(window).resize(function(){
    			if( $('#carusel').css('display') == 'block' ){
    				close_carusel();
    			}
    		})
            
    </script>



</body>
</html>

