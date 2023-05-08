<?php
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');
include('./././public/dash/layout/alert.php'); 


?>

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12 mbl_view">

                    <div class="card">
                        <div class="card-header card_header_color">Profile</div>
                           
                        <div class="card-body">
                            <?php
                            $session_details = $this->session_details();
                            $name = $session_details[0]->name;
                            $roletypecode = $session_details[0]->roletypecode;
                            $mobilenumber = $session_details[0]->mobilenumber;
                            $email = $session_details[0]->email;
                            $distcode = $session_details[0]->distcode;
                            $statecode = $session_details[0]->statecode;

                            if( $roletypecode   ==  '06')
                            {
                                $address1 = $session_details[0]->addr1;
                                $address2 = $session_details[0]->addr2;
                                $pincode = $session_details[0]->pincode;
                            }
                            else
                            {
                                $empid = $session_details[0]->empid;
                            }
                            

                            $Basemodel = new Basemodel;
                            $Basemodel->tablename = "mybillmyright.mst_district";
                            $id = 'distcode';
                            $district_data = ($Basemodel->getMultipleData(NULL, $id));

                            $Basemodel->tablename = "mybillmyright.mst_state";
                            $id = 'statecode';
                            $state_data = ($Basemodel->getMultipleData(NULL, $id));

                            ?>
                            <form id="profile_update" method="post" >
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label required">Name</label>
                                            <input type="text" class="form-control" id="validationCustom01" placeholder="Name" value="<?php echo $name ?>" required disabled>

                                        </div>
                                    </div>
                                    <?php if(!( $roletypecode == '06'))
                                    {?>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom02" class="form-label required">Employee Id</label>
                                                <input type="text" class="form-control" id="validationCustom02" placeholder="Mobile Number" value="<?php echo $empid ?>" required disabled>

                                            </div>
                                        </div>
<?php
                                    }?>

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom02" class="form-label required">Mobile Number</label>
                                            <input type="text" class="form-control" id="validationCustom02" placeholder="Mobile Number" value="<?php echo $mobilenumber ?>" required disabled>

                                        </div>
                                    </div>
                              
                              

                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom04" class="form-label required">Email</label>
                                            <input type="text" class="form-control" id="validationCustom04" placeholder="Email" value="<?php echo $email ?>" required disabled>

                                        </div>
                                    </div>
                                    <?php if( $roletypecode == '06')
                                    {?>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom03" class="form-label required">Address Line 1</label>
                                                <input type="text" class="form-control" name="add1" id="add1" placeholder="Address Line 1" value="<?php echo $address1 ?>" required>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom03" class="form-label required">Address Line 2</label>
                                            <input type="text" class="form-control" name="add2" id="add2" placeholder="Address Line 2" value="<?php echo $address2 ?>" required>
                                        </div>
                                    </div>
                                        
                                        <?php
                                    }?>
                                    

                              
                              
                             
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom03" class="form-label required">State</label>
                                            <select class="form-select" id="validationCustom03" required disabled>
                                            <?php
                                                foreach ($state_data as $value) 
                                                {
                                                    if (($value->statecode == $statecode)) 
                                                    {?>
                                                        <option value=" <?= htmlspecialchars($value->statecode); ?> " selected><?= htmlspecialchars($value->stateename);  ?></option> <?php 
                                                    } else 
                                                    {?>
                                                        <option value="<?= htmlspecialchars($value->statecode); ?>"><?= htmlspecialchars($value->stateename); ?></option><?php
                                                                 }
                                                            }
                                                           ?>
                                            </select>
                                        </div>
                                    </div>
                                
                                  

                               
                                <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom04" class="form-label required">District</label>
                                            <select class="form-select" id="validationCustom03" required disabled>
                                                <?php
                                                foreach ($district_data as $value) 
                                                {
                                                    if (($value->distcode == $distcode)) 
                                                    {?>
                                                        <option value=" <?= htmlspecialchars($value->distcode); ?> " selected><?= htmlspecialchars($value->distename);  ?></option> <?php 
                                                    } else 
                                                    {?>
                                                        <option value="<?= htmlspecialchars($value->distcode); ?>"><?= htmlspecialchars($value->distename); ?></option><?php
                                                                 }
                                                            }
                                                           ?>
                                               </option>
                                            </select>
                                        </div>
                                    </div>
                                    <?php if( $roletypecode == '06')
                                    {?>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label for="validationCustom04" class="form-label required">Pincode</label>
                                                <input type="text" class="form-control" id="validationCustom04" name="pincode" placeholder="Pincode" value="<?php echo $pincode ?>" required minlength="6" maxlength="6">

                                            </div>
                                        </div><?php
                                    }
                                        ?>
                    
                                </div>

                                <div>
                                    <br>
                                    <br>
                                    <?php if( $roletypecode == '06')
                                    {?>
                                    <center>
                                        <button class="btn btn-primary" type="submit">Update</button>
                                    </center>
                                    <?php
                                    }
                                        ?>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- end card -->
                </div> <!-- end col -->


            </div>
            <!-- end row -->


        </div> <!-- container-fluid -->
    </div>

</div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script>

$('#profile_update').validate({

// Specify validation rules
rules: {

    add1: {
        required: true,
    },
    add2: {
        required: true
    },
    pincode: {
        required: true
    }
},
// Specify validation error messages
messages: {

    add1: {
        required: "Please Update Address Line 1"
    },
    add2: "Please Update Address Line 2",
    pincode: "Please Update Pincode",

},

highlight: function(element, errorClass) {
    $(element).removeClass(errorClass); //prevent class to be added to selects
},
errorPlacement: function(error, element) {
    if (element.parent('.input-group').length) {
        error.insertAfter(element.parent());
    } else {
        error.insertAfter(element);
    }
},
submitHandler: function(form) {
    event.preventDefault();
            var form_data = $('#profile_update').serializeArray();
            form_data.push({
				name: "page",
				value: 'profile_update'
			});
    $.ajax({
        url: "<?php echo URLROOT; ?>Mybill/updating_profile",
        method: "POST",
        data: form_data,
        dataType: "json",
        success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        $('#confirmation_alert').modal({
                                        backdrop: 'static',
                                        keyboard: false
                                        })
							document.getElementById("process_button").onclick = function() 
							{
								profileupdate_sucess();
							};

                       		passing_alert_value('Confirmation', 'Profile Updated Successfully.', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert_with_function');                    }
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

function profileupdate_sucess()
	{
		$('#confirmation_alert').hide();
		window.location.href = '<?php echo URLROOT; ?>Mybill/dashboard';
	} 

</script>

<?php include('./././public/dash/layout/footer.php'); ?>