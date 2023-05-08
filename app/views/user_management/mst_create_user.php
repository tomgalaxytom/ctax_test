<?php
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');
include('./././public/dash/layout/alert.php');

?>
<!-- <link data-require="datatables@1.10.12" data-semver="1.10.12" rel="stylesheet" href="//cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" /> -->
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.1.0/css/responsive.dataTables.min.css"/> 
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.css" />
  
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.js"></script>
<style>
    .dataTables_length {
        padding: 0px 15px 0px 0px;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control {
        position: relative;
        padding-left: 30px;
        cursor: pointer;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr>td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr>th.dtr-control:before {
        top: 50%;
        left: 5px;
        height: 1em;
        width: 1em;
        margin-top: -9px;
        display: block;
        position: absolute;
        color: white;
        border: 0.15em solid white;
        border-radius: 1em;
        box-shadow: 0 0 0.2em #444;
        box-sizing: content-box;
        text-align: center;
        text-indent: 0 !important;
        font-family: "Courier New", Courier, monospace;
        line-height: 1em;
        content: "+";
        background-color: #31b131;
    }

    table.dataTable>tbody>tr.child span.dtr-title {
        display: inline-block;
        min-width: 100px;
        font-weight: bold;
    }

    table.dataTable.dtr-inline.collapsed>tbody>tr.parent>td.dtr-control:before,
    table.dataTable.dtr-inline.collapsed>tbody>tr.parent>th.dtr-control:before {
        content: "-";
        background-color: #d33333;
    }
</style>

<!-- Date picker css -->
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
<!-- Datatable Css -->
<!-- <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">   -->

	<?php 

	$session	=	$this->session_details(); 
	
	$session_roleid	=	$session[0]->roletypecode;
	$session_divisioncode	=	$session[0]->divisioncode;

	// $nic_roleid	=	 $this->nic_roleid;
	// $adc_roleid	=	$this->adc_roleid;
	// $jc_roleid	=	$this->jc_roleid;
	// $dc_roleid	=	$this->dc_roleid;
	// $ac_roleid	=	$this->ac_roleid;

	$nic_roleid	=	 $this->nic_roletypecode;
	$adc_roleid	=	$this->adc_roletypecode;
	$jc_roleid	=	$this->jc_roletypecode;
	$dc_roleid	=	$this->dc_roletypecode;
	$ac_roleid	=	$this->ac_roletypecode;
	$citizen_roletypecode	=	$this->citizen_roletypecode;

	$cto_roletypecode = $this->cto_roletypecode;

	
	?>

	<div class="main-content">
		<div class="page-content">
			<div class="container-fluid page_content_up">
				<div class="row">
					<div class="col-12">
						<!-- <div class="card" style="width: 100%;">
							<div class="card-body"> -->
								<div class="card shadow mb-2">
									<div class="card-header card_header_color">Department User Creation</div>
									<div class="card-body">
										<form class="forms-sample " id="createuser_form" name="createuser_form" method="POST" action="">
											<div class="alert alert-danger alert-dismissible fade show disable_this" role="alert" id="display_error">
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
											</div>
											<!-- Use hidden text box for storing configid - used at the time of updation and deletion -->
											<input type="hidden" id="userid" name="userid">
											<input type="hidden" id="distcode" name="distcode">

											<?php
											$Basemodel = new Basemodel;
											$Basemodel->tablename = "mybillmyright.mst_roletype";
											$id = 'roletypecode';
											$data = ($Basemodel->getMultipleData(NULL, $id));
											?>
											<div class="row">

												<div class="col-md-6">
													<label class=" col-form-label required">Enter Role</label>
													<div class="form-group row">
														<div class="col-sm-12">
															<select class="form-select " name="roleid" id="roleid" onchange="enable_basedon_roletypecode('')">
																<option value=''>---- Select Role Type ----</option>
																<?php 
																
																foreach ($data as $value) 
																{ 
																	if($session_roleid == $nic_roleid)
																	{
																		if(($value->roletypecode==$session_roleid)||($value->roletypecode == $citizen_roletypecode))
																			continue;
																		else
																		{?>
																			<option value="<?= htmlspecialchars($value->roletypecode); ?>"><?= htmlspecialchars($value->roletypelname); ?></option><?php
																		}
																	}
																	else if($session_roleid == $adc_roleid)
																	{
																		if(($value->roletypecode==$nic_roleid)||($value->roletypecode==$adc_roleid)||($value->roletypecode == $citizen_roletypecode))
																			continue;
																		else
																		{?>
																			<option value="<?= htmlspecialchars($value->roletypecode); ?>"><?= htmlspecialchars($value->roletypelname); ?></option><?php
																		}
																	}
																	else if($session_roleid == $jc_roleid)
																	{
																		if(($value->roletypecode==$nic_roleid)||($value->roletypecode==$adc_roleid)||($value->roletypecode==$jc_roleid)||($value->roletypecode == $citizen_roletypecode))
																			continue;
																		else
																		{?>
																			<option value="<?= htmlspecialchars($value->roletypecode); ?>"><?= htmlspecialchars($value->roletypelname); ?></option><?php
																		}
																	}
																	else if($session_roleid == $dc_roleid)
																	{
																		if(($value->roletypecode==$nic_roleid)||($value->roletypecode==$adc_roleid)||($value->roletypecode==$jc_roleid)||($value->roletypecode== $dc_roleid)||($value->roletypecode == $citizen_roletypecode))
																			continue;
																		else
																		{?>
																			<option value="<?= htmlspecialchars($value->roletypecode); ?>"><?= htmlspecialchars($value->roletypelname); ?></option><?php
																		}
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
															<select class="form-select " name="sel_division" id="sel_division"  onchange="getting_zone()">
																<option value=''>-- Select Division Name --</option>
															</select>
														</div>
													</div>
												</div>

												<div class="col-md-6 disable_this" id="zone_div">
													<label class=" col-form-label required">Zone Name</label>
													<div class="form-group row">
														<div class="col-sm-12">
															<select id="sel_zone" name="sel_zone" class="form-select "  onchange="getting_circle()">
																<option value=''>--- Select Zone Name---</option>
															</select>
														</div>
													</div>
												</div>
												
												<div class="col-md-6 disable_this" id="circle_div">
													<label class=" col-form-label select required">Circle Name</label>
													<div class="form-group row">
														<div class="col-sm-12">
															<select name="sel_circle" id="sel_circle"  class="form-select" onchange="get_district('','','','','','roleid','sel_division','sel_zone','sel_circle','sel_district','distcode')">
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
													<label class=" col-form-label required">Employee ID</label>
													<div class="form-group row">
														<div class="col-sm-12">
															<input type="text" name="emp_id" id="emp_id"  autocomplete="off" class="form-control alpha_numeric" maxlength="10" placeholder="Enter Employee Id"  />
														</div>
													</div>
												</div>

												<div class="col-md-6">
													<label class=" col-form-label required">Employee Name</label>
													<div class="form-group row">
														<div class="col-sm-12">
															<input type="text" name="emp_name" id="emp_name"  autocomplete="off" class="form-control name" maxlength="50" placeholder="Enter Employee Name" oninput="fn_captilise_each_word('emp_name')" />
														</div>
													</div>
												</div>


												<div class="col-md-6">
													<label class=" col-form-label required">Date of Birth</label>
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
												</div>
												<div class="col-md-6">
													<label class=" col-form-label required">Mobile Number</label>
													<div class="form-group row">

														<div class="col-sm-2">
															<input type="text" name="mob_no_code" id="mob_no_code" class="form-control" disabled="disabled" value="+91" />
														</div>
														<div class="col-sm-10">
															<input type="text" name="mob_no" id="mob_no"  autocomplete="off" class="form-control only_numbers" maxlength="10" placeholder="Enter Mobile Number" pattern="[6789][0-9]{9}"  />
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<label class=" col-form-label required">Email</label>
													<div class="form-group row">

														<div class="col-sm-12">
															<input type="email" name="email" id="email"  autocomplete="off" class="form-control" maxlength="300" placeholder="Enter Email Address" />
														</div>
													</div>
												</div>

												<!-- <div class="col-md-6">
													<label class=" col-form-label required">Nodal</label>
													<div class="form-group row">
														<div class="group">
															<div class="col-sm-12">
																<div class="form-check form-check-inline">
																	<input class="form-check-input" type="radio" name="nodal_status" id="yes_nodal" value="yes_nodal" >
																	<label class="form-check-label" for="inlineRadio1">Yes</label>
																</div>
																<div class="form-check form-check-inline">
																	<input class="form-check-input" type="radio" name="nodal_status" id="no_nodal" value="no_nodal"  >
																	<label class="form-check-label" for="inlineRadio2">No</label>
																</div>
																
															</div>
														</div>
													</div>
												</div>
												<div class="col-md-6">
													<label class=" col-form-label required">Lott Executor</label>
													<div class="form-group row">
														<div class="group">
															<div class="col-sm-12">
																<div class="form-check form-check-inline">
																	<input class="form-check-input" type="radio" name="lottexecutor_status" id="yes_lottexecutor" value="yes_lottexecutor" >
																	<label class="form-check-label" for="inlineRadio1">Yes</label>
																</div>
																<div class="form-check form-check-inline">
																	<input class="form-check-input" type="radio" name="lottexecutor_status" id="no_lottexecutor" value="no_lottexecutor"  >
																	<label class="form-check-label" for="inlineRadio2">No</label>
																</div>
															</div>
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
												<button type="button" class="btn btn-danger" onclick="reset_user_form_with_session_detail()" id="1">clear</button>
											</div>
											<div class="mb-3"></div>
										</form>
									</div>
								</div>
								<div class="card">
									<div class="card-header card_header_color">Department User Details</div>
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

	<!-- Js -->
	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>

	<!-- Jquery ui Datepicker -->
	<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 	

	<!-- Jquery Validation -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

	<!-- Datatable JS -->
	<!-- <script src="<?php echo URLROOT; ?>public/dash/cdn/js/datatables.min.js" defer="defer"></script> -->

	<!-- <script data-require="jquery@3.0.0" data-semver="3.0.0" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.0.0/jquery.js"></script>     -->

	
	<script src="//cdn.datatables.net/1.10.12/js/jquery.dataTables.min.js"></script>
	<script  src="//cdn.datatables.net/responsive/2.1.0/js/dataTables.responsive.min.js"></script>

	 

	<script>



		var nic_roleid	=	'<?php echo $this->nic_roletypecode ?>';
		var adc_roleid	=	'<?php echo $this->adc_roletypecode ?>';
		var jc_roleid	=	'<?php echo $this->jc_roletypecode ?>';
		var dc_roleid	=	'<?php echo $this->dc_roletypecode ?>';
		var ac_roleid	=	'<?php echo $this->ac_roletypecode ?>';
		var cto_roletypecode	=	'<?php echo $this->cto_roletypecode ?>';

		

		fetch_data() ;
	

		window.onload=check_session_detail();


		function check_session_detail()
		{
			<?php 
			$session	=	$this->session_details(); 
			$session_roleid	=	$session[0]->roletypecode;?>

			session_roleid='<?php echo $session_roleid?>';

			

			if((session_roleid==jc_roleid)||(session_roleid==dc_roleid))
			{
				session_zonecode	=	'';
				session_divisioncode	='<?php echo	$session[0]->divisioncode; ?>';
				$('#sel_division').val(session_divisioncode);
				get_division_data_basedon_roletype('roleid','sel_division',session_roleid,session_divisioncode);


				if((session_roleid==jc_roleid))		//JC
				{
					$('#division_div').show();
					$('#district_div').show();
					$('#zone_div').hide();
					$('#circle_div').hide();
					get_zone_data('',session_divisioncode,'','sel_division','sel_zone','roleid')
					
				}
				else if((session_roleid==dc_roleid))		//DC || AC
				{
					$('#division_div').show();
					$('#district_div').show();
					$('#zone_div').show();
					session_zonecode	='<?php echo	$session[0]->zonecode; ?>';
					get_zone_data('',session_divisioncode,session_zonecode,'sel_division','sel_zone','roleid')
					// get_circle_data('',session_divisioncode,session_zonecode,'','sel_division','sel_zone','sel_circle','roleid');
					$('#circle_div').hide();	
					$('#sel_zone').attr("disabled", "disabled");
				}

				
				$('#sel_division').attr("disabled", "disabled");
				// get_district(session_roleid,session_divisioncode,session_zonecode,'','')

				// $('#user_type').removeAttr("disabled");
			}
		}

		function calling_datepicker(value)
		{
			var dateToday = new Date();
			st_yr	=	-70;
			end_yr	=	 -18;

			date_range=(st_yr + ":" + end_yr);

			view_datepicker(value,date_range,'N','','','create_user');   
		}


		//validate age - minumum 18 yrs
		$.validator.addMethod("minAge", function(value, element, min) 
		{
			var today = new Date();
			var parts = value.split("/");
			var birthDate = new Date(parts[1] + "/" + parts[0] + "/" + parts[2]);
			// var birthDate = new Date(value);
			var age = today.getFullYear() - birthDate.getFullYear();

			if (age > min + 1) {
				return true;
			}

			var m = today.getMonth() - birthDate.getMonth();

			if (m < 0 || (m === 0 && today.getDate() < birthDate.getDate())) {
				age--;
			}

			return age >= min;
		}, "You are not old enough!");



		function reset_user_form()
		{
			$('#display_error').hide();
			valiator.resetForm();
		
			change_button_as_insert('createuser_form','action','button_action','display_error');
			$('#sel_division').val('');
			$("#sel_zone").empty();
			$("#sel_zone").append(" <option value=''>--- Select Zone Name---</option> ");
			$("#sel_circle").empty();
			$("#sel_circle").append(" <option value=''>--- Select Circle Name---</option> ");
			$('#sel_district').val('');
			$('#distcode').val('');
			
		}

		function reset_user_form_with_session_detail()
		{
			reset_user_form();
			check_session_detail();
		}


		function enable_basedon_roletypecode()
		{
			enable_zone_circle_basedon_role('');
			<?php 
			$session	=	$this->session_details(); 
			$session_roleid	=	$session[0]->roletypecode;?>

			session_roleid='<?php echo $session_roleid?>';

			

			if((session_roleid==nic_roleid)||(session_roleid==adc_roleid))
			{
				if($('#roleid').val())
				{
					get_division_data_basedon_roletype('roleid','sel_division',$('#roleid').val(),'');
				}
			}


			
		}

		
		function enable_zone_circle_basedon_role(roleid)
		{
			session_role_id='<?php echo $session_roleid?>';

			if(!((session_role_id == jc_roleid)||(session_role_id == dc_roleid)))
			{
				$('#sel_division').val('');
				$("#sel_zone").empty();
				$("#sel_zone").append(" <option value=''>--- Select Zone Name---</option> ");
				$("#sel_circle").empty();
				$("#sel_circle").append(" <option value=''>--- Select Circle Name---</option> ");
				$('#sel_district').val('');
				$('#distcode').val('');
			}
			else
			{
				if((session_role_id == jc_roleid))
				{
					rolebox_type	=	$('#roleid').val()
					if((rolebox_type == ac_roleid)|| (rolebox_type==cto_roletypecode)||(rolebox_type == dc_roleid))
					{
						$('#sel_zone').val('');
						$('#sel_circle').val('');
						get_zone_data(rolebox_type,session_divisioncode,'','sel_division','sel_zone','roleid')

					}
				}
				else if((session_role_id == dc_roleid))
				{
					rolebox_type	=	$('#roleid').val()
					if(rolebox_type)
					{
						get_circle_data(rolebox_type,session_divisioncode,session_zonecode,'','sel_division','sel_zone','sel_circle','roleid');

					}

				}
			}
			
			if(roleid	==	'')
				roleid	=	$('#roleid').val();


			if(!(roleid	==	''))
			{
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
				else if((roleid==dc_roleid)||(roleid==ac_roleid) || (roleid==cto_roletypecode))		//DC || AC
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
			else
			{
				reset_user_form_with_session_detail()
			}			
		}




		function getting_zone()
		{
			if(!($('#sel_division').val()==''))
			{
				if(($('#roleid').val()==dc_roleid)||($('#roleid').val()==ac_roleid)||($('#roleid').val() == cto_roletypecode))
				{
					get_zone_data('','','','sel_division','sel_zone','roleid');
				}
				else if($('#roleid').val()==jc_roleid)
				{
					get_district('','','','','','roleid','sel_division','sel_zone','sel_circle','sel_district','distcode');
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
					get_district('','','','','','roleid','sel_division','sel_zone','sel_circle','sel_district','distcode');

			
				else if(($('#roleid').val()==ac_roleid)||($('#roleid').val()==cto_roletypecode))
				{
					get_circle_data($('#roleid').val(),'','','','sel_division','sel_zone','sel_circle','roleid');

				}
			}
			else if($('#sel_zone').val()=='')
				$('#sel_circle').val('');
				
			else
				alert('select division and zone name');

		}

	

		function fetch_data() 
		{
			$.ajax({
				url: '<?php echo URLROOT; ?>/User_management/usercreation_data',
				paging: "true",
				dataType: "html",
				data : 
				{
					csrf    :   $('#csrf').val(),
					page_name  : 'form'
				},
				method :"POST",
				success: function(data, textStatus, jqXHR) 
				{
					if(jqXHR.status=='200')
					{
						if(data==0)
						$('#datatables').html('<br><center>No Data Available</center>');
						else
						{
							$('#datatables').html(data);
							$(function () {
								// $('#datatables-basic').DataTable({
								// 	responsive : true
								// });

								$('#datatables-basic').DataTable({
                                    "columnDefs": [{

                                        // "targets": hide_column,
                                        "visible": false,
                                        "searchable": false
                                    }],
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
				},
			});
		}



		var valiator = $('#createuser_form').validate({
			// Specify validation rules
			rules: {

				emp_name: {
					required: true
				},
				dob: {
						required: true,
						minAge: 18
					},
				mob_no: {
					required: true,
					number: true,
					minlength: 10,
					maxlength: 10
				},
				email: {
					required: true
				},
				sel_division: {
					required: true
				},
				sel_zone: {
					required: true
				},
				sel_circle: {
					required: true
				},
				roleid: {
					required: true
				},
				nodal_status:
				{
					required:true
				},
				lottexecutor_status:
				{
					required:true
				},
				emp_id	:{
					required :true
				}
				
			},
			// Specify validation error messages
			messages: {
				emp_id: "Enter Employee Id",
				emp_name: "Enter Employee Name",
				dob: {
					required: "Please enter you date of birth.",
					minAge: "You must be at least 18 years old!"
				},
				mob_no: "Enter Mobile Number",
				email: "Enter Email Address",
				sel_division: "Select Division Name",
				sel_zone: "Select Zone Name",
				sel_circle: "Select Circle Name",
				roleid:	"Select Role Name",
				nodal_status	:	"Select Nodal Status",
				lottexecutor_status	:	"Select Lottexecutor Status",
			},
			onfocusout: function(element) {
				$(element).valid();
			},
			highlight: function(element, errorClass) {
				$(element).removeClass(errorClass); //prevent class to be added to selects
			},
			errorPlacement: function(error, element) {
				if(element.parent('.input-group').length) {
					error.insertAfter(element.parent());
				}
				else if ( element.is(":radio") ) 
				{
					error.appendTo( element.parents('.group') );
				}
				else
				{
					error.insertAfter(element);
				}
			},
			submitHandler: function(form) 
			{
				event.preventDefault();
				var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
				if (!(mailformat.test($('#email').val()))) 
				{
					$("#display_error").show();
					$('#display_error').html('Invalid Email Address.');
				} 
				else 
				{
					var form_data = $('#createuser_form').serialize(); // All form data in a form_data variable.
					$.ajax({
						url: "<?php echo URLROOT; ?>/User_management/insert_update_createuser",
						dataSrc: "active",
						method: "POST",
						data: form_data,
						success: function(data, textStatus, jqXHR) 
						{
							if(jqXHR.status=='200')
							{
								getting_buttion_action=$('#action').val();
								if(getting_buttion_action	==	'insert')
								{
									passing_alert_value('Confirmation', 'Department User has been created Successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
									fetch_data();
									reset_user_form_with_session_detail()
								}
								else if(getting_buttion_action	==	'update')
								{
									passing_alert_value('Confirmation', 'Department User has been updated successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
									reset_user_form_with_session_detail();
									fetch_data();
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
											
							if(err.code==651)	
							{
								$('#suffix').css('border-color', '#ced4da');
								$('#gpf_no').css('border-color', '#ced4da');
								$("#display_error").show();
								$('#display_error').html("Email Address Already Exists");
								show_box_in_redclr('email');
								
							}
							if(err.code==652)	
							{
								$("#display_error").show();
								$('#display_error').html("Employee Id Already Exists");
								show_box_in_redclr('gpf_no','suffix');
							}
							if(err.code==653)	
							{
								$('#suffix').css('border-color', '#ced4da');
								$('#gpf_no').css('border-color', '#ced4da');
								$('#email').css('border-color', '#ced4da');
								$("#display_error").show();
								$('#display_error').html("Mobile Number Already Exists");
								show_box_in_redclr('mob_no');
								
							}
						},
						
					});
				}
			}
		});


		$(document).on('click', '.edit_dept_user', function() 
		{
			reset_user_form();
			var id = $(this).attr('id'); //Getting id of user clicked edit button.
			var action = 'fetch_single'; //Make as fetch single
			$('#userid').val(id);
			$.ajax({
				url: '<?php echo URLROOT; ?>User_management/edit_dept_user/',
				type: 'POST',
				data: {
					id: id,
					// csrf    :   $('#csrf').val()
				}, //passing id and action msg to the config_master_action.php file.
				dataType: 'json', //Response data type as json.
				success: function(response, textStatus, jqXHR) 
				{
					if(jqXHR.status=='200')
					{
						roletype_code=response['roletypecode']
						change_button_as_update('createuser_form','action','button_action','display_error');
						$('#roleid').val(roletype_code);
						enable_zone_circle_basedon_role(roletype_code);
						$('#email').val(response['email']);
						// $('#user_type').val(response['usertype_id']);
						// $('#gpf_no').val(response['emp_gpfno']);
						$('#emp_name').val(response['name']);
						$('#emp_id').val(response['empid']);
						$('#mob_no').val(response['mobilenumber']);
						$('#sel_district').val(response['distcode']);
						$('#distcode').val(response['distcode']);

						if((roletype_code==jc_roleid)||(roletype_code==dc_roleid)||(roletype_code==ac_roleid)|(roletype_code==cto_roletypecode))
						{
							// $('#sel_division').val(response['divisioncode']);
							get_division_data_basedon_roletype('roleid','sel_division',roletype_code,response['divisioncode']);

						
							if((roletype_code==dc_roleid)||(roletype_code==ac_roleid)||(roletype_code==cto_roletypecode))
							{
								get_zone_data(roletype_code,response['divisioncode'],response['zonecode'],'sel_division','sel_zone','roleid')
							}
							if((roletype_code==ac_roleid)||(roletype_code==cto_roletypecode))
							{
								get_circle_data(roletype_code,response['divisioncode'],response['zonecode'],response['circleid'],'sel_division','sel_zone','sel_circle','roleid')
							}
						}

						// if (response['lott_executor'] == 'Y') //if is_active value is 'Y' checked the yes radio button, else no radio button.
						// {
						// 	document.getElementById("yes_lottexecutor").checked = true;
						// } else
						// 	document.getElementById("no_lottexecutor").checked = true;	

						// 	if (response['nodal'] == 'Y') //if is_active value is 'Y' checked the yes radio button, else no radio button.
						// {
						// 	document.getElementById("yes_nodal").checked = true;
						// } else
						// 	document.getElementById("no_nodal").checked = true;	

						$('#dob').val(convert_dateto_dd_mm_yy_format_with_slash(response['dateofbirth']));
						$('#dob').datepicker('setDate',convert_dateto_dd_mm_yy_format_with_slash(response['dateofbirth']));
			
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



