<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cdbootstrap/css/bootstrap.min.css"/>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/cdbootstrap/css/cdb.min.css"/>
  <script src="https://cdn.jsdelivr.net/npm/cdbootstrap/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/cdbootstrap/js/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/cdbootstrap/js/cdb.min.js"></script>
</head>
<body>
   <?php include('./././public/dash/layout/header.php');
   include('./././public/dash/layout/sidebar.php');?>
<div class="main-content"><!-- main-content-->
	<div class="page-content"><!-- main-content-->


		<ul class="nav nav-pills " id="ex1" role="tablist">
			<li class="nav-item" role="presentation">
				<a
					class="nav-link active"
					id="ex1-tab-1"
					data-bs-toggle="tab"
					href="#ex1-tabs-1"
					role="tab"
					aria-controls="ex1-tabs-1"
					aria-selected="true"
					>Process Allotment</a
					>
			</li>
			<li class="nav-item" role="presentation">
				<a
					class="nav-link"
					id="ex1-tab-2"
					data-bs-toggle="tab"
					href="#ex1-tabs-2"
					role="tab"
					aria-controls="ex1-tabs-2"
					aria-selected="false"
					>Approved Details</a
					>
			</li>
			
		</ul>
		<div class="tab-content" id="ex1-content">
			<div
				class="tab-pane fade show active"
				id="ex1-tabs-1"
				role="tabpanel"
				aria-labelledby="ex1-tab-1"
				>
				<!-- Content-->
				<form action="/action_page.php">
  <div class="form-group">
    <label for="email">Email address:</label>
    <input type="email" class="form-control" id="email">
  </div>
  <div class="form-group">
    <label for="pwd">Password:</label>
    <input type="password" class="form-control" id="pwd">
  </div>
  <div class="checkbox">
    <label><input type="checkbox"> Remember me</label>
  </div>
  <button type="submit" class="btn btn-default">Submit</button>
</form>
				<!-- Content-->
			</div>
			<div class="tab-pane fade" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">
				Tab 2 content
			</div>
			
		</div>
	</div><!-- main-content-->
</div><!-- main-content-->
	
</body>
</html>