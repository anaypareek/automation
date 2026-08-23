<?php if (! defined('BASEPATH')) { exit('No direct script access allowed'); }
require_once(APPPATH . 'core/CI_finecontrol.php');
class ManualOrder extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }


  public function buyce_market(){

   $price = $this->get_price(STOCKCE);
   $auth_code = $this->auth_code();

$qty2 = AMOUNT/$price;
$qty3 = floor($qty2/50);
$qty = $qty3 - 0;

$exit_order = $price * PERCENTAGE/100;
$exit_order_amount2 = $price + $exit_order;
$exit_order_amount = round($exit_order_amount2 * 2, 1) / 2;


$sl_exit_order = $price * SL/100;
$sl_exit_order_amount2 = $price - $exit_order;
$sl_exit_order_amount = round($sl_exit_order_amount2 * 2, 1) / 2;
// echo $exit_order_amount;
// exit;
$buy_qty = $qty * 50;
echo $buy_qty;
exit;
   // PLACING THE ORDER ON PORTAL

   $curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fyers.in/api/v2/orders',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'POST',
  CURLOPT_POSTFIELDS =>'{
  "symbol":"'.STOCKCE.'",
  "qty":'.$buy_qty.',
  "type":2,
  "side":1,
  "productType":"INTRADAY",
  "limitPrice":0,
  "stopPrice":0,
  "validity":"IOC",
  "disclosedQty":0,
  "offlineOrder":"False",
  "stopLoss":0,
  "takeProfit":0
  }',
  CURLOPT_HTTPHEADER => array(
    'Content-Type: application/json',
    'Authorization: CAQOD0H5N3-100:'.$auth_code,

  ),
));

$response = curl_exec($curl);

curl_close($curl);
$r= json_decode($response);

if($r->s == "ok"){

  $curl2 = curl_init();

  curl_setopt_array($curl2, array(
    CURLOPT_URL => 'https://api.fyers.in/api/v2/orders?id='.$r->id,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Authorization: CAQOD0H5N3-100:'.$auth_code
    ),
  ));

  $response2 = curl_exec($curl2);

  curl_close($curl2);
  $r2 = json_decode($response2);

$status = $r2->s;

if($status == "ok"){
  $book = $r2->orderBook;
  $time = $book[0]->orderDateTime;
  $t_price = $book[0]->tradedPrice;

  $ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
  $cur_date=date("Y-m-d H:i:s");
$data_insert = array('stock'=>STOCKCE,
          'type'=>1,
          'buy_amount'=>$t_price,
          'target_amount'=>$exit_order_amount,
          'order_id'=>$r->id,
          'trade_status'=>1,
          'sl'=>$sl_exit_order_amount,
        'qty' =>$buy_qty,
          'buy_time' =>$cur_date,
          'status' =>1,
          'ip' =>$ip,
          'date'=>$cur_date
          );

$last_id=$this->base_model->insert_table("tbl_manual_order",$data_insert,1) ;
// sleep(10);

if($last_id!=0){
  echo "Order Placed at ₹".$t_price." Successfully and exit at ".$exit_order_amount." !! and SL is ".$sl_exit_order_amount."!!";
  exit;
}
else{
  echo "Error Occured";
  exit;
}

} // status ok ending here

} // status ok ending of order placing api

  }

  public function buype_market(){
    $auth_code = $this->auth_code();
    $price = $this->get_price(STOCKPE);
    // echo $price;
    // exit;

    $qty2 = round(AMOUNT/$price);
    $qty3 = floor($qty2/50);
    $qty = $qty3 - 0;
$buy_qty = $qty * 50;
    $exit_order = $price * PERCENTAGE/100;
    $exit_order_amount2 = $price + $exit_order;
$exit_order_amount = round($exit_order_amount2 * 2, 1) / 2;

$sl_exit_order = $price * SL/100;
$sl_exit_order_amount2 = $price - $exit_order;
$sl_exit_order_amount = round($sl_exit_order_amount2 * 2, 1) / 2;
    // PLACING THE ORDER ON PORTAL
// echo $price;
// exit;
    $curl = curl_init();
 curl_setopt_array($curl, array(
   CURLOPT_URL => 'https://api.fyers.in/api/v2/orders',
   CURLOPT_RETURNTRANSFER => true,
   CURLOPT_ENCODING => '',
   CURLOPT_MAXREDIRS => 10,
   CURLOPT_TIMEOUT => 0,
   CURLOPT_FOLLOWLOCATION => true,
   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
   CURLOPT_CUSTOMREQUEST => 'POST',
   CURLOPT_POSTFIELDS =>'{
   "symbol":"'.STOCKPE.'",
   "qty":'.$buy_qty.',
   "type":2,
   "side":1,
   "productType":"INTRADAY",
   "limitPrice":0,
   "stopPrice":0,
   "validity":"IOC",
   "disclosedQty":0,
   "offlineOrder":"False",
   "stopLoss":0,
   "takeProfit":0
   }',
   CURLOPT_HTTPHEADER => array(
     'Content-Type: application/json',
     'Authorization: CAQOD0H5N3-100:'.$auth_code
   ),
 ));

 $response = curl_exec($curl);

 curl_close($curl);
 $r= json_decode($response);

 if($r->s == "ok"){

   $curl2 = curl_init();

   curl_setopt_array($curl2, array(
     CURLOPT_URL => 'https://api.fyers.in/api/v2/orders?id='.$r->id,
     CURLOPT_RETURNTRANSFER => true,
     CURLOPT_ENCODING => '',
     CURLOPT_MAXREDIRS => 10,
     CURLOPT_TIMEOUT => 0,
     CURLOPT_FOLLOWLOCATION => true,
     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
     CURLOPT_CUSTOMREQUEST => 'GET',
     CURLOPT_HTTPHEADER => array(
       'Authorization: CAQOD0H5N3-100:'.$auth_code
     ),
   ));

   $response2 = curl_exec($curl2);

   curl_close($curl2);
   $r2 = json_decode($response2);

 $status = $r2->s;

 if($status == "ok"){
   // print_r()
   $book = $r2->orderBook;
   $time = $book[0]->orderDateTime;
   $t_price = $book[0]->tradedPrice;

   $ip = $this->input->ip_address();
 date_default_timezone_set("Asia/Calcutta");
   $cur_date=date("Y-m-d H:i:s");
 $data_insert = array('stock'=>STOCKPE,
           'type'=>2,
           'buy_amount'=>$t_price,
           'order_id'=>$r->id,
           'trade_status'=>1,
          'sl'=>$sl_exit_order_amount,
           'target_amount'=>$exit_order_amount,
         'qty' =>$buy_qty,
           'buy_time' =>$cur_date,
           'status' =>1,
           'ip' =>$ip,
           'date'=>$cur_date
           );

 $last_id=$this->base_model->insert_table("tbl_manual_order",$data_insert,1) ;
// sleep(10);

 if($last_id!=0){
   echo "Order Placed at ₹".$t_price." Successfully and exit at ".$exit_order_amount." !! and SL is ".$sl_exit_order_amount."!!";
   // sleep(10);
   // $this->exit_order_autocreate;
   exit;
 }
 else{
   echo "Error Occured";
   exit;
 }

 } // status ok ending here

 } // status ok ending of order placing api
  }

  public function sellce_market(){

  }

  public function sellpe_market(){

  }

  public function buyce_limit(){

  }

  public function buype_limit(){

  }

  public function sellce_limit(){

  }

  public function sellpe_limit(){

  }

//BUY AT MARKET AND CREATE EXIT ORDER WITH ₹10 PROFIT
public function buyce_market_exit10(){
 $price = $this->get_price(STOCKCE);
 $auth_code = $this->auth_code();
 // PLACING THE ORDER ON PORTAL

 $curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://api.fyers.in/api/v2/orders',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>'{
"symbol":"'.STOCKCE.'",
"qty":'.QTY.',
"type":2,
"side":1,
"productType":"INTRADAY",
"limitPrice":0,
"stopPrice":0,
"validity":"IOC",
"disclosedQty":0,
"offlineOrder":"False",
"stopLoss":0,
"takeProfit":0
}',
CURLOPT_HTTPHEADER => array(
  'Content-Type: application/json',
  'Authorization: CAQOD0H5N3-100:'.$auth_code,

),
));

$response = curl_exec($curl);

curl_close($curl);
$r= json_decode($response);

if($r->s == "ok"){

$curl2 = curl_init();

curl_setopt_array($curl2, array(
  CURLOPT_URL => 'https://api.fyers.in/api/v2/orders?id='.$r->id,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: CAQOD0H5N3-100:'.$auth_code
  ),
));

$response2 = curl_exec($curl2);

curl_close($curl2);
$r2 = json_decode($response2);

$status = $r2->s;

if($status == "ok"){
$book = $r2->orderBook;
$time = $book[0]->orderDateTime;
$t_price = $book[0]->tradedPrice;

$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");
$data_insert = array('stock'=>STOCKCE,
        'type'=>1,
        'buy_amount'=>$t_price,
        'order_id'=>$r->id,
        'qty' =>QTY,
        'buy_time' =>$cur_date,
        'status' =>1,
        'ip' =>$ip,
        'date'=>$cur_date
        );

$last_id=$this->base_model->insert_table("tbl_manual_order",$data_insert,1) ;

if($last_id!=0){

//CREATING EXIT ORDER OF ₹10

$exit_p = $t_pri + 5;


$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://api.fyers.in/api/v2/orders',
CURLOPT_RETURNTRANSFER => true,
CURLOPT_ENCODING => '',
CURLOPT_MAXREDIRS => 10,
CURLOPT_TIMEOUT => 0,
CURLOPT_FOLLOWLOCATION => true,
CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
CURLOPT_CUSTOMREQUEST => 'POST',
CURLOPT_POSTFIELDS =>'{
"symbol":"'.STOCKCE.'",
"qty":'.QTY.',
"type":1,
"side":-1,
"productType":"INTRADAY",
"limitPrice":0,
"stopPrice":0,
"validity":"IOC",
"disclosedQty":0,
"offlineOrder":"False",
"stopLoss":0,
"takeProfit":0
}',
CURLOPT_HTTPHEADER => array(
 'Content-Type: application/json',
 'Authorization: CAQOD0H5N3-100:'.$auth_code,

),
));

$response = curl_exec($curl);

curl_close($curl);
$r= json_decode($response);





echo "Order Placed at ₹".$t_price." Successfully !!";
exit;
}
else{
echo "Error Occured";
exit;
}

} // status ok ending here

} // status ok ending of order placing api

}



  public function exitorder_market(){
        // GET RUNNING ORDER ID FROM DATABASE
 $auth_code = $this->auth_code();
        $this->db->select('*');
                    $this->db->from('tbl_manual_order');
                    $this->db->where('status',1);
                    $this->db->order_by('id','DESC');
                    $dsa= $this->db->get();
                    $da=$dsa->row();
                  if(!empty($da)){
                      $order_id = $da->order_id;
                      $stock = $da->stock;
                      // SELL ORDER ON MARKET PRICE

                      $curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fyers.in/api/v2/positions',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'DELETE',
  CURLOPT_POSTFIELDS =>'{"id":"'.$order_id.'"}',
  CURLOPT_HTTPHEADER => array(
      'Content-Type: application/json',
     'Authorization: CAQOD0H5N3-100:'.$auth_code

  ),
));

$response = curl_exec($curl);

curl_close($curl);
echo $response;

$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");

$data_update = array(
        'sell_time' =>$cur_date,
        'status' =>2,
        'ip' =>$ip,
        'date'=>$cur_date
        );
        $this->db->where('id', $da->id);
            $zapak=$this->db->update('tbl_manual_order', $data_update);

exit;



                  }
                  else{
                    echo "No pending order found";
                    exit;
                  }

  }

  public function exitorder_limit($lm = ""){

  }

  public function get_price($symbol)
  {
 $auth_code = $this->auth_code();
// SYMBOL -> STOCK OR OPTION NAME
//
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.fyers.in/data-rest/v2/quotes/?symbols='.$symbol,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    'Authorization: CAQOD0H5N3-100:'.$auth_code
  ),
));

$response = curl_exec($curl);
$r = json_decode($response);
// foreach($response as $rr){
// print_r($r);
if($r->s=="error"){
return "err";
}
// }
// print_r($r->d);
// exit;
else{
$r1=$r->d;
$r2 = $r1[0];

$r3=$r2->v;
$r4=$r3->ask;

return $r4;
curl_close($curl);
}

}

public function order_check($symbol="2220603146742")
{
   $auth_code = $this->auth_code();
  $curl2 = curl_init();

  curl_setopt_array($curl2, array(
    CURLOPT_URL => 'https://api.fyers.in/api/v2/orders?id='.$symbol,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'GET',
    CURLOPT_HTTPHEADER => array(
      'Authorization: CAQOD0H5N3-100:'.$auth_code
    ),
  ));

  $response2 = curl_exec($curl2);

  curl_close($curl2);
  $r2 = json_decode($response2);
// print_r($r2);
  $status = $r2->s;
  // echo $status;
  if($status == "ok"){

  $book = $r2->orderBook;
  // echo $book;
  $time = $book[0]->orderDateTime;
  $t_price = $book[0]->tradedPrice;
  echo $t_price;

  }

}


public function exit_order_autocreate()
{
 $auth_code = $this->auth_code();
$this->db->select('*');
            $this->db->from('tbl_manual_order');
            $this->db->where('status',1);
            $this->db->order_by('id','DESC');
            $dsa= $this->db->get();
            $da=$dsa->row();
          if(!empty($da)){
                $stock = $da->stock;
                $qty = $da->qty;
                $target_amount = $da->target_amount;

                $curl2 = curl_init();
                curl_setopt_array($curl2, array(
                CURLOPT_URL => 'https://api.fyers.in/api/v2/orders',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                "symbol":"'.$stock.'",
                "qty":'.$qty.',
                "type":1,
                "side":-1,
                "productType":"INTRADAY",
                "limitPrice":'.$target_amount.',
                "stopPrice":0,
                "validity":"DAY",
                "disclosedQty":0,
                "offlineOrder":"False",
                "stopLoss":0,
                "takeProfit":0
                }',
                CURLOPT_HTTPHEADER => array(
                 'Content-Type: application/json',
                 'Authorization: CAQOD0H5N3-100:'.$auth_code,

                ),
                ));

                $response2 = curl_exec($curl2);

                print_r($response2);
                exit;

                curl_close($curl2);
                $r2 = json_decode($response2);
              // print_r($r2);
                $status = $r2->s;
                // echo $status;
                if($status == "ok"){
                    $data_update = array('status'=>2
                  );
                  $this->db->where('id', $da->id);
                  $zapak=$this->db->update('tbl_manual_order', $data_update);

                if($zapak!=0){
                  echo "exit order created at $target_amount";
                  exit;
                }

                }


          }
          else{

            echo "No order found";
            exit;

          }
        }

  public function auth_code(){
    $this->db->select('*');
                $this->db->from('tbl_config');
                $this->db->order_by('id','DESC');
                $dsa= $this->db->get();
                $da=$dsa->row();
                if(!empty($da)){
              $auth = $da->auth_code;
                }

return $auth;


  }

public function close_position(){


                                    $curl = curl_init();

                                      curl_setopt_array($curl, array(
                                      CURLOPT_URL => 'https://api.fyers.in/api/v2/positions',
                                      CURLOPT_RETURNTRANSFER => true,
                                      CURLOPT_ENCODING => '',
                                      CURLOPT_MAXREDIRS => 10,
                                      CURLOPT_TIMEOUT => 0,
                                      CURLOPT_FOLLOWLOCATION => true,
                                      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                                      CURLOPT_CUSTOMREQUEST => 'DELETE',
                                      CURLOPT_POSTFIELDS =>'',
                                      CURLOPT_HTTPHEADER => array(
                                      'Authorization: app_id:access_token',
                                      'Content-Type: application/json'
                                      ),
                                      ));

                                      $response = curl_exec($curl);

                                      curl_close($curl);
                                      $res_of_sell = json_decode($response);

                                        log_message('error', "CASE 5 - Sell order response - ".$response);




               }

}
