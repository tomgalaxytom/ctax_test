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
        $this->adc_roleid	=	'02';
        $this->jc_roleid	=	'03';
        $this->dc_roleid	=	'04';
        $this->ac_roleid	=	'05';
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
    public function FetchingAllotmentData()
    {
        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
            {
                throw new Exception('Forbidden','403');
            }
            else
            {
                // if($csrf_check==0)
                // {
                    $_POST              = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                    $isvalid            =   true;
                    $countValue         = trim($_POST['select_count_value']);
                    $str                = trim($_POST['yearmonth']);
                    $yearmonth          = substr($str, 2);
                    $seedValue          = trim($_POST['seedValue']);
                    $district           = trim($_POST['district']);
                    $session_details    =   $this->Mybill->session_details();
                    $session_roleid     =   $session_details[0]->roletypecode;
                    $role_type_id       = $session_roleid;
                    $status_flag = array(
                        'Y' => 'Active',
                        'N' => 'InActive'
                    );
                    // $data = $Basemodel->getMultipleJoin($select, $data, $del, $id);

                    $Basemodel  =   new Basemodel;
                    $datapf = $Basemodel->getallotment_data_pf($countValue,$yearmonth,$seedValue,$district);


                    $data = $Basemodel->getallotment_data($countValue,$district,$role_type_id);
                    $count = count($data);
                    http_response_code(200);
                    if($count > 0)
                    {


                        if( $role_type_id  == '02'){

                            echo '

                            <div class="row">
                            <div class="col-md-2" style="display:none">
                            <label class=""></label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <button class="btn btn-danger"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Revert Back</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                            
                            </div>
                            <div class="col-md-2">
                            <label class=""></label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <button class="btn btn-success"  onclick="forward_to_jc_one("03")"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Forward </button> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class=" col-form-label required" style="padding-top:0px !important;padding-bottom:0px !important;">Role Name</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <select class="form-select" name="roleid" id="roleid" onchange="forwardConfirmationOpen()">
                                            <option value="">-- Select Roles --</option>
                                    
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
    
        <br>';

                        }
                        elseif($role_type_id  == '03'){

                            echo '

                            <div class="row">
                            <div class="col-md-2">
                            <label class=""></label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <button class="btn btn-danger"><i class="fa fa-thumbs-down" aria-hidden="true"></i> Revert Back</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                            
                            </div>
                            <div class="col-md-2">
                            <label class=""></label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                    <button class="btn btn-success"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Forward </button> 
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <label class=" col-form-label required" style="padding-top:0px !important;padding-bottom:0px !important;">Role Name</label>
                                <div class="form-group row">
                                    <div class="col-sm-12">
                                        <select class="form-select" name="roleid" id="roleid" onchange="forwardConfirmationOpen()">
                                            <option value="">-- Select Roles --</option>
                                    
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
    
    
        <br>';

                        }





                        ?>
                        <div class="table-responsive">
                            <table id="datatables-basic" class="table table-bordered datatables-basic " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>District Name</th>
                                        <th>User Name </th>
                                        <th>Mobile Number</th>
                                        <th>Invoice Number</th>
                                        <th>Amount</th>
                                        <th>Shop Name</th>
                                        <th>Bill Purchase Date</th>
                                       
                                        
                                    </tr>
                                </thead>
                                <tbody><?php 
                                $i = 1;
                                if($district == 'all'){
                                    $keys = array_keys($data);
                                    for($j = 0; $j < count($data); $j++) {
                                        foreach ($data[$keys[$j]] as $key => $value) 
                                        { 
                                            ?> 
                                            <tr>
                                                <td><?php echo htmlentities($i); ?></td>
                                                <td><?= htmlspecialchars($value['distename']); ?></td>
                                                <td><?= htmlspecialchars($value['name']); ?></td>
                                                <td><?= htmlspecialchars($value['mobilenumber']); ?></td>
                                                <td><?= htmlspecialchars($value['billnumber']); ?></td>
                                                <td><?= htmlspecialchars($value['billamount']); ?></td>
                                                <td><?= htmlspecialchars($value['shopname']); ?></td>
                                                <td><?= htmlspecialchars($value['billdate']); ?></td>
                                            </tr><?php 
                                            $i++;
                                        }
                                    }

                                }
                                else{
                                    foreach ($data as $key => $value) 
                                    { 
                                        ?> 
                                        <tr>
                                            <td><?php echo htmlentities($i); ?></td>
                                            <td><?= htmlspecialchars($value['distename']); ?></td>
                                            <td><?= htmlspecialchars($value['name']); ?></td>
                                            <td><?= htmlspecialchars($value['mobilenumber']); ?></td>
                                            <td><?= htmlspecialchars($value['billnumber']); ?></td>
                                            <td><?= htmlspecialchars($value['billamount']); ?></td>
                                            <td><?= htmlspecialchars($value['shopname']); ?></td>
                                            <td><?= htmlspecialchars($value['billdate']); ?></td>
                                        </tr><?php 
                                        $i++;
                                    }
                                }
                                        

                                    ?>
                                </tbody>
                            </table>
                        </div><?php
                    }
                    else
                    {?>
                        <br><center> No Data Available </center><?php
                    }    
                // }
                // else
                //     throw new Exception('csrf error', '403');
        
            }
        
        }
        catch (Exception $e) 
        {
            header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
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
        sleep(5);
        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
            {
                throw new Exception('Forbidden','403');
            }
            else
            {
                // if($csrf_check==0)
                // {
                    $_POST              = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                    $isvalid            =   true;
                    $countValue         = trim($_POST['select_count_value']);
                    $str                = trim($_POST['yearmonth']);
                    $yearmonth          = substr($str, 2);
                    $seedValue          = trim($_POST['seedValue']);
                    $district           = trim($_POST['district']);
                    $session_details    =   $this->Mybill->session_details();
                    $session_roleid     =   $session_details[0]->roletypecode;
                    $role_type_id       = $session_roleid;
                    $status_flag = array(
                        'Y' => 'Active',
                        'N' => 'InActive'
                    );
                    // $data = $Basemodel->getMultipleJoin($select, $data, $del, $id);

                    $Basemodel  =   new Basemodel;
                   
                    $data = $Basemodel->getallotment_data($countValue,$district,$role_type_id);
                    
                    http_response_code(200);
                    if($data)
                    {
                       
                        if( $role_type_id  == '02'){

                            echo '

                            <div class="row">
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
                                            <button class="btn btn-success adc_btn"  onclick="forward_to_jc_one()"><i class="fa fa-thumbs-up" aria-hidden="true"></i> 
                                                 Forward 
                                            </button> 
                                        </div>
                                    </div>
                            </div>
                            
                        </div>
    
        <br>';

                        }
                        elseif($role_type_id  == '03'){

                            echo '

                            <div class="row">
                            <div class="col-md-2">
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
                                    <button class="btn btn-success"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Forward </button> 
                                    </div>
                                </div>
                            </div>
                            
                        </div>
    
    
        <br>';

                        }


                       
                        ?>

                    
                        <div class="table-responsive">
                            <table id="datatables-basic" class="table table-bordered datatables-basic " style="width:100%">
                            <div class="overlay"></div>
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                        <th>District Name</th>
                                        <th>User Name </th>
                                        <th>Mobile Number</th>
                                        <th>Invoice Number</th>
                                        <th>Amount</th>
                                        <th>Shop Name</th>
                                        <th>Bill Purchase Date</th>
                                       
                                        
                                    </tr>
                                </thead>
                                <tbody><?php 
                                $i = 1;
                                if($district == 'all'){
                                    $keys = array_keys($data);
                                    for($j = 0; $j < count($data); $j++) {
                                        foreach ($data[$keys[$j]] as $key => $value) 
                                        { 
                                            ?> 
                                            <tr>
                                                <td><?php echo htmlentities($i); ?></td>
                                                <td><?= htmlspecialchars($value['distename']); ?></td>
                                                <td><?= htmlspecialchars($value['name']); ?></td>
                                                <td><?= htmlspecialchars($value['mobilenumber']); ?></td>
                                                <td><?= htmlspecialchars($value['billnumber']); ?></td>
                                                <td><?= htmlspecialchars($value['billamount']); ?></td>
                                                <td><?= htmlspecialchars($value['shopname']); ?></td>
                                                <td><?= htmlspecialchars($value['billdate']); ?></td>
                                            </tr><?php 
                                            $i++;
                                        }
                                    }

                                }
                                else{
                                    foreach ($data as $key => $value) 
                                    { 
                                        ?> 
                                        <tr>
                                            <td><?php echo htmlentities($i); ?></td>
                                            <td><?= htmlspecialchars($value['distename']); ?></td>
                                            <td><?= htmlspecialchars($value['name']); ?></td>
                                            <td><?= htmlspecialchars($value['mobilenumber']); ?></td>
                                            <td><?= htmlspecialchars($value['billnumber']); ?></td>
                                            <td><?= htmlspecialchars($value['billamount']); ?></td>
                                            <td><?= htmlspecialchars($value['shopname']); ?></td>
                                            <td><?= htmlspecialchars($value['billdate']); ?></td>
                                        </tr><?php 
                                        $i++;
                                    }
                                }
                                        

                                    ?>
                                </tbody>
                            </table>
                        </div><?php
                    }
                    else
                    {?>
                        <br><center id="king"> No Data Available </center>
                        
                        <br><div id='noRecords'><center>  </center></div>
                        <?php
                    }    
                // }
                // else
                //     throw new Exception('csrf error', '403');
        
            }
        
        }
        catch (Exception $e) 
        {
            header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
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

    public function AllDistrictsDisabledChecking()
    {
        // $csrf_check=$this->Etransfer->checkCSRF();

        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                throw new Exception('Forbidden','403');

            else
            {

                                $Basemodel = new Basemodel;
                                $distCountbasedBsTbl = $Basemodel->getDistinctDistCodeCount();
                                $bsTblCount     =  $distCountbasedBsTbl->count ;



                                $distCountbasedConfigTbl = $Basemodel->getDistBasedConfigCount();
                                $configTblCount     =  $distCountbasedConfigTbl->count ;


                               
                               
                                $billSelectionCountByLimitCount = $Basemodel->getBillSelectionCountByLimit();


                                $billSelectionCountByLimitValue = $Basemodel->getBillSelectionSingleRecordByLimit();

                                $debug = array(
                                    "bsTblCount" => $bsTblCount,
                                    "configTblCount" => $configTblCount,
                                    "billSelectionCountByLimitCount" => $billSelectionCountByLimitCount,
                                    "billSelectionCountByLimitValue"  => $billSelectionCountByLimitValue

                                );
                                    // echo '<pre>';
                                    // print_R($debug);
                                    // exit;

                              



                            if($billSelectionCountByLimitCount > 0){ // $billSelectionCountByLimitCount if start 
                                $selectCountValue =  $billSelectionCountByLimitValue->selection_value;
                                $yearmonth =  $billSelectionCountByLimitValue->year_month;
                                $seedValue =  $billSelectionCountByLimitValue->seed_value;

                                if($bsTblCount > 0){ // $bsTblCount if start 
                                    if($bsTblCount == $configTblCount){
                                        $message = "true";
                                    }
                                    else{
                                        $message = "false";
                                    }

                                } // $bsTblCount if end 



                            } // $billSelectionCountByLimitCount if end  
                            else{ // $billSelectionCountByLimitCount else start 
                                $message = "false";
                                $selectCountValue = "";
                                $yearmonth  = "";
                                $seedValue = '';
                                $bsTblCount = '' ;

                            }// $billSelectionCountByLimitCount else end 


                            $response = array(
                                "message" =>  $message,
                                "svalue" => $selectCountValue,
                                "ym" => $yearmonth ,
                                "sv" => $seedValue,
                                "bscount" => $bsTblCount
                                
                            );
                            echo json_encode($response);
                           

                            // if($data)
                            // {
                            //     foreach ($data as $value) 
                            //     {
                            //         $menunames[] = $value['key'];
                            //     }
                            //     http_response_code(200);
                            //     echo json_encode($menunames);
                            // }
                            // else    throw new Exception('id not present', '404');
                       
                    
                // }
                // else
                //     throw new Exception('csrf error', '403');
            }
        
        }
        catch (Exception $e) 
        {
            header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }
    }
    public function get_rolename_basedon_usertype()
    {
        // $csrf_check=$this->Etransfer->checkCSRF();

        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                throw new Exception('Forbidden','403');

            else
            {
                // if($csrf_check==0)
                // {
                    $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);

                    $isvalid    =   true;

                    $user_type    = $_POST['user_type'];

                    // $user_type            =   $this->Etransfer->killChars(trim(htmlentities($_POST['user_type'])));

                    // if($this->Etransfer->is_int($user_type)!=1) $isvalid=false;

                    if(!($isvalid))
                        throw new Exception('Extra Characters','413');
                    else
                    {
                        $Basemodel = new Basemodel;
                        $Basemodel->tablename = "mybillmyright.mst_role";
                        if(!( (empty($user_type)) ))
                        {
                            $get_data   =   $Basemodel->getMultipleData(array('usertypecode' => $_POST['user_type']), 'rolesname');
                           
                            if($get_data!=null)
                            {
                                http_response_code(200);
                                foreach ($get_data as $value) 
                                { 
                                    $role_data[] = array(
                                        "roleid" =>$value->roletypecode,
                                    // "roleid" => $this->Etransfer->encryption($value->roleid,$this->Etransfer->key),
                                        "rolelname" => $value->rolesname,
                                    );
                                }
                                echo json_encode($role_data);
                            }
                            else    throw new Exception('id not present', '404');
                        }
                        else
                            throw new Exception('Not Accessible (mantatory fields is Empty)', '406'); 
                    }
                // }
                // else
                //     throw new Exception('csrf error', '403');
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
                    $role_type_id    = $_POST['role_type_id'];

                                $Basemodel = new Basemodel;
                                $update_role_id_change = $Basemodel->updateRoleIdChange($role_type_id);
                                if($update_role_id_change){
                                    $message = "true";
                                }
                                else{
                                    $message = "false";
                                }



                            $response = array(
                                "message" =>  $message,
                               
                                
                            );
                            echo json_encode($response);
                           

                            // if($data)
                            // {
                            //     foreach ($data as $value) 
                            //     {
                            //         $menunames[] = $value['key'];
                            //     }
                            //     http_response_code(200);
                            //     echo json_encode($menunames);
                            // }
                            // else    throw new Exception('id not present', '404');
                       
                    
                // }
                // else
                //     throw new Exception('csrf error', '403');
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