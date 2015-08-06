<?php 
class Package_assign extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();
		$Admin_Info_Id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == FALSE)
            {
                redirect('login');
            }
                $this->load->model('Package_assignModel');
				$this->load->model('Package_listModel');
	} 

	function index()
	{
		$data['PackageSelectBox']=$this->Package_listModel->getPackage_listSelectBox('required','');
		$data['Package_assignList']=$this->Package_assignModel->getPackage_assignList();
        $data['title']="Package Assign List";
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("package_assign",$data);
	}
	
	

	
	
	function submit()
	{
		 if($this->input->post('submit'))
		 {
			
			 if($this->input->post('F_User_Info_Id'))
			 $F_User_Info_Id=$this->input->post('F_User_Info_Id');
			 else $F_User_Info_Id='';
			 
			 if($this->input->post('F_Product_Package_Id'))
			 $F_Product_Package_Id=$this->input->post('F_Product_Package_Id');
			 else $F_Product_Package_Id='';


			 $insertArray=array(
				'F_User_Info_Id' => $F_User_Info_Id,
				'F_Product_Package_Id' => $F_Product_Package_Id,
				'F_Admin_Info_Id' => $this->session->userdata('Admin_Info_Id')
			 );
			 		
			 $inserted=$this->Package_assignModel->savePackage_assign( $F_User_Info_Id, $insertArray); //savePackage_assign() is used for  Insert and Update
			 
			 if ($inserted == TRUE)
				{
					$msgdata = array(
					   'msg'  => '<div class="alert alert-success" role="alert"><strong>Success.</strong> Package succesfully Saved for Person.</div>'
					 );
					 $this->session->set_userdata($msgdata);
				}
			else
			{
					$msgdata = array(
					   'msg'  => '<div class="alert alert-danger" role="alert"><strong>Error !</strong> Package not Saved.</div>'
					 );
					 $this->session->set_userdata($msgdata);
				}
	
		 }
		 
		 
		$data['PackageSelectBox']=$this->Package_listModel->getPackage_listSelectBox('required','');
		$data['Package_assignList']=$this->Package_assignModel->getPackage_assignList();
        $data['title']="Package Assign List";
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("package_assign",$data);




	}
	
	
	
	function edit_assign($User_Info_Id='')
	{
		$Package_assign=$this->Package_assignModel->getPackage_assignSingle($User_Info_Id);

        $CompanyInfoList=$this->CompanyInfoModel->getCompanyInfoSelectBox('required',$Package_assign[0]->Company_Info_Id,'_edit');

        $getDepartmentParentId=$this->DepartmentModel->getDepartmentParentID($Package_assign[0]->F_Department_Info_Id); //0 for edit
        $DepartmentList=$this->DepartmentModel->getDepartmentSelectBox('required',$getDepartmentParentId,$Package_assign[0]->Company_Info_Id,'',0);

        $SubDepartmentList=$this->DepartmentModel->getSubDepartmentSelectBox('required',$Package_assign[0]->F_Department_Info_Id,$getDepartmentParentId,'_edit');

		$DesignationList=$this->DesignationModel->getDesignationSelectBox('required',$Package_assign[0]->F_Designation_Id,'');

		echo '
		
	<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="closeButton close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="icon-edit"></span>Edit Package_assign</h4>
      </div>
      <div class="modal-body">
      				<form id="validation2" class="bs-example bs-example-form" method="post" enctype="multipart/form-data" action="'.base_url().'person/submit/">



        			<div class="input-group">
                        <span class="input-group-addon">Company Name</span>
                        '.$CompanyInfoList.'
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Department</span>
                        <span id="department_all_edit">
                        '.$DepartmentList.'
                    </span>
                    </div>

                    <div class="input-group">
                        <span class="input-group-addon">Sub Department</span>
                            <span id="sub_department_all_edit">
                              '.$SubDepartmentList.'
                            </span>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Designation</span>
                      '.$DesignationList.'
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">HR Employee Id</span>
                      <input type="text" name="HR_Employee_Id" maxlength="20" value="'.$Package_assign[0]->HR_Employee_Id.'" class="form-control required" placeholder="HR Employee Id"/>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Package_assign Full Name</span>
                      <input type="text" name="User_Info_Full_Name" maxlength="30" value="'.$Package_assign[0]->User_Info_Full_Name.'" class="form-control required" placeholder="Package_assign Full Name"/>
                    </div>

                   <div class="input-group">
                      <span class="input-group-addon">Package_assign Contact</span>
                      <input type="text" name="Contact_No" id="Contact_No" onkeypress="return isNumberKey(event,this.id);" maxlength="11" value="'.$Package_assign[0]->Contact_No.'" class="form-control required" placeholder="Contact Number"/>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Package_assign Nick Name</span>
                      <input type="text" name="Nick_Name"  class="form-control required" value="'.$Package_assign[0]->Nick_Name.'"  placeholder="Nick Name"/>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Package_assign Email</span>
                      <input type="text" name="User_Info_Email"  value="'.$Package_assign[0]->User_Info_Email.'" class="form-control required email" placeholder="Package_assign Email Address"/>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Package_assign Address</span>
                      <input type="text" name="User_Info_Address" value="'.$Package_assign[0]->User_Info_Address.'" class="form-control required" placeholder="Package_assign Address"/>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Username</span>
                      <input type="text" name="User_Info_User_Name" value="'.$Package_assign[0]->User_Info_User_Name.'"  class="form-control required" placeholder="Package_assign Login Username"/>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Password</span>
                      <input type="password" name="User_Info_User_Password" value="'.$Package_assign[0]->User_Info_User_Password.'"  class="form-control required" placeholder="Package_assign Login Password"/>
                    </div>
					
					
                    
                    
                    
                    <div class="modal-footer">
                        <button type="button" class="closeButton btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Update Package_assign" class="btn btn-primary"/>
                        <input type="hidden" name="User_Info_Id" value="'.$Package_assign[0]->User_Info_Id.'"/>
                    </div>
                    </form>
      </div>
      
    </div>
  </div>
	  
	  ';
	}
	
	
	
	

}
?>

