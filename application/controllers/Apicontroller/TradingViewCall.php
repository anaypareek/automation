<?php if (! defined('BASEPATH')) { exit('No direct script access allowed'); }
require_once(APPPATH . 'core/CI_finecontrol.php');
class TradingViewCall extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
        $this->load->library('Fyers');
    }


  public function buy_market($t){
    $auth_code = $this->auth_code();

    $case5 = 0;

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

// echo $stock;
// exit;
$org_cur_value_nifty = $this->get_price(NIFTY);
// $org_cur_value_nifty = NIFTY;

        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date=date("i");
         $cur_date2=date("Y-m-d H:i:s");

  // echo $cur_date;
        $nxtnum = round(($cur_date+5/2)/5)*5;
   // $r_time;
        $td = $nxtnum - $cur_date;
  // exit;
$nxt2= $td*60;
$nxt3 = $nxt2/3;


$data_insert = array('type'=>$type,
  'timeframe'=>5,
  'stock'=>$stockname,
  'closecall'=>0,
  'case5'=>0,
  'nifty'=>$org_cur_value_nifty,
  'option_value'=>$stock,
  'up_by_10'=>0,
  'up_by_20'=>0,
  'up_by_30'=>0,
  'trade_status'=>0,
  'ip' =>$ip,
  'date'=>$cur_date2
  );

$last_id=$this->base_model->insert_table("tbl_call",$data_insert,1) ;

//LOOPING FOR 5 MIN FROM HERE
for ($i = 0; $i < $nxt3; $i++) {

$cur_value_nifty = $this->get_price(NIFTY);
if($t == "ce"){
  $diff_value = $cur_value_nifty - $org_cur_value_nifty;
}
if($t == "pe"){
  $diff_value = $org_cur_value_nifty - $cur_value_nifty;

}
// log_message('error', 'Value increase by - '.$diff_value);

if($diff_value >= 3){
  //check if status already updated or not

// log_message('error', 'entered in 3');


$data_update = array('up_by_3'=>1,
            );
            $this->db->where('id', $last_id);
            $zapak=$this->db->update('tbl_call', $data_update);

}

if($diff_value >= 5){
  //check if status already updated or not

// log_message('error', 'entered in 5');
  if($t == "ce"){
    $stock = $this->get_price($das_stock->stockce);
  }
  if($t == "pe"){
    $stock = $this->get_price($das_stock->stockpe);
  }
$target2 = $stock * PERCENTAGE/100;
$target = $stock + $target2;

$sl2 = $stock * SL/100;
$sl = $stock - $sl2;



$data_update = array('up_by_5'=>1,
                  'trade_status'=>1,
                  'target'=>round($target,2),
                  'trade_value'=>$stock+1,
                  'case5'=>1,
                  'sl'=>round($sl,2)
            );
            $this->db->where('id', $last_id);
            $zapak=$this->db->update('tbl_call', $data_update);

//WILL TAKE ENTRY IN TRADE FROM HERE
//CHECK IF TRADE IS FIRST CALL OF THE DAY
if($case5 == 0){
  log_message('error', 'curl called to case5 from tradingview without close call increased by 5');

  $url ="https://www.fineoutput.co.in/automation/Apicontroller/case5/index/index/".$t;
  $ch = curl_init();
  $timeout = 5;

  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

  $data = curl_exec($ch);

  curl_close($ch);


  $case5 = 1;
}




}

if($diff_value >= 7){
  //check if status already updated or not

// log_message('error', 'entered in 7');


$data_update = array('up_by_7'=>1
            );
            $this->db->where('id', $last_id);
            $zapak=$this->db->update('tbl_call', $data_update);

}
if($diff_value >= 10){
  //check if status already updated or not

// log_message('error', 'entered in 10');

$data_update = array('up_by_10'=>1
            );
            $this->db->where('id', $last_id);
            $zapak=$this->db->update('tbl_call', $data_update);

}
if($diff_value >= 20){

  $data_update = array('up_by_20'=>1
              );
              $this->db->where('id', $last_id);
              $zapak=$this->db->update('tbl_call', $data_update);

}
if($diff_value >= 30){

  $data_update = array('up_by_30'=>1
              );
              $this->db->where('id', $last_id);
              $zapak=$this->db->update('tbl_call', $data_update);

}

sleep(3);
}
$cur_value_nifty2 = $this->get_price(NIFTY);
if($diff_value = $cur_value_nifty2 - $org_cur_value_nifty){
  if($t == "ce"){
    $stock2 = $this->get_price($das_stock->stockce);

  }
  if($t == "pe"){
    $stock2 = $this->get_price($das_stock->stockpe);

  }
  $data_update = array('closecall'=>1,
                  'closenifty'=>$cur_value_nifty2,
                  'option_close_value'=>$stock2,
              );
              $this->db->where('id', $last_id);
              $zapak=$this->db->update('tbl_call', $data_update);
}


  }

  public function closecall($t){


    $this->db->select('*');
                $this->db->from('tbl_call');
                $this->db->order_by('id','DESC');
                $dsa= $this->db->get();
                $da=$dsa->row();
              if(!empty($da)){
                $stock = $da->stock;

                $this->db->select('*');
                $this->db->from('tbl_options');
                $this->db->order_by('id','DESC');
                $da_stock= $this->db->get();
                $das_stock=$da_stock->row();

              if($t == "ce"){
                $stock2 = $das_stock->stockce;
                $stock_price = $this->get_price($das_stock->stockce);

              }
              if($t == "pe"){
                $stock2 = $das_stock->stockpe;
                $stock_price = $this->get_price($das_stock->stockpe);

              }
              if($stock2 == $stock){

                $cur_value_nifty = $this->get_price(NIFTY);
              if($da->trade_status != 1){

              $target2 = $stock_price * PERCENTAGE/100;
              $target = $stock_price + $target2;

              $sl2 = $stock_price * SL/100;
              $sl = $stock_price - $sl2;



                $data_update = array('closecall'=>1,
                                'closenifty'=>$cur_value_nifty,
                                'case5'=>1,
                                'trade_value'=>$stock_price+1,
                                'target'=>$target,
                                'sl'=>$sl,
                                'trade_status'=>1,
                                'option_close_value'=>$stock_price,
                            );
                            $this->db->where('id', $da->id);
                            $zapak=$this->db->update('tbl_call', $data_update);
              }
              else{
                $data_update = array('closecall'=>1,
                                'closenifty'=>$cur_value_nifty,
                                'case5'=>1,
                                'trade_status'=>1,
                                'option_close_value'=>$stock_price,
                            );
                            $this->db->where('id', $da->id);
                            $zapak=$this->db->update('tbl_call', $data_update);
              }


      $case5 = $da->case5;
      if($case5 == 0){

        $url ="https://www.fineoutput.co.in/automation/Apicontroller/case5/index/index/".$t."/1";
        $ch = curl_init();
        $timeout = 5;

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        log_message('error', 'Closed call recieved value changed in case5');
        $data = curl_exec($ch);
        print_r($data);
        curl_close($ch);





      }




              }
              else{
                echo "Stock does not match with last entry";
                exit;
              }



              }
              else{
                echo "no running order";
              }



  }



  public function buy_marketbn($t){
  if($t == "ce"){
    $stock = $this->get_price(STOCKBNCE);
    $stockname = STOCKBNCE;
    $type = 1;
  }
  if($t == "pe"){
    $stock = $this->get_price(STOCKBNPE);
    $stockname = STOCKBNPE;
    $type = 2;
  }
  $auth_code = $this->auth_code();
  $org_cur_value_nifty = $this->get_price(BNNIFTY);
  // $org_cur_value_nifty = NIFTY;

        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date=date("i");
         $cur_date2=date("Y-m-d H:i:s");

  // echo $cur_date;
        $nxtnum = round(($cur_date+5/2)/5)*5;
   // $r_time;
        $td = $nxtnum - $cur_date;
  // exit;
  $nxt2= $td*60;
  $nxt3 = $nxt2/3;



  $data_insert = array('type'=>$type,
  'timeframe'=>5,
  'stock'=>$stockname,
  'closecall'=>0,
  'nifty'=>$org_cur_value_nifty,
  'option_value'=>$stock,
  'up_by_10'=>0,
  'up_by_20'=>0,
  'up_by_30'=>0,
  'trade_status'=>0,
  'ip' =>$ip,
  'date'=>$cur_date2
  );

  $last_id=$this->base_model->insert_table("tbl_call",$data_insert,1) ;

  //LOOPING FOR 5 MIN FROM HERE
  for ($i = 0; $i < $nxt3; $i++) {

  $cur_value_nifty = $this->get_price(BNNIFTY);
  if($t == "ce"){
  $diff_value = $cur_value_nifty - $org_cur_value_nifty;
  }
  if($t == "pe"){
  $diff_value = $org_cur_value_nifty - $cur_value_nifty;

  }
  // log_message('error', $diff_value);

  if($diff_value >= 3){
  //check if status already updated or not

  // log_message('error', 'entered in 3');


  $data_update = array('up_by_3'=>1,
            );
            $this->db->where('id', $last_id);
            $zapak=$this->db->update('tbl_call', $data_update);

  }

  if($diff_value >= 5){
  //check if status already updated or not

  // log_message('error', 'entered in 5');
  if($t == "ce"){
    $stock = $this->get_price(STOCKBNCE);
  }
  if($t == "pe"){
    $stock = $this->get_price(STOCKBNPE);
  }
  $target2 = $stock * PERCENTAGE/100;
  $target = $stock + $target2;

  $sl2 = $stock * SL/100;
  $sl = $stock - $sl2;

  $data_update = array('up_by_5'=>1,
                  'trade_status'=>1,
                  'target'=>$target,
                  'sl'=>$sl
            );
            $this->db->where('id', $last_id);
            $zapak=$this->db->update('tbl_call', $data_update);

  //WILL TAKE ENTRY IN TRADE FROM HERE





  }

  if($diff_value >= 7){
  //check if status already updated or not

  // log_message('error', 'entered in 7');


  $data_update = array('up_by_7'=>1
            );
            $this->db->where('id', $last_id);
            $zapak=$this->db->update('tbl_call', $data_update);

  }
  if($diff_value >= 10){
  //check if status already updated or not

  // log_message('error', 'entered in 10');

  $data_update = array('up_by_10'=>1
            );
            $this->db->where('id', $last_id);
            $zapak=$this->db->update('tbl_call', $data_update);

  }
  if($diff_value >= 20){

  $data_update = array('up_by_20'=>1
              );
              $this->db->where('id', $last_id);
              $zapak=$this->db->update('tbl_call', $data_update);

  }
  if($diff_value >= 30){

  $data_update = array('up_by_30'=>1
              );
              $this->db->where('id', $last_id);
              $zapak=$this->db->update('tbl_call', $data_update);

  }

  sleep(3);
  }
  $cur_value_nifty2 = $this->get_price(BNNIFTY);
  if($diff_value = $cur_value_nifty2 - $org_cur_value_nifty){
  if($t == "ce"){
    $stock2 = $this->get_price(STOCKBNCE);

  }
  if($t == "pe"){
    $stock2 = $this->get_price(STOCKBNPE);

  }
  $data_update = array('closecall'=>1,
                  'closenifty'=>$cur_value_nifty2,
                  'option_close_value'=>$stock2,
              );
              $this->db->where('id', $last_id);
              $zapak=$this->db->update('tbl_call', $data_update);
  }


  }


  public function buy_market1min($t){
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
  $auth_code = $this->auth_code();
  $org_cur_value_nifty = $this->get_price(NIFTY);
  // $org_cur_value_nifty = NIFTY;

        $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
        $cur_date=date("i");
         $cur_date2=date("Y-m-d H:i:s");


  $data_insert = array('type'=>$type,
  'timeframe'=>1,
  'stock'=>$stockname,
  'closecall'=>0,
  'nifty'=>$org_cur_value_nifty,
  'option_value'=>$stock,
  'up_by_3'=>0,
  'up_by_5'=>0,
  'up_by_10'=>0,
  'trade_status'=>0,
  'ip' =>$ip,
  'date'=>$cur_date2
  );

  $last_id=$this->base_model->insert_table("tbl_call1min",$data_insert,1) ;

  //LOOPING FOR 5 MIN FROM HERE
  for ($i = 0; $i < 5; $i++) {

  $cur_value_nifty = $this->get_price(NIFTY);
  $diff_value = $cur_value_nifty - $org_cur_value_nifty;
  // log_message('error', $diff_value);


  if($diff_value >= 3){
  // log_message('error', 'entered in 3');
  if($t == "ce"){
    $stock = $this->get_price(STOCKCE);
  }
  if($t == "pe"){
    $stock = $this->get_price(STOCKPE);
  }
  $target2 = $stock + SCALPPERCENTAGE/100;
  $target = $stock + $target2;

  $sl2 = $stock - SCALPSL/100;
  $sl = $stock - $sl2;


  $qty2 = AMOUNT/$stock;
  $qty3 = floor($qty2/50);
  $qty = $qty3 - 0;

  $data_update = array('up_by_3'=>1,
                  'trade_status'=>1,
                  'qty'=>$qty,
                  'target'=>$target,
                  'sl'=>$sl
            );
            $this->db->where('id', $last_id);
            $zapak=$this->db->update('tbl_call1min', $data_update);

  //WILL TAKE ENTRY IN TRADE FROM HERE

  }

  if($diff_value >= 5){

  $data_update = array('up_by_5'=>1
            );
            $this->db->where('id', $last_id);
            $zapak=$this->db->update('tbl_call1min', $data_update);

  }
  if($diff_value >= 10){

  $data_update = array('up_by_10'=>1
            );
            $this->db->where('id', $last_id);
            $zapak=$this->db->update('tbl_call1min', $data_update);


  }

  sleep(3);
  }

  }


  public function aftercalldb(){

  date_default_timezone_set("Asia/Calcutta");

  $this->db->select('*');
  $this->db->from('tbl_call');
  $this->db->where('trade_status',1);
  $this->db->order_by('id','DESC');
  $dsa= $this->db->get();
  $da=$dsa->row();
  if(!empty($da)){

  //CHECK IF ANY PREVIOUS EXIT ORDER EXIST OR NOT
  // $exit_status = $da->status;
  $buy_price= $da->trade_value;
  $stock= $da->stock;
  $qty = 100;
  $target= $da->target;
  $sl= $da->sl;
  $price_low= $da->price_low;
  $price_high= $da->price_high;
  $percentage_high= $da->percentage_high;
  $percentage_low= $da->percentage_low;

  for ($i = 0; $i < 16; $i++) {
  //    log_message('error', 'case 5 - In the file2, cron job');
  date_default_timezone_set("Asia/Calcutta");
  $cur_date3=date("Y-m-d H:i:s");
  $cur_date4=date("H:i:s");

  $cur_price = $this->get_price($stock);

  date_default_timezone_set("Asia/Calcutta");
  log_message('error', 'CALL_CHECK - Order in progress Current Price - '.$cur_price.'--, Target Price --'.$target);


  if($cur_price >= $target){
  date_default_timezone_set("Asia/Calcutta");
  log_message('error', 'CALL_CHECK - ('.$cur_date4.')Price greater then target and order completed - '.$cur_price.'--'.$target);

  $diff = $cur_price-$buy_price;
  $amt = $diff*$qty;
  $data_update = array('trade_status'=>1,
  'plstatus'=>1,
  'profit_at'=>$cur_price,
  'plamount'=>$amt,
  'date3'=>$cur_date3

  );
  $this->db->where('id', $da->id);
  $zapak=$this->db->update('tbl_call', $data_update);

  }

  if($cur_price <= $sl){
  log_message('error', 'CALL_CHECK - Price less then SL and order completed - '.$cur_price.'--'.$sl);

  $diff = $buy_price-$cur_price;
  $amt = $diff*$qty;
  $data_update = array('trade_status'=>1,
  'plstatus'=>2,
  'loss_at'=>$cur_price,
  'plamount'=>$amt,
  'date3'=>$cur_date3
  );
  $this->db->where('id', $da->id);
  $zapak=$this->db->update('tbl_call', $data_update);

  }

  if($price_low == 0){
    $price_low = $cur_price;
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

  sleep(3);

} // foreach end
log_message('error', 'CALL_CHECK - Price High-'.$price_high.'--Price Low- '.$price_low);
log_message('error', 'CALL_CHECK - Percentage High-'.$percentage_high.'--Percentage Low- '.$percentage_low);

$data_update2 = array(
          'price_high'=>$price_high,
          'price_low'=>$price_low,
          'percentage_high'=>$percentage_high,
          'percentage_low'=>$percentage_low

            );
            $this->db->where('id', $da->id);
            $zapak=$this->db->update('tbl_call', $data_update2);


  }
  else{
  // echo "no order present";
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
// log_message('error', 'CALL_CHECK - '.$symbol);
// foreach($response as $rr){
// print_r($r);
// exit;
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


public function test_library(){

                echo $this->fyers->get_price('NSE:NIFTY23AUG19400CE');

               }

}
