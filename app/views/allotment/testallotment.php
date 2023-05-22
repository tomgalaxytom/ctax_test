<!DOCTYPE html>
<html lang="en">
<?php

include('./././public/dash/layout/alert.php'); 
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');

?>
<!-- Datatable Css -->
<!--<link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet"> --> 

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

                                    <div class="card  shadow mb-2 " id="allotment_form_card">
                                    <div class="card-header card_header_color"> Test  Allotment </div>

                                    <div class="card-body ">
                                        <div class="alert alert-danger alert-dismissible" id="error" style="display:none;" name="error">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                        </div>

                                       
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
                                                <div class="col-md-8">
                                                        <label class=" col-form-label required">Select Districts</label>
                                                        <div class="form-group row">
                                                            <div class="col-sm-4">
                                                                <select class="form-select " name="distid"  <?php echo $m;?> id="distid" >
                                                                    <!-- <option 
                                                                    value='all'>---- All ----</option> -->
                                                                    <?php 
                                                                    foreach ($data as $value) 
                                                                    {
                                                                        $disabledStr = in_array($value['distcode'], $alreadyBillSelectedDistricts) ? "disabled" : "";
                                                                        ?>
                                                                            <option   value="<?= htmlspecialchars($value['distcode']); ?>" ><?= htmlspecialchars($value['distename']); ?></option>   
                                                                    
                                                                        
                                                                    <?php }
                                                                    ?>
                                                                </select>
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <br>
                                                        <div class="form-group row">
                                                            <div class="col-sm-2">
                                                                <label class=" col-form-label required">Seed Value</label>
                                                                <input type="text" class="form-control "  name="seedvalue" id="seedvalue"  />
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label class=" col-form-label required">Count Value</label>
                                                                <input type="text" class="form-control "  name="countvalue" id="countvalue"  />
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        <div class="form-group row">
                                                            <div class="col-sm-2">
                                                                <label class=" col-form-label required">Year</label>
                                                                <?php $latest_year = date('Y');?>
                                                                <select class=" form-select"  name="bill_year" id="bill_year">
                                                                    <option value="<?php echo $latest_year;?>"><?php echo $latest_year;?></option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-2">
                                                                <label class=" col-form-label required">Month</label>
                                                                <select  class="form-select"  name="bill_month" id="bill_month" >
                                                                   <option value="04"><?php echo "April";?></option>  

                                                                </select>
                                                            </div>
                                                            
                                                            
                                                        </div>
                                                        
                                                        
                                                </div>
                                                <!-- Table Starts here-->
                                                <div class="col-md-4">
                                                        <label class=" col-form-label required">Select Districts</label>
                                                        <div class="form-group row">
                                                            <div class="col-sm-4">
                                                            <?php $database2 = new database;

                                                            $database2->query("select distinct bsd.distcode ,bsd.seed_value,bsd.selection_value,bsd.year_month,
                                                            (select distename from mybillmyright.mst_district where distcode = bsd.distcode) as districtname  
                                                            from mybillmyright.bill_selection_details  bsd
                                                            group by  bsd.distcode,bsd.seed_value,bsd.selection_value,bsd.year_month");
                                                            $datacount = $database2->resultSet1();

                                                            
                                                            
                                                            
                                                            
                                                            
                                                            ?>
                                                            <table style="width:100%"  class="table table-bordered">
                                                                <tr>
                                                                    <th>District Name</th>
                                                                    <th>Dist code</th>
                                                                    <th>seed value</th>
                                                                    <th>Count Value</th>
                                                                    <th>Year Month</th>
                                                                </tr>
                                                                <?php
                                                                foreach($datacount as $value){?>
                                                                    <tr>
                                                                        <td><?php echo $value['districtname']; ?></td>
                                                                        <td><?php echo $value['distcode']; ?></td>
                                                                        <td><?php echo $value['seed_value']; ?></td>
                                                                        <td><?php echo $value['selection_value']; ?></td>
                                                                        <td><?php echo $value['year_month']; ?></td>
                                                                    </tr>

                                                                <?php }
                                                                
                                                                
                                                                ?>
                                                                
                                                            </table>
                                                            </div>
                                                           
                                                        </div>
                                                </div>
                                                <!-- Table Starts here-->





                                                
                                            </div>
                                           
                                            <!-- Districts and Maximum Selection Rows -->

                                             <!-- Year, Month -->

                                            
                                           <!-- Year, Month -->



                                           

                                            
                                            <div class="mb-3"></div>

                                            <!-- Modal Footer with action button and close button -->

                                            <div style="text-align: center; ">
                                                <input type="hidden" name="hidden_id" id="hidden_id" />
                                                <input type="hidden" name="action" id="action" value="insert" />
                                                <input type="submit" name="button_action" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Submit" id="test_button_action" class="btn  btn-primary button_save " value="Process Allotment"  />

                                                

                                                


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
                                           

                                        

                                    </div>
                                </div>

                               <?php  } ?>




                                
                                <div class="card">
                                    <div class="card-header card_header_color"> Selection Details </div>
                                    <div class="card-body" id="testdataTableBody">

                                     <form id="frm-example" name ="frm-example" onsubmit="return false;"> 
                                        <!-- @table-->
                                        
                                    <table id="testSelectionTable" class="table table-bordered display responsive nowrap "  style= "width: 100%;display:none">
                                    <div id="datatables">
                       
                                    </div>
                                    <thead>
                                            <tr>
                                                
                                                <th></th>
                                                <!-- <th>District Name</th> -->
                                                <th style="text-align: center;">Invoice Details</th>
                                                <!-- <th style="text-align: center;">Invoice Amount( <i class="fa fa-inr" aria-hidden="true"></i>)</th> -->
                                                <th>Action</th>
                                                <?php


                                                if($roletypecode == "02"){


                                                echo '
                                                    <th>order <br>ID </th>
                                                ';
                                                }
                                                else{


                                                    echo '
                                                    <th style="text-align: center;" class="none">order <br>ID </th>
                                                    ';


                                                }


                                                ?>

                                                <th>Remarks</th>
                                                <th>Status</th>
                                                <?php 

                                                if($roletypecode == "02"){

                                                    echo '
                                                     <th>User Name </th>
                                                     <th>Mobile Number</th>
                                                     <th>Invoice <br> copy</th>';
                                                }
                                                else{

                                                     echo '
                                                     <th class="none" >User Name </th>
                                                     <th class="none">Mobile Number</th>
                                                     <th class="none">Invoice copy</th>';

                                                }

                                                ?>
  
                                                

                                            </tr>
                                        </thead>


                                    </table>
                                    
                                   <!-- 
 <input type="hidden1" id="hidden_data"> -->

<input type="hidden" name="ids" id="ids" />

                                     </form>


                                        
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
<!-- <link href="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet"> -->
<link href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css" rel="stylesheet"> 

<script src="https://code.jquery.com/jquery-3.5.1.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js" type="text/javascript"></script>

<!-- <script src="https://gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js" type="text/javascript"></script> -->
<!-- <script src="<?php //echo URLROOT; ?>public/dash/cdn/js/datatables.min.js" defer="defer"></script> -->


<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>


<script src="<?php echo URLROOT; ?>public/site/js/custom_validate.js"></script>
<script src="<?php echo URLROOT; ?>public/site/js/party/party.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
<script src="<?php echo URLROOT; ?>public/site/js/allotment.js"></script>
    <script>
           var nic_roleid  =   '<?php echo $this->nic_roletypecode ?>';
      <?php  $session   =   $this->session_details(); 
        $session_roleid =   $session[0]->roletypecode;
        
        ?>
        session_roleid='<?php echo $session_roleid?>';
        $(document).ready(function(){
            $("#test_button_action").click(function(){
                debugger;
                var district         = $("#distid option:selected").val();
                var districtText         = $("#distid option:selected").text();
                var seed_value    =  $("#seedvalue").val();
                var selectCountValue = $("#countvalue").val();
                
                var bill_year        =  $("#bill_year option:selected").text(); 
                var bill_month       = $("#bill_month option:selected").val();
               
                var yearmonth        = bill_year.concat(bill_month);
                
                let seedValue        = seed_value;
                fetch_data_auto_load(selectCountValue, yearmonth, seedValue, district, actionfunc = 'test_allotment', 'all');
            });


        });
        function fetch_data_auto_load(selectCountValue, yearmonth, seedValue, district, actionfunc, bill_status) {
    
    var formData = {
        select_count_value: selectCountValue,
        yearmonth: yearmonth,
        seedValue: seedValue,
        district: district,
        act: actionfunc,
        bill_status: bill_status,
    };
    if (district != 'all' && actionfunc == 'test_allotment') {
        $('#testdataTableBody').show();
        $('#testSelectionTable').show();
        displayDatatable(formData);
       // location.reload();
    }
    else {
        //emptyTableChecking(formData, district);

    }
}

function displayDatatable(formData) {  //DisplayDatatable if start
    //@stalin

    var baseurl = siteurl + '/Allotment/FetchingAllotmentDataAuto';
    var userDataTable = $('#testSelectionTable').DataTable({ //Datatable Start
        "fnInitComplete": function (oSettings) {
            if (oSettings.aiDisplayMaster.length <= 0) {
                $("#testdataTableBody").hide();
            }
        },
        "rowCallback": function (row, data, index) {
            if (index % 2 == 0) {
                $(row).removeClass('myodd myeven');
                $(row).addClass('myodd');
            } else {
                $(row).removeClass('myodd myeven');
                $(row).addClass('myeven');
            }
        },
        'processing': true,
        'serverSide': true,
        'serverMethod': 'post',
        'paging': true,
        'pageLength': 5,
        //      scrollY:        "300px",
        // scrollX:        true,
        // scrollCollapse: true,



        'lengthMenu': [[5, 10, 20, -1], [5, 10, 20, "All"]],
        'iDisplayLength': -1,
        'ajax': {
            'url': baseurl,
            data: formData,
        },
        // autoWidth: false,

        'destroy': true,

        responsive: true,
        //     responsive: {
        //     details: {
        //         type: 'column'
        //     }
        // },



        'columns': [
            { "data": "bill_selection_id", "name": "bill_selection_id" },
            // { "data": "distename","name": "distename"},
            { "data": "billnumber", "name": "billnumber" },
            // { "data": "billamount","name": "billamount"},
            { "data": "action", "name": "action" },
            { "data": "order_by_column", "name": "order_by_column" },
            { "data": "remarks", "name": "remarks" },
            { "data": "status", "name": "status" },
            { "data": "username", "name": "username" },
            { "data": "mobilenumber", "name": "mobilenumber" },
            { "data": "invoicecopy", "name": "invoicecopy" },

        ],


        'columnDefs': [
            {

                responsivePriority: 1,

                targets: 0,


                // className: 'dtr-control',
                orderable: false,
                // 'checkboxes': {
                //     'selectRow': true
                // }
            },

            {

                responsivePriority: 2,

                targets: -5,



            },
            {

                width: 95,

                targets: 4,



            },




        ],
        //  order: [ 0, 'asc' ],
        "ordering": false,
        'select': {
            'style': 'multi'
        },

    }); // DataTable End

    if (session_roleid == '02') {


        var dt = $('#testSelectionTable').DataTable();
        //hide the first column
        dt.columns([0,2, 4, 5]).visible(false);

        // location.reload();



    }
    else {

        jQuery('.dt-checkboxes-select-all').closest('tr').find('[type=checkbox]').hide();


        var dt = $('#testSelectionTable').DataTable();
        //hide the first column
        //dt.columns([0]).visible(false);
        //dt.columns([4,5,6,7]).visible(true);

    }




    //$('.dt-checkboxes').attr('name', 'test');

    // $('#testSelectionTable .dt-checkboxes').eq(0).attr('name', 'yourNewname1');




    $('#frm-example').on('submit', function (e) { // 28 Form submit start 



        // Prevent actual form submission
        e.preventDefault();
        if (session_roleid == '02') { //ADC

            forward_to_jc_one();
        } //ADC END
        else { // Not ADC

          
       

           

            // $('#dc_confirmation_alert').modal('show');
            // Serialize form data
            var data = userDataTable.$('input,select,textarea').serializeArray();


            // Submit form data via Ajax
            $.ajax({ //Ajax Start 
                url: siteurl + '/Allotment/getResultsEachRows',
                dataType: "json",
                type: 'POST',
                data: data,
                success: function (data) {

                   

                  

                    if (data.message == "true") {

                       
                        //  if(data.process_code == 'F'){


                        if (session_roleid == '03') { //jc


                            $('#dc_confirmation_alert').modal('show');
                        }
                        else if (session_roleid == '04') { //dc
                            //   $('#ac_success_message').modal('show');
                            $('#dc_confirmation_alert').modal('show');
                        }
                        else if (session_roleid == '05') { //dc
                            //   $('#ac_success_message').modal('show');
                            $('#dc_confirmation_alert').modal('show');
                        }


                    }
                    else {
                        $('#select_any_checkbox').modal('show');

                    }

                }
            });  //Ajax End



        }// Not ADC


    }); //Form Submit End



} //DisplayDatatable if End


    </script>



<style>
    /*.fontClass{
         font-size: 12px;
        background: #1E3D5D;
        font-size: 15px;
        color: white;
        text-align: center;
        font-weight: bold;
        font-family: arial,sans-serif,verdana;
    }*/

   /* .dt-checkboxes{
        margin-left: 10px; 
    }*/

/*table{
  margin: 0 auto;
  width: 100%;
  clear: both;
  border-collapse: collapse;
  table-layout: fixed; // ***********add this
  word-wrap:break-word; // ***********and this
}*/


/*table.dataTable.dtr-column>tbody>tr>td.dtr-control:before, table.dataTable.dtr-column>tbody>tr>th.dtr-control:before, table.dataTable.dtr-column>tbody>tr>td.control:before, table.dataTable.dtr-column>tbody>tr>th.control:before {
    top: 48% !important;
    left: 19% !important;
    font-size: 15px;
}*/
/*table.dataTable tbody tr{
    height: 100px !important;
}
*/
/*table.dataTable>tbody>tr.child ul.dtr-details>li:last-child {
    border-bottom: none;
    display: none;
}*/
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
/* Tab Navigation */
/***
Bootstrap Line Tabs by @keenthemes
A component of Metronic Theme - #1 Selling Bootstrap 3 Admin Theme in Themeforest: http://j.mp/metronictheme
Licensed under MIT
***/

/* Tabs panel */
.tabbable-panel {
  border:1px solid #eee;
  padding: 10px;
}

/* Default mode */
.tabbable-line > .nav-tabs {
  border: none;
  margin: 0px;
}
.tabbable-line > .nav-tabs > li {
  margin-right: 2px;
}
.tabbable-line > .nav-tabs > li > a {
  border: 0;
  margin-right: 0;
  color: #737373;
}
.tabbable-line > .nav-tabs > li > a > i {
  color: #a6a6a6;
}
.tabbable-line > .nav-tabs > li.open, .tabbable-line > .nav-tabs > li:hover {
  border-bottom: 4px solid #fbcdcf;
}
.tabbable-line > .nav-tabs > li.open > a, .tabbable-line > .nav-tabs > li:hover > a {
  border: 0;
  background: none !important;
  color: #333333;
}
.tabbable-line > .nav-tabs > li.open > a > i, .tabbable-line > .nav-tabs > li:hover > a > i {
  color: #a6a6a6;
}
.tabbable-line > .nav-tabs > li.open .dropdown-menu, .tabbable-line > .nav-tabs > li:hover .dropdown-menu {
  margin-top: 0px;
}
.tabbable-line > .nav-tabs > li.active {
  border-bottom: 4px solid #f3565d;
  position: relative;
}
.tabbable-line > .nav-tabs > li.active > a {
  border: 0;
  color: #333333;
}
.tabbable-line > .nav-tabs > li.active > a > i {
  color: #404040;
}
.tabbable-line > .tab-content {
  margin-top: -3px;
  background-color: #fff;
  border: 0;
  border-top: 1px solid #eee;
  padding: 15px 0;
}
.portlet .tabbable-line > .tab-content {
  padding-bottom: 0;
}
.form-check-input[type=checkbox] {
   outline: 2px solid black !important;
}


/* Below tabs mode */

.tabbable-line.tabs-below > .nav-tabs > li {
  border-top: 4px solid transparent;
}
.tabbable-line.tabs-below > .nav-tabs > li > a {
  margin-top: 0;
}
.tabbable-line.tabs-below > .nav-tabs > li:hover {
  border-bottom: 0;
  border-top: 4px solid #fbcdcf;
}
.tabbable-line.tabs-below > .nav-tabs > li.active {
  margin-bottom: -2px;
  border-bottom: 0;
  border-top: 4px solid #f3565d;
}
.tabbable-line.tabs-below > .tab-content {
  margin-top: -10px;
  border-top: 0;
  border-bottom: 1px solid #eee;
  padding-bottom: 15px;
}
/* Tab Navigation */


</style>

</body>

</html>