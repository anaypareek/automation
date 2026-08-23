<?php if (! defined('BASEPATH')) { exit('No direct script access allowed'); }
require_once(APPPATH . 'core/CI_finecontrol.php');
class OptionFinder extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }

public function option_price(){


    date_default_timezone_set("Asia/Calcutta");
    $date=date("Y-m-d");
    $date1=date("y");
    $date2=date("M");
    $date3=date("d");

    // $auth_code = $this->auth_code();
    // $NiftyAt = $this->get_price(NIFTY);

    $symbol1 = "NSE:NIFTY";

    $s2= $date1;
    $s3 = strtoupper($date2);
    // echo $s3;

    $this->db->select('*');
$this->db->from('tbl_option_expiry');
$this->db->order_by('id','DESC');
$dsa= $this->db->get();
$da=$dsa->row();
if(!empty($da)){
$d1 = $da->day;
$d2 = $da->month;
$d3 = $da->year;
$d4 = $da->expiry_date;


    // Create DateTime object from that date string. The ! at the beginning resets the time to midnight
    $dateObj = DateTime::createFromFormat('!m/d/Y', $d4);
    date_default_timezone_set("Asia/Calcutta");
      $now = (new DateTime())->setTime(0,0,0);
    // Calculate difference
    $interval = $dateObj->diff($now);
    // Display difference
    $difference = $interval->format('%R%a');
    $difference = -$difference;
    if($difference < 4){

      // Add 7 days to the date
    $dateObj->add(new DateInterval('P7D')); // P7D means a period of 7 days
    // Print new date
    $new_date = $dateObj->format('m/d/Y');

    $dateString = $new_date; // Replace this with your date
$dateObj2 = new DateTime($dateString);

// Clone the date object to avoid modifying the original date
$nextWeek = clone $dateObj2;
$nextWeek->modify('+7 days');

if ($nextWeek->format('m') === $dateObj->format('m')) {
    // echo "Next 7 days are in the same month.";
      $month1 = date('n', strtotime($new_date));
      $date = date('d', strtotime($new_date));
      $yearr = date('y', strtotime($new_date));

      if($month1 == "10"){
        $n_month = "O";
      }
      elseif($month1 == "11"){
        $n_month = "N";
      }
      elseif($month1 == "12"){
        $n_month = "D";
      }
      else{
        $n_month = $month1;
      }
      // echo $n_month;
      $auth_code = $this->auth_code();
      $org_cur_value_nifty = $this->get_price(NIFTY);
      $rounded = round($org_cur_value_nifty / 100) * 100;

  // NSE:NIFTY2381019700CE
      $stocktotal_ce = $symbol1.$yearr.$n_month.$date.$rounded."CE";
      $stocktotal_pe = $symbol1.$yearr.$n_month.$date.$rounded."PE";
} else {
    // echo "Next 7 days are in the next month.";
    $month1 = date('n', strtotime($new_date));
    $n_month = strtoupper(date('M', strtotime($new_date)));
    $date = date('d', strtotime($new_date));
    $yearr = date('y', strtotime($new_date));

    // echo $n_month;
    $auth_code = $this->auth_code();
    $org_cur_value_nifty = $this->get_price(NIFTY);
    $rounded = round($org_cur_value_nifty / 100) * 100;

// NSE:NIFTY2381019700CE
    $stocktotal_ce = $symbol1.$yearr.$n_month.$rounded."CE";
    $stocktotal_pe = $symbol1.$yearr.$n_month.$rounded."PE";

}

    // Extract the month

      // Extract the month

    $stock_price_ce = $this->get_price($stocktotal_ce);
    $stock_price_pe = $this->get_price($stocktotal_pe);
    date_default_timezone_set("Asia/Calcutta");
              $cur_date=date("Y-m-d H:i:s");
              $ip = $this->input->ip_address();

    $data_insert = array('option_value'=>$stocktotal_ce,
                        'day'=>$date,
                        'month'=>$month1,
                        'year'=>$yearr,
                        'strike_price'=>$rounded,
                        'amount'=>$stock_price_ce,
                        'expiry_date'=>$new_date,
                        'ip' =>$ip,
                        'date'=>$cur_date
                        );

              $last_id=$this->base_model->insert_table("tbl_option_expiry",$data_insert,1) ;


    $data_update = array(
      'nifty'=>$org_cur_value_nifty,
      'stockce'=>$stocktotal_ce,
      'stockpe'=>$stocktotal_pe,
      'price_ce'=>$stock_price_ce,
      'price_pe'=>$stock_price_pe,
      'expiry'=>$new_date,
                          );
                          $this->db->where('id', 1);
$zapak=$this->db->update('tbl_options', $data_update);

log_message('error', "OPTION SET - OPTION - ".$stocktotal_ce." PRICE - ".$stock_price_ce);

exit;
    }
    else{
      $this->auth_code();
     $org_cur_value_nifty = $this->get_price(NIFTY);
      $rounded = round($org_cur_value_nifty / 100) * 100;

      $dateObj = DateTime::createFromFormat('!m/d/Y', $d4);
        date_default_timezone_set("Asia/Calcutta");
            $new_date = $dateObj->format('m/d/Y');

            $dateString = $new_date; // Replace this with your date
        $dateObj2 = new DateTime($dateString);

        // Clone the date object to avoid modifying the original date
        $nextWeek = clone $dateObj2;
        $nextWeek->modify('+7 days');

        if ($nextWeek->format('m') === $dateObj->format('m')) {
          // echo "Next 7 days are in the same month.";
              $month1 = date('n', strtotime($new_date));
              $date = date('d', strtotime($new_date));
              $yearr = date('y', strtotime($new_date));

              if($month1 == "10"){
                $n_month = "O";
              }
              elseif($month1 == "11"){
                $n_month = "N";
              }
              elseif($month1 == "12"){
                $n_month = "D";
              }
              else{
                $n_month = $month1;
              }
              // echo $n_month;
              $auth_code = $this->auth_code();
              $org_cur_value_nifty = $this->get_price(NIFTY);
              $rounded = round($org_cur_value_nifty / 100) * 100;

          // NSE:NIFTY2381019700CE
              $stocktotal_ce = $symbol1.$yearr.$n_month.$date.$rounded."CE";
              $stocktotal_pe = $symbol1.$yearr.$n_month.$date.$rounded."PE";

        }
        else{
          // echo "Next 7 days are in the next month.";
          $month1 = date('n', strtotime($new_date));
          $n_month = strtoupper(date('M', strtotime($new_date)));
          $date = date('d', strtotime($new_date));
          $yearr = date('y', strtotime($new_date));

          // echo $n_month;
          $auth_code = $this->auth_code();
          $org_cur_value_nifty = $this->get_price(NIFTY);
          $rounded = round($org_cur_value_nifty / 100) * 100;

      // NSE:NIFTY2381019700CE
          $stocktotal_ce = $symbol1.$yearr.$n_month.$rounded."CE";
          $stocktotal_pe = $symbol1.$yearr.$n_month.$rounded."PE";
        }

      $stock_price_ce = $this->get_price($stocktotal_ce);
      $stock_price_pe = $this->get_price($stocktotal_pe);

      date_default_timezone_set("Asia/Calcutta");
                $cur_date=date("Y-m-d H:i:s");
                $ip = $this->input->ip_address();
      $data_insert = array('option_value'=>$stocktotal_ce,
                          'day'=>$date,
                          'month'=>$month1,
                          'year'=>$yearr,
                          'strike_price'=>$rounded,
                          'amount'=>$stock_price_ce,
                          'expiry_date'=>$new_date,
                          'ip' =>$ip,
                          'date'=>$cur_date
                          );

                $last_id=$this->base_model->insert_table("tbl_option_expiry",$data_insert,1) ;


      $data_update = array(
        'nifty'=>$org_cur_value_nifty,
        'stockce'=>$stocktotal_ce,
        'stockpe'=>$stocktotal_pe,
        'price_ce'=>$stock_price_ce,
        'price_pe'=>$stock_price_pe,
        'expiry'=>$new_date,
                            );
                            $this->db->where('id', 1);
    $zapak=$this->db->update('tbl_options', $data_update);
    log_message('error', "OPTION SET - OPTION - ".$stocktotal_ce." PRICE - ".$stock_price_ce);


    }




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

  return $r4;

  }
}

curl_close($curl);

}



}
