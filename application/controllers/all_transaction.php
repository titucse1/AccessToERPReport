<?php 
class All_transaction extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$Admin_Info_Id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == FALSE)
			{
			 redirect('login');
			}
		$this->load->model('All_transactionModel');
		$this->load->model('CategoryModel');
		$this->load->model('PackageModel');
		$this->load->model('StatusModel');
		
	}

	function index()
	{
		$data['CategorySelectBox']=$this->CategoryModel->getCategorySelectBox('required','');
		$data['PackageSelectBox']=$this->PackageModel->getPackageSelectBox('required','');
		
		$data['All_transactionList']=$this->All_transactionModel->getAll_transactionList();
		
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("all_transaction",$data);
	}
	
	function selectAll_transaction($Status_Info_Id='')
	{	
		$All_transactionList=$this->All_transactionModel->getAll_transactionList($Status_Info_Id,'0');
		
		
		
		$html= '
		
	  <div class="table-responsive">
       <div class="buttonDiv" style="text-align: center;">
            <button class="btn btn-success" onClick="selectSingleAll_transaction()" type="button"><span class="icon-ok"></span>&nbsp;Select All_transaction</button>
       </div>
                <table id="dataTableAll_transaction" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th id="checkAll"><span>#</span></th>
                            <th>ID</th>
                            <th>Cateory Name</th>
                            <th>IMEI 1</th>
                            <th>IMEI 2</th>
							<th>Package</th>
                            <th>Status</th>
                        </tr>
                    </thead>
					
                    <tbody>';
					
						foreach($All_transactionList as $prod)
						{
							//$status=$prod->Is_Void == 0 ? '<span style="color:#51a351;">Active</span>' :  '<span style="color:#FF0000;">Inactive</span>' ;
							if(empty($prod->All_transaction_Package_Name))
							$prod->All_transaction_Package_Name='No';
						$html.= 
						'
							<tr>
								<td><input type="checkbox" class="checkboxId" value="'.$prod->All_transaction_Info_Id.'$$$'.$prod->All_transaction_Info_IMEI_1.'" name="checkboxAll_transaction[]"/></td>
								<td>'.$prod->All_transaction_Info_Id.'</td>
								<td>'.$prod->Category_Info_Name.'</td>
								<td>'.$prod->All_transaction_Info_IMEI_1.'</td>
								<td>'.$prod->All_transaction_Info_IMEI_2.'</td>
								<td>'.$prod->All_transaction_Package_Name.'</td>
								<td>'.$prod->Status_Info_Name.'</td>
							</tr>
						';
						}
						
                  $html.= 
						'      
                    </tbody>
                </table>
            </div><br/>
		';
		
		
		echo $html;
	}
	
	
	function submit()
	{
		 

		 if($this->input->post('submit'))
		 {
			 $F_Category_Info_Id=$this->input->post('F_Category_Info_Id');
			 if(empty($F_Category_Info_Id))$F_Category_Info_Id='';
			 
			 $All_transaction_Info_IMEI_1=$this->input->post('All_transaction_Info_IMEI_1');
			 if(empty($All_transaction_Info_IMEI_1))$All_transaction_Info_IMEI_1='';
			 
			 $All_transaction_Info_IMEI_2=$this->input->post('All_transaction_Info_IMEI_2');
			 
			 if($this->input->post('All_transaction_Info_Purchase'))
			 $All_transaction_Info_Purchase=date("Y-m-d H:i:s", strtotime($this->input->post('All_transaction_Info_Purchase')));
			 else $All_transaction_Info_Purchase='';
			 
			 if($this->input->post('All_transaction_Info_Expire'))
			 $All_transaction_Info_Expire=date("Y-m-d H:i:s", strtotime($this->input->post('All_transaction_Info_Expire')));
			 else $All_transaction_Info_Expire='';
			 
			 if($this->input->post('All_transaction_Info_TeamViewer'))
			 $All_transaction_Info_TeamViewer=$this->input->post('All_transaction_Info_TeamViewer');
			 else $All_transaction_Info_TeamViewer='';
			 
			 if($this->input->post('F_All_transaction_Package_Id'))
			 $F_All_transaction_Package_Id=$this->input->post('F_All_transaction_Package_Id');
			 else $F_All_transaction_Package_Id='';
			 
			 
			 
			 
			 if(empty($All_transaction_Info_IMEI_2))$All_transaction_Info_IMEI_2='';
			 $All_transaction_Info_Description=$this->input->post('All_transaction_Info_Description');
			 if(empty($All_transaction_Info_Description))$All_transaction_Info_Description='';
			 
			 $All_transaction_Info_Id=$this->input->post('All_transaction_Info_Id');
			 if(empty($All_transaction_Info_Id))$All_transaction_Info_Id='';
		 
			 $insertArray=array(
				'F_Category_Info_Id' => $F_Category_Info_Id,
				'F_All_transaction_Package_Id' => $F_All_transaction_Package_Id,
				'All_transaction_Info_IMEI_1' => $All_transaction_Info_IMEI_1,
				'All_transaction_Info_IMEI_2' => $All_transaction_Info_IMEI_2,
				'All_transaction_Info_TeamViewer' => $All_transaction_Info_TeamViewer,
				'All_transaction_Info_Description' => $All_transaction_Info_Description,
				'F_Admin_Info_Id' => $this->session->userdata('Admin_Info_Id')
			 );
			
			 $inserted = FALSE;
			 $uniqueAll_transaction=$this->All_transactionModel->uniqueAll_transaction($F_Category_Info_Id,$All_transaction_Info_IMEI_1,$All_transaction_Info_Id);
			 
			 if($All_transaction_Info_IMEI_1!='' && $All_transaction_Info_IMEI_2!='' && $uniqueAll_transaction==TRUE)
			 $inserted=$this->All_transactionModel->saveAll_transaction($All_transaction_Info_Id,$insertArray); //saveAll_transaction() is used for  Insert and Update IDCR_TBL_PRODUCT_INFO.
			 
			 if ($inserted == TRUE)
				{
				   $msgdata = array(
					   'msg'  => '<div class="alert alert-success" role="alert"><strong>Success.</strong> All_transaction <strong>'.$All_transaction_Info_IMEI_1.'</strong> succesfully Saved.</div>'
					 );
					 $this->session->set_userdata($msgdata);
				}
			elseif ($inserted == FALSE && $uniqueAll_transaction==FALSE)
				{
				   $msgdata = array(
					   'msg'  => '<div class="alert alert-danger" role="alert"><strong>Error.</strong> This All_transaction <strong>'.$All_transaction_Info_IMEI_1.'</strong> is alrady Axist!</div>'
					 );
					 $this->session->set_userdata($msgdata);
				}
			else
				{
				   $msgdata = array(
					   'msg'  => '<div class="alert alert-danger" role="alert"><strong>Error.</strong> Failed to Save All_transaction.</div>'
					 );
					 $this->session->set_userdata($msgdata);
				}
	
		 }

		$data['CategorySelectBox']=$this->CategoryModel->getCategorySelectBox('required','');
		$data['PackageSelectBox']=$this->PackageModel->getPackageSelectBox('required','');
		$data['All_transactionList']=$this->All_transactionModel->getAll_transactionList();
		
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("all_transaction",$data);
	}
	
	function edit_all_transaction($All_transaction_Info_Id='')
	{
		
		
		$All_transaction=$this->All_transactionModel->getAll_transactionSingle($All_transaction_Info_Id);
		$CategorySelectBox=$this->CategoryModel->getCategorySelectBox('required',$All_transaction[0]->Category_Info_Id);
		$PackageSelectBox=$this->PackageModel->getPackageSelectBox('required',$All_transaction[0]->F_All_transaction_Package_Id);
		if($All_transaction[0]->All_transaction_Info_Expire!='0000-00-00')
		$All_transaction_Info_Expire=date("d-m-Y",strtotime($All_transaction[0]->All_transaction_Info_Expire));
		else
		$All_transaction_Info_Expire='';
		echo '
		
		<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="closeButton close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><span class="icon-edit"></span>Edit All_transaction</h4>
			  </div>
			  
			  
						<div class="modal-body">
							<form id="validation2" class="bs-example bs-example-form" method="post" enctype="multipart/form-data" action="'.base_url().'all_transaction/submit/">
							
							
							<div class="input-group">
							  <span class="input-group-addon">All_transaction Id</span>
							  <input type="text" readonly="readonly" name="All_transaction_Info_Id" value="'.$All_transaction[0]->All_transaction_Info_Id.'" maxlength="30" class="form-control required" placeholder="All_transaction Id"/>
							</div>
							
							<div class="input-group">
							  <span class="input-group-addon">Category</span>
							  '.$CategorySelectBox.'
							</div>
							
							<div class="input-group">
							  <span class="input-group-addon">IMEI&nbsp;1</span>
							  <input type="text" name="All_transaction_Info_IMEI_1" value="'.$All_transaction[0]->All_transaction_Info_IMEI_1.'" maxlength="30" class="form-control required" placeholder="IMEI 1"/>
							</div>
							
							
							
							<div class="input-group">
							  <span class="input-group-addon">IMEI&nbsp;2</span>
							  <input type="text" name="All_transaction_Info_IMEI_2" value="'.$All_transaction[0]->All_transaction_Info_IMEI_2.'" maxlength="30" class="form-control required" placeholder="IMEI 2"/>
							</div>
							
							
							 <div class="input-group">
							  <span class="input-group-addon">Purchase Date</span>
							  <input type="text" value="'.date("d-m-Y",strtotime($All_transaction[0]->All_transaction_Info_Purchase)).'" name="All_transaction_Info_Purchase" id="All_transaction_Info_Purchase_edit" maxlength="30" class="form-control required" placeholder="Purchase Date"/>[DD-MM-YYYY]
							</div>
							
							
							<div class="input-group">
							  <span class="input-group-addon">Expire Date</span>
							  <input type="text" value="'.$All_transaction_Info_Expire.'" name="All_transaction_Info_Expire" id="All_transaction_Info_Expire_edit" maxlength="30" class="form-control " placeholder="Expire Date"/>[DD-MM-YYYY]
							</div>
							
							
							
							<div class="input-group">
							  <span class="input-group-addon">Team Viewer ID</span>
							  <input type="text" name="All_transaction_Info_TeamViewer" value="'.$All_transaction[0]->All_transaction_Info_TeamViewer.'" id="All_transaction_Info_TeamViewer_edit" maxlength="11" class="form-control " placeholder="Team Viewer ID"/>
							</div>
							
							
							<div class="input-group">
							  <span class="input-group-addon">Package Name</span>
							  '.$PackageSelectBox.'
							</div>
							
							
							<div class="input-group">
							  <span class="input-group-addon">All_transaction Description</span>
							  <textarea class="form-control" cols="50" rows="3" name="All_transaction_Info_Description">'.$All_transaction[0]->All_transaction_Info_Description.'</textarea>
							</div>
						
							<div class="input-group">
							  <span class="input-group-addon">Current Status</span>
							  <input type="text" readonly="readonly" name="" value="'.$All_transaction[0]->Status_Info_Name.'" maxlength="30" class="form-control required" placeholder="All_transaction Id"/>
							</div>
							
							
							<div class="modal-footer">
								<button type="button" class="closeButton btn btn-default" data-dismiss="modal">Close</button>
								<input type="submit" name="submit" value="Update All_transaction" class="btn btn-primary"/>
							</div>
							</form>
						</div>
						
						
			  
			</div>
	  </div>
	  
	  ';
	}
	
	
	
	

}
?>

