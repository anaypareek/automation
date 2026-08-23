<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Stocks_call extends CI_finecontrol{
function __construct()
{
parent::__construct();
$this->load->model("login_model");
$this->load->model("admin/base_model");
$this->load->library('user_agent');
}

public function buy_call($stock,$time){
  // Set response header to avoid content negotiation issues
    //   header('Content-Type: application/json');
//   log_message('error', 'BUY CALL ' . $stock);

  // Get the raw POST data
  $json_data = file_get_contents("php://input");
   log_message('error', 'AllText' . $json_data);

  // Access the 'text' field
  if (isset($json_data)) {
    $text =  $json_data; // Output: BTCUSD Greater Than 9000
    // log_message('error', 'Text' . $text);
    // Use regex to extract the number
        preg_match('/\b\d+\b/', $text, $matches);

        // Output the extracted number
        if (!empty($matches)) {
          $price = $matches[0]; // Output: 327
          // log_message('error', 'Price' . $price);
        } else {
            $price = 0;
        }
  } else {
        $text = "";
        $price = 0;
  }


$this->db->select('*');
$this->db->from('tbl_stock_list');
$this->db->where('name',$stock);
$dsa= $this->db->get();
$da=$dsa->row();
if(!empty($da)){
$symbol = $da->id;
$logo = $da->logo;

$ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
$cur_date=date("Y-m-d H:i:s");

// $price = $this->get_price($logo);

// calculate last entry of same stock


$data_insert = array('name'=>$stock,
  'symbol'=>$symbol,
  'price'=>$price,
  'call_type'=>1, //1 for buy 2 for sell
  'call_timeframe'=>$time, //1 for 5 min, 2 for 15 min, 3 for 1hr, 4 for 1 day
  'call_open_close'=>1, //1 for open, 2 for close
  'ip' =>$ip,
  'date'=>$cur_date

  );

$last_id=$this->base_model->insert_table("tbl_stock_call",$data_insert,1) ;

echo json_encode("Success");

}
else{
echo json_encode("No data");
}



}


public function sell_call($stock,$time){
  // Set response header to avoid content negotiation issues
        // header('Content-Type: application/json');
  // Get the raw POST data
//   log_message('error', 'SELL CALL ' . $stock);

  $json_data = file_get_contents("php://input");
   log_message('error', 'AllText' . $json_data);

  // Access the 'text' field
  if (isset($json_data)) {
    $text =  $json_data; // Output: BTCUSD Greater Than 9000
    // log_message('error', 'Text' . $text);
    // Use regex to extract the number
        preg_match('/\b\d+\b/', $text, $matches);

        // Output the extracted number
        if (!empty($matches)) {
          $price = $matches[0]; // Output: 327
          // log_message('error', 'Price' . $price);
        } else {
            $price = 0;
        }
  } else {
        $text = "";
        $price = 0;
  }

 $this->db->select('*');
             $this->db->from('tbl_stock_list');
             $this->db->where('name',$stock);
             $dsa= $this->db->get();
             $da=$dsa->row();
             if(!empty($da)){
               $symbol = $da->id;
               $logo = $da->logo;

               $ip = $this->input->ip_address();
       date_default_timezone_set("Asia/Calcutta");
               $cur_date=date("Y-m-d H:i:s");

               // $price = $this->get_price($logo);

               // calculate last entry of same stock

       $data_insert = array('name'=>$stock,
                 'symbol'=>$symbol,
                 'price'=>$price,
                 'call_type'=>2, //1 for buy 2 for sell
                 'call_timeframe'=>$time, //1 for 5 min, 2 for 15 min, 3 for 1hr, 4 for 1 day
                 'call_open_close'=>1, //1 for open, 2 for close
                 'ip' =>$ip,
                 'date'=>$cur_date

                 );

       $last_id=$this->base_model->insert_table("tbl_stock_call",$data_insert,1) ;
echo json_encode("Success");

             }
           else{
             echo "No data";
           }



}

public function buy_call_close($stock,$time){
  // Set response header to avoid content negotiation issues
    //   header('Content-Type: application/json');

// log_message('error', 'BUY CALL CLOSE ' . $stock);
  // Get the raw POST data
  $json_data = file_get_contents("php://input");
  // log_message('error', 'AllText' . $json_data);

  // Access the 'text' field
  if (isset($json_data)) {
    $text =  $json_data; // Output: BTCUSD Greater Than 9000
    log_message('error', 'Text' . $text);
    // Use regex to extract the number
        preg_match('/\b\d+\b/', $text, $matches);

        // Output the extracted number
        if (!empty($matches)) {
          $price = $matches[0]; // Output: 327
          // log_message('error', 'Price' . $price);
        } else {
            $price = 0;
        }
  } else {
        $text = "";
        $price = 0;
  }

$this->db->select('*');
$this->db->from('tbl_stock_list');
$this->db->where('name',$stock);
$dsa= $this->db->get();
$da=$dsa->row();
if(!empty($da)){
 $high_price = "";
 $symbol = $da->id;
 $logo = $da->logo;

 $ip = $this->input->ip_address();
date_default_timezone_set("Asia/Calcutta");
 $cur_date=date("Y-m-d H:i:s");
 // $price = $this->get_price($logo);


$data_insert = array('name'=>$stock,
   'symbol'=>$symbol,
   'price'=>$price,
   'call_type'=>1, //1 for buy 2 for sell
   'call_timeframe'=>$time, //1 for 5 min, 2 for 15 min, 3 for 1hr, 4 for 1 day
   // 'high_price'=>$high_price, //highest price of duration
   'call_open_close'=>2, //1 for open, 2 for close
   'ip' =>$ip,
   'date'=>$cur_date

   );

$last_id=$this->base_model->insert_table("tbl_stock_call",$data_insert,1);

if($time == 1 || $time == 2){
  $this->buy_order_5min($symbol,$last_id,$price);
}
if($time == 2){
  $this->buy_order_15min($symbol,$last_id,$price);
}
if($time == 3){
  $this->buy_order_1hr($symbol,$last_id,$price);
}
echo json_encode("Success");
}
else{
echo "No data";
}





}

public function sell_call_close($stock,$time){

  // Set response header to avoid content negotiation issues
        // header('Content-Type: application/json');

// log_message('error', 'BUY CALL CLOSE ' . $stock);
  // Get the raw POST data
  $json_data = file_get_contents("php://input");
  // log_message('error', 'AllText' . $json_data);

  // Access the 'text' field
  if (isset($json_data)) {
    $text =  $json_data; // Output: BTCUSD Greater Than 9000
    log_message('error', 'Text' . $text);
    // Use regex to extract the number
        preg_match('/\b\d+\b/', $text, $matches);

        // Output the extracted number
        if (!empty($matches)) {
          $price = $matches[0]; // Output: 327
          // log_message('error', 'Price' . $price);
        } else {
            $price = 0;
        }
  } else {
        $text = "";
        $price = 0;
  }

  $this->db->select('*');
              $this->db->from('tbl_stock_list');
              $this->db->where('name',$stock);
              $dsa= $this->db->get();
              $da=$dsa->row();
              if(!empty($da)){
								 $high_price = "";
                $symbol = $da->id;
                $logo = $da->logo;

                $ip = $this->input->ip_address();
        date_default_timezone_set("Asia/Calcutta");
                $cur_date=date("Y-m-d H:i:s");
                // $price = $this->get_price($logo);

                // calculate last entry of same stock
                $this->db->select('*');
                            $this->db->from('tbl_stock_call');
                            $this->db->where('symbol',$symbol);
														 $this->db->where('call_timeframe',$time);
														 $this->db->where('call_open_close',2);
														 $this->db->order_by('id','DESC');
                            $dsa2= $this->db->get();
                            $da2=$dsa2->row();
														 if(!empty($da2)){
																	 	 $high_price = $this->calculate_high($da2->date,$cur_date,$logo);
																		 $data_update = array(
					                                     'high_price'=>$high_price
					                                     );
					                                     $this->db->where('id', $da2->id);
					                     								$zapak=$this->db->update('tbl_stock_call', $data_update);




                            }
                          else{
                          }




        $data_insert = array('name'=>$stock,
                  'symbol'=>$symbol,
                  'price'=>$price,
                  'call_type'=>2, //1 for buy 2 for sell
                  'call_timeframe'=>$time, //1 for 5 min, 2 for 15 min, 3 for 1hr, 4 for 1 day
                  // 'high_price'=>$high_price, //highest price of duration
                  'call_open_close'=>2, //1 for open, 2 for close
                  'ip' =>$ip,
                  'date'=>$cur_date

                  );

        $last_id=$this->base_model->insert_table("tbl_stock_call",$data_insert,1) ;

        if($time == 1){
          $this->sell_order_5min($symbol, $last_id,$price);
        }
        if($time == 2){
          $this->sell_order_15min($symbol, $last_id,$price);
        }
        if($time == 3){
          $this->sell_order_1hr($symbol, $last_id,$price);
        }
echo json_encode("Success");

              }
            else{
              echo "No data";
            }





               }

public function last_call_fixed($symbol, $time){
$this->db->select('*');
$this->db->from('tbl_stock_list');
$this->db->where('id',$symbol);
$dsa= $this->db->get();
$da=$dsa->row();
if(!empty($da)){

if($time==1){
$original_call = $da->current_5;
if($original_call == 1){
$call_type = 2;
}
elseif($original_call == 2){
$call_type = 1;
}
}
if($time==2){
$original_call = $da->current_15;
if($original_call == 1){
$call_type = 2;
}
elseif($original_call == 2){
$call_type = 1;
}
}
if($time==3){
$original_call = $da->current_1hr;
if($original_call == 1){
$call_type = 2;
}
elseif($original_call == 2){
$call_type = 1;
}
}
if($time==4){
$original_call = $da->current_1day;
if($original_call == 1){
$call_type = 2;
}
elseif($original_call == 2){
$call_type = 1;
}
}
return $call_type;
}
else{

}
}


public function reverse_value($value){
if($value == 1){
return 2;
}
if($value == 2){
return 1;
}
if($value == 0){
return 1;
}

}


public function update_highs_market_end(){
//UPDATE HIGH OF STOCKS WHEN MARKET ENDS


$date = new DateTime(); // Get current date and time
$date->setTime(15, 35, 00); // Set time to 15:30:00
$date2 = $date->format('Y-m-d H:i:s');



        $this->db->select('*');
$this->db->from('tbl_stock_list');
// $this->db->where('product_id',$pid);
$d1= $this->db->get();
$i=1; foreach($d1->result() as $dd1) {
$symbol_id = $dd1->id;
$symbol = $dd1->logo;
// 5min
			$this->db->select('*');
      $this->db->from('tbl_stock_call');
      $this->db->where('symbol',$symbol_id);
      $this->db->where('call_open_close',2);
      $this->db->where('call_type',1);
      $this->db->where('call_timeframe',1);
      $this->db->order_by('id','DESC');
      $dsa= $this->db->get();
      $da=$dsa->row();
      if(!empty($da)){

					 $high_price = $this->calculate_high($da->date,$date2,$symbol);
					 //check if old high price is higher or lower then db price
					 $old_high_price = $da->high_price;
					 if($high_price > $old_high_price){
						 //update new price in db
						 $data_update = array(
           'high_price'=>$high_price

           );

           $this->db->where('id', $da->id);
						$zapak=$this->db->update('tbl_stock_call', $data_update);


					 }


      }

// 15min
$this->db->select('*');
$this->db->from('tbl_stock_call');
$this->db->where('symbol',$symbol_id);
$this->db->where('call_open_close',2);
$this->db->where('call_type',1);
$this->db->where('call_timeframe',2);
$this->db->order_by('id','DESC');
$dsa= $this->db->get();
$da=$dsa->row();
if(!empty($da)){

 $high_price = $this->calculate_high($da->date,$date2,$symbol);
 //check if old high price is higher or lower then db price
 $old_high_price = $da->high_price;
 if($high_price > $old_high_price){
	 //update new price in db
	 $data_update = array(
 'high_price'=>$high_price

 );

 $this->db->where('id', $da->id);
$zapak=$this->db->update('tbl_stock_call', $data_update);


 }


}
// 1hr
			$this->db->select('*');
      $this->db->from('tbl_stock_call');
      $this->db->where('symbol',$symbol_id);
      $this->db->where('call_open_close',2);
			$this->db->where('call_type',1);
      $this->db->where('call_timeframe',3);
      $this->db->order_by('id','DESC');
      $dsa= $this->db->get();
      $da=$dsa->row();
      if(!empty($da)){

					 $high_price = $this->calculate_high($da->date,$date2,$symbol);
					 //check if old high price is higher or lower then db price
					 $old_high_price = $da->high_price;
					 if($high_price > $old_high_price){
						 //update new price in db
						 $data_update = array(
           'high_price'=>$high_price

           );

           $this->db->where('id', $da->id);
						$zapak=$this->db->update('tbl_stock_call', $data_update);


					 }


      }

			// 1day
								$this->db->select('*');
								$this->db->from('tbl_stock_call');
								$this->db->where('symbol',$symbol_id);
								$this->db->where('call_open_close',2);
								$this->db->where('call_type',1);
								$this->db->where('call_timeframe',4);
								$this->db->order_by('id','DESC');
								$dsa= $this->db->get();
								$da=$dsa->row();
								if(!empty($da)){

										 $high_price = $this->calculate_high($da->date,$date2,$symbol);
										 //check if old high price is higher or lower then db price
										 $old_high_price = $da->high_price;
										 if($high_price > $old_high_price){
											 //update new price in db
											 $data_update = array(
										 'high_price'=>$high_price

										 );

										 $this->db->where('id', $da->id);
										$zapak=$this->db->update('tbl_stock_call', $data_update);


										 }


								}

								sleep(1);
}

}






public function calculate_high($t1,$t2,$symbol){

$candles_get = $this->highest_price_sameday($t1,$t2,$symbol);
$candles = json_decode($candles_get);
// log_message('error', 'Message' . $candles_get);
// log_message('error', 'Symbol' . $symbol);
  if (isset($candles->candles)) {
  $can = $candles->candles;
  $h_price = 0;
  foreach($can as $cc){
  if($h_price < $cc[2]){
  $h_price = $cc[2];
  }
  }
  return $h_price;
}
else{
  log_message('error', 'Symbol' . $symbol);
  log_message('error', 'Message' . $candles_get);
}

}

public function highest_price_sameday($date1,$date2,$symbol){

// $datetime1 = new DateTime($date1);
// $d1 = $datetime1->format('Y-m-d');
$date00 = new DateTime($date1); // Your original date and time
$date00->setTime($date00->format('H'), $date00->format('i'), 0); // Set seconds to 0
$date100 = $date00->format('Y-m-d H:i:s');
$date11 = new DateTime($date100, new DateTimeZone('Asia/Kolkata')); // Your date and timezone
$d1 = $date11->getTimestamp();

$date0011 = new DateTime($date2); // Your original date and time
$date0011->setTime($date0011->format('H'), $date0011->format('i'), 0); // Set seconds to 0
$date200 = $date0011->format('Y-m-d H:i:s');
$date22 = new DateTime($date200, new DateTimeZone('Asia/Kolkata')); // Your date and timezone
$d2 = $date22->getTimestamp();

$symbol = $symbol;
$auth_code = $this->auth_code();
$res = "5";
$date_format = 0;
$range_from = $d1;
$range_to = $d2;

$curl = curl_init();
curl_setopt_array($curl, array(
CURLOPT_URL => 'https://api-t1.fyers.in/data/history?symbol='.$symbol.'&resolution='.$res.'&date_format='.$date_format.'&range_from='.$range_from.'&range_to='.$range_to.'&cont_flag=',
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
// $res = json_decode($response);
// $candles = $res->candles;
// foreach($candles as $cc){
// 	$epoch = $cc[0];
// 	$epochTime = $epoch; // Example epoch time
// $date = new DateTime("@$epochTime"); // The "@" symbol tells DateTime to interpret the value as a Unix timestamp
// $date->setTimezone(new DateTimeZone('Asia/Kolkata')); // Set timezone to IST
// echo $date->format('Y-m-d H:i:s');
//
// // 	$dateepoch = new DateTime();
// // $dateepoch->setTimestamp($epoch);
// // echo $dateepoch->format('Y-m-d H:i:s');
// echo "<br/>";
// echo $cc[2];
//
// echo "<br/>";echo "<br/>";
// }
// print_r($candles);
return $response;

}



public function get_price($symbol)
{
$auth_code = $this->auth_code();
// SYMBOL -> STOCK OR OPTION NAME NSE:NIFTY50-INDEX
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
// print_r($response);
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
if($r4 == 0){
$r4 = $r3->bid;
}

return $r4;
}


}


curl_close($curl);

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


//ORDER START HERE

public function buy_order_5min($id,$call_id,$price){
// log_message('error', 'BUY ON 5 MIN' . $id);
//check if buy call exist on 5 min and 15 min
$this->db->select('*');
            $this->db->from('tbl_stock_call');
            $this->db->where('symbol',$id);
            $this->db->where('call_timeframe',1);
            $this->db->where('call_open_close',2);
            $this->db->order_by('id','DESC');
            $dsa= $this->db->get()->row();
            if(!empty($dsa)){
              if($dsa->call_type == 1){
                $this->db->select('id,call_type,name');
                $this->db->from('tbl_stock_call');
                $this->db->where('symbol',$id);
                $this->db->where('call_timeframe',2);
                $this->db->where('call_open_close',2);
                $this->db->order_by('id','DESC');
                $dsa2 = $this->db->get()->row();
                if(!empty($dsa2)){
                if($dsa2->call_type == 1){
                  $this->db->select('*');
                              $this->db->from('tbl_orders');
                              $this->db->where('stock_id',$id);
                              $this->db->where('status',1);
                              $dsa33= $this->db->get();
                              $da22=$dsa33->row();
                              if(!empty($da22)){
                              exit;
                              }


                  $this->db->select('logo');
                              $this->db->from('tbl_stock_list');
                              $this->db->where('id',$id);
                              $dsa3= $this->db->get();
                              $da=$dsa3->row();
                              if(!empty($da)){
                              $logo = $da->logo;
                              }
                            else{
                              $logo = "";
                            }


                  // $price = $this->get_price($logo);
                  $qty = round(AMOUNT/$price)-1;

                                    $ip = $this->input->ip_address();
                            date_default_timezone_set("Asia/Calcutta");
                                    $cur_date=date("Y-m-d H:i:s");

                            $data_insert = array('stock'=>$dsa2->name,
                                      'stock_id'=>$id,
                                      'type'=>1,
                                      'buy_call_5min'=>$dsa->id,
                                      'buy_call_15min'=>$dsa2->id,
                                      'sell_call_5min'=>'',
                                      'buy_amount'=>$price,
                                      'sell_amount'=>'',
                                      'qty'=>$qty,
                                      'buy_time'=>$cur_date,
                                      'sell_time'=>'',
                                      'status' =>1,
                                      'profit_loss_status'=>0,
                                      'profit_loss_amt'=>'',
                                      'ip' =>$ip,
                                      'date'=>$cur_date

                                      );
                          $last_id=$this->base_model->insert_table("tbl_orders",$data_insert,1);
                }
              }
              }
            }
          else{
            echo "No data";
          }


}


public function sell_order_5min($id, $sell_id, $price){
// log_message('error', 'SELL ON 5 MIN' . $id);
  $this->db->select('logo');
              $this->db->from('tbl_stock_list');
              $this->db->where('id',$id);
              $dsa= $this->db->get();
              $da=$dsa->row();
              if(!empty($da)){
              $logo = $da->logo;
              }
            else{
              $logo = "";
            }


  // $price = $this->get_price($logo);

  $this->db->select('*');
              $this->db->from('tbl_orders');
              $this->db->where('status',1);
              $this->db->where('stock_id',$id);
              $this->db->order_by('id','DESC');
              $dsa= $this->db->get();
              $da=$dsa->row();
              if(!empty($da)){

      $b1= $da->buy_amount;
      $p_l = $price - $b1;
      if($p_l < 0){
        //profit
        $profit_loss_status = 2;
      }
      else{
        $profit_loss_status = 1;
      }

      $p_l_amt = $p_l * $da->qty;

      //government charges calculate
      $gov = $this->government_charges_calculator($b1,$price,$da->qty,1);
      $final_price = $p_l_amt - $gov;

                    $ip = $this->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
                    $cur_date=date("Y-m-d H:i:s");
$highest_value = $this->calculate_high($da->buy_time,$cur_date,$logo);
$percen = $highest_value - $b1;
$percentage = $percen/$b1;
$percentage2= $percentage*100;
            $data_update = array(
                      'sell_call_5min'=>$sell_id,
                      'sell_amount'=>$price,
                      'sell_time'=>$cur_date,
                      'status' =>2,
                      'profit_loss_status'=>$profit_loss_status,
                      'profit_loss_amt'=>$p_l_amt,
                      'highest_value'=>$highest_value,
                      'highest_percentage'=>$percentage2,
                      'gov_fees'=>$gov,
                      'final_price'=>$final_price,
                      'ip' =>$ip,
                      'date'=>$cur_date

                      );

                      $this->db->where('id', $da->id);
                      $zapak=$this->db->update('tbl_orders', $data_update);
}

}

public function buy_order_15min($id,$buy_id, $price){
log_message('error', 'BUY ON 15 MIN' . $id);
//check if buy call exist on 15 min and 1 hr

                  $this->db->select('*');
                              $this->db->from('tbl_orders2');
                              $this->db->where('stock_id',$id);
                              $this->db->where('status',1);
                              $dsa33= $this->db->get();
                              $da22=$dsa33->row();
                              if(!empty($da22)){
                              exit;
                              }


                  $this->db->select('name,logo');
                              $this->db->from('tbl_stock_list');
                              $this->db->where('id',$id);
                              $dsa3= $this->db->get();
                              $da=$dsa3->row();
                              if(!empty($da)){
                              $logo = $da->logo;
                              }
                            else{
                              $logo = "";
                              log_message('error', 'LOGO NOT FOUND' . $id);
                              exit;
                            }


                  // $price = $this->get_price($logo);
                  $qty = round(AMOUNT/$price)-1;

                                    $ip = $this->input->ip_address();
                            date_default_timezone_set("Asia/Calcutta");
                                    $cur_date=date("Y-m-d H:i:s");

                            $data_insert = array('stock'=>$da->name,
                                      'stock_id'=>$id,
                                      'type'=>1,
                                      'buy_call_15min'=>$buy_id,
                                      'buy_call_1hr'=>'',
                                      'sell_call_15min'=>'',
                                      'buy_amount'=>$price,
                                      'sell_amount'=>'',
                                      'qty'=>$qty,
                                      'buy_time'=>$cur_date,
                                      'sell_time'=>'',
                                      'status' =>1,
                                      'profit_loss_status'=>0,
                                      'profit_loss_amt'=>'',
                                      'ip' =>$ip,
                                      'date'=>$cur_date

                                      );
                          $last_id=$this->base_model->insert_table("tbl_orders2",$data_insert,1);

$title = "Buy Call Recieved on 15 min ".$da->name;
$content = "Buy Call Recieved on 15 min ".$da->name." at Price $price at ".$cur_date;
$this->send_notitifications($title,$content);



}

public function buy_order_1hr($id,$buy_id,$price){
log_message('error', 'BUY ON 1 HR -' . $id);
//check if buy call exist on 15 min and 1 hr

                  $this->db->select('*');
                              $this->db->from('tbl_orders3');
                              $this->db->where('stock_id',$id);
                              $this->db->where('status',1);
                              $dsa33= $this->db->get();
                              $da22=$dsa33->row();
                              if(!empty($da22)){
                              exit;
                              }

                              $option = 0;
                              $option_price = 0;
                  $this->db->select('name,logo');
                              $this->db->from('tbl_stock_list');
                              $this->db->where('id',$id);
                              $dsa3= $this->db->get();
                              $da=$dsa3->row();
                              if(!empty($da)){
                              $logo = $da->logo;
                              $option = $this->convert_option_name($da->name,$price);
                              log_message('error', 'OPTION_NAME - ' . $option);
                              $option_price = $this->get_price($option);
                              }
                            else{
                              $logo = "";
                              log_message('error', 'LOGO NOT FOUND' . $id);
                              exit;
                            }


                  // $price = $this->get_price($logo);
                  $qty = round(AMOUNT/$price)-1;

                                    $ip = $this->input->ip_address();
                            date_default_timezone_set("Asia/Calcutta");
                                    $cur_date=date("Y-m-d H:i:s");

                            $data_insert = array('stock'=>$da->name,
                                      'stock_id'=>$id,
                                      'option_stock'=>$option,
                                      'option_price'=>$option_price,
                                      'type'=>1,
                                      'buy_call_1hr'=>$buy_id,
                                      'buy_call_1day'=>'',
                                      'sell_call_1hr'=>'',
                                      'buy_amount'=>$price,
                                      'sell_amount'=>'',
                                      'qty'=>$qty,
                                      'buy_time'=>$cur_date,
                                      'sell_time'=>'',
                                      'status' =>1,
                                      'profit_loss_status'=>0,
                                      'profit_loss_amt'=>'',
                                      'ip' =>$ip,
                                      'date'=>$cur_date

                                      );
                          $last_id=$this->base_model->insert_table("tbl_orders3",$data_insert,1);

$title = "Buy Call Recieved on 1 Hr ".$da->name;
$content = "Buy Call Recieved on 1 Hr ".$da->name." at Price $price at ".$cur_date;
$this->send_notitifications($title,$content);



}


public function sell_order_15min($id, $sell_id,$price){
log_message('error', 'SELL ON 15 MIN' . $id);
  $this->db->select('name,logo');
              $this->db->from('tbl_stock_list');
              $this->db->where('id',$id);
              $dsa= $this->db->get();
              $da=$dsa->row();
              if(!empty($da)){
              $logo = $da->logo;
              $name = $da->name;
              }
            else{
              $logo = "";
              $name = "";
              log_message('error', 'LOGO NOT FOUND' . $id);
              exit;
            }


  // $price = $this->get_price($logo);

  $this->db->select('*');
              $this->db->from('tbl_orders2');
              $this->db->where('status',1);
              $this->db->where('stock_id',$id);
              $this->db->order_by('id','DESC');
              $dsa= $this->db->get();
              $da=$dsa->row();
              if(!empty($da)){

      $b1= $da->buy_amount;
      $p_l = $price - $b1;
      if($p_l < 0){
        //profit
        $profit_loss_status = 2;
      }
      else{
        $profit_loss_status = 1;
      }

      $p_l_amt = $p_l * $da->qty;

      //government charges calculate
      $gov = $this->government_charges_calculator($b1,$price,$da->qty,1);
      $final_price = $p_l_amt - $gov;

                    $ip = $this->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
                    $cur_date=date("Y-m-d H:i:s");
$highest_value = $this->calculate_high($da->buy_time,$cur_date,$logo);
$percen = $highest_value - $b1;
$percentage = $percen/$b1;
$percentage2= $percentage*100;
            $data_update = array(
                      'sell_call_15min'=>$sell_id,
                      'sell_amount'=>$price,
                      'sell_time'=>$cur_date,
                      'status' =>2,
                      'profit_loss_status'=>$profit_loss_status,
                      'profit_loss_amt'=>$p_l_amt,
                      'highest_value'=>$highest_value,
                      'highest_percentage'=>$percentage2,
                      'gov_fees'=>$gov,
                      'final_price'=>$final_price,
                      'ip' =>$ip,
                      'date'=>$cur_date

                      );

                      $this->db->where('id', $da->id);
                      $zapak=$this->db->update('tbl_orders2', $data_update);
                      
                      $title = "Sell Call Recieved on 15 min ".$name;
$content = "Sell Call Recieved on 15 min ".$name." at Price $price at ".$cur_date;
$this->send_notitifications($title,$content);
}



}

public function sell_order_1hr($id, $sell_id,$price){
log_message('error', 'SELL ON 1 HR' . $id);
  $this->db->select('logo');
              $this->db->from('tbl_stock_list');
              $this->db->where('id',$id);
              $dsa= $this->db->get();
              $da=$dsa->row();
              if(!empty($da)){
              $logo = $da->logo;
              $name = $da->name;
              }
            else{
              $logo = "";
              $name = "";
              log_message('error', 'LOGO NOT FOUND' . $id);
              exit;
            }


  // $price = $this->get_price($logo);

  $this->db->select('*');
              $this->db->from('tbl_orders3');
              $this->db->where('status',1);
              $this->db->where('stock_id',$id);
              $this->db->order_by('id','DESC');
              $dsa= $this->db->get();
              $da=$dsa->row();
              if(!empty($da)){

      $b1= $da->buy_amount;
      $p_l = $price - $b1;
      if($p_l < 0){
        //profit
        $profit_loss_status = 2;
      }
      else{
        $profit_loss_status = 1;
      }

      $p_l_amt = $p_l * $da->qty;

      //government charges calculate
      $gov = $this->government_charges_calculator($b1,$price,$da->qty,1);
      $final_price = $p_l_amt - $gov;

                    $ip = $this->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
                    $cur_date=date("Y-m-d H:i:s");
$highest_value = $this->calculate_high($da->buy_time,$cur_date,$logo);
$percen = $highest_value - $b1;
$percentage = $percen/$b1;
$percentage2= $percentage*100;
            $data_update = array(
                      'sell_call_1hr'=>$sell_id,
                      'sell_amount'=>$price,
                      'sell_time'=>$cur_date,
                      'status' =>2,
                      'profit_loss_status'=>$profit_loss_status,
                      'profit_loss_amt'=>$p_l_amt,
                      'highest_value'=>$highest_value,
                      'highest_percentage'=>$percentage2,
                      'gov_fees'=>$gov,
                      'final_price'=>$final_price,
                      'ip' =>$ip,
                      'date'=>$cur_date

                      );

                      $this->db->where('id', $da->id);
                      $zapak=$this->db->update('tbl_orders3', $data_update);
                      
                                            $title = "Sell Call Recieved on 1hr ".$name;
$content = "Sell Call Recieved on 1hr ".$name." at Price $price at ".$cur_date;
$this->send_notitifications($title,$content);
}

}

public function high_tracker(){

  date_default_timezone_set("Asia/Calcutta");
          $cur_date=date("Y-m-d H:i:s");
           $currentHour = date('H'); // 24-hour format (e.g., 9 = 09, 3 PM = 15)
  if ($currentHour >= 9 && $currentHour < 17) {
              $this->db->select('*');
  $this->db->from('tbl_orders2');
  $this->db->where('status', 1);
  $or2= $this->db->get();

  $i=1; foreach($or2->result() as $orr2) {

    $stock_id = $orr2->stock_id;
    $this->db->select('logo');
                $this->db->from('tbl_stock_list');
                $this->db->where('id',$stock_id);
                $dsa22= $this->db->get()->row();
                if(!empty($dsa22)){

                  $logo = $dsa22->logo;
                  $ss = $this->calculate_high($orr2->buy_time,$cur_date,$logo);

                  if($ss > $orr2->highest_value){
                    $percen = $ss - $orr2->buy_amount;
                    $percentage = $percen/$orr2->buy_amount;
                    $percentage2= $percentage*100;


                    $data_update = array('highest_value'=>$ss,
                    'highest_percentage'=>$percentage2,
                          );
                          $this->db->where('id', $orr2->id);
                          $zapak=$this->db->update('tbl_orders2', $data_update);
                  }

                }
              else{
                $logo = "";
              }

sleep(4);

  }

  $this->db->select('*');
$this->db->from('tbl_orders3');
$this->db->where('status', 1);
$or2= $this->db->get();

$i=1; foreach($or2->result() as $orr2) {

$stock_id = $orr2->stock_id;
$this->db->select('logo');
    $this->db->from('tbl_stock_list');
    $this->db->where('id',$stock_id);
    $dsa22= $this->db->get()->row();
    if(!empty($dsa22)){

      $logo = $dsa22->logo;
      $ss = $this->calculate_high($orr2->buy_time,$cur_date,$logo);

      if($ss > $orr2->highest_value){
        $percen = $ss - $orr2->buy_amount;
        $percentage = $percen/$orr2->buy_amount;
        $percentage2= $percentage*100;


        $data_update = array('highest_value'=>$ss,
        'highest_percentage'=>$percentage2,
              );
              $this->db->where('id', $orr2->id);
              $zapak=$this->db->update('tbl_orders2', $data_update);
      }

    }
  else{
    $logo = "";
  }

sleep(4);

}



} //hour code ends here

}

public function send_notitifications($value1,$value2){
// $value1 = "Hii";
// $value2 = "How are you avani";
sleep(4);
$value3 = 4;
  // Build the URL
$url = "http://www.fineoutput.work/master/bhadmin/Cronjob/sendNotification2/".urlencode($value1)."/".urlencode($value2)."/".urlencode($value3);
echo $url;
// Initialize cURL
$ch = curl_init();

// Set cURL options
curl_setopt($ch, CURLOPT_URL, $url); // Set the URL
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return response as a string
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Follow redirects
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Skip SSL verification (if needed)

// Execute the request
$response = curl_exec($ch);

// Check for errors
if (curl_errno($ch)) {
echo 'Curl error: ' . curl_error($ch);
} else {
// Display the response
// echo $response;
log_message('error', 'CURL--' . $response);
}

// Close cURL
curl_close($ch);
               }



public function new_order_way($stock){

  log_message('error', 'STOCK_NAME - ' . $stock);

  // Get the raw POST data
  $json_data = file_get_contents("php://input");
  // log_message('error', 'AllText' . $json_data);

  // Access the 'text' field
  if (isset($json_data)) {
    $text =  $json_data; // Output: BTCUSD Greater Than 9000
    log_message('error', 'NEW_ORDER_TEXT' . $text);
    // Use regex to extract the number
        // preg_match('/\b\d+\b/', $text, $matches);

        // Output the extracted number
        // if (!empty($matches)) {
        //   $price = $matches[0]; // Output: 327
        //   log_message('error', 'Price' . $price);
        // } else {
        //     $price = 0;
        // }
  } else {
        // $text = "";
        // $price = 0;
  }


}

public function convert_option_name($stock,$price){

//
            $this->db->select('*');
$this->db->from('tbl_stock_list');
$this->db->where('name',$stock);
$d1= $this->db->get()->row();
// $i=1; foreach($d1->result() as $dd1) {
//
if(!empty($d1)){
  $roundedPrice = ceil($price / 10) * 10;
  // $roundedPrice; // Outputs: 720
  $mon = strtoupper(date("M"));
  $yr = date("y");
  $name = $d1->name;
  $new_name  = $name.$yr.$mon.$roundedPrice."CE";
  // $new_price = $this->get_price($new_name);

  return $new_name;
}
else{
  return 0;
}


// }



}



public function test_high(){

                $ss = $this->calculate_high("2025-01-24 11:30:02","2025-01-28 15:08:02","NSE:HINDALCO-EQ");
                echo $ss;
               }

public function government_charges_calculator($buy_amt, $sell_amount, $qty, $type){
  $total = 0;
  $buy_total = $buy_amt * $qty;
  $sell_total = $sell_amount * $qty;
  $turnover = $buy_total + $sell_total;

 if($type == 1){// stock sell next day
   $brokage = 40;
   //transaction charges
    $txn_charge = round($turnover * 0.00297/100,3);
    //sebi charges
    $sebi = round($turnover * 0.000001,2);
    //gst
    $gst = round(($brokage + $sebi + $txn_charge)*18/100,2);
    //STT charges
    $stt = round($turnover * 0.1/100,2);


    //stamp duty
    $stamp = round($buy_total * 0.015/100,2);
    $nse = round($turnover * 0.000001,2);

    // echo "TXN-Charges - ".$txn_charge;
    // echo "<br/>GST - ".$gst;
    // echo "<br/>STT - ".$stt;
    // echo "<br/>SEBI - ".$sebi;
    // echo "<br/>STAMP - ".$stamp;
    // echo "<br/>NSE - ".$nse;

   $total = round($brokage + $txn_charge + $stt + $sebi + $stamp +$gst + $nse,2);
 }

 if($type == 2){ //intraday
    $brokage = $turnover * 0.03/100;
    //transaction charges
    $txn_charge = round($turnover * 0.00297/100,3);
    //sebi charges
    $sebi = round($turnover * 0.000001,2);
    //gst
    $gst = round(($brokage + $sebi + $txn_charge)*18/100,2);
    //STT charges
    $stt = round($sell_total * 0.025/100,2);
    //stamp duty
    $stamp = round($buy_total * 0.003/100,2);

    $nse = round($turnover * 0.000001,2);
    // echo "BROKAGE - ".$brokage;
    // echo "<br/>TXN-Charges - ".$txn_charge;
    // echo "<br/>GST - ".$gst;
    // echo "<br/>STT - ".$stt;
    // echo "<br/>SEBI - ".$sebi;
    // echo "<br/>STAMP - ".$stamp;
    // echo "<br/>NSE - ".$nse;

   $total = round($brokage + $txn_charge + $stt + $sebi + $stamp +$gst + $nse,2);
 }

 if($type == 3){ //f&O
    $brokage = 40;
    //transaction charges
    $txn_charge = round($turnover * 0.03503/100,3);
    //sebi charges
    $sebi = round($turnover * 0.000001,2);
    //Clearing charges
    $clearing = round($turnover * 0.009/100,2);
    //gst
    $gst = round(($brokage + $sebi + $txn_charge+ $clearing)*18/100,2);
    //STT charges
    $stt = round($sell_total * 0.1/100,2);

    //stamp duty
    $stamp = round($buy_total * 0.003/100,2);
    $nse = round($turnover * 0.000005,2);

    // echo "TURNOVER - ".$turnover;
    // echo "<br/>BROKAGE - ".$brokage;
    // echo "<br/>TXN-Charges - ".$txn_charge;
    // echo "<br/>GST - ".$gst;
    // echo "<br/>STT - ".$stt;
    // echo "<br/>SEBI - ".$sebi;
    // echo "<br/>STAMP - ".$stamp;
    // echo "<br/>NSE - ".$nse;

   $total = round($brokage + $txn_charge + $stt + $sebi + $stamp +$gst + $nse,2);
 }

// echo "<br/>";
 return $total;


}

public function test_push(){
    
    $this->send_notitifications("hi","how are you");
    
}
public function test_text(){


$text = "Buy on BDL 5min Close at 1312";
preg_match('/\b\d+\b/', $text, $matches);

// Output the extracted number
if (!empty($matches)) {
  $price = $matches[0]; // Output: 327

} else {
    $price = 0;
}
echo $price;

}


}
