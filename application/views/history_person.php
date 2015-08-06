<?php  include_once "headerfooter/header.php";?>
<?php  include_once "topmenu/topmenu.php";?>
   <script type="text/javascript">
	$(document).ready(function(){	
	
				$('#dataT-able').DataTable( {
					"dom": 'T<"clear">lfrtip',
					"tableTools": {
						"aButtons": [
							"copy",
							"print",
								{
									"sExtends":    "collection",
									"sButtonText": "Save",
									"aButtons":    [ "csv", "xls", "pdf" ]
								}
						]
					}
				} );

			$('#dataTable').DataTable( {} );
				
			$( "#Last_transaction_Info_Purchase" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "dd-mm-yy"
			});
			
			$( "#Last_transaction_Info_Expire" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "dd-mm-yy"
			});	
						
	});
	
	function doOperation(commnad)
	{

			//update command
			if(commnad=='edit'){
				
				var s=$('[name="checkbox[]"]:checked');
				if(s.length==0){alert('Please select a Transaction !');return false;}
				if(s.length>1){alert('Please select Only One Transaction !');return false;}
				var pp=0;
				var Last_transaction_Info_Id=0;
				
				s.each(function(){
					//we will edit only first one in case of multiple selction
					if(pp==0)
					Last_transaction_Info_Id  = $(this).val();
					pp++;
				});
				
				
				var url = '<?php echo base_url();?>index.php/last_transaction/edit_transaction/'+Last_transaction_Info_Id+'/history_person_<?php echo $userDetails[0]->User_Info_Id;?>'; 
				$.ajax({
					type: 'POST',	
					url: url,	
					beforeSend:function(req) {
						$('.loading_middle').show();
					},
					success:function(html)
					{
						$('#editModal').html(html);
						$('.loading_middle').hide();
						$('#editModalButton').click();
						$("button.closeButton").click(function(){
								$(".modal-backdrop").click();
							});
						$("#validation2").validate();
						

						$( "#Last_transaction_Info_Expire_edit" ).datepicker({
							changeMonth: true,
							changeYear: true,
							dateFormat: "dd-mm-yy"
						});	
			
			
					},
					error:function()
					{
						$('.loading_middle').show();
					}
				});	
				
				
			}
	}
	
	</script>  
    
    
 <div class="row-fluid topWrapper center">
   <div class="span12">
   <?php if($msg!='') echo $msg;?>
   <h3>Person Details</h3>
   <div class="buttonDiv">
            <div class="">     
            
            </div>
   </div>
   </div>
   
</div>
 
 
   
     
<div class="row-fluid">

   <div class="span12">
            <div class="table-responsive">
            
                <table id="" class="table table-bordered table-striped">
                    <tbody>
                        <?php 
						foreach($userDetails as $detail)
						{
						echo 
						'
	<tr> <td width="30%">Person Id</td>  <td width="70%">'.$detail->User_Info_Id.'</td>	</tr>
		
	<tr> <td>Person Name</td>  <td>'.$detail->User_Info_Full_Name.'</td> </tr>
		 
	<tr> <td>Designation</td>  <td>'.$detail->Designation_Name.'</td> </tr>
		
	<tr> <td>HR Employee Id</td>  <td>'.$detail->HR_Employee_Id.'</td> </tr>
	
	<tr> <td>Contact No</td>  <td>'.$detail->Contact_No.'</td> </tr>
	
	<tr> <td>Person Email</td>  <td>'.$detail->User_Info_Email.'</td> </tr>
	
	<tr> <td><strong>Current Status</strong></td> <td><strong>'.$detail->Is_Enable = 1 ?  '<strong>Active</strong>' : '<strong style="color:#F00">Inactive</strong>' .'</td> </tr>
	
	

						';
						}
						?>
                        
                    </tbody>
                </table>
            </div>
    </div>


</div>   
    
    
    
    
     
<div class="row-fluid topWrapper">
   <div class="span12">
   <h3>Current Product</h3>
   <div class="buttonDiv">
            <div class="">     
            <button class="btn btn-success" onClick="doOperation('edit')" type="button"><span class="icon-edit"></span>&nbsp;Edit Transaction</button>
            <button style="display:none;" class="btn btn-success" id="editModalButton" type="button" data-toggle="modal" data-target="#editModal"></button>
            </div>
   </div>
   </div>
   
</div>
 
 
   
     
<div class="row-fluid">

   <div class="span12">
            <div class="table-responsive">
            
                <table id="" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th id="checkAll"><span>#</span></th>
                            <th>SL No</th>
                            <th>Category</th>
                            <th>IMEI 1</th>
                            <th>IMEI 2</th>
                            <th>Assign Date</th>
                            <th>Return Date</th>
                            <th>Description</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
						$pp= count($userHistory);
						foreach($userHistory as $trans)
						{
							if($trans['Is_Last'] != '1')
							{
							$pp--;
							continue;
							
							}
							$Transaction_Date=date("d-m-Y",strtotime($trans['Transaction_Date']));
							if($trans['Return_Date']!='')
							$Return_Date=date("d-m-Y",strtotime($trans['Return_Date']));
							else
							$Return_Date='-';
						echo  
						'
	<tr>
		
		<td><input type="checkbox" class="checkboxId" value="'.$trans['Transaction_Id'].'" name="checkbox[]"/></td>
		<td>'.$pp.'</td>
		
		<td>'.$trans['Category_Info_Name'].'</td>
		
		<td><a target="_blank" href="'.base_url().'history/product/'.$trans['Product_Info_Id'].'">'.$trans['Product_Info_IMEI_1'].'</a></td>
		
		<td>'.$trans['Product_Info_IMEI_2'].'</td>
		
		
		<td>'.$Transaction_Date.'</td>
		<td>'.$Return_Date.'</td>
		
		<td>'.$trans['Transaction_Description'].'</td>
		
		

	</tr>
						';
						$pp--;
						}
						?>
                        
                    </tbody>
                </table>
                
                
            </div>
    </div>


</div>











<div class="row-fluid topWrapper">
   <div class="span12">
   <h3>Previous Product</h3>
   </div>
</div>
 
 
 
 
<div class="row-fluid">

   <div class="span12">
            <div class="table-responsive">
            
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                      <tr>
                            <th id="checkAll"><span>#</span></th>
                            <th>SL No</th>
                            <th>Category</th>
                            <th>IMEI 1</th>
                            <th>IMEI 2</th>
                            <th>Assign Date</th>
                            <th>Return Date</th>
                            <th>Description</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
						$pp= count($userHistory);
						foreach($userHistory as $trans)
						{
							if($trans['Is_Last'] == '1')
							{
							$pp--;
							continue;
							
							}
							
							$Transaction_Date=date("d-m-Y",strtotime($trans['Transaction_Date']));
							if($trans['Return_Date']!='')
							$Return_Date=date("d-m-Y",strtotime($trans['Return_Date']));
							else
							$Return_Date='-';
						echo  
						'
	<tr>
		
		<td><input type="checkbox" class="checkboxId" value="'.$trans['Transaction_Id'].'" name="checkbox[]"/></td>
		<td>'.$pp.'</td>
		
		<td>'.$trans['Category_Info_Name'].'</td>
		
		<td><a target="_blank" href="'.base_url().'history/product/'.$trans['Product_Info_Id'].'">'.$trans['Product_Info_IMEI_1'].'</a></td>
		
		<td>'.$trans['Product_Info_IMEI_2'].'</td>
		
		
		<td>'.$Transaction_Date.'</td>
		<td>'.$Return_Date.'</td>
		
		<td>'.$trans['Transaction_Description'].'</td>
		
		

	</tr>
						';
						$pp--;
						}
						?>
                        
                    </tbody>
                </table>
                
                
            </div>
    </div>


</div>




<!-- personModal -->
<button style="display:none;"  data-toggle="modal" data-target="#personModal" class="btn btn-success personModalButton" type="submit">Select Person</button>
<div class="modal fade modal-lg" id="personModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="closeButton close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="icon-ok"></span>Select a Person</h4>
      </div>
      <div class="modal-body">
      				
      </div>
      
    </div>
  </div>
</div>


<!-- editModal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>


 <?php include_once "headerfooter/footer.php";?>