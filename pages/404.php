<?
$Lang = $Main->GetDefaultLanguage();
$lang = $Lang['code'];
if(isset($_SESSION['last_lang']) && in_array($_SESSION['last_lang'], $CCpu->langList)){
    $lang = $_SESSION['last_lang'];
}

$CCpu->lang = $Main->lang = $lang;

$GLOBALS['ar_define_langterms'] = $Main->GetDefineLangTerms( $lang );
$defaultLinks['index'] = $CCpu->writelinkOne(1);
$page_404 = 0 ;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
		
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
    <div class="all__hr"></div>
    
    <section class="not_found">
        <div class="not_found__wrapper">
            <div class="not_found__title">
            	<?=$GLOBALS['ar_define_langterms']['MSG_NOT_FOUND_OPSS']?>
            </div>
            <div class="not_found__subtitle">
            	<?=$GLOBALS['ar_define_langterms']['MSG_NOT_FOUND_WE_GOT_A_PROBLEM_HERE_LET_US_KNOW_ABOUT_THIS_ERROR']?>
            </div>
            <div class="not_found__img">
            	<img src="/images/other/404.svg" >
            </div>
            <div class="not_found__lnk">
            	<a href="<?=$CCpu->writelink(84)?>" >
            		<button class="not_found__btn">
            			<?=$GLOBALS['ar_define_langterms']['MSG_NOT_FOUND_REPORT']?>
            		</button>
            	</a>
            </div>
            
            
        </div>
    </section>
    
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
</body>
</html>