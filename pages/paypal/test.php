<!DOCTYPE html>
<html lang="en">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body>
	<?
	//show($token_obj);
	
	$ab = $Db->getone("SELECT * FROM `ws_abonament_client` WHERE paypal_token = '".$_GET['token']."' ");
	$id = $ab['id'];
	//show($id);
	
	$url = "https://api-m.sandbox.paypal.com/v2/checkout/orders/".$_GET['token']."/capture";
	//show($url);
	
	$curl2 = curl_init($url);
	curl_setopt($curl2, CURLOPT_URL, $url);
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl2, CURLOPT_VERBOSE, true);
	
	$headers = array(
    	"Content-Type: application/json",
    	"PayPal-Request-Id: ".$id,
    	"Authorization: ".$token_type." ".$access_token
	);
	//show($headers);
	curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl2, CURLOPT_HEADER, true);
	
	//$data = json_encode($paypal_request);
	curl_setopt($curl2, CURLOPT_POST,true);
	//curl_setopt($curl2, CURLOPT_POSTFIELDS, $data);
	
	$response = curl_exec($curl2);
	curl_close($curl2);
	
	
	//show($response);
	$response = explode("\r", $response);
	$count = count($response)-1;
	$response = $response[$count];
	//show($response);
	
	$resp_obj = json_decode($response);
    show($resp_obj);
	
	
	
	
	exit();
	
	
	$order_id = '42E48271KT138092S';
	$auth_id = '5L631659WS412921M';
	$capt_id = '0KF70030AV557801R';
	
	
	
	
	$url = "https://api-m.sandbox.paypal.com/v2/checkout/orders/".$_GET['token'];
	
	
	$curl2 = curl_init($url);
	curl_setopt($curl2, CURLOPT_URL, $url);
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl2, CURLOPT_VERBOSE, true);
	
	$headers = array(
    	"Authorization: ".$token_type." ".$access_token
	);
	//show($headers);
	curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl2, CURLOPT_HEADER, true);
	
	$response = curl_exec($curl2);
	curl_close($curl2);
	
	
	//show($response);
	$response = explode("\r", $response);
	$count = count($response)-1;
	$response = $response[$count];
	show('order');
	show($response);
	$pay_obj = json_decode($response);
    
    show($pay_obj);
	
	
	
	
	$url = "https://api-m.sandbox.paypal.com/v2/payments/authorizations/".$auth_id;
	//show($url);
	
	$curl2 = curl_init($url);
	curl_setopt($curl2, CURLOPT_URL, $url);
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl2, CURLOPT_VERBOSE, true);
	
	$headers = array(
    	"Content-Type: application/json",
    	//"PayPal-Request-Id: ".$id,
    	"Authorization: ".$token_type." ".$access_token
	);
	//show($headers);
	curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl2, CURLOPT_HEADER, true);
	
	//$data = json_encode($paypal_request);
	//curl_setopt($curl2, CURLOPT_POST,true);
	//curl_setopt($curl2, CURLOPT_POSTFIELDS, $data);
	
	$response = curl_exec($curl2);
	curl_close($curl2);
	show('auth');
	show($response);
	$response = explode("\r", $response);
	$count = count($response)-1;
	$response = $response[$count];
	//show($response);
	$payment = json_decode($response);
    show($payment);
	
	
	
	
	
	
	$url = "https://api-m.sandbox.paypal.com/v2/payments/captures/".$capt_id;
	//show($url);
	
	$curl2 = curl_init($url);
	curl_setopt($curl2, CURLOPT_URL, $url);
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl2, CURLOPT_VERBOSE, true);
	
	$headers = array(
    	"Content-Type: application/json",
    	//"PayPal-Request-Id: ".$id,
    	"Authorization: ".$token_type." ".$access_token
	);
	//show($headers);
	curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl2, CURLOPT_HEADER, true);
	
	//$data = json_encode($paypal_request);
	//curl_setopt($curl2, CURLOPT_POST,true);
	//curl_setopt($curl2, CURLOPT_POSTFIELDS, $data);
	
	$response = curl_exec($curl2);
	curl_close($curl2);
	//show($response);
	$response = explode("\r", $response);
	$count = count($response)-1;
	$response = $response[$count];
	show('captures');
	show($response);
	$payment = json_decode($response);
    show($payment);
	
	
	
	
	
	
	exit();
	
	
	
	$url = "https://api-m.sandbox.paypal.com/v2/checkout/orders/".$_GET['token']."/authorize";
	//show($url);
	
	$curl2 = curl_init($url);
	curl_setopt($curl2, CURLOPT_URL, $url);
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl2, CURLOPT_VERBOSE, true);
	
	$headers = array(
    	"Content-Type: application/json",
    	"PayPal-Request-Id: ".$id,
    	"Authorization: ".$token_type." ".$access_token
	);
	//show($headers);
	curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl2, CURLOPT_HEADER, true);
	
	//$data = json_encode($paypal_request);
	curl_setopt($curl2, CURLOPT_POST,true);
	//curl_setopt($curl2, CURLOPT_POSTFIELDS, $data);
	
	$response = curl_exec($curl2);
	curl_close($curl2);
	
	
	//show($response);
	$response = explode("\r", $response);
	$count = count($response)-1;
	$response = $response[$count];
	//show($response);
	
	$resp_obj = json_decode($response);
    show($resp_obj);
	
	
	
	
	
	
	
	
	
	
	$payment_id = $resp_obj->purchase_units[0]->payments->authorizations[0]->id;
	
	
	
	
	//поехали оплачивать, сучки!!! снчала получить детали
	
	$url = "https://api-m.sandbox.paypal.com/v2/payments/authorizations/".$payment_id;
	//show($url);
	
	$curl2 = curl_init($url);
	curl_setopt($curl2, CURLOPT_URL, $url);
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl2, CURLOPT_VERBOSE, true);
	
	$headers = array(
    	"Content-Type: application/json",
    	//"PayPal-Request-Id: ".$id,
    	"Authorization: ".$token_type." ".$access_token
	);
	//show($headers);
	curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl2, CURLOPT_HEADER, true);
	
	//$data = json_encode($paypal_request);
	//curl_setopt($curl2, CURLOPT_POST,true);
	//curl_setopt($curl2, CURLOPT_POSTFIELDS, $data);
	
	$response = curl_exec($curl2);
	curl_close($curl2);
	show($response);
	$response = explode("\r", $response);
	$count = count($response)-1;
	$response = $response[$count];
	//show($response);
	$payment = json_decode($response);
    show($payment);
	show('here total ok');
	$payment_id = $payment->id;
	
	
	
	//а вот теперь каптурить
	
	$url = "https://api-m.sandbox.paypal.com/v2/payments/authorizations/".$payment_id."/capture";
	//show($url);
	
	$curl2 = curl_init($url);
	curl_setopt($curl2, CURLOPT_URL, $url);
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl2, CURLOPT_VERBOSE, true);
	
	$headers = array(
    	"Content-Type: application/json",
    	"PayPal-Request-Id: ".$id,
    	"Authorization: ".$token_type." ".$access_token
	);
	//show($headers);
	curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl2, CURLOPT_HEADER, true);
	
	
	$paypal_request = array(
		"amount" => $payment->amount,
		"final_capture" => true,
		"note_to_payer" => ""
	);
	$data = json_encode($paypal_request);
	curl_setopt($curl2, CURLOPT_POST,true);
	curl_setopt($curl2, CURLOPT_POSTFIELDS, $data);
	
	$response = curl_exec($curl2);
	curl_close($curl2);
	
	
	show($response);
	$response = explode("\r", $response);
	$count = count($response)-1;
	$response = $response[$count];
	//show($response);
	
	$resp_obj = json_decode($response);
    show($resp_obj);
	
	
	
	show('and stop again');
	
	exit();
	
	
	if($resp_obj->status == 'PENDING'){
		$Db->q("UPDATE `ws_abonament_client` SET is_paid = 1 WHERE id = ".$id);
		header('Location: '.$CCpu->writelink(80)."?section=subscription");
	}else{
		$_SESSION['paypal_msg'] = 'Оплату не удалось завершить';
		header('Location: '.$CCpu->writelink(95));
	}
	exit();
	
	//а вот теперь принимать
	$url = "https://api-m.sandbox.paypal.com/v2/payments/captures/".$resp_obj->id;
	//show($url);
	
	$curl2 = curl_init($url);
	curl_setopt($curl2, CURLOPT_URL, $url);
	curl_setopt($curl2, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl2, CURLOPT_VERBOSE, true);
	
	$headers = array(
    	"Content-Type: application/json",
    	//"PayPal-Request-Id: ".$id,
    	"Authorization: ".$token_type." ".$access_token
	);
	//show($headers);
	curl_setopt($curl2, CURLOPT_HTTPHEADER, $headers);
	curl_setopt($curl2, CURLOPT_HEADER, true);
	
	//$data = json_encode($paypal_request);
	//curl_setopt($curl2, CURLOPT_POST,true);
	//curl_setopt($curl2, CURLOPT_POSTFIELDS, $data);
	
	$response = curl_exec($curl2);
	curl_close($curl2);
	//show($response);
	$response = explode("\r", $response);
	$count = count($response)-1;
	$response = $response[$count];
	show('final');
	show($response);
	$payment = json_decode($response);
    show($payment);
	
	
	
	
	
	exit();
	
    
	if($resp_obj->status == 'COMPLETED'){
		$Db->q("UPDATE `ws_abonament_client` SET is_paid = 1 WHERE id = ".$id);
		header('Location: '.$CCpu->writelink(80)."?section=subscription");
	}else{
		$_SESSION['paypal_msg'] = 'Оплату не удалось завершить';
		header('Location: '.$CCpu->writelink(95));
	}
	
	?>
</body>
</html>