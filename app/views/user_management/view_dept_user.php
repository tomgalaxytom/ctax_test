<?php
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');
include('./././public/dash/layout/alert.php');

?>

<!-- Datatable Css -->
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">  


	<div class="main-content">
		<div class="page-content">
			<div class="container-fluid page_content_up">
				<div class="row">
					<div class="col-12">
						<!-- <div class="card" style="width: 100%;">
							<div class="card-body"> -->

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


	<!-- Datatable JS -->
	<script src="<?php echo URLROOT; ?>public/dash/cdn/js/datatables.min.js" defer="defer"></script>


	<script>



		fetch_data() ;


		function fetch_data() 
		{
			$.ajax({
				url: '<?php echo URLROOT; ?>/User_management/usercreation_data',
				paging: "true",
				dataType: "html",
				data : 
				{
					csrf    :   $('#csrf').val(),
                    page_name  : 'view'
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



