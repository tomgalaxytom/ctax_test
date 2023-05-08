<?php

include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');
?>
 <div class="main-content">

<div class="page-content">
    <div class="container-fluid">

        <div class="row">
            <div class="col-xl-12 mbl_view">
          
                <div class="card">
                <div class="card-header" style="background:#2a3042;">
                                                <h4 style="color:white">
                                                    <center>Change Password</center>
                                                </h4>
                                            </div>
                    <div class="card-body">
                      
                        <form class="needs-validation" novalidate>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom01" class="form-label">Current Password</label>
                                        <input type="text" class="form-control" id="validationCustom01"
                                            placeholder="Current Password" value="" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="validationCustom02" class="form-label">New Password</label>
                                        <input type="text" class="form-control" id="validationCustom02"
                                            placeholder="New Password" value="" required>
                                        <div class="valid-feedback">
                                            Looks good!
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                
                                    <div class="col-md-6">
                                        <div class="mb-3">
                                            <label for="validationCustom04" class="form-label">Confirm Password</label>
                                            <input type="text" class="form-control" id="validationCustom04"
                                            placeholder="Confirm Password" required>
                                        </select>
                                            <div class="invalid-feedback">
                                                Please provide a valid city.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                       
                                    </div>
                            
                                </div>
                          
                            <div>
                                <br>
                                <br>
                                <center>
                                <button class="btn btn-primary" type="submit">Submit</button>
                                </center>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- end card -->
            </div> <!-- end col -->

          
        </div>
        <!-- end row -->
       

    </div> <!-- container-fluid -->
</div>

</div>

<?php include('./././public/dash/layout/footer.php'); ?>
