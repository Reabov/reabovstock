<?
file_put_contents("crontest.txt", "start-> ".date("d.m.Y H:i:s")."\n", FILE_APPEND);

    chdir( dirname(__FILE__) );
    include_once '../reabov/config.php';
    include_once '../reabov/include/functions.php';
	
	//var_dump($_SERVER['DOCUMENT_ROOT']);
    //var_dump($_SERVER['SERVER_PROTOCOL']);
	//var_dump($_SERVER['HTTP_HOST']);
	
    $db =  mysqli_connect($SERVER_NAME, $DB_LOGIN, $DB_PASS, $DB_NAME);
    mysqli_set_charset($db, "utf8");
    // var_dump($db);
    /*
     * ws_mailer_news - таблица с заданиями на рассылку
     * ws_subscribers - списог подписавшихся
     *
     * */
	
    $getSettings = mysqli_query($db, "SELECT `code`,`value` FROM ws_settings ");
    $Settings = mysqli_fetch_all($getSettings, MYSQLI_ASSOC);
    $Settings = array_column($Settings, 'value','code' );
	
	//mysqli_query($db, "INSERT INTO ws_test_log (text, date) VALUES ('test', '".date("Y-m-d H:i:s")."')");
	
    $getmailer = mysqli_query($db, "SELECT * FROM ws_mailer_news WHERE status IN('new','in_process') ORDER BY id ASC LIMIT 1");
    if( mysqli_num_rows($getmailer)===0 ){
        exit;
    }
    ?><pre><?
    //var_dump($getmailer);
    ?></pre><?
    $Mailer = mysqli_fetch_assoc($getmailer);
    //var_dump($Mailer);
	
    if( $Mailer['status'] == 'new'){
      ?><pre><?
     // var_dump($Mailer);
      ?></pre><?
        mysqli_query($db, "UPDATE ws_mailer_news SET status = 'in_process' WHERE id = ".$Mailer['id']);
    }

    //$getnews = mysqli_query($db, "SELECT * FROM `ws_news` WHERE id = ".$Mailer['news_id']. " AND active = 1");
    
    
    
    ?><pre><?
    //var_dump($getnews);
    ?></pre><?
    ?><pre><?
    //var_dump( mysqli_num_rows($getnews));
    ?></pre><?
    /*
    if( mysqli_num_rows($getnews)===0 ){
       exit;
    }
    $News = mysqli_fetch_assoc($getnews);
*/
    ?><pre><?
    //var_dump($News);
    ?></pre><?
    
    
    
   $getlastUser = mysqli_query($db, " SELECT * FROM ws_subscribers WHERE id > ".(int)$Mailer['last_user_id']." ORDER BY id ASC LIMIT 1");
   
   
	//var_dump($getlastUser);
    if( mysqli_num_rows($getlastUser)===0 ){
        // Это задание на рассылку закончено
        mysqli_query($db, "UPDATE ws_mailer_news SET status = 'done' WHERE id = ".$Mailer['id']);
        exit;
    }
    $User = mysqli_fetch_assoc($getlastUser);
	//var_dump($User);
    // готовим текст
    $getTextFish = mysqli_query($db, " SELECT text_".$User['lang']." AS `text` FROM ws_pages_inc WHERE code = 'NEW_NEWS' LIMIT 1");
    $Text = mysqli_fetch_assoc($getTextFish);
	//var_dump($Text);
   
	
    $pagelink = $Mailer['link_'.$User['lang']];
	$image="<img width='100%' src='".$Settings['SERVER_PROTOCOL'].$Settings['HTTP_HOST']."/upload/mailer/".$Mailer['image']."'>";
	$image2='<img width="100%" src="../upload/mailer/bivce3dd7l.jpg" />';
	//var_dump($pageLink);

	 $ccpu = mysqli_query($db,
    "SELECT * FROM ws_cpu WHERE page_id = 4 AND lang = '".$User['lang']."'");
    $ccpu = mysqli_fetch_assoc($ccpu);


    $unsubscribe =$Settings['SERVER_PROTOCOL'].$Settings['HTTP_HOST'].$ccpu['cpu']."?email=".$User['email']."&id=".$User['id'];
    $arReplace = array( $Mailer['title_'.$User['lang']],$Mailer['text_'.$User['lang']],'<a href ="'.$unsubscribe.'">','</a>' );

    $Text = str_replace(array('{title}','{text}', '{unsubscribe}','{/unsubscribe}'), $arReplace, $Text['text'] );
	
	//var_dump($Text);
    $getTheme = mysqli_query($db, "SELECT title_".$User['lang']." AS title FROM ws_lang_dictionary WHERE code = 'MSG_ALL_MAILER_TITLE' ");
    $mailTheme = mysqli_fetch_assoc($getTheme);
    //var_dump($mailTheme);
    
    
    ///PDF  mailer_pdf
    // $mail_body = file_get_contents('../pdf/index.php');
		// $m_body = array($image2);
		// $m_body_replace = array("{pdf}");
		// $mail_body = str_replace($m_body_replace,$m_body,$mail_body);
		// $body .= $mail_body;
   // // var_dump($body);
//     
     // include_once '../lib/mpdf/mpdf.php';
     // $mpdf = new mPDF('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10);
     // $filenameDoc = "mailer_".uniqid().".pdf";
// //     
    // $mpdf->WriteHTML( $body, 2 );
	// $mpdf->debug = true;
	 // $mpdf->Output($_SERVER['DOCUMENT_ROOT']."/upload/mailer_pdf/".$filenameDoc,'F' );
	
	$Valmart= mysqli_query($db, "SELECT title_".$User['lang']." AS title FROM ws_lang_dictionary WHERE code = 'MSG_ALL_VALMARTMD' ");
	$Valmart = mysqli_fetch_assoc($Valmart);
	
	
	
    include_once '../lib/libmail/libmail.php';

    $m= new Mail();
    $m->From($Valmart['title'].";". $Settings['SMTP_MAIL'] );
    $m->ReplyTo( $Settings['SMTP_MAIL'] );
    $m->To( $User['email'] );   // кому, в этом поле так же разрешено указывать имя
    $m->Subject( $Mailer['title_'.$User['lang']] );
    $m->Body($Text, "html");
    $m->Priority(4);
	//$m->Attach($_SERVER['DOCUMENT_ROOT'] ."/upload/mailer_pdf/".$filenameDoc);
    $m->smtp_on($Settings['SMTP_SERVER'], $Settings['SMTP_MAIL'], $Settings['SMTP_PASS'], $Settings['SMTP_PORT']);
    $m->log_on(true); // включаем лог, чтобы посмотреть служебную информацию
    $a = $m->Send(); //var_
    
    //var_dump($a);
    mysqli_query($db, "UPDATE ws_mailer_news SET last_user_id = ".$User['id']." WHERE id = ".$Mailer['id']);
