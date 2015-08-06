<?php 
class Assign extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$Admin_Info_Id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == FALSE)
			{
			 redirect('login');
			}
		$this->load->model('AssignModel');
		$this->load->model('StatusModel');
	}

	function index()
	{
		redirect('home');
	}
	
	function transaction()
	{
		//$data['CategorySelectBox']=$this->CategoryModel->getCategorySelectBox('required','');
		$data['StatusListFrom']=$this->StatusModel->getStatusFrom('required','');//('required','currentStatus')
		$data['StatusListTo']=$this->StatusModel->getStatusTo('required','');
		
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("transaction",$data);
	}
	
	
	function submit()
	{
		 if($this->input->post('submit'))
		 {
			 if($this->input->post('from_hidden'))
			 $from_hidden=$this->input->post('from_hidden');
			 else $from_hidden='';
			 
			 
			 if($this->input->post('F_Status_Info_Id_Fron'))
			 $F_Status_Info_Id_Fron=$this->input->post('F_Status_Info_Id_Fron');
			 else $F_Status_Info_Id_Fron='';
			 
			 
			 if($this->input->post('F_Status_Info_Id_To'))
			 $F_Status_Info_Id_To=$this->input->post('F_Status_Info_Id_To');
			 else $F_Status_Info_Id_To='';
			 
			 
			 if($this->input->post('F_Product_Info_Id'))
			 $F_Product_Info_Id=$this->input->post('F_Product_Info_Id');
			 else $F_Product_Info_Id='';
			 
			 
			 if($this->input->post('F_User_Info_Id'))
			 $F_User_Info_Id=$this->input->post('F_User_Info_Id');
			 else $F_User_Info_Id='';
			 
			 
			 if($this->input->post('Transaction_Date'))
			 $Transaction_Date=date("Y-m-d H:i:s", strtotime($this->input->post('Transaction_Date')));
			 else $Transaction_Date='';
			 
			 if($this->input->post('Return_Date'))
			 $Return_Date=date("Y-m-d H:i:s", strtotime($this->input->post('Return_Date')));
			 else $Return_Date='';
			 
			 
			 if($this->input->post('Transaction_Description'))
			 $Transaction_Description=$this->input->post('Transaction_Description');
			 else $Transaction_Description='';
			 
			 
			 if($this->input->post('Transaction_Id'))
			 $Transaction_Id=$this->input->post('Transaction_Id');
			 else $Transaction_Id='';
		 
		 
			 $insertArray=array(
				'F_Status_Info_Id_Fron' => $F_Status_Info_Id_Fron,
				'F_Status_Info_Id_To' => $F_Status_Info_Id_To,
				'F_Product_Info_Id' => $F_Product_Info_Id,
				'F_User_Info_Id' => $F_User_Info_Id,
				'Transaction_Date' => $Transaction_Date,
				'Return_Date' => $Return_Date,
				'Transaction_Description' => $Transaction_Description,				
				'F_Admin_Info_Id' => $this->session->userdata('Admin_Info_Id')
			 );

			 $inserted = FALSE;
			 $available=$this->AssignModel->checkAvailable($F_Status_Info_Id_Fron,$F_Product_Info_Id);
			 
			 if($F_Status_Info_Id_Fron!='' && $F_Status_Info_Id_To!='' && $F_Product_Info_Id!='' && $F_User_Info_Id!='' && $available==TRUE)
			 {
				 $productArray=array('Is_Last' => '0');
				 $this->db->where('F_Product_Info_Id', $F_Product_Info_Id);
				 $this->db->update('IDCR_TBL_TRANSACTION', $productArray);
				 
				 $inserted=$this->AssignModel->saveAssign($Transaction_Id,$insertArray); //saveAssign() is used for  Insert and Update IDCR_TBL_PRODUCT_INFO.
				 
				 $productArray=array('F_Status_Info_Id' => $F_Status_Info_Id_To);
				 $this->db->where('Product_Info_Id', $F_Product_Info_Id);
				 $this->db->update('IDCR_TBL_PRODUCT_INFO', $productArray);
			 }
			 
			 if ($inserted == TRUE)
				{
				   $msgdata = array(
					   'msg'  => '<div class="alert alert-success" role="alert"><strong>Success.</strong> Assign <strong>'.$this->input->post('Product_Info').'</strong> succesfully Saved.</div>'
					 );
					 $this->session->set_userdata($msgdata);
				}
			else
				{
				   $msgdata = array(
					   'msg'  => '<div class="alert alert-danger" role="alert"><strong>Error.</strong> Failed to Transfer !</div>'
					 );
					 $this->session->set_userdata($msgdata);
				}
				
			redirect('assign/transaction');
	
		 }
		
		
		redirect('home');
		
	}

	

}
?>

