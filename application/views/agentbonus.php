<?php include_once "headerfooter/header.php"; ?>
<?php
include_once "topmenu/topmenu.php";

function showdataTable($result) {
    $resultTable = "";
    $resultTable.= '

	<table id="dataTable"  class="table display table-bordered table-striped">
	<thead>
		<tr>
			<th>Library Code</th>
            <th></th>
			<th></th>
			<th></th>
			<th>Library Name</th>
			<th>Balance</th>
			<th>Closing Balance</th>
			<th></th>
			<th>Full Report</th>
			
		</tr>
         <tr>
			<th><input type="text" name="search_grade" value="Library Code" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Library Division" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Library District" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Library Thana" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Library Name" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Balance" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Closing Balance" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Status" class="search_init" /></th>
			<th><input type="text" name="search_grade" value="Report" class="search_init" /></th>
		</tr>
	</thead>
	<tbody>';
    //$resultTable="";
    foreach ($result as $myrow) {
        if (!empty($myrow)) {
            //echo '<pre>';print_r($myrow);
            $status = 'Pending';
            if ($myrow["closing_balance"] > 0)
                $status = 'Closed';
            $resultTable.="<tr>
                            <td>" . $myrow["library_code"] . " </td>
                            <td>" . $myrow["division_name"] . "</td>
                            <td>" . $myrow["zilla_name"] . "</td>
                            <td>" . $myrow['thana_name'] . "</td>
                            <td>" . rtrim($myrow["library_name"], '**') . "</td>
                            <td style='text-align:right;'>" . number_format($myrow["balance_ammount"], 2) . "</td>
                            <td style='text-align:right;'>" . number_format($myrow["closing_balance"], 2) . "</td>
                            <td>" . $status . " </td>
							<td><span onclick='view_full_report(\"" . $myrow["library_code"] . "\")'>View</span></td>

                    </tr>";
        } else {
            echo "<font color='red'>No result found.</font>";
        }
    }
    $resultTable.="</tbody>

    </table>";

    echo $resultTable;
}
?>
<script type="text/javascript">
    $.fn.dataTable.ext.search.push(
            function (settings, data, dataIndex) {
                var min = parseInt($('#min').val(), 10);
                var max = parseInt($('#max').val(), 10);
                var age = parseFloat(data[3]) || 0; // use data for the age column

                if ((isNaN(min) && isNaN(max)) ||
                        (isNaN(min) && age <= max) ||
                        (min <= age && isNaN(max)) ||
                        (min <= age && age <= max))
                {
                    return true;
                }
                return false;
            }
    );

    $(document).ready(function () {




         var table = $('#dataTable').DataTable({});
        $('#min, #max').keyup(function () {
            table.draw();
        });
     

    });

    function doOperation(commnad)
    {

        //update command
        if (commnad == 'edit') {

            var s = $('[name="checkbox[]"]:checked');
            if (s.length == 0) {
                alert('Please select a Product !');
                return false;
            }
            if (s.length > 1) {
                alert('Please select Only One Product !');
                return false;
            }
            var pp = 0;
            var Product_Info_Id = 0;

            s.each(function () {
                //we will edit only first one in case of multiple selction
                if (pp == 0)
                    Product_Info_Id = $(this).val();
                pp++;
            });


            var url = '<?php echo base_url(); ?>index.php/product/edit_product/' + Product_Info_Id + '';
            $.ajax({
                type: 'POST',
                url: url,
                beforeSend: function (req) {
                    $('.loading_middle').show();
                },
                success: function (html)
                {
                    $('#editModal').html(html);
                    $('.loading_middle').hide();
                    $('#editModalButton').click();
                    $("button.closeButton").click(function () {
                        $(".modal-backdrop").click();
                    });
                    $("#validation2").validate();

                    $("#Product_Info_Purchase_edit").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "dd-mm-yy"
                    });

                    $("#Product_Info_Expire_edit").datepicker({
                        changeMonth: true,
                        changeYear: true,
                        dateFormat: "dd-mm-yy"
                    });


                },
                error: function ()
                {
                    $('.loading_middle').show();
                }
            });


        }
    }



    function selectSinglePerson()
    {

        var s = $('[name="checkboxPerson[]"]:checked');
        if (s.length == 0) {
            alert('Please select a Person !');
            return false;
        }
        if (s.length > 1) {
            alert('Please select Only One Person !');
            return false;
        }
        var pp = 0;
        var User_Info_Id = 0;

        s.each(function () {
            //we will edit only first one in case of multiple selction
            if (pp == 0)
                User_Info_Id = $(this).val();
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
        var url = '<?php echo base_url(); ?>index.php/person/selectPerson/';
        $.ajax({
            type: 'POST',
            url: url,
            beforeSend: function (req) {
                $('.loading_middle').show();
            },
            success: function (html)
            {
                $('#personModal .modal-body').html(html);
                $('.loading_middle').hide();
                $('.closeButton').click();
                $('.personModalButton').click();
                $('#dataTablePerson').DataTable();

                $(".checkboxId").click(function () {
                    if ($(this).is(':checked'))
                        $(this).parent().parent().addClass('active');
                    else
                        $(this).parent().parent().removeClass('active');
                });


            },
            error: function ()
            {
                $('.loading_middle').show();
            }
        });

    }


</script>   

<div class="row-fluid topWrapper">

    <div class="span12">
        <?php if ($msg != '') echo $msg; ?>
        <h3>Agent Bonus Statement</h3>
        <div class="buttonDiv">
            <div class="btn-group">
                <button class="btn btn-success" type="button" id="addModalButton" data-toggle="modal" data-target="#addModal"><span class="icon-plus-sign"></span>&nbsp;Add Product</button>

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
            <table border="0" cellpadding="5" cellspacing="5">
                <tbody><tr>
                        <td>Minimum Balance:</td>
                        <td><input id="min" name="min" type="text"></td>
                    </tr>
                    <tr>
                        <td>Maximum Balance:</td>
                        <td><input id="max" name="max" type="text"></td>
                    </tr>
                </tbody></table>
            <?php
            showdataTable($bonusList);
            ?>

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
                <h4 class="modal-title" id="myModalLabel"><span class="icon-plus-sign"></span>Add New Product</h4>
            </div>
            <div class="modal-body">
                <form id="validation" class="bs-example bs-example-form" method="post" enctype="multipart/form-data" action="<?php echo base_url() . "product/submit/"; ?>">
                    <div class="input-group">
                        <span class="input-group-addon">Category</span>
<?php echo $CategorySelectBox; ?>
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
                        <input type="text" value="<?php echo date("d-m-Y"); ?>" name="Product_Info_Purchase" id="Product_Info_Purchase" maxlength="30" class="form-control required" placeholder="Purchase Date"/>[DD-MM-YYYY]
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
                        <span class="input-group-addon">Product Description</span>
                        <textarea class="form-control" cols="50" rows="3" name="Product_Info_Description"></textarea>
                    </div>




                    <div class="input-group">
                        <span class="input-group-addon">Store Person</span>
                        <input type="text" id="personName" readonly name="Person_Info"  class="form-control" placeholder="No Person Selected"/>
                        <button onClick="selectPerson();" class="btn btn-success" type="button">Select Person&nbsp;</button>
                        <input style="display:none;" type="text" id="personId" name="F_User_Info_Id" maxlength="20" class="form-control required"/>
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


<?php include_once "headerfooter/footer.php"; ?>