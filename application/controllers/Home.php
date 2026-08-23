<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Home extends CI_Controller{
function __construct()
		{
			parent::__construct();
			$this->load->model("admin/login_model");
			$this->load->model("admin/base_model");
		}
public function index()
	{
			$this->load->view('index');

	}


	public function redirect()
	{


	}



	public function option_value_set()
	{

		$nifty = $this->get_price(NIFTY);
		// NSE:NIFTY2292218000CE


	}


	public function error404()
		{
				$this->load->view('errors/error404');

		}


		public function cron_job_set()
			{
				// $cron_command = '*/1 * * * 1-5 /usr/bin/curl --silent --compressed https://www.fineoutput.co.in/automation/Apicontroller/case5/Index/afterorderdb';
				// shell_exec('(crontab -l ; echo "'.$cron_command.'") | crontab -');

				// $cron_command2 = '*/1 * * * 1-5 /usr/bin/curl --silent --compressed https://www.fineoutput.co.in/automation/Apicontroller/tradingViewCall/aftercalldb';
				// shell_exec('(crontab -l ; echo "'.$cron_command2.'") | crontab -');

			}

			public function cron_job_delete()
				{
				// 	$cron_command = '*/1 * * * 1-5 /usr/bin/curl --silent --compressed https://www.fineoutput.co.in/automation/Apicontroller/case5/Index/afterorderdb';
				// 	// Use crontab -l to get the current crontab
				// 	$current_crontab = shell_exec('crontab -l');
				// // Remove the specific cron job from the crontab
				// 	$updated_crontab = preg_replace('#^\s*' . preg_quote($current_crontab, '#') . '\s*$#m', '', $current_crontab);
				//
				// 	// Set the updated crontab
				// 	shell_exec('echo "' . trim($updated_crontab) . '" | crontab -');
				//
				// 	$cron_command1 = '0 9 * * * /usr/bin/curl --silent --compressed https://www.fineoutput.co.in/automation/Home/cron_job_set';
				// 	shell_exec('(crontab -l ; echo "'.$cron_command1.'") | crontab -');
				//
				// 	$cron_command2 = '0 15 * * * /usr/bin/curl --silent --compressed https://www.fineoutput.co.in/automation/Home/cron_job_delete';
				// 	shell_exec('(crontab -l ; echo "'.$cron_command2.'") | crontab -');
				//
				// 	$cron_command3 = '25 9 * * * /usr/bin/curl --silent --compressed https://www.fineoutput.co.in/automation/Apicontroller/OptionFinder/option_price';
				// 	shell_exec('(crontab -l ; echo "'.$cron_command3.'") | crontab -');
				//
				// 	$cron_command4 = '0 8 * * * /usr/bin/curl --silent --compressed https://www.fineoutput.co.in/automation/Apicontroller/case5/Index/daily_order_complete_mark';
				// 	shell_exec('(crontab -l ; echo "'.$cron_command4.'") | crontab -');


				}



}
