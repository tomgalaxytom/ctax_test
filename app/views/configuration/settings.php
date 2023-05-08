<?php
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');
include('./././public/dash/layout/alert.php');

?>

<style>


</style>
		<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
		<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">  

		<div class="main-content">

	<div class="page-content">
		<div class="container-fluid">

			<div class="row">
				<div class="col-xl-12 mbl_view  page_content_up">
					<div class="card" >
						<div class="card-header card_header_color" >Settings</div>
						<div class="card-body">

						<div class="alert alert-danger alert-dismissible fade show disable_this" role="alert" id="display_error">
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>

							<form method="post" id="settings_form">
								<input type="hidden" name="configid" id="configid">
								

								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom01" class="form-label lable_size required">Scheme Name </label>
											<select class="form-select" id="scheme_code" name="scheme_code" required onchange="get_state_code()" >
												<option selected value=''>Select Scheme</option>
												<?php 
												
												$Basemodel = new Basemodel;
												$Basemodel->tablename = "mybillmyright.mst_scheme";
								
												$del = array();
												$id = 'schemecode';
												$data = ($Basemodel->getMultipleData($del, $id));

												foreach ($data as $value) { ?>
													<option value="<?= htmlspecialchars($value->schemecode); ?>"><?= htmlspecialchars($value->schemesname); ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom04" class="form-label lable_size required">State Name</label>
											<select class="form-select" id="state_code" name="state_code" required >
												<option selected value=''>Select State Name</option>
												<?php 
												
												$Basemodel = new Basemodel;
												$Basemodel->tablename = "mybillmyright.mst_state";
								
												$del = array();
												$id = 'statecode';
												$data = ($Basemodel->getMultipleData($del, $id));

												foreach ($data as $value) { ?>
													<option value="<?= htmlspecialchars($value->statecode); ?>"><?= htmlspecialchars($value->stateename); ?></option>
												<?php } ?>
											</select>										
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom03" class="form-label lable_size required">Allotment Type </label>
											<select class="form-select" id="allotmenttype" name="allotmenttype" required onchange="enablefields_basedon_allotmenttype()" >
												<option value=''>--Select Allotment Type--</option>
												<option value='S'>State</option>
												<option value='D'>District</option>
												
										
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom03" class="form-label lable_size required">District</label>
											<select class="form-select" id="dist_code" name="dist_code" required onchange="get_username_basedon_allotmenttype('','')">
												<option selected value=''>Select District</option>
												<?php
													$Basemodel = new Basemodel;
													$Basemodel->tablename = "mybillmyright.mst_district";

													$del = array();
													$id = 'distcode';
													$data = ($Basemodel->getMultipleData($del, $id));

												
												foreach ($data as $value) { ?>
													<option value="<?= htmlspecialchars($value->distcode); ?>"><?= htmlspecialchars($value->distename); ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom04" class="form-label lable_size required">Prize Amount</label>
											<input type="text" class="form-control only_numbers" name="prize_amt" id="prize_amt" placeholder="Prize Amount" maxlength="9" required >

										</div>
									</div>

									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom04" class="form-label lable_size required">Minimum Bill Amount</label>
											<input type="text" class="form-control only_numbers" name="min_amt" id="min_amt" placeholder="Minimum Bill Amount" maxlength="9" required >

										</div>
									</div>

									<div class="col-md-6">
										 <label for="validationCustom02" class="form-label lable_size required">Bill Entry Start Date</label>
										<!-- <div class="mb-3">
											<input type="date" class="form-control" id="bill_date" placeholder="Last name" name="bill_date" value="" required disabled>
											
										</div> -->
										<div class="input-group">
											<input type="text" class="form-control" id="bill_entry_start_date"  required name="bill_entry_start_date"  onclick="calling_datepicker('bill_entry_start_date')" >
											<div class="input-group-append">
												<button class="btn btn-light" id="bill_entry_start_btn" type="button" onclick="calling_datepicker('bill_entry_start_date')">
													<i class="fa fa-calendar" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										 <label for="validationCustom02" class="form-label lable_size required">Bill Entry End Date</label>
										<!-- <div class="mb-3">
											<input type="date" class="form-control" id="bill_date" placeholder="Last name" name="bill_date" value="" required disabled>
											
										</div> -->
										<div class="input-group">
											<input type="text" class="form-control" id="bill_entry_end_date"  required name="bill_entry_end_date" readonly="readonly" onclick="calling_datepicker('bill_entry_end_date')" disabled>
											<div class="input-group-append">
												<button class="btn btn-light" id="bill_entry_end_date_btn" type="button" onclick="calling_datepicker('bill_entry_end_date')">
													<i class="fa fa-calendar" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										 <label for="validationCustom02" class="form-label lable_size required">Bill Purchase start Date</label>
										<!-- <div class="mb-3">
											<input type="date" class="form-control" id="bill_date" placeholder="Last name" name="bill_date" value="" required disabled>
											
										</div> -->
										<div class="input-group">
											<input type="text" class="form-control" id="bill_purchase_start_date"  required name="bill_purchase_start_date" readonly="readonly" onclick="calling_datepicker('bill_purchase_start_date')" >
											<div class="input-group-append">
												<button class="btn btn-light" id="bill_purchase_start_date_btn" type="button" onclick="calling_datepicker('bill_purchase_start_date')">
													<i class="fa fa-calendar" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										 <label for="validationCustom02" class="form-label lable_size required">Bill Purchase End Date</label>
										<!-- <div class="mb-3">
											<input type="date" class="form-control" id="bill_date" placeholder="Last name" name="bill_date" value="" required disabled>
											
										</div> -->
										<div class="input-group">
											<input type="text" class="form-control" id="bill_purchase_end_date"  required name="bill_purchase_end_date" readonly="readonly" onclick="calling_datepicker('bill_purchase_end_date')" >
											<div class="input-group-append">
												<button class="btn btn-light" id="bill_purchase_end_date_btn" type="button" onclick="calling_datepicker('bill_purchase_end_date')">
													<i class="fa fa-calendar" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom03" class="form-label lable_size required">Finanical Year</label>
											<select class="form-select" id="fin_year" name="fin_year" required >
											
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom03" class="form-label lable_size required">Finanical Month</label>
											<select class="form-select" id="fin_month" name="fin_month" required >
												<option value=''>--Select Month--</option>
												<option value='01'>Janaury</option>
												<option value='02'>February</option>
												<option value='03'>March</option>
												<option value='04'>April</option>
												<option value='05'>May</option>
												<option value='06'>June</option>
												<option value='07'>July</option>
												<option value='08'>August</option>
												<option value='09'>September</option>
												<option value='10'>October</option>
												<option value='11'>November</option>
												<option value='12'>December</option>
											</select>
										</div>
									</div>
									
									<div class="col-md-6">
										 <label for="validationCustom02" class="form-label lable_size required">Bill Drawn Date</label>
										<!-- <div class="mb-3">
											<input type="date" class="form-control" id="bill_date" placeholder="Last name" name="bill_date" value="" required disabled>
											
										</div> -->
										<div class="input-group">
											<input type="text" class="form-control" id="bill_drawn_date"  required name="bill_drawn_date" onclick="calling_datepicker('bill_drawn_date')" disabled>
											<div class="input-group-append">
												<button class="btn btn-light" id="bill_drawn_date_btn" type="button" onclick="calling_datepicker('bill_drawn_date')">
													<i class="fa fa-calendar" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
									
									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom03" class="form-label lable_size required">Allotment Done By</label>
											<select class="form-select" id="bill_drawn_by" name="bill_drawn_by" required  disabled>
												<option selected value=''>Select District</option>
												<?php $Basemodel = new Basemodel;
												$Basemodel->tablename = "mybillmyright.mst_config";
												$del = array(
													
												);
												$select = "*";
												$data_verifer = array(
													'mybillmyright.mst_district' => "mybillmyright.mst_district.distcode = mybillmyright.mst_config.distcode",  
												);
												$id = 'distcode';
												$alias = 'mybillmyright.mst_config';
												$order_by = 'DESC';	

												$data = ($Basemodel->getMultipleJoin_query($select, $data_verifer, $del, $id, $alias, $order_by));
												foreach ($data as $value) { ?>
													<option value="<?= htmlspecialchars($value->distcode); ?>"><?= htmlspecialchars($value->distename); ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom03" class="form-label lable_size required">Bill Selection Count</label>
											<select class="form-select" id="bill_selection_count" name="bill_selection_count" required >
												<option value=''>-- Bill Selection count--</option>
												<option value='1'>1</option>
												<option value='2'>2</option>
												<option value='3'>3</option>
											
											</select>
										</div>
									</div>
								</div>
										<br>
										<br>
										<center>
											<!-- <button class="btn btn-primary" type="submit">Submit</button> -->
											<input type="hidden" name="action" id="action" value="insert" />
											<input type="submit" name="button_action" id="button_action" class="btn mt-2 btn-primary" value="Save" />
											<button type="reset" class="btn mt-2 btn-danger" onclick="reset_form()">clear</button>

										</center>
									</div>
									<span class="text_redcolour">*Marked fields are mandatory</span>

							</form>
						</div>
					</div>
					<!-- end card -->
				</div> <!-- end col -->

			</div>
			<!-- end row -->
			<!-- <div class="card-header" style="background:#2a3042;">
				<h4 style="color:white">
					<center>List of Bill Details</center>
				</h4>
							</div><br>
			
			<div id="datatables"></div> -->
			<div class="card">
										<div class="card-header card_header_color">List of Settings</div>
										<div class="card-body"><br>
											<div id="datatables"></div><br>
										</div>
									</div>


		</div> <!-- container-fluid -->
	</div>

</div>

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> 
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
 
<script src="<?php echo URLROOT; ?>public/dash/cdn/js/datatables.min.js" defer="defer"></script>

<script src="<?php echo URLROOT; ?>public/site/js/custom_validate.js"></script>

<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 	
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

 
<script>

	function reset_form()
	{
		valitator.resetForm();
		change_button_as_insert('settings_form', 'action', 'button_action', '', '');
		$("#bill_drawn_by").empty();
		$("#bill_drawn_by").append(" <option value=''>--- Select name---</option> ");
		$("#display_error").hide();
	}


    function enablefields_basedon_allotmenttype(allotmenttype) 
	{
		if(!(allotmenttype))
		{
			var allotmenttype = $('#allotmenttype').val();
		}
		
		if(allotmenttype=='D')
		{
			$("#bill_drawn_date").removeAttr("disabled");
			$("#bill_drawn_by").removeAttr("disabled");
		}
		else
		{
			$('#bill_drawn_date').val('');
			$("#bill_drawn_date").attr("disabled", "disabled");
			$("#bill_drawn_by").attr("disabled", "disabled");

			
		}
		$('#dist_code').val('');
		
		// get_username_basedon_allotmenttype(allotment_type,'');
		
	}

	function get_username_basedon_allotmenttype(allotment_type,userid)
	{
		$("#bill_drawn_by").empty();
		$("#bill_drawn_by").append(" <option value=''>--- Select name---</option> ");
		var allotment_type = $('#allotmenttype').val();
		if(allotment_type)
		{
			var distcode = $('#dist_code').val();
			$.ajax({
				url: '<?php echo URLROOT; ?>Configuration/get_username_basedon_allotmenttype',
				paging: true,
				data:  {
					allotment_type	:allotment_type,
					distcode: distcode
				},
				dataType: "json",
				method: "POST",
				success: function(data, textStatus, jqXHR) 
				{
					if (jqXHR.status == '200') 
					{
						
						if(allotment_type == 'S')
						{
							$("#bill_drawn_by").append("<option value='" + data[0]['userid'] + "'selected>" + data[0]['name'] + "("+ data[0]['roletypelname'] +")</option>");
						}
						else if(allotment_type == 'D')
						{
							for (var i = 0; i < data.length; i++) 
							{
								if (userid == data[i]['userid'])
									$("#bill_drawn_by").append("<option value='" + data[i]['userid'] + "'selected>" + data[i]['name'] + "</option>");
								else
									$("#bill_drawn_by").append("<option value='" + data[i]['userid'] + "'>" + data[i]['name'] + "</option>");
							}
						}
						
					
					}
				},

			});
		}
	}



	function calling_datepicker(value)
	{
		var dateToday = new Date();
		st_yr	=	'-1';
		end_yr	=	 '+0';

		date_range=(st_yr + ":" + end_yr);

		if(value=='bill_entry_start_date')
		{
			const date = new Date();
			var mindate= new Date(date.getFullYear(), date.getMonth() -2, 1);
        	var maxdate= new Date(date.getFullYear(), date.getMonth() -2, 0);
			$('#bill_entry_end_date').removeAttr("disabled");
		}
		if(value=='bill_entry_end_date')
		{
			
		}

		view_datepicker(value,date_range,'N',mindate,maxdate,'settings');   
	}

	function get_state_code(schemecode)
	{
		if(!(schemecode))
			var schemecode	=	$('#scheme_code').val();

		if(schemecode)
		{
			$.ajax({
				url: '<?php echo URLROOT; ?>Configuration/getting_state_code_basedon_scheme',
				paging: true,
				data:  {
					schemecode: schemecode
				},
				dataType: "json",
				method: "POST",
				success: function(data, textStatus, jqXHR) 
				{
					if (jqXHR.status == '200') 
					{
						$('#state_code').attr("disabled", "disabled");
						$('#state_code').val(data[0].statecode)
					
					}
				},

			});
		}
		else
		{
			$('#state_code').removeAttr("disabled");
			$('#state_code').val('');
		}
		
		
	}


	window.onload = function () 
	{
		$('#fin_year').empty();
		$("#fin_year").append(" <option value=''>--- Select Year---</option> ");
		//Reference the DropDownList.
		var ddlYears = document.getElementById("fin_year");

		//Determine the Current Year.
		var currentYear = (new Date()).getFullYear();

		//Loop and add the Year values to DropDownList.
		for (var i = 2010; i <= currentYear; i++) {
			var option = document.createElement("OPTION");
			option.innerHTML = i;
			option.value = i;
			ddlYears.appendChild(option);
		}
	};


	var valitator = $('#settings_form').validate({

		// Specify validation rules
		rules: {

			scheme_code: {
				required: true
				
			},
			dist_code: {
				required: true
			},
			prize_amt: {
				required: true,
			
			},

			bill_entry_start_date: {
				required: true
			},
			bill_entry_end_date: {
				required: true
			},
			bill_purchase_start_date: {
				required: true
			},
			bill_purchase_end_date: {
				required: true
			},

			fin_year: {
				required: true
			},
			fin_month: {
				required: true
			},

			bill_drawn_date:{
				required :true
			},bill_drawn_by:{
				required :true
			},
			allotmenttype:{
				required :true
			},
			min_amt:{
				required :true
			}

		},
		// Specify validation error messages
		messages: {

			scheme_code: {
				required: "Select Scheme name"
			},
			prize_amt: {
				required: "Enter prize amount"
			},
			bill_entry_start_date: "Select bill Entry Start date",
			bill_entry_end_date: "Select bill Entry End date",
			bill_purchase_start_date: "Select bill Purchase Start date",
			bill_purchase_end_date: "Select bill Purchase End date",

			dist_code: {
				required: "Select District"
			},
			fin_year: {
				required: "Select year"
			},
			fin_month: {
				required: "Select month"
			},
			bill_drawn_date: {
				required: "Select Bill drawn date"
			},
			bill_drawn_by: {
				required: "Select Bill drawn By"
			},
			allotmenttype:{
				required: "Select Allotment Type"
			},
			min_amt:{
				required :"Enter Minimum  Amount"
			}



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
		submitHandler: function(form) 
		{
			event.preventDefault();
			// var form_data = $('#settings_form').serialize();

			// var form_data = $('#settings_form').serializeArray();
			// 	form_data.push({
			// 		name: "state_userid",
			// 		value: $('#bill_drawn_by').val()
			// 	});

				var form_data = $('#settings_form').serializeArray(); // All form data in a form_data variable.

					form_data.push({
						name: "state_userid",
						value: $('#bill_drawn_by').val()
					});


			// var form_data = new FormData(document.getElementById("settings_form"));


			$.ajax({
				url: "<?php echo URLROOT; ?>Configuration/insert_update_config",
				method: "POST",
				data: form_data,
				dataType: "json",
			

				success: function(data, textStatus, jqXHR) 
				{

					// $number = data.split(":");
					var ack_no =jqXHR.responseText;
					// alert(ack_no);
					if (jqXHR.status == '200') 
					{
						$('#display_error').hide();
						
						getting_buttion_action = $('#action').val();
						if (getting_buttion_action == 'insert') 
						{
							passing_alert_value('Confirmation', 'Config Detail has been Submitted Successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
						} 
						else if (getting_buttion_action == 'update') 
						{
							passing_alert_value('Confirmation', 'Config Detail has been Updated Successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
						}
						reset_form();
						fetch_data();
					}

				},
				error: function(xhr, status, error) 
				{
					var err = JSON.parse(xhr.responseText);						
					if(err.code==409)	
					{
						$("#display_error").show();
						$('#display_error').html("Bill Detail Already Exists");
						
					}
						
					if(err.code== 601)
						alert('Not Inserted')
							
				}
				
			}).fail(function($xhr){


			});
		}

	});	

	fetch_data();

	function fetch_data() 
	{
		$.ajax({
			url: '<?php echo URLROOT; ?>/Configuration/config_data',
			paging: "true",
			dataType: "html",
			data : 
			{
				
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


	$(document).on('click', '.edit_config', function() 
	{
		valitator.resetForm();
		var id = $(this).attr('id'); //Getting id of user clicked edit button.
		var action = 'fetch_single'; //Make as fetch single
		$('#configid').val(id);
		$.ajax({
			url: '<?php echo URLROOT; ?>Configuration/edit_bill/',
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
					change_button_as_update('settings_form','action','button_action','display_error');

					enablefields_basedon_allotmenttype(response['allotmentby']) 

					$('#scheme_code').val(response['schemecode'])
					get_state_code(response['schemecode'])
					$('#dist_code').val(response['distcode']);
					$('#min_amt').val(response['minimumbillamt']);
					$('#prize_amt').val(response['prizeamount']);
					$('#fin_month').val(response['finmonth']);
					$('#fin_year').val(response['finyear']);
					$('#allotmenttype').val(response['allotmentby']);
					$('#bill_selection_count').val(response['bill_selection_count']);

					$('#bill_entry_start_date').val(convert_dateto_dd_mm_yy_format_with_slash_fordatetime(response['billentrystartdate']));
					$('#bill_entry_start_date').datepicker('setDate',convert_dateto_dd_mm_yy_format_with_slash_fordatetime(response['billentrystartdate']));

					$('#bill_entry_end_date').val(convert_dateto_dd_mm_yy_format_with_slash_fordatetime(response['billentryenddate']));
					$('#bill_entry_end_date').datepicker('setDate',convert_dateto_dd_mm_yy_format_with_slash_fordatetime(response['billentryenddate']));
		
					$('#bill_purchase_start_date').val(convert_dateto_dd_mm_yy_format_with_slash_fordatetime(response['billpurchasestartdate']));
					$('#bill_purchase_start_date').datepicker('setDate',convert_dateto_dd_mm_yy_format_with_slash_fordatetime(response['billpurchasestartdate']));
		
					$('#bill_purchase_end_date').val(convert_dateto_dd_mm_yy_format_with_slash_fordatetime(response['billpurchaseenddate']));
					$('#bill_purchase_end_date').datepicker('setDate',convert_dateto_dd_mm_yy_format_with_slash_fordatetime(response['billpurchaseenddate']));
		
					get_username_basedon_allotmenttype(response['allotmentby'],response['allotmentdoneby'])
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
<?php include('./././public/dash/layout/footer.php'); ?>