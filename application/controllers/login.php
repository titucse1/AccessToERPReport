<?php 
class Login extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$this->load->model('AdminModel');
		
		$Admin_Info_Id =$session_id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == true)
			{
			 redirect('home');
			}
	}
	

	
	function index()
	{
		$data['username']='';
		$data['password']='';
		$this->load->view("login",$data);
	}



	function submit()
	{
		 $username=$this->input->post('username');
		 if(empty($username))$username='';
		 $password=$this->input->post('password');
		 if(empty($password))$password='';
		
		 $this->AdminModel->checklogin($username,$password);
		 
		 $Admin_Info_Id = $this->session->userdata('Admin_Info_Id');
		 if ($Admin_Info_Id == TRUE)
			{
			$msgdata = array(
			   'msg'  => '<div class="alert alert-success" role="alert"><strong>Success.</strong> You are Logged In</div>'
		   	 );
			 $this->session->set_userdata($msgdata);
			 redirect('home');
			}
		
		 $data['username']=$username;
		 $data['password']=$password;

		$this->load->view("login",$data);
	}
	
	




}
?>