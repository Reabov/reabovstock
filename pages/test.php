<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/whitefog.php")?>
		
	<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
	
    <section class="terms" style="min-height: 90vh;">
    	<div style="max-width: 1400px; padding: 0 1rem; padding-top: 70px; margin: 0 auto;">
    		<div style="margin-bottom: 1rem;">
    			<button onclick="open_modal('login_space')">
        			Log in
        		</button>
    		</div>
    		<div style="margin-bottom: 1rem;">
        		<button onclick="open_modal('reg_space')">
        			Reg
        		</button>
        	</div>
        	<div style="margin-bottom: 1rem;">
        		<button onclick="open_modal('forgot_space')">
        			Forgot
        		</button>
        	</div>
        	<div style="margin-bottom: 1rem;">
        		<button onclick="open_modal('success_space')">
        			Success
        		</button>
        	</div>
    	</div>
    </section>
    
    
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>
    <?/*include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/log_blocks.php")*/?>
</body>
</html>