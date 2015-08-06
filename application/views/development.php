<?php  include_once "headerfooter/header.php";?>
<?php  include_once "topmenu/topmenu.php";?>
 
<div class="row-fluid topWrapper">

   <div class="span12">
   <?php if($msg!='') echo $msg;?>
   <h3>Development Strategy</h3>
   
   </div>
   
</div>
   
<div class="row-fluid">

   <div class="span12">
            <div class="table-responsive">
            
            <h3 id="nav" style="margin:30px 0 0px">Add New Product</h3>
            <p class="lead">There are Two SQL Quey Run, When Add New Product</p>
            <div class="bs-callout bs-callout-info">Insert into TBL_PRODUCT_INFO</div>
            <div class="bs-callout bs-callout-info">Insert into TBL_TRANSACTION with "Is_Last" = '1'</div>
            
            
            
            
            
            <h3 id="nav" style="margin:30px 0 0px">Package Assign</h3>
            <p class="lead">There are one SQL Quey Run, When Package Assign for Specific Peron</p>
            <div class="bs-callout bs-callout-info">Insert into TBL_USER_PACKAGE</div>
            <div class="bs-callout bs-callout-info">A Peron Id can be inset INTO TBL_USER_PACKAGE only for One time. No Multiple Record for a Specific Person in TBL_USER_PACKAGE</div>
           
            
            
            
            
            
            <h3 id="nav" style="margin:30px 0 0px">Product Transfer</h3>
            <p class="lead">There are Three SQL Quey Run, When Product Transfer</p>
            <div class="bs-callout bs-callout-info">Update TBL_TRANSACTION SET "Is_Last" = '0' only previous Transaction(s) for this Product </div>
            <div class="bs-callout bs-callout-info">Insert into TBL_TRANSACTION with "Is_Last" = '1'</div>
            <div class="bs-callout bs-callout-info">Update TBL_PRODUCT_INFO SET "F_Status_Info_Id" Field with the value of "Status To"</div>
                
            </div>
    </div>


</div>




 <?php include_once "headerfooter/footer.php";?>