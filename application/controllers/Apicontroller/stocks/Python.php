<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Python extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}


public function new_alert(){

            $this->db->select('*');
                        $this->db->from('tbl_stock_list');
                        $this->db->where('alert_created',0);
                        $dsa= $this->db->get();
                        $da=$dsa->row();
												    if(!empty($da)){
										$i=1; foreach($dsa->result() as $data) {

                          $arr[] = $data->name;
                          $data_update = array(
                        'alert_created'=>1,
                        );
                        $this->db->where('id', $da->id);
                        $zapak=$this->db->update('tbl_stock_list', $data_update);
												}
												echo json_encode($arr);

                        }
                      else{
                        echo json_encode("No data");
                      }


               }



}
