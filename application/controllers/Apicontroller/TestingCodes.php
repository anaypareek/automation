<?php if (! defined('BASEPATH')) { exit('No direct script access allowed'); }
require_once(APPPATH . 'core/CI_finecontrol.php');
class TestingCodes extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }


    public function position_checker(){

      $res = '{"s": "ok", "code": 200, "message": "", "netPositions": [{"netQty": 100, "qty": 100, "avgPrice": 105.175, "netAvg": 105.18, "side": 1, "productType": "INTRADAY", "realized_profit": 0.0, "unrealized_profit": -113.0, "pl": -113.0, "ltp": 104.05, "buyQty": 100, "buyAvg": 105.175, "buyVal": 10517.5, "sellQty": 0, "sellAvg": 0.0, "sellVal": 0.0, "slNo": 0, "fyToken": "101122111048283", "dummy": "          ", "crossCurrency": "N", "rbiRefRate": 1.0, "qtyMulti_com": 1.0, "segment": 11, "symbol": "NSE:NIFTY22N1018000PE", "id": "NSE:NIFTY22N1018000PE-INTRADAY", "qtyMultiplier": 1.0}], "overall": {"count_total": 1, "count_open": 1, "pl_total": -113.0, "pl_realized": 0.0, "pl_unrealized": -113.0}}';

      $res2 = json_decode($res);
      // print_r($res2);

      $status = $res2->s;
      if($status == "ok"){
        $overall = $res2->overall;
        $open_position = $overall->count_open;
        echo $open_position;
      }



                   }



public function round_checker(){

$value = 26.37;
$target_amt = round($value * 2, 1) / 2;
echo $target_amt;




}


}
