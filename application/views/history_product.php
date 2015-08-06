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
				
				
				var url = '<?php echo base_url();?>index.php/last_transaction/edit_transaction/'+Last_transaction_Info_Id+'/history_product_<?php echo $productDetails[0]->Product_Info_Id;?>'; 
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
   <h3>Product Details</h3>
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
						foreach($productDetails as $detail)
						{
						echo 
						'
	<tr> <td width="30%">Product Id</td>  <td width="70%">'.$detail->Product_Info_Id.'</td>	</tr>
		
	<tr> <td>Category Name</td>  <td>'.$detail->Category_Info_Name.'</td> </tr>
		 
	<tr> <td>Product IMEI 1</td>  <td>'.$detail->Product_Info_IMEI_1.'</td> </tr>
		
	<tr> <td>Product IMEI 2</td>  <td>'.$detail->Product_Info_IMEI_2.'</td> </tr>
	
	<tr> <td>Purchase Date</td>  <td>'.date("d-m-Y", strtotime($detail->Product_Info_Purchase)).'</td> </tr>
	
	<tr> <td>Expire Date</td>  <td>'.date("d-m-Y", strtotime($detail->Product_Info_Expire)).'</td> </tr>
	
	<tr> <td>TeamViewer ID</td>  <td>'.$detail->Product_Info_TeamViewer.'</td> </tr>
	
	<tr> <td>Description</td>  <td>'.$detail->Product_Info_Description.'</td> </tr>
	
	<tr> <td><strong>Current Status</strong></td>  <td><strong>'.$detail->Status_Info_Name.'</strong> ( '.$productHistory[0]['User_Info_Full_Name'].' )</td> </tr>
	
	

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
   <h3>Product History</h3>
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
            
                <table id="dataTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th id="checkAll"><span>#</span></th>
                            <th>SL No</th>
                            <th>Date</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Person</th>
                            <th>Designation</th>
                            <th>HR-ID</th>
                            <th>Contact</th>
                            <th>Description</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
						$pp= count($productHistory);
						foreach($productHistory as $trans)
						{
						echo  
						'
	<tr>
		
		<td><input type="checkbox" class="checkboxId" value="'.$trans['Transaction_Id'].'" name="checkbox[]"/></td>
		<td>'.$pp.'</td>
		<td>'.date("d-m-Y",strtotime($trans['Transaction_Date'])).'</td>
		<td>'.$trans['F_Status_Info_Id_Fron'].'</td>
		<td>'.$trans['F_Status_Info_Id_To'].'</td>
		<td><a target="_blank" href="'.base_url().'history/person/'.$trans['User_Info_Id'].'">'.$trans['User_Info_Full_Name'].'</a></td>
		<td>'.$trans['Designation_Name'].'</td>
		<td>'.$trans['HR_Employee_Id'].'</td>
		<td>'.$trans['Contact_No'].'</td>
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