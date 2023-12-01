<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
	
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
    
    
    <section class="promo">
        <div class="promo__wrapper">
        	<?
        	$col = $Db->getone("SELECT * FROM `ws_collections` WHERE id = ".$pageData['elem_id']);
			$col_products = $Db->getall("SELECT ws_collections_products.*, ws_categories_elements.sort 
												FROM `ws_collections_products` JOIN `ws_categories_elements` 
												ON ws_collections_products.elem_id = ws_categories_elements.id  
												WHERE ws_collections_products.elem_id = ".$col['id'].
												" ORDER BY ws_categories_elements.sort DESC ");
        	?>
            <video class="video-homepage" loop autoplay muted preload playsinline>
            	<source src="/upload/video_col/<?=$col['video']?>" type="video/mp4"></source>
            </video>
            <?/* <div class="promo__descr"><?=$col['sub_title_'.$CCpu->lang]?></div> */?>
        </div>
    </section>


    <section class="colproducts">
        <div class="colproducts__wrapper">
            <div class="colproducts__wr">
                <div class="colproducts__title"><?=$col['title_'.$CCpu->lang]?></div>
            	<div class="colproducts__descr">
            		<?=$col['text_'.$CCpu->lang]?>
            	</div>
            </div>
            <div class="container colproducts__item_wr">
                <div class="col-sm-12">
                    <div class="space-row-10 colproducts__row_wr">
                    	<?
                    	$col_prod_arr = $Db->getall("SELECT * FROM `ws_collections_products` WHERE elem_id = ".$pageData['elem_id']);
                    	foreach ($col_prod_arr as $key => $prod) {
                    		$product = $Db->getone("SELECT * FROM `ws_categories_elements` WHERE id = ".$prod['product_id']);
							if($product != array()){
								?>
						<div class="col-lg-20 col-sm-4 col-md-3 col-xs-6">
                            <div class="colproducts__item">
                                <a <? if($Client->auth){?> href="<?=$CCpu->writelink(74,$product['id'])?>" <?}else{?>  onclick="open_modal('login_space')" <?} ?> >
                                    <img src="/upload/categories/products/<?=$product['image']?>" alt="" class="colproducts__img">
                                </a>
                            </div>
                        </div>		
								<?
							}
                    	}
                    	?>
                    	<div class="col-lg-20 col-sm-4 col-md-3 col-xs-6"></div>
                    	<div class="col-lg-20 col-sm-4 col-md-3 col-xs-6"></div>
                    	<div class="col-lg-20 col-sm-4 col-md-3 col-xs-6"></div>
                    	<div class="col-lg-20 col-sm-4 col-md-3 col-xs-6"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="all__hr"></div>
    <section class="social colproducts__social">
        <div class="socia__wrapper">
            <div class="social__title">
                <?=$GLOBALS['ar_define_langterms']['MSG_CATALOG_FOLLOW_US_ON_SOCIAL_MEDIA']?>
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
    	function square_img(){
        	$('.colproducts__item img').each(function(){
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
    </script>
</body>
</html>