<?php 
class Zilla extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$Admin_Info_Id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == FALSE)
			{
			 redirect('login');
			}
		$this->load->model('ZillaModel');		
	}

	function index()
	{
		$data['ZillaList']=$this->ZillaModel->getZillaSelectBox('required','','');//($required='',$currentZilla='',$F_Division_Info_Id='')
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("zilla",$data);
	}
	
	
	function get_zilla_name($F_Division_Info_Id)
	{
		//$F_Division_Info_Id=$this->input->post('F_Division_Info_Id');
		echo $this->ZillaModel->getZillaSelectBox('required','',$F_Division_Info_Id);//($required='',$currentZilla='',$F_Division_Info_Id='')
	}
	

	
	
	

}
?>

