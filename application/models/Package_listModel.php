<?php

Class Package_listModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	

	function savePackage($Product_Package_Id='',$insertArray=array())//savePackage_list() is used for  Insert and Update IDCR_TBL_PRODUCT_PACKAGE.
	{

		if($Product_Package_Id=='')
		{
			$inserted=$this->db->insert('IDCR_TBL_PRODUCT_PACKAGE', $insertArray);
			if($inserted)
			return TRUE;
			else
			return FALSE;
		}
		else
		{
			$this->db->where('Product_Package_Id', $Product_Package_Id);
			if($updated=$this->db->update('IDCR_TBL_PRODUCT_PACKAGE', $insertArray))
			return TRUE;
			else
			return FALSE;
		}

	}
	
	function uniquePackage($Product_Package_Name='',$Product_Package_Id='')
	{

		$this->db->select('Product_Package_Name');
		$this->db->from('IDCR_TBL_PRODUCT_PACKAGE');
		$this->db->where('Product_Package_Name', $Product_Package_Name);
		$this->db->where('Product_Package_Id  !=', $Product_Package_Id);
		$query=$this->db->get();
		$package_info=$query->result();
		$query->free_result();

			if(count($package_info)>0)
			return FALSE;
			
			else
			return TRUE;
	}

	
	function getPackage_list($Product_Package_Id='')
	{
		$this->db->select('Product_Package_Id, Product_Package_Name, Product_Package_Date, Product_Package_Amount,IDCR_TBL_PRODUCT_PACKAGE.Is_Void');
		$this->db->from('IDCR_TBL_PRODUCT_PACKAGE');
		$this->db->order_by('Product_Package_Name', 'ASC');	
		$query=$this->db->get();
		$package_info=$query->result();
		$query->free_result();
		$result=array();
			if(count($package_info)>0)
			{
				$result= $package_info;
			}
		return $result;
	}
	
	
	
	function getPackage_listSelectBox($required='',$currentPackage='')
	{	
		$this->db->select('Product_Package_Id, Product_Package_Name');
		$this->db->from('IDCR_TBL_PRODUCT_PACKAGE');
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		$this->db->order_by('Product_Package_Name', 'ASC');
		
		$query=$this->db->get();
		$category_info=$query->result();
		$query->free_result();
		$string='<select class="'.$required.'" name="F_Product_Package_Id">';
		$string.='<option value="">Select Package Name</option>';
		if($currentPackage=='0')
		$string.='<option selected="selected" value="0">No Package</option>';
		else $string.='<option value="0">No Package</option>';
		if(count($category_info)>0)
		{
			   foreach($category_info as $pack)
			   {	
			   	  $selected='';
				  if($currentPackage==$pack->Product_Package_Id)
				  $selected ='selected="selected"';
				  $string.='<option '.$selected.' value="'.$pack->Product_Package_Id.'">'.$pack->Product_Package_Name.'</option>';
			   }
		}
		$string.='</select>';
		return $string;
		
	}

	
	
	function getPackage_listSingle($Product_Package_Id='')
	{
		$this->db->select(' Product_Package_Id, Product_Package_Name, Product_Package_Date, Product_Package_Amount,IDCR_TBL_PRODUCT_PACKAGE.Is_Void');
		$this->db->from('IDCR_TBL_PRODUCT_PACKAGE');
		$this->db->where('Product_Package_Id', $Product_Package_Id);	
		$this->db->order_by('Product_Package_Name', 'ASC');	
		$query=$this->db->get();
		$package_info=$query->result();
		$query->free_result();
		$result=array();
			if(count($package_info)>0)
			{
				$result= $package_info;
			}
		return $result;
		
	}
	
	
}