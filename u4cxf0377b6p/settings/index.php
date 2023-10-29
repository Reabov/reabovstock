<?
include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/admin/header.php");
include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");

$ar_item = mysqli_query($db,"SELECT * FROM `ws_menu_admin` WHERE `id`='".$lmenu_act."' AND `active`='1'", $db);
while ( $item = mysqli_fetch_array($ar_item) )
{
    $access = explode(",", $item['access']);
    if( !empty($access) && $User->InGroup( $access ) ){
        ?>
        <h3 align="center"><img src="/<?=WS_PANEL?>/templates/admin/images/<?=$item['image']?>" hspace="7" alt="" border="0" align="absmiddle" /><?=$item['title']?></h3>
        <?
        echo $item['description'];
    }
}
?>
<?include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/admin/footer.php");?>