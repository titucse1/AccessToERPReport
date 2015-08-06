<?php

Class CategoryModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	



	function getCategorySelectBox($required='',$currentCat='')
	{	
		$this->db->select('Category_Info_Id, Category_Info_Name');
		$this->db->from('IDCR_TBL_CATEGORY_INFO');
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		$this->db->order_by('Category_Info_Name', 'ASC');
		
		$query=$this->db->get();
		$category_info=$query->result();
		$query->free_result();
		$string='<select class="'.$required.'" name="F_Category_Info_Id">';
		$string.='<option value="">Select Category Name</option>';
		if(count($category_info)>0)
		{
			   foreach($category_info as $cat)
			   {	
			   	  $selected='';
				  if($currentCat==$cat->Category_Info_Id)
				  $selected ='selected="selected"';
				  $string.='<option '.$selected.' value="'.$cat->Category_Info_Id.'">'.$cat->Category_Info_Name.'</option>';
			   }
		}
		$string.='</select>';
		return $string;
		
	}

	
	
	
	
	
}