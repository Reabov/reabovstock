<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
include("settings.php");
if (isset($_GET['id'])) {$id = (int)$_GET['id'];} 

if( $User->InGroup($_params['access']) ){
	
    include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");

    if ( !isset($id) ):?>
       <?=$GLOBALS['ar_define_langterms']['MSG_ADM_NODATAFOREDIT']?>
    <?else:        
        $db_element = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE id='".$id."'");
        if ( $ElemParent = mysqli_fetch_assoc($db_element) ){ 
        ?>
	        <div class="content-wrapper">
	
	            <section class="content-header">
	                <div class="btn-group backbutton">
	                    <a class="btn btn-block btn-info btn-xs" href="list_elem.php?id=<?=$id?>"><?=$GLOBALS['CPLANG']['GO_BACK']?> (<?=$ElemParent['title_'.$Admin->lang]?>)</a>
	                </div>
	                
	                <div>
	                    <? 
                        if( isset( $_POST['ok'] ) ){
                            $ar_clean = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

                            $code = str_replace(" ", "_", $ar_clean['code']);
                            $code = $CCpu->translitURL($code);
                            $code = strtoupper($code);

                            $is_el = mysqli_query($db, "SELECT * FROM `".$_params['table']."` WHERE `code`='".$code."' ");
                            $el_count = mysqli_num_rows($is_el);

                            if( $el_count > 0 ){
                                ?>
                                <div class="alert alert-danger"> <?=$GLOBALS['CPLANG']['CODE']?> <?=$code?> <?=$GLOBALS['CPLANG']['EXISTS_WORD']?> </div>
                                <?
                                $el = mysqli_fetch_assoc( $is_el );
                                ?>
                                <div class="codeBlock">
                                    <div id="<?=uniqid()?>" class="php_code" style="padding: 5px;font-family: Consolas, Courier">
                                        <?echo"$";echo"GLOBALS['ar_define_langterms']['".$el['code']."']<br>";?>
                                    </div>

                                    <div id="<?=uniqid()?>" class="html_code" style="padding: 5px;font-family: Consolas, Courier">
                                        <?echo"&lt;?=$";echo"GLOBALS['ar_define_langterms']['".$el['code']."']?&gt;<br>";?>
                                    </div>

                                    <br>
                                    <div style="position: absolute;bottom: -5px;" class="notific">  </div>
                                </div>
                                <?
                            }else{

                                addElement($_params['table'], array('code'=>$code));

                                ?>
                                <div class="codeBlock">
                                    <div id="<?=uniqid()?>" class="php_code" style="padding: 5px;font-family: Consolas, Courier">
                                        <?echo"$";echo"GLOBALS['ar_define_langterms']['".$code."']<br>";?>
                                    </div>

                                    <div id="<?=uniqid()?>" class="html_code" style="padding: 5px;font-family: Consolas, Courier">
                                        <?echo"&lt;?=$";echo"GLOBALS['ar_define_langterms']['".$code."']?&gt;<br>";?>
                                    </div>

                                    <br>
                                    <div style="position: absolute;bottom: -5px;" class="notific">  </div>
                                </div>
                                <?
                            }

                            //addElement($_params['table']); show(mysql_error());
                        }
	                    ?>
	                </div>
	                
	                <h1><i><?//=$Elem['title_'.$Admin->lang]?></i></h1>
	            </section>
	
	            <section class="content">
	
	                <div class="row">
	                    <div class="col-xs-12">
								
                            <form method="post" enctype="multipart/form-data" onsubmit="return codevalidate()">
	                            <input type="hidden" name="section_id" value="<?=$id?>" />
	                            <div class="nav-tabs-custom">
	                                <div class="tab-content form-horizontal">
	                                	<div class="row form-group">
	                                   		<div class="col-lg-2 col-xs-12">
	                                   			<b> <?=$GLOBALS['CPLANG']['CODE']?> <span class="red">*</span></b>
	                                   		</div>
	                                   		<div class="col-lg-8 col-xs-12">
	                                   			<input required name="code" id="code" class="form-control" value="MSG_<?=$ElemParent['code']?>_" />
	                                   		</div>
	                                   </div>
	                                   <?
	                                   foreach ($Admin->langs as $keyLang=> $LangInfo) {
	                                       ?>
	                                       <div class="row form-group">
	                                       		<div class="col-lg-2 col-xs-12">
	                                       			<b><?=$LangInfo['title']?> <span class="red">*</span></b>
	                                       		</div>
	                                       		<div class="col-lg-8 col-xs-12">
	                                       			<textarea required class="form-control" name="title_<?=$keyLang?>"></textarea>
	                                       		</div>
	                                       </div>
	                                       <?
	                                   }
	                                   ?>
	                                   
	                                   <div class="row form-group">
	                                   		<div class="col-lg-2 col-xs-12">
	                                   			<b> <?=$GLOBALS['CPLANG']['COMMENT']?> </b>
	                                   		</div>
	                                   		<div class="col-lg-8 col-xs-12">
	                                   			<textarea class="form-control" name="comments"></textarea>
	                                   		</div>
	                                   </div>
	
	                                </div>
	                            </div>
	                            <div style="text-align: center">
	                                <input type="submit" class="btn btn-primary btn-lg" value="<?=$GLOBALS['CPLANG']['SAVE']?>" name="ok" />
	                            </div>
                            </form>
	
	                    </div>
	                </div>
	
	            </section>
	
	        </div>
              
          <?
        }
    endif;
}

include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");
?>