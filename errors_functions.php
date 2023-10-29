<?



function define_client_ip_error_handler() {
    $keys = [
        'HTTP_CLIENT_IP',
        'HTTP_X_FORWARDED_FOR',
        'REMOTE_ADDR'
    ];

    foreach ($keys as $key) {
        if (!empty($_SERVER[$key])) {
            @$ip = trim(end(explode(',', $_SERVER[$key])));
            if (filter_var($ip, FILTER_VALIDATE_IP)) {
                return $ip;
            }
        }
    }
}



function my_error_handler(){
    $last_error = error_get_last();
    //var_dump($last_error);
    if ($last_error && ($last_error['type'] == 4 || $last_error['type'] == 1)) {
        header("HTTP/1.1 500 Internal Server Error");

        ?>
        <div class="callout callout-danger" style="font-family: \'Open Sans\';border-radius: 3px;
            margin: 0 0 20px 0;
            padding: 15px 30px 15px 15px;
            border-left: 5px solid #eee;border-color: #c23321;    color: #fff !important;background-color: #dd4b39 !important;">
            <h4 style="    margin-bottom: 10px;margin-top: 0;
            font-weight: 600;font-size: 18px;line-height: 1.1;
            color: inherit;"> Error! </h4>
            <?
            $arr_file = explode('public_html', $last_error['file']);
            $str_file = str_replace(WS_PANEL, '', $arr_file['1']);
            $str_file = str_replace('//', '/', $str_file);
            ?>
            <p style="   font-family: \'Open Sans\'; margin-bottom: 0;margin: 0 0 10px;"> <b>Message:</b> <?=$last_error['message']?> </p>
            <p style="   font-family: \'Open Sans\'; margin-bottom: 0;margin: 0 0 10px;"> <b>File:</b> <?=$str_file?> </p>
            <p style="   font-family: \'Open Sans\'; margin-bottom: 0;margin: 0 0 10px;"> <b>Line:</b> <?=$last_error['line']?> </p>
        </div>
        <?php

        exit();
    }
}

$access_to_error = array( '95.65.81.152', "89.28.90.195" );
if( in_array(define_client_ip_error_handler(), $access_to_error)){
    register_shutdown_function('my_error_handler');
}