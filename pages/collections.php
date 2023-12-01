<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
	
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
    
    <section class="promo">
    	<?
    	$col_video = $Db->getone("SELECT * FROM `ws_video` WHERE id = 3 ");
    	?>
        <div class="promo__wrapper">
        	<style>
			.video_desc.video_3 {
				display: block;
			}
			.video_mob.video_3 {
				display: none;
			}
			@media(max-width: <?=$col_video['mob_size']?>px){
				.video_desc.video_3 {
					display: none;
				}
				.video_mob.video_3 {
					display: block;
				}
			}
			</style>
            <video class="video-homepage video_desc video_3" loop autoplay muted preload playsinline>
            	<source src="/upload/video/<?=$col_video['video']?>" type="video/mp4"></source>
            </video>
            <video class="video-homepage video_mob video_3" loop autoplay muted preload playsinline>
            	<source src="/upload/video/<?=$col_video['mob_video']?>" type="video/mp4"></source>
            </video>
            <?/* <div class="promo__descr">Video Loop</div> */?>
        </div>
    </section>

    <div class="all__hr colpage1"></div>

    <section class="collection collection-page">
        <div class="collectionpage__wrapper wr1420">
            <div class="container collection__item_wr">
                <div class="col-sm-12">
                    <div class="space-row-20 collection__row_wr row-colpage">
                        <?
                        $col_list = $Db->getall("SELECT * FROM `ws_collections` WHERE active = 1 ORDER BY sort DESC ");
						foreach ($col_list as $key => $col) {
							?>
						<div class="col-lg-3 col-sm-4 col-md-4 col-xs-6 df">
                            <div class="collection__item">
                                <a href="<?=$CCpu->writelink(73,$col['id'])?>">
                                    <img src="/upload/collections/<?=$col['image']?>" alt="" class="collection__img">
                                </a>
                                <a href="<?=$CCpu->writelink(73,$col['id'])?>">
                                	<div class="collection__name"><?=$col['title_'.$CCpu->lang]?></div>
                                </a>
                            </div>
                        </div>	
							<?
						}
                        ?>
                        <div class="col-lg-3 col-sm-4 col-md-4 col-xs-6 df"></div>
                        <div class="col-lg-3 col-sm-4 col-md-4 col-xs-6 df"></div>
                        <div class="col-lg-3 col-sm-4 col-md-4 col-xs-6 df"></div>
                        <div class="col-lg-3 col-sm-4 col-md-4 col-xs-6 df"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <div class="all__hr colpage"></div>
    
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
    
</body>
</html>