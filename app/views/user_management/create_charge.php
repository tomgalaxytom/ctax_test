<?php
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');
include('./././public/dash/layout/alert.php');

?>

<!-- Date picker css -->
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
<!-- Datatable Css -->
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">  
<?php $session	=	$this->session_details(); 
		$session_roleid	=	$session[0]->roletypecode;
		$session_divisioncode	=	$session[0]->divisioncode;
		
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
							<div class="card-header card_header_color">Department Charge Creation</div>
							<div class="card-body">
								<form class="forms-sample " id="createcharge_form" name="createcharge_form" method="POST" action="">
									<div class="alert alert-danger alert-dismissible fade show disable_this" role="alert" id="display_error">
										<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
									</div>
									<!-- Use hidden text box for storing configid - used at the time of updation and deletion -->
									<input type="hidden" id="chargeid" name="chargeid">
									<input type="hidden" id="distcode" name="distcode">

									<div class="row">

										<div class="col-md-6">
											<label class=" col-form-label required">Enter Role</label>
											<div class="form-group row">
												<div class="col-sm-12">
													<select class="form-select " name="roleid" id="roleid" onchange="enable_basedon_roletypecode('','')">
														<option value=''>---- Select Role Type ----</option>
														<?php 
														$Basemodel = new Basemodel;
														$Basemodel->tablename = "mybillmyright.mst_roletype";
														$id = 'roletypecode';
														$data = ($Basemodel->getMultipleData(NULL, $id));
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
											<label class=" col-form-label required">Role Action</label>
											<div class="form-group row">
												<div class="col-sm-12">
													<!-- <input type="text" name="roleactioncode" id="roleactioncode"  autocomplete="off" class="form-control name" maxlength="50" placeholder="Enter Employee Name" oninput="fn_captilise_each_word('charge_des')" /> -->
													<select name="roleactioncode" id="roleactioncode"  class="form-select" onchange="get_district('','','','','','roleid','sel_division','sel_zone','sel_circle','sel_district','distcode')">
														<option value=''>--- Select Role Action Name---</option>
													</select>
												</div>
											</div>
										</div>

										<div class="col-md-6">
											<label class=" col-form-label required">Charge Description</label>
											<div class="form-group row">
												<div class="col-sm-12">
													<input type="text" name="charge_des" id="charge_des"  autocomplete="off" class="form-control alpha_numeric" maxlength="50" placeholder="Enter Charge Description" />
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
										<button type="reset" class="btn btn-danger" onclick="reset_user_form_with_session_detail()" id="1">clear</button>
									</div>
									<div class="mb-3"></div>
								</form>
							</div>
						</div>
						<div class="card">
							<div class="card-header card_header_color">Department Charge Details</div>
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
<script src="<?php echo URLROOT; ?>public/dash/cdn/js/datatables.min.js" defer="defer"></script>

<script>

		var nic_roleid	=	'<?php echo $this->nic_roletypecode ?>';
		var adc_roleid	=	'<?php echo $this->adc_roletypecode ?>';
		var jc_roleid	=	'<?php echo $this->jc_roletypecode ?>';
		var dc_roleid	=	'<?php echo $this->dc_roletypecode ?>';
		var ac_roleid	=	'<?php echo $this->ac_roletypecode ?>';
		var cto_roletypecode	=	'<?php echo $this->cto_roletypecode ?>';



    window.onload=loading_page_function();

	function loading_page_function()
	{
		check_session_detail();
		fetch_data();
	}


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
		}
	}



	function calling_datepicker(value)
	{
		var dateToday = new Date();
		st_yr	=	- 70;
		end_yr	=	- 18;
		date_range=(st_yr + ":" + end_yr);

		view_datepicker(value,date_range,'N','','','create_user'); 
	}

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

			change_button_as_insert('createcharge_form','action','button_action','display_error');
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
			if((session_roleid==nic_roleid)||(session_roleid==adc_roleid))
			{
				if($('#roleid').val())
				{
					get_division_data_basedon_roletype('roleid','sel_division',$('#roleid').val(),'');
				}
			}
			
		}
		function enable_zone_circle_basedon_role(roleid,roleactioncode)
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
					if((rolebox_type == ac_roleid)|| (rolebox_type==cto_roletypecode)||(rolebox_type == dc_roleid)||(rolebox_type == jc_roleid))
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
				get_roleaction_basedon_roletype('',roleactioncode);
			}
			else
			{
				reset_user_form_with_session_detail()
			}	
		}


		
        function get_roleaction_basedon_roletype(roletypecode,roleactioncode)
        {
			if(roletypecode == '')
				roletypecode	=	$('#roleid').val();
			
			if(roletypecode)
			{
				$.ajax({
                    url: '<?php echo URLROOT; ?>/User_management/get_roleaction_basedon_roletype',
                    type: 'POST',
                    data: {
                        roletypecode: roletypecode,
                    }, //passing id and action msg as fetch to the respective Controller page with function name.
                    dataType: 'json', //Response data type as json.
					success: function(data, textStatus, jqXHR) 
					{
						if(jqXHR.status=='200')
						{
							$("#roleactioncode").empty();
							$("#roleactioncode").append(" <option value=''>--- Select Charge Role--</option> ");
							for (var i = 0; i <  data.length; i++) 
							{
								if (roleactioncode == data[i]['roleactioncode']) 
									$("#roleactioncode").append("<option value='" + data[i]['roleactioncode'] + "'selected>" + data[i]['roleactionlname'] + " </option>");
								else
									$("#roleactioncode").append("<option value='" + data[i]['roleactioncode'] + "'>" + data[i]['roleactionlname'] + " </option>");
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
					},

            
                });
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
					get_district('','','','','','roleid','sel_division','sel_zone','sel_circle','sel_district','distcode')
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
					get_district('','','','','','roleid','sel_division','sel_zone','sel_circle','sel_district','distcode')

				else if(($('#roleid').val()==ac_roleid)||($('#roleid').val()==cto_roletypecode))
					get_circle_data('','','','','sel_division','sel_zone','sel_circle','roleid');
			}
			else if($('#sel_zone').val()=='')
				$('#sel_circle').val('');
				
			else
				alert('select division and zone name');
		}



		function fetch_data() 
		{
			$.ajax({
				url: '<?php echo URLROOT; ?>/User_management/chargecreation_data',
				paging: "true",
				dataType: "html",
				data : 
				{
					csrf    :   $('#csrf').val(),
					page_name   :   'form'
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
				},
			});
		}



		var valiator = $('#createcharge_form').validate({
			// Specify validation rules
			rules: {

				charge_des: {
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
				
			},
			// Specify validation error messages
			messages: {
				charge_des: "Enter Charge Description",
			
				
				sel_division: "Select Division Name",
				sel_zone: "Select Zone Name",
				sel_circle: "Select Circle Name",
				roleid:	"Select Role Name"
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
				else
				{
					error.insertAfter(element);
				}
			},
			submitHandler: function(form) 
			{
				event.preventDefault();

				var form_data = $('#createcharge_form').serialize(); // All form data in a form_data variable.
				$.ajax({
					url: "<?php echo URLROOT; ?>/User_management/insert_update_createcharge",
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
								passing_alert_value('Confirmation', 'Department Charge has been added Successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
								fetch_data();
								reset_user_form_with_session_detail();
							}
							else if(getting_buttion_action	==	'update')
							{
								passing_alert_value('Confirmation', 'Department Charge has been updated successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
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
						{
							$("#display_error").show();
							$('#display_error').html("Charge Already Exists");
						}
						if(err.code==691)
						{
							alert('Role Not Created');
						}
							
										
						
					},
					
				});
				
			}
		});


	$(document).on('click', '.edit_charge', function() 
		{
			reset_user_form();
			var id = $(this).attr('id'); //Getting id of user clicked edit button.
			var action = 'fetch_single'; //Make as fetch single
			$('#chargeid').val(id);
			$.ajax({
				url: '<?php echo URLROOT; ?>User_management/edit_charge/',
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
						roletypecode	=	response['roletypecode'];

						change_button_as_update('createcharge_form','action','button_action','display_error');
						// enable_disenable_personal_fields(response['user_restriction']);
						// getting_data_for_dist_suffix_code(response['office_code'], response['dist_code'], response['hud_code'], 'hud_div', 'sel_hud', 'dist_div', 'sel_dist', 'sel_inst', 'sel_office',response['suffix_code'])
						// enable_field_basedon_usertype(response['office_code'],response['usertype_id']);                 
						// if(response['usertype_id']==4)
						// 	get_inst('sel_inst', response['inst_id'], 'sel_dist', response['dist_code'], 'sel_office', response['office_code'], 'sel_hud', response['hud_code']) 

						$('#roleid').val(roletypecode);
						enable_zone_circle_basedon_role(roletypecode,response['roleactioncode']);
						// $('#user_type').val(response['usertype_id']);
						// $('#gpf_no').val(response['emp_gpfno']);
						$('#charge_des').val(response['chargedescription']);
						
						$('#sel_district').val(response['distcode']);
						$('#distcode').val(response['distcode']);

						if((roletypecode==jc_roleid)||(roletypecode==dc_roleid)||(roletypecode==ac_roleid)||(roletypecode==cto_roletypecode))
						{
							
							// $('#sel_division').val(response['divisioncode']);
							get_division_data_basedon_roletype('roleid','sel_division',roletypecode,response['divisioncode']);
						
							if((roletypecode==dc_roleid)||(roletypecode==ac_roleid)||(roletypecode==cto_roletypecode))
							{
								get_zone_data(roletypecode,response['divisioncode'],response['zonecode'],'sel_division','sel_zone','roleid')
							}
							if((roletypecode==ac_roleid)||(roletypecode==cto_roletypecode))
							{
								get_circle_data(roletypecode,response['divisioncode'],response['zonecode'],response['circleid'],'sel_division','sel_zone','sel_circle','roleid')
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
		});







</script>



