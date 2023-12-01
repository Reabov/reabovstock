<?
    include($_SERVER['DOCUMENT_ROOT']."/73naasfalteon.php");
    include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/header.php");
    include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/lock.php");
    
    if( $User->InGroup(array(1,2,3,4,5,6,7,8,9)) ){
        include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/left_menu.php");
        ?>
            <div class="content-wrapper">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <h1> Page Header <small>Optional description</small></h1>
                    <ol class="breadcrumb">
                        <li>
                            <a href="#"><i class="fa fa-dashboard"></i> Level</a>
                        </li>
                        <li class="active">
                            Here
                        </li>
                    </ol>
                </section>


                <section class="content">

                    <!-- Your Page Content Here -->

                </section>

            </div>
        <?
        include($_SERVER["DOCUMENT_ROOT"]."/". WS_PANEL ."/templates/lte/footer.php");
    }
    
?>