<!DOCTYPE html>
<html lang="en">
<?php include('./././public/site/layouts/header.php');
include('./././public/dash/layout/alert.php');
__DIR__
?>

<head>
    <meta charset="utf-8">
    <title>Online Nurse Transfer</title>
    <link href="<?php echo URLROOT; ?>public/dash/css/modern.css" rel="stylesheet">
    <link href="<?php echo URLROOT; ?>public/dash/css/custom.css" rel="stylesheet">

    <style>
        @keyframes loaderCircle {}

        @keyframes loaderSize {
            0% {
                transform: scale(1) rotate(0);
            }

            16% {
                transform: scale(0) rotate(0);
            }

            50% {
                transform: scale(1) rotate(0);
            }

            80% {
                transform: scale(1) rotate(-360deg);
            }

            100% {
                transform: scale(1) rotate(-360deg);
            }
        }

        @keyframes loaderColor {
            5% {
                color: #9356DC;
            }

            10% {
                color: #FF79DA;
            }

            39% {
                color: #FF79DA;
            }

            40% {
                color: #99E2D0;
            }

            70% {
                color: #99E2D0;
            }

            80% {
                color: #9356DC;
            }

            100% {
                color: #9356DC;
            }
        }
    </style>
</head>

<body class="">
    <div class="wrapper ">
        <?php
        $Etransfer = new Etransfer;
        //    $active = $Etransfer->permissionID();
        include('./././public/site/layouts/sidebar.php'); ?>
        <div class="main">
            <nav class="navbar navbar-expand " style="background-color: #0262af ! important;">
                <a class="sidebar-toggle ">
                    <i class="fas fa-bars fa-lg align-self-center" style="color:white"></i>
                </a>
                <div class="navbar-collapse collapse">
                    <ul class="navbar-nav ms-auto">

                        <li>
                            <h3 style="color:white;margin-top: 20px;"> <?php print_r($_SESSION['user']->name); ?> </h3>
                        </li>
                        <li class="nav-item dropdown ms-lg-2">
                            <a class="nav-link dropdown-toggle position-relative " href="#" id="userDropdown" data-bs-toggle="dropdown">
                                <i class="align-middle fas fa-user me-3" style="color:white"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end " aria-labelledby="userDropdown">

                                <a class="dropdown-item" href="<?= URLROOT; ?>Etransfer/logout"><i class="align-middle me-1 fas fa-fw fa-arrow-alt-circle-right"></i> Sign out </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </nav>
            <main class="content">
                <div class="container-fluid MB-2">
                    <div class="header">

                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="card  shadow mb-2">
                                <div class="card-body">
                                    <div class="card  shadow mb-2 hide_this" id="assign_charge_card">
                                        <div class="card-header card_header_color">Additonal Charge</div>
                                        <div class="card-body ">
                                            <form class="forms-sample " id="assigncharge_form" name="assigncharge_form" method="POST" action="">
                                                <!-- Use hidden text box for storing configid - used at the time of updation and deletion -->
                                                <input type="hidden" id="user" name="user">
                                                <input type="hidden" id="dist_code" name="dist_code">
                                                <input type="hidden" id="csrf" name="csrf" value="<?php echo $this->generateCSRF(); ?>">

                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <label class=" col-form-label required">Directorate Name</label>
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <select class="form-select " name="sel_office" id="sel_office" disabled>
                                                                    <option value=''>-- Select Directorate Name --</option>
                                                                    <?php
                                                                    $Basemodel = new Basemodel;
                                                                    $Basemodel->tablename = "nursecounsil.mst_office";
                                                                    $id = 'office_lname';
                                                                    $data = ($Basemodel->getMultipleData(array('status_flag' => 'Y'), $id));
                                                                    $office_code = $_SESSION['user']->office_code;
                                                                    echo $office_code;
                                                                    foreach ($data as $value) {
                                                                        if ($office_code == $value->office_code) { ?>
                                                                            <option value="<?= htmlspecialchars($value->office_code); ?>" selected><?= htmlspecialchars($value->office_lname . ' ( ' . $value->office_sname . ' )'); ?></option><?php
                                                                                                                                                                                                        } else { ?>
                                                                            <option value="<?= htmlspecialchars($value->office_code); ?>"><?= htmlspecialchars($value->office_lname . ' ( ' . $value->office_sname . ' )'); ?></option><?php

                                                                                                                                                                                                        }
                                                                                                                                                                                                    ?>

                                                                    <?php } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="dist_div">
                                                        <label class=" col-form-label required">District Name</label>
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <select id="sel_dist" name="sel_dist" class="form-select " disabled>
                                                                    <option value=''>--- All ---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 hide_this" id="hud_div">
                                                        <label class=" col-form-label select required">HUD Name</label>
                                                        <div class="form-group row">

                                                            <div class="col-sm-12">
                                                                <select name="sel_hud" id="sel_hud" class="form-select" disabled>
                                                                    <option value=''>--- All ---</option>

                                                                </select>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6" id="inst_div">
                                                        <label class=" col-form-label select required">Institution Name</label>
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <select name="sel_inst" id="sel_inst" class="form-select " disabled>
                                                                    <option value=''>--- All---</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class=" col-form-label select required">Employee Name</label>
                                                        <div class="form-group row">
                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control " name="get_emp_name" id="get_emp_name" disabled="disabled" />
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="col-md-6">
                                                        <label class=" col-form-label select required">Additional Charge</label>
                                                        <div class="form-group row">

                                                            <div class="col-sm-12">
                                                                <select class="form-select select2" name="assign_charge[]" id="assign_charge" data-bs-toggle="select2" multiple require>

                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <label class=" col-form-label required">Effect From</label>
                                                        <div class="form-group row">

                                                            <div class="col-sm-12">
                                                                <input type="text" class="form-control " name="charge_from" id="charge_from" disabled="disabled" />

                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="mb-3"></div>

                                                    <!-- Modal Footer with action button and close button -->
                                                    <div style="text-align: center; ">
                                                        <input type="hidden" name="hidden_id" id="hidden_id" />
                                                        <input type="hidden" name="action" id="action" value="insert" />
                                                        <input type="submit" name="button_action" id="button_action" class="btn" style="background-color:#0262af;color:white;" value="Assign Charge" />
                                                        <a class="btn btn-danger" onclick="form_close()">Close</a>
                                                    </div>
                                                    <div class="mb-3"></div>

                                                </div>
                                            </form>
                                        </div>
                                    </div>

                                    <br><br>

                                    <div class="card">
                                        <div class="card-header card_header_color">Additional Charge User Details</div>
                                        <div class="card-body">
                                            <div id="datatables"></div>
                                            <br>
                                            <span class="text_redcolour">*Marked fields are mandatory</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </main>
            <?php include('./././public/dash/layout/footer.php'); ?>
        </div>
    </div>
</body>


<script src="<?php echo URLROOT; ?>public/dash/js/app.js"></script>
<script src="<?php echo URLROOT; ?>public/dash/js/settings.js"></script>
<script src="<?php echo URLROOT; ?>public/dash/js/custom_js.js"></script>
<?php include('./././public/dash/common/jsfn.php'); ?> 


<script>
    fix_date_format();

    function fix_date_format() {
        var today = new Date();
        var date = today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
        document.getElementById("charge_from").value = date;
    }



    $(".select2").each(function() {
        $(this)
            .wrap("<div class=\"position-relative\"></div>")
            .select2({
                placeholder: "Select Assign Charge",
                dropdownParent: $(this).parent()
            });
    })


    


    function enable_field_basedon_usertype(office_code, value) {

        if (office_code == '')
            office_code = $('#sel_office').val();

        if (value == '')
            value = $('#user_type').val();
        if (value == 3) {
            if (office_code == '04') {
                $('#hud_div').show();
                $('#dist_div').hide();
            } else {
                $('#hud_div').hide();
                $('#dist_div').show();
            }
            $('#inst_div').hide();
        } else if (value == 4) {
            $('#inst_div').show();
            if (office_code == '04') {
                $('#dist_div').hide();
                $('#hud_div').show();
            } else {
                $('#dist_div').show();
                $('#hud_div').hide();
            }
        } else if (value == 5) {
            $('#inst_div').hide();
            $('#dist_div').hide();
            $('#hud_div').hide();
        }
    }





    function form_close() {
        $('#assign_charge_card').hide();
        reset_form();
    }

    function reset_form() {
        valiator.resetForm();
        $('#assigncharge_form')[0].reset();

        $('#sel_inst').val('');
        $('#get_emp_name').empty();
        $('#sel_office').val('');
        $('#sel_dist').val('');
        $('#assign_charge').val('');
        $("#sel_inst").empty();
        $("#sel_dist").empty();
        $("#sel_dist").append(" <option value=''>--- Select District Name---</option> ");
        $('#assign_charge').val('').trigger('change');
        fix_date_format();

    }


    function get_asssign_charge(office_id, dist_id,hud_code, inst_id, usertype_id, charge_array) 
    {
        csrf=$('#csrf').val();

        $("#assign_charge").empty();
        $("#assign_charge").append(" <option value=''>--- Select Assign Charge---</option> ");
        $.ajax({
            url: '<?php echo URLROOT; ?>/User_management/get_assign_charge',
            type: 'POST',
            data: {
                dist_code: dist_id,
                hud_code    :   hud_code,
                inst_code: inst_id,
                directorate: office_id,
                usertype_id: usertype_id,
                csrf    :   csrf

            },
            dataType: 'json',
            success: function(data, textStatus, jqXHR) 
            {
                if(jqXHR.status=='200')
                {
                    $("#assign_charge").empty();
                    $("#assign_charge").append(" <option value=''>--- Select Assign Charge---</option> ");
                    if (!(data == null)) {
                        var len = data.length;
                        let fLen = charge_array.length;
                        for (var i = 0; i < len; i++) {
                            var charge_id = data[i]['charge_id'];
                            var charge_code = data[i]['charge_description'];
                            var present_or_not = charge_array.includes(data[i]['charge_id']);
                            if (!(present_or_not == true))
                                $("#assign_charge").append("<option value='" + charge_id + "'>" + charge_code + "</option>");
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



    function fetch_data() 
    {
        $.ajax({
            url: '<?php echo URLROOT; ?>/User_management/assigned_user_data',
            paging: "true",
            dataType: "html",
            type: 'POST',
            data: {
                csrf    :   $('#csrf').val()
            },
            success: function(data, textStatus, jqXHR) 
            {
                if(jqXHR.status=='200')
                {
                    if(data=='No_data')
                        $('#datatables').html('<br><center>No Data Available</center>');
                    else
                    {
                        $('#datatables').html(data);
                        $('#datatables-basic').DataTable({
                            pageLength: 5,
                            lengthMenu: [
                                [5, 10, 20, -1],
                                [5, 10, 20, 'All']
                            ],
                        });      
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
    fetch_data();







    var valiator = $('#assigncharge_form').validate({


        // Specify validation rules
        rules: {
            sel_office: {
                required: true
            },
            sel_dist: {
                required: true
            },
            sel_inst: {
                required: true
            },
            get_emp_name: {
                required: true
            },
            "assign_charge[]": {
                required: true
            }
        },
        // Specify validation error messages
        messages: {
            sel_office: "Select Directorate Name",
            sel_dist: "Select District Name",
            sel_inst: "Select Institution Name",
            get_emp_name: "Select Employee Name",
            assign_charge: "Select Assign Charge",
            "assign_charge[]": "Select Charge",
        },
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass); //prevent class to be added to selects
        },
        errorPlacement: function(error, element) {
            if (element.hasClass('select2') && element.next('.select2-container').length) {
                error.insertAfter(element.next('.select2-container'));
            }
            // } else if (element.parent('.input-group').length) {
            //     error.insertAfter(element.parent());
            // }
            // else if (element.prop('type') === 'radio' && element.parent('.radio-inline').length) {
            //     error.insertAfter(element.parent().parent());
            // }
            // else if (element.prop('type') === 'checkbox' || element.prop('type') === 'radio') {
            //     error.appendTo(element.parent().parent());
            // }
            // else {
            //     error.insertAfter(element);
            // }
        },
        submitHandler: function(form) {
            event.preventDefault();
            var form_data = $('#assigncharge_form').serializeArray();
            var office_code = $('#sel_office').val();
            form_data.push({
                name: "directorate",
                value: $('#sel_office').val()
            });
            form_data.push({
                name: "institution",
                value: $('#sel_inst').val()
            });
            form_data.push({
                name: "user",
                value: $('#user').val()
            });
            form_data.push({
                name: "action",
                value: $('#action').val()
            });
            form_data.push({
                name: "page_name",
                value: 'additional_charge'
            });
            form_data.push({
                name: "district",
                value: $('#sel_dist').val()
            });
            form_data.push({
                name: "csrf",
                value: $('#csrf').val()
            });
            if (office_code == '04') {
                form_data.push({
                    name: "hud",
                    value: $('#sel_hud').val()
                });
            }


            $.ajax({
                url: "<?php echo URLROOT; ?>/User_management/insert_update_assigncharge",
                dataSrc: "active",
                method: "POST",
                data: form_data,

                success: function( data, textStatus, jqXHR) 
                    {
                        if(jqXHR.status=='200')
                        {
                            getting_buttion_action=$('#action').val();
                        
                            if (getting_buttion_action == 'insert') 
                            {
                                passing_alert_value('Confirmation', 'Charge has been Assigned Successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
                                fetch_data();
                                form_close() 
                            }
                          
                        }
                        
                    },
                    error: function (xhr, status, error) 
                    {
                        var err = JSON.parse(xhr.responseText);	
                        if(err.code==409)	
                        {
                            $("#display_error").show();
                            $('#display_error').html("Charge Already Exists");
                            show_box_in_redclr('sel_office','charge_role');
                        }
                        if(err.code==413)
                        {
                            alert('Extra characters included')
                        }	
                        if(err.code==403)
                        {
                            alert('csrf token invalid')
                            window.location.href = '<?php echo URLROOT; ?>';
                            
                        }	
                        if(err.code==424)	
                        {
                            alert('Charge Assigned But mail not sent')
                        }
                        if(err.code==406)	
                        {
                            alert('Not Accessible');
                        }
                    }
            });

        }
    });


    $(document).on('click', '.edit_assign_charge', function() {
        $('#error').hide();
        valiator.resetForm();
        var id = $(this).attr('id'); //Getting id of user clicked edit button.
        var action = 'fetch_single'; //Make as fetch single
        $('#userid').val(id);

        $.ajax({
            url: '<?php echo URLROOT; ?>/User_management/edit_assigned_charge/',
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
                    var len = response.length;
                    var charge_name = '';
                    for (var i = 0; i < len; i++) {
                        charge_name = charge_name.concat(response[i]['charge_description'], ", ")
                    }
                    charge_name = charge_name.slice(0, -2);
                    $('#assigned_charge').val(charge_name);
                    var charge_id = [];
                    for (var i = 0; i < len; i++) {
                        charge_id.push(response[i]['charge_id'])
                        // charge_id[i]=response[i]['charge_id'];
                    }
                    charge_id = Object.values(charge_id);

                    
                    getting_directorate_related_data(response[0]['office_code'], response[0]['dist_code'], response[0]['hud_code'], 'hud_div', 'sel_hud', 'dist_div', 'sel_dist', 'sel_inst', 'sel_office', 'sel_office');
                    if(response[0]['usertype_id'] == 4)
                        get_inst('sel_inst', response[0]['inst_id'], 'sel_dist', response[0]['dist_code'], 'sel_office', response[0]['office_code'], 'sel_hud', response[0]['hud_code']);
                    enable_field_basedon_usertype(response[0]['office_code'], response[0]['usertype_id']);
                    $('#dist_code').val(response[0]['dist_code']);
                    $('#sel_office').val(response[0]['office_code']);
                    $('#user').val(response[0]['user_id']);
                    get_asssign_charge(response[0]['office_code'], response[0]['dist_code'],response[0]['hud_code'],response[0]['inst_id'], response[0]['usertype_id'], charge_id);
                    $('#get_emp_name').val(response[0]['name']);    
                    $('#assign_charge_card').show();            
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