<?

if( isset($_SESSION['admin']['mem']) && !empty($_SESSION['admin']['mem']) )
{
    $s_mem = mysqli_query($db, " SELECT * FROM `ws_users` WHERE `login_crypt`='".filter_var($_SESSION['admin']['mem'], FILTER_SANITIZE_SPECIAL_CHARS)."' AND active = 1 LIMIT 1 ");
    if( (int)mysqli_num_rows($s_mem)==1 )
    {
        $ar_mem = mysqli_fetch_assoc($s_mem);

        if( $ar_mem['block'] == 1 )
        {
            unset($_SESSION['admin']);
            $_SESSION['auth_error'] = '<div class="alert alert-danger">'.$GLOBALS['CPLANG']['ACCOUNT_IS_BLOCKED'].'</div>';
        }
        else
        {
            $_SESSION['admin']['login']  = $ar_mem['login'];                    
            $_SESSION['admin']['mem']    = $ar_mem['login_crypt'];           
        }
    }
    else
    {
        unset($_SESSION['admin']);
        $_SESSION['auth_error'] = '<div class="alert alert-danger">'.$GLOBALS['CPLANG']['ACCOUNT_IS_BLOCKED'].'</div>';
    }
}    
?>

<?if( !isset($_SESSION['admin']['mem']) ):?>

    <script>
        var a = $(window).height();
        $('.wrapper').css({"height": a+"px"});
    </script>
    
    <div class="login-box">
      <div class="login-logo">
        <a <?/*target="_blank" href="//webmaster.md"*/?> > <?=$GLOBALS['project_name']?> </a>
      </div>

      <div class="login-box-body">
        <p class="login-box-msg"><?=$GLOBALS['CPLANG']['LOGIN_TO_START']?></p>
        <?
        if( isset( $_SESSION['auth_error'] ) ){
            echo $_SESSION['auth_error'];
            unset($_SESSION['auth_error']);
        }
		
        ?>
        <form action="/<?=WS_PANEL?>/lock_processing.php" method="post">
          <div class="form-group has-feedback">
            <input type="text" class="form-control" placeholder="<?=$GLOBALS['CPLANG']['YOUR_LOGIN']?>" name="login" required>
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" class="form-control" placeholder="<?=$GLOBALS['CPLANG']['PASSWORD']?>" name="pass" required>
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>

          <div class="row">
            <div class="col-xs-5">
                <img src="/<?=WS_PANEL?>/lib/kcaptcha/?<?php echo session_name()?>=<?php echo session_id()?>">
            </div>
            <div class="col-xs-7">
                <input type="text" class="form-control" placeholder="captcha" name="keystring" style="height: 40px" required>
            </div>
          </div>
          
          <div class="row checkbox icheck">
            <div class="col-xs-2"></div>
            <div class="col-xs-8">
              <button type="submit" name="ok" class="btn btn-primary btn-block btn-flat"><?=$GLOBALS['CPLANG']['LOGIN_BTN']?></button>
            </div>
          </div>
          
        </form>
    
    
      </div>

    </div>

<? exit; endif;?>