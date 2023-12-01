<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
		
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
	
    <section class="terms">
        <div class="terms__wrapper">
            <div class="terms__title"><?=$page_data['title']?></div>
            <div class="terms__subtitle"><?=$page_data['meta_d']?></div>
            <div class="terms__text">
            	<?=$page_data['text']?>
            </div>
        </div>
    </section>

            
    
    

    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>

    <script>
        function setActive(btn){
            $('.accept span').toggleClass('active-color');
        }
    </script>
</body>
</html>