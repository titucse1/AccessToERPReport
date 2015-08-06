<?php 
class Last_transaction extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$Admin_Info_Id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == FALSE)
			{
			 redirect('login');
			}
		$this->load->model('Last_transactionModel');
		$this->load->model('CategoryModel');
		$this->load->model('Package_listModel');
		$this->load->model('StatusModel');
		
	}

	function index()
	{
		$data['CategorySelectBox']=$this->CategoryModel->getCategorySelectBox('required','');
		$data['PackageSelectBox']=$this->Package_listModel->getPackage_listSelectBox('required','');
	
		$data['Last_transactionList']=$this->Last_transactionModel->getLast_transactionList();
		
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("last_transaction",$data);
	}
	

	

	function update($url='')
	{
		 if($this->input->post('update'))
		 {

			 if($this->input->post('Transaction_Id'))
			 $Transaction_Id=$this->input->post('Transaction_Id');
			 else $Transaction_Id='';
			 
			 
			 if($this->input->post('Product_Info_IMEI_1'))
			 $Product_Info_IMEI_1=$this->input->post('Product_Info_IMEI_1');
			 else $Product_Info_IMEI_1='';
			 
			 
			
		 	 if($this->input->post('Transaction_Description_old'))
			 $Transaction_Description_old=$this->input->post('Transaction_Description_old');
			 else $Transaction_Description_old='';
			 
			 if($this->input->post('Transaction_Description_new'))
			 $Transaction_Description_new=$this->input->post('Transaction_Description_new');
			 else $Transaction_Description_new='';
		 
		 
		     $Transaction_Description=  $Transaction_Description_old .'. '. $Transaction_Description_new;
		 
			 $insertArray=array(
				'Transaction_Description' => $Transaction_Description,
				'F_Admin_Info_Id' => $this->session->userdata('Admin_Info_Id')
			 );
			
			 $inserted = FALSE;

			 $inserted=$this->Last_transactionModel->saveLast_transaction($Transaction_Id,$insertArray); //saveLast_transaction() is used for  Insert and Update
			 
			 if ($inserted == TRUE)
				{
					$msgdata = array(
					   'msg'  => '<div class="alert alert-success" role="alert"><strong>Success.</strong> Transaction for <strong>'.$Product_Info_IMEI_1.'</strong> is Succesfully Saved.</div>'
					 );
					 $this->session->set_userdata($msgdata);
				}

			else
				{
				   $msgdata = array(
					   'msg'  => '<div class="alert alert-danger" role="alert"><strong>Error.</strong>  Transaction for <strong>'.$Product_Info_IMEI_1.'</strong> is  Failed .</div>'
					 );
					 $this->session->set_userdata($msgdata);
				}
	
		 }
		 
		if($url!='')
		redirect(str_replace('_',"/", $url));
		 
		 
		$data['CategorySelectBox']=$this->CategoryModel->getCategorySelectBox('required','');
		$data['PackageSelectBox']=$this->Package_listModel->getPackage_listSelectBox('required','');
	
		$data['Last_transactionList']=$this->Last_transactionModel->getLast_transactionList();
		
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("last_transaction",$data);
	}
	
	function edit_transaction($Last_transaction_Info_Id='', $url='')
	{

		$Last_transaction =$this->Last_transactionModel->getLast_transactionSingle($Last_transaction_Info_Id);//get single transition.
		//print_r($Last_transaction); exit;
		echo '
		
		<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="closeButton close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><span class="icon-edit"></span>Edit Transaction</h4>
			  </div>
			  
			  
						<div class="modal-body">
							<form id="validation2" class="bs-example bs-example-form" method="post" enctype="multipart/form-data" action="'.base_url().'last_transaction/update/'.$url.'">
								
							<div class="input-group">
							  <span class="input-group-addon">Transaction Id</span>
							  <input type="text" readonly="readonly" name="Transaction_Id" value="'.$Last_transaction[0]['Transaction_Id'].'"  class="form-control" placeholder="Transaction Id"/>
							</div>
											
							
							<div class="input-group">
							  <span class="input-group-addon">Category Name</span>
							  <input type="text" readonly="readonly" name="Category_Info_Name" value="'.$Last_transaction[0]['Category_Info_Name'].'"  class="form-control" placeholder="IMEI 1"/>
							</div>
							
							
							<div class="input-group">
							  <span class="input-group-addon">IMEI&nbsp;1</span>
							  <input type="text" readonly="readonly" name="Product_Info_IMEI_1" value="'.$Last_transaction[0]['Product_Info_IMEI_1'].'"  class="form-control" placeholder="IMEI 1"/>
							</div>
							
							
							<div class="input-group">
							  <span class="input-group-addon">IMEI&nbsp;2</span>
							  <input type="text" readonly="readonly" name="Product_Info_IMEI_2" value="'.$Last_transaction[0]['Product_Info_IMEI_2'].'"  class="form-control" placeholder="IMEI 2"/>
							</div>
							
							
							<div class="input-group">
							  <span class="input-group-addon">Status Fron</span>
							  <input type="text" readonly="readonly" name="F_Status_Info_Id_Fron" value="'.$Last_transaction[0]['F_Status_Info_Id_Fron'].'" class="form-control" placeholder="F_Status_Info_Id_Fron"/>
							</div>
							
									
							<div class="input-group">
							  <span class="input-group-addon">Status To</span>
							  <input type="text" readonly="readonly" name="F_Status_Info_Id_To" value="'.$Last_transaction[0]['F_Status_Info_Id_To'].'" class="form-control" placeholder="F_Status_Info_Id_To"/>
							</div>
							
					
							
							
							<div class="input-group">
							  <span class="input-group-addon">User Name</span>
							  <input type="text" readonly="readonly" name="User_Info_Full_Name" value="'.$Last_transaction[0]['User_Info_Full_Name'].'" class="form-control" placeholder="User_Info_Full_Name"/>
							</div>
							
							
							<div class="input-group">
							  <span class="input-group-addon">HR Id</span>
							  <input type="text" readonly="readonly" name="HR_Employee_Id" value="'.$Last_transaction[0]['HR_Employee_Id'].'" class="form-control" placeholder="HR_Employee_Id"/>
							</div>
							
							
							
								
							<div class="input-group">
							  <span class="input-group-addon">Contact No</span>
							  <input type="text" readonly="readonly" name="Contact_No" value="'.$Last_transaction[0]['Contact_No'].'" class="form-control" placeholder="Contact_No"/>
							</div>
							
							
							<div class="input-group">
							  <span class="input-group-addon">Designation</span>
							  <input type="text" readonly="readonly" name="Short_Form_Of_Designation_Name" value="'.$Last_transaction[0]['Short_Form_Of_Designation_Name'].'" class="form-control" placeholder="Short_Form_Of_Designation_Name"/>
							</div>
							
							
							
							
							<div class="input-group">
							  <span class="input-group-addon">Transfer Date</span>
							  <input type="text" readonly="readonly" name="Transaction_Date" value="'.$Last_transaction[0]['Transaction_Date'].'" class="form-control" placeholder="Transaction_Date"/>
							</div>
							
							
							
							<div class="input-group">
							  <span class="input-group-addon">Description</span>
							  <textarea readonly="readonly" class="form-control" name="Transaction_Description_old">'.$Last_transaction[0]['Transaction_Description'].'</textarea>
							  
							</div>
							
							
			
							
							<div class="input-group">
							  <span class="input-group-addon">Add Description</span>

							  <textarea class="form-control" name="Transaction_Description_new"></textarea>
							</div>
							
							
							
							
							
							<div class="modal-footer">
								<button type="button" class="closeButton btn btn-default" data-dismiss="modal">Close</button>
								<input type="submit" name="update" value="Update Transaction" class="btn btn-primary"/>
							</div>
							</form>
						</div>
						
						
			  
			</div>
	  </div>
	  
	  ';
	}
	
	
	
	

}
?>

