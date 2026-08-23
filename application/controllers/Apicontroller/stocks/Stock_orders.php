<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Stock_orders extends CI_finecontrol{
function __construct()
{
parent::__construct();
$this->load->model("login_model");
$this->load->model("admin/base_model");
$this->load->library('user_agent');
}

public function buy_order_5min($id){

//check if buy call exist on 5 min and 15 min
$this->db->select('id,call_type');
            $this->db->from('tbl_stock_call');
            $this->db->where('symbol',$id);
            $this->db->where('call_timeframe',1);
            $this->db->where('call_open_close',2);
            $this->db->order_by('id','DESC');
            $dsa= $this->db->get()->row();
            if(!empty($dsa)){
              if($dsa->call_type == 1){
                $this->db->select('id,call_type');
                $this->db->from('tbl_stock_call');
                $this->db->where('symbol',$id);
                $this->db->where('call_timeframe',2);
                $this->db->where('call_open_close',2);
                $this->db->order_by('id','DESC');
                $dsa2 = $this->db->get()->row();
                if($dsa2->call_type == 1){
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


                  $price = $this->get_price($logo);
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
          else{
            echo "No data";
          }


}


public function sell_order_5min($id, $sell_id){

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


  $price = $this->get_price($logo);

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
        $profit_loss_status = 1;
      }
      else{
        $profit_loss_status = 2;
      }

      $p_l_amt = $p_l * $da->qty;
                    $ip = $this->input->ip_address();
            date_default_timezone_set("Asia/Calcutta");
                    $cur_date=date("Y-m-d H:i:s");

            $data_update = array(
                      'sell_call_5min'=>$sell_id,
                      'sell_amount'=>$price,
                      'sell_time'=>$cur_date,
                      'status' =>2,
                      'profit_loss_status'=>$profit_loss_status,
                      'profit_loss_amt'=>$p_l_amt,
                      'ip' =>$ip,
                      'date'=>$cur_date

                      );

                      $this->db->where('id', $da->id);
                      $zapak=$this->db->update('tbl_orders', $data_update);
}

}


public function buy_order_option_5min(){





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

}
