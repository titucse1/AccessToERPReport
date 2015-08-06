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
				
				
				var url = '<?php echo base_url();?>index.php/last_transaction/edit_transaction/'+Last_transaction_Info_Id+''; 
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
	
	
	
function selectSinglePerson()
	{
		
		var s=$('[name="checkboxPerson[]"]:checked');
				if(s.length==0){alert('Please select a Person !');return false;}
				if(s.length > 1){alert('Please select Only One Person !');return false;}
				var pp=0;
				var User_Info_Id=0;
				
				s.each(function(){
					//we will edit only first one in case of multiple selction
					if(pp==0)
					User_Info_Id  = $(this).val();
					pp++;
				});
				
				var arr = User_Info_Id.split('$$$');
				$('#personId').val(arr[0]);
				$('#personName').val(arr[1]);
				$('button.closeButton').click();
				$('#addModalButton').click();
				
	}
	
	function selectPerson()
	{
		var url = '<?php echo base_url();?>index.php/person/selectPerson/'; 
				$.ajax({
					type: 'POST',	
					url: url,	
					beforeSend:function(req) {
						$('.loading_middle').show();
					},
					success:function(html)
					{
						$('#personModal .modal-body').html(html);
						$('.loading_middle').hide();
						$('.closeButton').click();
						$('.personModalButton').click();
						$('#dataTablePerson').DataTable();
				
						$(".checkboxId").click(function(){						
							if($(this).is(':checked'))
							$(this).parent().parent().addClass('active');
							else
							$(this).parent().parent().removeClass('active');
						});
					
					
					},
					error:function()
					{
						$('.loading_middle').show();
					}
				});	
		
	}	
	
	
	</script>   
<div class="row-fluid topWrapper">

   <div class="span12">
   <?php if($msg!='') echo $msg;?>
   <h3>Last Transactions</h3>
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
                            <th>Category</th>
                            <th>IMEI 1</th>
                            <th>IMEI 2</th>
                            <th>From</th>
                            <th>To</th>
                            <th>Person</th>
                            <th>HR-ID</th>
                            <th>Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
						foreach($Last_transactionList as $trans)
						{
							
	if(empty($trans['Product_Package_Name'])) $trans['Product_Package_Name']='No Package';					
	if($trans['Product_Info_IMEI_1']=='' || $trans['Product_Info_IMEI_1']==' ')$trans['Product_Info_IMEI_1']='- - - - -';
						echo 
						'
	<tr>
		<td><input type="checkbox" class="checkboxId" value="'.$trans['Transaction_Id'].'" name="checkbox[]"/></td>
		<td>'.$trans['Category_Info_Name'].'</td>
		<td><a target="_blank" href="'.base_url().'history/product/'.$trans['Product_Info_Id'].'"><span title="Purchase:'.$trans['Product_Info_Purchase'].'&#10;Expire:'.$trans['Product_Info_Expire'].'">'.$trans['Product_Info_IMEI_1'].'</span></a></td>
		<td>'.$trans['Product_Info_IMEI_2'].'</td>
		<td>'.$trans['F_Status_Info_Id_Fron'].'</td>
		<td>'.$trans['F_Status_Info_Id_To'].'</td>
		<td><a target="_blank" href="'.base_url().'history/person/'.$trans['User_Info_Id'].'"><span title="Designation:'.$trans['Short_Form_Of_Designation_Name'].'&#10;Contact:'.$trans['Contact_No'].'&#10;Package:'.$trans['Product_Package_Name'].'">'.$trans['User_Info_Full_Name'].'&nbsp;('.$trans['Short_Form_Of_Designation_Name'].')</span></a></td>
		<td>'.$trans['HR_Employee_Id'].'</td>
		<td>'.date("d-m-Y",strtotime($trans['Transaction_Date'])).'</td>

	</tr>
						';
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