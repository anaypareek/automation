<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use OTPHP\TOTP;

class FyersAutomation extends CI_Controller {

    private $app_id = "CAQOD0H5N3";
    private $app_type = "100";
    private $secret_key = "ECJZW3EEK0";
    private $client_id;
    private $state = "verifyanay";

    private $fy_id = "XA33665";
    private $app_id_type = "2";
    private $totp_key = "XAJD2F44ZPWDL4D24EGMET43TLIC7NUF";
    private $pin = "2208";
    private $redirect_uri = "https://www.fineoutput.co.in/automation/redirect";
    private $response_type = 'code';
    private $grant_type = 'authorization_code';

    // API Endpoints
    private $base_url = "https://api-t2.fyers.in/vagator/v2";
    private $base_url_2 = "https://api.fyers.in/api/v2";
    private $base_url_3 = "https://api-t1.fyers.in/api/v3";
    private $url_send_login_otp;
    private $url_verify_totp;
    private $url_verify_pin;
    private $url_token;
    private $url_validate_auth_code;
    private $SUCCESS = 1;
    private $ERROR = -1;

    public function __construct() {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->helper('url');
        $this->load->library('session');
        // $this->load->helper('json');
        $this->load->library('curl');

        $this->client_id = $this->app_id . '-' . $this->app_type;
        $this->url_send_login_otp = $this->base_url . "/send_login_otp";
        $this->url_verify_totp = $this->base_url . "/verify_otp";
        $this->url_verify_pin = $this->base_url . "/verify_pin";
        $this->url_token = $this->base_url_3 . "/token";
        $this->url_validate_auth_code = "https://api-t1.fyers.in/api/v3/validate-authcode";
    }

    private function send_login_otp($fy_id, $app_id) {
        try {
            $post_data = json_encode(array('fy_id' => $fy_id, 'app_id' => $app_id));
            $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api-t2.fyers.in/vagator/v2/send_login_otp',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>$post_data,
  CURLOPT_HTTPHEADER => array(
    'Content-Type: text/plain',
    'Cookie: __cf_bm=58skUN_q1HTeHKvBpICK_4GD5Jfis0V68dOYRhRaL_k-1726828355-1.0.1.1-3Gy_XjyL5ZMn_qWEkLFOWStSS7oArRS9yLftDryF7Shf5u3Ot8.rH_P1J0xKj3Brmklu28jmV9Jua4cdwfVA4Q; _cfuvid=vU8B2bi1DkMhGgO8rDl8poOcqjtepuDCAkqQWvho5XI-1726828355662-0.0.1.1-604800000'
  ),
));

$response = curl_exec($curl);
  // print_r($response);
curl_close($curl);

            // print_r($response);
            if (!$response) {
                return array($this->ERROR, "Error in request");
            }
            $result = json_decode($response, true);
            $request_key = $result['request_key'];
            return array($this->SUCCESS, $request_key);
        } catch (Exception $e) {
            return array($this->ERROR, $e->getMessage());
        }
    }

    private function verify_totp($request_key, $totp) {
        try {
          $totp = $this->totp_code();
          $request_key;
          $post_data = json_encode(array('request_key' => $request_key, 'otp' => $totp));
          $curl = curl_init();

          curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://api-t2.fyers.in/vagator/v2/verify_otp',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'POST',
            CURLOPT_POSTFIELDS =>$post_data,
            CURLOPT_HTTPHEADER => array(
              'Content-Type: application/json',
              'Cookie: _cfuvid=vU8B2bi1DkMhGgO8rDl8poOcqjtepuDCAkqQWvho5XI-1726828355662-0.0.1.1-604800000'
            ),
          ));

          $response = curl_exec($curl);
  // print_r($response);
          curl_close($curl);

            if (!$response) {
                return array($this->ERROR, "Error in request");
            }
            $result = json_decode($response, true);
            $request_key = $result['request_key'];
            return array($this->SUCCESS, $request_key);
        } catch (Exception $e) {
            return array($this->ERROR, $e->getMessage());
        }
    }

    public function automation() {
        // Step 1 - Retrieve request_key from send_login_otp API
        $send_otp_result = $this->send_login_otp($this->fy_id, $this->app_id_type);
        // print_r($send_otp_result);

        if ($send_otp_result[0] != $this->SUCCESS) {
            exit();
        } else {
            // echo "send_login_otp success";
        }

        // Step 2 - Verify totp and get request key from verify_otp API
        for ($i = 1; $i <= 3; $i++) {
            $request_key = $send_otp_result[1];
            // print_r($request_key);
            // $this->load->library('totp'); // Make sure you have a TOTP library or helper in PHP

            $verify_totp_result = $this->verify_totp($request_key, $this->totp_code());
              // print_r($verify_totp_result);
            if ($verify_totp_result[0] != $this->SUCCESS) {
                sleep(1);
            } else {
                break;
            }
        }

        $request_key_2 = $verify_totp_result[1];
        // print_r($request_key_2);
        // Step 3 - Verify pin and send back access token
        $session = curl_init();
        $payload_pin = json_encode(array(
            'request_key' => $request_key_2,
            'identity_type' => 'pin',
            'identifier' => $this->pin,
            'recaptcha_token' => ''
        ));

        curl_setopt($session, CURLOPT_URL, $this->url_verify_pin);
        curl_setopt($session, CURLOPT_POST, 1);
        curl_setopt($session, CURLOPT_POSTFIELDS, $payload_pin);
        curl_setopt($session, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($session, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));

        $res_pin = json_decode(curl_exec($session), true);
        // print_r($res_pin);
        curl_close($session);

        $access_token = $res_pin['data']['access_token'];
        // print_r($access_token);
        // Update the 'authorization' header using string concatenation
        $this->curl->http_header('authorization', 'Bearer ' . $access_token);

        // Token generation
        $authParam = array(
            "fyers_id" => $this->fy_id,
            "app_id" => $this->app_id,
            "redirect_uri" => $this->redirect_uri,
            "appType" => $this->app_type,
            "code_challenge" => "",
            "state" => "None",
            "scope" => "",
            "nonce" => "",
            "response_type" => "code",
            "create_cookie" => true
        );

        $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $this->url_token,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>json_encode($authParam),
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
     'authorization: Bearer '.$access_token,
    'Cookie: _cfuvid=vU8B2bi1DkMhGgO8rDl8poOcqjtepuDCAkqQWvho5XI-1726828355662-0.0.1.1-604800000'
  ),
));

        $response22 = curl_exec($curl);
        // print_r($response22);
        // exit;
        curl_close($curl);
        $authres =  json_decode($response22);
          // print_r($authres);
        // $authres = json_decode($this->curl->simple_post($this->url_token, json_encode($authParam), array(CURLOPT_HTTPHEADER => array('Content-Type: application/json'))), true);
        $url = $authres->Url;
        $parsed_url = parse_url($url);
        parse_str($parsed_url['query'], $query_params);
        $auth_code = $query_params['auth_code'];

        // print_r($auth_code);
        // exit;

        if ($auth_code) {
            $token_response = $this->exchange_auth_code($auth_code,$access_token);
            // print_r($token_response);
            // exit;
            if (isset($token_response['access_token'])) {
              $ip ="9999999999";
            date_default_timezone_set("Asia/Calcutta");
              $cur_date=date("Y-m-d H:i:s");

              $data_insert = array('auth_code'=>trim($token_response['access_token']),
                        'ip' =>$ip,
                        'date'=>$cur_date
                        );

              $last_id=$this->base_model->insert_table("tbl_config",$data_insert,1) ;
            } else {
                echo "Error exchanging auth code for token";
            }
        } else {
            echo "Authorization code missing";
        }



    }

    // Example to use TOTP in your function
   private function generate_totp_code($totp_key) {
       // Create a TOTP object
       $totp = TOTP::create($totp_key);

       // Get the current TOTP code
       $current_otp = $totp->now();

       return $current_otp;
   }

   public function totp_code() {
       $secret_key = "XAJD2F44ZPWDL4D24EGMET43TLIC7NUF";  // Your TOTP secret key
       $otp_code = $this->generate_totp_code($secret_key);
       return $otp_code;
   }

   // Function to generate the authorization URL
   public function generate_authcode_url() {
       $auth_url = $this->base_url . "/auth";
       $params = http_build_query(array(
           'client_id' => $this->client_id,
           'redirect_uri' => $this->redirect_uri,
           'response_type' => $this->response_type,
           'state' => 'random_state'  // Replace with a unique state string
       ));
       return $auth_url . '?' . $params;
   }

   public function some_function() {
       $auth_url = $this->generate_authcode_url();
       echo "Authorization URL: " . $auth_url;
   }

   // Function to exchange authorization code for access token
    public function exchange_auth_code($auth_code,$access_token) {
        $url = $this->url_validate_auth_code;
        // Concatenate app_id and app_secret with a colon
$string_to_hash = $this->app_id . ':' . $this->secret_key;

// Compute the SHA-256 hash
$sha256_hash = hash('sha256', $string_to_hash);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api-t1.fyers.in/api/v3/validate-authcode',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
    "grant_type":"authorization_code",
    "appIdHash":"817a02fd7b3085afc60ce4804c8d5aae06c7a754c25dc3a59c94869a06e1f772",
    "code":"'.$auth_code.'"
}',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Cookie: __cf_bm=DPlG.x0jQlrQaoFdZ25T3SVCr7Udb47ShjDNW0QIoQI-1726835547-1.0.1.1-P2BCRtydoIgidpcQxVF5mWWodVjeSJ7dTEvZ2ifn5FLy1dsPn7DlRTSZ0BKQcrhx52TJVRoUaKkfGXxFYzdKzg; _cfuvid=vU8B2bi1DkMhGgO8rDl8poOcqjtepuDCAkqQWvho5XI-1726828355662-0.0.1.1-604800000'
  ),
));

$response = curl_exec($curl);

curl_close($curl);
// echo $response;


        // print_r($response);
        if ($response === false) {
            return curl_error($curl);
        }
        curl_close($curl);

        return json_decode($response, true);
    }

    // Example callback function after user is redirected
    public function redirect() {
        $auth_code = $this->input->get('auth_code');
        if ($auth_code) {
            $token_response = $this->exchange_auth_code($auth_code);
            if (isset($token_response['access_token'])) {
                echo "Access Token: " . $token_response['access_token'];
            } else {
                echo "Error exchanging auth code for token";
            }
        } else {
            echo "Authorization code missing";
        }
    }
}
