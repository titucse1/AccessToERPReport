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
				
			$( "#Product_Info_Purchase" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "dd-mm-yy"
			});
			
			$( "#Product_Info_Expire" ).datepicker({
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
				if(s.length==0){alert('Please select an Assign Record !');return false;}
				if(s.length>1){alert('Please select Only One Record !');return false;}
				var pp=0;
				var User_Package_Id=0;
				
				s.each(function(){
					//we will edit only first one in case of multiple selction
					if(pp==0)
					User_Package_Id  = $(this).val();
					pp++;
				});
				
				
				var url = '<?php echo base_url();?>index.php/package_assign/edit_assign/'+User_Package_Id+''; 
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
   <h3>Person and Package</h3>
   <div class="buttonDiv">
            <div class="btn-group">
            <button class="btn btn-success" type="button" id="addModalButton" data-toggle="modal" data-target="#addModal"><span class="icon-plus-sign"></span>&nbsp;Add / Edit Assign</button>
            
            <!--<button class="btn btn-warning"  type="button"><span class="icon-edit"></span>&nbsp;Edit Assign</button>-->
            <button style="display:none;" class="btn btn-success" id="editModalButton" type="button" data-toggle="modal" data-target="#editModal"></button>
            
            
            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#delModal"><span class="icon-remove"></span>&nbsp;Del Assignment</button>
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
                            <th>Person Name</th>
                            <th>Designation</th>
                            <th>Contact</th>
                            <th>Package Name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
						foreach($Package_assignList as $assign)
						{
							//$status=$prod->Is_Void == 0 ? '<span style="color:#51a351;">Active</span>' :  '<span style="color:#FF0000;">Inactive</span>' ;
					if(empty($assign->Product_Package_Name))
					$assign->Product_Package_Name='No';
					
						echo 
						'
							<tr>
								<td><input type="checkbox" class="checkboxId" value="'.$assign->User_Package_Id.'" name="checkbox[]"/></td>
								<td>'.$assign->User_Info_Full_Name.'</td>
								<td>'.$assign->Short_Form_Of_Designation_Name.'</td>
								<td>'.$assign->Contact_No.'</td>
								<td>'.$assign->Product_Package_Name.'</td>
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

<!-- addModal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="closeButton close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="icon-plus-sign"></span>New Assignment</h4>
      </div>
      <div class="modal-body">
      				<form id="validation" class="bs-example bs-example-form" method="post" enctype="multipart/form-data" action="<?php echo base_url()."package_assign/submit/";?>">
        			
                    
                    <div class="input-group">
                      <span class="input-group-addon">Store Person</span>
                      <input type="text" id="personName" readonly name="Person_Info"  class="form-control" placeholder="No Person Selected"/>
                      <button onClick="selectPerson();" class="btn btn-success" type="button">Select Person&nbsp;</button>
                      <input style="display:none;" type="text" id="personId" name="F_User_Info_Id" maxlength="20" class="form-control required"/>
                    </div>
                    
     
     
                      <div class="input-group">
                      <span class="input-group-addon">Package Name</span>
                       <?php echo $PackageSelectBox;?>
                      </div>
                    
                  
                   
                    
                    
                    
                    
                    
                    
                    
                    <div class="modal-footer">
                        <button type="button" class="closeButton btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Save Assignment" class="btn btn-primary"/>
                    </div>
                    </form>
      </div>
      
    </div>
  </div>
</div>

<!-- editModal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  
</div>


 <?php include_once "headerfooter/footer.php";?>