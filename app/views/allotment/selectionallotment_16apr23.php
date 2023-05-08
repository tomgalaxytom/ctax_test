<!DOCTYPE html>
<html lang="en">
<?php
include('./././public/dash/layout/alert.php'); 
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');

?>
<!-- Datatable Css -->
<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">  



<div class="main-content">

    <div class="page-content">
        <div class="container-fluid mbl_view page_content_up">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body">
                                <?php
                                $roletypecode = $_SESSION['user']->roletypecode;

                                if($roletypecode == '02'){?>

                                    <div class="card  shadow mb-2 " id="allotment_form_card">
                                    <div class="card-header card_header_color"> Create Allotment </div>

                                    <div class="card-body ">
                                        <div class="alert alert-danger alert-dismissible" id="error" style="display:none;" name="error">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                        </div>

                                        <form class="forms-sample " id="privillage_form" name="privillage_form" method="POST" action="">
                                            <div class="alert alert-danger alert-dismissible" id="error" style="display:none;" name="error">
                                                <a href="#" cl+ass="close" data-dismiss="alert" aria-label="close">&times</a>
                                            </div>
                                            <!-- Use hidden text box for storing configid - used at the time of updation and deletion -->
                                            <input type="hidden" id="menuid" name="menuid">

                                            <!-- Districts and Maximum Selection Rows -->
                                            <?php
                                            $Basemodel = new Basemodel;
                                            $Basemodel->tablename = "mybillmyright.mst_district";
                                            $id = 'distename';
                                            $data = ($Basemodel->getMultipleData(NULL, $id));

                                            $Basemodel = new Basemodel;
                                            $Basemodel->tablename = "mybillmyright.mst_config";
                                            $id = 'configcode';
                                            $dataConfig = ($Basemodel->getMultipleData(NULL, $id));
                                            
                                            $database = new database;
                                            $database->query("select d.distcode,d.distename,c.allotment_status from mybillmyright.mst_district d left join mybillmyright.mst_config c on d.distcode = c.distcode order by d.distename asc");
                                            $data = $database->resultSet1();

                                            ?>

                                            <div class="row">
                                                <div class="col-md-12">
                                                        <label class=" col-form-label required">Select Districts</label>
                                                        <div class="form-group row">
                                                            <div class="col-sm-4">
                                                            <select class="form-select " name="distid" id="distid" onchange="enable_zone_circle_basedon_role('')">
                                                                <option value='all'>---- All ----</option>
                                                                <?php foreach ($data as $value) 
                                                                {
                                                                    if( $value['allotment_status'] == 'Y'){?>
                                                                        <option value="<?= htmlspecialchars($value['distcode']); ?>" disabled><?= htmlspecialchars($value['distename']); ?></option>   
                                                                   <?php }
                                                                    else{?>
                                                                        <option value="<?= htmlspecialchars($value['distcode']); ?>" ><?= htmlspecialchars($value['distename']); ?></option>   
                                                                  <?php  }
                                                                
                                                                    
                                                                    
                                                                    ?>
                                                                     
                                                                <?php }
                                                                ?>
                                                            </select>
                                                            </div>
                                                            <!-- <div class="col-sm-4">
                                                                <button type="reset" class="btn btn-danger" style="display:none" onclick="reset_enableform()" id="enableButton">Enable</button>
                                                            </div> -->
                                                        </div>
                                                </div>
                                                
                                            </div>
                                            <div class="row">
                                            <div class="col-md-6">
                                                    <label class=" col-form-label required">Maximum Selection</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control " name="menu" id="menu" />
                                                        </div>
                                                        <!-- <div class="col-sm-4">
                                                            <button type="reset" class="btn btn-danger" style="display:none" onclick="reset_enableform()" id="enableButton">Enable</button>
                                                        </div> -->
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Districts and Maximum Selection Rows -->

                                             <!-- Year, Month -->

                                             <div class="row">
                                             <div class="col-md-6">
                                                   
                                                  
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                        <label class=" col-form-label required">Year</label>
                                                                <?php $currently_selected = date('Y'); 
                                                                    // Year to start available options at
                                                                    $earliest_year = 2022; 
                                                                    // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
                                                                    $latest_year = date('Y'); 
        
                                                                    print '<select class=" form-select"  name="bill_year" id="bill_year">';
                                                                    // Loops over each int[year] from current year, back to the $earliest_year [1950]
                                                                    foreach ( range( $latest_year, $earliest_year ) as $i ) {
                                                                        // Prints the option with the next year in range.
                                                                        print '<option value="'.$i.'"'.($i === $currently_selected ? ' selected="selected"' : '').'>'.$i.'</option>';
                                                                    }
                                                                    print '</select>';
                                                                ?>
                                                                </div>
                                                            <div class="col-sm-4">
                                                            <label class=" col-form-label required">Month</label>
                                                                <select  class="form-select"  name="bill_month" id="bill_month">
                                                                    <?php
                                                                    $curmonth = date("F");
                                                                   // echo $curmonth;
                                                                    for ($i = 1; $i <= 12; $i++) {
                                                                        $month = date('F', strtotime("$i/12/10"));

                                                                        if (strlen($i) == 1) {
                                                                            $value = "0" . $i;
                                                                        } else {

                                                                            $value = $i;
                                                                        }
                                                                        if($curmonth == $month){
                                                                            $selected = 'selected';
                                                                        }
                                                                        else{
                                                                            $selected = ' ';
                                                                        }

                                                                        echo "<option value=$value $selected>$month</option> ";
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                            
                                                        </div>
                                                    </div><!-- form group row-->
                                            </div>
                                           <!-- Year, Month -->




                                            

                                            


                                           

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class=" col-form-label required">Rules Applied</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-12">
                                                        <ul>
                                                            <li>Minimum One Year in Current Station</li>
                                                            <li>Discipilinary Cases Nil</li>
                                                            <li>Preference of Date of Birth</li>
                                                        </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                            <br>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" >
                                                        <label class="form-check-label" for="flexCheckChecked">
                                                            Agreed,the terms and condition for Allotment Process
                                                        </label>
                                                    </div>
                                                </div>
                                                
                                            </div>

                                           

                                            
                                            <div class="mb-3"></div>

                                            <!-- Modal Footer with action button and close button -->

                                            <div style="text-align: center; ">
                                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                                <input type="hidden" name="action" id="action" value="insert" />
                                                <input type="submit" name="button_action" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Submit" id="button_action" class="btn  btn-primary button_save " value="Process Allotment"  />

                                                

                                                


                                                <!-- <button type="reset" class="btn btn-danger" onclick="reset_menuform()" id="1">Cancel</button> -->
                                                <button type="reset" class="btn btn-primary" id ="alloted_detail_btn" onclick="" id="1">Reset</button>
                                            </div>


                                            <!-- <div style="text-align: center; ">
                                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                            <input type="hidden" name="action" id="action" value="insert" />

                                            <input type="Save" name="button_action" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Submit" id="button_action" class="btn button_save" value="Save" />
                                            <button type="reset" class="btn btn-danger"  onclick="reset_menuform()" id="1">clear</button>
                                            </div> -->
                                            <div class="mb-3"></div>

                                        </form>

                                    </div>
                                </div>

                               <?php  } ?>




                                
                                <div class="card">
                                    <div class="card-header card_header_color"> Selection Details </div>
                                    <div class="card-body">
                                        <div id="datatables"></div>
                                        <br>
                                        <span style="color:#ff0000; font-size:80%!important;">*Marked fields are mandatory</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
        </div> <!-- container-fluid -->
    </div>

<!-- Modal -->


    <?php include('./././public/dash/layout/footer.php'); ?>


</div>

<!-- Datatable JS -->
<script src="<?php echo URLROOT; ?>public/dash/cdn/js/datatables.min.js" defer="defer"></script>


<script src="<?php echo URLROOT; ?>public/site/js/custom_validate.js"></script>
<script src="<?php echo URLROOT; ?>public/site/js/party/party.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>




    <script>
        var nic_roleid	=	'<?php echo $this->nic_roletypecode ?>';
      <?php  $session	=	$this->session_details(); 
		$session_roleid	=	$session[0]->roletypecode;
        
        ?>
        session_roleid='<?php echo $session_roleid?>';
    function getRole(){
        let user_type = '02';
        $.ajax({
                url: '<?php echo URLROOT; ?>/Allotment/get_rolename_basedon_usertype',
                type: 'POST',
                data: {
                    user_type: user_type,
                },
                dataType: 'json',
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {

                       let roleTypeId = '<?php echo  $session_roleid;?>';

                        debugger;
                        
                        $("#roleid").empty();
                        $("#roleid").append(" <option value=''>--- Select Role Name---</option> ");
                        for (var i = 0; i < data.length; i++) 
                        { 
                            if(roleTypeId == '01'){ //NIC ADMIN

                                if(roleTypeId != data[i]['roleid']){
                                    if(data[i]['roleid'] !="03" && data[i]['roleid'] !="04" && data[i]['roleid'] !="05"){
                                        $("#roleid").append("<option value='" + data[i]['roleid'] + "'>" + data[i]['rolelname'] + "</option>");
                                    }
                               
                                } 

                            }
                            else if(roleTypeId == '02'){ //ADC 

                                if(roleTypeId != data[i]['roleid']){
                                    if(data[i]['roleid'] !="01" && data[i]['roleid'] !="02" && data[i]['roleid'] !="04" && data[i]['roleid'] !="05"){
                                        $("#roleid").append("<option value='" + data[i]['roleid'] + "'>" + data[i]['rolelname'] + "</option>");
                                    }

                                } 

                            }
                            
                                  
                            
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

        window.onload = function() 
        {


             // if( session_roleid == "02")
             //            {
             //                $('#allotment_form_card').show();
             //            }
             //            else if (session_roleid == "03")
             //            {
                           
             //            } $('#allotment_form_card').hide();
            
            
          
            $.ajax({
				url: '<?php echo URLROOT; ?>/Allotment/AllDistrictsDisabledChecking',
				paging: "true",
				dataType: "json",
                type	: 'POST',
                data	:{
                    csrf    :   $('#csrf').val(),
        

                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {

                      
                       if(data.message == 'true'){
                     //  alert("Already Selected All Districts selection ");
                        $('#distid').prop('disabled', 'disabled');
                        $('#menu').prop('disabled', 'disabled');
                        $('#bill_year').prop('disabled', 'disabled');
                        $('#bill_month').prop('disabled', 'disabled');
                        $('#flexCheckChecked').prop('disabled', 'disabled');

                        let selectCountValue = data.svalue;
                        let yearmonth = data.ym ;
                        let seedValue = data.sv;
                        let district = 'all';

                        if(selectCountValue !="" || yearmonth !="" ||  seedValue !=""  ){

                            fetch_data_auto_load(selectCountValue ,yearmonth,seedValue,district );

                        }
                        
                        
                        
                       }
                       else{
                        $("#datatables").html("No Data Available").css("text-align","center");
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

            
        };

        function reset_menuform()
        {
            valiator.resetForm();
            $('#action').val('insert');
            $('#button_action').val('Save');
            document.getElementById('button_action').style.backgroundColor ='#56a1e3';
            document.getElementById('button_action').style.color = "#FFFFFF";

        }

        function reset_enableform()
        {
            $('#enable_confirmation_alert').modal('show');

            //$("#menu").prop('disabled', true);
             //$('#enableButton').hide();

        }

        function enable_select_count_text_box(){

            $("#menu").prop('disabled', false);
             $('#enableButton').hide();

        }




        function enable_cat(value) 
        {
            if ($('#cat_sub').val() == '') 
            {
                passing_alert_value('Alert', 'Please select category/subcategory option', 'confirmation_alert', 'alert_header', 'alert_body', 'confirmation_alert');
                $("#cat_name").attr("disabled", "disabled");

            } 
            else 
            {
                if ($('#cat_sub').val() == 1) 
                {
                    $("#cat_name").attr("disabled", "disabled");
                    $("#cat_name").val('');
                } 
                else 
                    $("#cat_name").removeAttr("disabled");
            }
            
        }

        function fun_close()
        {
            valiator.resetForm();
            
        }
		function fetch_data(selectCountValue ,yearmonth,seedValue,district) 
        {
             $("#datatables").html(`<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>`); 
            
			$.ajax({
				url: '<?php echo URLROOT; ?>/Allotment/FetchingAllotmentData',
				paging: "true",
				dataType: "html",
                type	: 'POST',
                data	:{
                    csrf    :   $('#csrf').val(),
        select_count_value  : selectCountValue ,
                yearmonth   : yearmonth ,
                seedValue   : seedValue ,
                district    : district

                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        if( session_roleid == "02")
                        {
                            $('#allotment_form_card').show();
                        }
                        else if (session_roleid == "03")
                        {

                            $('#allotment_form_card').hide();
                           
                        } 

                        $('#datatables').html(data);
                        $('#datatables-basicyyy').DataTable(
                        {
                            pageLength : 5,
                            lengthMenu: [[5, 10, 20,25, -1], [5, 10, 20,25, 'All']],

                        });
                        var textValue =  $('.dataTables_empty').html();
                       //debugger;

                       if(textValue != "No data available in table"){

                         $('.adc_btn').prop('disabled', false);

                        initiateAnimation( "layout-wrapper");
                       // getRole();

                       }
                       else{
                        $('#roleid').prop('disabled', 'disabled');
                        $('.adc_btn').prop('disabled', true);
                       }
                       // location.reload();
                        // $("#menu").prop('disabled', true);
                        // $('#enableButton').show();
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
       
        function fetch_data_auto_load(selectCountValue ,yearmonth,seedValue,district) 
        {
             $("#datatables").html(`<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>`); 
			$.ajax({
				url: '<?php echo URLROOT; ?>/Allotment/FetchingAllotmentDataAuto',
				paging: "true",
				dataType: "html",
                type	: 'POST',
                data	:{
                    csrf    :   $('#csrf').val(),
        select_count_value  : selectCountValue ,
                yearmonth   : yearmonth ,
                seedValue   : seedValue ,
                district    : district

                },
                beforeSend: function () {
                   // debugger;
                   
                },
                
                success: function(data, textStatus, jqXHR) 
                {

                    debugger;
                    if(jqXHR.status=='200')
                    {
                         if( session_roleid == "02")
                        {
                            $('#allotment_form_card').show();
                        }
                        else if (session_roleid == "03")
                        {
                            $('#allotment_form_card').hide();
                        }

                        $('#datatables').html(data);
                        $('#datatables-basic').DataTable(
                        {
                            pageLength : 5,
                            lengthMenu: [[5, 10, 20,25, -1], [5, 10, 20,25, 'All']],
                           

                        });
                        // $("#menu").prop('disabled', true);
                        // $('#enableButton').show();
                        // start animation here
                        // no need to stop, it handles by itself;
                       var textValue =  $('.dataTables_empty').html();
                       //debugger;

                       if(textValue != "No data available in table"){

                         $('.adc_btn').prop('disabled', false);

                        initiateAnimation( "layout-wrapper");
                        //getRole();

                       }
                       else{
                        $('#roleid').prop('disabled', 'disabled');
                         $('.adc_btn').prop('disabled', true);
                       }

                       
                    }
				},
                complete: function () {
                    $("#datatables").removeClass("loading");
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
//         $(document).on({
           
//     ajaxStart: function(){
        
//         $("#datatables").addClass("loading"); 
//     },
//     ajaxStop: function(){ 
//         //debugger;
      
//         const myTimeout = setTimeout(myGreeting, 5000);
        
//     }
        
// });


        var valiator = $('#privillage_form').validate({


            // Specify validation rules
            rules: {
                menu: {
                    required: true
                },
                menu_url: {
                    required: true
                },
                cat_sub: {
                    required: true
                },
                cat_name: {
                    required: true
                },
                key: {
                    required: true
                },
            },
            // Specify validation error messages
            messages: {
                menu:"Enter Maximum Count",
                key:"Enter Menu key ",
                menu_url:"Enter Year / Month",
                cat_sub:"Select Cateory or Sub Category",
                cat_name:"Select Cateory Name",
            },
            highlight: function(element, errorClass) 
            {
                $(element).removeClass(errorClass); //prevent class to be added to selects
            },
            errorPlacement: function(error, element) 
            {
                if(element.parent('.input-group').length) 
                {
                    error.insertAfter(element.parent());
                }
                else
                {
                    error.insertAfter(element);
                }
            },
            submitHandler: function(form) 
            {
                event.preventDefault();
                var form_data = $('#privillage_form').serialize(); // All form data in a form_data variable.
                

                let selectCountValue = $('#menu').val();
                $('#allotment_confirmation_alert').modal('show');
                $('.winners_class').html(selectCountValue);

                var district         = $("#distid option:selected").val();
                if(district == "all"){
                    $('#distid').prop('disabled', true);
                    $('#bill_year').prop('disabled', true);
                    $('#bill_month').prop('disabled', true);
                     //$('#flexCheckChecked').prop('disabled', 'true');
                   // $('#menu').prop('disabled', false);
                        
                }
              
            }
        });

        $(document).on('click', '.edit_privillage', function() 
        {
            $('#error').hide();
            var id = $(this).attr('id'); //Getting id of user clicked edit button.
            $('#menuid').val(id);
            $.ajax({
                url: '<?php echo URLROOT; ?>/Menu/edit_menu',
                type: 'POST',
                data: {
                    id: id,
                    csrf    :   $('#csrf').val()
                }, //passing id and action msg to the config_master_action.php file.
                dataType: 'json', //Response data type as json.
                success: function(response, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {     
                        $('#menu').val(response['menuname']);
                        $('#key').val(response['key']);
                        $('#menu_url').val(response['menuurl']);
                        $('#cat_sub').val(response['levelid']);
                        $('#cat_name').val(response['parentid']);
                    
                        if (response['status'] == 'Y') 
                            document.getElementById("active").checked = true;
                        else
                            document.getElementById("inactive").checked = true;

                        if(response['levelid'] == 1)
                        
                            $("#cat_name").attr("disabled", "disabled");
                        else
                            $("#cat_name").removeAttr("disabled");

                        $('#action').val('update');
                        $('#button_action').val('Update');
                        $('.card-heading').text('Edit Configure Master Data');
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
        });

       	/**
         *  Author: Stalin Thomas
         * 
         * Content : Allotment Module
         * 
         * Date  : 29-03-2023
         * 
         * 
         */

        //  function getAllotmentConfirmBox(){
		 
           
         
        //  }

        function cancel_confirmation_box(){
             $('#allotment_confirmation_alert').modal('hide');
              $('#distid').prop('disabled', false);
              $('#bill_year').prop('disabled', false);
              $('#bill_month').prop('disabled',  false);
             // $('#flexCheckChecked').removeattr('disabled', 'disabled');
              $('#menu').prop('disabled', false);
        }


        

         function allotment_fetch_data(){
            
            var selectCountValue = $("#menu").val();
            var bill_year        =  $("#bill_year option:selected").text(); 
            var bill_month       = $("#bill_month option:selected").val();
            var district         = $("#distid option:selected").val();
            var yearmonth        = bill_year.concat(bill_month);
            var min              = -1;
            var max              = 1
            var random           = (Math.random() * (max - min) + min);
            let num              = random;
            let seedValue        = num.toString().substring(0,4);
            if(district == undefined){
                alert("Already ALl Districts Selected");
                return false;
            }
            fetch_data(selectCountValue ,yearmonth,seedValue,district );
            $('#button_action').attr('disabled', 'disabled');

         }
         function forwardConfirmationOpen(){
            $('#forward_confirmation_alert').modal('show');
         }

         function role_forward(){

            if(session_roleid == "02"){
                var role_type_id          =  "03"; 
                var role_type_name        = "Joint Commissioner"; 
            }
            else if(session_roleid == "03"){
                var role_type_id          =  "04"; 
                var role_type_name        = "Deputy Commissioner";
            }
            

            






            $.ajax({
				url: '<?php echo URLROOT; ?>/Allotment/ForwardToNextRole',
				paging: "true",
				dataType: "json",
                type	: 'POST',
                data	:{
                    csrf    :   $('#csrf').val(),
              role_type_id  : role_type_id ,
               

                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        if(data.message == 'true'){
                            debugger;
                            alert("Forwarded Successfully to "+role_type_name) ;
                            location.reload();
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
     $(function() {
         $('#button_action').attr('disabled', 'disabled');
         $('#alloted_detail_btn').attr('disabled', 'disabled');
         $('#flexCheckChecked').click(function() {
             if ($(this).is(':checked')) {
                
                 $('#button_action').removeAttr('disabled');
                 $('#alloted_detail_btn').removeAttr('disabled');
                 
             } else {
                 $('#button_action').attr('disabled', 'disabled');
                 $('#alloted_detail_btn').attr('disabled', 'disabled');
             }
         });
     });

     function forward_to_jc_one(){

        let jc_role_id = "03";
         $('#jc_one_confirmation_alert').modal('show');
       

     }
      function forward_to_jc_two(){

        let jc_role_id = "03";
         $('#jc_two_confirmation_alert').modal('show');
       

     }

     /**
      *  Author: Stalin Thomas
      * 
      * Content : Allotment Module
      * 
      * Date  : 29-03-2023
      * 
      * 
      */
    </script>

<style>
.overlay{
    text-align: center;
    display: none;
    position: fixed;
    width: 100%;
    height: 100%;
    top: 13%;
    left: 10%;
    z-index: 999;
    /* background: rgba(255,255,255,0.8) url("https://i.gifer.com/74H8.gif") center no-repeat; */
    background: rgba(255,255,255,0.8) url("http://localhost/projects/ctax_server/public/site/images/winner.gif") center no-repeat;
    /* background: rgba(255,255,255,0.8) url("https://media.tenor.com/E6lFjorkDRAAAAAd/winner.gif") center no-repeat; */
}
/* Turn off scrollbar when body element has the loading class */
#datatables.loading{
    overflow: hidden;   
}
/* Make spinner image visible when body element has the loading class */
#datatables.loading .overlay{
    display: block;
}
</style>

</body>

</html>