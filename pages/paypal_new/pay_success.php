<!DOCTYPE html>
<html lang="<?=$CCpu->lang?>" class="page">
<head>
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/head.php")?>
</head>
<body class="page__body" id="body">
<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/header.php")?>
<main class="main">
    <?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/breadcrumbs.php")?>
        <div id="container">
                <div class="section-title">
                    <h2><?=$page_data['title']?></h2>
                </div>
            <? if( isset($_GET['token']) && !empty($_GET['token']) ) { // Token parameter exists
                include($_SERVER['DOCUMENT_ROOT']."/arkanum/include/CPaypal.php");
                // Get checkout details, including buyer information.
                // We can save it for future reference or cross-check with the data we have
                $paypal = new Paypal();
                // получаем информацию об оплате
                $checkoutDetails = $paypal -> request('GetExpressCheckoutDetails', array('TOKEN' => filter_var($_GET['token'], FILTER_SANITIZE_STRING)));
                $GetExpressCheckoutDetailsRESPONSE = serialize($checkoutDetails);
                // готовим информацию о заказе
                $_SESSION['pay']['sum'] = 0.01;

                $itemsParams = array();
                $itemsParams['L_PAYMENTREQUEST_0_NAME0'] = 'Refil account';
                $itemsParams['L_PAYMENTREQUEST_0_DESC0'] = 'Refil account in system';
                $itemsParams['L_PAYMENTREQUEST_0_AMT0'] = $_SESSION['pay']['sum'];
                $itemsParams['L_PAYMENTREQUEST_0_QTY0'] = 1;

                $orderParams = array(
                    'PAYMENTREQUEST_0_AMT' => $_SESSION['pay']['sum'],
                    // 'PAYMENTREQUEST_0_SHIPPINGAMT' => '0',
                    'PAYMENTREQUEST_0_CURRENCYCODE' => 'USD',
                    'PAYMENTREQUEST_0_ITEMAMT' => $_SESSION['pay']['sum'] // 1+2
                );

                $itemsParams['PAYMENTREQUEST_0_AMT'] = $_SESSION['pay']['sum'];
                //$itemsParams['PAYMENTREQUEST_0_SHIPPINGAMT'] = 0;
                $itemsParams['PAYMENTREQUEST_0_CURRENCYCODE'] = "USD";
                $itemsParams['PAYMENTREQUEST_0_ITEMAMT'] = $_SESSION['pay']['sum'];

                // Complete the checkout transaction
                $requestParams = array(
                    'PAYMENTACTION' => 'Sale',
                    'PAYERID' => filter_var($_GET['PayerID'], FILTER_SANITIZE_STRING),
                    'TOKEN' => filter_var($_GET['token'], FILTER_SANITIZE_STRING),
                    'AMT'=>$_SESSION['pay']['sum'],
                    'CURRENCYCODE' => "USD",
                    //'PAYMENTREQUEST_0_PAYMENTACTION' => urlencode("SALE"),
                );
                //array_push($requestParams, $itemsParams);
                $response = $paypal -> request('DoExpressCheckoutPayment',$requestParams);
                if(is_array($response) &&
                    ($response['ACK'] == 'Success' || $response['PAYMENTINFO_0_ACK']=='Success' || strripos($response['PAYMENTINFO_0_ACK'], 'success'))
                ){
                    // Payment successful
                    // We'll fetch the transaction ID for internal bookkeeping
                    $transactionId = $response['PAYMENTINFO_0_TRANSACTIONID'];
                    $paymentStatus = $response['PAYMENTSTATUS'];
                }else{
                    $ERRORS_PAYMENT[]=$GLOBALS['ar_define_langterms']['MSG_PAY_ERROR_TRANZACTION']." ".$response['PAYMENTINFO_0_ERRORCODE'].". ".$GLOBALS['ar_define_langterms']['MSG_PAY_TRANZACTION_NUMBER']." ".$transactionId;
                }
                /*if( $_SESSION['mypay']['TOKEN']!=$clear_request['token'] ){
                    $ERRORS_PAYMENT[]="Ошибка аутентификации пользователя!";
                }*/
                if( empty($ERRORS_PAYMENT) ){?>
                    <h4 style="color: forestgreen">Успешная оплата</h4>
                    <? echo $page_data['text'];
                    mysqli_query($db,"UPDATE ws_orders SET `status` = '4', `pay_status` = '2' WHERE id = '".$_SESSION['order_id_pay']."' ");

                }else{?>
                    <div style="color: darkred;font-weight: bold">Ошибка транзакции</div>
                    <?foreach ($ERRORS_PAYMENT as $key => $value) {?>
                        <div style="color: red"><?=$value?></div>
                        <?
                    }
                }
            }?>
            <div class="col-xs-12">
                <?=$page_data['text']?>
            </div>
</main>
<?include($_SERVER['DOCUMENT_ROOT']."/pages/blocks/footer.php")?>

</body>

</html>
