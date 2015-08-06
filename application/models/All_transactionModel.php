<?php

Class All_transactionModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	



	function saveAll_transaction($All_transaction_Info_Id='',$insertArray=array())//saveAll_transaction() is used for  Insert and Update IDCR_TBL_PRODUCT_INFO.
	{

		if($All_transaction_Info_Id=='')
		{
			$inserted=$this->db->insert('IDCR_TBL_PRODUCT_INFO', $insertArray);
			if($inserted)
			return TRUE;
			else
			return FALSE;
		}
		else
		{
			$this->db->where('All_transaction_Info_Id', $All_transaction_Info_Id);
			if($updated=$this->db->update('IDCR_TBL_PRODUCT_INFO', $insertArray))
			return TRUE;
			else
			return FALSE;
		}

	}
	
	function uniqueAll_transaction($F_Category_Info_Id='',$All_transaction_Info_IMEI_1='',$All_transaction_Info_Id='')
	{
		$this->db->select('All_transaction_Info_IMEI_1');
		$this->db->from('IDCR_TBL_PRODUCT_INFO');
		$this->db->where('F_Category_Info_Id', $F_Category_Info_Id);
		$this->db->where('All_transaction_Info_IMEI_1', $All_transaction_Info_IMEI_1);
		$this->db->where('All_transaction_Info_Id  !=', $All_transaction_Info_Id);
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		
		$query=$this->db->get();
		$product_info=$query->result();
		$query->free_result();

			if(count($product_info)>0)
			{
			$this->db->select('All_transaction_Info_IMEI_1');
			$this->db->from('IDCR_TBL_PRODUCT_INFO');
			$this->db->where('F_Category_Info_Id', $F_Category_Info_Id);
			$this->db->where('All_transaction_Info_IMEI_2', $All_transaction_Info_IMEI_1);
			$this->db->where('All_transaction_Info_Id  !=', $All_transaction_Info_Id);
			$this->db->where('Is_Exist', '1');
			$this->db->where('Is_Void', '0');
			
			$query=$this->db->get();
			$product_info=$query->result();
			$query->free_result();
	
				if(count($product_info)>0)
				return FALSE;
				
				else
				return TRUE;
			}
			else
			return TRUE;
	}

	
	function getAll_transactionList($Status_Info_Id='',$Is_Void='')
	{
		$this->db->select('IDCR_TBL_CATEGORY_INFO.Category_Info_Name,IDCR_TBL_PRODUCT_PACKAGE.All_transaction_Package_Name, All_transaction_Info_Id, All_transaction_Info_Id, All_transaction_Info_IMEI_1, All_transaction_Info_IMEI_2, All_transaction_Info_Purchase, All_transaction_Info_Expire, All_transaction_Info_TeamViewer, All_transaction_Info_Description, IDCR_TBL_PROD_STATUS_INFO.Status_Info_Name');
		$this->db->from('IDCR_TBL_PRODUCT_INFO');
		$this->db->join('IDCR_TBL_CATEGORY_INFO', 'IDCR_TBL_CATEGORY_INFO.Category_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Category_Info_Id');	
		$this->db->join('IDCR_TBL_PROD_STATUS_INFO', 'IDCR_TBL_PROD_STATUS_INFO.Status_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Status_Info_Id');	
		
		$this->db->join('IDCR_TBL_PRODUCT_PACKAGE', 'IDCR_TBL_PRODUCT_INFO.F_All_transaction_Package_Id = IDCR_TBL_PRODUCT_PACKAGE.All_transaction_Package_Id', 'left');	
		
		if($Status_Info_Id!='')
		$this->db->where('IDCR_TBL_PROD_STATUS_INFO.Status_Info_Id', $Status_Info_Id);	
		
		if($Is_Void!='')
		$this->db->where('IDCR_TBL_PRODUCT_INFO.Is_Void', $Is_Void);
		

		$this->db->order_by('All_transaction_Info_Id', 'DESC');	
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
	
	
	function getAll_transactionSingle($All_transaction_Info_Id='')
	{
		$this->db->select('IDCR_TBL_CATEGORY_INFO.Category_Info_Id, IDCR_TBL_PRODUCT_INFO.F_All_transaction_Package_Id, All_transaction_Info_Id, All_transaction_Info_IMEI_1, All_transaction_Info_IMEI_2,  All_transaction_Info_Purchase, All_transaction_Info_Expire, All_transaction_Info_TeamViewer, All_transaction_Info_Description, IDCR_TBL_PROD_STATUS_INFO.Status_Info_Name');
		$this->db->from('IDCR_TBL_PRODUCT_INFO');
		$this->db->join('IDCR_TBL_CATEGORY_INFO', 'IDCR_TBL_CATEGORY_INFO.Category_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Category_Info_Id');	
		$this->db->join('IDCR_TBL_PROD_STATUS_INFO', 'IDCR_TBL_PROD_STATUS_INFO.Status_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Status_Info_Id');	
		
		$this->db->join('IDCR_TBL_PRODUCT_PACKAGE', 'IDCR_TBL_PRODUCT_INFO.F_All_transaction_Package_Id = IDCR_TBL_PRODUCT_PACKAGE.All_transaction_Package_Id', 'left');
		
		$this->db->where('All_transaction_Info_Id', $All_transaction_Info_Id);	
		$this->db->order_by('All_transaction_Info_Id', 'DESC');	
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
	
	
}