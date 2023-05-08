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
						<div class="card-header card_header_color" > Bill Details </div>
						<div class="card-body">

						<div class="alert alert-danger alert-dismissible fade show disable_this" role="alert" id="display_error">
												<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
						</div>

							<form method="post" id="bill_upload">
								<input type="hidden" name="bill_update_id" id="bill_update_id">
								<input type="hidden" name="fwd_id" id="fwd_id">
								<input type="hidden" name="billstart" id="billstart">
								<input type="hidden" name="billend" id="billend">
								<input type="hidden" name="minimumamount" id="minimumamount">
								<input type="hidden" name="file_upload_status" id="file_upload_status" value='Y'>
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom01" class="form-label lable_size required">Invoice Number <span
                                                        style="color:#ff0000; font-size:10px;">( Enter Last 5 Numbers )<span></label>
											<input type="text" class="form-control only_numbers" id="bill_number" placeholder="Invoice Number" name="bill_number" value="" maxlength="10" required onchange="generate_invoice_number()">

										</div>
									</div>
									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom04" class="form-label lable_size required">Shop Name</label>
											<input type="text" class="form-control name" id="shop_name" placeholder="Shop Name" name="shop_name" maxlength="100" required>

										</div>
									</div>

								</div>
								<div class="row">
									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom03" class="form-label lable_size required">Shop Located District</label>
											<select class="form-select" id="shop_dist" name="shop_dist" required onchange="basedon_district()">
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
										 <label for="validationCustom02" class="form-label lable_size required">Date of Purchase Previous Month</label>
										<!-- <div class="mb-3">
											<input type="date" class="form-control" id="bill_date" placeholder="Last name" name="bill_date" value="" required disabled>
											
										</div> -->
										<div class="input-group">
											<input type="text" class="form-control" id="bill_date"  required name="bill_date" readonly="readonly" onclick="calling_datepicker('bill_date')" disabled>
											<div class="input-group-append">
												<button class="btn btn-light" id="bill_date_btn" type="button" onclick="calling_datepicker('bill_date')">
													<i class="fa fa-calendar" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
								</div>
								<div class="row">

									<div class="col-md-6">
										<div class="mb-3">
											<label for="validationCustom04" class="form-label lable_size required">Invoice Amount</label>
											<input type="text" class="form-control only_numbers" name="bill_amount" id="bill_amount" placeholder="Invoice Amount" maxlength="9" required disabled>

										</div>
									</div>

									<div class="col-md-6">
										<div id="enable_document">
											<label class=" col-form-label lable_size required">Upload Invoice Copy
											<span
                                                        style="color:#ff0000; font-size:10px;">( Max Size : 1
                                                        MB & File Format :Jpg & Png )<span>
											</label>
											<div class="form-group row">
												<div class="col-sm-12">
													<input type="file" class="form-control name" name="bill_upload" id="bill_upload" accept="image/jpeg, image/gif, image/png" data-max-size="1000000" required />
												</div>
											</div>
										</div>



										<div id="disenable_document" style="display:none">

											<label class=" col-form-label lable_size required">Invoice Copy
											<span
                                                        style="color:#ff0000; font-size:10px;">(Max Size : 1
                                                        MB & File Format : Pdf,Jpg & Png )<span>
											</label>
											<div class="form-group row">
												<div class="col-sm-12">
													<span id="bill_upload_filename"></span> <a id="disabled_file" onclick="destroy_file('enable_document','disenable_document')"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
															<path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
															<path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
														</svg> </a>
												</div>

											</div>



										</div>





									</div>

									<div>
										<br>
										<br>
										<center>
											<!-- <button class="btn btn-primary" type="submit">Submit</button> -->
											<input type="hidden" name="action" id="action" value="insert" />
											<input type="submit" name="button_action" id="button_action" class="btn mt-2 btn-primary" value="Save" />
											<button type="reset" class="btn mt-2 btn-danger" onclick="reset_bill_form()">clear</button>

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
										<div class="card-header card_header_color">List of Bill Details</div>
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


<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 	
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>

 
   <script>


	function generate_invoice_number() 
	{
		var invoice_number = $('#bill_number').val().padStart(10,'0');
		$('#bill_number').val(invoice_number);
	}

function calling_datepicker(value)
{

    var dateToday = new Date();

	var mindate = $('#billstart').val();
	var maxdate = $('#billend').val();

    end_yr=dateToday.getFullYear() - 18;
    st_yr=dateToday.getFullYear() - 70;
    date_range=(st_yr + ":" + end_yr);

    view_datepicker(value,date_range,'N',mindate,maxdate,'bill');

    // $( "#dob"  ).datepicker( "option", "yearRange", '2006:2010' );
    // $( "#dob" ).datepicker("yearRange",  '1950 : 2000');     
}



function toget_dateonly(value)
{
	const date = value.split(" ");   
	return date[0];
}

	fetch_data();

	$('#display_error').hide();

	function basedon_district() 
	{
		var dist = $('#shop_dist').val();
		if (dist) 
		{
			$("#bill_amount").removeAttr("disabled");
			$("#bill_date").removeAttr("disabled");

			$.ajax({
				url: '<?php echo URLROOT; ?>Citizen/getting_config_details',
				paging: true,
				data:  {
				dist: dist
			},
			    dataType: "json",
				method: "POST",
				success: function(data, textStatus, jqXHR) {
					if (jqXHR.status == '200') {
						var minimumamount = $('#minimumamount').val(data[0].minimumbillamt);
						var billstart = $('#billstart').val(data[0].billpurchasestartdate);
						var billend = $('#billend').val(data[0].billpurchaseenddate);
						// document.getElementById("bill_date").min=toget_dateonly(data[0].billentrystartdate);
						// document.getElementById("bill_date").max=toget_dateonly(data[0].billentryenddate);

						// $('#bill_date').datepicker('option', 'minDate', new Date(data[0].billentrystartdate));
						// $('#bill_date').datepicker('option', 'maxDate', new Date(data[0].billentryenddate));

						$('#bill_date').datepicker('option', 'minDate', new Date(data[0].billpurchasestartdate));
						$('#bill_date').datepicker('option', 'maxDate', new Date(data[0].billpurchaseenddate));
						// toget_dateonly(data[0].billentrystartdate);
						// alert(data[0].billentrystartdate);
						// alert(data[0].billentryenddate);
						// $('')
					}
				},

			});
		} 
		else 
		{
			$("#bill_amount").attr("disabled", "disabled");
			$("#bill_date").attr("disabled", "disabled");


		}
	}

	function fetch_data() 
	{
		$.ajax({
			url: '<?php echo URLROOT; ?>Citizen/bill_data',
			paging: true,
			method: "POST",
			success: function(data, textStatus, jqXHR) {
				if (jqXHR.status == '200') {
					if (data == 0)
						$('#datatables').html("<br><center> No Data Available </center>");
					else {
						$('#datatables').html(data);
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
						
					}
				}
			},

		});
	}


	var valitator = $('#bill_upload').validate({

		// Specify validation rules
		rules: {

			bill_number: {
				required: true,
				min:1
			},
			bill_date: {
				required: true
			},
			shop_name: {
				required: true
			},

			shop_dist: {
				required: true
			},

			bill_amount: {
				required: true,
				minamt	: 0,
			},

			bill_upload: {
				required: true
			}

		},
		// Specify validation error messages
		messages: {

			bill_number: {
				required: "Please enter a bill number"
			},
			shop_name: {
				required: "Please enter a shop name"
			},
			bill_date: "Please choose bill purchased date",
			shop_dist: {
				required: "Please select District"
			},
			bill_amount: {
				required: "Please enter a Bill amount"
			},
			bill_upload: {
				required: "Please upload Bill"
			},



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
			// var form_data = $('#bill_upload').serialize();
			var form_data = new FormData(document.getElementById("bill_upload"));

			$('input[type=file][data-max-size]').each(function(){
            if(typeof this.files[0] !== 'undefined'){
                var maxSize = parseInt($(this).attr('max-size'),10),
                size = this.files[0].size;
                isOk = maxSize > size;
                return isOk;
            }
		});

			$.ajax({
				url: "<?php echo URLROOT; ?>Citizen/bill_upload",
				dataSrc: "active",
				method: "POST",
				data: form_data,
				dataType: "json",
				processData: false,
				contentType: false,

				success: function(data, textStatus, jqXHR) {

					// $number = data.split(":");
					// alert(ack_no);
					if (jqXHR.status == '200') 
					{

						var err = JSON.parse(jqXHR.responseText);
						ack_no = err['ack_no']	;
						$('#display_error').hide();
						getting_buttion_action = $('#action').val();
						if (getting_buttion_action == 'insert') 
						{
							passing_alert_value('Confirmation', 'Bill Detail has been Submitted Successfully . Your Acknowledgement Number is : '+ack_no, 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
							change_button_as_insert('bill_upload', 'action', 'button_action', '', '');
						} else if (getting_buttion_action == 'update') 
						{
							$('#file_upload_status').val('N');
							passing_alert_value('Confirmation', 'Bill Detail has been Updated Successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
							change_button_as_insert('bill_upload', 'action', 'button_action', '', '');
						}
						fetch_data();
						$('#enable_document').show();
						$('#disenable_document').hide();

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
				
			}).fail(function($xhr) {


			});
		}

	});


	$(document).on('click', '.edit_bill', function() 
	{
		var id = $(this).attr('id'); //Getting id of user clicked edit button.
		$('#bill_update_id').val(id);

		$.ajax({
			url: '<?php echo URLROOT; ?>Citizen/edit_bill',
			paging: true,
			data: {
				id: id
			},
			method: "POST",
			dataType: 'json', //Response data type as json.
			success: function(response, textStatus, jqXHR) {
				if (jqXHR.status == '200') {
					
					$('#file_upload_status').val('N');
					change_button_as_update('bill_upload', 'action', 'button_action', 'error', '', '')

					if (response.filename == null) 
					{
						$('#enable_document').show();
						$('#disenable_document').hide();
					} 
					else 
					{
						$('#disenable_document').show();
						$('#enable_document').hide();
						var dot = '.';
						var fileextension = response.fileextension;
						var filepath	=	 response.filepath;

						var loc = "<?php echo ('https://rtionline.tn.gov.in/ctax/gstweb/uploads/');?>"+filepath;
						var filesize = '('.concat(response.filesize).concat(')');
						$('#bill_upload_filename').html('<a href='+loc+' target="_blank">'+(response.filename).concat(dot).concat(fileextension).concat(filesize)+'</a>');
						// $('#bill_upload_filename').html((response.filename).concat(dot).concat(fileextension).concat(filesize));
						document.getElementById('bill_upload_filename').style.color = "red";
					}
					$('#shop_dist').val(response['distcode']);
					$('#bill_number').val(response['billnumber']);

					$('#bill_date').val(convert_dateto_dd_mm_yy_format_with_slash(response['billdate']));
					$('#bill_date').datepicker('setDate',convert_dateto_dd_mm_yy_format_with_slash(response['billdate']));

					$('#shop_name').val(response['shopname']);
					$('#bill_amount').val(response['billamount']);
					basedon_district();

				}
			},
			error: function(xhr, status, error) {
		
				var err = JSON.parse(xhr.responseText);

				if (err.code == 413) {
					// $("#display_error").show();
					// $('#display_error').html("101_611 Please contact Admin");
					alert('Extra characters included')

				}
				if (err.code == 403)
					alert('csrf token invalid')

				if (err.code == 400)
					alert('Bad request');
			},


		});
	});

	function destroy_file(enable, disable) {
		if (confirm("Are you sure to delete the uploaded file?")) {
			$('#' + enable).show();
			$('#' + disable).hide();
			$('#file_upload_status').val('Y');
		}
	}

	$.validator.addMethod("minamt", function(value, element, min) {
			min	= parseInt($('#minimumamount').val());
			if(value >= min)
			{
				return true;
			}
			else 
			return false;

		}, "Please Enter Required Value" + $('#minimumamount').val());


		function reset_bill_form()
		{
			valitator.resetForm();
			change_button_as_insert('bill_upload', 'action', 'button_action', '', '');
			$('#enable_document').show();
			$('#disenable_document').hide();
			$('#file_upload_status').val('N');
	
		}

		$(document).on('click', '.freeze_bill', function() 
			{
				var id = $(this).attr('id');
				$('#fwd_id').val(id);
				document.getElementById("process_button").onclick = function() 
				{
					forwardbill();
				};
				passing_alert_value('Confirmation', 'Are you sure to Finalize Bill details?', 'confirmation_alert', 'alert_header', 'alert_body', 'forward_alert');
			});

			function forwardbill() 
			{
				var id = $('#fwd_id').val();
				$.ajax({
					url: '<?php echo URLROOT; ?>Citizen/forward_billdata',
					type: 'POST',
					data: {
						id: id,
					}, //passing id and action msg as fetch to the respective Controller page with function name.
					dataType: 'json', //Response data type as json.
					success: function(data, textStatus, jqXHR) 
					{
						if(jqXHR.status=='200')
						{
							passing_alert_value('Acknowledgement', 'Bill Detail has been Finalized successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
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


</script>
<?php include('./././public/dash/layout/footer.php'); ?>