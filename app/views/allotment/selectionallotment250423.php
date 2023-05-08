<!DOCTYPE html>
<html lang="en">
<?php

include('./././public/dash/layout/alert.php'); 
include('./././public/dash/layout/header.php');
include('./././public/dash/layout/sidebar.php');

?>
<!--<!-- Datatable Css -->
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
                                    <div class="card-header card_header_color"> Create Allotment </div>

                                    <div class="card-body ">
                                        <div class="alert alert-danger alert-dismissible" id="error" style="display:none;" name="error">
                                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times</a>
                                        </div>

                                        <form class="forms-sample " id="allotment_form" name="allotment_form" method="POST" action="">
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
                                                            <select class="form-select " name="distid"  <?php echo $m;?> id="distid" >
  



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
                                            <div class="row">
                                            <div class="col-md-6">
                                                    <label class=" col-form-label required">Maximum Selection</label>
                                                    <div class="form-group row">
                                                        <div class="col-sm-4">
                                                            <input type="text" class="form-control " name="menu" id="menu" <?php echo $m;?> />
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
                                                        <input class="form-check-input" type="checkbox" value="" name="flexCheckChecked"  required style="font-size:21px" id="flexCheckChecked" >
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
                                    <div class="card-body" id="dataTableBody">

                                    <!-- <form id="frm-example" action="test.php"> @stalin-->
                                        
                                    <table id="billSelectionTable" class="display responsive nowrap "  style= "width: 100% !important;">
                                    <div id="datatables">

                                    <?php if($roletypecode == '02'){ //ADC Role
                                        ?>

                                    <div class="row">  <!-- DIv Start --->
                            <div class="col-md-2" style="display:none">
                            <label class=""></label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <button class="btn btn-danger"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Revert Back</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-8">
                            
                            </div>
                           
                            <div class="col-md-2">
                                <label class=""></label>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                        <button class="btn btn-success forward-btn" data-action="forward" onclick="forward_to_jc_one()"><i class="fa fa-thumbs-up" aria-hidden="true" ></i> Forward </button> 
                                        <input type="hidden" name="action" id="action" />
                                        <input type="hidden" name="ids" id="ids" />
                                        </div>
                                    </div>
                            </div>
                            
                        </div><!-- DIv Start --->
                        <?php }
                        else if($roletypecode == '03'){ //JC Role


                                            /*** List of Dcs
                                             * 
                                             * /
                                             */
                                            $distcode = $_SESSION['user']->distcode;

                                            $dbModel = new database;
                                        $dbModel->query("SELECT * FROM mybillmyright.mst_dept_user where distcode ='$distcode' and roletypecode = '04'
ORDER BY userid ASC ");
                                            $listjcs = $dbModel->resultSet1();
//echo '<pre>';
                                            //print_r($listjcs);

                                           

                                             /*** List of Dcs
                                              * 
                                              */

                                             ?>


                           
                            <div class="row" >  <!-- DIv Start --->
                            <!-- <div class="col-md-2" style="display:none">
                            <label class=""></label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <button class="btn btn-danger revert_back_btn" onclick="revert_back_to_adc_one()" ><i class="fa fa-thumbs-down" aria-hidden="true"></i> Revert Back</button>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-8">
                            
                            </div>
                             <div class="col-md-2">
                                <label class=""></label>
                                    <div class="form-group row">
                                        
                                    </div>
                            </div>

                           
                            <!-- <div class="col-md-2">
                                <label class=""></label>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                        <button class="btn btn-success forward-btn" data-action="forward" onclick="forward_to_dc_one()"><i class="fa fa-thumbs-up" aria-hidden="true" ></i> Forward </button> 
                                        <input type="hidden" name="action" id="action" />
                                        <input type="hidden" name="ids" id="ids" />
                                        </div>
                                    </div>
                            </div> -->
                            
                        </div>
                        <br>
                        <?php 




                        }
                        else if($roletypecode == '04'){ //DC Role



 
                                            $distcode = $_SESSION['user']->distcode;

                                            $dbModel = new database;
                                        $dbModel->query("SELECT * FROM mybillmyright.mst_dept_user where distcode ='$distcode' and roletypecode = '05'
ORDER BY userid ASC ");
                                            $listacs = $dbModel->resultSet1();?>

                                            










                            
                            <div class="row">  <!-- DIv Start --->
                           <!--  <div class="col-md-2" >
                            <label class=""></label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <button class="btn btn-danger revert_back_btn" onclick="revert_back_to_jc_one()" ><i class="fa fa-thumbs-down" aria-hidden="true"></i> Revert Back</button>
                                    </div>
                                </div>
                            </div> -->
                            <div class="col-md-6">
                            
                            </div>
                             <div class="col-md-2">
                                <label class=""></label>
                                    <div class="form-group row">
                                        <div class="col-sm-12">

                         
                                      



                                        </div>
                                    </div>
                            </div>
                           
                           <!--  <div class="col-md-2">
                                <label class=""></label>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                        <button class="btn btn-success forward-btn" data-action="forward" onclick="forward_to_ac_one()"><i class="fa fa-thumbs-up" aria-hidden="true" ></i> Forward </button> 
                                        <input type="hidden" name="action" id="action" />
                                        <input type="hidden" name="ids" id="ids" />
                                        </div>
                                    </div>
                            </div> -->
                            
                        </div>
                        <br>




                     <?php    }
                         else if($roletypecode == '05'){ //AC Role
                            $distcode = $_SESSION['user']->distcode;

                                            $dbModel = new database;
                                        $dbModel->query("SELECT * FROM mybillmyright.mst_dept_user where distcode ='$distcode' and roletypecode = '04'
ORDER BY userid ASC ");
                                            $listdcs = $dbModel->resultSet1();
                            ?>
                          
                            <div class="row">  <!-- DIv Start --->
                            <!-- <div class="col-md-2" >
                            <label class=""></label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <button class="btn btn-danger revert_back_btn" onclick="revert_back_to_dc_one()" ><i class="fa fa-thumbs-down" aria-hidden="true"></i> Revert Back</button>
                                     <input type="hidden" name="action" id="action" />
                                        <input type="hidden" name="ids" id="ids" />
                                    </div>
                                </div>
                            </div> -->
                              <div class="col-md-2">
                                <label class=""></label>
                                    <div class="form-group row">
                                        <div class="col-sm-12">

                       
                                      



                                        </div>
                                    </div>
                            </div>
                            <div class="col-md-6">
                            
                            </div>
                           
                          <!--  <div class="col-md-2">
                                <label class=""></label>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                        <button class="btn btn-success forward-btn" data-action="forward" onclick="verify_to_ac_one()"><i class="fa fa-thumbs-up" aria-hidden="true" ></i> Verify </button> 
                                        <input type="hidden" name="action" id="action" />
                                        <input type="hidden" name="ids" id="ids" />
                                        </div>
                                    </div>
                            </div>-->
                            
                        </div>
                        <br>




                       <?php }
                        
                        // @stalin
                        
                        
                        
                        ?>
                                    </div>
                                        <thead>
                                            <tr>
                                                <th style="width: 2%;padding-left:24px !important"><input name="select_all" value="1" type="checkbox"></th>
                                                <th class="fontClass">District Name</th>
                                                <th class="fontClass">Invoice Number</th>
                                                <th class="fontClass">Shop Name</th>
                                                <th class="fontClass">Bill <br>Purchase Date</th>
                                                <th class="fontClass">Invoice<br> Amount</th>
                                                <th class="fontClass">Invoice copy</th>
                                               
                                                <th>Process Code</th>
                                                 <th>Roles</th>
                                                
                                                <th class="fontClass">Action</th>
                                                <th class="fontClass">User Name </th>
                                                <th class="fontClass">Mobile Number</th>
                                                <th  class="fontClass">Order ID</th>
                                                 <th  class="fontClass">Message</th>
                                                
                                               
                                               
                                               
                                                

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
        var nic_roleid	=	'<?php echo $this->nic_roletypecode ?>';
      <?php  $session	=	$this->session_details(); 
		$session_roleid	=	$session[0]->roletypecode;
        
        ?>
        session_roleid='<?php echo $session_roleid?>';
    

        window.onload = function() 
        {




            //debugger;

          //  emptyTableChecking( , "all");

           //   var userDataTable = $('#billSelectionTable').DataTable();

           // if ( ! userDataTable.data().any() ) {
           //      $('#dataTableBody').hide();
           //  }
           //  else{
           //     $('#dataTableBody').hide();
           //  }




            var valiator = $('#allotment_form').validate({


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


    
    // $('#billSelectionTable').dataTable().fnDestroy();
    let selectCountValue = $('#menu').val();
    $('#allotment_confirmation_alert').modal('show');
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
				url: '<?php echo URLROOT; ?>/Allotment/AllDistrictsDisabledChecking',
				paging: "true",
				dataType: "json",
                type	: 'POST',
                data	:{
                    csrf    :   $('#csrf').val(),
                    district :district,
        

                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        debugger;

                      
                       if(data.message == 'true'){
                         $('#dataTableBody').show();
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

                        if( session_roleid == "02"){

                             var userDataTable = $('#billSelectionTable').DataTable();
                           if ( ! userDataTable.data().any() ) {
                                $('#dataTableBody').hide();
                            }

                        }

                        // var userDataTable = $('#billSelectionTable').DataTable();
                        // userDataTable.destroy();

                        // $('#dataTableBody').hide();

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


                           // var userDataTable = $('#billSelectionTable').DataTable();
                           // if ( ! userDataTable.data().any() ) {
                           //      $('#dataTableBody').hide();
                           //  }
            
                       
                        // var myTable = jQuery("#billSelectionTable");
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
            //  $("#datatables").html(`<div class="d-flex justify-content-center"><div class="spinner-border" role="status"><span class="sr-only">Loading...</span></div></div>`);
             

             fetch_data_auto_load(selectCountValue ,yearmonth,seedValue,district,actionfunc = 'form-submit' );
             
             



            
		
		}
        $(".forward-btn").attr('disabled', "disabled");
        $(".revert_back_btn").attr('disabled', "disabled");

        $('#billSelectionTable').on('change', 'input[type="checkbox"]', function() {
           
            let selectedCheckboxCount = $("#billSelectionTable input[type=\"checkbox\"]:checked").length;


           
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


        function fetch_data_auto_load(selectCountValue ,yearmonth,seedValue,district,actionfunc) 
        { 
            debugger;
           
             var formData = {
                select_count_value: selectCountValue,
                yearmonth: yearmonth,
                seedValue: seedValue,
                district : district,
                act : actionfunc
            };

          
           //emptyTableChecking(formData , district);

           if(district != 'all')
                             {
                                     $('#dataTableBody').show();
                              displayDatatable(formData);
                             }
                              else{
                                     $('#dataTableBody').show();
                                displayDatatable(formData);
                                //emptyTableChecking(formData , district);
                             }

           

			
		}
        function emptyTableChecking(formData , district){
             $.ajax({
                url: '<?php echo URLROOT; ?>/Allotment/EmptyTableCheckingToServer',
                paging: "true",
                dataType: "json",
                type    : 'POST',
                data    :{
                    csrf    :   $('#csrf').val(),
                    
               

                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        debugger;
                                              
                         if(data.message == 'true'){

                             if(district != 'all')
                             {
                                    // $('#dataTableBody').show();
                              displayDatatable(formData);
                             }
                              else{
                                    // $('#dataTableBody').show();
                                displayDatatable(formData);
                             }
                                                        
                              
                        }
                        else{
                            swal({
                                    title: "", 
                                    text: "Records is not available Bill Details DB", 
                                    type:"success"
                                }).then(function(){ 
                                     location.reload();
                                }
                                );

                                $('#dataTableBody').hide();

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
        function displayDatatable(formData){
            //@stalin
            var baseurl = '<?php echo URLROOT; ?>/Allotment/FetchingAllotmentDataAuto';
            var userDataTable = $('#billSelectionTable').DataTable({
                "fnInitComplete": function(oSettings) {
           if (oSettings.aiDisplayMaster.length <= 0) {
               $("#dataTableBody").hide();
           }
        },
            'processing': true,
            'serverSide': true,
            'serverMethod': 'post',
            'paging': true,
            'pageLength' : 5,
            'lengthMenu': [[5, 10, 20, -1], [5, 10, 20,"All"]],
            'iDisplayLength': -1,
            'ajax': {
                'url': baseurl,
                data: formData,
            },
            
            'destroy':true,
            responsive: {
            details: {
                type: 'column'
            }
        },
            'columns': [
                {
                    data: 'bill_selection_id'
                },
                {
                    data: 'distename',
                },
                 {
                    data: 'billnumber'
                },
                {
                    data: 'shopname'
                },
                 {
                    data: 'billdate'
                },
                 {
                    data: 'billamount'
                },
                {
                    data: 'filepath'
                },
               
                {
                    data: 'process_code',
                },
                  {
                    data: 'roles',
                },
                 {
                    data: 'action'
                },
                
                {
                    data: 'name'
                },
                {
                    data: 'mobilenumber'
                },

                 {
                    data: 'order_by_column'
                },

                 {
                    data: 'message'
                },
                
                

                
               
                

            ],
        //      columnDefs: [
        //     { responsivePriority: 1, targets: 0 },
        //     { responsivePriority: 10001, targets: 4 },
        //     { responsivePriority: 2, targets: -2 }
        // ],
            'columnDefs': [
            
            

             { 
                    responsivePriority: 1,
                    targets: 0,
                     className: 'dtr-control',
                     orderable: false,
                     'checkboxes': {
                        'selectRow': true
                     }
                },
                 
                
                  
                   // { responsivePriority:4, targets: 5 },
                   { responsivePriority: 2, targets: -3 },
                  // { responsivePriority: 3, targets: 3 },
                  // { responsivePriority: 10001, targets: 8 },
                  // { responsivePriority: 10002, targets: 9 },
                  // { responsivePriority: 10003, targets: 10 },
                    // { responsivePriority: 3, targets: 6 },

             
               
            

            // { responsivePriority: 10002, targets: -3 },
             
            // {
            //     responsivePriority: 2,
            //     'targets': 0,
            //      className: 'dtr-control',
            // orderable: false,
            //     'checkboxes': {
            //         'selectRow': true
            //     }
            // },



            // { responsivePriority: 10001, targets: 4 },
            // { responsivePriority: 2, targets: -2 }

             ],
             order: [ 1, 'asc' ],
            'select': {
                'style': 'multi'
            },

        });


            // if ( ! userDataTable.data().any() ) {
            //     $('#dataTableBody').hide();
            // }
            // else{
            //    $('#dataTableBody').hide();
            // }
            


          
        }
        function cancel_confirmation_box(){
             $('#allotment_confirmation_alert').modal('hide');
              $('#distid').prop('disabled', false);
              $('#bill_year').prop('disabled', false);
              $('#bill_month').prop('disabled',  false);
             // $('#flexCheckChecked').removeattr('disabled', 'disabled');
              $('#menu').prop('disabled', false);
        }
         function allotment_fetch_data(){
            // var table = $('#billSelectionTable').DataTable();
            // table.destroy();
            //;
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

           


           

             //let seedValue  = 0.33;


            if(district == undefined){
                alert("Already ALl Districts Selected");
                return false;
            }
            fetch_data(selectCountValue ,yearmonth,seedValue,district );
           // location.reload()
            //$('#button_action').attr('disabled', 'disabled');

         }
         function forwardConfirmationOpen(){
            $('#forward_confirmation_alert').modal('show');
         }

         function role_revert_back(dc_value,remarks,id){


              if(session_roleid == "02"){ //ADC
                var ids =   $("#ids").val();
                var p_bill_selection_id = ids;
                var role_type_id          =  "03"; 
                var role_type_name        = "JC"; 
                var dc_name = '';
                var remarks ="Forward To  JC";
            }
            else if(session_roleid == "03"){ //JC
                var role_type_id          =  "04"; 
                var role_type_name        = "DC";
                 var dc_name = dc_value;
                var p_bill_selection_id =   id;
            }
            else if(session_roleid == "04"){ //DC
                var role_type_id          =  "03"; 
                var role_type_name        = "JC";
                var dc_name = dc_value;
                 var p_bill_selection_id =   id;
            }
             else if(session_roleid == "05"){  //AC
               
                var role_type_id          =  "04"; 
                var role_type_name        = "DC";
                var dc_name = dc_value;
                var p_bill_selection_id =   id;
            }


            $.ajax({
				url: '<?php echo URLROOT; ?>/Allotment/RevertBackToBeforeRole',
				paging: "true",
				dataType: "json",
                type	: 'POST',
                data	:{
                    csrf    :   $('#csrf').val(),
                    bill_selection_id  : p_bill_selection_id ,
                     dc_name  : dc_name ,
                     remarks : remarks
               

                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                                              
                         if(data.message == 'true'){
                            
                              swal({
                                    title: "", 
                                    text: "Revert Back Successfully To "+role_type_name, 
                                    type:"success"
                                }).then(function(){ 
                                    location.reload();
                                }
                                );

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
        
         

         function role_forward(dc_value,remarks,id){

            debugger;

         // let p_bill_selection_id =   id;




        
          

            if(session_roleid == "02"){
                var ids =   $("#ids").val();
                var p_bill_selection_id = ids;
                var role_type_id          =  "03"; 
                var role_type_name        = "JC"; 
                var dc_name = '';
                var remarks ="Forward To  JC";
            }
            else if(session_roleid == "03"){
                var role_type_id          =  "04"; 
                var role_type_name        = "DC";
                 var dc_name = dc_value;
                var p_bill_selection_id =   id;
            }
            else if(session_roleid == "04"){
                var role_type_id          =  "04"; 
                var role_type_name        = "AC";
                var dc_name = dc_value;
                 var p_bill_selection_id =   id;
            }
             else if(session_roleid == "05"){
               
                var role_type_name        = "v";
            }

            $.ajax({
				url: '<?php echo URLROOT; ?>/Allotment/ForwardToNextRole',
				paging: "true",
				dataType: "json",
                type	: 'POST',
                data	:{
                    csrf    :   $('#csrf').val(),
                    bill_selection_id  : p_bill_selection_id ,
                    dc_name  : dc_name ,
                    remarks : remarks
               

                },
                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                       
                        if(data.message == 'true'){

                            if(role_type_name == 'v'){

                                 swal({
                                    title: "", 
                                    text: "Verified Successfully", 
                                    type:"success"
                                 }).then(function(){ 
                                    location.reload();
                                });

                            }
                            else{

                                 swal({
                                    title: "", 
                                    text: "Forwarded Successfully to "+role_type_name, 
                                    type:"success"
                                 }).then(function(){ 
                                    location.reload();
                                });

                            }


               
                            
                            // swal("Forwarded Successfully to "+role_type_name) ;
                            // setTimeout(function(){
                            //     window.location.reload();
                            //   }, 5000);
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


                // Handle form submission event
        $(".action-btn").on('click', function(e) {
            e.preventDefault;
            debugger;
            
            $("#action").val($(this).data('action'));

            let action_value = $("#action").val();
           

            if(session_roleid == "02"){

                 var dc_value ="";

            }
            else if(session_roleid == "03"){
                var dc_value = $(this).parents().parents().find(' #list-dcs option:selected').val();
            }
            else if(session_roleid == "04"){
               var dc_value = $(this).parents().parents().find(' #list-acs option:selected').val();
            }
             else if(session_roleid == "05"){ //Ac For revert back
               var dc_value = $(this).parents().parents().find(' #list-dcs-rb option:selected').val();
            }
            
           // var dc_value = $(this).parents().parents().find(' #list-dcs option:selected').val();

            // make the form submit
            var rows_selected = $('#billSelectionTable').DataTable().column(0).checkboxes.selected();



            //let form = "#frm-example";
            let rowIds = "";



            if (rows_selected.length == 0) {

                swal("Please select atleast one checkbox");
                return false;

            } else {

                let title = action_value[0].toUpperCase() +action_value.slice(1);
                $.each(rows_selected, function(index, rowId) {
                            // Create a hidden element
                            rowIds += `${rowId},`;

                        });
                        rowIds = rowIds.substring(0, rowIds.length - 1);

                        $("#ids").val(rowIds);
                        ;
                        if(action_value =='role_forward'){
                            role_forward(dc_value,"","");
                        }
                        else if(action_value =='role_revertback'){
                            role_revert_back(dc_value);
                        }

                       
                    

            }

        });
     $(function() {
        // $('#button_action').attr('disabled', 'disabled');
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

      $('#billSelectionTable').on('change', '#p_code', function(e) {

          var p_code_value = $(this).val();
          if(p_code_value == 'R'){

          $(this).closest("tr").find('#jc_role_user_id').show();
          $(this).closest("tr").find('#role_user_id').hide();

          }
          else{
             $(this).closest("tr").find('#jc_role_user_id').hide();
             $(this).closest("tr").find('#role_user_id').show();

          }

         
       

         });


      $('#billSelectionTable').on('change', '#p_ac_code', function(e) {
        debugger;

          var p_code_value = $(this).val();
          if(p_code_value == 'R'){

          $(this).closest("tr").find('#role_user_id_dc').show();

          }
          else{
              $(this).closest("tr").find('#role_user_id_dc').hide();

          }

         
       

         });


     $('#billSelectionTable').on('click', '.publishbtn', function(e) { // publish button start
            e.preventDefault()
            debugger;
            var id = $(this).data('id');

            if(session_roleid == "05"){
                var roles_id = $(this).closest("tr").find('#role_user_id_dc option:selected').val();
                var dc_value = roles_id ;
                var process_code = $(this).closest("tr").find('#p_ac_code option:selected').val();

            }
            else{
                var roles_id = $(this).closest("tr").find('#role_user_id option:selected').val();
                var dc_value = roles_id ;
                var process_code = $(this).closest("tr").find('#p_code option:selected').val();
            }
            
           

            swal("Write something here:", {
                content: "input",
                })
                .then((remarks) => { //then start
                //swal(`You typed: ${value}`);
                if(remarks == ""){
                    swal("Enter Remarks");
                    return false;
                }

                if(process_code == 'F'){
                    role_forward(dc_value,remarks,id)
                }
                else if(process_code == 'V'){

                    role_verified(dc_value,remarks,id)

                }
                 if(process_code == 'R'){
                    role_revert_back(dc_value,remarks,id)
                }

              //  role_forward(dc_value,remarks)

               
            });      // Then end    
         

        }); // publish button end


function role_verified(dc_value,remarks,id){
     $.ajax({ //ajax start
        url: '<?php echo URLROOT; ?>/Allotment/VerifyTo',
        dataType: "json",
        type    : 'POST',
        data    :{
            csrf    :   $('#csrf').val(),
            bill_selection_id  : id ,
            remarks: remarks,
            dc_value :dc_value
        

        }, // in ,my case the absence of this was the cause of failure
    

                success: function(data, textStatus, jqXHR) 
                {
                    if(jqXHR.status=='200')
                    {
                        
                        if(data.message == 'true'){
debugger;

                swal({
                    title: "", 
                    text: data.text, 
                    type:"success"
                 }).then(function(){ 
                    location.reload();
                }
                );       
                        }
                     
                    }
                },
                error: function (xhr, status, error) 
                { //error start
                    var err = JSON.parse(xhr.responseText);     

                    if(err.code==413)
                    {
                        alert('Extra characters included')
                    }   
                    if(err.code== 403)
                        alert('csrf token invalid')

                    if(err.code==400)
                        alert('Bad request');
                }, // error end
      
      
                }); //ajax end
}




     function forward_to_jc_one(){
         $('#jc_two_confirmation_alert').modal('show');    
    }
      function forward_to_jc_two(){
         $('#jc_two_confirmation_alert').modal('show');
     }

      function forward_to_dc_one(){
         $('#dc_fwd_one').modal('show');    
    }

      function forward_to_dc_two(){
         $('#dc_fwd_two').modal('show');    
    }

     function forward_to_ac_one(){
         $('#ac_fwd_one').modal('show');    
    }

      function forward_to_ac_two(){
         $('#ac_fwd_two').modal('show');    
    }

     function verify_to_ac_one(){
         $('#ac_verify_one').modal('show');    
    }

      function verify_to_ac_two(){
         $('#ac_verify_two').modal('show');    
    }

    

     

     function revert_back_to_adc_one(){
         $('#adc_one_confirmation_alert').modal('show');     }
      function revert_back_to_adc_two(){
         $('#adc_two_confirmation_alert').modal('show');
     }



     function revert_back_to_dc_one(){
         $('#dc_rb_one').modal('show');     }
      function revert_back_to_dc_two(){
         $('#dc_rb_two').modal('show');
     }

     function revert_back_to_jc_one(){
         $('#jc_rb_one').modal('show');     }
      function revert_back_to_jc_two(){
         $('#jc_rb_two').modal('show');
     }




      function getRevertBacktoJC(selectObject) {


            debugger;
            var value = selectObject.value; 
          
            if(value == "R"){
              $('#p_code').closest('tr').find("#jc_role_user_id").show();
              
                $('#p_code').parent('tr').next().find("#role_user_id").hide();

            }
            else{

                $("#jc_role_user_id").hide();
                $("#role_user_id").show();

            } 
 
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


   /*   $(document).ready(function () {
   
 
 
        // Get the column API object
        var column = billSelectionTable.column($(this).attr('data-column'));
 
        // Toggle the visibility
        column.visible(!column.visible());
   
});
*/
    </script>

<style>
    .fontClass{
        font-size: 15px;
    }

    .dt-checkboxes{
        margin-left: 10px; 
    }


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
table.dataTable.dtr-column>tbody>tr>td.dtr-control:before, table.dataTable.dtr-column>tbody>tr>th.dtr-control:before, table.dataTable.dtr-column>tbody>tr>td.control:before, table.dataTable.dtr-column>tbody>tr>th.control:before {
    top: 42% !important;
    left: 12% !important;
    font-size: 15px;
}
</style>

</body>

</html>