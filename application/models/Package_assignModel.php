<?php

Class Package_assignModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	


			 
			 
function check_already_assign($F_User_Info_Id='')
	{
		$this->db->select('F_User_Info_Id');
		$this->db->from('IDCR_TBL_USER_PACKAGE');
		$this->db->where('F_User_Info_Id', $F_User_Info_Id);
		$query=$this->db->get();
		$person_info=$query->result();
		$query->free_result();
		$result=array();
			if(count($person_info)>0)
			{
				return TRUE;
			}
		return FALSE;
	}
	
	
	
			 
	function savePackage_assign($F_User_Info_Id='',$insertArray=array())//savePackage_assign() is used for  Insert and Update TBL_USER_INFO.
	{
		$already_assign= $this->check_already_assign($F_User_Info_Id);
		if($already_assign== FALSE)
		{
                  //  print_r($insertArray);exit;
			$inserted=$this->db->insert('IDCR_TBL_USER_PACKAGE', $insertArray);
			if($inserted)
			return TRUE;
			else
			return FALSE;
		}
		else
		{
			$this->db->where('F_User_Info_Id', $F_User_Info_Id);
			if($updated=$this->db->update('IDCR_TBL_USER_PACKAGE', $insertArray))
			return TRUE;
			else
			return FALSE;
		}

	}
	
	
	function getPackage_assignList()
	{
		$this->db->distinct();
		$this->db->select('User_Info_Id,Short_Form_Of_Designation_Name, HR_Employee_Id, User_Info_Full_Name, Contact_No, Is_Enable, IDCR_TBL_PRODUCT_PACKAGE.Product_Package_Name, IDCR_TBL_USER_PACKAGE.User_Package_Id');
		$this->db->from('TBL_USER_INFO');	
		$this->db->join('TBL_DESIGNATION', 'TBL_DESIGNATION.Designation_Id = TBL_USER_INFO.F_Designation_Id', "LEFT");
		$this->db->join('IDCR_TBL_USER_PACKAGE', 'TBL_USER_INFO.User_Info_Id = IDCR_TBL_USER_PACKAGE.F_User_Info_Id');
		$this->db->join('IDCR_TBL_PRODUCT_PACKAGE', 'IDCR_TBL_USER_PACKAGE.F_Product_Package_Id = IDCR_TBL_PRODUCT_PACKAGE.Product_Package_Id', "LEFT");


		$this->db->order_by('User_Info_Id', 'ASC');	
		$query=$this->db->get();
		$assign_info=$query->result();
		$query->free_result();
		$result=array();
			if(count($assign_info)>0)
			{
				$result= $assign_info;
			}
		return $result;

	}
	
	
	function getPackage_assignSingle($User_Info_Id='')
	{
		$this->db->select('Company_Info_Id,F_Department_Info_Id,Department_Info_Name,F_Designation_Id, User_Info_Id, HR_Employee_Id, User_Info_Full_Name,Nick_Name, Contact_No,User_Info_Address,User_Info_Email,User_Info_User_Name,User_Info_User_Password,Is_Enable');
		$this->db->from('TBL_USER_INFO');
        $this->db->join('TBL_DEPARTMENT_INFO','TBL_USER_INFO.F_Department_Info_Id=TBL_DEPARTMENT_INFO.Department_Info_Id');
        $this->db->join('TBL_COMPANY_INFO','TBL_DEPARTMENT_INFO.F_Company_Info_Id=TBL_COMPANY_INFO.Company_Info_Id');
		$this->db->where('User_Info_Id', $User_Info_Id);
		$this->db->order_by('User_Info_Id', 'ASC');	
		$query=$this->db->get();
		$person_info=$query->result();
		$query->free_result();
		$result=array();
			if(count($person_info)>0)
			{
				$result= $person_info;
			}
		return $result;
	}
	
	
	
	
	
}