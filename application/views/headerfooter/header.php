<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title><?php if(isset($title)) {echo $title.'- Powered by belivIT'; } else {echo 'Product Management- Powered by belivIT'; }?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Product Management System">
    <meta name="author" content="belivIT">

    <!-- Le styles -->
    <link href="<?php echo base_url();?>css/bootstrap.css" rel="stylesheet">
   
    <link href="<?php echo base_url();?>css/bootstrap-responsive.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/dataTable.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/dataTables.tableTools.css" rel="stylesheet">
    <link href="<?php echo base_url();?>css/docs.css" rel="stylesheet">

    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="<?php echo base_url();?>js/html5shiv.js"></script>
    <![endif]-->
            <script src="<?php echo base_url();?>angularjs/angular.js"></script>                         
    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="<?php echo base_url();?>js/jquery-1.8.3.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-transition.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-alert.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-modal.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-dropdown.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-scrollspy.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-tab.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-tooltip.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-popover.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-button.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-collapse.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-carousel.js"></script>
    <script src="<?php echo base_url();?>js/jquery.validate.js"></script>
    
    <link href="<?php echo base_url();?>css/jquery-ui.css" rel="stylesheet">
    <script src="<?php echo base_url();?>js/jquery-ui.js"></script>


    <script src="<?php echo base_url();?>js/dataTable.js"></script>  
    <script src="<?php echo base_url();?>js/dataTables.tableTools.js"></script>                               
    <script type="text/javascript">
	$(document).ready(function(){	
	
	
				$("#validation").validate();
				
				
				$("button.closeButton").click(function(){
					$(".modal-backdrop").click();
				});
				
				
				$("#checkAll").click(function(){
					$(".checkboxId").click();
					$(".checkboxId").parent().parent().removeClass('active');
				});
				
				
				$(".checkboxId").click(function(){						
					if($(this).is(':checked'))
					$(this).parent().parent().addClass('active');
					else
					$(this).parent().parent().removeClass('active');
				});
						
						
	});
	</script>                       
  </head>

  <body> 
  
  
  <div class="container">     
  
  <div class="headerWrapper">
  <div class="row-fluid">
	<div class="span12">
        <center><h2>LPL ERP Report System</h2><hr style="margin:0;"/><h5>An Inventory Control System</h5></center>
    </div>
  </div>
  </div>

<hr style="margin:0px"/>

