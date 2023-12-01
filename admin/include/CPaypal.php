<?
class Paypal {
   /**
    * Last error message(s)
    * @var array
    */
   protected $_errors = array();

   /**
    * API Credentials
    * Use the correct credentials for the environment in use (Live / Sandbox)
    * @var array
    */
   /* protected $_credentials = array(
      'USER' => 'info_api1.metalworking.pro',
      'PWD' => 'EPEB28HERUQYHEM6',
      'SIGNATURE' => 'ATi7jbS4Bca6-.zkJdlSdtwS8k5CAXCXDke0He6prkh9INDR1PmAdudy',
   ); */
   
   /* protected $_credentials = array(
      'USER' => 'sb-motcu6031023_api1.business.example.com',
      'PWD' => 'HKT6PGNRA5VFJ7ZN',
      'SIGNATURE' => 'AUrLuJK9kEnBg.88TtC9aKnsFPPCAnKHfKUVpE4MtSPej7--vSgziE51',
   ); */
   
   /* здесь настоящиие доступы */
   protected $_credentials = array(
      'USER' => 'reabovstock_api1.gmail.com',
      'PWD' => '3BG3M2K8WFZFP3WR',
      'SIGNATURE' => 'ANXwMECR--C7lF93Rhq3y5CAX3.KA8oYVjgfXkFEvJCJAixPEpCgmfhU',
   );
   
   
   /*
    * Merchant IDEEFXWY45453Y2
    * 
    * 	Credential	API Signature
		API Username	y_okuneva_api1.inbox.ru
		API Password	SDMPVCJTD63WRQXZ
		Signature	AiPC9BjkCyDFQXbSkoZcgqH3hpacAXaJIbaD9v30b5uJIp5FpT.HgtXE
		Request Date	12 Feb 2015 13:52:01 GMT+01:00
    * 
    * 'USER' => 'barcov.vadim-facilitator_api1.amoresparaiso.com',
      'PWD' => '1407930424',
      'SIGNATURE' => 'AFcWxV21C7fd0v3bYYYRCpSSRl31ASFbeSiu--uKFNgs0L0iT032wSK5'
    * 
    * 
    * */

   /**
    * API endpoint
    * Live - https://api-3t.paypal.com/nvp
    * Sandbox - https://api-3t.sandbox.paypal.com/nvp
    * @var string
    */
  	//protected $_endPoint = 'https://api-3t.sandbox.paypal.com/nvp';
	
	protected $_endPoint = 'https://api-3t.paypal.com/nvp';
	
	
   /**
    * API Version
    * @var string
    */
   protected $_version = '98.0';

   /**
    * Make API request
    *
    * @param string $method string API method to request
    * @param array $params Additional request parameters
    * @return array / boolean Response array / boolean false on failure
    */
   public function request($method,$params = array()) {
      $this -> _errors = array();
      if( empty($method) ) { //Check if API method is not empty
         $this -> _errors = array('API method is missing');
         return false;
      }

      //Our request parameters
      $requestParams = array(
         'METHOD' => $method,
         'VERSION' => $this -> _version
      ) + $this -> _credentials;

      //Building our NVP string
      $request = http_build_query($requestParams + $params);

      //cURL settings
      $curlOptions = array (
         CURLOPT_URL => $this -> _endPoint,
         CURLOPT_VERBOSE => 1,
         CURLOPT_SSL_VERIFYPEER => 0,
         CURLOPT_SSL_VERIFYHOST => 0,
         //CURLOPT_CAINFO => dirname(__FILE__) . '/cacert.pem', //CA cert file
         CURLOPT_RETURNTRANSFER => 1,
         CURLOPT_POST => 1,
         CURLOPT_POSTFIELDS => $request
      );

      $ch = curl_init();
      curl_setopt_array($ch,$curlOptions);

      //Sending our request - $response will hold the API response
      $response = curl_exec($ch);

      //Checking for cURL errors
      if (curl_errno($ch)) {
         $this -> _errors = curl_error($ch);
         curl_close($ch);
         return false;
         //Handle errors
      } else  {
         curl_close($ch);
         $responseArray = array();
         parse_str($response,$responseArray); // Break the NVP string to an array
         return $responseArray;
      }
   }
}
?>