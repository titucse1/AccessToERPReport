<?php

Class PersonModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	



	function savePerson($User_Info_Id='',$insertArray=array())//savePerson() is used for  Insert and Update TBL_USER_INFO.
	{

		if($User_Info_Id=='')
		{
                  //  print_r($insertArray);exit;
			$inserted=$this->db->insert('TBL_USER_INFO', $insertArray);
			if($inserted)
			return TRUE;
			else
			return FALSE;
		}
		else
		{
			$this->db->where('User_Info_Id', $User_Info_Id);
			if($updated=$this->db->update('TBL_USER_INFO', $insertArray))
			return TRUE;
			else
			return FALSE;
		}

	}
	
	function uniquePerson($HR_Employee_Id='',$User_Info_Id='')
	{

		$this->db->select('HR_Employee_Id');
		$this->db->from('TBL_USER_INFO');
		$this->db->where('HR_Employee_Id', $HR_Employee_Id);
		$this->db->where('User_Info_Id  !=', $User_Info_Id);
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Enable', '1');
		
		$query=$this->db->get();
		$person_info=$query->result();
		$query->free_result();

			if(count($person_info)>0)
			return FALSE;
			
			else
			return TRUE;
	}

	
	function getPersonList($Is_Enable='')
	{
		$this->db->distinct();
		$this->db->select('User_Info_Id,Short_Form_Of_Designation_Name, HR_Employee_Id, User_Info_Full_Name, Contact_No, Is_Enable, IDCR_TBL_PRODUCT_PACKAGE.Product_Package_Name');
		$this->db->from('TBL_USER_INFO');	
		$this->db->join('TBL_DESIGNATION', 'TBL_DESIGNATION.Designation_Id = TBL_USER_INFO.F_Designation_Id', "LEFT");
		$this->db->join('IDCR_TBL_USER_PACKAGE', 'TBL_USER_INFO.User_Info_Id = IDCR_TBL_USER_PACKAGE.F_User_Info_Id', "LEFT");
		$this->db->join('IDCR_TBL_PRODUCT_PACKAGE', 'IDCR_TBL_USER_PACKAGE.F_Product_Package_Id = IDCR_TBL_PRODUCT_PACKAGE.Product_Package_Id', "LEFT");
		
		
		if($Is_Enable!='')
		$this->db->where('TBL_USER_INFO.Is_Enable', $Is_Enable);
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
	
	
	function getPersonSingle($User_Info_Id='')
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