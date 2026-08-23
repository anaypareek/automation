<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Home extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}

		function index(){


			if(!empty($this->session->userdata('admin_data'))){


				$data['user_name']=$this->load->get_var('user_name');

				// echo SITE_NAME;

				$this->db->select('*');
				$this->db->from('tbl_admin_sidebar');
				// $this->db->where('student_shift',$cvf);
				$data['sidebar_data']= $this->db->get();

// 				      			$this->db->select('*');
// 				$this->db->from('tbl_case5');
// 				$this->db->where('trade_status',2);
// 				$data['total_trades']= $this->db->count_all_results();
//
// 				$this->db->select('*');
// $this->db->from('tbl_case5');
// $this->db->where('trade_status',2);
// $this->db->where('plstatus',1);
// $data['profit_trades']= $this->db->count_all_results();
//
// $this->db->select('*');
// $this->db->from('tbl_case5');
// $this->db->where('trade_status',2);
// $this->db->where('plstatus',2);
// $data['loss_trades']= $this->db->count_all_results();
//
//
// $this->db->select_sum('plamount');
// $this->db->where('trade_status',2);
// $this->db->where('plstatus',1);
// $data['profit_amount']= $this->db->get('tbl_case5')->result();
//
//
// $this->db->select_sum('plamount');
// $this->db->where('trade_status',2);
// $this->db->where('plstatus',2);
// $data['loss_amount']= $this->db->get('tbl_case5')->result();


$this->db->select('*');
				$this->db->from('tbl_stock_list');
				// $this->db->where('trade_status',2);
				$data['total_stocks']= $this->db->count_all_results();

								$this->db->select('*');
								$this->db->from('tbl_stock_call');
								$this->db->where('call_timeframe',1);
								$data['calls_5min']= $this->db->count_all_results();

								$this->db->select('*');
								$this->db->from('tbl_stock_call');
								$this->db->where('call_timeframe',2);
								$data['calls_15min']= $this->db->count_all_results();

								$this->db->select('*');
								$this->db->from('tbl_stock_call');
								$this->db->where('call_timeframe',3);
								$data['calls_1hr']= $this->db->count_all_results();

								$this->db->select('*');
								$this->db->from('tbl_stock_call');
								$this->db->where('call_timeframe',4);
								$data['calls_1day']= $this->db->count_all_results();

			$this->load->view('admin/common/header_view',$data);
				$this->load->view('admin/dash');
				$this->load->view('admin/common/footer_view');

		}
		else{

				$this->load->view('admin/login/index');
		}

		}



}
