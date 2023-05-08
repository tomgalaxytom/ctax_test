<!DOCTYPE html>
<html lang="en">
<style>
@media(max-width:600px){
  .govt_head .g_row1 {
  padding: 2%;
}
  .g_row1 [class*="col"]:nth-child(odd) {
  width: 28%;
}
  .g_row1 [class*="col"]:nth-child(even) {
  width: 70%;
}
.g_row1 h4, .g_row1 h5, .g_row1 h6 {
  font-size: 11px;
}

.g_row2{
  justify-content: center;
}
.dropdown{
  margin-left: -13px ! important;
}

}

</style>
<head>
	<!-- set the encoding of your site -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
  
	<!-- set the page title -->
	<title>Commercial Tax</title>
	<!-- inlcude google nunito sans font cdn link -->
	<link rel="preconnect" href="https://fonts.gstatic.com/">
	<link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,300;0,400;0,600;0,700;1,300;1,400;1,600;1,700&amp;display=swap" rel="stylesheet">
	<!-- inlcude google cabin font cdn link -->
	<link href="https://fonts.googleapis.com/css2?family=Cabin:ital,wght@0,400;0,500;0,600;0,700;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet">
	<!-- include the site bootstrap stylesheet -->
	<link rel="stylesheet" href="<?php echo URLROOT; ?>public/site/css/bootstrap.css">
	<!-- include the site stylesheet -->
	<link rel="stylesheet" href="<?php echo URLROOT; ?>public/site/css/style.css">
	<!-- include theme color setting stylesheet -->
	<link rel="stylesheet" href="<?php echo URLROOT; ?>public/site/css/colors.css">
	<!-- include the site responsive stylesheet -->
	<link rel="stylesheet" href="<?php echo URLROOT; ?>public/site/css/responsive.css">


</head>

<body>
	<!-- pageWrapper -->
	<div id="pageWrapper">
		<!-- phStickyWrap -->
		<div class="phStickyWrap">
			<!-- pageHeader -->
			<section class="govt_head">
        <div class="container ">
            <div class="row g_row_main">
                <div class="col-md-8">
                    <a href="<?php echo URLROOT; ?>">
                        <div class="row g_row1">
                            <div class="col-md-2">
                                <img src="<?php echo URLROOT; ?>public/site/images/tn__logo.png" width="75%" height="75%">
                            </div>
                            <div class="col-md-10 p-0" style="color:black;margin-top: 3%;">
                                <h5  class="nameline3">Commercial Taxes Department</h5>
                                <h5  class="nameline2">Government of TamilNadu</h5>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4">
                    <div class="row">
                        <div class="col-lg-12" style="text-align: right;">
                            <ul>
                              <span class="px-2"> <label for="Screen Reader Access" style="color: #214E75;  font-size: 10px;"> <a  href="<?= URLROOT ;?>pages/Screen_recorder">Screen Reader Access</label></span> </a>
                                <span class="px-2 decrease" style="border: 1px solid black;border-radius:5px;font-size:8px;cursor: pointer;">A-</span>
                                <span class="px-2 resetMe" style="border: 1px solid black;border-radius:5px;font-size:8px;cursor: pointer;">A</span>
                                <span class="px-2 increase" style="border: 1px solid black;border-radius:5px;font-size:8px;cursor: pointer;">A+</span>
                            </ul>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="text-align: right;">


                            <div class="glast" style=" justify-content: end; display: flex;">


                                <div class="glast">
							<span> Language:</span>	
                                    <select class="translate" id="translate" style="border-radius: 10px; border-color: #0262af;">
                                        <option value="en" style="font-family: 'poppins', sans-serif !important; font-size:16px; line-height: 27px;">English</option>
                                        <option value="ta" style="font-family: 'poppins', sans-serif !important; font-size:16px;  line-height: 27px;">தமிழ்</option>
                                    </select>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </section>
				<div class="hdFixerWrap py-2 sSticky" style="background-color: #1E3D5D;">
				<div class="container">
					<nav class="navbar navbar-expand-lg navbar-light">
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item active">
	  <a class="nav-link" href="<?php echo URLROOT; ?>" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">Home</a>
      </li>
      <li class="nav-item">
	  <a class="nav-link" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">About Us</a>
      </li>
     
      <li class="nav-item">
	  <a class="nav-link" href="javascript:void(0);" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color:white;">Contact Us</a>

      </li>
    </ul>
	<form class="form-inline">
	<a href="<?php echo URLROOT; ?>user/login" class="btn btn-outline-secondary bdrWidthAlter btnHd text-capitalize position-relative border-0 p-0" data-hover="Login">       
	 <span class="d-block btnText" style="color:white;">Login</span>
    </a>
    <a href="<?php echo URLROOT; ?>user/dept_login" class="btn btn-outline-secondary bdrWidthAlter btnHd text-capitalize position-relative border-0 p-0" data-hover="Department Login">       
	 <span class="d-block btnText" style="color:white;">Department Login</span>
    </a>
	
    <!-- <button class="" type="button">Login</button> -->
  </form>
  </div>
</nav>
					</div>
					</div>
			</header>
		</div>

	</div>

</body>

</html>