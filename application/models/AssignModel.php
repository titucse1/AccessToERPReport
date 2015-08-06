<?php

Class AssignModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	



	function saveAssign($Transaction_Id='',$insertArray=array())//saveAssign() is used for  Insert and Update IDCR_TBL_PRODUCT_INFO.
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
	
	function checkAvailable($F_Status_Info_Id_Fron='',$F_Product_Info_Id='')
	{
		if($F_Status_Info_Id_Fron=='' || $F_Product_Info_Id=='')
		return FALSE;
		
		$this->db->select('Product_Info_Id');
		$this->db->from('IDCR_TBL_PRODUCT_INFO');
		$this->db->where('Product_Info_Id', $F_Product_Info_Id);
		$this->db->where('F_Status_Info_Id', $F_Status_Info_Id_Fron);
		
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		
		$query=$this->db->get();
		$assign_info=$query->result();
		$query->free_result();

			if(count($assign_info)>0)
			return TRUE;
			
			else
			return FALSE;
	}

	
	function getAssignList()
	{
		$this->db->select('IDCR_TBL_CATEGORY_INFO.Category_Info_Name, Assign_Info_Id, Assign_Info_IMEI_1, Assign_Info_IMEI_2, Assign_Info_Description, IDCR_TBL_PROD_STATUS_INFO.Status_Info_Name');
		$this->db->from('IDCR_TBL_PRODUCT_INFO');
		$this->db->join('IDCR_TBL_CATEGORY_INFO', 'IDCR_TBL_CATEGORY_INFO.Category_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Category_Info_Id');	
		$this->db->join('IDCR_TBL_PROD_STATUS_INFO', 'IDCR_TBL_PROD_STATUS_INFO.Status_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Status_Info_Id');	
		$this->db->order_by('Assign_Info_Id', 'DESC');	
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
	
	
	function getAssignSingle($Assign_Info_Id='')
	{
		$this->db->select('IDCR_TBL_CATEGORY_INFO.Category_Info_Id, Assign_Info_Id, Assign_Info_IMEI_1, Assign_Info_IMEI_2, Assign_Info_Description, IDCR_TBL_PROD_STATUS_INFO.Status_Info_Name');
		$this->db->from('IDCR_TBL_PRODUCT_INFO');
		$this->db->join('IDCR_TBL_CATEGORY_INFO', 'IDCR_TBL_CATEGORY_INFO.Category_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Category_Info_Id');	
		$this->db->join('IDCR_TBL_PROD_STATUS_INFO', 'IDCR_TBL_PROD_STATUS_INFO.Status_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Status_Info_Id');	
		$this->db->where('Assign_Info_Id', $Assign_Info_Id);	
		$this->db->order_by('Assign_Info_Id', 'DESC');	
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
	
	
}