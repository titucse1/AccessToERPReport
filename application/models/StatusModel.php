<?php

Class StatusModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	



	function getStatusSelectBox($required='',$currentStatus='')
	{	
		$this->db->select('Status_Info_Id, Status_Info_Name');
		$this->db->from('IDCR_TBL_PROD_STATUS_INFO');
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		$this->db->order_by('Status_Info_Id', 'ASC');
		
		$query=$this->db->get();
		$status_info=$query->result();
		$query->free_result();
		$string='<select class="'.$required.'" name="F_Status_Info_Id">';
		$string.='<option value="">Select Status</option>';
		if(count($status_info)>0)
		{
			   foreach($status_info as $status)
			   {	
			   	  $selected='';
				  if($currentStatus==$status->Status_Info_Id)
				  $selected ='selected="selected"';
				  
				  $string.='<option '.$selected.' value="'.$status->Status_Info_Id.'">'.$status->Status_Info_Name.'</option>';
			   }
		}
		$string.='</select>';
		return $string;
		
	}
	
	function getStatusFrom($required='',$currentStatus='')
	{	
		$this->db->select('Status_Info_Id, Status_Info_Name');
		$this->db->from('IDCR_TBL_PROD_STATUS_INFO');
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		$this->db->order_by('Status_Info_Id', 'ASC');
		
		$query=$this->db->get();
		$status_info=$query->result();
		$query->free_result();
		$string='<select class="'.$required.'" id="F_Status_Info_Id_Fron" name="F_Status_Info_Id_Fron">';
		$string.='<option value="">Select Current Status</option>';
		if(count($status_info)>0)
		{
			   foreach($status_info as $status)
			   {	
			   	  $selected='';
				  if($currentStatus==$status->Status_Info_Id)
				  $selected ='selected="selected"';

				  
				  $string.='<option '.$selected.' value="'.$status->Status_Info_Id.'">'.$status->Status_Info_Name.'</option>';
			   }
		}
		$string.='</select>';
		return $string;
		
	}
	
	
	function getStatusTo($required='',$currentStatus='')
	{	
		$this->db->select('Status_Info_Id, Status_Info_Name');
		$this->db->from('IDCR_TBL_PROD_STATUS_INFO');
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		$this->db->order_by('Status_Info_Id', 'ASC');
		
		$query=$this->db->get();
		$status_info=$query->result();
		$query->free_result();
		$string='<select class="'.$required.'" id="F_Status_Info_Id_To" name="F_Status_Info_Id_To">';
		$string.='<option value="">Select Status</option>';
		if(count($status_info)>0)
		{
			   foreach($status_info as $status)
			   {	
			   	  $selected='';
				  if($currentStatus==$status->Status_Info_Id)
				  $selected ='selected="selected"';

				  $string.='<option '.$selected.' value="'.$status->Status_Info_Id.'">'.$status->Status_Info_Name.'</option>';
			   }
		}
		$string.='</select>';
		return $string;
		
	}

	
	
	
	
	
}