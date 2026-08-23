<?php if (! defined('BASEPATH')) { exit('No direct script access allowed'); }
require_once(APPPATH . 'core/CI_finecontrol.php');
class Redirect extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }


  public function index(){

// $url="https://www.fineoutput.co.in/automation/redirect?s=ok&code=200&auth_code=eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJhcGkubG9naW4uZnllcnMuaW4iLCJpYXQiOjE2NTg3NDc0MjYsImV4cCI6MTY1ODc3NzQyNiwibmJmIjoxNjU4NzQ2ODI2LCJhdWQiOiJbXCJ4OjBcIiwgXCJ4OjFcIiwgXCJ4OjJcIiwgXCJkOjFcIiwgXCJkOjJcIiwgXCJ4OjFcIiwgXCJ4OjBcIl0iLCJzdWIiOiJhdXRoX2NvZGUiLCJkaXNwbGF5X25hbWUiOiJYQTMzNjY1Iiwibm9uY2UiOiIiLCJhcHBfaWQiOiJDQVFPRDBINU4zIiwidXVpZCI6IjI0YzNiMjI2ZDQwZjQ5N2VhNmIwYmMwNzI3YmNiZDA0IiwiaXBBZGRyIjoiMC4wLjAuMCIsInNjb3BlIjoiIn0.p_gQgrJFAB6-r8hNtlToApKT-4DG7k3AmD_VnZf0ejA&state=verifyanay";

// parse_str($str, $arr);
// print_r($arr);

$s = $this->input->get('s');
if($s == "ok"){

  $ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
  $cur_date=date("Y-m-d H:i:s");

$auth_code = $this->input->get('auth_code');

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fyers.in/api/v2/validate-authcode',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{"grant_type":"authorization_code","appIdHash":"817a02fd7b3085afc60ce4804c8d5aae06c7a754c25dc3a59c94869a06e1f772","code":"'.$auth_code.'"}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json'
  ),
));


$response2 = curl_exec($curl);

curl_close($curl);
// echo $response;
 $r2 = json_decode($response2);
 // log_message('error', "CHECKING - ".$response2);
 // log_message('error', "CHECKING - ".$r2->access_token);

if($r2->s == "ok"){
  $access_token = $r2->access_token;
$data_insert = array('auth_code'=>trim($access_token),
          'ip' =>$ip,
          'date'=>$cur_date
          );

$last_id=$this->base_model->insert_table("tbl_config",$data_insert,1) ;

if($last_id!=0){
  echo "Data Updated Successfully";
  exit;
}

}

if($r2->s == "error"){
  echo $r2->message;
  exit;
}





}


  }



            public function pythonUpdate()

              {

                $raw_data = file_get_contents('php://input');

   // Decode the JSON data (assuming it's JSON)
   $data = json_decode($raw_data, true);

   // Check if JSON decoding was successful
   if ($data !== null) {

     $ip = $this->input->ip_address();
     date_default_timezone_set("Asia/Calcutta");
     $cur_date=date("Y-m-d H:i:s");

     $data_insert = array('auth_code'=>trim($data['access_code']),
               'ip' =>$ip,
               'date'=>$cur_date
               );

     $last_id=$this->base_model->insert_table("tbl_config",$data_insert,1) ;


                 if($last_id!=0){

                   echo "success";
                   exit;
                         }
                         else
                         {

                         }


   }







          }



public function test_hdfc(){
  // $curl = curl_init();
  //
  // curl_setopt_array($curl, array(
  //   CURLOPT_URL => 'https://smartgateway.hdfcbank.com/orders/ORD20241340000400001',
  //   CURLOPT_RETURNTRANSFER => true,
  //   CURLOPT_ENCODING => '',
  //   CURLOPT_MAXREDIRS => 10,
  //   CURLOPT_TIMEOUT => 0,
  //   CURLOPT_FOLLOWLOCATION => true,
  //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  //   CURLOPT_CUSTOMREQUEST => 'GET',
  //   CURLOPT_HTTPHEADER => array(
  //     'Authorization: Basic OUEyMTNERDk4RDE0MkI3OEE3NzcxMEExMTRGMkNE',
  //     'version: 2023-06-30',
  //     'Content-Type: application/x-www-form-urlencoded',
  //     'x-merchantid: 37464',
  //     'x-customerid: 12312434'
  //   ),
  // ));
  //
  // $response = curl_exec($curl);
  //
  //
  // // echo $response;
  // $a =json_decode($response);
  //
  // print_r($a);

  // Define necessary variables
  $orderId = "ORD20241340000400001"; // Replace with actual order ID
  $apiKey = "OUEyMTNERDk4RDE0MkI3OEE3NzcxMEExMTRGMkNE"; // Replace with your base64-encoded API key
  $merchantId = "37464"; // Replace with actual merchant ID
  $customerId = "12312434"; // Replace with actual customer ID

  // Initialize cURL
  $ch = curl_init();

  // Set cURL options
  curl_setopt($ch, CURLOPT_URL, "https://smartgateway.hdfcbank.com/orders/$orderId");
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return the response as a string
  curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects

  // Set the headers
  curl_setopt($ch, CURLOPT_HTTPHEADER, [
      "Authorization: Basic $apiKey",
      "version: 2023-06-30",
      "Content-Type: application/x-www-form-urlencoded",
      "x-merchantid: $merchantId",
      "x-customerid: $customerId",
      "User-Agent: PostmanRuntime/7.28.4"
  ]);

  // Execute the request
  $response = curl_exec($ch);

  // Check for cURL errors
if (curl_errno($ch)) {
    echo 'cURL error: ' . curl_error($ch);
} else {
    // Output the full response (headers + body)
    echo $response;

    // Optionally, inspect the HTTP status code and headers
    $info = curl_getinfo($ch);
    echo "\n\nHTTP Code: " . $info['http_code'];
    echo "\n\nFinal URL: " . $info['url'];
}

  // Close the cURL session
  curl_close($ch);


}


}
