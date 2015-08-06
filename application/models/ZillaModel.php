<?php

Class ZillaModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	



	function getZillaSelectBox($required='',$currentZilla='',$F_Division_Info_Id='')
	{	
		$this->db->select('Zilla_Info_Id, Zilla_Name_Eng');
		$this->db->from('TBL_ZILLA_INFO');
		if($F_Division_Info_Id!='')
		$this->db->where('F_Division_Info_Id',$F_Division_Info_Id);
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		$this->db->order_by('Zilla_Name_Eng', 'ASC');
		
		$query=$this->db->get();
		$zilla_info=$query->result();
		$query->free_result();
		$string='<select class="'.$required.'" name="F_Zilla_Info_Id">';
		$string.='<option value="">Select Zilla Name</option>';
		if(count($zilla_info)>0)
		{
			   foreach($zilla_info as $cat)
			   {	
			   	  $selected='';
				  if($currentZilla==$cat->Zilla_Info_Id)
				  $selected ='selected="selected"';
				  $string.='<option '.$selected.' value="'.$cat->Zilla_Info_Id.'">'.$cat->Zilla_Name_Eng.'</option>';
			   }
		}
		$string.='</select>';
		return $string;
		
	}
	
	
	function getDivisionByZilla($Zilla_Info_Id='')
	{
			$this->db->select('F_Division_Info_Id');
			$this->db->from('TBL_ZILLA_INFO');
			$this->db->where('Zilla_Info_Id',$Zilla_Info_Id);
			$this->db->where('Is_Exist', '1');
			$this->db->where('Is_Void', '0');
			
			$query=$this->db->get();
			$zilla_info=$query->result();
			$query->free_result();
			
			
			if(isset($zilla_info[0]->F_Division_Info_Id))
			return $zilla_info[0]->F_Division_Info_Id;
			else
			return '';
	}

	
	
	
	
	
}