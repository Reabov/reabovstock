<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
include($_SERVER['DOCUMENT_ROOT']."/lib/libmail/libmail.php");
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
					$GLOBALS['ar_define_langterms'] = $Main->GetDefineLangTerms($CCpu->lang);
					
					//обработка запроса
				    if( isset( $_POST['ok'] ) ){
				        $ar_clean = filter_input_array(INPUT_POST,FILTER_SANITIZE_SPECIAL_CHARS);
				        $checkboxFields = array();
				        
				        $active = checkboxParam('active');
						//$countrye = checkboxParam('countrye');
						$elem_id = checkboxParam('elem_id');
						$checkboxFields['active'] = $active;	
						
						$exceptions[] = 'email';
				   		
						$exceptions[] = 'new_pass';
						$exceptions[] = 'old_pass';
						
				        $exceptions[] = 'oldimg';
						
						if($ar_clean['new_pass'] != ''){
							$password = hash('sha512', $ar_clean['new_pass']); 
        					$password = hash('sha512', $password.$GLOBALS['security_salt']);
						}else{
							$password = $ar_clean['old_pass'];
						}
					
				        // Файл           
				        if( isset($_FILES['image']['tmp_name']) && $_FILES['image']['tmp_name']!='' ){ 
				            $FileName = file_name(10, $_FILES['image']['name'] );
                            $uploadfile = $_SERVER["DOCUMENT_ROOT"]."/upload/userfiles/images/".$FileName;
                            //var_dump($FileName); die;
							
                            move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile);
				            unlink($_SERVER["DOCUMENT_ROOT"]."/upload/userfiles/images/".$ar_clean['oldfile']);
				            
				        }else{
				            $FileName = $ar_clean['oldimg'];
				        }
						$checkboxFields['image'] = $FileName;						
						
						$old_email = $Db->getone("SELECT * FROM `".$_params['table']."` WHERE id = ".$id);
						$old_email = $old_email['email'];
						if($old_email != $ar_clean['email']){
							$check_email = $Db->getone(" SELECT * FROM `".$_params['table']."` WHERE email = '".$ar_clean['email']."' ");
							if($check_email == array()){
								$email = $ar_clean['email'];
								
								$up = $Db->q("UPDATE `".$_params['table']."` SET activated = 0 WHERE id = ".$id);
								if($up){
									$logo_path = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].'/images/elements/logo/logo-black.png';
									
									$getSettings = mysqli_query($db, "SELECT `code`,`value` FROM ws_settings ");
									$Settings = mysqli_fetch_all($getSettings, MYSQLI_ASSOC);
									$Settings = array_column($Settings, 'value','code' );
									
									include_once WS_PANEL.'/lib/libmail/libmail.php';
									
									$Text =  <<<HTML
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" ></head>
<body><table border="0" cellpadding="0" cellspacing="0" style="max-width:600px !important;width: 100%;margin: 0 auto;" ><tbody>
<tr><td><table border="0" cellpadding="0" cellspacing="0" style="max-width: 600px !important;width: 100%;padding: 0 20px"><tr><td>
                        <img src="{$logo_path}" style="margin: 0 auto; display: block; margin-top: 50px; max-width: 565px; width: 100%;" alt="logo">
</td></tr></table></td></tr >
<tr ><td style="font-family: 'Tahoma';font-size: 50px;font-weight: 500;font-style: normal; text-transform: uppercase; text-align: center; padding-top: 88px; max-width: 434px; width: 100%;color: #000;">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_HI]} {$name}
</td></tr>
<tr><td colspan="2" ><table border="0" cellpadding="0" cellspacing="0"  style="width: 100%;max-width: 600px;"><tr><div style="font-size: 27px; font-weight: 300; text-align: center; color: #000;line-height: 38px; margin: 0 auto;font-family: 'Tahoma'">
			{$GLOBALS[ar_define_langterms][MSG_LETTER_CONFIRM_YOUR_EMAIL_TO_CONTINUE_YOUR_REGISTRATION]}
</div></tr></table></td></tr>
<tr><td colspan="2"><div style="font-family: 'Tahoma';font-size: 50px;font-weight: 500;max-width: 497px;margin: 0 auto;text-align: center;padding-bottom: 28px; padding-top: 47px; color: #44CE00; ">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_CONFIRM_EMAIL]}
</div></td></tr>
<tr><td colspan="2"><a href="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}{$CCpu->writelink(86)}?id={$client_id}" style="display: block; margin: 0 auto; text-align: center; text-decoration: none; max-width: 210px; width: 100%; padding: 10px 0; background-color: #44CE00; color: #fff;border-radius: 19px;font-size: 21px; font-weight: 500; font-family: 'Tahoma'">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_CLICK_HERE]}
</a></td></tr>
<tr><td colspan="2" style="font-size: 27px; font-weight: 500;color: #000; text-align: center;padding-top: 67px; padding-bottom: 13px; font-family: 'Tahoma'">
            {$GLOBALS[ar_define_langterms][MSG_LETTER_IF_BUTTON_DOESNT_WORK_CLICK_ON_LINK_BELLOW]}
</td></tr>
<tr><td colspan="2" style="font-size: 27px;color: #000; font-weight: 300; text-align: center; padding-bottom: 102px; font-family: 'Tahoma'">
        	{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}{$CCpu->writelink(84)} {$GLOBALS[ar_define_langterms][MSG_LETTER_EMAIL_CONFIRM_LEA_LEA_LEA]}
</td></tr>
<tr><td colspan="2" ><table  cellpadding="0" cellspacing="0" style="width: 100%;margin: 0 auto"><tr>
<td><a href="{$_SERVER[REQUEST_SCHEME]}://{$_SERVER[SERVER_NAME]}{$CCpu->writelink(1)}" style="text-decoration: none;font-size: 29px; font-weight: 300;color: #000;font-family: 'Tahoma'">
			{$_SERVER[SERVER_NAME]}
</a></td>
<td align="right" valign="bottom" style="font-size: 29px; font-weight: 300;color: #000;font-family: 'Tahoma'">
			{$GLOBALS[ar_define_langterms][MSG_LETTER_ALL_RIGHTS_C_2023]}
</td></tr></table></td></tr>
</tbody></table></body></html>
HTML;
									
									
    								$m= new Mail();
    								$m->From($Settings['SMTP_MAIL'] );
    								$m->To( $email );
    								$m->Subject( $GLOBALS['ar_define_langterms']['MSG_LETTER_YOU_EMAIL_WAS_CHANGED_ACTIVATE_IT_AGAIN'] );
    								$m->Body($Text, "html");
    								$m->Priority(4);
									//$m->Attach($_SERVER['DOCUMENT_ROOT'] ."/upload/mailer_pdf/".$filenameDoc);
    								$m->smtp_on($Settings['SMTP_SERVER'], $Settings['SMTP_MAIL'], $Settings['SMTP_PASS'], $Settings['SMTP_PORT']);
    								$m->log_on(true); // включаем лог, чтобы посмотреть служебную информацию
    								$a = $m->Send();
									
									if($a){
										?>
								<div class="alert alert-success">Email был изменён и было послано письмо со ссылкой на активацию</div>		
										<?
									}
								}
							}else{
								$email = $old_email;
								?>
								<div class="alert alert-danger">Email не был изменён, потому что новый емейл уже занят</div>
								<?
							}
						}else{
							$email = $ar_clean['email'];
						}
						
						
				        updateElement($id, $_params['table'], $checkboxFields, array(), array('email' => $email, 'password' => $password), $exceptions);				        		        
				    }

                    $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$_GET['id']."'");
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
									<li><a href="#tab_2" data-toggle="tab" aria-expanded="true">Abonament</a></li>
									
								</ul>
								
								<div class="tab-content form-horizontal">
								    
									<div class="tab-pane active" id="tab_1">
										<? editElem('active', $GLOBALS['CPLANG']['ACTIVE'], '3', $Elem, '', 'edit' ); ?>
					                    <? //editElem('main_page', "Вывести на главной", '3', $Elem, '', 'edit' ); ?>

					                    <div class="form-group">
					                        <label for="exampleInputEmail1" class="col-sm-3"><?=$GLOBALS['CPLANG']['CURRENT_IMAGE']?></label>
				                            <div class="col-sm-10">
				                            	<img style="max-width: 300px;" src="/upload/userfiles/images/<?=$Elem['image']?>" />  
				                            	<input type="hidden" name="oldimg" value="<?=$Elem['image']?>" />  
				                            </div>         
					                    </div>
					                    
					                    <? editElem('image', $GLOBALS['CPLANG']['CHANGE_IMAGE'].' (118X118)', '5', $Elem,  '', 'edit', 0, 6, '', ''); ?>
					                    <? //editElem('date', $GLOBALS['CPLANG']['DATE'], '6', $Elem, '', 'edit' ); ?>
					                    <? //editElem('sort', $GLOBALS['CPLANG']['SORT'], '1', $Elem,  '', 'edit', 1, 2 ); ?>					                 
					                    
									
										<div class="form-group">
                                            <label for="exampleInputEmail1" class="col-sm-3"> Registration Data </label>
                                            <div class="col-sm-7">
                                            	<i> <?=date( 'd.m.Y' , strtotime( $Elem['registration_date'] ) )?> </i>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3">User Country</label>
                                            <div class="col-sm-7">
                                            	<select class="form-control input-sm" name="elem_id" >
                                                	<?$getCountries = $Db->getall("SELECT * FROM ws_country WHERE active = 1 ORDER BY sort DESC ");?>
                                                    <? foreach ( $getCountries AS $k => $county ) { ?>
                                                    	<option value="<?=$county['id']?>" <?if($Elem['elem_id'] == $county['id']){echo 'selected';}?> ><?=$county['title_'.$CCpu->lang]?></option>
                                                	<? } ?>
                                            	</select>
                                            </div>
                                        </div>	
										<? editElem('full_name','Name', '1', $Elem,  '', 'edit', 1, 7 ); ?>
			                        	<? editElem('email', $GLOBALS['CPLANG']['EMAIL'], '1', $Elem,  '', 'edit', 1, 7 ); ?>
			                        	<? //editElem('password', 'Password', '1', $Elem,  '', 'edit', 1, 7 ); ?>
			                        	<div class="form-group">
                                            <label for="exampleInputEmail1" class="col-sm-3"> Change password </label>
                                            <div class="col-sm-7">
                                            	<input type="text" name="new_pass" value="" class="form-control input-sm">
                                            	<input name="old_pass" value="<?=$Elem['password']?>" hidden>
                                            </div>
                                        </div>	
			                        	
			                        </div>
			                        
			                        <div class="tab-pane" id="tab_2">
			                            <?
			                            $client_subscribe = $Db->getone("SELECT * FROM `ws_abonament_client` WHERE client_id = ".$id." AND is_paid = 1 ");
			                            if($client_subscribe == array()){
			                                ?>
			                             No abonement   
			                                <?
			                            }else{
			                                $active_client_subscribe = $Db->getone("SELECT * FROM `ws_abonament_client` WHERE client_id = ".$id." AND ab_end >= NOW() AND is_paid = 1 ");
			                                $get_ab = $Db->getone("SELECT * FROM `ws_abonament` WHERE id = ".$client_subscribe['ab_id']);
			                                if($active_client_subscribe == array()){
			                                    ?>
			                                 <h3>Expired</h3>
			                                 <hr>
			                                    <?
			                                }else{
			                                    $client_subscribe = $active_client_subscribe;
			                                }
			                                ?>
			                            <div class="form-group">
                                            <label class="col-sm-3"> Abonament </label>
                                            <?=$get_ab['title_en']?>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3"> Abonament price </label>
                                            <?=$get_ab['price']?>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3"> Start date </label>
                                            <?=date('Y-m-d',strtotime($client_subscribe['ab_start']))?>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3"> Expired term </label>
                                            <?=date('Y-m-d',strtotime($client_subscribe['ab_end']))?>
                                        </div>
                                        <div class="form-group">
                                            <label class="col-sm-3"> <span class="btn btn-danger" onclick="confirm_remove_ab('<?=$client_subscribe['id']?>')" ><i class="fa fa-close"></i></span> </label>
                                        </div>
			                                <?
			                                
			                            }
			                            
			                            ?>
			                        </div>   
			                    
									
								</div>
            				</div>
            				
            				<div style="text-align: center">
								<input type="submit" class="btn btn-primary btn-lg" value="<?=$GLOBALS['CPLANG']['SAVE']?>" name="ok" />
							</div>
							
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
<script>
    function confirm_remove_ab(id){
    	var check = confirm('<?=$GLOBALS['CPLANG']['SURE_TO_DELETE']?>');
    	if(check){
    		remove_ab(id);
    	}
    }
    function remove_ab(id){
        $.ajax({
            type: 'POST',
            url: '/<?=WS_PANEL?>/ajax/',
            data: 'task=remove_ab&id='+id,
            success: function(){
                location.reload();
            }
        })
    }
</script>