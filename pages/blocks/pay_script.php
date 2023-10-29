<?



            $price_client = $Db->getone(" SELECT * FROM `ws_abonament_client` WHERE id = ".$price_client_id);
			$abonoment = $Db->getone("SELECT * FROM `ws_abonament` WHERE id = ".$price_client['ab_id']);
			
			$months['ru'] = array('января','февраля','марта','апреля','мая','июня','июля','августа','сентября','октября','ноября','декабря');
			$months['en'] = array('january','february','march','april','may','june','july','august','september','october','november','december');
			
			$day_start = date('d', strtotime($price_client['ab_start']));
			$day_end = date('d', strtotime($price_client['ab_end']));
			
			$month_start = date('n', strtotime($price_client['ab_start']));
			$month_start = $month_start-1;
			$month_start = $months[$CCpu->lang][$month_start];
			$month_end = date('n', strtotime($price_client['ab_end']));
			$month_end = $month_end-1;
			$month_end = $months[$CCpu->lang][$month_end];
			
			$year_start = date('Y', strtotime($price_client['ab_start']));
			$year_end = date('Y', strtotime($price_client['ab_end']));
			
			
			
			$price = $abonoment['price'];
			$price_number = $price;
			if($price < 100){
				//$price_number = '0'.$price_number;
			}
			if($price < 10){
				//$price_number = '0'.$price_number;
			}



	$number_form = number_format($price,2,'.','');
	//show($number_form);
	
	//$number_form = "2.75";
	
	include($_SERVER['DOCUMENT_ROOT']."/".WS_PANEL."/include/CPaypal.php");
	$prot = 'http';
	if ( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] != 'off' ) {
	    $prot = 'https';
	}
	$requestParams = array(
	    'RETURNURL' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$CCpu->writelink(94),
        'CANCELURL' => $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$CCpu->writelink(95)
    );
	
    $orderParams = array(
        'PAYMENTREQUEST_0_AMT' => $number_form ,
       	// 'PAYMENTREQUEST_0_SHIPPINGAMT' => '0',
       	'PAYMENTREQUEST_0_CURRENCYCODE' => $GLOBALS['ar_define_langterms']['MSG_SUBSCRIBES_EUR'],
        'PAYMENTREQUEST_0_ITEMAMT' => $number_form // 1+2
    );

    $paypal = new Paypal();
    $response = $paypal->request( 'SetExpressCheckout' , $requestParams + $orderParams );

    //show($response);

    if( is_array( $response ) && ( $response['ACK'] == 'Success' || "SUCCESSWITHWARNING" == strtoupper( $response["ACK"] ) || "SUCCESS" == strtoupper( $response["ACK"] ) ) ){
	    	
	    //$_SESSION['mypay'] = $response;
		$token = $response['TOKEN'];
	    //header( 'Location: https://www.paypal.com/webscr?cmd=_express-checkout&token=' . urlencode($token) );
        
        //$pay_link = "https://www.sandbox.paypal.com/webscr?cmd=_express-checkout&token=".urlencode($token);
        $pay_link = "https://www.paypal.com/webscr?cmd=_express-checkout&token=".urlencode($token);
        $Db->q("UPDATE `ws_abonament_client` SET paypal_token = '".$token."' WHERE id = ".$price_client_id);
		
	}else{
		$pay_link = "";
	}
	
	
?>

	<script>
    	
    	function pay_subscribe(){
    		var pay_method = $('.accept-method .s.s-activ').data('value');
    		var terms = $('#accept_terms').hasClass('s-activ');
    		var policy = $('#accept_policy').hasClass('s-activ');
    		
    		var err = 0;
    		
    		if(pay_method == undefined){
    			err = 1;
    			show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_VYBERITE_VARIANT_OPLATY']?>');
    		}
    		if(!terms){
    			err = 1;
    			show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_NEOBHODIMO_OTMETITI_SVOYO_SOGLASIE_S_USLOVIYAMI']?>');
    		}
    		if(!policy){
    			err = 1;
    			show_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_NEOBHODIMO_OTMETITI_SVOYO_SOGLASIE_S_POLITIKOJ']?>');
    		}
    		
    		//здесь заглушка на систему оплаты, пока она проходит автоматически
    		if(err == 0){
    			
    			if(pay_method == 'pay'){
    				<?/* window.open("<?=$pay_link?>", "_blank"); */?>
    				<?
    				if($pay_link != ""){
    					?>
    				location.href = "<?=$pay_link?>";	
    					<?
    				}else{
    					?>
    				show_ext_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_PROIZOSHLA_OSHIBKA_V_SISTEME_OPLATY']?>');
    					<?
    				}
    				?>
    				
    			}else{
    				$.ajax({
    					type: 'POST',
    					url: '<?=$CCpu->writelink(3)?>',
    					data: 'task=pay_subscribe&id=<?=$price_client_id?>',
    					success: function(msg){
    						//console.log(msg);
    						if($.trim(msg) == 'ok'){
    							location.href = '<?=$CCpu->writelink(80)?>?section=subscription';
    						}else{
    							show_ext_not('<?=$GLOBALS['ar_define_langterms']['MSG_MESSAGE_OPLATU_PROIZVESTI_NE_UDALOSI']?>');
    						}
    						check_notifications();
    					}
    				})
    			}
    			
    		}
    		
    	}
    	
        function setO(btn){
            $('.a').children().removeClass('s-activ');
            $(btn).children('.a').children().toggleClass('s-activ');
            // $('.a').children().toggleClass('s-activ');
        }
        function setAll1(){
            $('.ac1').children().toggleClass('s-activ');
            // $(btn).children('.a').children().toggleClass('s-activ');
            // $('.a').children().toggleClass('s-activ');
        }
        function setAll2(){
            $('.ac2').children().toggleClass('s-activ');
            // $(btn).children('.a').children().toggleClass('s-activ');
            // $('.a').children().toggleClass('s-activ');
        }
        
        function setAreaProfile(){
            $('.area__detals').toggleClass('area-profile');
        }
    </script>

