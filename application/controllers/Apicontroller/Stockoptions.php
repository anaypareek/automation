<?php if (! defined('BASEPATH')) { exit('No direct script access allowed'); }
require_once(APPPATH . 'core/CI_finecontrol.php');
class Stockoptions extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }


    public function get_buycall()
    {
      // CHECK FIRST FOR KILL SWITCH
      // IF STATUS IS 0 THEN DONT DO ANYTHING
      // IF STATUS IS 1 THEN ONLY PLACE ORDER IN DB
      // IF STATUS IS 2 THEN PLACE ORDER AT BROKER AND ALSO SAVES THE DATA
      $switch = SWITCHER;
      // echo $switch;
      // exit;
      switch ($switch) {
      case 0:
      exit;
      case 1:
      // CHECK FIRST WHETHER A TRADE IS ALREAY ON IF YES THEN EXIT
      $this->db->select('*');
                  $this->db->from('tbl_stockoption_order');
                  $this->db->order_by('id','DESC');
                  $this->db->where('status','1');
                  $dsa= $this->db->get();
                  $da=$dsa->row();

                  if(!empty($da)){
                    $type = $da->type;
                    $buy_price = $da->buy_amount;
                if($type == 1){
                    exit;
                }
                if($type == 2){
                  // TRIGGER  EXIT FOR CE AND THEN PLACE PE ORDER
                  $get_present_price =  $this->get_price($da->stock);

                $sell_old_order =  $this->database(1,1,QTY,$da->stock,$get_present_price,$da->id,$buy_price);
                // GET NEW PRICE OF PE AND PLACE PE ORDER
                $get_present_price =  $this->get_price(STOCKCE);
              //   //WILL SELL OLD ORDER
              $sell_old_order =  $this->database(2,1,QTY,STOCKCE,$get_present_price,"","");
              if($sell_old_order){
                echo "success";
                exit;
              }
              else{
                echo "failed";
                exit;
              }
                }

                  }
                  else{
                    //NO PENDING ORDERS
                      $get_present_price =  $this->get_price(STOCKCE);
                        $buy_order =  $this->database(2,1,QTY,STOCKCE,$get_present_price,"");

                    if($buy_order){
                      echo "success";
                      exit;
                    }
                    else{
                      echo "failed";
                      exit;
                    }
                  }





      case 2:
        //SAFELY PLAY PLACE ORDER WITH TARGET ₹10 AND STOP LOSS ₹20 AND PLACE BO ORDER SO ORDER WILL AUTO EXIT
        $get_present_price =  $this->get_price(STOCKCE);
        $target = $get_present_price +10;
          $sl = $get_present_price-20;
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
         'Authorization: CAQOD0H5N3-100:'.AUTH_CODE,

       ),
     ));

     $response = curl_exec($curl);

     curl_close($curl);
     $r= json_decode($response);
        print_r($r);
        exit;

      default:
      exit;
    }

      // CHECK FIRST WHETHER A TRADE IS ALREAY ON IF YES THEN EXIT

      // IF NO TRADE IS ACTIVE




      //---------------//





      $res = array('message'=>'success',
        'status'=>200,
        'data'=>$slider,
          );

            echo json_encode($res);


    }

    public function get_sellcall()
    {

      $switch = SWITCHER;
      // echo $switch;
      // exit;
      switch ($switch) {
      case 0:
      exit;
      case 1:
      // CHECK FIRST WHETHER A TRADE IS ALREAY ON IF YES THEN EXIT TRADE FIRST
      $this->db->select('*');
                  $this->db->from('tbl_stockoption_order');
                  $this->db->order_by('id','DESC');
                  $this->db->where('status','1');
                  $dsa= $this->db->get();
                  $da=$dsa->row();

                  if(!empty($da)){
                    $type = $da->type;
                    $buy_price = $da->buy_amount;
                if($type == 2){
                    exit;
                }
                if($type == 1){
                  // TRIGGER  EXIT FOR CE AND THEN PLACE PE ORDER
                  $get_present_price =  $this->get_price($da->stock);
                  //WILL SELL OLD ORDER
                $sell_old_order =  $this->database(1,2,QTY,$da->stock,$get_present_price,$da->id,$buy_price);

                // GET NEW PRICE OF PE AND PLACE PE ORDER
                $get_present_price =  $this->get_price(STOCKPE);
              //   //WILL SELL OLD ORDER
              $sell_old_order =  $this->database(2,2,QTY,STOCKPE,$get_present_price,"","");
              if($sell_old_order){
                echo "success";
                exit;
              }
              else{
                echo "failed";
                exit;
              }
                }

                  }
                  else{
                    //NO PENDING ORDERS
                      $get_present_price =  $this->get_price(STOCKPE);
                        $buy_order =  $this->database(2,2,QTY,STOCKPE,$get_present_price,"");

                    if($buy_order){
                      echo "success";
                      exit;
                    }
                    else{
                      echo "failed";
                      exit;
                    }
                  }





      case 2:
      //SAFELY PLAY PLACE ORDER WITH TARGET ₹10 AND STOP LOSS ₹20 AND PLACE BO ORDER SO ORDER WILL AUTO EXIT
      $get_present_price =  $this->get_price(STOCKPE);
      $target = $get_present_price +10;
        $sl = $get_present_price-20;
      $curl = curl_init();


      // echo $target;
      // echo $sl;
      // exit;

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
       'Authorization: CAQOD0H5N3-100:'.AUTH_CODE,

     ),
   ));

   $response = curl_exec($curl);

   curl_close($curl);
   $r= json_decode($response);
        print_r($r);
      exit;
      default:
      exit;
    }

      // CHECK FIRST WHETHER A TRADE IS ALREAY ON IF YES THEN EXIT

      // IF NO TRADE IS ACTIVE




      //---------------//





      $res = array('message'=>'success',
        'status'=>200,
        'data'=>$slider,
          );

            echo json_encode($res);



    }


        public function place_order($order_type,$stock_type,$qty)
        {

      // STOCK TYPE MEAN -> PE OR CE I.E BUY OR SELL 1 for CE 2 FOR PE
      // ORDER TYPE MEAN -> Buy or exit order



          //---------------//





          $res = array('message'=>'success',
            'status'=>200,
            'data'=>$slider,
              );

                echo json_encode($res);


            }


            public function get_price($symbol)
            {

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
              'Authorization: CAQOD0H5N3-100:'.AUTH_CODE
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
        // $r = $d'];


              //---------------//







                }
                /**
                 * Used to insert value in the database of buy and sell order
                 * @param string $values
                 * @return array
                 */
                public function database($order_type,$stock_type,$qty,$stock,$price,$id="",$buy_price="")
                {
                    // ORDER TYPE MEAN -> Buy or exit order 1 for exit 2 for buy
                  // STOCK TYPE MEAN -> PE OR CE I.E BUY OR SELL 1 for CE 2 FOR PE

                  $ip = $this->input->ip_address();
                date_default_timezone_set("Asia/Calcutta");
                  $cur_date=date("Y-m-d H:i:s");
                  $cur_date2=date("Y-m-d");

                  switch ($order_type) {
                    case 1:
                    // WILL SELL THE ACTIVE ORDER
                    //UPDATE PRICE IN DATABASE
                    $pl =  $price - $buy_price;
                    if($pl>0){
                      $status2=1;
                    }
                    else{
                        $status2=2;
                    }

                    $total_pl = $pl * $qty;

                    $data_update = array(
                      'sell_amount'=>$price,
                      'sell_placed_amount'=>$price,
                      'status'=>2,
                      'status2 '=>$status2,
                      'pl_amount'=>$pl,
                      'total_pl'=>$total_pl,
                      'sell_time'=>$cur_date
                                );
          $this->db->where('id', $id);
          $zapak=$this->db->update('tbl_order', $data_update);

          $this->db->select('*');
                      $this->db->from('tbl_daily_leisure');
                      $this->db->where('date',$cur_date2);
                      $dsa= $this->db->get();
                      $da=$dsa->row();
                    if(!empty($da))  {

                      if($status2 == 1){
                        $profit_trades = $da->profit_trades+1;
                      }
                      else{
                          $profit_trades = $da->profit_trades;
                      }
                      if($status2 == 2){
                        $loss_trades = $da->loss_trades+1;
                      }
                      else{
                        $loss_trades = $da->loss_trades;
                      }

                      if($profit_trades >= $loss_trades){
                        $day_in_pl = 1;
                      }
                      else{
                        $day_in_pl = 2;
                      }


          $data_update2 = array(
            'no_of_trades'=>$da->no_of_trades+1,
            'profit_trades'=>$profit_trades,
            'loss_trades'=>$loss_trades,
            'day_in_pl'=>$day_in_pl,
            'pl_amount'=>$da->pl_amount+$total_pl
                      );
$this->db->where('date', $cur_date2);
$zapak2=$this->db->update('tbl_daily_leisure', $data_update2);
                    }
                    else{

                    }


          if($zapak!=0){
            return true;
            exit;

          }
          else{
            return false;
            exit;
          }


                    case 2:
                    // WILL PLACE NEW ORDER
                  $data_insert = array('stock'=>$stock,
                            'type'=>$stock_type,
                            'buy_amount'=>$price,
                            'buy_placed_amount'=>$price,
                            'order_type'=>$order_type,
                            'sell_amount'=>0,
                            'sell_placed_amount'=>0,
                            'status'=>1,
                            'ip' =>$ip,
                            'buy_time' =>$cur_date,
                            'qty' =>$qty,
                            'date'=>$cur_date
                            );

                  $last_id=$this->base_model->insert_table("tbl_order",$data_insert,1) ;


                  $this->db->select('*');
                              $this->db->from('tbl_daily_leisure');
                              $this->db->where('date',$cur_date2);
                              $dsa= $this->db->get();
                              $da=$dsa->row();
                            if(empty($da))  {
                              $data_insert2 = array(
                                'date'=>$cur_date2,
                                'no_of_trades'=>0,
                                'profit_trades'=>0,
                                'loss_trades'=>0,
                                'day_in_pl'=>0,
                                'pl_amount'=>0
                                          );
            $last_id2=$this->base_model->insert_table("tbl_daily_leisure",$data_insert2,1) ;
                            }


                  if($last_id!=0){
                    return true;
                    exit;

                  }
                  else{
                    return false;
                    exit;
                  }

                  }



                }




}
