<?php if (! defined('BASEPATH')) { exit('No direct script access allowed'); }
require_once(APPPATH . 'core/CI_finecontrol.php');
class StockTrading extends CI_finecontrol
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model("login_model");
        $this->load->model("admin/base_model");
        $this->load->library('user_agent');
        $this->load->library('upload');
    }

    public function buy_stock()
    {
       $auth_code = $this->auth_code();


       $stock = $this->get_price(STOCK);

   //ENTER IN CALL TABLE FOR STOCK
if($t == 1){





}
else{
// IF BUY CALL THEN TAKE ENTRY IF SELL CALL THEN EXIT THE ENTRY AND ENTER ALL PRICES IN DB



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



  }
