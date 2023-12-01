<?include($_SERVER['DOCUMENT_ROOT']."/".WS_PANEL."/include/CPaypal.php");
	$prot = 'http';
	if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ) {
	    $prot = 'https';
	}
	$requestParams = array(
	    'RETURNURL' => $prot . '://' . $_SERVER['HTTP_HOST'] . $CCpu->writelink( 94 ), // Адрес, на который будет перенаправлен пользователь после успешного совершения платежа
        'CANCELURL' => $prot . '://' . $_SERVER['HTTP_HOST'] . $CCpu->writelink( 95 ) // Адрес, на который будет перенаправлен пользователь, если во время платежа произошла ошибка
    );
	
    $item = array();
        //$item['L_PAYMENTREQUEST_0_NAME0'] = ' ID- ' . $_GET['id'] . ' email- ' . $_SESSION['pay']['email'];
        //$item['L_PAYMENTREQUEST_0_DESC0'] = $_SESSION['pay']['id'] . ' ID- ' . $_SESSION['order_id_pay'] . ' email- ' . $_SESSION['pay']['email'];
        $item['L_PAYMENTREQUEST_0_AMT0'] = $_SESSION['pay']['sum']; //Итоговая сумма для перевода
        $item['L_PAYMENTREQUEST_0_QTY0'] = 1;

    $orderParams = array(
        'PAYMENTREQUEST_0_AMT' => $_SESSION['pay']['sum'] ,
       	// 'PAYMENTREQUEST_0_SHIPPINGAMT' => '0',
       	'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
        'PAYMENTREQUEST_0_ITEMAMT' => $_SESSION['pay']['sum'] // 1+2
    );

    $paypal = new Paypal();
    $response = $paypal->request( 'SetExpressCheckout' , $requestParams + $orderParams + $item );

    

    if( is_array( $response ) && ( $response['ACK'] == 'Success' || "SUCCESSWITHWARNING" == strtoupper( $response["ACK"] ) || "SUCCESS" == strtoupper( $response["ACK"] ) ) ){
	    $_SESSION['mypay'] = $response;
		$token = $response['TOKEN'];
	    //header( 'Location: https://www.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token) );
        
        ?>
        <script>
            setTimeout(function(){ window.location = "https://www.paypal.com/webscr?cmd=_express-checkout&token=<?=urlencode($token)?>"; }, 100);
        </script>
        <p>
            <?=$GLOBALS['ar_define_langterms']['MSG_ALL_WAITFORPAYMENT']?>
        </p>
        <?}else{
        
    	/* если что то посшло не так */
        header("Location: ".$CCpu->writelink( 95 )."?status=".filter_var($response["ACK"], FILTER_SANITIZE_SPECIAL_CHARS));
    }

?>