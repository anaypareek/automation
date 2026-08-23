<?php if (! defined('BASEPATH')) { exit('No direct script access allowed'); }
require_once(APPPATH . 'core/CI_finecontrol.php');
class Autochecker extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }

  public function afterorder(){
    // echo $this->open_position;
    // exit;
if($this->open_position() == 1){

$this->db->select('*');
            $this->db->from('tbl_manual_order');
            $this->db->where('trade_status',1);
            $this->db->order_by('id','DESC');
            $dsa= $this->db->get();
            $da=$dsa->row();
          if(!empty($da)){

//CHECK IF ANY PREVIOUS EXIT ORDER EXIST OR NOT
$exit_status = $da->status;
$buy_price= $da->buy_amount;
$stock= $da->stock;
$qty= $da->qty;
$target= $da->target_amount;
$sl= $da->sl;

if($exit_status == 1){
  //CREATE FIRST EXIT ORDER

  $exit = $this->exit($stock,$qty,$target);

  $exit2 =json_decode($exit);

  $stat = $exit2->status;
  $sell_ord_id = $exit2->order_id;

  if($stat == 1){
$data_update = array('sell_order_id'=>$sell_ord_id,
          'status'=>2,
            );
            $this->db->where('id', $da->id);
            $zapak=$this->db->update('tbl_manual_order', $data_update);
if($zapak!=0){
  echo "Order Placed Successfully";
  exit;

}
else{
  echo "error occured";
  exit;
}

  }
  else{
    echo "Error occured in placing exit order";
    exit;
  }

}
else{
// IF EXIT ORDER EXIST THEN LOOP IN THIS FUNCTION
$sell_order_id= $da->sell_order_id;
$cur_price = $this->get_price($stock);

if($cur_price >= $buy_price){


$modify_order = $this->modify_order($sell_order_id,$qty,1,$target);
echo $modify_order;

}
else{
  $modify_order = $this->modify_order($sell_order_id,$qty,2,$sl);
  echo $modify_order;
}




}

//CREATE EXIT ORDER


//MODIFY EXIT ORDER ACCORDING TO SITUATION IF GREATER THAN BUY PRICE TARGET OTHERWISE SL





          }
          else{
            echo "no order present";
            exit;
          }



}


  }

  public function afterorderdb(){

$this->db->select('*');
            $this->db->from('tbl_call');
            $this->db->where('trade_status',1);
            $this->db->order_by('id','DESC');
            $dsa= $this->db->get();
            $da=$dsa->row();
          if(!empty($da)){

//CHECK IF ANY PREVIOUS EXIT ORDER EXIST OR NOT
// $exit_status = $da->status;
$buy_price= $da->option_value;
$stock= $da->stock;
$qty= 100;
$target= $da->target;
$sl= $da->sl;

for ($i = 0; $i < 12; $i++) {

$cur_price = $this->get_price($stock);

if($cur_price >= $target){
  date_default_timezone_set("Asia/Calcutta");
  // log_message('error', 'Price greater then target and order completed - '.$cur_price.'--'.$target);

$diff = $cur_price-$buy_price;
$amt = $diff*$qty;
  $data_update = array('trade_status'=>2,
            'plstatus'=>1,
            'plamount'=>$amt,
              );
              $this->db->where('id', $da->id);
              $zapak=$this->db->update('tbl_call', $data_update);
// $modify_order = $this->modify_order($sell_order_id,$qty,1,$target);
// echo $modify_order;


//UPDATE IN DAILY LEISURE TABLE FOR DAULY PROFIT CHECKING



exit;



}

if($cur_price <= $sl){
  date_default_timezone_set("Asia/Calcutta");
  // log_message('error', 'Price less then SL and order completed - '.$cur_price.'--'.$sl);

  $diff = $buy_price-$cur_price;
  $amt = $diff*$qty;
  $data_update = array('trade_status'=>2,
            'plstatus'=>2,
            'plamount'=>$amt

              );
              $this->db->where('id', $da->id);
              $zapak=$this->db->update('tbl_call', $data_update);
// $modify_order = $this->modify_order($sell_order_id,$qty,1,$target);
// echo $modify_order;

//UPDATE IN DAILY LEISURE TABLE FOR DAULY PROFIT CHECKING


exit;

}
sleep(3);

}

          }
          else{
            // echo "no order present";
            exit;
          }






  }

  public function afterorder1min(){


$this->db->select('*');
            $this->db->from('tbl_call1min');
            $this->db->where('trade_status',1);
            $this->db->order_by('id','DESC');
            $dsa= $this->db->get();
            $da=$dsa->row();
          if(!empty($da)){

            $buy_price= $da->option_value;
            $stock= $da->stock;
            $qty= $da->qty;
            $target= $da->target;
            $sl= $da->sl;

$cur_price = $this->get_price($stock);

if($cur_price>=$target){

  $diff = $target-$buy_price;
  $pl = $diff*$qty;
  $data_update = array('trade_status'=>2,
            'plstatus'=>1,
            'plamount'=>$pl
              );
              $this->db->where('id', $da->id);
              $zapak=$this->db->update('tbl_call1min', $data_update);

}
if($cur_price<=$sl){
  $diff = $buy_price-$sl;
  $pl = $diff*$qty;
  $data_update = array('trade_status'=>2,
            'plstatus'=>2,
            'plamount'=>$pl
              );
              $this->db->where('id', $da->id);
              $zapak=$this->db->update('tbl_call1min', $data_update);
}

          }
          else{
            echo "no order present";
            exit;
          }




  }





  public function buy($stock,$qty){
     $auth_code = $this->auth_code();

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
   "symbol":"'.$stock.'",
   "qty":'.$qty.',
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

 $status = $r->s;

 if($status == "ok"){
   $book = $r->orderBook;
   $time = $book[0]->orderDateTime;
   $t_price = $book[0]->tradedPrice;
   $order_id2 = $book[0]->id;

   $res = array("price"=>$t_price,"status"=>1);
    return json_encode($res);




          }
          else{
            $res = array("price"=>0,"status"=>0);
             return json_encode($res);
          }




  }

  public function exit($stock,$qty,$price){
     $auth_code = $this->auth_code();

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
   "symbol":"'.$stock.'",
   "qty":'.$qty.',
   "type":1,
   "side":-1,
   "productType":"INTRADAY",
   "limitPrice":'.$price.',
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

 $response = curl_exec($curl);
// print_r($response);
// exit;
 curl_close($curl);
 $r= json_decode($response);

 $status = $r->s;
 $order_id = $r->id;

 if($status == "ok"){

   $order_id2 = $order_id;
   $res = array("price"=>$price,"status"=>1,"order_id"=>$order_id2);
    return json_encode($res);




          }
          else{
            $res = array("price"=>0,"status"=>0);
             return json_encode($res);
          }




  }


    public function modify_order($order_id,$qty,$type,$price){
       $auth_code = $this->auth_code();

if($type == 1){
  // IN CASE OF TARGET ORDER
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.fyers.in/api/v2/orders',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS =>'{
            "id":'.$order_id.',
            "qty":'.$qty.',
            "type":1,
            "side":-1,
            "limitPrice":'.$price.'
          }',
    CURLOPT_HTTPHEADER => array(
      'Authorization: CAQOD0H5N3-100:'.$auth_code
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  echo $response;


}
else{
  // IN CASE OF SL ORDER
$lmprice = $price-1;
  $curl = curl_init();
  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.fyers.in/api/v2/orders',
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => '',
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => 'PUT',
    CURLOPT_POSTFIELDS =>'{
            "id":'.$order_id.',
            "qty":'.$qty.',
            "type":4,
            "side":-1,
            "limitPrice":0,
            "stopPrice":'.$price.'
          }',
    CURLOPT_HTTPHEADER => array(
      'Authorization: CAQOD0H5N3-100:'.$auth_code.'',
      'Content-Type: application/json'
    ),
  ));

  $response = curl_exec($curl);

  curl_close($curl);
  echo $response;



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


public function traded()
{
$entityBody = file_get_contents('php://input');
$this->db->select('*');
            $this->db->from('tbl_manual_order');
            $this->db->order_by('id','DESC');
            $dsa= $this->db->get();
            $da=$dsa->row();
          if(!empty($da)){
            $id= $da->id;
            $data_update = array('msg'=>$entityBody,
                        );
                        $this->db->where('id', $id);
                        $zapak=$this->db->update('tbl_manual_order', $data_update);

          }



}


public function open_position()
{
$auth_code = $this->auth_code();
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => 'https://api.fyers.in/api/v2/positions',
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

  curl_close($curl);
  // echo $response;
  $r = json_decode($response);
  $status = $r->s;
  $pos = $r->overall;
  if($status == "ok"){
    // echo $status;
    // echo $pos->count_open;
    return $pos->count_open;
  }
  else{
    return "error";
  }
}



}
