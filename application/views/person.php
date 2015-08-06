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

        $("thead input").keyup( function () {

            oTable.fnFilter( this.value, oTable.oApi._fnVisibleToColumnIndex(
                oTable.fnSettings(), $("thead input").index(this) ) );
        } );


        $('#dataTable').DataTable( {} );
				
				
						
	});
	

	function getZillaName(F_Division_Info_Id)
	{
		var url = '<?php echo base_url();?>index.php/zilla/get_zilla_name/'+F_Division_Info_Id+'';
				$.ajax({
					type: 'POST',
					url: url,
					beforeSend:function(req) {
						$('.loading_middle').show();
					},
					success:function(html)
					{
						$('#zillaWrapper_1').html(html);
						$('#zillaWrapper_2').html(html);
						$('.loading_middle').hide();
					},
					error:function()
					{
						$('.loading_middle').show();
					}
				});

	}
	function doOperation(commnad)
	{

			//update command
			if(commnad=='edit'){
				
				var s=$('[name="checkbox[]"]:checked');
				if(s.length==0){alert('Please select a Person !');return false;}
				var pp=0;
				var User_Info_Id=0;
				
				s.each(function(){
					//we will edit only first one in case of multiple selction
					if(pp==0)
					User_Info_Id  = $(this).val();
					pp++;
				});
				
				
				var url = '<?php echo base_url();?>index.php/person/edit_person/'+User_Info_Id+''; 
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

    function getDepartmentInfo(Company_Id,Flag){


        var url = '<?php echo base_url();?>index.php/person/getDepartment/'+Company_Id+'/'+Flag;
        //alert(url);
        if(Company_Id!=''){
                $.ajax({
                    type: 'POST',
                    url: url,
                    beforeSend:function(req) {
                        $('.loading_middle').show();
                        $('#department_all').html('<select class="required" name="Department_Info_Id" id="Department_Info_Id" onChange="getSubDepartmentInfo();">;<option value="">Select Department Name</option></select>');
                        $('#sub_department_all').html(' <select class="required" name="Sub_Department_Info_Id" id="Sub_Department_Info_Id">;<option value="">Select Department Name</option></select>');
                    },
                    success:function(html)
                    {
                        $('.loading_middle').hide();
                        if(Flag==1) $('#department_all').html(html)
                        else        $('#department_all_edit').html(html);
                    },
                    error:function()
                    {
                        $('.loading_middle').show();
                        $('#department_all').html('<select class="required" name="Department_Info_Id" id="Department_Info_Id" onChange="getSubDepartmentInfo();">;<option value="">Select Department Name</option></select>');
                        $('#sub_department_all').html(' <select class="required" name="Sub_Department_Info_Id" id="Sub_Department_Info_Id">;<option value="">Select Department Name</option></select>');
                    }
                });
        }
    }

    function getSubDepartmentInfo(Department_Info_Id,Flag){


        var url = '<?php echo base_url();?>index.php/person/getSubDepartment/'+Department_Info_Id+'';
        if(Department_Info_Id!=''){
            $.ajax({
                type: 'POST',
                url: url,
                beforeSend:function(req) {
                    $('.loading_middle').show();
                },
                success:function(html)
                {
                    $('.loading_middle').hide();
                    if(Flag==1) $('#sub_department_all').html(html);
                    else        $('#sub_department_all_edit').html(html);
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
   <h3>All Persons</h3>
   <!--<div class="buttonDiv">
            <div class="btn-group">
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#addModal"><span class="icon-plus-sign"></span>&nbsp;Add Person</button>
            
            <button class="btn btn-warning" onClick="doOperation('edit')" type="button"><span class="icon-edit"></span>&nbsp;Edit Person</button>
            <button style="display:none;" class="btn btn-success" id="editModalButton" type="button" data-toggle="modal" data-target="#editModal"></button>
            
            
            <button class="btn btn-danger" type="button" data-toggle="modal" data-target="#delModal"><span class="icon-remove"></span>&nbsp;Del Person</button>
            </div>
   </div>-->
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
                            <th>Person Name</th>
                            <th>Designation</th>
                            <th>HR ID</th>
                            <th>Contact</th>
                            <th>Package Name</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
						foreach($PersonList as $prod)
						{
							$status=$prod->Is_Enable == 1 ? '<span style="color:#51a351;">Active</span>' :  '<span style="color:#FF0000;">Inactive</span>' ;
						echo 
						'
							<tr>
								<td><input type="checkbox" class="checkboxId" value="'.$prod->User_Info_Id.'" name="checkbox[]"/></td>
								<td>'.$prod->User_Info_Id.'</td>
								<td><a target="_blank" href="'.base_url().'history/person/'.$prod->User_Info_Id.'">'.$prod->User_Info_Full_Name.'</a></td>
								<td>'.$prod->Short_Form_Of_Designation_Name.'</td>
								<td>'.$prod->HR_Employee_Id.'</td>
								<td>'.$prod->Contact_No.'</td>
								<td>'.$prod->Product_Package_Name.'</td>
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
                    <h4 class="modal-title" id="myModalLabel"><span class="icon-plus-sign"></span>Add New Person</h4>
                </div>
                <div class="modal-body">
                    <form id="validation" class="bs-example bs-example-form" method="post" enctype="multipart/form-data" action="<?php echo base_url()."person/submit/";?>">



                                        <div class="input-group">
                                            <span class="input-group-addon">Company Name</span>
                                            <?php echo $CompanyInfoList; ?>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">Department</span>
                                                <span id="department_all">
                                                <select class="required" name="Department_Info_Id" id="Department_Info_Id" onChange="getSubDepartmentInfo();">;
                                                   <option value="">Select Department Name</option>
                                                </select>
                                            </span>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">Sub Department</span>
                                                <span id="sub_department_all">
                                                <select class="required" name="Sub_Department_Info_Id" id="Sub_Department_Info_Id">;
                                                    <option value="">Select Department Name</option>
                                                </select>
                                                </span>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">Designation</span>
                                            <?php echo $DesignationList;?>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">HR Employee Id</span>
                                            <input type="text" name="HR_Employee_Id" maxlength="20" class="form-control required" placeholder="HR Employee Id"/>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">Person Full Name</span>
                                            <input type="text" name="User_Info_Full_Name" maxlength="30"  class="form-control required" placeholder="Person Full Name"/>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">Person Contact</span>
                                            <input type="text" name="Contact_No" id="Contact_No" onkeypress="return isNumberKey(event,this.id);" maxlength="11"  class="form-control required" placeholder="Contact Number"/>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">Person Nick Name</span>
                                            <input type="text" name="Nick_Name"  class="form-control required"   placeholder="Nick Name"/>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">Person Email</span>
                                            <input type="text" name="User_Info_Email"  class="form-control required email" placeholder="Person Email Address"/>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">Person Address</span>
                                            <input type="text" name="User_Info_Address" class="form-control required" placeholder="Person Address"/>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">Username</span>
                                            <input type="text" name="User_Info_User_Name"  class="form-control required" placeholder="Person Login Username"/>
                                        </div>

                                        <div class="input-group">
                                            <span class="input-group-addon">Password</span>
                                            <input type="password" name="User_Info_User_Password"  class="form-control required" placeholder="Person Login Password"/>
                                        </div>





                                        <div class="modal-footer">
                        <button type="button" class="closeButton btn btn-default" data-dismiss="modal">Close</button>
                        <input type="submit" name="submit" value="Save Person" class="btn btn-primary"/>
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