<?php
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');
include('./././public/dash/layout/alert.php');

?>

	<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
	<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">  

	<div class="main-content">
		<div class="page-content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-xl-12 mbl_view  page_content_up">
						<div class="card" >
							<div class="card-header card_header_color" >Update Nodal Person</div>
							<div class="card-body">

							<div class="alert alert-danger alert-dismissible fade show disable_this" role="alert" id="display_error">
								<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
							</div>

								<form method="post" id="updateuser_form">

									<div class="row">
											<div class="col-md-6" id="division_div">
												<label class=" col-form-label required">District Name</label>
												<div class="form-group row">
													<div class="col-sm-12">
														<?php
														$Basemodel = new Basemodel;
														$Basemodel->tablename = "mybillmyright.mst_district";
														$id = 'distename';
														$data = ($Basemodel->getMultipleData(array(), $id));
														?>
														<select class="form-select " name="sel_dist" id="sel_dist"  onchange="gettingusernames_basedon_division()">
															<option value=''>-- Select District Name --</option><?php
															foreach ($data as $value) 
															{ ?>
																<option value="<?= htmlspecialchars($value->distcode); ?>"><?=  htmlspecialchars($value->distename); ?></option><?php
															} ?>
														</select>
													</div>
												</div>
											</div>
										
										<div class="col-md-6">
											<div class="mb-3">
												<label for="validationCustom01" class="form-label lable_size required">User </label>
												<select class="form-select" id="userid" name="userid" required  >
													<option selected value=''>Select User</option>
													<?php 
													
													$Basemodel = new Basemodel;
													$Basemodel->tablename = "mybillmyright.mst_dept_user";
									
													$del = array();
													$id = 'userid';
													$data = ($Basemodel->getMultipleData($del, $id));

													foreach ($data as $value) 
													{ 
														if($_SESSION['user']->userid ==$value->userid )
														{?>
															<option value="<?= htmlspecialchars($value->userid); ?>"><?= htmlspecialchars($value->name); ?></option>
															<?php 
														} 
													} ?>
														
												</select>
											</div>
										</div>

										<div class="col-md-6">
											<div class="mb-3">
												<label for="validationCustom03" class="form-label lable_size required">Nodal Person</label>
												<select class="form-select" id="yesno" name="yesno" required >
													<option value=''>--select --</option>
													<option value='Y'>Yes</option>
													<option value='N'>No</option>
													
												</select>
											</div>
										</div>
										
									</div>
									
											<br>
											<br>
											<center>
												<!-- <button class="btn btn-primary" type="submit">Submit</button> -->
												<input type="hidden" name="action" id="action" value="update" />
												<input type="submit" name="button_action" id="button_action" class="btn mt-2 updatebutton" value="Update" />
												<button type="reset" class="btn mt-2 btn-danger" onclick="reset_user_form()">clear</button>

											</center>
										</div>
										<span class="text_redcolour">*Marked fields are mandatory</span>

								</form>
							</div>
						</div>
						<!-- end card -->
					</div> <!-- end col -->

				</div>

				<div class="card">
					<div class="card-header card_header_color">List of Nodal Person</div>
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


    // function reset_form()
	// {
	// 	$('#sel_dist').val('');
	// 	$("#userid").empty();
	// 	$("#userid").append(" <option value=''>--- Select User Name---</option> ");
	// }



	window.onload = load_function();

	function load_function()
	{
		fetch_data();
	}

	function gettingusernames_basedon_division()
	{
		//jc names only

		$("#userid").empty();
		$("#userid").append(" <option value=''>--- Select User Name---</option> ");
		
		var distcode	=	$('#sel_dist').val();

		if(distcode)
		{
			$.ajax({
				url: '<?php echo URLROOT; ?>Configuration/gettingusernames_basedon_division',
				paging: true,
				data:  {
					distcode: distcode
				},
				dataType: "json",
				method: "POST",
				success: function(data, textStatus, jqXHR) 
				{
					if (jqXHR.status == '200') 
					{
						
						for (var i = 0; i < data.length; i++) 
						{
							// if (zonecode == data[i]['name'])
							// 	$("#userid").append("<option value='" + data[i]['userid'] + "'selected>" + data[i]['name'] + "</option>");
							// else
								$("#userid").append("<option value='" + data[i]['userid'] + "'>" + data[i]['name'] + "</option>");
						}
					
					}
				},

			});
		}
		else
		{
			// $('#state_code').removeAttr("disabled");
			// $('#state_code').val('');
		}
	}

	function reset_user_form()
	{
		$('#display_error').hide();
		valiator.resetForm();

		$('#sel_dist').val('');
		$("#userid").empty();
		$("#userid").append(" <option value=''>--- Select User Name---</option> ");
		$('#yesno').val('');			
	}

	var valiator = $('#updateuser_form').validate({

		// Specify validation rules
		rules: {
			sel_dist: {
				required: true
				
			},
			userid: {
				required: true
			},
			yesno: {
				required: true,
			},
		},
		// Specify validation error messages
		messages: {

			sel_division: {
				required: "Select Division name"
			},
			userid: {
				required: "Select User name"
			},
			yesno: "Select Nodal Person yes or no",
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
			var form_data = $('#updateuser_form').serialize();

			$.ajax({
				url: "<?php echo URLROOT; ?>Configuration/update_nodal_person",
			
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
						if (getting_buttion_action == 'update') 
						{
							passing_alert_value('Confirmation', 'Nodal person has been updated successfully', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
							reset_user_form()
							fetch_data() 
						}					
					}
				},
				error: function(xhr, status, error) 
				{
					var err = JSON.parse(xhr.responseText);						
					if(err.code==409)	
					{
						$("#display_error").show();
						$('#display_error').html("Nodal person Already Exists for the division");
						
					}
						
					if(err.code== 601)
						alert('Not Inserted')
							
				}
				
			}).fail(function($xhr){


			});
		}

	});	


	function fetch_data() 
		{
			$.ajax({
				url: '<?php echo URLROOT; ?>Configuration/nodalperson_data',
				paging: "true",
				dataType: "html",
				data : 
				{
					// csrf    :   $('#csrf').val(),
					// page_name  : 'form'
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


</script>

<?php include('./././public/dash/layout/footer.php'); ?>