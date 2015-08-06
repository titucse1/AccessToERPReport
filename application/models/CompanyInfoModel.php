<?php

Class CompanyInfoModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }



    function getCompanyInfoSelectBox($required='',$Current_Company='',$Edit='')
    {
        $this->db->select('Company_Info_Id,Company_Info_Name');
        $this->db->from('TBL_COMPANY_INFO');
        $this->db->where('Is_Exist', '1');
        $this->db->where('Is_Void', '0');
        $this->db->order_by('Company_Info_Name', 'ASC');

        $query=$this->db->get();
        $company_info=$query->result();
        $query->free_result();
        // 1 for add and 0 for edit
        if($Edit=='') $string='<select class="'.$required.'" name="Company_Info_Id" id="Company_Info_Id'.$Edit.'" onChange="getDepartmentInfo(this.value,1);">';
        else $string='<select class="'.$required.'" name="Company_Info_Id" id="Company_Info_Id'.$Edit.'" onChange="getDepartmentInfo(this.value,0);">';
        $string.='<option value="">Select Company Name</option>';
        if(count($company_info)>0)
        {
            foreach($company_info as $cat)
            {
                $selected='';
                if($Current_Company==$cat->Company_Info_Id)
                    $selected ='selected="selected"';
                $string.='<option '.$selected.' value="'.$cat->Company_Info_Id.'">'.$cat->Company_Info_Name.'</option>';
            }
        }
        $string.='</select>';
        return $string;

    }

}