<?php
class Allotment extends Controller
{


    public function __construct()
    {
        $this->Mybill = $this->controller('Mybill');
        $this->Basemodel = $this->model('Basemodel');
        // if (!isset($_SESSION['user'])) {
           
        //     header("Location: " . URLROOT . "");
        // }
        $this->nic_roleid   =   '01';
        $this->adc_roleid   =   '02';
        $this->jc_roleid    =   '03';
        $this->dc_roleid    =   '04';
        $this->ac_roleid    =   '05';
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
    public function FetchingAllotmentDataAuto()
    {
      
       ## Read value
       $draw = $_POST['draw'];
       $row = $_POST['start'];
       $rowperpage = $_POST['length']; // Rows display per page
       $columnIndex = @$_POST['order'][0]['column']; // Column index
       $columnName = @$_POST['columns'][$columnIndex]['data']; // Column name
       $columnSortOrder = @$_POST['order'][0]['dir']; // asc or desc
       $searchValue = @$_POST['search']['value']; // Search value
       ## Search 
       $searchQuery = "";
       if ($searchValue != '') {
           $searchQuery = "   md.distename ilike '%".$searchValue."%' or 
           bd.mobilenumber ilike '%".$searchValue."%' or
           mu.name ilike '%".$searchValue."%'  or
           bd.billnumber ilike '%".$searchValue."%'  or
           bd.billamount::TEXT ilike '%".$searchValue."%'  or
           bd.shopname ilike '%".$searchValue."%' or 
           TO_CHAR(bd.billdate, 'yyyy-mm-dd') like'%".$searchValue."%'
           ";
       }



        $countValue             = trim($_POST['select_count_value']);
        $str                    = trim($_POST['yearmonth']);
        $yearmonth              = substr($str, 2);
        $seedValue              = trim($_POST['seedValue']);
        $district               = trim($_POST['district']);
         $act         = trim($_POST['act']);
         $bill_status            = trim($_POST['bill_status']);
        if( $act == 'form-submit'){
            $model              =   new Basemodel;
            $datapf             = $model->getallotment_data_pf($countValue,$yearmonth,$seedValue,$district);
            
        }

        
        $session_details    =   $this->Mybill->session_details();
        $session_roleid     =   $session_details[0]->roletypecode;
        $role_type_id       = $session_roleid;
        $model              =   new Basemodel;
        $totalRecordsWithoutFiltering =  $model->totalRecordsWithOutFiltering($district,$role_type_id,$bill_status);
        $totalRecordwithoutFilter = $totalRecordsWithoutFiltering->bstablecount;
        $totalRecordsWithFiltering =  $model->totalRecordsWithFiltering($searchQuery,$district,$role_type_id,$bill_status);
        $totalRecordwithFilter = $totalRecordsWithFiltering->allcount;
        $fetchRecords = $model->getallotment_data(
            $countValue,
            $district,
            $role_type_id,
            $searchQuery,
            $columnName,
            $columnSortOrder,
            $row,
            $rowperpage,
            $bill_status


        );
        $uploadFolder = 'https://10.163.2.160/projects/gstweb/uploads/';

        $data = array();
        $keys = array_keys($fetchRecords);
        for($j = 0; $j < count($fetchRecords); $j++) { //forloop start
             $filePath = "";
            foreach ($fetchRecords[$keys[$j]] as $key => $value){  // Foreach Start

            $Basemodel = new Basemodel;
            $Basemodel->tablename = "mybillmyright.mst_dept_user";
            $id = 'userid';
            $distcode = $_SESSION['user']->distcode;
            $roletypecode = $_SESSION['user']->roletypecode;
            if( $roletypecode == '02'){  //ADC
                    $fetch_roles = ''; 
                    $process_code = "<select name='processcode' id='processcode'>
                    <option value='F'>Forward</option></select>";
                    $fianl_roles = $fetch_roles;
            }
            else if( $roletypecode == '03'){//JC
                
                $status = array('roletypecode' => '04','distcode' =>$distcode);
                 $kj = $j+1;
                 $fetchRecords12 = ($Basemodel->getMultipleData($status, $id));
                 $fetch_roles = '';
                 $fetch_roles .= "<select name='r{$kj}_roleuserid' id='roleuserid' class='form-select roleuserid' style='width:200px'>";
                  foreach($fetchRecords12 as $val){
                        $fetch_roles .= "<option value='" . $val->userid . "'>" . $val->name . "</option>";
                  }
                 $fetch_roles .="</select>";
                $process_code = <<<TEXT
                <select name="r{$kj}_processcode" id='processcode' class='form-select processcode'>
                <option value='F'>Forward</option></select>
TEXT;
                $fianl_roles = $process_code.'<br>'.$fetch_roles ;
            } // JC
            else if( $roletypecode == '04'){  //DC




                // List of Acs
                $status = array('roletypecode' => '05','distcode' =>$distcode );
                $kj = $j+1;
                $fetchRecords12 = ($Basemodel->getMultipleData($status, $id));

                // echo '<pre>';
                // print_r( $fetchjcs);

                $fetch_roles = '';
                $fetch_roles .= "<select name='r{$kj}_roleuserid' id='roleuserid' class='form-select' style='width:125px'>";
                foreach($fetchRecords12 as $val){
                    $fetch_roles .= "<option value='" . $val->userid . "'>" . $val->name . "</option>";
                }
                $fetch_roles .="</select>";
                // List of Acs

                  // List of Jcs
                $status = array('roletypecode' => '03','distcode' =>$distcode );
                $kj = $j+1;
                $fetchjcs = ($Basemodel->getMultipleData($status, $id));


                // echo '<pre>';
                // print_r( $fetchjcs);

                $list_jc = '';
                $list_jc .= "<select name='r{$kj}_jcs' id='listjc' class='form-select' style='width:125px;display:none'>";
                foreach($fetchjcs as $jc){
                    $list_jc .= "<option value='" . $jc->userid . "'>" . $jc->name . "</option>";
                }
                $list_jc .="</select>";
                // List of Jcs




                $process_code = <<<TEXT
                <select name="r{$kj}_processcode" id='processcode' class='form-select processcode'>
                <option value='F'>Forward</option>
                <option value='R'>Return</option></select>
TEXT;
               $fianl_roles = $process_code."<br>".$fetch_roles."<br>".$list_jc;

            } //DC
            else{//AC
                 $kj = $j+1;
                 $status = array('roletypecode' => '04','distcode' =>$distcode);
                 $kj = $j+1;
                 $fetchRecords12 = ($Basemodel->getMultipleData($status, $id));

                 $bsid = $value['bill_selection_id'];

                 $disadbled = $Basemodel->getDisabled($bsid);
                 $alreadyBillSelectedDistricts = array();
                 $uid  = $disadbled->updated_by;
                 $alreadyBillSelectedDistricts[] =   $uid;
                 $fetch_roles = '';
                 $fetch_roles .= "<select name='r{$kj}_roleuserid' id='roleuserid' class='form-select roleuserid' style='width:200px;display:none !important'>";
                  foreach($fetchRecords12 as $val){
                    $disabledStr = in_array($val->userid, $alreadyBillSelectedDistricts) ? "" : "disabled";
                        $userid_wit_bill_id = $val->userid;
                     
                        $fetch_roles .= "<option   value='" . $userid_wit_bill_id . "' " . $disabledStr . ">" . $val->name . "</option>";
                        
                  }
                 $fetch_roles .="</select>";

                $process_code = <<<TEXT
                <select name="r{$kj}_processcode" id='processcode' class='form-select processcode' >
                <option value='V'>Verifed-Eligible</option>
                <option value='VIE'>Verifed-InEligible</option>
                <option value='R'>Sent Back</option>
                <option value='RO'>Rejected Options</select>
TEXT;
                $fianl_roles = $process_code."<br>".$fetch_roles;

            }
            if( $session_roleid =='03' || $session_roleid =='04' || $session_roleid =='05'){
                $kj = $j+1;
                    $remarks_button = "<textarea id='remarks' name='r{$kj}_remarks' rows='4' class='textAreaclass' maxlength='500' minlength='5' >
</textarea><input type='hidden'  name ='r{$kj}_bsid' class='bsid' value='" . $value['bill_selection_id'] . "'>";

$fileLocation         = $uploadFolder.$value['filepath'];
$verifyfilePathLength = $value['filepath'];
 $file                = '<p style="text-align:left"><a target="_blank" class="btn btn-danger" href="'.$fileLocation.'"> <i class="fa fa-file-pdf"></i></a></p>' ;



                }
                else{
                    $remarks_button   = "";
                    $fileLocation         = $uploadFolder.$value['filepath'];
                    $verifyfilePathLength = $value['filepath'];
                     $file                = '<p style="text-align:center"><a target="_blank" class="btn btn-danger" href="'.$fileLocation.'"> <i class="fa fa-file-pdf"></i></a></p>' ;
                }

                $remarks               = $remarks_button ;
               
                 $bill_purchase_date  = date("d-m-Y", strtotime($value['billdate']));
                 $invoiceDetails      = "";
                 $invoiceDetails     .= "<b>Bill Number : </b>".$value['billnumber']."<br>";
                 $invoiceDetails     .= "<b>Shop Name : </b>".$value['shopname']."<br>";
                 $invoiceDetails     .= "<b>Bill Purchase Date : </b>".$bill_purchase_date."<br>";
                 $billAmountWithZero  = $value['billamount'].".00";
                 $invoiceDetails     .= "<b>Bill Amount : </b>".$billAmountWithZero."<br>";
                 $invoiceDetails     .= "<b>District : </b>".$value['distename']."<br>";
                // $invoiceDetails     .= "<b>Order Id : </b>".$value['order_by_column']."<br>";
                // $invoiceDetails     .= "<b>User Name : </b>".$value['name']."<br>";
               //  $invoiceDetails     .= "<b>Mobile Number : </b>".$value['mobilenumber']."<br>";

                  $order_id          = "<h6 style='text-align:center;'>".$value['order_by_column']."</h6>";
                  $Basemodel = new Basemodel;
                  $id = $value['bill_selection_id'];
                  $getRemarks =  $Basemodel ->getRemarksFunction( $id);


                //   $status_message = '';
                //   $status_message .= "<ul>";
                //   foreach($getRemarks as $remark){

                //     $forwarded_by_name = $remark['forwarded_by_name'];
                //     $forwarded_to_name = $remark['forwarded_to_name'];
                //     $forwarded_on = $remark['forwarded_on'];
                //     $new_date = date('jS F Y h:i A', strtotime($forwarded_on));
                //     $access_code =  $remark['process_code'];
                //     if( $access_code=="F"){
                //         $access_code_msg = "Forwarded To  ";
                //     }
                //     else{
                //          $access_code_msg = "Return  ";
                //     }
                //     $final_remarks = "<b>".$forwarded_by_name." </b>".$access_code_msg.  "<b>".$forwarded_to_name." </b> on " .$new_date;


                //      $status_message .= "<li>" .  $final_remarks . "</li>";
                //   }
                //   $status_message .="</ul>";

                $status_message = '';
                 $status_message .= "<ul>";
                 foreach($getRemarks as $remark){


                   $forwarded_by_name = $remark['forwarded_by_name'];
                   $forwarded_to_name = $remark['forwarded_to_name'];
                   $rm_message = $remark['remarks'];
                   $forwarded_on = $remark['forwarded_on'];
                   $new_date = date('jS F Y', strtotime($forwarded_on));
                   $access_code =  $remark['process_code'];
                   if( $access_code=="F"){
                       $access_code_msg = "Forwarded To  ";

                       if($rm_message == ""){

                        $r = "";

                       }
                       else{

                        $r = "<ul style='list-style:none;padding-left:4px'>
                   
                       <li><i class='far fa-comment-dots' style='color:green;font-size:15px'></i> " .  $rm_message . "</li>
                    </ul>";

                       }


                       
                   }
                   else{
                        $access_code_msg = "Revert Back  ";

                        if($rm_message == ""){

                            $r = "";

                        }
                        else{

                            $r = "<ul style='list-style:none;padding-left:4px'>
                   
                        <li><i class='far fa-comment-dots' style='color:red;font-size:15px'></i> " .  $rm_message . "</li>
                     </ul>";
                     $invoiceDetails     .= '<b>Process Status : </b><i class="fa fa-undo" aria-hidden="true" style="color:red"></i> <style="color:red">Return </p><br>';

                        }






                        
                   }
                   $final_remarks = "<b>".$forwarded_by_name." </b>".$access_code_msg.  "<b>".$forwarded_to_name." </b> on " .$new_date;




                    $status_message .= "<li>" .  $final_remarks . "


                    " .  $r . "
                   
                    </li>";
                 }
                 $status_message .="</ul>";
                 $mobilenumber = '';
                 $mobilenumber .= $value['mobilenumber']."<input type ='hidden' name='bsid[]' value= " . $value['bill_selection_id'] . ">";

                 $kj = $j+1;

                 $bill_selection_id = '';
                 $bill_selection_id .= "<input type ='checkbox'  name='r{$kj}_checkbox' value= " . $value['bill_selection_id'] . ">";


                

                 





           


                // $value['billnumber']."<br>"."/".$value['shopname']."/".$bill_purchase_date;
                 //@stalin
                $data[] = array(
                    "bill_selection_id" => $bill_selection_id,
                    "billnumber"        => $invoiceDetails,
                    "action"           => $fianl_roles,
                    "order_by_column"   => $order_id,
                    "remarks"            => $remarks_button,
                    "status"           => $status_message,
                    "username"              => $value['name'],
                    "mobilenumber"      => $mobilenumber,
                    "invoicecopy"          =>  $file,
                );
                $j++;

            }// Foreach Start
        }// for loop
         ## Response
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithoutFilter,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        echo json_encode($response);
        exit;
    }
     /**
         *  Author: Stalin Thomas
         * 
         * Content : Allotment Module
         * 
         * Date  : 28-04-2023
         * 
         * 
         */


         public function getResultsEachRows(){
            try 
            {
                if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                    throw new Exception('Forbidden','403');
    
                else
                {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                         

                    $logged_in_userid   = $_SESSION['user']->userid;
                    $session_details    =   $this->Mybill->session_details();
                    $session_roleid     =   $session_details[0]->roletypecode;
                    $role_type_id       = $session_roleid;
                    $model = new Basemodel;





                  


                    $forward_to_bill_selection = $model->forwardToBillSelection($_POST,$role_type_id,$logged_in_userid );

                       

                       
                    
                            if($forward_to_bill_selection){


                                // if($data["r1_processcode"]== "F"){ 
                                // }



                                $message = "true";
                                //$remarks = $_POST['r1_remarks'];
                            }
                             else{
                                $message = "false";
                               // $remarks =$_POST['r1_remarks'];
                            }

                           $response = array("message" =>  $message);
                            echo json_encode($response);
                            exit;
                }
            
            }
            catch (Exception $e) 
            {
                header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }
         }


         
         public function getAdcResultsEachRows(){
            try 
            {
                if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                    throw new Exception('Forbidden','403');
    
                else
                {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                         

                    $logged_in_userid   = $_SESSION['user']->userid;
                    $session_details    =   $this->Mybill->session_details();
                    $session_roleid     =   $session_details[0]->roletypecode;
                    $role_type_id       = $session_roleid;
                    $model = new Basemodel;
                   
                    $response = array("message" =>  $_POST);
                    echo json_encode($response);
                    exit;


                    
                }
            
            }
            catch (Exception $e) 
            {
                header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }
         }


      public function VerifyTo(){
            try 
            {
                if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                    throw new Exception('Forbidden','403');
    
                else
                {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                        $bill_selection_id    = $_POST['bill_selection_id'];
                        $remarks    = $_POST['remarks'];
                        
                        $logged_in_userid   = $_SESSION['user']->userid;
    
                        $session_details    =   $this->Mybill->session_details();
                        $session_roleid     =   $session_details[0]->roletypecode;
                        $role_type_id       = $session_roleid;
                        
                        $model = new Basemodel;
                        $forward_to_bill_selection = $model->VerifyToBillSelection(
                            $bill_selection_id,
                            $logged_in_userid,
                            $role_type_id,
                            $remarks,
                        
                        );
                                    if($forward_to_bill_selection){
                                        $message = "true";
                                        $text = "Verified Successfully";
                                    }
                                    else{
                                        $message = "false";
                                        $text = "";
                                    }
    
    
    
                                $response = array(
                                    "message" =>  $message,
                                    "text" =>  $text,
                                   
                                    
                                );
                                echo json_encode($response);
                                exit;
                               
    
                              
                }
            
            }
            catch (Exception $e) 
            {
                header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }
         }




          public function totalMaximumCountbasedConfigTable(){
            try 
            {
                if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                    throw new Exception('Forbidden','403');
    
                else
                {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                        $district    = $_POST['district'];
                        $selectCountValue = $_POST['selectCountValue'];
                        $bill_year = $_POST['bill_year'];
                        $bill_month = $_POST['bill_month'];
                        $model = new Basemodel;
                        $totalCount = $model->totalMaximumCountbasedConfigTable(
                            $selectCountValue,$district,$bill_year,$bill_month
                        
                        );
                             $countValue = count($totalCount);
                            

                       
                       

                                    if($countValue > 0){
                                        $message = "true";
                                        $results = $totalCount ;
                                        $scountvalue =  $selectCountValue ;
                                        $text = "Verified Successfully";
                                        $y = date('Y');
                                        $m = date('m');
                                        $curmonth = $y.$m;
                                        $district = $district ;

                                         //$finalcount = $totalCount *  $scountvalue;
                                    }
                                   
    
    
    
                                $response = array(
                                    "message" =>  $message,
                                    "results"  => $results,
                                     "scountvalue"=>$scountvalue ,
                                     "curmonth"=>$curmonth ,
                                     "district" =>$district 
                                   
                                   
                                    
                                );
                                echo json_encode($response);
                                exit;
                               
    
                              
                }
            
            }
            catch (Exception $e) 
            {
                header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }
         }



     public function VerifyAllotmentDataAuto()
    {
      
       ## Read value
       $draw = $_POST['draw'];
       $row = $_POST['start'];
       $rowperpage = $_POST['length']; // Rows display per page
       $columnIndex = $_POST['order'][0]['column']; // Column index
       $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
       $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
       $searchValue = $_POST['search']['value']; // Search value
       ## Search 
       $searchQuery = "";
       if ($searchValue != '') {
           $searchQuery = "   md.distename ilike '%".$searchValue."%' or 
           bd.mobilenumber ilike '%".$searchValue."%' or
           mu.name ilike '%".$searchValue."%'  or
           bd.billnumber ilike '%".$searchValue."%'  or
           bd.billamount::TEXT ilike '%".$searchValue."%'  or
           bd.shopname ilike '%".$searchValue."%' or 
           TO_CHAR(bd.billdate, 'yyyy-mm-dd') like'%".$searchValue."%'
           ";
       }
        
        $str                    = trim($_POST['yearmonth']);
        $yearmonth              = substr($str, 2);
        $district               = trim($_POST['district']);
        $session_details    =   $this->Mybill->session_details();
        $session_roleid     =   $session_details[0]->roletypecode;
        $role_type_id       = $session_roleid;
        $model              =   new Basemodel;

        $totalRecordsWithoutFiltering =  $model->verifytotalRecordsWithOutFiltering($district,$role_type_id,$searchQuery,$columnName,$columnSortOrder,$row,$rowperpage);
       
         $totalRecordwithoutFilter = $totalRecordsWithoutFiltering->bstablecount;
       




        $totalRecordsWithFiltering =  $model->verifytotalRecordsWithFiltering($district,$role_type_id,$searchQuery,$columnName,
            $columnSortOrder,$row,$rowperpage);
        $totalRecordwithFilter = $totalRecordsWithFiltering->bstablecount;
        $fetchRecords = $model->verifygetallotment_data($district,$role_type_id,$searchQuery,$columnName,
            $columnSortOrder,$row,$rowperpage);





        $uploadFolder = 'https://10.163.2.160/projects/gstweb/uploads/';

        $data = array();
        $keys = array_keys($fetchRecords);
        for($j = 0; $j < count($fetchRecords); $j++) { //forloop start
             $filePath = "";
            foreach ($fetchRecords[$keys[$j]] as $key => $value){  // Foreach Start
                $fileLocation = $uploadFolder.$value['filepath'];
                $verifyfilePathLength = $value['filepath'];
                 $action = '<a target="_blank" href="'.$fileLocation.'">'.$verifyfilePathLength.'</a>' ;
                 $billAmountWithZero  = $value['billamount'].".00";

                  $billAmount          = "<h6 style='text-align:center;'>".$billAmountWithZero."</h6>";
                 $bill_purchase_date  = date("d-m-Y", strtotime($value['billdate']));
                 $invoiceDetails      = "";
                 $invoiceDetails     .= "<b>Bill Number : </b>".$value['billnumber']."<br>";
                 $invoiceDetails     .= "<b>Shop Name : </b>".$value['shopname']."<br>";
                 $invoiceDetails     .= "<b>Bill Purchase Date : </b>".$bill_purchase_date."<br>";
                 $invoiceDetails     .= "<b>Bill Amount : </b>".$billAmountWithZero."<br>";
                 
                  $order_id          = "<h6 style='text-align:center;'>".$value['order_by_column']."</h6>";
                  $Basemodel = new Basemodel;
                  $id = $value['bill_selection_id'];
                  $getRemarks =  $Basemodel ->getRemarksFunction( $id);
                  $status_message = '';
                  $status_message .= "<ul>";
                  foreach($getRemarks as $remark){
 
 
                    $forwarded_by_name = $remark['forwarded_by_name'];
                    $forwarded_to_name = $remark['forwarded_to_name'];
                    $rm_message = $remark['remarks'];
                    $forwarded_on = $remark['forwarded_on'];
                    $new_date = date('jS F Y', strtotime($forwarded_on));
                    $access_code =  $remark['process_code'];
                    if( $access_code=="F"){
                        $access_code_msg = "Forwarded To  ";
                        $r = "<ul style='list-style:none;padding-left:4px'>
                    
                        <li><i class='far fa-comment-dots' style='color:green;font-size:15px'></i> " .  $rm_message . "</li>
                     </ul>";
                    }
                    else if($access_code=="V"){

                        $access_code_msg = "Verified   ";
                        $r = "<ul style='list-style:none;padding-left:4px'>
                    
                        <li><i class='far fa-comment-dots' style='color:blue;font-size:15px'></i> " .  $rm_message . "</li>
                     </ul>";

                    }
                    
                    else{
                         $access_code_msg = "Revert Back  ";
                         $r = "<ul style='list-style:none;padding-left:4px'>
                    
                         <li><i class='far fa-comment-dots' style='color:red;font-size:15px'></i> " .  $rm_message . "</li>
                      </ul>";
                    }
                    $final_remarks = "<b>".$forwarded_by_name." </b>".$access_code_msg.  "<b>".$forwarded_to_name." </b> on " .$new_date;
 
 
 
 
                     $status_message .= "<li>" .  $final_remarks . "
 
 
                     " .  $r . "
                    
                     </li>";
                  }
                  $status_message .="</ul>";

                  $fileLocation         = $uploadFolder.$value['filepath'];
                $verifyfilePathLength = $value['filepath'];
                 $file                = '<p style="text-align:center"><a target="_blank" class="btn btn-danger" href="'.$fileLocation.'"> <i class="fa fa-file-pdf"></i></a></p>' ;





                 $userDetails      = "";
                 $userDetails     .= "<b>Name : </b>".$value['name']."<br>";
                 $userDetails     .= "<b>Mobile No : </b>".$value['mobilenumber']."<br>";
                 $userDetails     .= "<b>District Name : </b>".$value['distename']."<br>";
                $data[] = array(
                  
            //         "distename"         => $value['distename'],
            //         "name"              => $value['name'],
            //         "mobilenumber"      => $value['mobilenumber'],
            //         "billnumber"        => $value['billnumber'],
            //         "billamount"        => $value['billamount'],
            //         "shopname"          => $value['shopname'],
            //         "billdate"          => date("d-m-Y", strtotime($value['billdate'])),
            //  "order_by_column"          => $value['order_by_column'],
            //         "filepath"          =>  $action,
            //         "order_by_column"   => $value['order_by_column'],
            //         "message"           => $value['remarks'],
                    "distename"         => $userDetails,
                    "billnumber"        => $invoiceDetails,
                    // "billamount"        =>  $billAmount ,
                   
                    
                     "order_by_column"   => $order_id,
                    //  "remarks"           => $remarks_message,
                    
                    // "status"           => $value['remarks'],
                     "status"           => $status_message,
                     
                    
                     "invoicecopy"          =>  $file,

                   
                );

            }// Foreach Start
        }// for loop
         ## Response
         $response = array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithoutFilter,
            "iTotalDisplayRecords" => $totalRecordwithFilter,
            "aaData" => $data
        );

        echo json_encode($response);
        exit;
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

    public function AllDistrictsDisabledChecking()
    {
        // $csrf_check=$this->Etransfer->checkCSRF();

        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                throw new Exception('Forbidden','403');

            else
            {
                                @$district               = trim($_POST['district']);
                                @$selectCountValue               = trim($_POST['selectCountValue']);



                                $Basemodel = new Basemodel;
                                $billSelectionCountByLimitCount = $Basemodel->getBillSelectionCountByLimit();

                                $debug = array(
                                    "billSelectionCountByLimitCount" => $billSelectionCountByLimitCount,

                                );

                                if($billSelectionCountByLimitCount > 0){
                                    $billSelectionCountByLimitValue = $Basemodel->getBillSelectionSingleRecordByLimit();
                                    $selectCountValue = $billSelectionCountByLimitValue->selection_value;
                                    $yearmonth = $billSelectionCountByLimitValue->year_month;
                                    $seedValue = $billSelectionCountByLimitValue->seed_value;
                                    $message = "true";
                                    $dist = $district;
                                }
                                else{
                                    $selectCountValue = "";
                                    $yearmonth = "";
                                    $seedValue = '';
                                    $message = "false";
                                    $dist = $district;
                                }
                                $response = array(
                                    "message" => $message,
                                    "svalue" => $selectCountValue,
                                    "ym" => $yearmonth ,
                                    "sv" => $seedValue
                                    );
                                    echo json_encode($response);
                                   exit;

            }
        
        }
        catch (Exception $e) 
        {
            header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }
    }

    public function AllDistrictsDisabledCheckingVerified()
    {
        // $csrf_check=$this->Etransfer->checkCSRF();

        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                throw new Exception('Forbidden','403');

            else
            {
                                @$district               = trim($_POST['district']);
                                @$selectCountValue               = trim($_POST['selectCountValue']);



                                $Basemodel = new Basemodel;
                                $verifiedCount = $Basemodel->VerifiedCount($district);


                                $debug = array(
                                    "VerifiedCount" => $VerifiedCount,

                                );

                                if($verifiedCount > 0){
                                    $billSelectionCountByLimitValue = $Basemodel->getBillSelectionSingleRecordByLimit();
                                    $selectCountValue = $billSelectionCountByLimitValue->selection_value;
                                    $yearmonth = $billSelectionCountByLimitValue->year_month;
                                    $seedValue = $billSelectionCountByLimitValue->seed_value;
                                    $message = "true";
                                    $dist = $district;
                                    $count = $verifiedCount;
                                }
                                else{
                                    $selectCountValue = "";
                                    $yearmonth = "";
                                    $seedValue = '';
                                    $message = "false";
                                    $dist = $district;
                                    $verifiedCount = 0;
                                }
                                $response = array(
                                    "message" => $message,
                                    "svalue" => $selectCountValue,
                                    "ym" => $yearmonth ,
                                    "sv" => $seedValue,
                                    "totalCount" =>$verifiedCount
                                    );
                                    echo json_encode($response);
                                   exit;

            }
        
        }
        catch (Exception $e) 
        {
            header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }
    }
   
    public function ForwardToNextRole(){
        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                throw new Exception('Forbidden','403');

            else
            {
                    $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                    $bill_selection_id    = $_POST['bill_selection_id'];
                    $dc_name            = $_POST['dc_name'];
                    $remarks            = $_POST['remarks'];
                    $logged_in_userid   = $_SESSION['user']->userid;






                    $session_details    =   $this->Mybill->session_details();
                    $session_roleid     =   $session_details[0]->roletypecode;
                    $role_type_id       = $session_roleid;
                    $model = new Basemodel;
                    $forward_to_bill_selection = $model->forwardToBillSelectionADC(
                        $bill_selection_id,
                        $logged_in_userid,
                        $role_type_id,
                        $dc_name,
                        $remarks
                    
                    );
                                if($forward_to_bill_selection){
                                    $message = "true";
                                }
                                else{
                                    $message = "false";
                                }



                            $response = array(
                                "message" =>  $message,
                               
                                
                            );
                            echo json_encode($response);
                            exit;
                           

                           // throw new Exception('csrf error', '403');
            }
        
        }
        catch (Exception $e) 
        {
            header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }
    }
    public function RevertBackToBeforeRole(){
        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                throw new Exception('Forbidden','403');

            else
            {
                    $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                    $bill_selection_id    = $_POST['bill_selection_id'];
                    $dc_name            = $_POST['dc_name'];
                    $remarks            = $_POST['remarks'];
                    $logged_in_userid   = $_SESSION['user']->userid;
                    $session_details    =   $this->Mybill->session_details();
                    $session_roleid     =   $session_details[0]->roletypecode;
                    $role_type_id       = $session_roleid;
                    $model = new Basemodel;
                    $revert_back_to_bill_selection = $model->revertbackToBillSelection(
                        $bill_selection_id,
                        $logged_in_userid,
                        $role_type_id,
                        $dc_name,
                         $remarks
                    
                    );
                                if($revert_back_to_bill_selection){
                                    $message = "true";
                                }
                                else{
                                    $message = "false";
                                }



                            $response = array(
                                "message" =>  $message,
                               
                                
                            );
                            echo json_encode($response);
            }
        
        }
        catch (Exception $e) 
        {
            header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }
    }

 public function totalRecordsCheckingConfig(){
        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                throw new Exception('Forbidden','403');

            else
            {
                    $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                    $selectCountValue    = $_POST['selectCountValue'];
                    $district            = $_POST['district'];

                    $model = new Basemodel;
                    $forward_to_bill_selection = $model->totalRecordsCheckingConfigBaseModel(
                        $selectCountValue,
                        $district 
                    
                    );
                                if($forward_to_bill_selection){
                                    $message = "true";
                                }
                                else{
                                    $message = "false";
                                }



                            $response = array(
                                "message" =>  $message,
                               
                                
                            );
                            echo json_encode($response);
            }
        
        }
        catch (Exception $e) 
        {
            header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }
    }
    // Empty Table Checking
    public function EmptyTableCheckingToServer(){
        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                throw new Exception('Forbidden','403');

            else
            {
                    $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                    $district            = ($_POST['district']==false?"all":$_POST['district']);

                    
                    $session_details    =   $this->Mybill->session_details();
                    $session_roleid     =   $session_details[0]->roletypecode;
                    $role_type_id       = $session_roleid;

                    $model = new Basemodel;
                    $forward_to_bill_selection = $model->EmptyTableCheckingToModel($district,$role_type_id );

                   
                            if($forward_to_bill_selection > 0){
                                 
                                    $message = "true";
                                    $count = $forward_to_bill_selection;
                                    $district = $district;
                                    
                                }
                                else{
                                    $message = "false";
                                    $count = $forward_to_bill_selection ;
                                }
                                $response = array(
                                    "message" => $message,
                                    "count" => $count,
                                    "district" => $district
                                    );
                                    echo json_encode($response);
                                   exit;
            }
        
        }
        catch (Exception $e) 
        {
            header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }
    }




}
?>