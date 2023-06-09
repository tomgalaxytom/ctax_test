n<!DOCTYPE html>
<html lang="en">
<?php
include('./././public/dash/layout/alert.php'); 
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');

?>
<!-- Datatable Css -->
<!-- <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet">   -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>






<div class="main-content">

    <div class="page-content">
        <div class="container-fluid mbl_view page_content_up">
                    <div class="row">
                        <div class="col-12">
                            <div class="card-body">
                                <?php
                                $roletypecode = $_SESSION['user']->roletypecode;

                             

                                if($roletypecode == '02'){?>

                                    <div class="card  shadow mb-2 " id="verified_form_card" >
                                    <div class="card-header card_header_color"> Create Allotment </div>

                                    <div class="card-body ">
                                        <div class="alert alert-danger alert-dismissible" id="error" style="display:none;" name="error">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                        </div>

                                        <form class="forms-sample " id="verified_form" name="verified_form" method="POST" action="">
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
                                            // $database->query("select d.distcode,d.distename,c.allotment_status from mybillmyright.mst_district d left join mybillmyright.mst_config c on d.distcode = c.distcode order by d.distename asc");
                                            // get already bill selection districts

                                            $database1 = new database;
                                            $database1->query("select distinct distcode from mybillmyright.bill_selection_details");
                                            $billselectiondistricts = $database1->resultSet1();
                                            //echo "<pre>";
                                           // print_r( $billselectiondistricts );
                                            $alreadyBillSelectedDistricts = array();
                                            foreach($billselectiondistricts as $v){
                                                $alreadyBillSelectedDistricts[] =  $v['distcode'];

                                            }
                                            //print_r($array);

                                            //$alreadyBillSelectedDistricts = [610,586];
                                            $count = count($alreadyBillSelectedDistricts);
                                           // print_r($alreadyBillSelectedDistricts);
                                            $database->query("select  d.distcode,d.distename from  mybillmyright.mst_district d
                                            inner join mybillmyright.billdetail c on d.distcode = c.distcode
                                            group by d.distcode,d.distename order by d.distename asc");
                                            $data = $database->resultSet1();


                                            //count

                                            $database2 = new database;

                                            $database2->query("select  count(distinct(distcode)) from mybillmyright.billdetail");
                                             $datacount = $database2->single();
                                             

                                             if($count ==  $datacount->count){
                                                 $m = 'disabled';
                                             }
                                             else{
                                                 $m = ''; 
                                             }
                                            

                                            ?>

                                            <div class="row">
                                                <div class="col-md-12">
                                                        <label class=" col-form-label required">Select Districts</label>
                                                        <div class="form-group row">
                                                            <div class="col-sm-4">
                                                            <select class="form-select " required name="distid"  <?php echo $m;?> id="distid" >
  



                                                                <option 
                                                                value='all'>---- All ----</option>
                                                                <?php 
                                                                foreach ($data as $value) 
                                                                {
                                                                    $disabledStr = in_array($value['distcode'], $alreadyBillSelectedDistricts) ? "disabled" : "";
                                                                    ?>
                                                                        <option  <?php echo $disabledStr;?>  value="<?= htmlspecialchars($value['distcode']); ?>" ><?= htmlspecialchars($value['distename']); ?></option>   
                                                                   
                                                                     
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
                                            
                                            <!-- Districts and Maximum Selection Rows -->

                                             <!-- Year, Month -->

                                             <div class="row">
                                             <div class="col-md-6">
                                                   
                                                  
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                        <label class=" col-form-label required">Year</label>
                                                                <?php $currently_selected = date('Y'); 
                                                                    // Year to start available options at
                                                                    $earliest_year = 2023; 
                                                                    // Set your latest year you want in the range, in this case we use PHP to just set it to the current year.
                                                                    $latest_year = date('Y');?> 
        
                                                                    <select class=" form-select"  name="bill_year" id="bill_year" <?php echo $m;?>>';
                                                                    <?php 
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
                                                                <select  class="form-select"  name="bill_month" id="bill_month" <?php echo $m;?>>
                                                                    <?php
                                                                    $curmonth = date("F");
                                                                       $nm = date("m");
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
                                                                         if($value-1 == $nm){
                                                                            break;
                                                                        }

                                                                        echo "<option value=$value $selected>$month</option> ";
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                            
                                                        </div>
                                                    </div><!-- form group row-->
                                            </div>
                                           <!-- Year, Month -->



                                            <br>


                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckCheckedVerified" style="font-size:21px" id="flexCheckChecked" required >
                                                        <label class="form-check-label" style ="margin-top:5px" for="flexCheckChecked">
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
                                                <input type="submit" name="verified_button_action" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Submit" id="verified_button_action" class="btn  btn-primary button_save " value="Verify Allotment"  />

                                                

                                                


                                                <!-- <button type="reset" class="btn btn-danger" onclick="reset_menuform()" id="1">Cancel</button> -->
                                                <button type="reset" class="btn btn-primary" id ="alloted_detail_btn" onclick="" id="1">Reset</button>
                                            </div>


                                            <!-- <div style="text-align: center; ">
                                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                            <input type="hidden" name="action" id="action" value="insert" />

                                            <input type="Save" name="verified_button_action" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Submit" id="verified_button_action" class="btn button_save" value="Save" />
                                            <button type="reset" class="btn btn-danger"  onclick="reset_menuform()" id="1">clear</button>
                                            </div> -->
                                            <div class="mb-3"></div>

                                        </form>

                                    </div>
                                </div>

                               <?php  } ?>




                                
                                <div class="card">
                                    <div class="card-header card_header_color"> Verified Selection Details </div>
                                    <div class="card-body" id="verifydataTableBody">

                                    <!-- <form id="frm-example" action="test.php"> -->
                                        
                                    <table id="verifySelectionTable" class="table table-bordered display responsive nowrap"  style= "width: 100% !important;">
                                   
                                        <thead>
                                            <tr>
                                               
                                                <th>District Name</th>
                                                <th>User Name </th>
                                                <th>Mobile Number</th>
                                                <th>Invoice Number</th>
                                                <th>Amount</th>
                                                <th>Shop Name</th>
                                                <th>Bill Purchase Date</th>
                                                <th>invoice copy</th>
                                                <th>Order By</th>
                                                <th>Remarks</th>


                                            </tr>
                                        </thead>


                                    </table>

                                    <!-- </form> -->


                                        
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



<link href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css" rel="stylesheet"> 
<link href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet">
<link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" rel="stylesheet"> 
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js" type="text/javascript"></script>

<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js" type="text/javascript"></script>

<script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js" type="text/javascript"></script>
<!-- <script src="<?php //echo URLROOT; ?>public/dash/cdn/js/datatables.min.js" defer="defer"></script> -->


<script src="<?php echo URLROOT; ?>public/site/js/custom_validate.js"></script>
<script src="<?php echo URLROOT; ?>public/site/js/party/party.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>



    <script>
        var nic_roleid  =   '<?php echo $this->nic_roletypecode ?>';
      <?php  $session   =   $this->session_details(); 
        $session_roleid =   $session[0]->roletypecode;
        
        ?>
        session_roleid='<?php echo $session_roleid?>';

           window.onload = function() 
        {

            //debugger;

          //  emptyTableChecking( , "all");

           //   var userDataTable = $('#verifiedTable').DataTable();

           // if ( ! userDataTable.data().any() ) {
           //      $('#verifydataTableBody').hide();
           //  }
           //  else{
           //     $('#verifydataTableBody').hide();
           //  }




            var valiator = $('#verified_form').validate({


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
    flexCheckChecked: {
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
    var form_data = $('#allotment_form').serialize(); // All form data in a form_data variable.

debugger;
    
    // $('#verifiedTable').dataTable().fnDestroy();
    let selectCountValue = $('#menu').val();
   
    $('.winners_class').html(selectCountValue);

    var district         = $("#distid option:selected").val();
    //if(district == "all"){
      //  $('#distid').prop('disabled', true);
      //  $('#bill_year').prop('disabled', true);
      //  $('#bill_month').prop('disabled', true);
         //$('#flexCheckChecked').prop('disabled', 'true');
       // $('#menu').prop('disabled', false);
            
    //}
    // else{
    //     //$('#distid').val("all");
    //     $(`#distid option[value="${district}"]`).prop('disabled', true);
    // }
  
}
});

             // if( session_roleid == "02")
             //            {
             //                $('#allotment_form_card').show();
             //            }
             //            else if (session_roleid == "03")
             //            {
                           
             //            } $('#allotment_form_card').hide();
            
             var district         = $("#distid option:selected").val();
          
            $.ajax({
                url: '<?php echo URLROOT; ?>/Allotment/AllDistrictsDisabledCheckingVerified',
                paging: "true",
                dataType: "json",
                type    : 'POST',
                data    :{
                    csrf    :   $('#csrf').val(),
                    district :district,
        

                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        debugger;

                      
                       if(data.totalCount > 0){
                         $('#verifydataTableBody').show();
                     //  alert("Already Selected All Districts selection ");
                        // $('#distid').prop('disabled', 'disabled');
                        // $('#menu').prop('disabled', 'disabled');
                        // $('#bill_year').prop('disabled', 'disabled');
                        // $('#bill_month').prop('disabled', 'disabled');
                        // $('#flexCheckChecked').prop('disabled', 'disabled');
                        let selectCountValue = data.svalue;
                        let yearmonth = data.ym ;
                        let seedValue = data.sv;
                        //let dist = data.dist;
                        let district = 'all';


                        if(selectCountValue !="" || yearmonth !="" ||  seedValue !=""  ){

                            fetch_data_auto_load(selectCountValue ,yearmonth,seedValue,district,actionFunction = 'auto' );

                        }
                        
                        
                        
                       }
                       else{
                        debugger;

                        //if( session_roleid == "02"){

                             var userDataTable = $('#verifiedTable').DataTable();
                           if ( ! userDataTable.data().any() ) {
                                $('#verifydataTableBody').hide();
                            }

                     //   }

                        // var userDataTable = $('#verifiedTable').DataTable();
                        // userDataTable.destroy();

                        // $('#verifydataTableBody').hide();

                        // debugger;


            //             var formData = {
            //     select_count_value: "",
            //     yearmonth: "",
            //     seedValue: "",
            //     district : "",
            //     act : ""
            // };
            // debugger;


            //             displayDatatable(formData);


                           // var userDataTable = $('#verifiedTable').DataTable();
                           // if ( ! userDataTable.data().any() ) {
                           //      $('#verifydataTableBody').hide();
                           //  }
            
                       
                        // var myTable = jQuery("#verifiedTable");
                        // var thead = myTable.find("thead");
                        // thead = jQuery('<tbody><tr class="odd"><td valign="top" colspan="8" class="dataTables_empty" style="text-align:center">No data available in table</td></tr></tbody>').appendTo(myTable);  

                        
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
       
           

          function verify_fetch_data(){
            var bill_year        =  $("#bill_year option:selected").text(); 
            var bill_month       = $("#bill_month option:selected").val();
            var district         = $("#distid option:selected").val();
            var yearmonth        = bill_year.concat(bill_month);
           

             //let seedValue  = 0.33;


            if(district == undefined){
                alert("Already ALl Districts Selected");
                return false;
            }
            fetch_data(yearmonth,district );
           // location.reload()
            //$('#verified_button_action').attr('disabled', 'disabled');

         }
         function  fetch_data(yearmonth,district){
             fetch_data_auto_load(yearmonthdistrict);
         }

        function reset_menuform()
        {
            valiator.resetForm();
            $('#action').val('insert');
            $('#verified_button_action').val('Save');
            document.getElementById('verified_button_action').style.backgroundColor ='#56a1e3';
            document.getElementById('verified_button_action').style.color = "#FFFFFF";

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
        
        $(".forward-btn").attr('disabled', "disabled");
        $(".revert_back_btn").attr('disabled', "disabled");

        $('#verifySelectionTable').on('change', 'input[type="checkbox"]', function() {
            let selectedCheckboxCount = $("#verifySelectionTable input[type=\"checkbox\"]:checked").length;
            ;
            if (selectedCheckboxCount > 0) {

                

                  
                
                    $(".forward-btn").removeAttr('disabled');
                    $(".revert_back_btn").removeAttr('disabled');
               

                // $(".forward-btn").removeAttr('disabled');
                // $(".revert_back_btn").removeAttr('disabled');
            } else {
                $(".forward-btn").attr('disabled', "disabled");
                $(".revert_back_btn").attr('disabled', "disabled");
                //$(".archivebtn").removeAttr('disabled');
            }
        });

        function fetch_data_auto_load(yearmonth,district) 
        { 
            ;
             var formData = {
                yearmonth: yearmonth,
                district : district,
               
            };

           if(district != 'all'){
           // $('#verifySelectionTable').dataTable().fnDestroy();
            displayDatatableVerify(formData);
           }
           else{
            displayDatatableVerify(formData);
           }
           

            
        }
        function displayDatatableVerify(formData){
            var baseurl = '<?php echo URLROOT; ?>/Allotment/VerifyAllotmentDataAuto';
            var userDataTable = $('#verifySelectionTable').DataTable({
                  "fnInitComplete": function(oSettings) {
           if (oSettings.aiDisplayMaster.length <= 0) {
               $("#verifydataTableBody").hide();
           }
        },
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            
            'ajax': {
                'url': baseurl,
                data: formData,
            },
            'destroy':true,
            'columns': [

                {
                    data: 'distename'
                },
                {
                    data: 'name'
                },
                {
                    data: 'mobilenumber'
                },
                {
                    data: 'billnumber'
                },

                {
                    data: 'billamount'
                },
                {
                    data: 'shopname'
                },
                {
                    data: 'billdate'
                },
                 {
                    data: 'filepath'
                },
                 {
                    data: 'order_by_column'
                },
                 {
                    data: 'message'
                },

                

            ],
            'columnDefs': [{
                'targets': 0,
               
            }],
            
        });
        }
        function cancel_confirmation_box(){
             $('#allotment_confirmation_alert').modal('hide');
              $('#distid').prop('disabled', false);
              $('#bill_year').prop('disabled', false);
              $('#bill_month').prop('disabled',  false);
             // $('#flexCheckChecked').removeattr('disabled', 'disabled');
              $('#menu').prop('disabled', false);
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
#processcode{
    padding: 5px !important;
}
table.dataTable tbody tr.myeven{
    background-color:white;
}
table.dataTable tbody tr.myodd{
    background-color:#DCD9D9;
}
table.dataTable th{
    color: white;
    background: #1E3D5D;
}
table.dataTable tbody tr{
    height: 100px !important;
}

</style>

</body>

</html>