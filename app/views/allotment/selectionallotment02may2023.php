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

                                        <form class="forms-sample " id="allotment_form" name="allotment_form" method="POST" >
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

                                     <form id="frm-example" name ="frm-example" onsubmit="return false;"> 
                                        <!-- @table-->
                                        
                                    <table id="billSelectionTable" class="table table-bordered display responsive nowrap "  style= "width: 100%;display:none">
                                    <div id="datatables">

                                    <?php if($roletypecode == '02'){ //ADC Role
                                        ?>



                    

                                    <!-- <div class="row"> 
                            <div class="col-md-2" style="display:none">
                            <label class=""></label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <button class="btn btn-danger"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Revert Back</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-9">
                            
                            </div>
                           
                            <div class="col-md-1">
                                <label class=""></label>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                        <button class="btn btn-success forward-btn" data-action="forward" onclick="forward_to_jc_one()"><i class="fa fa-thumbs-up" aria-hidden="true" ></i> Forward </button> 
                                        <input type="hidden" name="action" id="action" />
                                        <input type="hidden" name="ids" id="ids" />
                                        </div>
                                    </div>
                            </div>
                            
                        </div> --><!-- DIv Start --->
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

                            <input type="hidden" name="ids" id="ids" />
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
                                                <th><input name="select_all" value="1" type="checkbox" id="multipleCheckbox"></th>
                                                <th>District Name</th>
                                                <th style="text-align: center;">Invoice Details</th>
                                                <th style="text-align: center;">Invoice Amount</th>
                                                <th>Action</th>
                                                <th style="text-align: center;">Order <br>ID</th>
                                                <th>Remarks</th>
                                                <th>Status</th>
                                                <?php 

                                                if($roletypecode == "02"){

                                                    echo '
                                                     <th>Userd Name </th>
                                                     <th>Mobile Number</th>
                                                     <th>Invoice <br> copy</th>';
                                                }
                                                else{

                                                     echo '
                                                     <th class="none" >Userd Name </th>
                                                     <th class="none">Mobile Number</th>
                                                     <th class="none">Invoice copy</th>';

                                                }

                                                ?>
  
                                                

                                            </tr>
                                        </thead>


                                    </table>
                                    
                                    <p class="form-group">
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </p><!-- 
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


</style>

</body>

</html>