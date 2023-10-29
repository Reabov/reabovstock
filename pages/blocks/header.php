<?
if($Client->auth){
	$client_subscribe = $Db->getone("SELECT * FROM `ws_abonament_client` WHERE client_id = ".$Client->id." AND ab_end >= NOW() AND is_paid = 1 ");
}else{
    $client_subscribe = array();
}
?>
<div class="header">
        <div class="header__mobile" >
            <button class="burger" onclick="setMobileActive(this)">
                <img src="/images/icons/burger.svg" alt="">
            </button>
            <a href="<?=$CCpu->writelink(1)?>" class="logo-black">
                <img src="/images/elements/logo/logo-black.svg" alt="">
            </a>

            <?/* onclick="setAreaProfile(this)" */?>
            <a <? if($Client->auth){?> onclick="open_modal_pers()" <?}else{?> onclick="open_modal('login_space')" <?} ?> class="cabin">
                <img src="/images/icons/log-mobile.svg" alt="">
            </a>
            
            <div class="area__detals" >
                    <div class="area__detals_wr">
                        <a href="<?=$CCpu->writelink(80)?>" class="area__detals_link my_profile"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_MY_PROFILE']?></a>
                        <a href="<?=$CCpu->writelink(80)?>?section=download" class="area__detals_link"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_DOWNLOADS']?></a>
                        <a href="<?=$CCpu->writelink(80)?>?section=settings" class="area__detals_link"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_SETTINGS']?></a>
                        <a href="<?=$CCpu->writelink(80)?>?section=subscription" class="area__detals_link"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_SUBSCRIPTION']?></a>
                        <a href="<?=$CCpu->writelink(80)?>?section=notifications" class="area__detals_link heade_link_not">
                        	<div>
                        		<?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_NOTIFICATIONS']?>
                        		<span class="count_not"></span>
                        	</div>
                        </a>
                        <?/* <div class="area_hr"></div> */?>
                        <a href="<?=$CCpu->writelink(87)?>" class="area__detals_btn"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_LOG_OUT']?></a>
                    </div>
            </div>
            
        </div>

        <div class="header__mobile_active" >
            <div class="mobile_active_wr">
                <div class="mobile_active_header">
                    <button class="burger" > 
                        <?/* <img src="/images/icons/burger.png" alt=""> */?>
                    </button>
                    <button href="" class="" class="mobile_active_close" onclick="setMobileClose(this)">
                        <img src="/images/icons/Group 453.png" alt="">
                    </button>
                </div>

                <div class="header__mid-mob">
                    <a href="<?=$CCpu->writelink(75)?>" class="header__link <?if($pageData['page_id'] == 78){?> active_mob <?}?> header__link_mob"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_ABOUT_US']?></a>
                    <a href="<?=$CCpu->writelink(79)?>" class="header__link <?if($pageData['page_id'] == 79){?> active_mob <?}?> header__link_mob <?if($client_subscribe == array()){?> prices <?}?>"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_PRICES']?>
                    	<?
                    	if($client_subscribe == array()){
                    		?>
                    	<span><img src="/images/icons/Ellipse 20.png" alt=""></span>	
                    		<?
                    	}
                    	?> 
                        
                    </a>
                    <a href="<?=$CCpu->writelink(84)?>" class="header__link <?if($pageData['page_id'] == 84){?> active_mob <?}?> header__link_mob"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_CONTACT_US']?></a>
                    <?
                    if($Client->auth){
                    	?>
                    <a href="<?=$CCpu->writelink(77)?>" class="header__link <?if($pageData['page_id'] == 77){?> active_mob <?}?>"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_3D_MODELS']?></a>
                    	<?
                    }
                    ?>
                    
                </div>
                <a href="<?=$CCpu->writelink(1)?>" class="logo-black-mob">
                    <img src="/images/elements/logo/logo-black.svg" alt="">
                </a>
            </div>
        </div>
        
        
        <div class="header__wrapper <?if($Client->auth){?> wrap_log <?}?>"> 
            <div class="header__start">
                <a href="<?=$CCpu->writelink(1)?>" class="logo-black">
                    <img src="/images/elements/logo/logo-black.svg" alt="">
                </a>
            </div>
            <div class="header__mid <? if($Client->auth){?> logged <?} ?>">
                <a href="<?=$CCpu->writelink(75)?>" class="header__link <?if($pageData['page_id'] == 75){?> active <?}?> "><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_ABOUT_US']?></a>
                <a href="<?=$CCpu->writelink(79)?>" class="header__link <?if($pageData['page_id'] == 79){?> active <?}?>  <?if($client_subscribe == array()){?> prices <?}?>"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_PRICES']?>
                	<?
                    	if($client_subscribe == array()){
                    	?> 
                    <span><img src="/images/icons/Ellipse 20.png" alt=""></span>
                    	<?
						}
                    ?>
                </a>
                <a href="<?=$CCpu->writelink(84)?>" class="header__link <?if($pageData['page_id'] == 84){?> active <?}?>"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_CONTACT_US']?></a>
                <?
                if($Client->auth){
                	?>
                <a href="<?=$CCpu->writelink(77)?>" class="header__link  <?if($pageData['page_id'] == 77){?> active <?}?>"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_3D_MODELS']?></a>	
                	<?
                }
                ?>
            </div>
            <?
            //тут должна быть проверка на логирование
            if($Client->auth){
            	$client_info = $Db->getone("SELECT * FROM `ws_clients` WHERE id = ".$Client->id);
            	?>
            <div class="header__end">
                <button class="area__btn" onclick="setAreaProfile(this)"><?=$client_info['full_name']?></button>
                <div class="area__img" onclick="setAreaProfile(this)">
                	<?
                	if($client_info['image'] != ''){
                		?>
                	<img src="/upload/userfiles/images/<?=$client_info['image']?>" alt="pic" >	
                		<?
                	}else{
                		/**/
                		?>
                	<img src="/upload/userfiles/images/default.jpg" alt="pic" >	
                		<?
                	}
                	?>
                    
                    <span class="count_not"></span>
                </div>
                
                
                <div class="area__detals" >
                    <div class="area__detals_wr">
                        <a href="<?=$CCpu->writelink(80)?>" class="area__detals_link my_profile"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_MY_PROFILE']?></a>
                        <a href="<?=$CCpu->writelink(80)?>?section=download" class="area__detals_link"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_DOWNLOADS']?></a>
                        <a href="<?=$CCpu->writelink(80)?>?section=settings" class="area__detals_link"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_SETTINGS']?></a>
                        <a href="<?=$CCpu->writelink(80)?>?section=subscription" class="area__detals_link"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_SUBSCRIPTION']?></a>
                        <a href="<?=$CCpu->writelink(80)?>?section=notifications" class="area__detals_link heade_link_not">
                        	<div>
                        		<?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_NOTIFICATIONS']?>
                        		<span class="count_not"></span>
                        	</div>
                        </a>
                        <?/* <div class="area_hr"></div> */?>
                        <a href="<?=$CCpu->writelink(87)?>" class="area__detals_btn"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_LOG_OUT']?></a>
                    </div>
                </div>
            </div>
            	<?
            }else{
            	?>
            <div class="header__end">
                <a onclick="open_modal('login_space')" class="log-in"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_LOG_IN']?></a>
                <span></span>
                <a onclick="open_modal('reg_space')" class="registerlink"><?=$GLOBALS['ar_define_langterms']['MSG_BLOCKS_REGISTER']?></a>
            </div>	
            	<?
            }
            ?>
            
        </div>
        <div class="not_modal_wr" id="showed_not_block">
        	
        </div>
    </div>
    <?
    			$soc = $Db->getall("SELECT * FROM `ws_soc` ORDER BY id ASC ");
				$facebook = $soc[0];
				$facebook_link = $facebook['link_'.$CCpu->lang];
				$facebook_image = $facebook['image'];
				$facebook_image_act = $facebook['image_act'];
				$instagram = $soc[1];
				$instagram_link = $instagram['link_'.$CCpu->lang];
				$instagram_image = $instagram['image'];
				$instagram_image_act = $instagram['image_act'];
				$telegram = $soc[2];
				$telegram_link = $telegram['link_'.$CCpu->lang];
				$telegram_image = $telegram['image'];
				$telegram_image_act = $telegram['image_act'];
    ?>