<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
		
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
    
    <div class="<?/* back-black */?>">
        <section  class="login success">
            <div class="login__wrapper reset_wrapper">
                <a href="index.html" class="login__close reset_close">
                    <img src="/images/icons/Group 453.png" alt="">
                </a>
                <!-- <div class="login__menu">
                    <a href="index.html" class="login__close_menu">
                        <img src="/images/icons/Group 453.png" alt="">
                    </a>
                    <a href="register.html" class="cabin">
                        <img src="/images/icons/log-mobile.png" alt="">
                    </a>
                </div> -->
                <div class="login__title">
                    <a href="<?=$CCpu->writelink(82)?>" class="log activ-colorgreen"><?=$GLOBALS['ar_define_langterms']['MSG_REG_LOG_IN']?></a>
                    <span></span>
                    <a href="<?=$CCpu->writelink(81)?>" class="reg activ-colorgrey"><?=$GLOBALS['ar_define_langterms']['MSG_REG_REGISTER']?></a>
                </div>
                

                
                    <img src="/images/icons/correct.png" alt="" class="reset__correct-img">
                
                <div class="reset__correct-title"><?=$GLOBALS['ar_define_langterms']['MSG_REG_EMAIL_WAS_SEND']?></div>
                <div class="reset__correct-subtitle"><?=$GLOBALS['ar_define_langterms']['MSG_REG_CHECK_YOUR_E-MAIL']?></div>
                
                
                <a href="<?=$CCpu->writelink(82)?>" class="backtologin"><?=$GLOBALS['ar_define_langterms']['MSG_REG_BACK_TO_LOG_IN']?></a>


                
            </div>
        </section>
        
    </div>
    
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
    
    <script>
        function setActivRing(){
            if ($('w') === hide()) {
            $('w').show();
            } else {
            $('w') === hide();
            }
        }
    </script>
</body>
</html>