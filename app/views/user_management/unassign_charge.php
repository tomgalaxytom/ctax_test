<!DOCTYPE html>
<html lang="en">
<?php 

include('./././public/site/layouts/header.php');
include('./././public/dash/layout/alert.php'); ?>
<head>
    <meta charset="utf-8">
    <title>Online Nurse Transfer</title>

    <link href="<?php echo URLROOT; ?>public/dash/css/modern.css" rel="stylesheet">
    <link href="<?php echo URLROOT; ?>public/dash/css/custom.css" rel="stylesheet">

</head>
<style>
#employee_details {
   z-index: 9997;
}

#confirmation_alert {
   z-index: 9998;    /* This will come above popup1*/
}
  </style>
<body class="">
<div class="wrapper ">
    <?php
    $Etransfer = new Etransfer;
    $active = '';
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
                            
                            <a class="dropdown-item" href="<?= URLROOT ;?>Etransfer/logout"><i class="align-middle me-1 fas fa-fw fa-arrow-alt-circle-right"></i> Sign out</a>
                        </div>
                    </li>
                </ul>
            </div>
        </nav>
        <main class="content">
            <div class="container-fluid MB-2">
                <div class="row">
                    <div class="col-12">
                        <div class="card" style="width: 100%;">
                            <div class="card-header card_header_color">Unassign Charge </div>
                            <div class="card-body">
                                <div class="alert alert-danger alert-dismissible" id="error"style="display:none;" name="error" >
                                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                </div>
                                <form class="forms-sample " id="trans_fwd" name="trans_fwd" method="POST" >
                                    <input type="hidden" id="action_code" name="action_code">
                                    <input type="hidden" id="is_it_unassign_charge" name="is_it_unassign_charge">

                                    <input type="hidden" id="csrf" name="csrf" value="<?php echo $this->generateCSRF(); ?>">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <?php
                                                $data=  $this->get_charge_assigned_usernames();

                                                    
                                                ?>
                                            <label class=" col-form-label required ">Select User Name</label>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <select class="form-select" name="user_id" id="user_id" onchange="get_selected_user_charge('')" >     
                                                        <option value=''> -- Select Employee Name -- </option>
                                                        <?php

                                                        foreach ($data as $value) 
                                                        {?>
                                                            <option value="<?= htmlspecialchars($value['user_id']); ?>"><?= htmlspecialchars($value['name']); ?></option><?php

                                                            // if($value['user_restriction']=='Y')
                                                            // {
                                                            // }
                                                          
                                                            // else
                                                            //     continue;
                                                          
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <label class=" col-form-label required">Select Charge</label>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <select name="sel_charge" id="sel_charge" class="form-select" onchange="get_assignedto_usernames()" >
                                                        <option value=''> -- Select Charge -- </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="hide_this col-md-4" id="empname_div">
                                            <label class=" col-form-label required ">Charge Assigned To </label>
                                            <div class="form-group row">
                                                <div class="col-sm-12">
                                                    <select class="form-select" name="assignedto_user_id" id="assignedto_user_id" >     
                                                        <option value=''> -- Select Employee Name -- </option>
                                                        <?php $Basemodel = new Basemodel;
                                                        $Basemodel->tablename = "nursecounsil.mst_user";
                                                        $id = 'user_id';
                                                        $data = ($Basemodel->getMultipleData(array('user_restriction'=>'Y'), $id));
                                                        foreach ($data as $value) 
                                                        {
                                                            if(($value->usertype_id==2)||($value->usertype_id==1))
                                                               continue;
                                                            else
                                                            {?>
                                                                <option value="<?= htmlspecialchars($value->user_id); ?>"><?= htmlspecialchars($value->name); ?></option><?php
                                                            }
                                                        } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                        <center><button type="button" class="btn btn-success text-center" id="unassign_btn" onclick="unassign_charge()" style="display:none">UnAssign</button></center>
                                </form>
                            </div>
                        </div>
                        <div  class="card disable_this" id="data_list">
                            <div class="card-header card_header_color"> List of Submitted Employee Details </div>
                            <div class="card-body">
                                <div id="datatables"></div>
                                    <center><input type="submit" class="btn btn-success " disabled value="Submit" onclick="fun_assign_charge_update_data()" id="assign_charge">
                                            <input type="reset" class="btn btn-danger " value="Cancel"  id="uncheck_button" onclick="uncheck()"></center>
                                <br>
                            </div>
                        </div>
                        <span style="color:#ff0000 ;font-size:80%!important;">*Marked fields are mandatory</span>
                    </div>
                </div>
            </div>
        </main>
        <?php include('./././public/dash/layout/footer.php'); ?>
    </div>
</div>
    
    <script src="<?php echo URLROOT; ?>public/dash/js/app.js"></script>
    <script src="<?php echo URLROOT; ?>public/dash/js/settings.js"></script>
    <script src="<?php echo URLROOT; ?>public/dash/js/custom_js.js"></script>
    <script>
        function get_selected_user_charge(user_id)
        {
            user_id=$('#user_id').val();

            $('#data_list').hide();
            $('#unassign_btn').hide();
            $('#sel_charge').val('');
            $('#assignedto_user_id').val('');

            $("#sel_charge").empty();
            $("#sel_charge").append(" <option value=''>--- Select Charge Name---</option> ");

            if(user_id!='')
            {
                $.ajax({
                    url: '<?php echo URLROOT; ?>/User_management/get_selected_user_charge',
                    type: 'POST',
                    data: {
                        user_id: user_id,
                        csrf    :   $('#csrf').val()
                    }, //passing id and action msg as fetch to the respective Controller page with function name.
                    dataType: 'json', //Response data type as json.
                    success: function(data, textStatus, jqXHR) 
                    {
                        if(jqXHR.status=='200')
                        {
                            var len = data.length;
                            for (var i = 0; i < len; i++) 
                            {
                                $("#sel_charge").append("<option value='" +  data[i]['charge_id'] + "'>" +  data[i]['charge_description'] + "</option>");
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
        function get_assignedto_usernames()
        {
            charge_id=$('#sel_charge').val();
            user_id=$('#user_id').val();

            $("#assignedto_user_id").empty();
            $("#assignedto_user_id").append(" <option value=''>--- Select Employee Name---</option> ");
            if(charge_id!='')
            {
                $.ajax({
                url: '<?php echo URLROOT; ?>/User_management/get_assignedto_usernames',
                type: 'POST',
                data: {
                    charge_id: charge_id,
                    user_id :user_id,
                    csrf    :   $('#csrf').val()
                }, //passing id and action msg as fetch to the respective Controller page with function name.
                dataType: 'json', //Response data type as json.
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        if(data[0]['status']=='success')
                        {
                            $('#action_code').val(data[0]['action_code']);
                            $('#data_list').show();

                            $('#datatables').html(data[0]['table_data']);
                                $('#datatables').DataTable({
                                    pageLength: 5,
                                    lengthMenu: [
                                        [5, 10, 20, -1],
                                        [5, 10, 20, 'All']
                                    ]
                                });
                                user_det=data[0]['assigned_to_userdet'];
                                var len = user_det.length;
                                for (var i = 0; i < len; i++) 
                                {
                                    $("#assignedto_user_id").append("<option value='" +  user_det[i]['user_id'] + "'>" +  user_det[i]['name'] + "</option>");
                                }
                                $('#empname_div').show();
                        }
                        else if(data[0]['status']=='Fail')
                        {
                            $('#data_list').hide();
                            $('#unassign_btn').show();
                            $('#empname_div').hide();
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

        function uncheck()
        {
        var myArray=[];
        $("input:checkbox[name=row_id]:checked").each(function() 
        {
            myArray.push(this.value);
        });
        for(i=0;i<myArray.length;i++)
        {
            document.getElementById(myArray[i]).checked = false;
            $("#sel_dist"+myArray[i]).val('');
            $("#action"+myArray[i]).val('');
            $("#sel_verifer"+myArray[i]).val('');
            $("#remark"+myArray[i]).val('');
            $("#sel_dist"+myArray[i]).attr("disabled", "disabled");
            $("#sel_verifer"+myArray[i]).attr("disabled", "disabled");
            $("#action"+myArray[i]).attr("disabled", "disabled");
            // $("#select_veri"+myArray[i]).hide();
            $("#remark"+myArray[i]).attr("disabled", "disabled");

        }
        $("#btnSubmit").attr("disabled", "disabled");
        $("#fwd_super_admin").attr("disabled", "disabled");
        
        $("#forward_button").attr("disabled", "disabled");
        $("#verify_button").attr("disabled", "disabled");
        $("#approve_emptrans_request").attr("disabled", "disabled");
        
        
        }

        $(document).on('click', '.get_employee_det', function() 
    {
      var id = $(this).attr('id');
      var per_id = [];
      var transaction_code=[];
      var input = document.getElementsByName('per_id[]');
      for (var i = 0; i < input.length; i++) 
      {
        var a = input[i];
        per_id.push(a.value);
      }
      var input = document.getElementsByName('transaction_code[]');
      for (var i = 0; i < input.length; i++) 
      {
        var a = input[i];
        transaction_code.push(a.value);
      }
      
      $('#hidden_rowid').val(id);
      var selected_perid=per_id[id];
      var process='';
         $("#btnSubmit").hide();
         $("#btn_cancel").hide();
         $("#btn_close").show();
    //   if((transaction_code[id]=='01'))
    //   {
    //     var process='emp_del';
    //     $("#btnSubmit").show();
    //     $("#btn_cancel").show();
    //     $("#btn_close").hide();Etransfer
    //   }
    //   else
    //   {
    //      var process='';
    //      $("#btnSubmit").hide();
    //      $("#btn_cancel").hide();
    //      $("#btn_close").show();
    //   }
      if(document.getElementById(id).checked == true)
          var check='Y';
      else
      var check='N';
              
    $.ajax
      ({
            url:'<?php echo URLROOT;?>/Etransfer/employee_details',
            type: 'POST',
            data:{
            id:selected_perid,
            process:process,
            checkbox_check : check,
            csrf    :   $('#csrf').val()
            },
            //passing id and action msg to the state_master_action.php file.
            dataType: 'html',
            paging:true,
            success: function(data, textStatus, jqXHR) 
            {
                if(jqXHR.status=='200')
                {
                    passing_alert_value('Employee Details', data, 'employee_details', 'employee_header', 'employee_body', 'confirmation_alert');
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
  function get_checkbox_value(value)
  {
      selected_checkboxid=[];
      $("input:checkbox[name=row_id]:checked").each(function() 
      {
            selected_checkboxid.push(this.value);
      });
      let checked_count = selected_checkboxid.length;
      if(checked_count>0)
      $('#assign_charge').removeAttr("disabled");
      else
      $("#assign_charge").attr("disabled", "disabled");

  }

  function fun_assign_charge_update_data()
  {
    if($('#assignedto_user_id').val()=='')
    {
        passing_alert_value('Confirmation', 'Select AssignedTo User Name', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
    }
    else
    {
        per_id=[];
      transaction_code=[];
      var input = document.getElementsByName('per_id[]');
      for (var i = 0; i < input.length; i++) 
      {
        var a = input[i];
        per_id.push(a.value);
      }
      var input = document.getElementsByName('transaction_code[]');
      for (var i = 0; i < input.length; i++) 
      {
        var a = input[i];
        transaction_code.push(a.value);
      }
      const form_data = [];

      user_id=$('#user_id').val();
      action_code=$('#action_code').val();
      sel_charge=$('#sel_charge').val();
      assignedto_user_id=$('#assignedto_user_id').val();
      

      form_data.push({
            name: "checked_checkboxid",
            value: selected_checkboxid
        });
        form_data.push({
            name: "csrf",
            value: $('#csrf').val()
        });
        form_data.push({
					name: "per_id",
					value: per_id
            });
        form_data.push({
                name: "transaction_code",
                value: transaction_code
            });
        form_data.push({
            name: "user_id",
            value: user_id
        });
        form_data.push({
            name: "sel_charge",
            value: sel_charge
        });
        form_data.push({
            name: "assignedto_user_id",
            value: assignedto_user_id
        });
        form_data.push({
            name: "action_code",
            value: action_code
        });
        form_data.push({
        name: "unassign_charge",
        value: 'N'
    });
    $('#is_it_unassign_charge').val('N');

      document.getElementById("process_button").onclick = function() {
				forward_detail(form_data);
			};
            var e = document.getElementById('assignedto_user_id');
			assigned_to_username=e.options[e.selectedIndex].text ;
      passing_alert_value('Confirmation', 'Are you sure to assign the charge and move Employee details to '+assigned_to_username+' ?', 'confirmation_alert', 'alert_header', 'alert_body', 'forward_alert');



    }

      
  }

function forward_detail(form_data)
{
    $.ajax
      ({
          url:'<?php echo URLROOT;?>/User_management/split_emptrans_todeptuser',
          type: 'POST',
         data:form_data,//passing id and action msg to the state_master_action.php file.
        // dataType: 'json',
        success: function(data, textStatus, jqXHR) 
        {
            alert($('#is_it_unassign_charge').val());
            if(jqXHR.status=='200')
            {
                if($('#is_it_unassign_charge').val()=='N')
                {
                    passing_alert_value('Confirmation', 'Charge and Employee details has been assigned Successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
                    get_assignedto_usernames();
                }
                if($('#is_it_unassign_charge').val()=='Y')
                {
                    passing_alert_value('Confirmation', 'Charge has been Unassigned Successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
                    $('#user_id').val('');
                    get_selected_user_charge();
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


function unassign_charge()
{
    const form_data = [];
    user_id=$('#user_id').val();
    action_code=$('#action_code').val();
    sel_charge=$('#sel_charge').val();
    assignedto_user_id=$('#assignedto_user_id').val();
    form_data.push({
            name: "csrf",
            value: $('#csrf').val()
        });
    form_data.push({
        name: "user_id",
        value: user_id
    });
    form_data.push({
        name: "sel_charge",
        value: sel_charge
    });
    form_data.push({
        name: "assignedto_user_id",
        value: assignedto_user_id
    });
    form_data.push({
        name: "action_code",
        value: action_code
    });
    form_data.push({
        name: "unassign_charge",
        value: 'Y'
    });
    $('#is_it_unassign_charge').val('Y');

    document.getElementById("process_button").onclick = function() {
				forward_detail(form_data);
			};
            var e = document.getElementById('user_id');
			username=e.options[e.selectedIndex].text ;
      passing_alert_value('Confirmation', 'Are you sure to unassign charge from '+username+' ?', 'confirmation_alert', 'alert_header', 'alert_body', 'forward_alert');
}


    </script>
</body>
</html>