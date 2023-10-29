<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if( $User->InGroup($_params['access']) ){
	include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
        ?>
        <div class="content-wrapper">
			<section class="content-header">
				<div class="btn-group backbutton">
					<a class="btn btn-block btn-info btn-xs" href="list_elem.php"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$_params['title']?>)</a>
				</div>

                <div class="both"></div>
				
				<div>
					<? 
					//обработка запроса
				    if( isset( $_POST['ok'] ) ){

				        updateElement($id, $_params['table']);

 
				    }

                    $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
                    $Elem = mysqli_fetch_array($db_element);

                    
					?>
				</div>
				
				<h1><i><?=$Elem['name']?></i></h1>
			</section>

			<section class="content">

				<div class="row">
					<div class="col-xs-12">
						<div class="">
							<form method="post" enctype="multipart/form-data">
							<div class="nav-tabs-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true"><?=$GLOBALS['CPLANG']['ALLADATA']?></a></li>
								</ul>
								
								<div class="tab-content form-horizontal">
								    
									<div class="tab-pane active" id="tab_1">
									    <div class="form-group">
                                            <label for="exampleInputEmail1" class="col-sm-3">Date</label><i><?=date("d.m.Y  H:i:s",strtotime($Elem['date']))?> </i>       
                                        </div>
					                    <div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3">Country</label><?=$Elem['country']?>
					                    </div>
					                    <div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3">Name</label><?=$Elem['name']?>        
					                    </div>
					                    <div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3">Surname</label><?=$Elem['surname']?>        
					                    </div>
					                    <div class="form-group">
                                            <label for="exampleInputEmail1" class="col-sm-3">Email</label><?=$Elem['email']?>        
                                        </div>
                                        <div class="form-group">
                                            <label for="exampleInputEmail1" class="col-sm-3">Complete message</label><?=$Elem['message']?>        
                                        </div>
									</div>

								</div>
            				</div>
            				
            				<?/* <div style="text-align: center">
								<input type="submit" class="btn btn-primary btn-lg" value="<?=$GLOBALS['CPLANG']['SAVE']?>" name="ok" />
							</div> */?>
							
            			</form>
					</div>
				</div>
			</div>
		</section>
	</div>
              
            <?
        
}

include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");
?>