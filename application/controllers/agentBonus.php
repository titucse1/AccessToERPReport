<?php 
class AgentBonus extends CI_Controller
{
	function __construct()
	{
		parent::__construct();
		$Admin_Info_Id = $this->session->userdata('Admin_Info_Id');;
		if ($Admin_Info_Id == FALSE)
			{
			 redirect('login');
			}
                $this->load->library("access_db_connect");        
				
	}

	function index()
	{
       
                //$result= $this->bonusCanlculation();
		$data["bonusList"]=$this->bonusCanlculation();
		$data['msg']=$this->session->userdata('msg');
		$userdata = array('msg'  => '');
		$this->session->set_userdata($userdata);
		$this->load->view("agentbonus",$data);
	}
        
        function  bonusCanlculation()
        {
         
   $sql = "SELECT *, [Thana Name] as thana_name , [Zilla Name] as zilla_name , [Division] as division_name, [Opening Balance] as balance_ammount, [Closing Balance] as closing_balance FROM ( SELECT * FROM ( SELECT * FROM ( SELECT [Library Name] as library_name, [Library Code] as library_code, [Library Info].[Account Code] as sub_account_code, [Thana Code] as thana_code, [Zilla Code] as zilla_code, [Zone Code] as zone_code FROM [Library Info] WHERE [Zone Code] NOT IN ('42') ) AS A INNER JOIN [Sub Account info] as SAI ON SAI.[Account Code]=A.sub_account_code ) AS B INNER JOIN [Thana Info] as TI ON TI.[Thana Code]=B.thana_code ) AS C INNER JOIN [Zilla Info] as ZI ON ZI.[Zilla Code]=C.zilla_code";
            
	  return $result =$this->access_db_connect->query($sql);	
            
        }
        
         function showdataTable(){
    
             $result= $this->bonusCanlculation();
             
             $resultTable="";
      $resultTable.= '
	<table id="MydataTable" class="display" cellspacing="0" width="100%">
	<thead>
		<tr>
			<th >Library Code</th>
            <th></th>
			<th></th>
			<th></th>
			<th>Library Name</th>
			<th>Balance</th>
			<th>Closing Balance</th>
			<th></th>
			<th>Full Report</th>
			
		</tr>
         <tr>
			<th><input type="text" name="search_grade" value="Library Code" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Library Division" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Library District" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Library Thana" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Library Name" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Balance" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Closing Balance" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Status" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Report" class="search_init" /></th>
		</tr>
	</thead>
	<tbody>';
          //$resultTable="";
            foreach ($result as $myrow) {
            if(!empty($myrow)){
                //echo '<pre>';print_r($myrow);
				$status='Pending';
				if($myrow["closing_balance"]>0)
				$status='Closed';
                $resultTable.="<tr>
                            <td>". $myrow["library_code"]." </td>
                            <td>".$myrow["division_name"]."</td>
                            <td>". $myrow["zilla_name"]."</td>
                            <td>". $myrow['thana_name']. "</td>
                            <td>". rtrim($myrow["library_name"], '**')."</td>
                            <td style='text-align:right;'>". number_format($myrow["balance_ammount"], 2). "</td>
                            <td style='text-align:right;'>". number_format($myrow["closing_balance"], 2). "</td>
                            <td>". $status." </td>
							<td><span onclick='view_full_report(\"".$myrow["library_code"]."\")'>View</span></td>

                    </tr>";
                   } else {
                echo "<font color='red'>No result found.</font>";
            }
           } 
            $resultTable.="</tbody>

    </table>";
      
        $data["datatable"]=$resultTable;
        $this->load->view("datatable",$data);  
       
} 

            
	
	
	
	
	
	
	

}
?>

