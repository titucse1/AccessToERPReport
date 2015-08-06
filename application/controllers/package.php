<?php 
class Package extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$Admin_Info_Id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == FALSE)
			{
			 redirect('login');
			}
		$this->load->model('PackageModel');
		
	}

	function index()
	{
		$data['PackageList']=$this->PackageModel->getPackage();
		
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("package",$data);
	}
	
	function selectPackage($Product_Package_Id='')
	{	
		$PackageList=$this->PackageModel->getPackage($Product_Package_Id);
		
		
		
		$html= '
		
	  <div class="table-responsive">
       <div class="buttonDiv" style="text-align: center;">
            <button class="btn btn-success" onClick="selectSinglePackage()" type="button"><span class="icon-ok"></span>&nbsp;Select Package</button>
       </div>
                <table id="dataTablePackage" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th id="checkAll"><span>#</span></th>
                            <th>ID</th>
                            <th>Package Name</th>
							<th>Renew Date</th>
							<th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
					
                    <tbody>';
					
						foreach($PackageList as $prod)
						{
							$status=$prod->Is_Void == 0 ? '<span style="color:#51a351;">Active</span>' :  '<span style="color:#FF0000;">Inactive</span>' ;
						$html.= 
						'
							<tr>
								<td><input type="checkbox" class="checkboxId" value="'.$prod->Product_Package_Id.'$$$'.$prod->Product_Package_Name.'" name="checkboxPackage[]"/></td>
								<td>'.$prod->Product_Package_Id.'</td>
								<td>'.$prod->Product_Package_Name.'</td>
								<td>'.date("d-m-Y",strtotime($prod->Product_Package_Name)).'</td>
								<td>'.$prod->Product_Package_Amount.'</td>
								<td>'.$status.'</td>
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
			 
			 $Product_Package_Name=$this->input->post('Product_Package_Name');
			 if(empty($Product_Package_Name))$Product_Package_Name='';
			
			 
			 if($this->input->post('Product_Package_Date'))
			 $Product_Package_Date=date("Y-m-d", strtotime($this->input->post('Product_Package_Date')));
			 else $Product_Package_Date='';
			 
			 $Product_Package_Amount=$this->input->post('Product_Package_Amount');
			 if(empty($Product_Package_Amount))$Product_Package_Amount='';
			 
			 $Product_Package_Id=$this->input->post('Product_Package_Id');
			 if(!isset($Product_Package_Id))$Product_Package_Id='';

			 

		 
			 $insertArray=array(
				'Product_Package_Name' => $Product_Package_Name,
				'Product_Package_Date' => $Product_Package_Date,
				'Product_Package_Amount' => $Product_Package_Amount,
				'F_Admin_Info_Id' => $this->session->userdata('Admin_Info_Id')
			 );
			
			 $inserted = FALSE;
			 $uniquePackage=$this->PackageModel->uniquePackage($Product_Package_Name,$Product_Package_Id);
			 
			 if($Product_Package_Name!='' && $uniquePackage==TRUE)
			 $inserted=$this->PackageModel->savePackage($Product_Package_Id,$insertArray); //savePackage() is used for  Insert and Update IDCR_TBL_PRODUCT_PACKAGE.
			 
			 if ($inserted == TRUE)
				{
				   $msgdata = array(
					   'msg'  => '<div class="alert alert-success" role="alert"><strong>Success.</strong> Package <strong>'.$Product_Package_Name.'</strong> succesfully Saved.</div>'
					 );
					 $this->session->set_userdata($msgdata);
				}
			elseif ($inserted == FALSE && $uniquePackage==FALSE)
				{
				   $msgdata = array(
					   'msg'  => '<div class="alert alert-danger" role="alert"><strong>Error.</strong> This Package <strong>'.$Product_Package_Name.'</strong> is alrady Axist!</div>'
					 );
					 $this->session->set_userdata($msgdata);
				}
			else
				{
				   $msgdata = array(
					   'msg'  => '<div class="alert alert-danger" role="alert"><strong>Error.</strong> Failed to Save Package.</div>'
					 );
					 $this->session->set_userdata($msgdata);
				}
	
		 }

		$data['PackageList']=$this->PackageModel->getPackage();
		
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("package",$data);
	}
	
	function edit_package($Product_Package_Id='')
	{
		
		
		$Package=$this->PackageModel->getPackageSingle($Product_Package_Id);
		echo '
		
		<div class="modal-dialog">
			<div class="modal-content">
			  <div class="modal-header">
				<button type="button" class="closeButton close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel"><span class="icon-edit"></span>Edit Package</h4>
			  </div>
			  
			  
						<div class="modal-body">
							<form id="validation2" class="bs-example bs-example-form" method="post" enctype="multipart/form-data" action="'.base_url().'package/submit/">
							
							<div class="input-group">
							  <span class="input-group-addon">Package Id</span>
							  <input type="text" readonly="readonly" name="Product_Package_Id" value="'.$Package[0]->Product_Package_Id.'" maxlength="30" class="form-control required" placeholder="Package Id"/>
							</div>
							
							<div class="input-group">
							  <span class="input-group-addon">Package Name</span>
							  <input type="text" name="Product_Package_Name" value="'.$Package[0]->Product_Package_Name.'" maxlength="30" class="form-control required" placeholder="Package Name"/>
							</div>
							
							
							 <div class="input-group">
							  <span class="input-group-addon">Renew Date</span>
							  <input type="text" name="Product_Package_Date" value="'.date("d-m-Y",strtotime($Package[0]->Product_Package_Date)).'"  id="Product_Package_Date" maxlength="30" class="form-control required" placeholder="Renew Date"/>
							</div>
							
							
							<div class="input-group">
							  <span class="input-group-addon">Package Amount</span>
							  <input type="text" name="Product_Package_Amount" value="'.$Package[0]->Product_Package_Amount.'" maxlength="30" class="form-control required" placeholder="Package Amount"/>
							</div>
							
							
							<div class="modal-footer">
								<button type="button" class="closeButton btn btn-default" data-dismiss="modal">Close</button>
								<input type="submit" name="submit" value="Update Package" class="btn btn-primary"/>
							</div>
							
							</form>
						</div>
						
						
			  
			</div>
	  </div>
	  
	  ';
	}
	
	
	
	

}
?>

