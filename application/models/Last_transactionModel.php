<?php

Class Last_transactionModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	



	function saveLast_transaction($Transaction_Id='',$insertArray=array())//saveLast_transaction() is used for  Insert and Update IDCR_TBL_TRANSACTION.
	{
		if($Transaction_Id=='')
		{
			$inserted=$this->db->insert('IDCR_TBL_TRANSACTION', $insertArray);
			if($inserted)
			return TRUE;
			else
			return FALSE;
		}
		else
		{
			$this->db->where('Transaction_Id', $Transaction_Id);
			if($updated=$this->db->update('IDCR_TBL_TRANSACTION', $insertArray))
			return TRUE;
			else
			return FALSE;
		}

	}
	

	
	function getLast_transactionList() // last entries for all devices.
	{
		$this->db->select('Status_Info_Id, Status_Info_Name');
		$this->db->from('IDCR_TBL_PROD_STATUS_INFO');
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		$this->db->order_by('Status_Info_Id', 'ASC');
		
		$query=$this->db->get();
		$status_info=$query->result();
		$query->free_result();
		$status_arr=array();
		if(count($status_info)>0)
		{
		   foreach($status_info as $status)
		   {	
			  $status_arr[$status->Status_Info_Id]=$status->Status_Info_Name;
		   }
		}


		$this->db->select('IDCR_TBL_TRANSACTION.Transaction_Id,
		IDCR_TBL_CATEGORY_INFO.Category_Info_Name,
		IDCR_TBL_PRODUCT_INFO.Product_Info_Id,
		IDCR_TBL_PRODUCT_INFO.Product_Info_IMEI_1,
		IDCR_TBL_PRODUCT_INFO.Product_Info_IMEI_2,
		IDCR_TBL_PRODUCT_INFO.Product_Info_Purchase,
		IDCR_TBL_PRODUCT_INFO.Product_Info_Expire,
		IDCR_TBL_TRANSACTION.F_Status_Info_Id_Fron,
		IDCR_TBL_TRANSACTION.F_Status_Info_Id_To,
		TBL_USER_INFO.User_Info_Full_Name,
		TBL_USER_INFO.HR_Employee_Id,
		TBL_USER_INFO.User_Info_Id,
		TBL_USER_INFO.Contact_No,
		IDCR_TBL_PRODUCT_PACKAGE.Product_Package_Name,
		IDCR_TBL_TRANSACTION.Transaction_Date,
		TBL_DESIGNATION.Short_Form_Of_Designation_Name,
		IDCR_TBL_TRANSACTION.Transaction_Description');
		
		$this->db->from('IDCR_TBL_TRANSACTION');
		$this->db->join('IDCR_TBL_PRODUCT_INFO', 'IDCR_TBL_PRODUCT_INFO.Product_Info_Id = IDCR_TBL_TRANSACTION.F_Product_Info_Id');
		$this->db->join('IDCR_TBL_CATEGORY_INFO', 'IDCR_TBL_CATEGORY_INFO.Category_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Category_Info_Id');						        $this->db->join('TBL_USER_INFO', 'TBL_USER_INFO.User_Info_Id = IDCR_TBL_TRANSACTION.F_User_Info_Id');
		$this->db->join('TBL_DESIGNATION', 'TBL_DESIGNATION.Designation_Id = TBL_USER_INFO.F_Designation_Id');
		$this->db->join('IDCR_TBL_USER_PACKAGE', 'TBL_USER_INFO.User_Info_Id = IDCR_TBL_USER_PACKAGE.F_User_Info_Id', "LEFT");
		$this->db->join('IDCR_TBL_PRODUCT_PACKAGE', 'IDCR_TBL_USER_PACKAGE.F_Product_Package_Id = IDCR_TBL_PRODUCT_PACKAGE.Product_Package_Id', "LEFT");
		
		$this->db->where('IDCR_TBL_TRANSACTION.Is_Last', '1');
		$this->db->order_by('IDCR_TBL_TRANSACTION.Transaction_Id', 'DESC');	
		
		
		$query=$this->db->get();
		$product_info=$query->result();
		$query->free_result();
		$result=array();
		$pp=0;
			if(count($product_info)>0)
			{ 
				foreach($product_info as $trans)
				   {	
					  $result[$pp]['Transaction_Id']=$trans->Transaction_Id;
					  $result[$pp]['Category_Info_Name']=$trans->Category_Info_Name;
					  $result[$pp]['Product_Info_Id']=$trans->Product_Info_Id;
					  $result[$pp]['Product_Info_Purchase']=$trans->Product_Info_Purchase;
					  $result[$pp]['Product_Info_Expire']=$trans->Product_Info_Expire;
					  $result[$pp]['Product_Info_IMEI_1']=$trans->Product_Info_IMEI_1;
					  $result[$pp]['Product_Info_IMEI_2']=$trans->Product_Info_IMEI_2;
					  $result[$pp]['F_Status_Info_Id_Fron']=$status_arr[$trans->F_Status_Info_Id_Fron];
					  $result[$pp]['F_Status_Info_Id_To']=$status_arr[$trans->F_Status_Info_Id_To];
					  $result[$pp]['User_Info_Full_Name']=$trans->User_Info_Full_Name;
					  $result[$pp]['HR_Employee_Id']=$trans->HR_Employee_Id;
					  $result[$pp]['User_Info_Id']=$trans->User_Info_Id;
					  $result[$pp]['Contact_No']=$trans->Contact_No;
					  $result[$pp]['Short_Form_Of_Designation_Name']=$trans->Short_Form_Of_Designation_Name;
					  $result[$pp]['Transaction_Date']=$trans->Transaction_Date;
					  $result[$pp]['Product_Package_Name']=$trans->Product_Package_Name;
					  $result[$pp]['Transaction_Description']=$trans->Transaction_Description;
					  $pp++;
				   }
			}
		return $result;
	}
	
	
	function getLast_transactionSingle($Transaction_Id='')// get single transition by Transition ID.
	{
		
		$this->db->select('Status_Info_Id, Status_Info_Name');
		$this->db->from('IDCR_TBL_PROD_STATUS_INFO');
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		$this->db->order_by('Status_Info_Id', 'ASC');
		
		$query=$this->db->get();
		$status_info=$query->result();
		$query->free_result();
		$status_arr=array();
		if(count($status_info)>0)
		{
		   foreach($status_info as $status)
		   {	
			  $status_arr[$status->Status_Info_Id]=$status->Status_Info_Name;
		   }
		}


		$this->db->select('IDCR_TBL_TRANSACTION.Transaction_Id,
		IDCR_TBL_CATEGORY_INFO.Category_Info_Name,
		IDCR_TBL_PRODUCT_INFO.Product_Info_Id,
		IDCR_TBL_PRODUCT_INFO.Product_Info_IMEI_1,
		IDCR_TBL_PRODUCT_INFO.Product_Info_IMEI_2,
		IDCR_TBL_PRODUCT_INFO.Product_Info_Purchase,
		IDCR_TBL_PRODUCT_INFO.Product_Info_Expire,
		IDCR_TBL_TRANSACTION.F_Status_Info_Id_Fron,
		IDCR_TBL_TRANSACTION.F_Status_Info_Id_To,
		TBL_USER_INFO.User_Info_Full_Name,
		TBL_USER_INFO.HR_Employee_Id,
		TBL_USER_INFO.User_Info_Id,
		TBL_USER_INFO.Contact_No,
		IDCR_TBL_TRANSACTION.Transaction_Date,
		TBL_DESIGNATION.Short_Form_Of_Designation_Name,
		IDCR_TBL_TRANSACTION.Transaction_Description');
		
		$this->db->from('IDCR_TBL_TRANSACTION');
		$this->db->join('IDCR_TBL_PRODUCT_INFO', 'IDCR_TBL_PRODUCT_INFO.Product_Info_Id = IDCR_TBL_TRANSACTION.F_Product_Info_Id');
		$this->db->join('IDCR_TBL_CATEGORY_INFO', 'IDCR_TBL_CATEGORY_INFO.Category_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Category_Info_Id');						        $this->db->join('TBL_USER_INFO', 'TBL_USER_INFO.User_Info_Id = IDCR_TBL_TRANSACTION.F_User_Info_Id');
		$this->db->join('TBL_DESIGNATION', 'TBL_DESIGNATION.Designation_Id = TBL_USER_INFO.F_Designation_Id');	
		$this->db->where('IDCR_TBL_TRANSACTION.Transaction_Id', $Transaction_Id);
		
		
		
		$query=$this->db->get();
		$product_info=$query->result();
		$query->free_result();
		$result=array();
		$pp=0;
			if(count($product_info)>0)
			{ 
				foreach($product_info as $trans)
				   {	
					  $result[$pp]['Transaction_Id']=$trans->Transaction_Id;
					  $result[$pp]['Category_Info_Name']=$trans->Category_Info_Name;
					  $result[$pp]['Product_Info_Id']=$trans->Product_Info_Id;
					  $result[$pp]['Product_Info_Purchase']=$trans->Product_Info_Purchase;
					  $result[$pp]['Product_Info_Expire']=$trans->Product_Info_Expire;
					  $result[$pp]['Product_Info_IMEI_1']=$trans->Product_Info_IMEI_1;
					  $result[$pp]['Product_Info_IMEI_2']=$trans->Product_Info_IMEI_2;
					  $result[$pp]['F_Status_Info_Id_Fron']=$status_arr[$trans->F_Status_Info_Id_Fron];
					  $result[$pp]['F_Status_Info_Id_To']=$status_arr[$trans->F_Status_Info_Id_To];
					  $result[$pp]['User_Info_Full_Name']=$trans->User_Info_Full_Name;
					  $result[$pp]['HR_Employee_Id']=$trans->HR_Employee_Id;
					  $result[$pp]['User_Info_Id']=$trans->User_Info_Id;
					  $result[$pp]['Contact_No']=$trans->Contact_No;
					  $result[$pp]['Short_Form_Of_Designation_Name']=$trans->Short_Form_Of_Designation_Name;
					  $result[$pp]['Transaction_Date']=$trans->Transaction_Date;
					  $result[$pp]['Transaction_Description']=$trans->Transaction_Description;
					  $pp++;
				   }
			}
		return $result;
	
		
	}
	

	
	
}