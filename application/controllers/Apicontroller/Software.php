<?php if (! defined('BASEPATH')) { exit('No direct script access allowed'); }
require_once(APPPATH . 'core/CI_finecontrol.php');
class Software extends CI_finecontrol
{
public function __construct()
{
parent::__construct();
$this->load->model("login_model");
$this->load->model("admin/base_model");
$this->load->library('user_agent');
$this->load->library('upload');
}

public function case_entry_check(){








               }




}
