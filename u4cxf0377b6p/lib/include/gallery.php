
<?php

$_SESSION['photo_gallery_add_page'] = array();

// show( $_params);

$getparams = mysqli_query($db," SELECT * FROM ws_photogallery_params WHERE page_id = ".$_params['page_id']);
if( mysqli_num_rows($getparams)==0 ){
    echo getErrorMessage(array('text'=>'Нет записи для настроек галлереи к данной странице page_id: ' . $_params['page_id']));
}
else {
?>

    <script>
                            
	function del(elem)
	{
	    if( !confirm('<?=$GLOBALS['CPLANG']['DELETE_IMAGE_']?>') ){ 
	        return false;
	    }
	    var file = $(elem).parent().find('img').attr('src');
	    files = file.split('/');
	    file = files[files.length-1];
	    
	    $.ajax({
	       type: "POST",
	       url: "/<?=WS_PANEL?>/ajax/",
	       data: "task=del&image="+file,
	       success: function(msg){
	         $(elem).parent().remove();
	       }
	     });
	    
	}
	
	
	function addfilegallery()
	{
	    // 728*476
	    var control = $("#addfile");
	    var fileName = '';
	    if(control[0].files.length > 0 ){
	        var maxSize = 15*1024*1024;
	        if( control[0].files[0].size > maxSize ){
	            alert('Error size img');
	            return false;
	        }else{
	            
	            $('#galleryloader').show();
	            $('#addfile').fadeOut(300);
	            
	            var form = new FormData();
	            
	            for( a=0;a<control[0].files.length;a++ ){
	                form.append("file"+a, control[0].files[a]);
	            }
	            form.append("task", "addfilesingallery");
	            form.append("elem_id", "<?=(int)$id?>");
	            form.append("page_id", "<?=$_params['page_id']?>");
	            // отправляем через xhr
	            var xhr = new XMLHttpRequest();
	            xhr.onload = function(event) {
	                files = event.srcElement.response;
	                filesArray = files.split(',');
	                filesArray.forEach(function(item, i, arr){
	                    $('#filelist').append('<span class="itemgallery"><delete onclick="del(this)"></delete><img src="/upload/gallery/thumb/'+item+'"></span>');
	                });
	                $('#galleryloader').hide();
	                $('#addfile').fadeIn(300);
	                
	            };
	            xhr.open("post", "/<?=WS_PANEL?>/ajax/", true);
	            xhr.send(form);
	            
	            
	        }
	    }
	}
	</script>

	<style>
		.gallery_sort input {
			max-width: 100px;
		}
		.gallery_sort span {
			height: 24px;
			line-height: 24px;
			padding: 0 10px;
		}
	</style>

	<div class="form-group">
        <label class="col-sm-2"> <?=$GLOBALS['CPLANG']['CURRENT_IMAGES']?> </label>
        <div class="col-sm-10" id="filelist">
            <?
            $getCurrentImages = mysqli_query($db, "SELECT * 
            	FROM ws_photogallery 
            	WHERE page_id = ".$_params['page_id']." 
            	AND elem_id = ".$id." ORDER BY sort DESC ");
				
            while($cImage = mysqli_fetch_assoc($getCurrentImages)){
                ?>
                <span class="itemgallery">
                    <delete onclick="del(this)"></delete>
                    <img src="/upload/gallery/thumb/<?=$cImage['image']?>" />
                    <div class="gallery_sort">
                    	<input id="gallery_sort_<?=$cImage['id']?>" type="number" value="<?=$cImage['sort']?>" >
                    	<span class="btn btn-info" onclick="save_sort_image('<?=$cImage['id']?>')" >
                    		save
                    	</span>
                    </div>
                </span>
                <?
            }
            ?>
        </div>
    </div>
    
    <script>
    	function save_sort_image(id){
    		var sort = $('#gallery_sort_'+id).val();
    		
    		$.ajax({
    			type: 'POST',
    			url: '/<?=WS_PANEL?>/ajax/',
    			data: 'task=save_sort_image&id='+id+'&sort='+sort,
    			success: function(msg){
    				
    			}
    		})
    		
    	}
    </script>
    
    <?
	$gal_params = mysqli_fetch_assoc($getparams);
    ?>
    <div class="form-group">
        <label class="col-sm-2"> <?=$GLOBALS['CPLANG']['ADD_IMAGE_GALLERY']?> (<?=$gal_params['image_width']?>x<?=$gal_params['image_height']?>) </label>
        <div class="col-sm-12">
            <input accept="images/*" type="file" multiple id="addfile" onchange="addfilegallery()" />
            <div>
                <div class="docloader" id="galleryloader"></div>
            </div>
        </div>
    </div>
    
<?php
} ?>