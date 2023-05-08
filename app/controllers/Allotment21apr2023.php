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
        $uploadFolder = 'https://rtionline.tn.gov.in/ctax/gstweb/uploads/';

        $data = array();
        $keys = array_keys($fetchRecords);
        for($j = 0; $j < count($fetchRecords); $j++) { //forloop start
             $filePath = "";
            foreach ($fetchRecords[$keys[$j]] as $key => $value){  // Foreach Start
                $fileLocation = $uploadFolder.$value['filepath'];
                $verifyfilePathLength = substr($value['filepath'], 0, 40);
                 $action = '<a target="_blank" href="'.$fileLocation.'">'.$verifyfilePathLength.'</a>' ;
                $data[] = array(
                    "bill_selection_id" => $value['bill_selection_id'],
                    "distename"         => $value['distename'],
                    "name"              => $value['name'],
                    "mobilenumber"      => $value['mobilenumber'],
                    "billnumber"        => $value['billnumber'],
                    "billamount"        => $value['billamount'],
                    "shopname"          => $value['shopname'],
                    "billdate"          => date("d-m-Y", strtotime($value['billdate'])),
                    "filepath"          =>  $action

                   
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
        $totalRecordsWithoutFiltering =  $model->verifytotalRecordsWithOutFiltering($district,$role_type_id);
        $totalRecordwithoutFilter = $totalRecordsWithoutFiltering->bstablecount;
        $totalRecordsWithFiltering =  $model->verifytotalRecordsWithFiltering($searchQuery,$district,$role_type_id);
        $totalRecordwithFilter = $totalRecordsWithFiltering->allcount;
        $fetchRecords = $model->verifygetallotment_data($countValue,$district,$role_type_id,$searchQuery);
        $uploadFolder = 'https://rtionline.tn.gov.in/ctax/gstweb/uploads/';

        $data = array();
        $keys = array_keys($fetchRecords);
        for($j = 0; $j < count($fetchRecords); $j++) { //forloop start
             $filePath = "";
            foreach ($fetchRecords[$keys[$j]] as $key => $value){  // Foreach Start
                $fileLocation = $uploadFolder.$value['filepath'];
                $verifyfilePathLength = substr($value['filepath'], 0, 40);
                 $action = '<a target="_blank" href="'.$fileLocation.'">'.$verifyfilePathLength.'</a>' ;
                $data[] = array(
                    "bill_selection_id" => $value['bill_selection_id'],
                    "distename"         => $value['distename'],
                    "name"              => $value['name'],
                    "mobilenumber"      => $value['mobilenumber'],
                    "billnumber"        => $value['billnumber'],
                    "billamount"        => $value['billamount'],
                    "shopname"          => $value['shopname'],
                    "billdate"          => date("d-m-Y", strtotime($value['billdate'])),
                    "filepath"          =>  $action

                   
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