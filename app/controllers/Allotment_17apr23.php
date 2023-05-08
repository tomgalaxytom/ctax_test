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
                                    <button class="btn btn-success action-btn" data-action="forward"><i class="fa fa-thumbs-up" aria-hidden="true"></i> Forward </button> 
                                    <input type="hidden" name="action" id="action" />
                                    <input type="hidden" name="ids" id="ids" />
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
       ## Read value
       $draw = $_POST['draw'];
       $row = $_POST['start'];
       $rowperpage = $_POST['length']; // Rows display per page
       $columnIndex = $_POST['order'][0]['column']; // Column index
       $columnName = $_POST['columns'][$columnIndex]['data']; // Column name
       $columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
       $searchValue = $_POST['search']['value']; // Search value
       ## Search 
       $searchQuery = " ";
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

       //mu.name ilike '%".$searchValue."%'  or
      // bd.billnumber ilike '%".$searchValue."%'  or
      // bd.shopname ilike '%".$searchValue."%' 

      // bd.billamount::TEXT ilike '%".$searchValue."%'  or
        $countValue             = trim($_POST['select_count_value']);
        $str                    = trim($_POST['yearmonth']);
        $yearmonth              = substr($str, 2);
        $seedValue              = trim($_POST['seedValue']);
        $district               = trim($_POST['district']);
         $act         = trim($_POST['act']);
        if( $act == 'form-submit'){
            $model              =   new Basemodel;
            $datapf             = $model->getallotment_data_pf($countValue,$yearmonth,$seedValue,$district);
            
        }
        





        $session_details    =   $this->Mybill->session_details();
        $session_roleid     =   $session_details[0]->roletypecode;
        $role_type_id       = $session_roleid;
        $model              =   new Basemodel;
        $totalRecordsWithoutFiltering =  $model->totalRecordsWithOutFiltering($district,$role_type_id);
        $totalRecordwithoutFilter = $totalRecordsWithoutFiltering->bstablecount;
        $totalRecordsWithFiltering =  $model->totalRecordsWithFiltering($searchQuery,$district,$role_type_id);
        $totalRecordwithFilter = $totalRecordsWithFiltering->allcount;
        $fetchRecords = $model->getallotment_data($countValue,$district,$role_type_id,$searchQuery);
// echo '<pre>';
// print_r( $fetchRecords);


        $data = array();

        $keys = array_keys($fetchRecords);
        for($j = 0; $j < count($fetchRecords); $j++) { //forloop start
            foreach ($fetchRecords[$keys[$j]] as $key => $value){  // Foreach Start
                $data[] = array(
                    "bill_selection_id" => $value['bill_selection_id'],
                    "distename"         => $value['distename'],
                    "name"         => $value['name'],
                    "mobilenumber"      => $value['mobilenumber'],
                    "billnumber"        => $value['billnumber'],
                    "billamount"        => $value['billamount'],
                    "shopname"          => $value['shopname'],
                    "billdate"          => $value['billdate']
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



                                 $Basemodel = new Basemodel;
                                // $distCountbasedBsTbl = $Basemodel->getDistinctDistCodeCount();
                                // $bsTblCount     =  $distCountbasedBsTbl->count ;



                                // $distCountbasedConfigTbl = $Basemodel->getDistBasedConfigCount();
                                // $configTblCount     =  $distCountbasedConfigTbl->count ;


                               
                               
                                $billSelectionCountByLimitCount = $Basemodel->getBillSelectionCountByLimit();


                                

                                $debug = array(
                                    
                                    
                                    "billSelectionCountByLimitCount" => $billSelectionCountByLimitCount,
                                    

                                );

                                // echo '<pre>';
                                // print_r($debug);
                                // exit;

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
   
    public function ForwardToNextRole(){
        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                throw new Exception('Forbidden','403');

            else
            {
                    $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                    $bill_selection_id    = $_POST['bill_selection_id'];
                    $logged_in_userid   = $_SESSION['user']->userid;

                    $session_details    =   $this->Mybill->session_details();
                    $session_roleid     =   $session_details[0]->roletypecode;
                    $role_type_id       = $session_roleid;
                    
                    $model = new Basemodel;
                    $forward_to_bill_selection = $model->forwardToBillSelection(
                        $bill_selection_id,
                        $logged_in_userid,
                        $role_type_id
                    
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
    public function RevertBackToBeforeRole(){
        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                throw new Exception('Forbidden','403');

            else
            {
                    $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                    $bill_selection_id    = $_POST['bill_selection_id'];
                    $logged_in_userid   = $_SESSION['user']->userid;

                    $session_details    =   $this->Mybill->session_details();
                    $session_roleid     =   $session_details[0]->roletypecode;
                    $role_type_id       = $session_roleid;
                    
                    $model = new Basemodel;
                    $forward_to_bill_selection = $model->revertbackToBillSelection(
                        $bill_selection_id,
                        $logged_in_userid,
                        $role_type_id
                    
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