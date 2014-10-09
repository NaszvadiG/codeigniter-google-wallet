<?php
class pay_with_google extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->library('google_wallet');
	}
	
	function index()
	{
		$data = array();
		$pay_arr = array();
		
		$name = "Lorem ipsum dolor sit amet";
		$description = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce ac ex arcu. Cras convallis id ex ac facilisis. Vestibulum sed ornare est, ut pharetra ligula";
		$price = 99;
		
		// PAYMENT PARAMETERS
		$pay_arr['name'] = $name;
		$pay_arr['description'] = $description;
		$pay_arr['price'] = $price;
		$pay_button = $this->google_wallet->payNow($pay_arr);
		
		// VIEW PARAMETERS
		$data['name'] = $name;
		$data['description'] = $description;
		$data['price'] = $price;
		$data['pay_button'] = $pay_button;
		
		$this->load->view('pay_with_google',$data);
	}
}