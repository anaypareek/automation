<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Orders extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}

public function view_orders(){

                 if(!empty($this->session->userdata('admin_data'))){

                   $this->db->select('*');
                   $this->db->from('tbl_orders');
									 $this->db->order_by('id','DESC');
                   $data['orders']= $this->db->get();

									 $this->db->select('*');
			 					 	 $this->db->from('tbl_orders2');
									 $this->db->order_by('id','DESC');
									 $data['orders2']= $this->db->get();

									 $this->db->select('*');
									 $this->db->from('tbl_orders3');
									 $this->db->order_by('id','DESC');
									 $data['orders3']= $this->db->get();

									 $this->db->select_avg('highest_percentage');
									$query = $this->db->get('tbl_orders');
									$result = $query->row();
									$data['high1'] = $result->highest_percentage ?? 0; // This will print the average value

									$this->db->select_avg('highest_percentage');
								 $query = $this->db->get('tbl_orders2');
								 $result = $query->row();
								 $data['high2'] = $result->highest_percentage ?? 0; // This will print the average value

								 $this->db->select_avg('highest_percentage');
								$query = $this->db->get('tbl_orders3');
								$result = $query->row();
								$data['high3'] = $result->highest_percentage ?? 0; // This will print the average value

								$this->db->select_sum('profit_loss_amt');
							 $query = $this->db->get('tbl_orders');
							 $result = $query->row();
							 $data['profitloss_all1'] = $result->profit_loss_amt ?? 0; // This will print the average value

							 $this->db->select_sum('profit_loss_amt');
							$query = $this->db->get('tbl_orders2');
							$result = $query->row();
							$data['profitloss_all2'] = $result->profit_loss_amt ?? 0; // This will print the average value

								$this->db->select_sum('profit_loss_amt');
							 $query = $this->db->get('tbl_orders3');
							 $result = $query->row();
							 $data['profitloss_all3'] = $result->profit_loss_amt ?? 0; // This will print the average value

							 $this->db->select_sum('profit_loss_amt');
							 $this->db->where('DATE(sell_time)', date('Y-m-d')); // Filter records for today
							 $query = $this->db->get('tbl_orders');
							 $result = $query->row();
							 $data['today_profitloss_all1'] = $result->profit_loss_amt ?? 0; // This will print the average value

							 $this->db->select_sum('profit_loss_amt');
							 $this->db->where('DATE(buy_time)', date('Y-m-d')); // Filter records for today
							 $query = $this->db->get('tbl_orders2');
							 $result = $query->row();
							 $data['today_profitloss_all2'] = $result->profit_loss_amt ?? 0; // This will print the average value

							 $this->db->select_sum('profit_loss_amt');
							 $this->db->where('DATE(sell_time)', date('Y-m-d')); // Filter records for today
							 $query = $this->db->get('tbl_orders3');
							 $result = $query->row();
							 $data['today_profitloss_all3'] = $result->profit_loss_amt ?? 0; // This will print the average value

							 $this->db->select_avg('highest_percentage');
							 $this->db->where('DATE(sell_time)', date('Y-m-d')); // Filter records for today
							 $query = $this->db->get('tbl_orders');
							 $result = $query->row();
							 $data['today_high1'] = $result->highest_percentage ?? 0; // This will print the average value

							 $this->db->select_avg('highest_percentage');
							 $this->db->where('DATE(buy_time)', date('Y-m-d')); // Filter records for today
							 $query = $this->db->get('tbl_orders2');
							 $result = $query->row();
							 $data['today_high2'] = $result->highest_percentage ?? 0; // This will print the average value

							 $this->db->select_avg('highest_percentage');
							 $this->db->where('DATE(sell_time)', date('Y-m-d')); // Filter records for today
							 $query = $this->db->get('tbl_orders3');
							 $result = $query->row();
							 $data['today_high3'] = $result->highest_percentage ?? 0; // This will print the average value


                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/orders/view_orders');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }





}
