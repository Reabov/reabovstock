<div class="modal_space pers <?/* back-black */?>">
    	 
    	
    
    
    
    
    <section  class="register modal_block pers" id="personal_space">
        <div class="register__wrapper">
            <?/* <a onclick="close_modal()" class="register__close">
                <img src="/images/icons/Group 453.png" alt="">
            </a> */?>
            <div class="register__menu" style="display: flex;justify-content:flex-end;margin-top: 20px;">
                <a onclick="close_modal_pers()" class="register__close_menu">
                    <img src="/images/icons/Group 453.png" alt="">
                </a>
                <?/* <a class="cabin">
                    <img src="/images/icons/log-mobile.svg" alt="">
                </a> */?>
            </div>
            
            
            <div class="area__wrapper">
            <div class="area__img-wr">
                <div class="u">
                     <?
                    if($client_info['image'] != ''){
                		?>
                	<img src="/upload/userfiles/images/<?=$client_info['image']?>" alt="pic" class="area__title_img2" >	
                		<?
                	}else{
                		?>
                	<img src="/upload/userfiles/images/default.jpg" alt="pic" class="area__title_img2" >	
                		<?
                	}
                    ?>
                </div>
            </div>
            <div class="area__name"><?=$client_info['full_name']?></div>

            <div class="area__choice_wr">
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
        	
        	<?/* <a href="<?=$CCpu->writelink(1)?>" class="logo-black-mob logo-reg">
                <img src="/images/elements/logo/logo-black.svg" alt="">
         	</a> */?>
        	
        </div>
    </section>
    
    
    
  
    	
    	
    	
</div>
    
    <script>
    	function open_modal_pers(){
    		$('.modal_block.pers').css('display','none');
    		$('.modal_space.pers').css('display','flex');
    		$('#personal_space').css('display','block');
    		unscroll_body();
    	}
    	function close_modal_pers(){
    		$('.modal_block.pers').css('display','none');
    		$('.modal_space.pers').css('display','none');
    		rescroll_body();
    	}
    </script>
    
    
    
    
    
    
    