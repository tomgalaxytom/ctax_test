<?php
   include('./././public/dash/layout/header.php');
   include('./././public/dash/layout/sidebar.php');
   include('./././public/dash/layout/alert.php');
   
   ?> 
   
   	<style>
		.abstract_card {
			width: 350px;
			height: 150px;
			background: #07182E;
			position: relative;
			display: -webkit-box;
			display: -ms-flexbox;
			display: flex;
			place-content: center;
			place-items: center;
			overflow: hidden;
			border-radius: 20px;
		}

		.abstract_card h2 {
			z-index: 1;
			color: white;
			font-size: 2em;
		}

		// .abstract_card::before {
			content: '';
			position: absolute;
			width: 100px;
			background-image: -webkit-gradient(linear, left top, left bottom, from(rgb(0, 183, 255)), to(rgb(255, 48, 255)));
			background-image: linear-gradient(180deg, rgb(0, 183, 255), rgb(255, 48, 255));
			height: 130%;
			-webkit-animation: rotBGimg 3s linear infinite;
			animation: rotBGimg 3s linear infinite;
			-webkit-transition: all 0.2s linear;
			transition: all 0.2s linear;
		}//

		@-webkit-keyframes rotBGimg {
			from {
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
			}

			to {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
			}
		}

		@keyframes rotBGimg {
			from {
			-webkit-transform: rotate(0deg);
			transform: rotate(0deg);
			}

			to {
			-webkit-transform: rotate(360deg);
			transform: rotate(360deg);
			}
		}

		.abstract_card::after {
			content: '';
			position: absolute;
			background: #07182E;
			;
			inset: 5px;
			border-radius: 15px;
		}

		button:focus,
		input:focus,
		textarea:focus,
		select:focus {
			outline: none;
		}

		.tabs {
			display: block;
			display: -webkit-flex;
			display: -moz-flex;
			display: flex;
			-webkit-flex-wrap: wrap;
			-moz-flex-wrap: wrap;
			flex-wrap: wrap;
			margin: 0;
			overflow: hidden;
		}

		.tabs [class^="tab"] label,
		.tabs [class*=" tab"] label {
			color: #efedef;
			cursor: pointer;
			display: block;
			font-size: 1.1em;
			font-weight: 300;
			line-height: 1em;
			padding: 2rem 0;
			text-align: center;
		}

		.tabs [class^="tab"] [type="radio"],
		.tabs [class*=" tab"] [type="radio"] {
			border-bottom: 1px solid rgba(239, 237, 239, 0.5);
			cursor: pointer;
			-webkit-appearance: none;
			-moz-appearance: none;
			appearance: none;
			display: block;
			width: 100%;
			-webkit-transition: all 0.3s ease-in-out;
			-moz-transition: all 0.3s ease-in-out;
			-o-transition: all 0.3s ease-in-out;
			transition: all 0.3s ease-in-out;
		}

		.tabs [class^="tab"] [type="radio"]:hover,
		.tabs [class^="tab"] [type="radio"]:focus,
		.tabs [class*=" tab"] [type="radio"]:hover,
		.tabs [class*=" tab"] [type="radio"]:focus {
			border-bottom: 1px solid #fd264f;
		}

		.tabs [class^="tab"] [type="radio"]:checked,
		.tabs [class*=" tab"] [type="radio"]:checked {
			border-bottom: 2px solid #fd264f;
		}

		.tabs [class^="tab"] [type="radio"]:checked+div,
		.tabs [class*=" tab"] [type="radio"]:checked+div {
			opacity: 1;
		}

		.tabs [class^="tab"] [type="radio"]+div,
		.tabs [class*=" tab"] [type="radio"]+div {
			display: block;
			opacity: 0;
			padding: 2rem 0;
			width: 90%;
			-webkit-transition: all 0.3s ease-in-out;
			-moz-transition: all 0.3s ease-in-out;
			-o-transition: all 0.3s ease-in-out;
			transition: all 0.3s ease-in-out;
		}

		.tabs .tab-2 {
			width: 50%;
		}

		.tabs .tab-2 [type="radio"]+div {
			width: 200%;
			margin-left: 200%;
		}

		.tabs .tab-2 [type="radio"]:checked+div {
			margin-left: 0;
		}

		.tabs .tab-2:last-child [type="radio"]+div {
			margin-left: 100%;
		}

		.tabs .tab-2:last-child [type="radio"]:checked+div {
			margin-left: -100%;
		}
	</style>


	<link href="https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css" rel="stylesheet">
	<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet"> 

	
	
	<?php
		$result =   $this->invoice_count();
		foreach ($result as $value) 
		{
			$invoice_count = htmlentities($value['billuploaded_count']);   
		}

		$resultdata =   $this->user_count();
		foreach ($resultdata as $value) 
		{
			$division = htmlentities($value['created_user']);   
			$zone = htmlentities($value['created_charge']);   
			$circle = htmlentities($value['assigned_charge']);   
		}
    ?> 
<div class="main-content">
	<div class="page-content">

	
<div class="container"><h1>Bootstrap  tab panel example (using nav-pills)  </h1></div>
<div id="exTab1" class="container">	
<ul  class="nav nav-pills">
			<li class="active">
        <a  href="#1a" data-toggle="tab">Overview</a>
			</li>
			<li><a href="#2a" data-toggle="tab">Using nav-pills</a>
			</li>
			<li><a href="#3a" data-toggle="tab">Applying clearfix</a>
			</li>
  		<li><a href="#4a" data-toggle="tab">Background color</a>
			</li>
		</ul>

			<div class="tab-content clearfix">
			  <div class="tab-pane active" id="1a">
          <h3>Content's background color is the same for the tab</h3>
				</div>
				<div class="tab-pane" id="2a">
          <h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
				</div>
        <div class="tab-pane" id="3a">
          <h3>We applied clearfix to the tab-content to rid of the gap between the tab and the content</h3>
				</div>
          <div class="tab-pane" id="4a">
          <h3>We use css to change the background color of the content to be equal to the tab</h3>
				</div>
			</div>
  </div>


<hr></hr>
<div class="container"><h2>Example tab 2 (using standard nav-tabs)</h2></div>

<div id="exTab2" class="container">	
<ul class="nav nav-tabs">
			<li class="active">
        <a  href="#1" data-toggle="tab">Overview</a>
			</li>
			<li><a href="#2" data-toggle="tab">Without clearfix</a>
			</li>
			<li><a href="#3" data-toggle="tab">Solution</a>
			</li>
		</ul>

			<div class="tab-content ">
			  <div class="tab-pane active" id="1">
          <h3>Standard tab panel created on bootstrap using nav-tabs</h3>
				</div>
				<div class="tab-pane" id="2">
          <h3>Notice the gap between the content and tab after applying a background color</h3>
				</div>
        <div class="tab-pane" id="3">
          <h3>add clearfix to tab-content (see the css)</h3>
				</div>
			</div>
  </div>

<hr></hr>

<div class="container"><h2>Example 3 </h2></div>
<div id="exTab3" class="container">	
<ul  class="nav nav-pills">
			<li class="active">
        <a  href="#1b" data-toggle="tab">Overview</a>
			</li>
			<li><a href="#2b" data-toggle="tab">Using nav-pills</a>
			</li>
			<li><a href="#3b" data-toggle="tab">Applying clearfix</a>
			</li>
  		<li><a href="#4a" data-toggle="tab">Background color</a>
			</li>
		</ul>

			<div class="tab-content clearfix">
			  <div class="tab-pane active" id="1b">
          <h3>Same as example 1 but we have now styled the tab's corner</h3>
				</div>
				<div class="tab-pane" id="2b">
          <h3>We use the class nav-pills instead of nav-tabs which automatically creates a background color for the tab</h3>
				</div>
        <div class="tab-pane" id="3b">
          <h3>We applied clearfix to the tab-content to rid of the gap between the tab and the content</h3>
				</div>
          <div class="tab-pane" id="4b">
          <h3>We use css to change the background color of the content to be equal to the tab</h3>
				</div>
			</div>
  </div>


<!-- Bootstrap core JavaScript
    ================================================== -->
	<!-- Placed at the end of the document so the pages load faster -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
	
	</div>
</div>

	<!-- <div class="main-content">
		<div class="page-content">
			<div class="container-fluid">
				<div class="row">
					<div class="tabs">
						<div class="tab-2">
							<label for="tab2-1" style="color: black;">Process Allotment</label>
							<input id="tab2-1" name="tabs-two" type="radio" checked="checked" />
							<div>
								<div class="row">
								<div class="col-md-12">
									<!-- Stalin-->
									<!-- <ul class="nav nav-tabs">
  <li class="nav-item">
    <a class="nav-link active" aria-current="page" href="#">Active</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="#">Link</a>
  </li>
  <li class="nav-item">
    <a class="nav-link disabled">Disabled</a>
  </li>
</ul> -->
									<!-- Stalin-->
								<!-- </div> -->
									<!-- <div class="col-md-2">
										
									</div>


									<div class="col-md-4">
										<div class="card abstract_card">
											<h2>Total Invoice</h2>
											<h2 class="text-right" style="color: white;" id="invoice_value">
												<i class="f-left"></i>
												<span> <?php echo $invoice_count ?> </span>
											</h2>
										</div>
									</div>
									<div class="col-md-4">
										<div class="card abstract_card">
											<h2>Allotted Invoice</h2>
										</div>
									</div> -->
								</div>
							</div>
						</div>
						<div class="tab-2">
							<label for="tab2-2" style="color: black;">Approval Selection </label>
							<input id="tab2-2" name="tabs-two" type="radio" />
							<div>
								<div class="row">
									<div class="col-md-4">
										<div class="card abstract_card" onclick="dashboard_reports('create_user')">
											<h2>Total User</h2>
											<h2 class="text-right" style="color: white;" id="invoice_value">
												<i class="f-left"></i>
												<span> <?php echo $division ?> </span>
											</h2>
										</div>
									</div>
									<div class="col-md-4">
										<div class="card abstract_card" onclick="dashboard_reports('create_charge')">
											<h2>Total Charge</h2>
											<h2 class="text-right" style="color: white;" id="invoice_value">
												<i class="f-left"></i>
												<span> <?php echo $zone ?> </span>
											</h2>
										</div>
									</div>
									<div class="col-md-4">
										<div class="card abstract_card" onclick="dashboard_reports('assigned_charge')">
											<h2>Charge Assigned </h2>
											<h2 class="text-right" style="color: white;" id="invoice_value">
												<i class="f-left"></i>
												<span> <?php echo $circle ?> </span>
											</h2>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="card" id="table" style="display:none">
						<div class="card-header" id="card_color" style="background:#54585b;">
							<center>
								<h4 style="color:white" id="report_heading"> </h4>
							</center>
						</div>
						<div class="card-body">
							<div id="datatables"></div>
							<center>
								<a class="btn btn-danger" onclick="fun_close()"> Close </a>
							</center>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	 -->

	<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
	<script src="<?php echo URLROOT; ?>public/dash/cdn/js/datatables.min.js" defer="defer"></script>
	<script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script> <?php include('./././public/dash/layout/footer.php'); ?> <script>
 
		const buttons = document.querySelectorAll(".menu__item");
		let activeButton = document.querySelector(".menu__item.active");
		buttons.forEach(item => {
		const text = item.querySelector(".menu__text");
		setLineWidth(text, item);
		window.addEventListener("resize", () => {
		setLineWidth(text, item);
		})
		item.addEventListener("click", function() {
		if (this.classList.contains("active")) return;
		this.classList.add("active");
		if (activeButton) {
			activeButton.classList.remove("active");
			activeButton.querySelector(".menu__text").classList.remove("active");
		}
		handleTransition(this, text);
		activeButton = this;
		});
	});

	function setLineWidth(text, item) {
		const lineWidth = text.offsetWidth + "px";
		item.style.setProperty("--lineWidth", lineWidth);
	}

	function handleTransition(item, text) {
		item.addEventListener("transitionend", (e) => {
		if (e.propertyName != "flex-grow" || !item.classList.contains("active")) return;
		text.classList.add("active");
		});
	}

		function dashboard_reports(value) 
        {
            if (value == 'create_user') 
            {
             
                $("#report_heading").html("Create User");
                document.getElementById("card_color").style.backgroundColor = "#07182e";
                var url='<?php echo URLROOT; ?>Dashboard/dashboardreport';
            } 
            else if (value == "create_charge") {
                $("#report_heading").html("Create Charge");
                document.getElementById("card_color").style.backgroundColor = "#07182e";
                
                var url='<?php echo URLROOT; ?>Dashboard/dashboardreport';
            } 
            else if (value == "assigned_charge") {
                $("#report_heading").html("Charge Assigned");
                document.getElementById("card_color").style.backgroundColor = "#07182e";
                
                var url='<?php echo URLROOT; ?>Dashboard/dashboardreport';
            } 
          
            
            $.ajax({
                url: url,
                paging: true,
                type: 'POST',
                data: {
                    action: value,
                    // csrf    :   $('#csrf').val()
                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        $('#table').show();
                        $('#datatables').html(data);

						
                        $('#dashboard_table').DataTable({
                            dom: 'Bfrtip',
                            buttons: [{
                                extend: 'collection',
                                text: 'Export',
                                buttons: [
                                    'copy',
                                    'excel',
                                    'csv'
                                    
                                ]
                            }],
                            pageLength: 5,
                            lengthMenu: [
                                [5, 10, 20, 25, -1],
                                [5, 10, 20, 25, 'All']
                            ]
                        });
                        
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

		function fun_close() {
            $('#table').hide();
        }


</script>