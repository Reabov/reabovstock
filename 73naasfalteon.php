<?php


// ---- - -- -- - - - -- - - - - - -
    if( substr(sprintf('%o', fileperms($_SERVER['DOCUMENT_ROOT'] . '/' . '73naasfalteon.php')), -4) != '0600' ) {
        $r = chmod($_SERVER['DOCUMENT_ROOT'] . '/' . "73naasfalteon.php", 0600 );
        if( !$r ) {
            exit('Error permission');
        }
    }


    $path = 'u4cxf0377b6p'; /* НАЗВАНИЕ ПАПКИ АДМИН ПАНЕЛИ */
    if( !is_dir( $_SERVER['DOCUMENT_ROOT'] . '/' . $path ) ) {
        exit( 'Error connect panel' );
    }
    define( "WS_PANEL" , $path );
// ---- - -- -- - - - -- - - - - - - END

?>