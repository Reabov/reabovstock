<?
	//show($token_obj);
	
	$ab = $Db->getone("SELECT * FROM `ws_abonament_client` WHERE paypal_token = '".$_GET['token']."' ");
	$id = $ab['id'];
	$abonament = $Db->getone("SELECT * FROM `ws_abonament` WHERE id = ".$ab['ab_id']);
	//show($ab);
	//show($abonament);
	
	$number_form = number_format($abonament['price'],2,'.','');
	//$number_form = "2.75";
	
	
	include($_SERVER['DOCUMENT_ROOT']."/".WS_PANEL."/include/CPaypal.php");
	$paypal = new Paypal();
	// получаем информацию об оплате
    $checkoutDetails = $paypal -> request('GetExpressCheckoutDetails', array('TOKEN' => filter_var($_GET['token'], FILTER_SANITIZE_STRING)));
    $GetExpressCheckoutDetailsRESPONSE = serialize($checkoutDetails);
	
	//show($GetExpressCheckoutDetailsRESPONSE);
	
	/*
    $itemsParams = array();
    //$itemsParams['L_PAYMENTREQUEST_0_NAME0'] = 'Refil account';
    //$itemsParams['L_PAYMENTREQUEST_0_DESC0'] = 'Refil account in system';
    $itemsParams['L_PAYMENTREQUEST_0_AMT0'] = $number_form;
    $itemsParams['L_PAYMENTREQUEST_0_QTY0'] = 1;

    $itemsParams['PAYMENTREQUEST_0_AMT'] = $number_form;
    //$itemsParams['PAYMENTREQUEST_0_SHIPPINGAMT'] = 0;
    $itemsParams['PAYMENTREQUEST_0_CURRENCYCODE'] = $GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_EUR'];
    $itemsParams['PAYMENTREQUEST_0_ITEMAMT'] = $number_form;
    */
	
    $orderParams = array(
		'PAYMENTREQUEST_0_AMT' => $number_form,
        // 'PAYMENTREQUEST_0_SHIPPINGAMT' => '0',
        'PAYMENTREQUEST_0_CURRENCYCODE' => $GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_EUR'],
        'PAYMENTREQUEST_0_ITEMAMT' => $number_form // 1+2
	);
	
	$requestParams = array(
        'PAYMENTACTION' => 'Sale',
        'PAYERID' => filter_var($_GET['PayerID'], FILTER_SANITIZE_STRING),
        'TOKEN' => filter_var($_GET['token'], FILTER_SANITIZE_STRING),
        'AMT'=>$number_form,
    	'CURRENCYCODE' => $GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_EUR']
	);
	
	
	
	$response = $paypal -> request('DoExpressCheckoutPayment',$requestParams);
	//show($response);
    if(is_array($response) && ($response['ACK'] == 'Success' || $response['PAYMENTINFO_0_ACK']=='Success' || strripos($response['PAYMENTINFO_0_ACK'], 'success'))){
        $Db->q("UPDATE `ws_abonament_client` SET is_paid = 1 WHERE id = ".$id);
        
        $text = $GLOBALS['ar_define_langterms']['MSG_PERSONAL_YOUR_PAYMENT_IS_SUCCEFULLY'];
        
        if((int)$Client->id != 0){
		$insert_not = $Db->q("INSERT INTO `ws_notifications` (is_read,client_id,type,rang,session_id,not_text,created) 
												VALUES (0,".(int)$Client->id.",'pay_success',1,'','".$text."',NOW()) ");
	    }
        
		header('Location: '.$CCpu->writelink(80)."?section=subscription");
		//show('success');
    }else{
    	$_SESSION['paypal_msg'] = $GLOBALS['ar_define_langterms']['MSG_MESSAGE_OPLATU_NE_UDALOSI_ZAVERSHITI'];
		header('Location: '.$CCpu->writelink(95));
	}
	
	?>
	<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	
</body>
</html>