<?php
include('./././public/dash/layout/alert.php'); 
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');

?>

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid mbl_view">

            <div class="row">

                <div class="col-lg-4">
                <a href="<?php echo URLROOT; ?>Mybill/mybill" class="text-body">
                    <div class="card dash">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <img src="<?php echo URLROOT; ?>public/dash/img/companies/bill1.svg" alt="" class="avatar-sm">
                                    <h5 class="mt-4 mb-2 font-size-15 clr">My Bill</h5>   
                            </div>
                        </div>
                    </div><!--end card-->
                    </a>
                </div><!--end col-->
                <div class="col-lg-4">
                <a href="<?php echo URLROOT; ?>Mybill/bill_history" class="text-body">
                    <div class="card dash">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <img src="<?php echo URLROOT; ?>public/dash/img/companies/history.svg" alt="" class="avatar-sm">      
                                    <h5 class="mt-4 mb-2 font-size-15 clr">Bill History</h5>   
                            </div>
                           
                        </div>
                    </div><!--end card-->
                    </a>
                </div><!--end col-->
                <div class="col-lg-4">
                <a href="<?php echo URLROOT; ?>Mybill/profile" class="text-body">
                    <div class="card dash">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <img src="<?php echo URLROOT; ?>public/dash/img/companies/profile.svg" alt="" class="avatar-sm">
                                    <h5 class="mt-4 mb-2 font-size-15 clr">Profile</h5>
                            </div>
                           
                        </div>
                    </div><!--end card-->
                    </a>
                </div><!--end col-->
                <div class="col-lg-4">
                <a href="<?php echo URLROOT; ?>Mybill/change_password" class="text-body">
                    <div class="card dash">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <img src="<?php echo URLROOT; ?>public/dash/img/companies/password1.svg" alt="" class="avatar-sm">
                               
                                    <h5 class="mt-4 mb-2 font-size-15 clr">Change Password</h5>
                              
                            </div>
                           
                        </div>
                    </div><!--end card-->
                    </a>
                </div><!--end col-->
                <div class="col-lg-4">
                <a href="#" class="text-body">
                    <div class="card dash">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <img src="<?php echo URLROOT; ?>public/dash/img/companies/contact.svg" alt="" class="avatar-sm">
                              
                                    <h5 class="mt-4 mb-2 font-size-15 clr">Contact Us</h5>
                              
                            </div>
                           
                        </div>
                    </div><!--end card-->
                    </a>
                </div><!--end col-->
                <div class="col-lg-4">
                <a href="<?= URLROOT; ?>Mybill/logout" class="text-body">
                    <div class="card dash">
                        <div class="card-body p-4">
                            <div class="text-center mb-3">
                                <img src="<?php echo URLROOT; ?>public/dash/img/companies/logout.svg" alt="" class="avatar-sm">
                               
                                    <h5 class="mt-4 mb-2 font-size-15 clr">Logout</h5>
                               
                            </div>
                        </div>
                        </a>
                    </div><!--end card-->
                </div><!--end col-->
            </div><!--end row-->



        </div> <!-- container-fluid -->
    </div>



    <?php include('./././public/dash/layout/footer.php'); ?>


</div>

<script src="<?php echo URLROOT; ?>public/site/js/custom_validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>


<script>

    window.onload=check_profile_update('');

    function check_profile_update(value)
    {
        $.ajax({
            url: '<?php echo URLROOT; ?>Mybill/check_profile_update',
            type: 'POST',
            dataType: 'json',
            paging: true,
            success: function(data, textStatus, jqXHR) 
            {
                if(jqXHR.status=='200')
                {
                    //if chanage password status has null and 'n' value  to show the change password force window
                    if (data == null || data == 'N') 
                    {
                        $('#change_pwd_modal').modal({
                            backdrop: 'static',
                            keyboard: false
                        })
                        $('#close_btn').hide();
                        $('#change_pwd_modal').modal('show');
                    }
                    
                    if(data == 'Y')
                    {
                        if(value == 'check_update')
                        {
                            $('#change_pwd_modal').modal('hide');
                            passing_alert_value('Confirmation', 'Profile has been Updated successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
                        }
                    }
                }
            },
            error: function (xhr, status, error) 
            {
                   
                var err = JSON.parse(xhr.responseText);						
    
                if(err.code== 403)
                    alert('csrf token invalid')

                if(err.code==400)
                    alert('Bad request');
            },
            
        });
    }



    var valiator = $('#update_profile').validate({
        // Specify validation rules
        rules: {
            address1: {
                required: true
            },
            address2: {
                required: true
            },
            pincode: {
                required: true
            },
        },
        // Specify validation error messages
        messages: {

            address1: {
                required: "Enter a address"
            },
            address2: {
                required: "Enter a address"
            },
            pincode: {
                required: "Enter a pincode"
            },
        },
        
        submitHandler: function(form) {

            event.preventDefault();
            var form_data = $('#update_profile').serializeArray();
            form_data.push({
				name: "page",
				value: 'model_update'
			});
            $.ajax({
                url: '<?php echo URLROOT; ?>Mybill/updating_profile',
                method: "POST",
                data: form_data,
                dataType: "json",
                
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        check_profile_update('check_update');
                    }
                },
                error: function(xhr, status, error) 
                {
                    var err = JSON.parse(xhr.responseText);
                    if(err.code==601)
                        alert('prb in mst_user updation')
                    if(err.code==602)
                        alert('prb in insert into mst_userlog')
                }

            });
        }
	});


    </script>