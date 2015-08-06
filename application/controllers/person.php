<?php 
class Person extends CI_Controller
{
	function __construct() 
	{
		parent::__construct();
		$Admin_Info_Id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == FALSE)
            {
                redirect('login');
            }
                $this->load->model('PersonModel');
                $this->load->model('DivisionModel');
                $this->load->model('ZillaModel');
                $this->load->model('CompanyInfoModel');
                $this->load->model('DepartmentModel');
                $this->load->model('DesignationModel');
	} 

	function index()
	{
		$data['PersonList']=$this->PersonModel->getPersonList();
        $data['title']="Person List";
        $data['CompanyInfoList']=$this->CompanyInfoModel->getCompanyInfoSelectBox('required','');

		$data['DesignationList']=$this->DesignationModel->getDesignationSelectBox('required');
		
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("person",$data);
	}
	
	
	function getDepartment($Company_Id,$flag) // $flag may be   1 for add and 0 for edit
    {
        echo $this->DepartmentModel->getDepartmentSelectBox('required','',$Company_Id,'',$flag);//($required='',$currentDepartment='',$Company_Id='')
    }

    function getSubDepartment($Department_Info_Id)
    {
        echo $this->DepartmentModel->getSubDepartmentSelectBox('required','',$Department_Info_Id);//($required='',$currentDepartment='',$Company_Id='')
    }
	
	function selectPerson()
	{
		$PersonList=$this->PersonModel->getPersonList('');// parameter may be '1', '0' or '', '1' for active person,'0' for inactive person, '' for all person,
		
		$html= '
	  <div class="table-responsive">
       <div class="buttonDiv" style="text-align: center;">
            <button class="btn btn-success" onClick="selectSinglePerson()" type="button"><span class="icon-ok"></span>&nbsp;Select Person</button>
       </div>
                <table id="dataTablePerson" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th id="checkAll"><span>#</span></th>
                            <th>ID</th>
                            <th>Full Name</th>
							<th>Desig</th>
							<th>HR Id</th>
                            <th>Contact Number</th>
							<th>Package Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
					
                    <tbody>';
					
						foreach($PersonList as $person)
						{
							$status=$person->Is_Enable == 1 ? '<span style="color:#51a351;">Active</span>' :  '<span style="color:#FF0000;">Inactive</span>' ;
						$html.= 
						'
							<tr>
								<td><input type="checkbox" class="checkboxId" value="'.$person->User_Info_Id.'$$$'.$person->User_Info_Full_Name.'" name="checkboxPerson[]"/></td>
								<td>'.$person->User_Info_Id.'</td>
								<td>'.$person->User_Info_Full_Name.'</td>
								<td>'.$person->Short_Form_Of_Designation_Name.'</td>
								<td>'.$person->HR_Employee_Id.'</td>
								<td>'.$person->Contact_No.'</td>
								<td>'.$person->Product_Package_Name.'</td>
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
                $Sub_Department_Info_Id=$this->input->post('Sub_Department_Info_Id');
                if(empty($F_Department_Info_Id))$F_Department_Info_Id='';

                $F_Designation_Id=$this->input->post('F_Designation_Id');
                if(empty($F_Designation_Id))$F_Designation_Id='';

                $HR_Employee_Id=$this->input->post('HR_Employee_Id');
                if(empty($HR_Employee_Id))$HR_Employee_Id='';

                $User_Info_Full_Name=$this->input->post('User_Info_Full_Name');
                if(empty($User_Info_Full_Name))$User_Info_Full_Name='';

                $Contact_No=$this->input->post('Contact_No');
                if(empty($Contact_No))$Contact_No='';

                $Nick_Name=$this->input->post('Nick_Name');
                if(empty($Nick_Name))$Nick_Name='';

                $User_Info_Email=$this->input->post('User_Info_Email');
                if(empty($User_Info_Email))$User_Info_Email='';

                $User_Info_Email=$this->input->post('User_Info_Email');
                if(empty($User_Info_Email))$User_Info_Email='';

                $User_Info_Address=$this->input->post('User_Info_Address');
                if(empty($User_Info_Address))$User_Info_Address='';

                $User_Info_User_Name=$this->input->post('User_Info_User_Name');
                if(empty($User_Info_User_Name))$User_Info_User_Name='';

                $User_Info_User_Password=$this->input->post('User_Info_User_Password');
                if(empty($User_Info_User_Password))$User_Info_User_Password='';

                $User_Info_Id=$this->input->post('User_Info_Id');
                if(empty($User_Info_Id))$User_Info_Id='';
			 
			 
		 
			 $insertArray=array(
                                'F_User_Login_Type_Id' => '4',
                                'F_Department_Info_Id' => $Sub_Department_Info_Id,
                                'F_Designation_Id' => $F_Designation_Id,
                                'HR_Employee_Id' => $HR_Employee_Id,
                                'User_Info_Full_Name' => $User_Info_Full_Name,
                                'Contact_No' => $Contact_No,
                                'Nick_Name' => $Nick_Name,
                                'User_Info_Email' => $User_Info_Email,
                                'User_Info_Address' => $User_Info_Address,
                                'User_Info_User_Name' => $User_Info_User_Name,
                                'User_Info_User_Password' =>$User_Info_User_Password  );
	
			 $inserted = FALSE;
			 $uniquePerson=$this->PersonModel->uniquePerson($HR_Employee_Id,$User_Info_Id);
			 
			 if($HR_Employee_Id!='' && $User_Info_Full_Name!='' && $uniquePerson==TRUE)
			 $inserted=$this->PersonModel->savePerson($User_Info_Id,$insertArray); //savePerson() is used for  Insert and Update TBL_USER_INFO.
			 
			 if ($inserted == TRUE)
				{
				   $msgdata = array('msg'  => '<div class="alert alert-success" role="alert"><strong>Success.</strong> Person <strong>'.$User_Info_Full_Name.'&nbsp;('.$HR_Employee_Id.')</strong> succesfully Saved.</div>');
					 $this->session->set_userdata($msgdata);
				}
			elseif ($inserted == FALSE && $uniquePerson==FALSE)
				{
				   $msgdata = array('msg'  => '<div class="alert alert-danger" role="alert"><strong>Error.</strong> This Person <strong>'.$User_Info_Full_Name.'&nbsp;('.$HR_Employee_Id.')</strong> is alrady Axist!</div>');
					 $this->session->set_userdata($msgdata);
				}
			else
				{
				   $msgdata = array('msg'  => '<div class="alert alert-danger" role="alert"><strong>Error.</strong> Failed to Save Person.</div>');
					 $this->session->set_userdata($msgdata);
				}
	
    }



			$data['PersonList']=$this->PersonModel->getPersonList();
			$data['CompanyInfoList']=$this->CompanyInfoModel->getCompanyInfoSelectBox('required','');
			$data['DivisionList']=$this->DivisionModel->getDivisionSelectBox('required');
			$data['DepartmentList']=$this->DepartmentModel->getDepartmentSelectBox('required','','','','1');//($required='',$currentDepartment='',$Parent_F_Department_Info_Id='')
			$data['DesignationList']=$this->DesignationModel->getDesignationSelectBox('required');
			$data['title']="Person List";
			$data['msg']=$this->session->userdata('msg');
			$userdata = array('msg'  => '');
			$this->session->set_userdata($userdata);
			$this->load->view("person",$data);
	}
	
	
	
	function edit_person($User_Info_Id='')
	{
		$Person=$this->PersonModel->getPersonSingle($User_Info_Id);

        $CompanyInfoList=$this->CompanyInfoModel->getCompanyInfoSelectBox('required',$Person[0]->Company_Info_Id,'_edit');

        $getDepartmentParentId=$this->DepartmentModel->getDepartmentParentID($Person[0]->F_Department_Info_Id); //0 for edit
        $DepartmentList=$this->DepartmentModel->getDepartmentSelectBox('required',$getDepartmentParentId,$Person[0]->Company_Info_Id,'',0);

        $SubDepartmentList=$this->DepartmentModel->getSubDepartmentSelectBox('required',$Person[0]->F_Department_Info_Id,$getDepartmentParentId,'_edit');

		$DesignationList=$this->DesignationModel->getDesignationSelectBox('required',$Person[0]->F_Designation_Id,'');

		echo '
		
	<div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="closeButton close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="icon-edit"></span>Edit Person</h4>
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
                      <input type="text" name="HR_Employee_Id" maxlength="20" value="'.$Person[0]->HR_Employee_Id.'" class="form-control required" placeholder="HR Employee Id"/>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Person Full Name</span>
                      <input type="text" name="User_Info_Full_Name" maxlength="30" value="'.$Person[0]->User_Info_Full_Name.'" class="form-control required" placeholder="Person Full Name"/>
                    </div>

                   <div class="input-group">
                      <span class="input-group-addon">Person Contact</span>
                      <input type="text" name="Contact_No" id="Contact_No" onkeypress="return isNumberKey(event,this.id);" maxlength="11" value="'.$Person[0]->Contact_No.'" class="form-control required" placeholder="Contact Number"/>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Person Nick Name</span>
                      <input type="text" name="Nick_Name"  class="form-control required" value="'.$Person[0]->Nick_Name.'"  placeholder="Nick Name"/>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Person Email</span>
                      <input type="text" name="User_Info_Email"  value="'.$Person[0]->User_Info_Email.'" class="form-control required email" placeholder="Person Email Address"/>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Person Address</span>
                      <input type="text" name="User_Info_Address" value="'.$Person[0]->User_Info_Address.'" class="form-control required" placeholder="Person Address"/>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Username</span>
                      <input type="text" name="User_Info_User_Name" value="'.$Person[0]->User_Info_User_Name.'"  class="form-control required" placeholder="Person Login Username"/>
                    </div>

                    <div class="input-group">
                      <span class="input-group-addon">Password</span>
                      <input type="password" name="User_Info_User_Password" value="'.$Person[0]->User_Info_User_Password.'"  class="form-control required" placeholder="Person Login Password"/>
                    </div>
					
					
                    
                    
                    
                    <div class="modal-footer">
                        <button type="button" class="closeButton btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Update Person" class="btn btn-primary"/>
                        <input type="hidden" name="User_Info_Id" value="'.$Person[0]->User_Info_Id.'"/>
                    </div>
                    </form>
      </div>
      
    </div>
  </div>
	  
	  ';
	}
	
	
	
	

}
?>

