<?php 
class Logout extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		
		$this->session->sess_destroy();
		$Admin_Info_Id =$session_id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == true)
		{
		 redirect('home');
		}
		else
		{
		 redirect('login');
		}

	}
	

	function index()
	{
        $Admin_Info_Id =$session_id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == true)
		{
		 redirect('home');
		}
		else
		{
		 redirect('login');
		}

	}




}
?>