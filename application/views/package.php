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
				
				
				$( "#Product_Package_Date" ).datepicker({
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
				if(s.length==0){alert('Please select a Package !');return false;}
				if(s.length>1){alert('Please select Only One Package !');return false;}
				var pp=0;
				var Product_Package_Id=0;
				
				s.each(function(){
					//we will edit only first one in case of multiple selction
					if(pp==0)
					Product_Package_Id  = $(this).val();
					pp++;
				});
				
				
				var url = '<?php echo base_url();?>index.php/package_list/edit_package/'+Product_Package_Id+''; 
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
	</script>   
<div class="row-fluid topWrapper">

   <div class="span12">
   <?php if($msg!='') echo $msg;?>
   <h3>All Packages</h3>
   <div class="buttonDiv">
            <div class="btn-group">
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#addModal"><span class="icon-plus-sign"></span>&nbsp;Add Package</button>
            
            <button class="btn btn-warning" onClick="doOperation('edit')" type="button"><span class="icon-edit"></span>&nbsp;Edit Package</button>
            <button style="display:none;" class="btn btn-success" id="editModalButton" type="button" data-toggle="modal" data-target="#editModal"></button>
            
            
            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#delModal"><span class="icon-remove"></span>&nbsp;Del Package</button>
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
                            <th>ID</th>
                            <th>Package Name</th>
                            <th>Renew Date</th>
                            <th>Amount</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
						foreach($PackageList as $prod)
						{
							$status=$prod->Is_Void == 0 ? '<span style="color:#51a351;">Active</span>' :  '<span style="color:#FF0000;">Inactive</span>' ;
						echo 
						'
							<tr>
								<td><input type="checkbox" class="checkboxId" value="'.$prod->Product_Package_Id.'" name="checkbox[]"/></td>
								<td>'.$prod->Product_Package_Id.'</td>
								<td>'.$prod->Product_Package_Name.'</td>
								<td>'.date("d-m-Y",strtotime($prod->Product_Package_Date)).'</td>
								<td>'.$prod->Product_Package_Amount.'</td>
								<td>'.$status.'</td>
							</tr>
						';
						}
						?>
                        
                    </tbody>
                </table>
            </div>
    </div>


</div>



<!-- addModal -->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="closeButton close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="icon-plus-sign"></span>Add New Package</h4>
      </div>
      <div class="modal-body">
      				<form id="validation" class="bs-example bs-example-form" method="post" enctype="multipart/form-data" action="<?php echo base_url()."package_list/submit/";?>">
        			
                    
                    
                    <div class="input-group">
                      <span class="input-group-addon">Package Name</span>
                      <input type="text" name="Product_Package_Name" maxlength="30" class="form-control required" placeholder="Package Name"/>
                    </div>
                    
                    
                   <div class="input-group">
                      <span class="input-group-addon">Renew Date</span>
                      <input type="text" name="Product_Package_Date"  id="Product_Package_Date" maxlength="30" class="form-control required" placeholder="Renew Date"/>
                    </div>
                    
                    <div class="input-group">
                      <span class="input-group-addon">Package Amount</span>
                      <input type="text" name="Product_Package_Amount" maxlength="30" class="form-control required" placeholder="Package Amount"/>
                    </div>
                       
                    
                    <div class="modal-footer">
                        <button type="button" class="closeButton btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Save Package" class="btn btn-primary"/>
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