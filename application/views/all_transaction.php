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
				if(s.length==0){alert('Please select a Product !');return false;}
				if(s.length>1){alert('Please select Only One Product !');return false;}
				var pp=0;
				var Product_Info_Id=0;
				
				s.each(function(){
					//we will edit only first one in case of multiple selction
					if(pp==0)
					Product_Info_Id  = $(this).val();
					pp++;
				});
				
				
				var url = '<?php echo base_url();?>index.php/product/edit_product/'+Product_Info_Id+''; 
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
						
						$( "#Product_Info_Purchase_edit" ).datepicker({
							changeMonth: true,
							changeYear: true,
							dateFormat: "dd-mm-yy"
						});
						
						$( "#Product_Info_Expire_edit" ).datepicker({
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
<div class="row-fluid topWrapper">

   <div class="span12">
   <?php if($msg!='') echo $msg;?>
   <h3>All Products</h3>
   <div class="buttonDiv">
            <div class="btn-group">
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#addModal"><span class="icon-plus-sign"></span>&nbsp;Add Product</button>
            
            <button class="btn btn-warning" onClick="doOperation('edit')" type="button"><span class="icon-edit"></span>&nbsp;Edit Product</button>
            <button style="display:none;" class="btn btn-success" id="editModalButton" type="button" data-toggle="modal" data-target="#editModal"></button>
            
            
            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#delModal"><span class="icon-remove"></span>&nbsp;Del Product</button>
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
                            <th>Cateory Name</th>
                            <th>IMEI 1</th>
                            <th>IMEI 2</th>
                            <th>Package</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
						foreach($ProductList as $prod)
						{
							//$status=$prod->Is_Void == 0 ? '<span style="color:#51a351;">Active</span>' :  '<span style="color:#FF0000;">Inactive</span>' ;
							if(empty($prod->Product_Package_Name))
							$prod->Product_Package_Name='No';
						echo 
						'
							<tr>
								<td><input type="checkbox" class="checkboxId" value="'.$prod->Product_Info_Id.'" name="checkbox[]"/></td>
								<td>'.$prod->Product_Info_Id.'</td>
								<td>'.$prod->Category_Info_Name.'</td>
								<td>'.$prod->Product_Info_IMEI_1.'</td>
								<td>'.$prod->Product_Info_IMEI_2.'</td>
								<td>'.$prod->Product_Package_Name.'</td>
								<td>'.$prod->Status_Info_Name.'</td>
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
        <h4 class="modal-title" id="myModalLabel"><span class="icon-plus-sign"></span>Add New Product</h4>
      </div>
      <div class="modal-body">
      				<form id="validation" class="bs-example bs-example-form" method="post" enctype="multipart/form-data" action="<?php echo base_url()."product/submit/";?>">
        			<div class="input-group">
                      <span class="input-group-addon">Category</span>
                      <?php echo $CategorySelectBox;?>
                    </div>
                    
                    <div class="input-group">
                      <span class="input-group-addon">IMEI&nbsp;1</span>
                      <input type="text" name="Product_Info_IMEI_1" maxlength="30" class="form-control required" placeholder="IMEI 1"/>
                    </div>
                    
                    
                    
                    <div class="input-group">
                      <span class="input-group-addon">IMEI&nbsp;2</span>
                      <input type="text" name="Product_Info_IMEI_2" maxlength="30" class="form-control required" placeholder="IMEI 2"/>
                    </div>
                    
                    
                    <div class="input-group">
                      <span class="input-group-addon">Purchase Date</span>
                      <input type="text" value="<?php echo date("d-m-Y");?>" name="Product_Info_Purchase" id="Product_Info_Purchase" maxlength="30" class="form-control required" placeholder="Purchase Date"/>[DD-MM-YYYY]
                    </div>
                    
                    
                    
                    <div class="input-group">
                      <span class="input-group-addon">Expire Date</span>
                      <input type="text" name="Product_Info_Expire" id="Product_Info_Expire" maxlength="30" class="form-control " placeholder="Expire Date"/>[DD-MM-YYYY]
                    </div>
                    
                    
                    <div class="input-group">
                      <span class="input-group-addon">Team Viewer ID</span>
                      <input type="text" name="Product_Info_TeamViewer" id="Product_Info_TeamViewer" maxlength="11" class="form-control " placeholder="Team Viewer ID"/>
                    </div>
                    
                    
     
     
                      <div class="input-group">
                      <span class="input-group-addon">Package Name</span>
                       <?php echo $PackageSelectBox;?>
                      </div>
                    
                  
                    
                    <div class="input-group">
                      <span class="input-group-addon">Product Description</span>
                      <textarea class="form-control" cols="50" rows="3" name="Product_Info_Description"></textarea>
                    </div>

                    
                    
                    
                    <div class="modal-footer">
                        <button type="button" class="closeButton btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Save Product" class="btn btn-primary"/>
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