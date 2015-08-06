<?php 
class Home extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$Admin_Info_Id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == FALSE)
			{
			 redirect('login');
			}
			
		$data['title']="ERP Report System";
	}

	function index()
	{

		
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("home",$data);
	}
	
	
	function inxcvxgdfgfdgdex()
	{
		$this->load->view("home",$data);
	}

}
?>