<?php

Class DesignationModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	



	function getDesignationSelectBox($required='',$currentDesignation='')
	{	
		$this->db->select('Designation_Id, Designation_Name');
		$this->db->from('TBL_DESIGNATION');
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		$this->db->order_by('Designation_Name', 'ASC');
		
		$query=$this->db->get();
		$designation_info=$query->result();
		$query->free_result();
		$string='<select class="'.$required.'" name="F_Designation_Id">';
		$string.='<option value="">Select Designation Name</option>';
		if(count($designation_info)>0)
		{
			   foreach($designation_info as $cat)
			   {	
			   	  $selected='';
				  if($currentDesignation==$cat->Designation_Id)
				  $selected ='selected="selected"';
				  $string.='<option '.$selected.' value="'.$cat->Designation_Id.'">'.$cat->Designation_Name.'</option>';
			   }
		}
		$string.='</select>';
		return $string;
		
	}

	
	
	
	
	
}