<?php
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');
include('./././public/dash/layout/alert.php');

?>

<!-- Date picker css -->
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
<!-- Datatable Css -->
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">  

<div class="main-content">
	<div class="page-content">
		<div class="container-fluid page_content_up">

		<div class="row">
			<div class="col-12">

						<div class="card">
							<div class="card-header card_header_color">Assigned User-Charge Details</div>
							<div class="card-body"><br>
								<div id="datatables"></div><br>
								<span class="text_redcolour">*Marked fields are mandatory</span>
							</div>
						</div>
					
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
fetch_data();

function fetch_data() 
		{
			$.ajax({
				url: '<?php echo URLROOT; ?>/User_management/usercharge_data',
				paging: "true",
				dataType: "html",
				data : 
				{
					csrf    :   $('#csrf').val(),
                    page_name   :   'view'
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


        </script>