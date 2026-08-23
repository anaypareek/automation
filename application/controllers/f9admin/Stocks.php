<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH . 'core/CI_finecontrol.php');
class Stocks extends CI_finecontrol{
function __construct()
		{
			parent::__construct();
			$this->load->model("login_model");
			$this->load->model("admin/base_model");
			$this->load->library('user_agent');
		}

public function view_stocks(){

                 if(!empty($this->session->userdata('admin_data'))){


                   $data['user_name']=$this->load->get_var('user_name');


                               $this->db->select('*');
                   $this->db->from('tbl_stock_list');
                   //$this->db->where('',);
                   $data['stocks_list']= $this->db->get();

									 $this->db->distinct();
	 $this->db->select('symbol,MAX(date) as date');
			 $this->db->from('tbl_stock_call');
			 $this->db->where('call_timeframe', 1);
			 $this->db->where('call_open_close', 2);
			 $this->db->group_by('symbol');
			 $this->db->order_by('date','DESC');
			 $data['stocks_list_5min']= $this->db->get();

			 $this->db->distinct();
$this->db->select('symbol,MAX(date) as date');
$this->db->from('tbl_stock_call');
$this->db->where('call_timeframe', 2);
$this->db->where('call_open_close', 2);
$this->db->group_by('symbol');
$this->db->order_by('date','DESC');
$data['stocks_list_15min']= $this->db->get();

$this->db->distinct();
$this->db->select('symbol,MAX(date) as date');
$this->db->from('tbl_stock_call');
$this->db->where('call_timeframe', 3);
$this->db->where('call_open_close', 2);
$this->db->group_by('symbol');
$this->db->order_by('date','DESC');
$data['stocks_list_1hr']= $this->db->get();

$this->db->distinct();
$this->db->select('symbol,MAX(date) as date');
$this->db->from('tbl_stock_call');
$this->db->where('call_timeframe', 4);
$this->db->where('call_open_close', 2);
$this->db->group_by('symbol');
$this->db->order_by('date','DESC');
$data['stocks_list_1day']= $this->db->get();

                   $this->load->view('admin/common/header_view',$data);
                   $this->load->view('admin/stocks/view_stocks');
                   $this->load->view('admin/common/footer_view');

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }


public function refresh_price(){

                 if(!empty($this->session->userdata('admin_data'))){


									 $this->db->select('*');
			 $this->db->from('tbl_stock_list');
			 // $this->db->where('product_id',$pid);
			 $d1= $this->db->get();
			 $i=1; foreach($d1->result() as $dd1) {

			 $s1 = $dd1->logo;
			 $price = $this->get_price($s1);
			 if (!is_numeric($price)) {
    // Log the non-numeric price
    log_message('error', 'Invalid price: ' . $price);
}
$data_update = array(
 'current_price'=>$price

 );

 $this->db->where('id', $dd1->id);
	$zapak=$this->db->update('tbl_stock_list', $data_update);
	// Pause the script for 2 seconds
	sleep(1);

			 }

			 redirect("dcadmin/Stocks/view_stocks","refresh");

               }
               else{

                  redirect("login/admin_login","refresh");
               }

               }

               public function add_stocks(){

                                if(!empty($this->session->userdata('admin_data'))){


                                  $data['user_name']=$this->load->get_var('user_name');

                                              $this->db->select('*');
                                  $this->db->from('tbl_stock_list');
                                  //$this->db->where('',);
                                  $data['stocks_list']= $this->db->get();

                                  $this->load->view('admin/common/header_view',$data);
                                  $this->load->view('admin/stocks/add_stocks');
                                  $this->load->view('admin/common/footer_view');

                              }
                              else{

                                 redirect("login/admin_login","refresh");
                              }

                              }


								public function update_stocks($idd){

																 if(!empty($this->session->userdata('admin_data'))){
																	  $id=base64_decode($idd);
																	 $data['id']=$idd;

																	 $data['user_name']=$this->load->get_var('user_name');

																							 $this->db->select('*');
																	 $this->db->from('tbl_stock_list');
																	 $this->db->where('id',$id);
																	 $data['data']= $this->db->get()->row();

																	 $this->load->view('admin/common/header_view',$data);
																	 $this->load->view('admin/stocks/update_stock_list');
																	 $this->load->view('admin/common/footer_view');

															 }
															 else{

																	redirect("login/admin_login","refresh");
															 }

															 }


                                          public function add_stocks_data($t,$iw="")

                                            {

                                              if(!empty($this->session->userdata('admin_data'))){


                                          $this->load->helper(array('form', 'url'));
                                          $this->load->library('form_validation');
                                          $this->load->helper('security');
                                          if($this->input->post())
                                          {
                                            // print_r($this->input->post());
                                            // exit;
                                            $this->form_validation->set_rules('name', 'name', 'required|xss_clean|trim');
                                            $this->form_validation->set_rules('logo', 'logo', 'required|xss_clean|trim');
                                            $this->form_validation->set_rules('current_5', 'current_5', 'required|xss_clean|trim');
                                            $this->form_validation->set_rules('current_15', 'current_15', 'required|xss_clean|trim');
                                            $this->form_validation->set_rules('current_1hr', 'current_1hr', 'required|xss_clean|trim');
                                            $this->form_validation->set_rules('current_1day', 'current_1day', 'required|xss_clean|trim');

                                            if($this->form_validation->run()== TRUE)
                                            {
                                              $name=$this->input->post('name');
                                              $logo=$this->input->post('logo');
                                              $current_5=$this->input->post('current_5');
																							// echo $current_5;
																							// exit;
                                              $current_15=$this->input->post('current_15');
                                              $current_1hr=$this->input->post('current_1hr');
                                              $current_1day=$this->input->post('current_1day');



                                                $ip = $this->input->ip_address();
                                        date_default_timezone_set("Asia/Calcutta");
                                                $cur_date=date("Y-m-d H:i:s");

                                                $addedby=$this->session->userdata('admin_id');
                                                $current_price = $this->get_price($logo);
                                                // echo $current_price;
                                                // exit;
                                        $typ=base64_decode($t);
                                        if($typ==1){

                                        $data_insert = array('name'=>$name,
                                                  'logo'=>$logo,
                                                  'current_price'=>$current_price,
                                                  'current_5'=>$current_5,
                                                  'current_15'=>$current_15,
                                                  'current_1hr'=>$current_1hr,
                                                  'current_1day'=>$current_1day,
                                                  'ip' =>$ip,
                                                  'date'=>$cur_date

                                                  );

                                        $last_id=$this->base_model->insert_table("tbl_stock_list",$data_insert,1) ;

                                        }
                                        if($typ==2){

                                 $idw=base64_decode($iw);

                              // $this->db->select('*');
                              //     $this->db->from('tbl_minor_category');
                              //    $this->db->where('name',$name);
                              //     $damm= $this->db->get();
                              //    foreach($damm->result() as $da) {
                              //      $uid=$da->id;
                              // if($uid==$idw)
                              // {
                              //
                              //  }
                              // else{
                              //    echo "Multiple Entry of Same Name";
                              //       exit;
                              //  }
                              //     }

                                        $data_insert = array('name'=>$name,
                                                  'logo'=>$logo,
                                                  'current_price'=>$current_price,
                                                  'current_5'=>$current_5,
                                                  'current_15'=>$current_15,
                                                  'current_1hr'=>$current_1hr,
                                                  'current_1day'=>$current_1day,

                                                  );

                                          $this->db->where('id', $idw);
                                          $last_id=$this->db->update('tbl_stock_list', $data_insert);

                                        }


                                                            if($last_id!=0){

                                                            $this->session->set_flashdata('smessage','Stock added successfully');

                                                            redirect("dcadmin/Stocks/view_stocks","refresh");

                                                                    }

                                                                    else

                                                                    {

                                                                 $this->session->set_flashdata('emessage','Sorry error occured');
                                                                   redirect($_SERVER['HTTP_REFERER']);


                                                                    }


                                            }
                                          else{

                              $this->session->set_flashdata('emessage',validation_errors());
                                   redirect($_SERVER['HTTP_REFERER']);

                                          }

                                          }
                                        else{

                              $this->session->set_flashdata('emessage','Please insert some data, No data available');
                                   redirect($_SERVER['HTTP_REFERER']);

                                        }
                                        }
                                        else{

                                    redirect("login/admin_login","refresh");


                                        }

                                        }

					public function view_calls($idd){

					                 if(!empty($this->session->userdata('admin_data'))){

														  $id=base64_decode($idd);
														 $data['id']=$idd;

														 $this->db->select('*');
														             $this->db->from('tbl_stock_list');
														             $this->db->where('id',$id);
														             $dsa= $this->db->get();
														             $da=$dsa->row();
														             if(!empty($da)){
														               $data['name'] =  $da->name;
														             }
														           else{
														            $data['name'] = "No name";
														           }


														       			$this->db->select('*');
														 $this->db->from('tbl_stock_call');
														 $this->db->where('symbol',$id);
														 $this->db->where('call_timeframe',1);
														 $this->db->order_by('id','DESC');
														 $data['stock_call_5min']= $this->db->get();

														 $this->db->select('*');
									 $this->db->from('tbl_stock_call');
									 $this->db->where('symbol',$id);
									 $this->db->where('call_timeframe',2);
									 $this->db->order_by('id','DESC');
									 $data['stock_call_15min']= $this->db->get();

									 $this->db->select('*');
				 $this->db->from('tbl_stock_call');
				 $this->db->where('symbol',$id);
				 $this->db->where('call_timeframe',3);
				 $this->db->order_by('id','DESC');
				 $data['stock_call_1hr']= $this->db->get();

				 $this->db->select('*');
$this->db->from('tbl_stock_call');
$this->db->where('symbol',$id);
$this->db->where('call_timeframe',4);
$this->db->order_by('id','DESC');
$data['stock_call_1day']= $this->db->get();

					                   $this->load->view('admin/common/header_view',$data);
					                   $this->load->view('admin/stocks/view_calls');
					                   $this->load->view('admin/common/footer_view');

					               }
					               else{

					                  redirect("login/admin_login","refresh");
					               }

					               }











		//------------- FIXED FUNCTIONS TO GET DATA -------------------------------------------


			public function getPrice($logo){

			$price = $this->get_price($logo);
			if(!empty($price)){
				echo $price;

			}
			else{
				echo "NA";
			}

							               }

      public function get_price($symbol)
      {
      $auth_code = $this->auth_code();
      // SYMBOL -> STOCK OR OPTION NAME NSE:NIFTY50-INDEX
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
			// print_r($response);
			// exit;
      // foreach($response as $rr){

			log_message('error', 'Message' . $response);

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
          $r4 = $r3->lp;
        }
 // log_message('error', 'Price: ' . $response);
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
