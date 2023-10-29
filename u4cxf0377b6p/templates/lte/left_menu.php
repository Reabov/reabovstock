
    <!-- Left side column. contains the logo and sidebar -->
    <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
            <!-- Sidebar user panel (optional) -->
            <?/*
            <div class="user-panel">
                <div class="pull-left image">
                    <img src="/<?=WS_PANEL?>/templates/lte/dist/img/users/<?=$Admin->image?>" class="img-circle" alt="User Image">
                </div>
                <div class="pull-left info">
                    <p>
                        <?=$_SESSION['admin']['login']?>
                    </p>
                    <!-- Status -->

                </div>
            </div>
            */?>

            <!-- search form (Optional) -->
            <!--<form action="#" method="get" class="sidebar-form">
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="Search...">
                    <span class="input-group-btn">
                        <button type="submit" name="search" id="search-btn" class="btn btn-flat">
                            <i class="fa fa-search"></i>
                        </button> </span>
                </div>
            </form> -->

            <ul class="sidebar-menu">
                <? /*<li class="header">
                    <?=$GLOBALS['CPLANG']['LEFTMENU_MENU']?>
                </li> */?>

                <?
                $getLeftMenu = mysqli_query($db,
                "SELECT * FROM ws_menu_admin 
                    WHERE active = 1 AND section_id = 0 AND id <> 3 AND id <> 39
                    AND 
                        ( 	
                            access = '".$User->user_group."' 
                            OR access LIKE '%,".$User->user_group.",%' 
                            OR access LIKE '".$User->user_group.",%' 
                            OR access LIKE '%,".$User->user_group."' 
                        )
                    ORDER BY sort DESC ");
                while($menu1 = mysqli_fetch_assoc($getLeftMenu)) {
                    $actClass="";
                    $menu1['link'] = str_replace( '{WS_PANEL}' , WS_PANEL , $menu1['link'] );
                    if( substr_count($_SERVER['REQUEST_URI'], $menu1['link']) ){
                        $actClass = 'active';
                    }
                    ?>
                    <li class="treeview <?=$actClass?>">
                        <a href="#">
                            <i class="fa <?=$menu1['image']?>"></i>
                            <span> <?=$menu1['title']?> </span>
                            <i class="fa fa-angle-left pull-right"></i>
                        </a>
                        <ul class="treeview-menu">
                            <?
                            $getLeftMenu2 = mysqli_query($db, "SELECT * FROM ws_menu_admin WHERE active = 1 AND section_id = ".$menu1['id']." ORDER BY sort DESC ");
                            while($menu2 = mysqli_fetch_assoc($getLeftMenu2)){
                                $subClass="";
                                $menu2['link'] = str_replace( '{WS_PANEL}' , WS_PANEL , $menu2['link'] );
                                if( substr_count($_SERVER['REQUEST_URI'], $menu2['link']) ){
                                    $subClass = 'active';
                                }
                                ?>
                                <li class="<?=$subClass?>">
                                    <a href="<?=$menu2['link']?>">
                                        <?=$menu2['title']?>
                                    </a>
                                </li>
                                <?
                            }
                            ?>
                        </ul>
                    </li>
                    <?
                }

                if( $User->InGroup( array( 1,2 ) ) )
                {
                    ?>
                    <li class="header">
                        <?=$GLOBALS['CPLANG']['LEFTMENU_SETTINGS']?>
                    </li>

                    <?
                    $getLeftMenu = mysqli_query($db, "SELECT * FROM ws_menu_admin WHERE id = 3 ORDER BY sort DESC ");
                    while($menu1 = mysqli_fetch_assoc($getLeftMenu)){
                        $actClass="";
                        $menu1['link'] = str_replace( '{WS_PANEL}' , WS_PANEL , $menu1['link'] );
                        if( substr_count($_SERVER['REQUEST_URI'], $menu1['link']) ){
                            $actClass = 'active';
                        }
                        ?>
                        <li class="treeview <?=$actClass?>">
                            <a href="#"><i class="fa <?=$menu1['image']?>"></i> <span><?=$menu1['title']?></span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <?
                                $getLeftMenu2 = mysqli_query($db,
                                "SELECT * FROM ws_menu_admin WHERE active = 1 AND section_id = ".$menu1['id']." 
                                AND ( 
                                    access = '".$User->user_group."' OR access LIKE '%,".$User->user_group.",%' OR 
                                    access LIKE '".$User->user_group.",%' OR access LIKE '%,".$User->user_group."'  
                                    )
                                ORDER BY sort DESC ");
                                while($menu2 = mysqli_fetch_assoc($getLeftMenu2)){
                                    $subClass="";
                                    $menu2['link'] = str_replace( '{WS_PANEL}' , WS_PANEL , $menu2['link'] );
                                    if( substr_count($_SERVER['REQUEST_URI'], $menu2['link']) ){
                                        $subClass = 'active';
                                    }
                                    ?>
                                    <li class="<?=$subClass?>">
                                        <a href="<?=$menu2['link']?>"><?=$menu2['title']?></a>
                                    </li>
                                    <?
                                }
                                ?>
                            </ul>
                        </li>
                        <?
                    }
                }
                ?>

                <?/*if( $User->InGroup( array( 1,2 ) ) ){?>
                    <li class="header">
                        <?=$GLOBALS['CPLANG']['LEFTMENU_CONSTRUCTOR']?>
                    </li>

                    <?
                    $getLeftMenu = mysqli_query($db, "SELECT * FROM ws_menu_admin WHERE id = 39 ORDER BY sort DESC ");
                    while($menu1 = mysqli_fetch_assoc($getLeftMenu)){
                        $actClass="";
                        if( substr_count($_SERVER['REQUEST_URI'], $menu1['link']) ){
                            $actClass = 'active';
                        }
                        ?>
                        <li class="treeview <?=$actClass?>">
                            <a href="#"><i class="fa <?=$menu1['image']?>"></i> <span><?=$menu1['title']?></span> <i class="fa fa-angle-left pull-right"></i></a>
                            <ul class="treeview-menu">
                                <? // $User->user_group
                                $getLeftMenu2 = mysqli_query($db,
                                "SELECT * FROM ws_menu_admin WHERE active = 1 AND section_id = ".$menu1['id']."
                                AND (
                                    access = '".$User->user_group."' OR access LIKE '%,".$User->user_group.",%' OR
                                    access LIKE '".$User->user_group.",%' OR access LIKE '%,".$User->user_group."'
                                    )
                                ORDER BY sort DESC ");
                                while($menu2 = mysqli_fetch_assoc($getLeftMenu2)){
                                    $subClass="";
                                    if( substr_count($_SERVER['REQUEST_URI'], $menu2['link']) ){
                                        $subClass = 'active';
                                    }
                                    ?>
                                    <li class="<?=$subClass?>">
                                        <a href="<?=$menu2['link']?>"><?=$menu2['title']?></a>
                                    </li>
                                    <?
                                }
                                ?>
                            </ul>
                        </li>
                        <?
                    }
                    ?>
                <?
                   }*/?>
            </ul>
            <!-- /.sidebar-menu -->
        </section>
        <!-- /.sidebar -->
    </aside>