<?php

Class ProductModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	



	function saveProduct($Product_Info_Id='',$insertArray=array())//saveProduct() is used for  Insert and Update IDCR_TBL_PRODUCT_INFO.
	{

		if($Product_Info_Id=='')
		{
			$inserted=$this->db->insert('IDCR_TBL_PRODUCT_INFO', $insertArray);
			if($inserted)
			return TRUE;
			else
			return FALSE;
		}
		else
		{
			$this->db->where('Product_Info_Id', $Product_Info_Id);
			if($updated=$this->db->update('IDCR_TBL_PRODUCT_INFO', $insertArray))
			return TRUE;
			else
			return FALSE;
		}

	}
	
	function uniqueProduct($F_Category_Info_Id='',$Product_Info_IMEI_1='',$Product_Info_Id='')
	{
		$this->db->select('Product_Info_Id');
		$this->db->from('IDCR_TBL_PRODUCT_INFO');
		$this->db->where('F_Category_Info_Id', $F_Category_Info_Id);
		$this->db->where('Product_Info_IMEI_1', $Product_Info_IMEI_1);
		$this->db->where('Product_Info_Id  !=', $Product_Info_Id);
		$query=$this->db->get();
		$product_info=$query->result();
		$query->free_result();
		
		if(count($product_info)>0)
			{
				return FALSE;
			}
		else	
			{
			$this->db->select('Product_Info_Id');
			$this->db->from('IDCR_TBL_PRODUCT_INFO');
			$this->db->where('F_Category_Info_Id', $F_Category_Info_Id);
			$this->db->where('Product_Info_IMEI_2', $Product_Info_IMEI_1);
			$this->db->where('Product_Info_Id  !=', $Product_Info_Id);
			$query=$this->db->get();
			$product_info=$query->result();
			$query->free_result();
	
				if(count($product_info)>0)
				return FALSE;
				
				else
				return TRUE;
			}
	}

	
	function getProductList($Status_Info_Id='',$Is_Void='')
	{
		$this->db->select('IDCR_TBL_CATEGORY_INFO.Category_Info_Name, Product_Info_Id, Product_Info_Id, Product_Info_IMEI_1, Product_Info_IMEI_2, Product_Info_Purchase, Product_Info_Expire, Product_Info_TeamViewer, Product_Info_Description, IDCR_TBL_PROD_STATUS_INFO.Status_Info_Name');
		$this->db->from('IDCR_TBL_PRODUCT_INFO');
		$this->db->join('IDCR_TBL_CATEGORY_INFO', 'IDCR_TBL_CATEGORY_INFO.Category_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Category_Info_Id');	
		$this->db->join('IDCR_TBL_PROD_STATUS_INFO', 'IDCR_TBL_PROD_STATUS_INFO.Status_Info_Id = IDCR_TBL_PRODUCT_INFO.F_Status_Info_Id');	
		
		
		if($Status_Info_Id!='')
		$this->db->where('IDCR_TBL_PROD_STATUS_INFO.Status_Info_Id', $Status_Info_Id);	
		
		if($Is_Void!='')
		$this->db->where('IDCR_TBL_PRODUCT_INFO.Is_Void', $Is_Void);
		

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
	
	
	function getProductSingle($Product_Info_Id='')
	{
		$this->db->select('IDCR_TBL_CATEGORY_INFO.Category_Info_Id, Product_Info_Id, Product_Info_IMEI_1, Product_Info_IMEI_2,  Product_Info_Purchase, Product_Info_Expire, Product_Info_TeamViewer, Product_Info_Description, IDCR_TBL_PROD_STATUS_INFO.Status_Info_Name');
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
	
	function getLastId()
	{
		$this->db->select('Product_Info_Id');
		$this->db->from('IDCR_TBL_PRODUCT_INFO');
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		$this->db->order_by("Product_Info_Id","desc");
		$this->db->limit(1);
		$query=$this->db->get();
		$product_info=$query->result();
		$query->free_result();
		return $product_info[0]->Product_Info_Id;
		
	}
	function makeFirstTransaction($F_User_Info_Id='')
	{
		
		 $insertArray=array(
				'F_Status_Info_Id_Fron' => '1',
				'F_Status_Info_Id_To' => '1',
				'F_Product_Info_Id' => $this->getLastId(),
				'F_User_Info_Id' => $F_User_Info_Id,
				'Transaction_Date' =>date("Y-m-d H:i:s"),
				'Return_Date' => '',
				'Transaction_Description' => '',				
				'F_Admin_Info_Id' => $this->session->userdata('Admin_Info_Id')
			 );
			 
			$inserted=$this->db->insert('IDCR_TBL_TRANSACTION', $insertArray);
			if($inserted)
			return TRUE;
			else
			return FALSE;
	}
	
	
}