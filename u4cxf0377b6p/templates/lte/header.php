<?
/**
 * Header for admin template
 *
 * @author       Cusnir Simion <cusnir.simion@webmaster.md>
 * @copyright    Copyright (c) 2015, Webmaster Studio, http://www.webmaster.md
 * @version      1.0 Date: 2015-06-20
 * @link         /ws/*.php
 */
//include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");

include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/include.php");
$skins = array(
    'skin-blue','skin-black','skin-purple','skin-yellow','skin-red','skin-green','skin-blue-light',
    'skin-black-light','skin-purple-light','skin-yellow-light','skin-red-light','skin-green-light');
if( isset($User->skin) && in_array(isset($User->skin), $skins) ){
    $connectSkin = $User->skin;
}else{
    $connectSkin = 'skin-blue';
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title> <?=$GLOBALS['CPLANG']['CONTROL_PANEL']?>: <?=$GLOBALS['project_name']?> </title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.6 -->
    <link rel="stylesheet" href="/<?=WS_PANEL?>/templates/lte/bootstrap/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
    <!-- daterange picker -->
    <!--<link rel="stylesheet" href="/ws/templates/lte/plugins/daterangepicker/daterangepicker-bs3.css">-->
    <!-- <link rel="stylesheet" href="/ws/templates/lte/plugins/jqueryui-1.12/jquery-ui.css">-->



    <!-- Theme style -->
    <link rel="stylesheet" href="/<?=WS_PANEL?>/templates/lte/dist/css/AdminLTE.css?v=3">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
    page. However, you can choose any other skin. Make sure you
    apply the skin class to the body tag so the changes take effect.
    -->
    <link rel="stylesheet" href="/<?=WS_PANEL?>/templates/lte/dist/css/skins/<?=$connectSkin?>.min.css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript" src="/<?=WS_PANEL?>/lib/ckeditor/ckeditor.js"></script>

    <!-- REQUIRED JS SCRIPTS -->

    <!-- jQuery 2.2.0 -->
    <script src="/<?=WS_PANEL?>/templates/lte/plugins/jQuery/jQuery-2.2.0.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="/<?=WS_PANEL?>/templates/lte/bootstrap/js/bootstrap.min.js"></script>
    <!-- AdminLTE App -->
    <script src="/<?=WS_PANEL?>/templates/lte/dist/js/app.min.js"></script>

    <!-- daterange picker -->
    <!--<script src="/ws/templates/lte/plugins/daterangepicker/moment.min.js"></script>
    <script src="/ws/templates/lte/plugins/daterangepicker/daterangepicker.js"></script> -->

    <!-- datepicker  -->
    <script src="/<?=WS_PANEL?>/templates/lte/plugins/datepicker/bootstrap-datepicker.js"></script>

    <?if($Admin->lang!='en'){?>
        <script src="/<?=WS_PANEL?>/templates/lte/plugins/datepicker/locales/bootstrap-datepicker.<?=$Admin->lang?>.js"></script>
    <?}?>

    <link rel="stylesheet" href="/<?=WS_PANEL?>/templates/lte/plugins/datepicker/datepicker3.css">

    <link rel="stylesheet" href="/<?=WS_PANEL?>/lib/datetimepicker/jquery.datetimepicker.css">
    <script src="/<?=WS_PANEL?>/lib/datetimepicker/jquery.datetimepicker.full.js"></script>

    <link rel="stylesheet" href="/<?=WS_PANEL?>/templates/lte/plugins/colorpicker/bootstrap-colorpicker.min.css">
    <script src="/<?=WS_PANEL?>/templates/lte/plugins/colorpicker/bootstrap-colorpicker.min.js"></script>

    <script>
        function refresh_elem(id, table){

            $('#loaderAllPage').show();
            var request = $.ajax({
                type: "POST",
                url: "/<?=WS_PANEL?>/ajax/",
                data: "task=refresh&id="+id+"&table="+table,
                success: function(msg){
                    location.reload();
                }
            });
            request.done(function( msg ) { // успешно
            });
            request.fail(function( jqXHR, textStatus ) { // не успешно
                alert('Произошла ошибка');
                $('#loaderAllPage').show();
            });
        }

        function block_elem(id, table){
            $.ajax({
                type: "POST",
                url: "/<?=WS_PANEL?>/ajax/",
                data: "task=block_elem&id="+id+"&table="+table,
                success: function(msg){
                    location.reload();
                }
            });
        }

        $(function(){
            $('.datetimepicker').datetimepicker({
                format: 'Y-m-d h:m:s',
                language: '<?=$Admin->lang?>' ,
                dayOfWeekStart: 1 ,
            });

            $( ".datepicker" ).datepicker({
                format: 'yyyy-mm-dd',
                todayHighlight: true,
                weekStart: 1,
                language: '<?=$Admin->lang?>' ,
                dayOfWeekStart: 1 ,
            });
        });


        <?// COPY TO CLICK ?>
        function clearmessage(delay , elem){
            setTimeout(function(){
                $(elem).html('');
            },delay);
        }

        function selectText(elementId) {
            var doc = document,
                text = doc.getElementById(elementId),
                range,
                selection;

            if (doc.body.createTextRange) {
                range = document.body.createTextRange();
                range.moveToElementText(text);
                range.select();
            } else if (window.getSelection) {
                selection = window.getSelection();
                range = document.createRange();
                range.selectNodeContents(text);
                selection.removeAllRanges();
                selection.addRange(range);
            }
        }

        $(document).ready(function() {
            $(".php_code , .html_code").click(function() {
                selectText(this.id);
                document.execCommand("copy");

                $(this).parent().find('.notific').html('<span style="color:#009481" class="animated tada"> <?=$GLOBALS['CPLANG']['SUCCES_COPY']?> </span>');
                clearmessage(2200, '.notific');
            });

            $('body').on('click', 'input[name=newpass]', function(){
                checkPassword($(this));
            });
        });

        <?// COPY TO CLICK end ?>
        function codevalidate(){
            var code = $('#code').val();
            var a = code.toUpperCase();
            $('#code').val(a);
            return true;
        }

        <? // проверка пароля на сложность ?>
        function checkPassword(field) {
            var password = $.trim( $(field).val() ); // Получаем пароль из формы
            var s_letters = "qwertyuiopasdfghjklzxcvbnm"; // Буквы в нижнем регистре
            var b_letters = "QWERTYUIOPLKJHGFDSAZXCVBNM"; // Буквы в верхнем регистре
            var digits = "0123456789"; // Цифры
            var specials = "!@#$%^&*()_-+=\|/.,:;[]{}"; // Спецсимволы
            var is_s = false; // Есть ли в пароле буквы в нижнем регистре
            var is_b = false; // Есть ли в пароле буквы в верхнем регистре
            var is_d = false; // Есть ли в пароле цифры
            var is_sp = false; // Есть ли в пароле спецсимволы
            for (var i = 0; i < password.length; i++) {
                /* Проверяем каждый символ пароля на принадлежность к тому или иному типу */
                if (!is_s && s_letters.indexOf(password[i]) != -1) is_s = true;
                else if (!is_b && b_letters.indexOf(password[i]) != -1) is_b = true;
                else if (!is_d && digits.indexOf(password[i]) != -1) is_d = true;
                else if (!is_sp && specials.indexOf(password[i]) != -1) is_sp = true;
            }
            var rating = 0;
            var text = "";
            if (is_s) rating++; // Если в пароле есть символы в нижнем регистре, то увеличиваем рейтинг сложности
            if (is_b) rating++; // Если в пароле есть символы в верхнем регистре, то увеличиваем рейтинг сложности
            if (is_d) rating++; // Если в пароле есть цифры, то увеличиваем рейтинг сложности
            if (is_sp) rating++; // Если в пароле есть спецсимволы, то увеличиваем рейтинг сложности
            /* Далее идёт анализ длины пароля и полученного рейтинга, и на основании этого готовится текстовое описание сложности пароля */
            if (password.length < 6 && rating < 3) text = "<?=$GLOBALS['CPLANG']['SIMPLE']?>";
            else if (password.length < 6 && rating >= 3) text = "<?=$GLOBALS['CPLANG']['MEDIUM']?>";
            else if (password.length >= 8 && rating < 3) text = "<?=$GLOBALS['CPLANG']['MEDIUM']?>";
            else if (password.length >= 8 && rating >= 3) text = "<?=$GLOBALS['CPLANG']['COMPLICATED']?>";
            else if (password.length >= 6 && rating == 1) text = "<?=$GLOBALS['CPLANG']['SIMPLE']?>";
            else if (password.length >= 6 && rating > 1 && rating < 4) text = "<?=$GLOBALS['CPLANG']['MEDIUM']?>";
            else if (password.length >= 6 && rating == 4) text = "<?=$GLOBALS['CPLANG']['COMPLICATED']?>";

            if (password.length < 1) text = "<?=$GLOBALS['CPLANG']['NOT']?>";
            $('#indicator').text( text );
        }
    </script>
    <style>
        .docloader{
            width: 120px;
            height: 120px;
            border-radius: 120px;
            background: url(/<?=WS_PANEL?>/templates/lte/dist/img/loader.gif) no-repeat 50% 50%;
            display: none;

        }

        delete{
            display: block;
            width: 22px;
            height: 22px;
            position: absolute;
            top: -3px;
            right: -6px;
            cursor: pointer;
            opacity: 0.8;
            transition: all 0.2s;
            background: url(/<?=WS_PANEL?>/templates/lte/dist/img/file_delete.png) no-repeat 50% 50%;
        }
    </style>
    <style>
    	.glyphicon-refresh {
    		
    	}
    	.glyphicon-refresh:before {
    		content: '';
    		display: block;
    		height: 18px;
    		width: 19px;
    		background: no-repeat url(/images/active.svg);
    	}
    	.label-default .glyphicon-refresh:before {
    		filter: brightness(0);
    	}
    </style>
</head>
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to get the
desired effect
|---------------------------------------------------------|
| SKINS         | skin-blue                               |
|               | skin-black                              |
|               | skin-purple                             |
|               | skin-yellow                             |
|               | skin-red                                |
|               | skin-green                              |
|---------------------------------------------------------|
|LAYOUT OPTIONS | fixed                                   |
|               | layout-boxed                            |
|               | layout-top-nav                          |
|               | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->

<body class="hold-transition <?=$connectSkin?> sidebar-mini">

    <div id="loaderAllPage" style="width: 45px;
        height: 45px;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        z-index: 1045;
        margin: 0 auto; display: none">
        <div>
            <i class="fa fa-refresh fa-spin" style="font-size: 47px;"></i>
        </div>
    </div>

    <div class="wrapper">
        <header class="main-header">

            <a href="/<?=WS_PANEL?>/" class="logo">
                <span class="logo-lg">
                    <small> <? //$GLOBALS['CPLANG']['STUDIO_WEBMASTER_CP']?> <?=$GLOBALS['project_name']?> </small>
                </span>
            </a>

            <nav class="navbar navbar-static-top" role="navigation">

                <?
                if( $User->IsAuthorized() ){
                    ?>
                    <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button"> <span class="sr-only">Toggle navigation</span> </a>
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <?/*?>
                                    <li class="dropdown messages-menu">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-envelope-o"></i> <span class="label label-success">4</span> </a>
                                        <ul class="dropdown-menu">
                                            <li class="header">
                                                You have 4 messages
                                            </li>
                                            <li>
                                                <ul class="menu">
                                                    <li>
                                                        <!-- start message -->
                                                        <a href="#">
                                                        <div class="pull-left">
                                                            <!-- User Image -->
                                                            <img src="/ws/templates/lte/dist/img/users/abc.jpg" class="img-circle" alt="User Image">
                                                        </div> <!-- Message title and timestamp --> <h4> Support Team <small><i class="fa fa-clock-o"></i> 5 mins</small></h4> <!-- The message -->
                                                        <p>
                                                            Why not buy a new awesome theme?
                                                        </p> </a>
                                                    </li>
                                                    <!-- end message -->
                                                </ul>
                                                <!-- /.menu -->
                                            </li>
                                            <li class="footer">
                                                <a href="#">See All Messages</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- /.messages-menu -->

                                    <!-- Notifications Menu -->
                                    <li class="dropdown notifications-menu">
                                        <!-- Menu toggle button -->
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-bell-o"></i> <span class="label label-warning">10</span> </a>
                                        <ul class="dropdown-menu">
                                            <li class="header">
                                                You have 10 notifications
                                            </li>
                                            <li>
                                                <!-- Inner Menu: contains the notifications -->
                                                <ul class="menu">
                                                    <li>
                                                        <!-- start notification -->
                                                        <a href="#"> <i class="fa fa-users text-aqua"></i> 5 new members joined today </a>
                                                    </li>
                                                    <!-- end notification -->
                                                </ul>
                                            </li>
                                            <li class="footer">
                                                <a href="#">View all</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <!-- Tasks Menu -->
                                    <li class="dropdown tasks-menu">
                                        <!-- Menu Toggle Button -->
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa fa-flag-o"></i> <span class="label label-danger">9</span> </a>
                                        <ul class="dropdown-menu">
                                            <li class="header">
                                                You have 9 tasks
                                            </li>
                                            <li>
                                                <!-- Inner menu: contains the tasks -->
                                                <ul class="menu">
                                                    <li>
                                                        <!-- Task item -->
                                                        <a href="#"> <!-- Task title and progress text --> <h3> Design some buttons <small class="pull-right">20%</small></h3> <!-- The progress bar -->
                                                        <div class="progress xs">
                                                            <!-- Change the css width attribute to simulate progress -->
                                                            <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                                <span class="sr-only">20% Complete</span>
                                                            </div>
                                                        </div> </a>
                                                    </li>
                                                    <!-- end task item -->
                                                </ul>
                                            </li>
                                            <li class="footer">
                                                <a href="#">View all tasks</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <?*/?>
                            <!-- User Account Menu -->
                            <li class="dropdown user user-menu">
                                <!-- Menu Toggle Button -->
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <!-- The user image in the navbar-->
                                    <img src="/<?=WS_PANEL?>/templates/lte/dist/img/users/<?=$Admin->image?>" class="user-image" alt="User Image">
                                    <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                    <span class="hidden-xs"><?=$_SESSION['admin']['login']?></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <!-- The user image in the menu -->
                                    <li class="user-header">
                                        <img src="/<?=WS_PANEL?>/templates/lte/dist/img/users/<?=$Admin->image?>" class="img-circle" alt="User Image">
                                        <p>
                                            <?=$User->user_name?>
                                            <small><?=$GLOBALS['CPLANG']['AUTHORIZED']?>: <?=date("d.m.Y H:i", strtotime($User->auth_date))?></small>
                                        </p>
                                    </li>
                                    <!-- Menu Footer-->
                                    <li class="user-footer">
                                        <div class="pull-left">
                                            <a href="/<?=WS_PANEL?>/users/users/edit_elem.php?id=<?=$User->user_id?>" class="btn btn-default btn-flat"><?=$GLOBALS['CPLANG']['PROFILE']?></a>
                                        </div>
                                        <div class="pull-right">
                                            <a href="/<?=WS_PANEL?>/logout.php" onclick="return confirm('<?=$GLOBALS['CPLANG']['GO_OUT_QUESTION']?>')" class="btn btn-default btn-flat"><?=$GLOBALS['CPLANG']['QUIT']?></a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <!-- Control Sidebar Toggle Button -->
                            <!-- <li>
                                <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                            </li> -->
                            <li>
                                <a target="_blank" title="<?=$GLOBALS['CPLANG']['PUBLIC_PART']?>" href="/" ><i class="fa fa-chrome"></i></a>
                            </li>
                        </ul>
                    </div>
                <?}?>
            </nav>
        </header>