<div class="modal fade" id="change_pwd_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="change_pwd_modal_alert_header" class="text-white" style="margin-left: 150px;">
                    Profile Update </h3>

                <button type="button" class="btn-close bg-white" id="close_btn" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                <div class="alert alert-danger alert-dismissible fade show " role="alert" id="change_pwd_display_error" style="display:none">
											<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
										</div>
                  
                    <!-- <p id="change_pwd_modal_alert_body">

                    </p> -->
                    <form id="update_profile" method="POST">
                        <div class="mb-3">
                            <label class="col-form-label required">Address Line 1</label>
                            <input class="form-control" autocomplete="off" name="address1" id="address1" type="text"  placeholder="Enter your Address" maxlength='100' minlength="10"/>

                        </div>
                        <div class="mb-3">
                            <label class="col-form-label required">Address Line 2</label> 
                            <input class="form-control" autocomplete="off" name="address2" id="address2" type="text" placeholder="Enter your Address2"  maxlength='100' minlength="10"/>

                        </div>
                        <div class="mb-3">
                            <label class="col-form-label required">Pincode</label>
                            <input class="form-control only_numbers" autocomplete="off" name="pincode" id="pincode" type="text" placeholder="Enter your Pincode" maxlength="6"/>

                        </div>
                        <!-- <div class="text-center mt-3">
                            <a href="dashboard-default.html" class="btn btn-lg btn-primary">Sign up</a>
                             <button type="submit" class="btn btn-lg btn-primary">Sign up</button> 
                        </div> -->
                        <div class="text-center mt-3">
                            <button type="submit" class="btn  btn-success">Submit</button>
                            <!-- id="ok_btn" onclick="change_pwd_fun()"        -->
                        </div>
                    </form>
                    
                    <div class="mb-3"></div>
                </div>
                <!-- <div class="modal-footer">
                </div> -->
            </div>
        </div>
    </div>
</div>



<div class="modal fade" id="confirmation_alert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;"></h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body"></p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="ok_button" style="display:none" >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()" style="display:none">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Author: stalin Thomas  --->

<!-- Allotment Confirm Box --->
<div class="modal fade" id="allotment_confirmation_alert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Allotment Confirmation</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 <table id="records_table" class="table table-bordered">
                <tr>
                    <th>District</th>
                    <th>Zonal</th>
                    <th>Count</th>
                     <th>Total</th>
                </tr>
            </table>

                    <p id="alert_body">
                       
                        Maximum of <span class ="winners_class w3-badge" style="
                       /* color: #fff!important;
                            background-color: #f44336!important;
                            border-radius: 50%;
                            display: inline-block;
                            padding-left: 8px;
                            padding-right: 8px;
                            text-align: center;*/
                        
                        
                        
                        
                        
                        "></span> member(s) at each district will be selected automatically by the system.After the Allotment It will not revert back .<br>
                        Do you  want to finalise now?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="ok_button" onclick="allotment_fetch_data()" >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Allotment Confirm Box --->








<!-- Forward Confirm Box --->
<div class="modal fade" id="forward_confirmation_alert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                       
                       
                        Do you  want to Forward now?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="ok_button" onclick="role_forward()" >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forward Confirm Box  --->





<!-- Allotment Confirm Box --->
<div class="modal fade" id="enable_confirmation_alert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Selection Count TextBox Process ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="ok_button" onclick="enable_select_count_text_box()" >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Allotment Confirm Box --->



<!-- jc_success_message --->
 <div class="modal fade" id="jc_success_message" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white">Allotment Confirmation</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <h4 id="alert_body">
                       Success fully Forwarded To JC 
                    </h4>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="ok_button" onclick="reload_function()" >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div> 

<!-- jc_success_message --->



<!-- DC success_message --->
 <div class="modal fade" id="dc_success_message" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <h4 id="alert_body">
                       Success fully Forwarded To AC 
                    </h4>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="ok_button" onclick="reload_function()" >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div> 

<!-- DC_success_message --->



<!-- Forward to JC2 Confirm Box --->
<div class="modal fade" id="jc_two_confirmation_alert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white">Allotment Confirmation</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <h3 id="alert_body">
                        Selected Details will be Forwarded to Nodal Person of Division
                    </h3>
                    <div class="mb-3">
                        Are you sure to Continue?

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success action-btn" data-bs-dismiss="modal" id="ok_button" data-action="role_forward"  >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Forward to JC2 Confirm Box --->




<!-- Revert Back to  ADC Confirm Box1 --->
<div class="modal fade" id="adc_one_confirmation_alert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Revert Back ADC  ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="ok_button" onclick="revert_back_to_adc_two()" >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revert Back to  ADC Confirm Box 1 --->



<!-- Revert Back to  ADC Confirm Box2 --->
<div class="modal fade" id="adc_two_confirmation_alert" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Revert Back to  ADC  ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success action-btn" data-bs-dismiss="modal" id="ok_button" data-action="role_revertback"  >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revert Back to  ADC Confirm Box2 --->

<!-- Author: stalin Thomas  --->


<!-- 17-04-23-->
<!-- DC -->


<!-- Forward --->
<div class="modal fade" id="dc_fwd_one" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Forward DC 1 ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="ok_button" onclick="forward_to_dc_two()" >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forward  --->



<!-- Forward  --->
<div class="modal fade" id="dc_fwd_two" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Forward DC 2 ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success action-btn" data-bs-dismiss="modal" id="ok_button" data-action="role_forward"  >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Forward --->


<!-- Forward --->
<div class="modal fade" id="ac_fwd_one" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Forward AC ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="ok_button" onclick="forward_to_ac_two()" >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Forward  --->



<!-- Forward  --->
<div class="modal fade" id="ac_fwd_two" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Forward AC 2 ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success action-btn" data-bs-dismiss="modal" id="ok_button" data-action="role_forward"  >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Forward --->




<!-- Revert Back --->
<div class="modal fade" id="jc_rb_one" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Revert Back JC  ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                   
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="reload_function()">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revert Back  --->



<!-- Revert Back to  ADC Confirm Box2 --->
<div class="modal fade" id="jc_rb_two" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Revert Back to  JC 2  ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success action-btn" data-bs-dismiss="modal" id="ok_button" data-action="role_revertback"  >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revert Back  --->


<!-- DC -->









<!-- AC -->


<!-- Verify --->
<div class="modal fade" id="ac_verify_one" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Verify  ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="ok_button" onclick="verify_to_ac_two()" >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Verify  --->



<!-- Verify  --->
<div class="modal fade" id="ac_verify_two" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Verify ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success action-btn" data-bs-dismiss="modal" id="ok_button" data-action="role_forward"  >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!--Verify --->




<!-- Revert Back --->
<div class="modal fade" id="dc_rb_one" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Revert Back DC   ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="ok_button" onclick="reload_function()" >Ok</button>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revert Back  --->

<!-- Verified Successfully --->
<div class="modal fade" id="verified_success" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                       Verified Successfully  ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="ok_button" onclick="reload_function()" >Ok</button>
                    
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Verified Successfully --->



<!-- Revert Back to  ADC Confirm Box2 --->
<div class="modal fade" id="dc_rb_two" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" style="margin-left: 150px;">Lot Selection Process</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <p id="alert_body">
                        Are You Sure to Revert Back to  DC 2  ?
                    </p>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-success action-btn" data-bs-dismiss="modal" id="ok_button" data-action="role_revertback"  >Ok</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal" id="process_button" style="display:none"></button>
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">Cancel</button>
                </div>
            </div>
        </div>
    </div>
</div>




<div class="modal fade" id="no_records" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header" style="background-color:#06163a;">

                <h3 id="alert_header" class="text-white" >Allotment Confirmation</h3>

                <button type="button" id="button_close" class="btn-close bg-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="container">
                 

                    <h3 id="alert_body" style="text-align: center;">No Records</h3>
                    <div class="mb-3"></div>
                </div>
                <div class="modal-footer">
                    
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal" id="cancel_button" onclick="cancel_confirmation_box()">OK</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revert Back  --->


<!-- AC -->


<!-- 17-04-2023-->