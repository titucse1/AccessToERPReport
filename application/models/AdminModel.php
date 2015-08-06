<?php

Class AdminModel extends CI_Model
{
    function __construct()
    {
        /* Call the Model constructor */
        parent::__construct();
    }
	



	function checklogin($Admin_Info_User_Name='',$Admin_Info_User_Password='')
	{
		 	
		$this->db->select('Admin_Info_Id, Admin_Info_Full_Name, Admin_Info_User_Name, Admin_Info_User_Password');
		$this->db->from('IDCR_TBL_ADMIN_INFO');
		$this->db->where('Admin_Info_User_Name', mysql_real_escape_string($Admin_Info_User_Name));
		$this->db->where('Admin_Info_User_Password', mysql_real_escape_string($Admin_Info_User_Password));
		$this->db->where('Is_Exist', '1');
		$this->db->where('Is_Void !=', '1');
		
		$query=$this->db->get();
		$user_info=$query->result();
		$query->free_result();

		if(count($user_info)>0)
		{
			$userdata = array(
                   'Admin_Info_Id'  => $user_info[0]->Admin_Info_Id,
                   'Admin_Info_User_Name'  => $user_info[0]->Admin_Info_User_Name,
                   'Admin_Info_Full_Name'  => $user_info[0]->Admin_Info_Full_Name
               );
			$this->session->set_userdata($userdata);
		}
		
	}

	
	
	
	
	
}