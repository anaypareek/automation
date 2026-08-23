<?php if (! defined('BASEPATH')) { exit('No direct script access allowed'); }
require_once(APPPATH . 'core/CI_finecontrol.php');
class Index extends CI_finecontrol
{
public function __construct()
{
parent::__construct();
$this->load->model("login_model");
$this->load->model("admin/base_model");
$this->load->library('user_agent');
$this->load->library('upload');
}



public function index($t,$cc=""){

$switch = LIVETRADING_CASE5;
switch ($switch) {
case 0:
//CHECK TIME BEFORE ENTRY INTO DATABASE TIME SHOULD BE BETWEEN 9:30 - 11 AM
date_default_timezone_set("Asia/Calcutta");
$date=date("Y-m-d");
$t1=date("H:i");
// $t1="11:00";
if($t1<= "11:30" && $t1>="09:30"){

$this->db->select('*');
$this->db->from('tbl_case5');
$this->db->where('date2',$date);
$this->db->order_by('id','DESC');
$dsa= $this->db->get();
$da=$dsa->row();
if(!empty($da)){
log_message('error', "CASE 5 - already exist in db case5");
}
else{
$auth_code = $this->auth_code();
$org_cur_value_nifty = $this->get_price(NIFTY);

$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("i");
$cur_date2=date("Y-m-d H:i:s");
$cur_date3=date("Y-m-d H:i:s");
$cur_date4=date("Y-m-d");

// echo $cur_date;
$nxtnum = round(($cur_date+5/2)/5)*5;
// $r_time;
$td = $nxtnum - $cur_date;
// exit;
$nxt2= $td*60;
$nxt3 = $nxt2/3;

if($t == "ce"){
$stock = $this->get_price(STOCKCE);
$stockname = STOCKCE;
$type = 1;
}
if($t == "pe"){
$stock = $this->get_price(STOCKPE);
$stockname = STOCKPE;
$type = 2;
}

if($cc == 1){
$close_call = 1;
$close_val = $stock;
}
else{
$close_call = "";
$close_val ="";
}

$target2 = $stock * PERCENTAGE/100;
$target = $stock + $target2;

$sl2 = $stock * SL/100;
$sl = $stock - $sl2;

$qty2 = AMOUNT/$stock;
$qty3 = floor($qty2/50);
$qty = $qty3 - 0;


$data_insert = array('stock_type'=>"NIFTY",
'type'=>$type,
'qty'=>$qty,
'timeframe'=>5,
'stock'=>$stockname,
'closecall'=>$cc,
'nifty'=>$org_cur_value_nifty,
'closenifty'=>$org_cur_value_nifty,
'option_value'=>$stock,
'option_close_value'=>$close_val,
'up_by_3'=>0,
'up_by_5'=>1,
'up_by_10'=>0,
'up_by_20'=>0,
'up_by_30'=>0,
'trade_status'=>1,
'target'=>round($target,2),
'sl'=>round($sl,2),
'ip' =>$ip,
'date'=>$cur_date2,
'date2'=>$cur_date4
// 'date3'=>$cur_date3
);

$last_id=$this->base_model->insert_table("tbl_case5",$data_insert,1) ;

if($last_id!=0){
echo "success";
exit;
}
else{
echo "error occured";
exit;
}



}



}
else{
echo "Out of time no order will be placed";
exit;
}


exit;



case 1:
//CHECK TIME BEFORE ENTRY INTO DATABASE TIME SHOULD BE BETWEEN 9:30 - 11 AM
date_default_timezone_set("Asia/Calcutta");
$date=date("Y-m-d");
$t1=date("H:i");
// $t1="11:00";
if($t1<= "11:30" && $t1>="09:30"){

$this->db->select('*');
$this->db->from('tbl_case5');
$this->db->where('date2',$date);
$this->db->order_by('id','DESC');
$dsa= $this->db->get();
$da=$dsa->row();
if(!empty($da)){
log_message('error', "CASE 5 - already exist in db case5");
}
else{
$auth_code = $this->auth_code();
$org_cur_value_nifty = $this->get_price(NIFTY);

$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("i");
$cur_date2=date("Y-m-d H:i:s");
$cur_date3=date("Y-m-d H:i:s");
$cur_date4=date("Y-m-d");

// echo $cur_date;
$nxtnum = round(($cur_date+5/2)/5)*5;
// $r_time;
$td = $nxtnum - $cur_date;
// exit;
$nxt2= $td*60;
$nxt3 = $nxt2/3;


   $this->db->select('*');
$this->db->from('tbl_options');
$this->db->order_by('id','DESC');
$da_stock= $this->db->get();
$das_stock=$da_stock->row();

if($t == "ce"){

$stock = $this->get_price($das_stock->stockce);
$stockname = $das_stock->stockce;

$type = 1;
}
if($t == "pe"){
$stock = $this->get_price($das_stock->stockpe);
$stockname = $das_stock->stockpe;
$type = 2;
}
log_message('error', "CASE 5 - INFO - ORDER RECIEVED AT VALUE - ".$stock."And NIFTY AT ".$org_cur_value_nifty);
if($cc == 1){
$close_call = 1;
$close_val = $stock;
}
else{
$close_call = "";
$close_val ="";
}

$target2 = $stock * PERCENTAGE/100;
$target = $stock + $target2;

$sl2 = $stock * SL/100;
$sl = $stock - $sl2;

$qty2 = AMOUNT/$stock;
$qty3 = floor($qty2/50);
$qty = $qty3 - 0;
$qty = $qty * 50;
// echo $stockname;
// exit;

$limit_price = $stock + 1;
$limit_price_round = round($limit_price * 2, 1) / 2;
//ORDER PLACING CODE HERE
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
      "symbol":"'.$stockname.'",
      "qty":'.$qty.',
      "type":1,
      "side":1,
      "productType":"INTRADAY",
      "limitPrice":'.$limit_price_round.',
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
      log_message('error', "CASE 5 - order place response - ".$response);


//ORDER PLACING CODE ENDS HERE
// CHECKING ORDER PLACED AND ITS AMOUNT

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
  // log_message('error', "CASE 5 - order get details response - ".$response2);

  curl_close($curl2);

  $r2 = json_decode($response2);

      $status = $r2->s;

      if($status == "ok"){
        $book = $r2->orderBook;
        $time = $book[0]->orderDateTime;
        $t_price = $book[0]->tradedPrice;


        //INSERTING VALUE IN DATABASE AFTER ORDER PLACED

                    $data_insert = array('stock_type'=>"NIFTY",
                    'type'=>$type,
                    'qty'=>$qty,
                    'live'=>1,
                    'timeframe'=>5,
                    'stock'=>$stockname,
                    'closecall'=>$cc,
                    'nifty'=>$org_cur_value_nifty,
                    'closenifty'=>$org_cur_value_nifty,
                    'option_value'=>$stock,
                    'order_place_amount'=>$t_price,
                    'option_close_value'=>$close_val,
                    'up_by_3'=>0,
                    'up_by_5'=>1,
                    'up_by_10'=>0,
                    'up_by_20'=>0,
                    'up_by_30'=>0,
                    'trade_status'=>1,
                    'target'=>round($target,2),
                    'sl'=>round($sl,2),
                    'ip' =>$ip,
                    'date'=>$cur_date2,
                    'date2'=>$cur_date4
                    // 'date3'=>$cur_date3
                    );

                    $last_id=$this->base_model->insert_table("tbl_case5",$data_insert,1) ;

                    if($last_id!=0){

                    //for testing only get orders details
                    $order_details = $this->get_orders();


                    log_message('error', "CASE 5 - all orders details- ".$order_details);

                      echo "success";
                        exit;
                    }
                    else{
                      echo "error occured";
                      exit;
                    }

      }
      else{
              log_message('error', "CASE 5 - status not ok of order details get");
      }




}
else{
    log_message('error', "CASE 5 - status not ok of order placing");
}



}



}
else{
echo "Out of time no order will be placed";
exit;
}


exit;


default:
exit;
}


}

public function entry_creator(){





}

public function afterorderdb(){

//CHECKING IF LIVE TRADING IS ON OR OFF IF ON THEN CASE 1 OTHERWISE CASE 2
date_default_timezone_set("Asia/Calcutta");
// log_message('error', 'case 5 - In the file, cron job 1');
$switch = LIVETRADING_CASE5;
switch ($switch) {
case 0:
$this->db->select('*');
$this->db->from('tbl_case5');
$this->db->where('trade_status',1);
$this->db->order_by('id','DESC');
$dsa= $this->db->get();
$da=$dsa->row();
if(!empty($da)){

//CHECK IF ANY PREVIOUS EXIT ORDER EXIST OR NOT
// $exit_status = $da->status;
$buy_price= $da->option_value;
$stock= $da->stock;
$qty_m= $da->qty;
$qty = $qty_m * 50;
$target= $da->target;
$sl= $da->sl;

for ($i = 0; $i < 16; $i++) {
//    log_message('error', 'case 5 - In the file2, cron job');
date_default_timezone_set("Asia/Calcutta");
$cur_date3=date("Y-m-d H:i:s");
$cur_date4=date("H:i:s");

$cur_price = $this->get_price($stock);

date_default_timezone_set("Asia/Calcutta");
log_message('error', 'case 5 - Order in progress Current Price - '.$cur_price.'--, Target Price --'.$target);


if($cur_price >= $target){
date_default_timezone_set("Asia/Calcutta");
log_message('error', 'case 5 - ('.$cur_date4.')Price greater then target and order completed - '.$cur_price.'--'.$target);

$diff = $cur_price-$buy_price;
$amt = $diff*$qty;
$data_update = array('trade_status'=>2,
'plstatus'=>1,
'profit_at'=>$cur_price,
'plamount'=>$amt,
'date3'=>$cur_date3

);
$this->db->where('id', $da->id);
$zapak=$this->db->update('tbl_case5', $data_update);
// $modify_order = $this->modify_order($sell_order_id,$qty,1,$target);
// echo $modify_order;
exit;


}

if($cur_price <= $sl){
log_message('error', 'case 5 - Price less then SL and order completed - '.$cur_price.'--'.$sl);

$diff = $buy_price-$cur_price;
$amt = $diff*$qty;
$data_update = array('trade_status'=>2,
'plstatus'=>2,
'loss_at'=>$cur_price,
'plamount'=>$amt,
'date3'=>$cur_date3


);
$this->db->where('id', $da->id);
$zapak=$this->db->update('tbl_case5', $data_update);
// $modify_order = $this->modify_order($sell_order_id,$qty,1,$target);
// echo $modify_order;
exit;


}
sleep(3);

}

}
else{
// echo "no order present";
exit;
}



exit;
case 1:
        $this->db->select('*');
                    $this->db->from('tbl_case5');
                    $this->db->where('trade_status',1);
                    $this->db->order_by('id','DESC');
                    $dsa= $this->db->get();
                    $da=$dsa->row();
                  if(!empty($da)){

        //CHECK IF ANY PREVIOUS EXIT ORDER EXIST OR NOT
        // $exit_status = $da->status;
        $buy_price= $da->order_place_amount;
        $stock= $da->stock;
        $qty_m= $da->qty;
        $qty = $qty_m * 50;
        $target= $da->target;
        $target_amt = round($target * 2, 1) / 2;
        log_message('error', "CASE 5 - TARGET AMOUNT -".$target_amt);
        log_message('error', "CASE 5 - ORDER AMOUNT -".$buy_price);
        $sl= $da->sl;
        $exit_created= $da->exit_created;
        $exit_order_id= $da->exit_order_id;

        $nifty_high= $da->nifty_high;
        $nifty_low= $da->nifty_low;
        $price_high= $da->price_high;
        $price_low= $da->price_low;
        $percentage_high= $da->percentage_high;
        $percentage_low= $da->percentage_low;
        $trade_start_date= $da->date;
        $sl_changed= $da->sl_changed;

        //CHECK IF EXIT ORDER IS CREATED IF NOT CREATED EXIT ORDER ALSO THIS WILL ONLY RUN  1 TIME FIRST TIME ONLY
        if($exit_created!=1){
          $create_exit = $this->create_exit_order($stock,$qty_m,$target_amt);
          log_message('error', "CASE 5 - exit order create response- ".$create_exit);
          $create_exit2 = json_decode($create_exit);

          $status = $create_exit2->s;
          $exit_order_id = $create_exit2->id;
          // echo $status;
          if($status == "ok"){
            $data_update = array(
                      'exit_created'=>1,
                      'exit_order_id'=>$exit_order_id
                        );
                        $this->db->where('id', $da->id);
                        $zapak=$this->db->update('tbl_case5', $data_update);

          }

          $position_details = $this->get_positions();
          log_message('error', "CASE 5 - all positions details- ".$position_details);
          }





        for ($i = 0; $i < 16; $i++) {
      //    log_message('error', 'case 5 - In the file2, cron job');
          date_default_timezone_set("Asia/Calcutta");
          $cur_date3=date("Y-m-d H:i:s");
            $cur_date4=date("H:i:s");
          $pl_statement2 = 0;
          $cur_price = $this->get_price($stock);
          $pl_statement = $cur_price - $buy_price;
          $pl_statement2 = $pl_statement*$qty_m;
          date_default_timezone_set("Asia/Calcutta");
          log_message('error', 'case 5 - Order in progress Current Price - '.$cur_price.'--, Target Price --'.$target.' SL--'.$sl."--,pl (-".$pl_statement2.")");


        if($cur_price >= $target){
          date_default_timezone_set("Asia/Calcutta");
          log_message('error', 'case 5 - ('.$cur_date4.')Price greater then target and order completed - '.$cur_price.'--'.$target);

            if($this->check_open_positions() == 1){
              $close = $this->close_all_positions();

              $res_of_sell = json_decode($close);

                log_message('error', "CASE 5 - Sell order response - ".$close);
            }
            else{

            }



        $diff = $target-$buy_price;
        $amt = $diff*$qty_m;

        // Define your start and end times
       $start = new DateTime($trade_start_date);
       $end = new DateTime($cur_date3);

       // Calculate the difference
       $interval = $start->diff($end);

       // Show the result
       $trade_time = $interval->format('%h:%i:%s');


          $data_update = array('trade_status'=>2,
                    'plstatus'=>1,
                    'profit_at'=>$target,
                    'plamount'=>$amt,
                    'date3'=>$cur_date3,
                    'trade_time'=>$trade_time,

                      );
                      $this->db->where('id', $da->id);
                      $zapak=$this->db->update('tbl_case5', $data_update);
        // $modify_order = $this->modify_order($sell_order_id,$qty,1,$target);
        // echo $modify_order;
        exit;


        }

        if($cur_price <= $sl){
          log_message('error', 'case 5 - Price less then SL and order completed - '.$cur_price.'--'.$sl);

                  if($this->check_open_positions() == 1){

                    //CANCEL ORDER OF TARGET FIRST THEN CLOSE POSITION IN SL
                    $cancel_ord = $this->cancel_order($exit_order_id);

                    log_message('error', "CASE 5 - cancel order response - ".$cancel_ord);

                    $close = $this->close_all_positions();

                    $res_of_sell = json_decode($close);

                      log_message('error', "CASE 5 - Sell order response - ".$close);
                  }



          $diff = $buy_price-$cur_price;
          $amt = $diff*$qty_m;

          // Define your start and end times
         $start = new DateTime($trade_start_date);
         $end = new DateTime($cur_date3);
         $interval = $start->diff($end);
         $trade_time = $interval->format('%h:%i:%s');

          $data_update = array('trade_status'=>2,
                    'plstatus'=>2,
                    'loss_at'=>$cur_price,
                    'plamount'=>$amt,
                    'date3'=>$cur_date3,
                    'trade_time'=>$trade_time


                      );
                      $this->db->where('id', $da->id);
                      $zapak=$this->db->update('tbl_case5', $data_update);
        // $modify_order = $this->modify_order($sell_order_id,$qty,1,$target);
        // echo $modify_order;
        exit;


        }

        //CHECKING HIGH AND LOW OF PRICE AND NIFTY
        $new_cur_value_nifty = $this->get_price(NIFTY);
        if($nifty_low == 0){
          $nifty_low = $new_cur_value_nifty;
        }
        if($price_low == 0){
          $price_low = $cur_price;
        }


        if($nifty_high < $new_cur_value_nifty){
          $nifty_high = $new_cur_value_nifty;
        }

        if($nifty_low > $new_cur_value_nifty){
          $nifty_low = $new_cur_value_nifty;
        }

        if($price_high < $cur_price){
          $price_high = $cur_price;
        }

        if($price_low > $cur_price){
          $price_low = $cur_price;
        }

        $price_in_diff = $cur_price - $buy_price;
        $diff_in_percent = ( $price_in_diff / $buy_price ) * 100;

        if($diff_in_percent < $percentage_low){
          $percentage_low = $diff_in_percent;

        }
        if($diff_in_percent > $percentage_high ){
          $percentage_high = $diff_in_percent;
        }

        if($sl_changed == 0 && $percentage_high > 4){
          $data_update = array('sl_changed'=>1,
                      'sl'=>$buy_price
                      );
                      $this->db->where('id', $da->id);
                      $zapak=$this->db->update('tbl_case5', $data_update);

              $sl = $buy_price;
        }

        sleep(3);

        }

        $data_update = array('nifty_high'=>$nifty_high,
                  'nifty_low'=>$nifty_low,
                  'price_high'=>$price_high,
                  'price_low'=>$price_low,
                  'percentage_high'=>$percentage_high,
                  'percentage_low'=>$percentage_low

                    );
                    $this->db->where('id', $da->id);
                    $zapak=$this->db->update('tbl_case5', $data_update);

                  }
                  else{
                    // echo "no order present";
                    exit;
                  }



      exit;

default:
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


public function get_orders(){

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
CURLOPT_CUSTOMREQUEST => 'GET',
CURLOPT_HTTPHEADER => array(
'Authorization: CAQOD0H5N3-100:'.$auth_code
),
));

$response = curl_exec($curl);

curl_close($curl);
return $response;


}



public function get_positions(){
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
return $response;

}


public function check_open_positions(){
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
$res = json_decode($response);
log_message('error', "CASE 5 - check open position function - ".$response);
$status = $res->s;
if($status == "ok"){
  $overall = $res->overall;
  $open_position = $overall->count_open;
  return $open_position;
}
else{
    return "err";
}

curl_close($curl);

}

public function close_all_positions(){

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
         CURLOPT_CUSTOMREQUEST => 'DELETE',
         CURLOPT_POSTFIELDS =>'{}',
         CURLOPT_HTTPHEADER => array(
           'Content-Type: application/json',
           'Authorization: CAQOD0H5N3-100:'.$auth_code,
         ),
       ));

       $response = curl_exec($curl);

       curl_close($curl);
       return $response;


          }




public function get_price($symbol)
{
$auth_code = $this->auth_code();
// SYMBOL -> STOCK OR OPTION NAME
//
$curl = curl_init();

curl_setopt_array($curl, array(
CURLOPT_URL => 'https://api-t1.fyers.in/data/quotes?symbols='.$symbol,
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
if($symbol == NIFTY){
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
  $r5=$r3->cmd->c;
  return $r5;

  }
}
else{
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

  }
}

curl_close($curl);

}

public function create_exit_order($stock,$qty,$target_amount)
{
$auth_code = $this->auth_code();
// SYMBOL -> STOCK OR OPTION NAME
//
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
          "qty":"'.$qty.'",
          "type":1,
          "side":-1,
          "productType":"INTRADAY",
          "limitPrice":"'.$target_amount.'",
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

          )
          ));

          $response2 = curl_exec($curl2);

          // print_r($response2);
          // exit;

            return $response2;
            curl_close($curl);
}



public function cancel_order($id)
{
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
CURLOPT_CUSTOMREQUEST => 'DELETE',
CURLOPT_POSTFIELDS =>'{"id":"'.$id.'"}',
CURLOPT_HTTPHEADER => array(
  'Content-Type: application/json',
  'Authorization: CAQOD0H5N3-100:'.$auth_code,

),
));

$response = curl_exec($curl);

curl_close($curl);
return $response;




}


public function daily_order_complete_mark()
{

  $data_update = array('trade_status'=>2,
                            );
                            // $this->db->where('$', $$$);
  $zapak=$this->db->update('tbl_case5', $data_update);

}


}
