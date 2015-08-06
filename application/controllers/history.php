<?php 
class History extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$Admin_Info_Id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == FALSE)
			{
			 redirect('login');
			}
		$this->load->model('HistoryModel');
	}

	
	function product($F_Product_Info_Id='')
	{
		if ($F_Product_Info_Id == FALSE)redirect('Home');
			
		$data['productDetails']=$this->HistoryModel->getProductSingle($F_Product_Info_Id);
		$data['productHistory']=$this->HistoryModel->getHistory_product($F_Product_Info_Id);
				
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("history_product",$data);
	}
	
	
	
	function person($F_User_Info_Id='')
	{
		if ($F_User_Info_Id == FALSE)redirect('Home');
			
		$data['userDetails']=$this->HistoryModel->getUserSingle($F_User_Info_Id);
		$data['userHistory']=$this->HistoryModel->getHistory_User($F_User_Info_Id);
		
		//print_r($data['userHistory']); exit;
				
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("history_person",$data);
	}
	
	

	

	
	

}
?>

