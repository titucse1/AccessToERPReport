<?php

Class DivisionModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	



	function getDivisionSelectBox($required='',$currentDivision='')
	{	
		$this->db->select('Division_Info_Id, Division_Name_Eng');
		$this->db->from('TBL_DIVISION_INFO');
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		$this->db->order_by('Division_Name_Eng', 'ASC');
		
		$query=$this->db->get();
		$division_info=$query->result();
		$query->free_result();
		$string='<select onchange="getZillaName(this.value)" class="'.$required.'" name="F_Division_Info_Id">';
		$string.='<option value="">Select Division Name</option>';
		if(count($division_info)>0)
		{
			   foreach($division_info as $cat)
			   {	
			   	  $selected='';
				  if($currentDivision==$cat->Division_Info_Id)
				  $selected ='selected="selected"';
				  $string.='<option '.$selected.' value="'.$cat->Division_Info_Id.'">'.$cat->Division_Name_Eng.'</option>';
			   }
		}
		$string.='</select>';
		return $string;
		
	}

	
	
	
	
	
}