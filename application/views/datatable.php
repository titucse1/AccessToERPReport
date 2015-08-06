<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php if(isset($title)) {echo $title.'- Powered by belivIT'; } else {echo 'Product Management- Powered by belivIT'; }?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Product Management System">
    <meta name="author" content="belivIT">

    
<!--   <script type="text/javascript">
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
				
				
				var url = '<?php // echo base_url();?>index.php/product/edit_product/'+Product_Info_Id+''; 
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
		var url = '<?php //echo base_url();?>index.php/person/selectPerson/'; 
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
	
	
	</script> -->
    
<link href="<?php echo base_url();?>DataTable/media/css/jquery.dataTables.css" rel="stylesheet">
<script src="<?php echo base_url();?>DataTable/media/js/jquery.js"></script>
<script src="<?php echo base_url();?>DataTable/media/js/jquery.dataTables.js"></script>
   
    <script type="text/javascript">
    $(document).ready(function() {
    $('#MydataTable').DataTable();
} );
    </script>
  </head>
  <body>
      
<?php
echo $datatable;

?>
 </body>  
</html>
