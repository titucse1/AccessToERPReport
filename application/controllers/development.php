<?php 
class Development extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$Admin_Info_Id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == FALSE)
			{
			 redirect('login');
			}	
	}

	function index()
	{
	
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->load->view("development",$data);
	}

	

}
?>

