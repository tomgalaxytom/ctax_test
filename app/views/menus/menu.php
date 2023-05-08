<!DOCTYPE html>
<html lang="en">
<?php
include('./././public/dash/layout/alert.php'); 
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');

?>
<!-- Datatable Css -->
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">  



<div class="main-content">

    <div class="page-content">
        <div class="container-fluid mbl_view page_content_up">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body">
                                <div class="card disable_this shadow mb-2 " id="Menu_form_card">
                                    <div class="card-header card_header_color"> Create Menu </div>

                                    <div class="card-body ">
                                        <div class="alert alert-danger alert-dismissible" id="error" style="display:none;" name="error">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                        </div>

                                        <form class="forms-sample " id="privillage_form" name="privillage_form" method="POST" action="">
                                            <div class="alert alert-danger alert-dismissible" id="error" style="display:none;" name="error">
                                                <a href="#" cl+ass="close" data-dismiss="alert" aria-label="close">&times</a>
                                            </div>
                                            <!-- Use hidden text box for storing configid - used at the time of updation and deletion -->
                                            <input type="hidden" id="menuid" name="menuid">


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class=" col-form-label required">Menu Name</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control " name="menu" id="menu" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class=" col-form-label required">Menu URL</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control " name="menu_url" id="menu_url" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class=" col-form-label required">Key Slug</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <input type="text" class="form-control" name="key" id="key" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label class=" col-form-label select required">Category/Subcategory</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <select name="cat_sub" id="cat_sub" class="form-select" onchange="enable_cat('')">
                                                                <option value=''>--- Select Category/subcategory Name---</option>
                                                                <option value='1'> category </option>
                                                                <option value='2'> Sub category </option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class=" col-form-label select required">Category Name</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <?php
                                                             $Basemodel = new Basemodel;
                                                             $Basemodel->tablename = "mybillmyright.mst_menu";
                                                             $status = array('levelid' => 1);
                                                             $id = 'menuname';
                                                             $data = ($Basemodel->getMultipleData($status, $id));
                                                            
                                                             ?>
                                                            <select class="form-select" name="cat_name" id="cat_name" disabled="disabled">
                                                                <option value=''>--- Select category ---</option>
                                                                <?php
                                                               
                                                                foreach ($data as $value) { ?>
                                                                    <option value="<?= htmlspecialchars($value->menuid); ?>"><?= htmlspecialchars($value->menuname); ?></option>
                                                                <?php } ?>

                                                            </select>


                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class=" col-form-label required">Status</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status_flag" id="active" value="active" checked>
                                                                <label class="form-check-label" for="inlineRadio1">Active</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="radio" name="status_flag" id="inactive" value="inactive" <label class="form-check-label" for="inlineRadio2">Inactive</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mb-3"></div>

                                            <!-- Modal Footer with action button and close button -->

                                            <div style="text-align: center; ">
                                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                                <input type="hidden" name="action" id="action" value="insert" />
                                                <input type="submit" name="button_action" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Submit" id="button_action" class="btn button_save" value="Save" />
                                                <button type="reset" class="btn btn-danger" onclick="reset_menuform()" id="1">clear</button>
									        </div>


                                            <!-- <div style="text-align: center; ">
                                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                            <input type="hidden" name="action" id="action" value="insert" />

                                            <input type="Save" name="button_action" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Submit" id="button_action" class="btn button_save" value="Save" />
                                            <button type="reset" class="btn btn-danger"  onclick="reset_menuform()" id="1">clear</button>
                                            </div> -->
                                            <div class="mb-3"></div>

                                        </form>

                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header card_header_color"> Menu Details </div>
                                    <div class="card-body">
                                        <div id="datatables"></div>
                                        <br>
                                        <span style="color:#ff0000; font-size:80%!important;">*Marked fields are mandatory</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div> <!-- container-fluid -->
    </div>



    <?php include('./././public/dash/layout/footer.php'); ?>


</div>

<!-- Datatable JS -->
<script src="<?php echo URLROOT; ?>public/dash/cdn/js/datatables.min.js" defer="defer"></script>


<script src="<?php echo URLROOT; ?>public/site/js/custom_validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script>

        var nic_roleid	=	'<?php echo $this->nic_roletypecode ?>';
      <?php  $session	=	$this->session_details(); 
		$session_roleid	=	$session[0]->roletypecode;?>
        session_roleid='<?php echo $session_roleid?>';

        window.onload = function() 
        {
            fetch_data();
        };

        function reset_menuform()
        {
            valiator.resetForm();
            $('#action').val('insert');
            $('#button_action').val('Save');
            document.getElementById('button_action').style.backgroundColor ='#56a1e3';
            document.getElementById('button_action').style.color = "#FFFFFF";

        }




        function enable_cat(value) 
        {
            if ($('#cat_sub').val() == '') 
            {
                passing_alert_value('Alert', 'Please select category/subcategory option', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
                $("#cat_name").attr("disabled", "disabled");

            } 
            else 
            {
                if ($('#cat_sub').val() == 1) 
                {
                    $("#cat_name").attr("disabled", "disabled");
                    $("#cat_name").val('');
                } 
                else 
                    $("#cat_name").removeAttr("disabled");
            }
            
        }

        function fun_close()
        {
            valiator.resetForm();
            
        }

		function fetch_data() 
        {
			$.ajax({
				url: '<?php echo URLROOT; ?>/Menu/getting_menus_data',
				paging: "true",
				dataType: "html",
                type	: 'POST',
                data	:{
                    csrf    :   $('#csrf').val()
                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        if(nic_roleid == session_roleid)
                        {
                            $('#Menu_form_card').show();
                        }
                        else
                        {
                            $('#Menu_form_card').hide();
                        }

                        $('#datatables').html(data);
                        $('#datatables-basic').DataTable(
                        {
                            pageLength : 5,
                            lengthMenu: [[5, 10, 20,25, -1], [5, 10, 20,25, 'All']]
                        });
                    }
				},
                error: function (xhr, status, error) 
                {
                    var err = JSON.parse(xhr.responseText);		

                    if(err.code==413)
                    {
                        // $("#display_error").show();
                        // $('#display_error').html("101_611 Please contact Admin");
                        alert('Extra characters included')

                    }	
                    if(err.code== 403)
                        alert('csrf token invalid')

                    if(err.code==400)
                        alert('Bad request');
                },
			});
		}
       

        var valiator = $('#privillage_form').validate({


            // Specify validation rules
            rules: {
                menu: {
                    required: true
                },
                menu_url: {
                    required: true
                },
                cat_sub: {
                    required: true
                },
                cat_name: {
                    required: true
                },
                key: {
                    required: true
                },
            },
            // Specify validation error messages
            messages: {
                menu:"Enter Menu Name",
                key:"Enter Menu key ",
                menu_url:"Enter Menu URL",
                cat_sub:"Select Cateory or Sub Category",
                cat_name:"Select Cateory Name",
            },
            highlight: function(element, errorClass) 
            {
                $(element).removeClass(errorClass); //prevent class to be added to selects
            },
            errorPlacement: function(error, element) 
            {
                if(element.parent('.input-group').length) 
                {
                    error.insertAfter(element.parent());
                }
                else
                {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) 
            {
                event.preventDefault();
                var form_data = $('#privillage_form').serialize(); // All form data in a form_data variable.
             
                $.ajax({
                    url: "<?php echo URLROOT; ?>/Menu/insert_update_menu",
                    dataSrc: "active",
                    method: "POST",
                    data: form_data,
                    success: function(data, textStatus, jqXHR) 
                    {
                        var menu = $('#menu').val();
                        if(jqXHR.status=='200')
                        {
                            getting_buttion_action=$('#action').val();
                            if(getting_buttion_action	==	'insert')
                            {
                                $("#error").hide();
                                $('#menu').css('border-color', '#ced4da');
                                $('#menu_url').css('border-color', '#ced4da');
                                passing_alert_value('Confirmation', menu+" - Menu has been added Successfully", 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
                                $('#privillage_form')[0].reset();
                                fetch_data();
                                $('#menu').focus();
                            }
                            else if(getting_buttion_action	==	'update')
                            {
                                $("#error").hide();
                                passing_alert_value('Confirmation', menu+" - Menu has been updated Successfully", 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
                                $('#menu').css('border-color', '#ced4da');
                                $('#menu_url').css('border-color', '#ced4da');
                                $('#privillage_form')[0].reset();
                                $('#action').val('insert');
                                $('#button_action').val('Submit');
                                fetch_data();
                            }
                        }
                    },
                    error: function (xhr, status, error) 
                    {
                        var err = JSON.parse(xhr.responseText);						
                        if(err.code==409)	
                        {
                            $("#error").show();
                                $('#error').html("Menu Already Exists");
                                document.getElementById('sel_state').focus();
                                $('#menu').css('border-color', 'red');
                                $('#menu_url').css('border-color', 'red');
                            
                        }
                        if(err.code==413)
                            alert('Extra characters included')

                        if(err.code== 403)
                            alert('csrf token invalid')

                        if(err.code== 406)
                            alert('Not Accessible')			
                    }                 
                });
            }
        });

        $(document).on('click', '.edit_privillage', function() 
        {
            $('#error').hide();
            var id = $(this).attr('id'); //Getting id of user clicked edit button.
            $('#menuid').val(id);
            $.ajax({
                url: '<?php echo URLROOT; ?>/Menu/edit_menu',
                type: 'POST',
                data: {
                    id: id,
                    csrf    :   $('#csrf').val()
                }, //passing id and action msg to the config_master_action.php file.
                dataType: 'json', //Response data type as json.
                success: function(response, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {     
                        $('#menu').val(response['menuname']);
                        $('#key').val(response['key']);
                        $('#menu_url').val(response['menuurl']);
                        $('#cat_sub').val(response['levelid']);
                        $('#cat_name').val(response['parentid']);
                    
                        if (response['status'] == 'Y') 
                            document.getElementById("active").checked = true;
                        else
                            document.getElementById("inactive").checked = true;

                        if(response['levelid'] == 1)
                        
                            $("#cat_name").attr("disabled", "disabled");
                        else
                            $("#cat_name").removeAttr("disabled");

                        $('#action').val('update');
                        $('#button_action').val('Update');
                        $('.card-heading').text('Edit Configure Master Data');
                    }
                },
                error: function (xhr, status, error) 
                {
                    var err = JSON.parse(xhr.responseText);		

                    if(err.code==413)
                    {
                        // $("#display_error").show();
                        // $('#display_error').html("101_611 Please contact Admin");
                        alert('Extra characters included')

                    }	
                    if(err.code== 403)
                        alert('csrf token invalid')

                    if(err.code==400)
                        alert('Bad request');                                 

                },
            });
        });
    </script>

</body>

</html>