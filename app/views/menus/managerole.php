<!DOCTYPE html>
<html lang="en">
<?php
include('./././public/dash/layout/alert.php'); 
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');

?>
<!-- Datatable Css -->
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">  

<style>

    .switch-field {
            /* display: flex;
            margin-bottom: 36px; */
            overflow: hidden;
        }

        .switch-field input {
            position: absolute !important;
            clip: rect(0, 0, 0, 0);
            height: 1px;
            width: 1px;
            border: 0;
            overflow: hidden;
        }

        .switch-field label {
            background-color: #e4e4e4;
            color: rgba(0, 0, 0, 0.6);
            font-size: 14px;
            line-height: 1;
            text-align: center;
            padding: 6px 12px;
            margin-right: -1px;
            border: 1px solid rgba(0, 0, 0, 0.2);
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.3), 0 1px rgba(255, 255, 255, 0.1);
            transition: all 0.1s ease-in-out;
        }

        .switch-field label:hover {
            cursor: pointer;
        }

        .switch-field input:checked+label {
            background-color: #a5dc86;
            box-shadow: none;
        }

        .switch-field label:first-of-type {
            border-radius: 4px 0 0 4px;
        }

        .switch-field label:last-of-type {
            border-radius: 0 4px 4px 0;
        }

        /* This is just for CodePen. */

        .form {
            max-width: 600px;
            font-family: "Lucida Grande", Tahoma, Verdana, sans-serif;
            font-weight: normal;
            line-height: 1.625;
            margin: 8px auto;
            padding: 16px;
        }

        h2 {
            font-size: 18px;
            margin-bottom: 8px;
        }

        .container2 {
            width: 100%;
            border: 1px solid #d3d3d3;
        }

        .container2 div {
            width: 100%;
        }

        .container2 .header {
            background-color: #d3d3d3;
            padding: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .container2 .administrator {
            background-color: #f2f2f2;
            padding: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .container2 .employee {
            background-color: #f2f2f2;
            padding: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .container2 .report {
            background-color: #d3d3d3;
            padding: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .container2 .admin_manage {
            background-color: #d3d3d3;
            padding: 8px;
            cursor: pointer;
            font-weight: bold;
        }

        .container2 .content {
            display: none;
            padding: 5px;
        }

        #user_management tr>td:last-child {
            text-align: right;
        }
        .switch-field{
            text-align: right;
        }
        .accordion .card {
	margin-bottom: 0.5rem;
	border: 0;
	border-radius: 0;
}
.accordion .card .card-header {
	cursor: pointer;
	background-color: #ccc;
	position: relative;
	border: 0;
	margin-bottom: 0;
	padding: 0.75rem 1.25rem 0.75rem 2.5rem;
}
.accordion .card .card-header:before {
	display: inline-block;
	font-style: normal;
	font-variant: normal;
	text-rendering: auto;
	-webkit-font-smoothing: antialiased;
	content: "\f067";
	font-family: "Font Awesome 5 Free";
	font-weight: 900;
	position: absolute;
	left: 1rem;
	top: 50%;
	transform: translateY(-50%);
}
.accordion .card .card-header.open:before {
	content: "\f068";
}
.accordion .card .card-header h5 {
	font-size: 18px;
	font-weight: normal;
	margin-bottom: 0;
}

</style>


<div class="main-content">

    <div class="page-content">
        <div class="container-fluid mbl_view page_content_up">
            <div class="row ">
                <div class="col-12">
                    <div class="card " style="width: 100%;">
                        <div class="card-header card_header_color">Manage Role</div>
                            <div class="card-body">
                                <div class="alert alert-danger alert-dismissible fade show disable_this" role="alert" id="display_error">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>

                                <form class="forms-sample " id="role_form" name="role_form" method="POST" action="">
                                    <!-- Use hidden text box for storing configid - used at the time of updation and deletion -->
                                    <input type="hidden" id="role_id" name="role_id">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class=" col-form-label required">Enter User Type</label>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <select class="form-select" name="usertypeid" id="usertypeid" onchange="get_rolename_basedon_usertype()">
                                                        <option value=''>--- Select category ---</option>
                                                        <?php
                                                        $Basemodel = new Basemodel;
                                                        $Basemodel->tablename = "mybillmyright.mst_usertype";
                                                        
                                                        $id = 'usertypeid';
                                                        $data = ($Basemodel->getMultipleData($status, $id));
                                                        foreach ($data as $value) { ?>
                                                            <option value="<?= htmlspecialchars($value->usertypecode); ?>"><?= htmlspecialchars($value->usertypelname); ?></option>
                                                        <?php } ?>

                                                    </select>  
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <label class=" col-form-label required">Role Name</label>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <select class="form-select" name="roleid"
                                                        id="roleid" onchange="role_change()">
                                                        <option value=''>-- Select Roles --</option>
                                                
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    


                                   
                                    <div class="row">
                                        <div class="col-md-6">
                                            <label class=" col-form-label required">Category</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                           
                                            <div class="container2">
                                                <?php 
                                                $Basemodel = new Basemodel;
                                                $Basemodel->tablename = "mybillmyright.mst_menu";
                                                $del = array('status'=>'Y');
                                                $select = "mybillmyright.mst_menu.menuname,mybillmyright.mst_menu.menuurl,mybillmyright.mst_menu.status,mybillmyright.mst_menu.menuid,mybillmyright.mst_menu.parentid,mybillmyright.mst_menu.levelid,mybillmyright.mst_menu.key";
                                                $data = array();
                                                $id = 'menuname';
                                                $status_flag = array('Y' => 'Active', 'N' => 'InActive');
                                                $data = $Basemodel->getMultipleJoin($select, $data, $del, $id);?>
                                                <div class="accordion" id="accordionExample">
                                                        <?php
                                                        foreach ($data as $value) 
                                                        {
                                                            $parent = $value->menuid;
                                                            $menuname = $value->menuname;
                                                            if ($value->levelid == 1) 
                                                            {
                                                                $Basemodel->tablename = "mybillmyright.mst_menu";
                                                                $del = array('parentid' => $parent, 'levelid' => 2 ,'status'=>'Y');
                                                                $select = "mybillmyright.mst_menu.menuname,mybillmyright.mst_menu.menuurl,mybillmyright.mst_menu.status,mybillmyright.mst_menu.menuid,mybillmyright.mst_menu.parentid,mybillmyright.mst_menu.levelid,mybillmyright.mst_menu.key";
                                                                $data_st = array();
                                                                $id = 'menuname';
                                                                $status_flag = array('Y' => 'Active', 'N' => 'InActive');
                                                                $data1 = $Basemodel->getMultipleJoin($select, $data_st, $del, $id);
                                                                
                                                                if($data1!=null)
                                                                {
                                                                    ?>
                                                                
                                                                        <div class="accordion-item">
                                                                            <h2 class="accordion-header" >
                                                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#menu<?php echo htmlspecialchars($value->menuid) ?>" aria-expanded="false"  aria-controls="menu<?php echo htmlspecialchars($parent);?> ">
                                                                                <?= htmlspecialchars($value->menuname); ?>
                                                                                </button>
                                                                            </h2>
                                                                            <div id="menu<?php echo htmlspecialchars($parent);?>" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                                                                                <div class="card-body">
                                                                                    <table class="table table-striped">
                                                                                        <thead>
                                                                                            <tr>
                                                                                                <th>Subcategory</th>
                                                                                                <th class="text-end">privileges</th>
                                                                                            </tr>
                                                                                        </thead>
                                                                                        <tbody>
                                                                                                        <?php
                                                                                                

                                                                                                foreach ($data1 as $value1) 
                                                                                                {?>
                                                                                                    <tr>
                                                                                                        <td><?php echo htmlentities($value1->menuname);  ?></td>
                                                                                                        <td>
                                                                                                            <div class="switch-field"> <?php

                                                                                                                if((($value1->menuid == 115)||($value1->menuid == 116)))
                                                                                                                {?>
                                                                                                                    <input type="radio" id="<?php echo htmlentities($value1->key) ?>-one" name="<?php echo htmlentities($value1->key) ?>" value="1" checked /> <?php
                                                                                                                }
                                                                                                                else
                                                                                                                {?>
                                                                                                                    <input type="radio" id="<?php echo htmlentities($value1->key) ?>-one" name="<?php echo htmlentities($value1->key) ?>" value="1"   /><?php

                                                                                                                } ?>
                                                                                                                <label for="<?php echo htmlentities($value1->key) ?>-one" >Yes</label><?php
                                                                                                                    if(!(($value1->menuid == 115)||($value1->menuid == 116)))
                                                                                                                    {?>
                                                                                                                        <input type="radio" id="<?php echo htmlentities($value1->key) ?>-two" name="<?php echo htmlentities($value1->key) ?>" value="0" checked />
                                                                                                                        <label for="<?php echo htmlentities($value1->key) ?>-two">No</label><?php
                                                                                                                    } ?>
                                                                                                                
                                                                                                            </div>
                                                                                                        </td>
                                                                                                    </tr>
                                                                                                    
                                                                                                    <?php
                                                                                                }?>
                                                                                            </tbody>
                                                                                        </table>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <?php
                                                                }
                                                                else
                                                                continue;
                                                                                            
                                                                
                                                            }
                                                        }?>
                                                </div>
                                            </div>
                                            <div class="mb-3"></div>
                                            <div style="text-align: center; ">
                                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                                <input type="hidden" name="action" id="action" value="update" />
                                                <input type="submit" name="button_action" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Submit" id="button_action" class="btn button_save" value="Update" />
                                                <button type="reset" class="btn btn-danger" onclick="reset_role_form()">clear</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    
                        <div class="card  shadow mb-2 " id="card_role">
                            <div class="card-header card_header_color"> List of Role Details  </div>
                            <div class="card-body">
                                <div class="mb-3"></div>
                                <div id="datatables" ></div>
                            </div>
                        </div>
                    </div>
                    <span class="text_redcolour">*Marked fields are mandatory</span>
                <div class="mb-3"></div>
            </div>
        </div> <!-- container-fluid -->
    </div>



    <?php include('./././public/dash/layout/footer.php'); ?>


</div>

    <script src="<?php echo URLROOT; ?>public/site/js/custom_validate.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap4-toggle@3.6.1/js/bootstrap4-toggle.min.js"></script>


    
	<!-- Datatable JS -->
	<script src="<?php echo URLROOT; ?>public/dash/cdn/js/datatables.min.js" defer="defer"></script>

    <script>
        $(".collapser").on("click", function () 
        {
            $(this).toggleClass("collapsed open");
            $(this).next().collapse("toggle");
        });



        function get_rolename_basedon_usertype()
        {
            var user_type=$('#usertypeid').val();
            if(user_type)
            {
                $.ajax({
                url: '<?php echo URLROOT; ?>/Menu/get_rolename_basedon_usertype',
                type: 'POST',
                data: {
                    user_type: user_type,
                },
                dataType: 'json',
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        
                        $("#roleid").empty();
                        $("#roleid").append(" <option value=''>--- Select Role Name---</option> ");
                        for (var i = 0; i < data.length; i++) 
                        {         
                            $("#roleid").append("<option value='" + data[i]['roleid'] + "'>" + data[i]['rolelname'] + "</option>");
                        }
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
          
        }

        function role_change() 
        {
            var roleid = $("#roleid").val();
            var user_type=$('#usertypeid').val();
            $('#role_form')[0].reset();
            $("#roleid").val(roleid);
            $('#usertypeid').val(user_type);


            if(roleid)    
            {
                $.ajax({
                    url: '<?php echo URLROOT; ?>/Menu/editrole',
                    type: 'POST',
                    data: {
                        edit_role: roleid,
                        csrf    :   $('#csrf').val()
                    },
                    dataType: 'json',
                    success: function(data, textStatus, jqXHR) 
                    {
                        if(jqXHR.status=='200')
                        {
                            fetch_data();
                            for (var i = 0; i < data.length; i++) 
                            {
                                if(!(data[i]=='dashboard'))
                                {
                                    document.getElementById((data[i] + '-one')).checked = true;

                                }
                            }
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
            else
            $('#card_role').hide();
            
            

        }

        function fetch_data() 
        {
            
            role_id=$('#roleid').val();

            if(roleid=='')
                $('#card_role').hide();
            else
            {
                $('#card_role').show();
                $.ajax({
                url: '<?php echo URLROOT; ?>/Menu/role_data',
                paging: "true",
                type: 'POST',
                data: {
                    role_id: role_id,
                    // csrf    :   $('#csrf').val()
                },

                dataType: "html",
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        if(data==0)
                            $('#card_role').hide();
                        else
                        {
                            $('#card_role').show();
                            $('#datatables').html(data);
                            $('#datatables-basic').DataTable();
                        }
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
               
           
        }


        var valiator = $('#role_form').validate({
            errorClass: "my_error",
            // Specify validation rules
            rules: {
                roleid: {
                    required: true
                },
            },
            // Specify validation error messages
            messages: {
                roleid: "Select a Role",
            },
            highlight: function (element, errorClass) {
                $(element).removeClass(errorClass); //prevent class to be added to selects
            },
            submitHandler: function (form) 
            {
                event.preventDefault();
                var form_data = $('#role_form').serialize(); // All form data in a form_data variable.
                var e = document.getElementById('roleid');
                var role_name   =   e.options[e.selectedIndex].text;


                $.ajax({
                    url: "<?php echo URLROOT; ?>/Menu/update_role",
                    dataSrc: "active",
                    method: "POST",
                    data: form_data,
                    success: function(data, textStatus, jqXHR) 
                    {
                        if(jqXHR.status=='200')
                        {
                            $("#error").hide();
                            passing_alert_value('Confirmation', 'Role has been Updated Successfully for '+role_name, 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
                            $('#role_form')[0].reset();

    	                    $('.accordion-collapse.show').collapse('hide');	

                            $("#roleid").empty();
			                $("#roleid").append(" <option value=''>--- Select Role Name---</option> ");

                            fetch_data();
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
        });
    </script>

</body>

</html>