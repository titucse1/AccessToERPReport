<?php  include_once "headerfooter/header.php";?>
<?php  include_once "topmenu/topmenu.php";?>
   <script type="text/javascript">
	$(document).ready(function(){	
			$( "#Return_Date" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "dd-mm-yy"
			});
			
			$( "#Transaction_Date" ).datepicker({
				changeMonth: true,
				changeYear: true,
				dateFormat: "dd-mm-yy"
			});			
	});
	
	function selectSingleProduct()
	{
		
		var s=$('[name="checkboxProduct[]"]:checked');
				if(s.length==0){alert('Please select a Product !');return false;}
				if(s.length > 1){alert('Please select Only One Product !');return false;}
				
				var pp=0;
				var Product_Info_Id=0;
				
				s.each(function(){
					//we will edit only first one in case of multiple selction
					if(pp==0)
					Product_Info_Id  = $(this).val();
					pp++;
				});
				
				var arr = Product_Info_Id.split('$$$');
				$('#productId').val(arr[0]);
				$('#productName').val(arr[1]);
				$('button.closeButton').click();
				
	}
	
	function selectProduct()
	{	var F_Status_Info_Id_Fron=$('#F_Status_Info_Id_Fron').val();
	
	
		if(F_Status_Info_Id_Fron=='')
			{
			alert('Please select "From Status".');
			$('#F_Status_Info_Id_Fron').focus();
			$('#F_Status_Info_Id_Fron').css('border-color','#F00');
			return false;
			}

		var url = '<?php echo base_url();?>index.php/product/selectProduct/'+F_Status_Info_Id_Fron+''; 
				$.ajax({
					type: 'POST',	
					url: url,	
					beforeSend:function(req) {
						$('.loading_middle').show();
					},
					success:function(html)
					{
						$('#productModal .modal-body').html(html);
						$('.loading_middle').hide();
						$('.productModalButton').click();
						$('#dataTableProduct').DataTable();
				
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
   <h3>Product Transfer</h3>
   
   </div>
   
</div>
   
<div class="row-fluid">

   <div class="span12 formWrapper">
   
   
            <form id="validation" class="bs-example bs-example-form" method="post" enctype="multipart/form-data" action="<?php echo base_url()."assign/submit/";?>">

        			<div class="input-group">
                      <span class="input-group-addon">Status From</span>
                      <?php echo $StatusListFrom;?>
                    </div>
                    
                    <div class="input-group">
                      <span class="input-group-addon">Status To</span>
                      <?php echo $StatusListTo;?>
                    </div>
                    
                    <div class="input-group">
                      <span class="input-group-addon">Select Product</span>
                      <input type="text" id="productName" readonly name="Product_Info"  class="form-control" placeholder="No Product Selected"/>
                      <button onClick="selectProduct();" class="btn btn-success" type="button">Select Product</button>
                      <input style="display:none;" type="text" id="productId" name="F_Product_Info_Id" maxlength="20" class="form-control required"/>
                    </div>
                    
                    
                    <div class="input-group">
                      <span class="input-group-addon">Receive Person</span>
                      <input type="text" id="personName" readonly name="Person_Info"  class="form-control" placeholder="No Person Selected"/>
                      <button onClick="selectPerson();" class="btn btn-success" type="button">Select Person&nbsp;</button>
                      <input style="display:none;" type="text" id="personId" name="F_User_Info_Id" maxlength="20" class="form-control required"/>
                    </div>
                    
                    
				
                    
                     <div class="input-group">
                      <span title="When Receive Person Receive This Product" class="input-group-addon">Receive Date</span>
                      <input type="text" id="Transaction_Date" name="Transaction_Date" value="<?php echo date("d-m-Y");?>" maxlength="20" class="form-control required"/>[DD-MM-YYYY]
                     </div>
					
                    
                    <div class="input-group">
                      <span title="Receive Person Hold This Product Till" class="input-group-addon">Hold Till Date</span>
                      <input type="text" id="Return_Date" name="Return_Date" value="" maxlength="20" class="form-control"/>[DD-MM-YYYY]
                     </div>
                     
                     
                     
                     <div class="input-group">
                      <span class="input-group-addon">Description</span>
                      <textarea class="form-control" name="Transaction_Description"></textarea>
                     </div>

                    
                    <div class="modal-footer">
                        <input type="submit" name="submit" value="Make Transfer" class="btn btn-primary"/>
                         <input type="hidden" name="from_hidden" value="transaction"/>
                    </div>
                    </form>
    </div>


</div>



<!-- productModal -->
<button style="display:none;"  data-toggle="modal" data-target="#productModal" class="btn btn-success productModalButton" type="submit">Select Product</button>
<div class="modal fade modal-lg" id="productModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="closeButton close" data-dismiss="modal"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel"><span class="icon-ok"></span>Select a Product</h4>
      </div>
      <div class="modal-body"> 
      </div>
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



 <?php include_once "headerfooter/footer.php";?>