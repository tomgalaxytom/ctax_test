<?php
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');
include('./././public/dash/layout/alert.php');

?>

<!-- Date picker css -->
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
<!-- Datatable Css -->
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet"> 

<link href="<?php echo URLROOT; ?>public/dash/libs/select2/css/select2.min.css" rel="stylesheet" type="text/css" />


   <style>
@keyframes loaderCircle {

}
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



<div class="main-content">
	<div class="page-content">
		<div class="container-fluid page_content_up">

		<div class="row">
			<div class="col-12">
				<!-- <div class="card" style="width: 100%;">
					<div class="card-body"> -->
						<div class="card disable_this shadow mb-2" id="assign_charge_card">
							<div class="card-header card_header_color">Assign Charge</div>
							<div class="card-body">
								<form class="forms-sample " id="assigncharge_form" name="assigncharge_form" method="POST" action="">
									<div class="alert alert-danger alert-dismissible fade show disable_this" role="alert" id="display_error">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
									<!-- Use hidden text box for storing configid - used at the time of updation and deletion -->
									<input type="hidden" id="userid" name="userid">
									<input type="hidden" id="distcode" name="distcode">

									<div class="row">

										<div class="col-md-6">
											<label class=" col-form-label required">Role Name</label>
											<div class="form-group row">
												<div class="col-sm-12">
													<select class="form-select " name="roleid" id="roleid" onchange="enable_zone_circle_basedon_role('')" disabled>
														<option value=''>---- Select Role Type ----</option>
														<?php 
														$Basemodel = new Basemodel;
														$Basemodel->tablename = "mybillmyright.mst_roletype";
														$id = 'roletypecode';
														$data = ($Basemodel->getMultipleData(NULL, $id));
														foreach ($data as $value) 
														{ 
															if(!(($value->roleid == 01)||($value->roleid == 10)))
															{?>
																<option value="<?= htmlspecialchars($value->roletypecode); ?>"><?= htmlspecialchars($value->roletypelname); ?></option><?php
															} 
														}?>
													</select>
												</div>
											</div>
										</div>

										<div class="col-md-6" id="division_div">
											<label class=" col-form-label required">Division Name</label>
											<div class="form-group row">
												<div class="col-sm-12">
													<?php
													$Basemodel = new Basemodel;
													$Basemodel->tablename = "mybillmyright.mst_division";
													$id = 'divisionlname';
													$data = ($Basemodel->getMultipleData(array('statusflag' => 'Y'), $id));
													?>
													<select class="form-select " name="sel_division" id="sel_division"  onchange="getting_zone()" disabled>
														<option value=''>-- Select Directorate Name --</option>
														<?php
													
														$divisioncode=$_SESSION['user']->divisioncode;
														foreach ($data as $value) 
														{ 
															if($divisioncode==$value->divisioncode)
															{?>
															<option value="<?= htmlspecialchars($value->divisioncode); ?>" selected ><?=  htmlspecialchars($value->divisionlname . ' ( ' . $value->divisionsname . ' )'); ?></option><?php
															}
															else
															{?>
																<option value="<?= htmlspecialchars($value->divisioncode); ?>"><?=  htmlspecialchars($value->divisionlname . ' ( ' . $value->divisionsname . ' )' ); ?></option><?php
															}
															?>

														<?php } ?>
													</select>
												</div>
											</div>
										</div>

										
										


										<div class="col-md-6 disable_this" id="zone_div">
											<label class=" col-form-label required">Zone Name</label>
											<div class="form-group row">
												<div class="col-sm-12">
													<select id="sel_zone" name="sel_zone" class="form-select "  onchange="getting_circle()" disabled>
														<option value=''>--- Select Zone Name---</option>
													</select>
												</div>
											</div>
										</div>
										
										<div class="col-md-6 disable_this" id="circle_div">
											<label class=" col-form-label  required">Circle Name</label>
											<div class="form-group row">
												<div class="col-sm-12">
													<select name="sel_circle" id="sel_circle"  class="form-select" onchange="get_district()" disabled>
														<option value=''>--- Select Circle Name---</option>
													</select>
												</div>
											</div>
										</div>											

										<div class="col-md-6" id="district_div">
											<label class=" col-form-label required">District Name</label>
											<div class="form-group row">
												<div class="col-sm-12">
													<?php
													$Basemodel = new Basemodel;
													$Basemodel->tablename = "mybillmyright.mst_district";
													$id = 'distcode';
													$data = ($Basemodel->getMultipleData(array(), $id));
													?>
													<select class="form-select" name="sel_district" id="sel_district"  disabled>
														<option value=''>-- Select District Name --</option>
														<?php
														foreach ($data as $value) 
														{ ?>
															<option value="<?= htmlspecialchars($value->distcode); ?>"><?=  htmlspecialchars($value->distename); ?></option><?php
														} ?>
													</select>
												</div>
											</div>
										</div>




										<div class="col-md-6">
											<label class=" col-form-label required">Employee Name</label>
											<div class="form-group row">
												<div class="col-sm-12">
													<input type="text" name="emp_name" id="emp_name"  autocomplete="off" class="form-control name" maxlength="50" placeholder="Enter Employee Name" oninput="fn_captilise_each_word('emp_name')" disabled/>
												</div>
											</div>
										</div>
                                        <div class="col-md-6">
                                            <label class=" col-form-label  required">Assign Charge</label>
                                            <div class="form-group row">

                                                <div class="col-sm-12">
                                                    <!-- <select class="form-select select2" name="assign_charge[]" id="assign_charge" data-bs-toggle="select2" multiple require >
                                                        
                                                        </select> -->

														<select class="select   " name="assign_charge[]" id="assign_charge"  data-bs-toggle="select2" multiple require>
														<option value=''>-- Select District Name --</option>
														<?php
														foreach ($data as $value) 
														{ ?>
															<option value="<?= htmlspecialchars($value->distcode); ?>"><?=  htmlspecialchars($value->distename); ?></option><?php
														} ?>
													</select>
                                                </div>
                                            </div>
                                        </div>
										<div class="col-md-6">
											<label class=" col-form-label required">Effect From</label>
											<div class="form-group row">

												<div class="col-sm-12">
													<input type="text" class="form-control " name="charge_from" id="charge_from"  disabled="disabled"/>

												</div>
											</div>
										</div>




										<!-- <div class="col-md-6">
											<label class=" col-form-label required">Date Of Birth</label>
											<div class="form-group row">
												<div class="col-sm-12">
													<div class="input-group">
														<input type="text" class="form-control" id="dob"  required name="dob" readonly="readonly" onclick="calling_datepicker('dob')">
														<div class="input-group-append">
															<button class="btn btn-light" id="dob_btn" type="button" onclick="calling_datepicker('dob')">
																<i class="fa fa-calendar" aria-hidden="true"></i>
															</button>
														</div>
													</div>
												</div>
											</div>
										</div> -->
										<!-- <div class="col-md-6">
											<label class=" col-form-label required">Mobile Number</label>
											<div class="form-group row">

												<div class="col-sm-2">
													<input type="text" name="mob_no_code" id="mob_no_code" class="form-control" disabled="disabled" value="+91" />
												</div>
												<div class="col-sm-10">
													<input type="text" name="mob_no" id="mob_no"  autocomplete="off" class="form-control only_numbers" maxlength="10" placeholder="Enter Mobile Number" pattern="[6789][0-9]{9}"  />
												</div>
											</div>
										</div> -->
										<!-- <div class="col-md-6">
											<label class=" col-form-label required">Email</label>
											<div class="form-group row">

												<div class="col-sm-12">
													<input type="email" name="email" id="email"  autocomplete="off" class="form-control" maxlength="300" placeholder="Enter Email Address" />
												</div>
											</div>
										</div> -->
									</div>

									<div class="mb-3"></div>

									<!-- Modal Footer with action button and close button -->
									<div style="text-align: center; ">
										<input type="hidden" name="hidden_id" id="hidden_id" />
										<input type="hidden" name="action" id="action" value="insert" />
										<input type="submit" name="button_action" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Submit" id="button_action" class="btn button_save" value="Save" />
										<button type="button" class="btn btn-danger" onclick="close_assignform()" >close</button>
									</div>
									<div class="mb-3"></div>
								</form>
							</div>
						</div>
						<div class="card">
							<div class="card-header card_header_color">Assign Charge Details</div>
							<div class="card-body"><br>
								<div id="datatables"></div><br>
								<span class="text_redcolour">*Marked fields are mandatory</span>
							</div>
						</div>
					<!-- </div>
				</div> -->
			</div>
		</div>

		</div> <!-- container-fluid -->
	</div><!-- page-content -->
</div><!-- main-content -->

<?php include('./././public/dash/layout/footer.php'); ?>
<?php include('./././public/dash/common/js_fn.php'); ?> 

<script src="<?php echo URLROOT; ?>public/dash/libs/select2/js/select2.min.js"></script>

<script src="<?php echo URLROOT; ?>public/dash/js/script.js"></script>

<!-- Jquery Validation -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

<!-- Datatable JS -->
<script src="<?php echo URLROOT; ?>public/dash/cdn/js/datatables.min.js" defer="defer"></script>


   


    <script>
      	
		var nic_roleid	=	'<?php echo $this->nic_roletypecode ?>';
		var adc_roleid	=	'<?php echo $this->adc_roletypecode ?>';
		var jc_roleid	=	'<?php echo $this->jc_roletypecode ?>';
		var dc_roleid	=	'<?php echo $this->dc_roletypecode ?>';
		var ac_roleid	=	'<?php echo $this->ac_roletypecode ?>';
		var cto_roletypecode	=	'<?php echo $this->cto_roletypecode ?>';

	    function close_assignform()
		{
			$('#assign_charge_card').hide();
		}



	  	fix_date_format();

        function fix_date_format()
        {
            var today = new Date();
            var date = today.getDate() + '/' + (today.getMonth() + 1) + '/' + today.getFullYear();
            document.getElementById("charge_from").value = date;
        }

        $(".select").each(function() {
				$(this)
				.wrap("<div class=\"position-relative\"></div>")
					.select({
						placeholder: "Select Assign Charge",
						dropdownParent: $(this).parent()
					});
			})

        function enable_field_basedon_usertype(office_code,value)
		{

			if(office_code=='')
				office_code=$('#sel_office').val();

			if(value=='')
				value=$('#user_type').val();
			if(value==3)
			{
				if(office_code=='04')
				{
					$('#hud_div').show();
					$('#dist_div').hide();
				}
				else
				{
					$('#hud_div').hide();
					$('#dist_div').show();
				}
				$('#inst_div').hide();
			}
			else if(value==4)
			{
				$('#inst_div').show();
				if(office_code=='04')
				{
					$('#dist_div').hide();
					$('#hud_div').show();
				}
				else
				{
					$('#dist_div').show();
					$('#hud_div').hide();
				}
			}
			else if(value==nic_roleid)
			{
				$('#inst_div').hide();
				$('#dist_div').hide();
				$('#hud_div').hide();
			}
		}


            function form_close()
            {
                $('#assign_charge_card').hide();
                reset_form() ;
            }

            function reset_form() 
            {
                // valiator.resetForm();
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


            function get_asssign_charge(office_id,dist_id,inst_id,hud_code,usertype_id) 
            {
                csrf=$('#csrf').val();
                $("#assign_charge").empty();
                // $("#assign_charge").append(" <option value=''>--- Select Assign Charge---</option> ");
                $.ajax({
                    url: '<?php echo URLROOT; ?>/User_management/get_assign_charge',
                    type: 'POST',
                    data: {
                        dist_code   :   dist_id,
                        inst_code   :   inst_id,
                        directorate :   office_id,
                        usertype_id :   usertype_id,
                        hud_code    :   hud_code,
                        csrf        :   csrf
                    },
                    dataType: 'json',
                    success: function(data, textStatus, jqXHR) 
                    {
                        if(jqXHR.status=='200')
                        {
                            $("#assign_charge").empty();
                            // $("#assign_charge").append(" <option value=''>--- Select Assign Charge---</option> ");
                            if(!(data==null))
                            {
                                var len = data.length;
                                for (var i = 0; i < len; i++) 
                                {
                                    var chargeid = data[i]['chargeid'];
                                    var charge_code = data[i]['chargedescription'];
                                    // var categeory_name = data[i]['categeory_name'];
                                    
                                    $("#assign_charge").append("<option value='" + data[i]['chargeid'] + "'>" + data[i]['chargedescription'] +"</option>");
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

                        if(err.code==409)
                            alert('Already exists')
                                        
                        if(err.code==681)	
                        {
                            $("#display_error").show();
                            $('#display_error').html("Detail has been Filled Already");
                            
                        }

                        if(err.code==682)
                            alert('All Personal Details entered for the GO')
                        
                        if(err.code==683)
                            alert('updation prb in postdistribution emp_filled count');
                    },

                });
            }

        

            function fetch_data() 
            {
                // var csrf=$('#csrf').val();
                $.ajax({
                    url: '<?php echo URLROOT; ?>/User_management/assign_user_data',
                    paging: "true",
                    dataType: "html",
                    data: {
                        // csrf:csrf,
                    },
                    type: 'POST',
                    success: function(data, textStatus, jqXHR) 
                    {
                        if(jqXHR.status=='200')
                        {
                            if(data.trim()=='No_data')
                                $('#datatables').html('<br><center>No Data Available</center>');
                            else
                            {
                                $('#datatables').html(data);
                                $(function () {
                                    $('#datatables-basic').DataTable({
                                            paging: true,
                                            lengthChange: true,
                                            searching: true,
                                            ordering: true,
                                            info: true,
                                            autoWidth: true,
                                            responsive: true,
                                            "lengthMenu": [
                                                [5, 10, 25, 50, -1],
                                                [5, 10, 25, 50, "All"]
                                            ],
                                    });
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
                    }
                });
            }
            fetch_data();




        function enable_zone_circle_basedon_role(roleid)
		{
			$('#sel_division').val('');
			$("#sel_zone").empty();
			$("#sel_zone").append(" <option value=''>--- Select Zone Name---</option> ");
			$("#sel_circle").empty();
			$("#sel_circle").append(" <option value=''>--- Select Circle Name---</option> ");
			$('#sel_district').val('');
			$('#distcode').val('');

			if(roleid	==	'')
				roleid	=	$('#roleid').val();

				if((roleid==adc_roleid))		//ADC
				{
					$('#division_div').hide();
					$('#district_div').hide();
					$('#zone_div').hide();
					$('#circle_div').hide();
				}
				if((roleid==jc_roleid))		//JC
				{
					$('#division_div').show();
					$('#district_div').show();
					$('#zone_div').hide();
					$('#circle_div').hide();
				}
				else if((roleid==dc_roleid)||(roleid==ac_roleid)||(roleid==cto_roletypecode))		//DC || AC
				{
					$('#division_div').show();
					$('#district_div').show();
					$('#zone_div').show();
					if((roleid==dc_roleid))		//DC
					{
						$('#circle_div').hide();
					}
					if((roleid==ac_roleid)||(roleid==cto_roletypecode))		//AC
					{
						$('#circle_div').show();
					}

				}
		}

		function get_district()
		{
			form_data	=	[];
			var get_distcode	=	'N';
			if((($('#roleid').val()==jc_roleid)&&(!($('#sel_division').val()==''))))		//JC
			{
				get_distcode	=	'Y';
				form_data.push({
					name: "divisioncode",
					value: $('#sel_division').val()
				});
			}
			else if((($('#roleid').val()==dc_roleid)&&(!(($('#sel_division').val()=='')&&($('#sel_zone').val()=='')))))	//DC
			{
				get_distcode	=	'Y';
				form_data.push({
					name: "divisioncode",
					value: $('#sel_division').val()
				});
				form_data.push({
					name: "zonecode",
					value: $('#sel_zone').val()
				});
			
			}
			else if((($('#roleid').val()==ac_roleid)&&(!(($('#sel_division').val()=='')&&($('#sel_zone').val()=='')&&($('#sel_circle').val()=='')))))		//AC
			{
				get_distcode	=	'Y';
				form_data.push({
					name: "divisioncode",
					value: $('#sel_division').val()
				});
				form_data.push({
					name: "zonecode",
					value: $('#sel_zone').val()
				});
				form_data.push({
					name: "circlecode",
					value: $('#sel_circle').val()
				});
			}
			// alert(get_distcode);
			if(get_distcode=='Y')
			{
				form_data.push({
					name: "roleid",
					value: $('#roleid').val()
				});

				$.ajax({
					url: '<?php echo URLROOT; ?>Mybill/get_distcode_basedon_selection',
					paging: true,
					data:  form_data,
					dataType: "json",
					method: "POST",
					success: function(data, textStatus, jqXHR) 
					{
						if(jqXHR.status=='200')
						{
							$('#sel_district').val(data);
							$('#distcode').val(data);
							
						}
					},

				});

			}
			else
			{
				$('#sel_district').val('');
				$('#distcode').val('');
			}
				

			
		}


		// function get_zone_data(divisioncode,zonecode)
		// {
		// 	if(divisioncode	==	'')
		// 		divisioncode	=	$('#sel_division').val()
		// 	$.ajax({
		// 		url: '<?php echo URLROOT; ?>Mybill/get_zonedata_basedon_division',
		// 		paging: true,
		// 		data:  {
		// 			divisioncode	:	$('#sel_division').val()
		// 		},
		// 		dataType: "json",
		// 		method: "POST",
		// 		success: function(data, textStatus, jqXHR) 
		// 		{
		// 			if(jqXHR.status=='200')
		// 			{
		// 				$("#sel_zone").empty();
		// 				$("#sel_zone").append(" <option value=''>--- Select Zone Name---</option> ");
		// 				for (var i = 0; i < data.length; i++) 
		// 				{
		// 					if (zonecode == data[i]['zonecode'])
		// 						$("#sel_zone").append("<option value='" + data[i]['zonecode'] + "'selected>" + data[i]['zonelname'] + "</option>");
		// 					else
		// 						$("#sel_zone").append("<option value='" + data[i]['zonecode'] + "'>" + data[i]['zonelname'] + "</option>");
		// 				}
		// 			}
		// 		},

		// 	});
		// }




		// function get_circle_data(divisioncode,zonecode,circlecode)
		// {
		// 	if(divisioncode	==	'')
		// 	{
		// 		divisioncode	=	$('#sel_division').val()
		// 	}


		// 	if(zonecode	==	'')
		// 		zonecode	=	$('#sel_zone').val()

		// 	$.ajax({
		// 		url: '<?php echo URLROOT; ?>Mybill/get_circledata_basedon_division_zone',
		// 		paging: true,
		// 		data:  {
		// 			divisioncode	:	divisioncode,
		// 			zonecode		:	zonecode
		// 		},
		// 		dataType: "json",
		// 		method: "POST",
		// 		success: function(data, textStatus, jqXHR) 
		// 		{
		// 			if(jqXHR.status=='200')
		// 			{
		// 				$("#sel_circle").empty();
		// 				$("#sel_circle").append(" <option value=''>--- Select Circle Name---</option> ");
		// 				for (var i = 0; i < data.length; i++) 
		// 				{
		// 					if (circlecode == data[i]['circleid'])
		// 						$("#sel_circle").append("<option value='" + data[i]['circleid'] + "'selected>" + data[i]['circlename'] + "</option>");
		// 					else
		// 						$("#sel_circle").append("<option value='" + data[i]['circleid'] + "'>" + data[i]['circlename'] + "</option>");
		// 				}
		// 			}
		// 		},

		// 	});
		// }


		function getting_zone()
		{
			if(!($('#sel_division').val()==''))
			{
				if(($('#roleid').val()==dc_roleid)||($('#roleid').val()==ac_roleid)||($('#roleid').val()==cto_roletypecode))
				{
					get_zone_data();
				}
				else if($('#roleid').val()==jc_roleid)
				{
					get_district();
				}
			}
			else
			{
				alert('select division name');
			}
		}

		function getting_circle()
		{
			if(!(($('#sel_division').val()=='')||($('#sel_zone').val()=='')))
			{
				if($('#roleid').val()==dc_roleid)
				{
					get_district();
				}
				else if(($('#roleid').val()==ac_roleid)||($('#roleid').val()==cto_roletypecode))
				{
					get_circle_data('','','');
				}
			}
			else if($('#sel_zone').val()=='')
			{
				$('#sel_circle').val('');
				
			}
			else
			{
				alert('select division and zone name');
			}
		}





        var valiator = $('#assigncharge_form').validate({


            // Specify validation rules
            rules: {
                // sel_office: {
                //     required: true
                // },
                // sel_dist: {
                //     required: true
                // },
                // sel_inst: {
                //     required: true
                // },
                // get_emp_name: {
                //     required: true
                // },
                "assign_charge[]": { required:true }
            },
            // Specify validation error messages
            messages: {
                // sel_office:"Select Directorate Name",
                // sel_dist:"Select District Name",
                // sel_inst:"Select Institution Name",
                // get_emp_name:"Select Employee Name",
                assign_charge:"Select Assign Charge",
                "assign_charge[]": "Select Charge",
            },
            highlight: function(element, errorClass) {
                $(element).removeClass(errorClass); //prevent class to be added to selects
            },
            errorPlacement: function (error, element) {
                if(element.hasClass('select') && element.next('.select2-container').length) {
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
                else {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) {
                event.preventDefault();
                var form_data = $('#assigncharge_form').serializeArray();
                form_data.push({
                name: "sel_division",
                value: $('#sel_division').val()
            });
            form_data.push({
                name: "sel_zone",
                value: $('#sel_zone').val()
            });
            form_data.push({
                name: "sel_circle",
                value: $('#sel_circle').val()
            });

            form_data.push({
                name: "roleid",
                value: $('#roleid').val()
            });

            form_data.push({
                name: "page_name",
                value: 'assign_charge'
            });
			form_data.push({
                name: "sel_district",
                value: $('#sel_district').val()
            });

        

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


        $(document).on('click', '.edit_assign_charge', function() 
        {
            $('#error').hide();
            // valiator.resetForm();
            var id = $(this).attr('id'); //Getting id of user clicked edit button.
            var action = 'fetch_single'; //Make as fetch single
            $('#userid').val(id);

            var csrf=$('#csrf').val();

            

            $.ajax({
                url: '<?php echo URLROOT; ?>/User_management/edit_assign_charge/',
                type: 'POST',
                data: {
                    id: id,
                    action: action,
                    csrf:csrf,
                }, //passing id and action msg to the config_master_action.php file.
                dataType: 'json', //Response data type as json.

                error: function (xhr, status, error) 
				{
					// debugger;
					var err = JSON.parse(xhr.responseText);						
				
					if(err.code==400)
					{
						alert('Bad Request')
					}	
					if(err.code==403)
					{
						alert('csrf token invalid')
						// window.location.href = '<?php echo URLROOT; ?>';
						
					}	
				},

				success: function(response, status ,xhr) 
				{
					if (xhr.status == 200) 
					{
                        $('#assign_charge_card').show();

						roletypecode	=	response['roletypecode'];
                        $('#roleid').val(roletypecode);
						enable_zone_circle_basedon_role(roletypecode);
						$('#email').val(response['email']);
						// $('#user_type').val(response['usertype_id']);
						// $('#gpf_no').val(response['emp_gpfno']);
						$('#emp_name').val(response['name']);
						$('#mob_no').val(response['mobilenumber']);
						$('#sel_district').val(response['distcode']);
						$('#distcode').val(response['distcode']);

						

						if((roletypecode==jc_roleid)||(roletypecode==dc_roleid)||(roletypecode==ac_roleid)||(roletypecode==cto_roletypecode))
						{
							$('#sel_division').val(response['divisioncode']);
						
							if((roletypecode==dc_roleid)||(roletypecode==ac_roleid)||(roletypecode==cto_roletypecode))
							{

								get_zone_data(roletypecode,response['divisioncode'],response['zonecode'],'sel_division','sel_zone','roleid')
							}
							if((roletypecode==ac_roleid)||(roletypecode==cto_roletypecode))
							{

								get_circle_data(roletypecode,response['divisioncode'],response['zonecode'],response['circleid'],'sel_division','sel_zone','sel_circle','roleid')
							}
						}

						get_asssign_charge(response['divisioncode'],response['zonecode'],response['circleid'],response['distcode'],roletypecode);


                        // getting_directorate_related_data(response['office_code'],response['dist_code'],response['hud_code'],'hud_div','sel_hud','dist_div','sel_dist','sel_inst','sel_office','sel_office');
                        // if(response['usertype_id'] == 4)
                        //     get_inst('sel_inst',response['inst_id'],'sel_dist',response['dist_code'],'sel_office',response['office_code'],'sel_hud',response['hud_code']) ;
                        // enable_field_basedon_usertype(response['office_code'],response['usertype_id']);
                        // $('#sel_dist').val(response['dist_code']);
                        // $('#sel_office').val(response['office_code']);
                        // $('#assign_charge').val(response['charge_id']);
                        // $('#user').val(response['user_id']);
                        // get_asssign_charge(response['office_code'],response['dist_code'],response['inst_id'],response['hud_code'],response['usertype_id']);
                        // $('#get_emp_name').val(response['name']);
					}
				}

            });
        });




		function get_asssign_charge(divisioncode,zonecode,circleid,distcode,roleid) 
		{
			// csrf=$('#csrf').val();
			$("#assign_charge").empty();
			// $("#assign_charge").append(" <option value=''>--- Select Assign Charge---</option> ");
			$.ajax({
				url: '<?php echo URLROOT; ?>/User_management/get_assign_charge',
				type: 'POST',
				data: {
					divisioncode   :   divisioncode,
					zonecode   :   zonecode,
					circleid :   circleid,
					distcode :   distcode,
					roleid    :   roleid,
					// csrf        :   csrf
				},
				dataType: 'json',
				success: function(data, textStatus, jqXHR) 
				{
					if(jqXHR.status=='200')
					{
						
						if(!(data==null))
						{
							var len = data.length;
							for (var i = 0; i < len; i++) 
							{
								// var charge_id = data[i]['chargeid'];
								// var charge_code = data[i]['chargedescription'];
								
								$("#assign_charge").append("<option value='" +  data[i]['chargeid'] + "'>" + data[i]['chargedescription']  + "</option>");
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

					if(err.code==409)
						alert('Already exists')
									
					if(err.code==681)	
					{
						$("#display_error").show();
						$('#display_error').html("Detail has been Filled Already");
						
					}

					if(err.code==682)
						alert('All Personal Details entered for the GO')
					
					if(err.code==683)
						alert('updation prb in postdistribution emp_filled count');
				},

			});
		}

       
    </script>

</body>

</html>