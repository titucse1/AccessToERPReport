<?php

Class HistoryModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	




    function getProductSingle($Product_Info_Id='')
	{
		$this->db->select('IDCR_TBL_CATEGORY_INFO.Category_Info_Name, Product_Info_Id, Product_Info_IMEI_1, Product_Info_IMEI_2,  Product_Info_Purchase, Product_Info_Expire, Product_Info_TeamViewer, Product_Info_Description, IDCR_TBL_PROD_STATUS_INFO.Status_Info_Name');
		$this->db->from('IDCR_TBL_PRODUCT_INFO');
		$this->db->join('IDCR_TBL_CATEGORY_INFO', 'IDCR_TBL_CATEGORY_INFO.Category_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Category_Info_Id');	
		$this->db->join('IDCR_TBL_PROD_STATUS_INFO', 'IDCR_TBL_PROD_STATUS_INFO.Status_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Status_Info_Id');	
		
		$this->db->where('Product_Info_Id', $Product_Info_Id);	
		$this->db->order_by('Product_Info_Id', 'DESC');	
		$query=$this->db->get();
		$product_info=$query->result();
		$query->free_result();
		$result=array();
			if(count($product_info)>0)
			{
				$result= $product_info;
			}
		return $result;
	}
	
	function getHistory_product($F_Product_Info_Id='') // get product history by product ID.
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
		IDCR_TBL_TRANSACTION.F_Status_Info_Id_Fron,
		IDCR_TBL_TRANSACTION.F_Status_Info_Id_To,
		TBL_USER_INFO.User_Info_Full_Name,
		TBL_USER_INFO.HR_Employee_Id,
		TBL_USER_INFO.User_Info_Id,
		TBL_USER_INFO.Contact_No,
		IDCR_TBL_TRANSACTION.Transaction_Date,
		TBL_DESIGNATION.Designation_Name,
		IDCR_TBL_TRANSACTION.Transaction_Description');
		
		$this->db->from('IDCR_TBL_TRANSACTION');
		$this->db->join('TBL_USER_INFO', 'TBL_USER_INFO.User_Info_Id = IDCR_TBL_TRANSACTION.F_User_Info_Id');
		$this->db->join('TBL_DESIGNATION', 'TBL_DESIGNATION.Designation_Id = TBL_USER_INFO.F_Designation_Id');
		$this->db->where('IDCR_TBL_TRANSACTION.F_Product_Info_Id', $F_Product_Info_Id);
		$this->db->order_by('IDCR_TBL_TRANSACTION.Transaction_Id', 'DESC');	
		//$this->db->limit(50);	
		
		
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
					  $result[$pp]['F_Status_Info_Id_Fron']=$status_arr[$trans->F_Status_Info_Id_Fron];
					  $result[$pp]['F_Status_Info_Id_To']=$status_arr[$trans->F_Status_Info_Id_To];
					  $result[$pp]['User_Info_Full_Name']=$trans->User_Info_Full_Name;
					  $result[$pp]['HR_Employee_Id']=$trans->HR_Employee_Id;
					  $result[$pp]['User_Info_Id']=$trans->User_Info_Id;
					  $result[$pp]['Contact_No']=$trans->Contact_No;
					  $result[$pp]['Designation_Name']=$trans->Designation_Name;
					  $result[$pp]['Transaction_Date']=$trans->Transaction_Date;
					  $result[$pp]['Transaction_Description']=$trans->Transaction_Description;
					  $pp++;
				   }
			}
		return $result;
	}
	
	
	
	//---------------------------------------
	
	function getUserSingle($User_Info_Id='')
	{
		$this->db->select('Designation_Name, User_Info_Id, HR_Employee_Id, User_Info_Full_Name, Nick_Name, Contact_No,User_Info_Address,User_Info_Email,Is_Enable');
		$this->db->from('TBL_USER_INFO');
        $this->db->join('TBL_DESIGNATION', 'TBL_DESIGNATION.Designation_Id = TBL_USER_INFO.F_Designation_Id');

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
	
	
	function getReturnDate($Product_Info_Id='', $Transaction_Id='')
	{
		$this->db->select('
		IDCR_TBL_TRANSACTION.Transaction_Date');
		
		$this->db->from('IDCR_TBL_TRANSACTION');
		$this->db->where('IDCR_TBL_TRANSACTION.F_Product_Info_Id', $Product_Info_Id);
		$this->db->where('IDCR_TBL_TRANSACTION.Transaction_Id > ', $Transaction_Id);
		$this->db->order_by('IDCR_TBL_TRANSACTION.Transaction_Id', 'ASC');	
		$this->db->limit(1);	

		$query=$this->db->get();
		$date=$query->result();
		$query->free_result();
		if(isset($date[0]->Transaction_Date))
		return $date[0]->Transaction_Date;
		else return '';
		
	}
	
	
	function getHistory_User($F_User_Info_Id='') // get history by user ID.
	{
		

		$this->db->select('
		IDCR_TBL_TRANSACTION.Transaction_Id,
		IDCR_TBL_CATEGORY_INFO.Category_Info_Name,
		IDCR_TBL_PRODUCT_INFO.Product_Info_Id,
		IDCR_TBL_PRODUCT_INFO.Product_Info_IMEI_1,
		IDCR_TBL_PRODUCT_INFO.Product_Info_IMEI_2,
		IDCR_TBL_TRANSACTION.Transaction_Date,
		IDCR_TBL_TRANSACTION.Transaction_Description,
		IDCR_TBL_TRANSACTION.Is_Last');
		
		$this->db->from('IDCR_TBL_TRANSACTION');
		$this->db->join('IDCR_TBL_PRODUCT_INFO', 'IDCR_TBL_PRODUCT_INFO.Product_Info_Id = IDCR_TBL_TRANSACTION.F_Product_Info_Id');
		$this->db->join('IDCR_TBL_CATEGORY_INFO', 'IDCR_TBL_CATEGORY_INFO.Category_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Category_Info_Id');						
		
		$this->db->where('IDCR_TBL_TRANSACTION.F_User_Info_Id', $F_User_Info_Id);
		$this->db->order_by('IDCR_TBL_TRANSACTION.Transaction_Id', 'DESC');	
		//$this->db->limit(50);	

		$query=$this->db->get();
		$product_info=$query->result();
		$query->free_result();
		$product_list=array();
		$result=array();
		$pp=0;
			if(count($product_info)>0)
			{ 
				foreach($product_info as $trans)
				   {	
					  
					  
					  $result[$pp]['Transaction_Id']=$trans->Transaction_Id;
					  $result[$pp]['Category_Info_Name']=$trans->Category_Info_Name;
					  $result[$pp]['Product_Info_Id']=$trans->Product_Info_Id;
					  $result[$pp]['Product_Info_IMEI_1']=$trans->Product_Info_IMEI_1;
					  $result[$pp]['Product_Info_IMEI_2']=$trans->Product_Info_IMEI_2;
					  $result[$pp]['Transaction_Date']=$trans->Transaction_Date;
					  $result[$pp]['Return_Date']='';
					  if($trans->Is_Last != '1')
					  $result[$pp]['Return_Date']=$this->getReturnDate($trans->Product_Info_Id, $trans->Transaction_Id);
					  $result[$pp]['Transaction_Description']=$trans->Transaction_Description;
					  $result[$pp]['Is_Last']=$trans->Is_Last;
					  
					  
					  $product_list[]=$trans->Product_Info_Id;
					  $pp++;
				   }
			}
			//print_r($result); exit;
		return $result;
	}
	


	
	
}