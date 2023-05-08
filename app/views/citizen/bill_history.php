<?php

include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');
?>
<style>

.ui-datepicker-clear 
{
	display:none;
}

.card_header_color
  {
    background:#2a3042;
    font-size: 15px;
    color:white;
    text-align:center;
    font-weight: bold;
    font-family: arial,sans-serif,verdana;
  }

  
  .disable_this
  {
    display:none;
  }

  .text_redcolour
 {
  color:#ff0000; font-size:80%!important;
 }

 .datatables-basic td, .datatables-basic th {
    border: 1px solid #ddd;
    padding: 8px;
  }
  
  .datatables-basic tr:nth-child(odd){background-color: #f2f2f2;}
  
  .datatables-basic tr:hover {background-color: #ddd;}
  
  .datatables-basic th {
    padding-top: 12px;
    padding-bottom: 12px;
    text-align: left;
    background-color: #6b6b6c;
    color: white;
  }
</style>
<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">  
		<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">  

<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">

            <div class="row">
                <div class="col-xl-12 mbl_view">

                    <div class="card">
                        <div class="card-header card_header_color">Bill History</div>
                        <div class="card-body">
							<div class="row">
								<div class="col-md-1"></div>
								<div class="col-md-4">
									<div class="mb-3">
										<label for="validationCustom01" class="form-label">From Date</label>
										<!-- <input type="date" class="form-control only_numbers" id="from_date" placeholder="Bill Number" name="from_date" value=""  > -->
										<div class="input-group">
											<input type="text" class="form-control" id="from_date"  required name="from_date" readonly="readonly" onclick="calling_datepicker('from_date')">
											<div class="input-group-append">
												<button class="btn btn-light" id="from_date_btn" type="button" onclick="calling_datepicker('from_date')">
													<i class="fa fa-calendar" aria-hidden="true"></i>
												</button>
											</div>
										</div>
									</div>
								</div>

								<div class="col-md-1"></div>

								<div class="col-md-4">
									<div class="mb-3">
									<label for="validationCustom04" class="form-label">To Date</label>
									<!-- <input type="date" class="form-control name" id="to_date" placeholder="Shop Name" name="to_date"  onchange="fetch_data()"> -->
									<div class="input-group">
										<input type="text" class="form-control" id="to_date"  required name="to_date" readonly="readonly" onclick="calling_datepicker('to_date')" onchange="fetch_data()">
										<div class="input-group-append">
											<button class="btn btn-light" id="to_date_btn" type="button" onclick="calling_datepicker('to_date')">
												<i class="fa fa-calendar" aria-hidden="true"></i>
											</button>
										</div>
									</div>
							</div>
						</div>

					</div>

                    <div id="datatables"></div>
                        
                </div>

                    <!-- end card -->
            </div> <!-- end col -->
        </div> <!-- container-fluid -->
    </div>

</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> 
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
 
<script src="https://cdn.datatables.net/1.10.8/js/jquery.dataTables.min.js" defer="defer"></script>


<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script> 	
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="<?php echo URLROOT; ?>public/site/js/custom_validate.js"></script>



<script>
window.onload = set_datepicker_min_maxdate();


function set_datepicker_min_maxdate()
{
	view_datepicker('from_date','','N','','','bill_history');
	view_datepicker('to_date','','N','','','bill_history');
	const date = new Date();
	var maxdate= new Date(date.getFullYear(), date.getMonth() - 1, 0);
	var mindate= new Date(date.getFullYear(), date.getMonth() - 4, 1);
	$("#from_date").datepicker('setDate',mindate);
	$("#to_date").datepicker('setDate',maxdate);
}



function get_the_bill_history_data()
{
  fetch_data();
}

    	fetch_data();
      function calling_datepicker(value)
{

    var dateToday = new Date();

	var mindate = '-4M';
	var maxdate = '-1M';

    end_yr=dateToday.getFullYear() - 18;
    st_yr=dateToday.getFullYear() - 70;
    date_range=(st_yr + ":" + end_yr);

    view_datepicker(value,date_range,'N',mindate,maxdate,'bill_history');

    // $( "#dob"  ).datepicker( "option", "yearRange", '2006:2010' );
    // $( "#dob" ).datepicker("yearRange",  '1950 : 2000');     
}

	function fetch_data() 
  {
    var from_date = $('#from_date').val();
    var to_date = $('#to_date').val();


    if($('#from_date').val());
      var from_date = convert_dateto_yy_mm_dd_format_with_hyphen(from_date);
    if($('#to_date').val())
      var to_date = convert_dateto_yy_mm_dd_format_with_hyphen(to_date)
    
		$.ajax({
			url: '<?php echo URLROOT; ?>Citizen/bill_data_history',
			paging: true,
			method: "POST",
      data : 
      {
        "from_date" : from_date,
        "to_date" : to_date
      },
			success: function(data, textStatus, jqXHR) {
				if (jqXHR.status == '200') {
					if (data == 0)
						$('#datatables').html("<br><center> No Data Available </center>");
					else {
						$('#datatables').html(data);
						$('#datatables-basic').DataTable();
					}
				}
			},

		});
	}

</script>

<?php include('./././public/dash/layout/footer.php'); ?>