<?php

Class DepartmentModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	



	function getDepartmentSelectBox($required='',$currentDepartment='',$F_Company_Info_Id='',$Parent_F_Department_Info_Id='0',$flag)
	{	
		$this->db->select('Department_Info_Id, Department_Info_Name');
		$this->db->from('TBL_DEPARTMENT_INFO');
		$this->db->where('F_Company_Info_Id',$F_Company_Info_Id);
        $this->db->where('Parent_F_Department_Info_Id',$Parent_F_Department_Info_Id);
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void', '0');
		$this->db->order_by('Department_Info_Name', 'ASC');
		
		$query=$this->db->get();
		$department_info=$query->result();
		$query->free_result(); // 1 for add and 0 for edit
        if($flag==1) $string='<select class="'.$required.'" name="Department_Info_Id" id="Department_Info_Id" onChange="getSubDepartmentInfo(this.value,1);">';
		else $string='<select class="'.$required.'" name="Department_Info_Id" id="Department_Info_Id_edit" onChange="getSubDepartmentInfo(this.value,0);">';

		$string.='<option value="">Select Department Name</option>';
		if(count($department_info)>0)
		{
			   foreach($department_info as $cat)
			   {	
			   	  $selected='';
				  if($currentDepartment==$cat->Department_Info_Id)
				  $selected ='selected="selected"';
				  $string.='<option '.$selected.' value="'.$cat->Department_Info_Id.'">'.$cat->Department_Info_Name.'</option>';
			   }
		}
		$string.='</select>';
		return $string;
		
	}

    function getSubDepartmentSelectBox($required='',$currentDepartment='',$Department_Info_Id='0',$Edit='')
    {
        $this->db->select('Department_Info_Id, Department_Info_Name');
        $this->db->from('TBL_DEPARTMENT_INFO');
        $this->db->where('Parent_F_Department_Info_Id',$Department_Info_Id);
        $this->db->where('Is_Exist', '1');
        $this->db->where('Is_Void', '0');
        $this->db->order_by('Department_Info_Name', 'ASC');

        $query=$this->db->get();
        $department_info=$query->result();
        $query->free_result();
        $string='<select class="'.$required.'" name="Sub_Department_Info_Id" id="Sub_Department_Info_Id'.$Edit.'">';
        $string.='<option value="">Select Department Name</option>';
        if(count($department_info)>0)
        {
            foreach($department_info as $cat)
            {
                $selected='';
                if($currentDepartment==$cat->Department_Info_Id)
                    $selected ='selected="selected"';
                $string.='<option '.$selected.' value="'.$cat->Department_Info_Id.'">'.$cat->Department_Info_Name.'</option>';
            }
        }
        $string.='</select>';
        return $string;
    }

	function getDepartmentParentID($Department_Info_Id)
    {
        $this->db->select('Parent_F_Department_Info_Id');
        $this->db->from('TBL_DEPARTMENT_INFO');
        $this->db->where('Department_Info_Id',$Department_Info_Id);
        $query=$this->db->get();
        $department_info=$query->result();
        $query->free_result();

        return $department_info[0]->Parent_F_Department_Info_Id;
    }
	
	
	
	
}