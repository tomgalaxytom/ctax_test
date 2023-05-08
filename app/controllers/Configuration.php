<?php

class Configuration extends Controller
{

    public function __construct()
    {

        $this->Mybill = $this->controller('Mybill');
        $this->Basemodel = $this->model('Basemodel');
        $this->User = $this->controller('User');
        $this->active_menu='';
        if (!isset($_SESSION['user'])) 
        {
           
            header("Location: " . URLROOT . "");
        }

       
        if (isset($_SESSION['charge']['id'])) 
        {
            // if(!($_SESSION['user']->roletypecode =='06'))
            // {
                $Basemodel = new Basemodel;
                $Basemodel->role_permission($_SESSION['charge']['id']);
            //}
           
        } 

    }
    public function getting_state_code_basedon_scheme(Type $var = null)
    {
        try 
        {
            if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) 
            {
                throw new Exception('Forbidden', '403');
            } 
            else 
            {
                // if($csrf_check==0)
                // {
                    $isvalid    =   true;
                    $schemecode   =   $_POST['schemecode'];
                  

                    // if($this->is_int($user_id)!=1) $isvalid=false;

                    // if(!($isvalid))
                    //     throw new Exception('Extra Characters','413');
                    // else
                    // {

                        $Basemodel = new Basemodel;
                        $Basemodel->tablename = "mybillmyright.mst_scheme";
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                        $where_data = array(
                            "schemecode" => $schemecode,
                        );
                        $data =   $Basemodel->getMultipleData($where_data,'schemecode');

                        if ($data) 
                        {
                            http_response_code(200);
                            echo json_encode($data);
                        } 
                        else
                            throw new Exception('Bad Request', '400');
                    //}                                                         
                    // }
                    // else
                    //     throw new Exception('csrf error', '403');
            }
        } 
        catch (Exception $e) {
            header('HTTP/1.1 ' . $e->getCode() . ' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }
        
    }


    
    public function insert_update_config()
    {

        // $csrf_check=$this->Etransfer->checkCSRF();

        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
            {
                throw new Exception('Forbidden','403');
            }
            else
            {

                // print_r($_POST);
              
                              // else $nodal = 'N';
                // if ($_POST['lottexecutor_status'] == 'yes_lottexecutor') $lott_executor = 'Y';
                // else $lott_executor = 'N';
                // if($csrf_check==0)
                // {
                    $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                    $valid    =   true;



                    // if(isset($_POST['sel_office']))
                    //     $office_code    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_office'])));
                    // else
                    //     $office_code= $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->office_code)));

                    $session_details    =   $this->Mybill->session_details();
                    $session_roletypecode            =   $session_details[0]->roletypecode;
                    $session_state_code     =   $session_details[0]->statecode;
                    $session_userid            =   $session_details[0]->userid;


                    if($session_roletypecode == '01')
                        $schemecode =   trim(htmlentities($_POST["scheme_code"]));
                    // else
                    //     $schemecode            =   $session_details[0]->roletypecode;
                   
                    $distcode =   trim(htmlentities($_POST["dist_code"]));
                    $minimumbillamt     =   trim(htmlentities($_POST["min_amt"]));
                    $prizeamount =   trim(htmlentities($_POST["prize_amt"]));
                    $finyear =   trim(htmlentities($_POST["fin_year"]));
                    $finmonth =   trim(htmlentities($_POST["fin_month"]));
                    $allotmentby =   trim(htmlentities($_POST["allotmenttype"]));
                    $billselectioncount =   trim(htmlentities($_POST["bill_selection_count"]));

                    

                    if($allotmentby=='D')
                    {
                        $billdrawdate=$this->Mybill->change_date_time_to_database_format($_POST['bill_drawn_date'],'');
                        $allotmentdoneby    =   trim(htmlentities($_POST["bill_drawn_by"]));

                    }
                    if($allotmentby=='S')
                    {
                        $allotmentdoneby    =   trim(htmlentities($_POST["state_userid"]));
                    }

                    $schemecode	=	trim(htmlentities($_POST["scheme_code"]));
                    

                    $action =   trim(htmlentities($_POST["action"]));
                  
                    

                    $billentrystartdate=$this->Mybill->change_date_time_to_database_format($_POST['bill_entry_start_date'],'');
                    $billentryenddate=$this->Mybill->change_date_time_to_database_format($_POST['bill_entry_end_date'],'');
                    $billpurchasestartdate=$this->Mybill->change_date_time_to_database_format($_POST['bill_purchase_start_date'],'');
                    $billpurchaseenddate=$this->Mybill->change_date_time_to_database_format($_POST['bill_purchase_end_date'],'');




                    // $session_usertype_id     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->usertype_id)));
                    // $session_dist_code     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->dist_code)));
                    // $session_hud_code     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->hud_code)));

                    // $state_code     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->state_code)));
                    // $emp_gpfno      =   $this->Etransfer->killChars(trim(htmlentities($_POST['gpf_no'])));
                    // $suffix_code    =   $this->Etransfer->killChars(trim(htmlentities($_POST['suffix'])));
                    // $mobilenumber   =   $this->Etransfer->killChars(trim(htmlentities($_POST['mob_no'])));
                    // $emp_name       =   $this->Etransfer->killChars(trim(htmlentities($_POST['emp_name'])));
                    // $email          =   $this->Etransfer->killChars(trim(htmlentities($_POST['email'])));
                    // $user_type      =   $this->Etransfer->killChars(trim(htmlentities($_POST['user_type'])));
                    // $dob    =   $this->Etransfer->change_date_time_to_database_format(trim(htmlentities($_POST['dob'])),'');

                    // if(isset($_POST['sel_dist']))
                    //     $dist_code    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_dist'])));
                    // else
                    //     $dist_code= $session_dist_code;


                    // if(isset($_POST['sel_hud']))
                    //     $hud_code    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_hud'])));
                    // else 
                    //     $hud_code= $session_hud_code;

                    // $inst_id    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_inst'])));


                    // if($this->Etransfer->has_only_letters($suffix_code,'2','Y')!=1)$valid=false;
                    // if($this->Etransfer->has_only_letters($emp_name,'50','Y')!=1)$valid=false;

                    // if($this->Etransfer->is_int($office_code)!=1) $isvalid=false;
                    // if($this->Etransfer->is_int($state_code)!=1) $isvalid=false;
                    // if($this->Etransfer->is_int($emp_gpfno)!=1) $isvalid=false;
                    // if($this->Etransfer->is_int($mobilenumber)!=1) $isvalid=false;
                    // if($this->Etransfer->is_int($user_type)!=1) $isvalid=false;

                    // if($this->Etransfer->validateDate($dob)!=1) $isvalid=false;
                    // if($this->Etransfer->validateEmail($email)!=1) $isvalid=false;

                


                    if(!($valid))
                        throw new Exception('Extra Characters','413');
                    else
                    {
                        if(!( (empty($schemecode)) || (empty($distcode)) || (empty($prizeamount)) || (empty($finyear))  || (empty($finmonth)) || (empty($billentrystartdate)) || (empty($billentryenddate)) || (empty($billpurchasestartdate)) || (empty($billpurchaseenddate))))
                        {
                            
                            $Basemodel = new Basemodel;
                            $Basemodel->tablename = "mybillmyright.mst_config";

                            $max_code = $Basemodel->get_maxid('configcode');
                            if ($max_code == 0)
                                $config_code = '01';
                            else
                                $config_code = $max_code + 1;

                            $data = array(
                                'schemecode'      => $schemecode,
                                'statecode'      => $session_state_code,
                                'distcode'       => $distcode,
                                'minimumbillamt'=>  $minimumbillamt,
                                'prizeamount'     => $prizeamount,
                                'finyear'       => $finyear,
                                'finmonth'           => $finmonth,
                                'billentrystartdate'        => $billentrystartdate, 
                                'billentryenddate'        => $billentryenddate, 
                                'billpurchasestartdate'        => $billpurchasestartdate, 
                                'billpurchaseenddate'        => $billpurchaseenddate, 
                                'bill_selection_count'         =>  $billselectioncount,
                                'allotmentby'       =>  $allotmentby
                            );
                            if($allotmentby=='D')
                            {
                                $data['billdrawdate']=$billdrawdate;
                                $data['allotmentdoneby']    =   $allotmentdoneby;
        
                            }

                            


                            $check = array(
                                'schemecode' => htmlentities($schemecode),
                                'statecode'      => $session_state_code,
                                'distcode'       => $distcode,
                                'finyear'       => $finyear,
                                'finmonth'           => $finmonth,
                            );
                            $exists = $Basemodel->getSingleData($check);

                            if ($action == 'insert') 
                            {

                                $data['configcode']=$config_code;
                                $data['createdby']=$session_userid;
                                $data['createdon']='now()';

                                if ($exists == '') //If not exists.. insert into table
                                {
                                   
                                    if($Basemodel->insert($data))
                                        throw new Exception('Sucess', '200'); 
                                    else
                                        throw new Exception('Bad Request', '400'); 
                                } 
                                else throw new Exception('exists', '409');    
                                                            
                            }
                            else if ($action == 'update') 
                            {
                                $id =   trim(htmlentities($_POST["configid"]));
                                $data['updatedby']=$session_userid;
                                $data['updatedon']='now()';

                                $check_id   =   array("configid"=>$id);
                                $check_update_id_present_in_table   =   $Basemodel->getSingleData($check_id);
                                if($check_update_id_present_in_table!=null)
                                {
                                    $exists = $Basemodel->getSingleData($check);

                                    if ((($exists) && ($id == $exists->configid)) || (!$exists))
                                    {
                                        $where = array(
                                            'configid' => $id
                                        );
                                        $updaterow = $Basemodel->update($data, $where);
                                        if($updaterow==true)
                                            throw new Exception('Success Update', '200');
                                        else
                                            throw new Exception('Bad Request', '400');
                                    } 
                                    else
                                        throw new Exception('exists', '409');
                                }
                            }
                            else    throw new Exception('Bad Request', '400');
                                
                        }
                        else
                            throw new Exception('Not Accessible (mantatory fields is Empty)', '406'); 
                    }

        
            }
        
            
        
        }
        catch (Exception $e) 
        {
            header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }            
    }



    public function config_data()
    {
        $Basemodel = new Basemodel;
        $Basemodel->tablename = "mybillmyright.mst_config";
        $del = array(

        );
        $select = "mybillmyright.mst_scheme.schemesname,mybillmyright.mst_district.distename,mybillmyright.mst_config.minimumbillamt,
        mybillmyright.mst_config.billentrystartdate, mybillmyright.mst_config.billentryenddate,
                                mybillmyright.mst_config.billpurchasestartdate, mybillmyright.mst_config.billpurchaseenddate,
                                mybillmyright.mst_config.finyear, mybillmyright.mst_config.configid,mybillmyright.mst_config.finmonth";
        $data_verifer = array(
            'mybillmyright.mst_scheme' => "mybillmyright.mst_scheme.schemecode = mybillmyright.mst_config.schemecode",
            'mybillmyright.mst_district' => "mybillmyright.mst_district.distcode = mybillmyright.mst_config.distcode",

        );
        $id = 'createdon';
        $alias = 'mybillmyright.mst_config';
        $month_name = array(
            '01' => 'January',
            '02' => 'February',
            '03' => 'March',
            '04' => 'April',
            '05' => 'May',
            '06' => 'June',
            '07' => 'July',
            '08' => 'August',
            '09' => 'Septmeber',
            '10' => 'October',
            '11' => 'November',
            '12' => 'December',
        );

        $order_by = 'DESC';
        $data = $Basemodel->getMultipleJoin_query($select, $data_verifer, $del, $id, $alias, $order_by);
        
        $count = 0;

        if ($data == null) 
        {
            echo 0;
        } 
        else 
        { ?>
            <div class="table-responsive">
                <table id="datatables-basic" class="table table-bordered datatables-basic" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width:5%">S.No</th>
                            <th style="width:10%">Scheme Name</th>
                            <th style="width:10%">District Name</th>
                            <th style="width:10%">Minimum Amt</th>

                            <th style="width:5%">Bill Entry Start</th>
                            <th style="width:5%">Bill Entry End</th>
                            <th style="width:10%">Bill Purchase Start</th>
                            <th style="width:10%">Bill Purchase End</th>
                            <th style="width:15%">Financial Month</th>
                            <th style="width:15%">Financial Year</th>
                            <th style="width:30%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;

                        foreach ($data as $value) {
                           
                        ?>
                            <tr>
                                <td style="text-align:right"><?php echo htmlentities($i); ?></td>
                                <td><?= htmlspecialchars($value->schemesname)  ?></td>
                                <td><?= htmlspecialchars($value->distename); ?></td>
                                <td><?= htmlspecialchars($value->minimumbillamt); ?></td>
                                
                                <td><?= htmlspecialchars(date("d-m-Y", strtotime($value->billentrystartdate))); ?></td>
                                <td><?= htmlspecialchars(date("d-m-Y", strtotime($value->billentryenddate))); ?></td>
                                <td><?= htmlspecialchars(date("d-m-Y", strtotime($value->billpurchasestartdate))); ?></td>
                                <td><?= htmlspecialchars(date("d-m-Y", strtotime($value->billpurchaseenddate))); ?></td>

                                <td><?= htmlspecialchars($value->finyear); ?></td>

                                <td><?= htmlspecialchars($month_name[$value->finmonth]); ?></td>
                              
                                <td>
                                     <a name="edit_config" class="edit_config" id=<?php echo htmlentities($value->configid); ?>><i class="fa fa-pencil  editicon"  aria-hidden="true"></i></a>
                                </td>
                              
                            </tr>
                        <?php  $i++;
                        } ?>
                    </tbody>
                </table>
            </div><?php
        }
    }


    public function edit_bill()
    {
        $id = $_POST['id'];
        $Basemodel = new Basemodel;
        $Basemodel->tablename = "mybillmyright.mst_config";
    
            $updatebill = $Basemodel->getSingleData(array(
                "configid" => $id
            ));
            if (!$updatebill) {
                header("Location: " . URLROOT . "Pages");
            }
            echo json_encode($updatebill);
        
    }

    public function get_username_basedon_allotmenttype()
    {
        # code...
        try 
        {
            if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) 
            {
                throw new Exception('Forbidden', '403');
            } 
            else 
            {
                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                // if($csrf_check==0)
                // {
                    $isvalid    =   true;
                    $allotmenttype   =   $_POST['allotment_type'];
                    $distcode   =   $_POST['distcode'];

                    if($allotmenttype   ==  'S')
                    {
                        $where_condition = array(
                            "roletypecode" => '02',
                        );
                    }
                    else if($allotmenttype   ==  'D')
                    {
                        $where_condition = array(
                            'distcode'      =>  $distcode,
                            "roletypecode"  => '03',
                        );
                    }
                  

                    // if($this->is_int($user_id)!=1) $isvalid=false;

                    // if(!($isvalid))
                    //     throw new Exception('Extra Characters','413');
                    // else
                    // {


                        $Basemodel = new Basemodel;
                        $Basemodel->tablename = "mybillmyright.mst_dept_user";
                 
                        $select = "mybillmyright.mst_dept_user.userid,mybillmyright.mst_dept_user.name,
                            mybillmyright.mst_roletype.roletypelname";
                        
                        $data_verifer = array(
                            'mybillmyright.mst_roletype' => "mybillmyright.mst_roletype.roletypecode = mybillmyright.mst_dept_user.roletypecode",
                        );

                        $id = 'createdon';
                        $alias = 'mybillmyright.mst_dept_user';
                       
                        $order_by = 'DESC';
                        $data = $Basemodel->getMultipleJoin_query($select, $data_verifer, $where_condition, $id, $alias, $order_by);

                     

                       

                        if ($data) 
                        {
                            http_response_code(200);
                            echo json_encode($data);
                        } 
                        else
                            throw new Exception('Bad Request', '400');
                    //}                                                         
                    // }
                    // else
                    //     throw new Exception('csrf error', '403');
            }
        } 
        catch (Exception $e) {
            header('HTTP/1.1 ' . $e->getCode() . ' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }

        
    }

    ################################ settings function - Start ###############################

        public function gettingusernames_basedon_division()
        {
            try 
            {
                if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) 
                    throw new Exception('Forbidden', '403');
                else 
                {
                    // if($csrf_check==0)
                    // {
                        $isvalid    =   true;
                        $distcode   =   $_POST['distcode'];
                    

                        // if($this->is_int($user_id)!=1) $isvalid=false;

                        // if(!($isvalid))
                        //     throw new Exception('Extra Characters','413');
                        // else
                        // {

                            // $Basemodel = new Basemodel;
                            // $Basemodel->tablename = "mybillmyright.mst_dept_user";
                            // $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                            // $where_data = array(
                            //     "divisioncode" => $divisioncode,
                            //     "roletypecode"  =>  '03'
                            // );
                            // $data =   $Basemodel->getMultipleData($where_data,'divisioncode');

                        

                            $Basemodel = new Basemodel;
                            $Basemodel->tablename = "mybillmyright.mst_user_charge";
                                    
                            $select = "mybillmyright.mst_dept_user.userid,mybillmyright.mst_dept_user.name";
                            $data=  array(
                                'mybillmyright.mst_dept_user' => "mybillmyright.mst_dept_user.userid = mybillmyright.mst_user_charge.userid",  
                            );
                            $alias = 'mybillmyright.mst_dept_user';
                            $id = 'userid';
                            $where_alias='mybillmyright.mst_dept_user';
                            $order_by = 'ASC';
                            $del = array(
                                'distcode'  =>  $distcode,
                                'roletypecode'   =>  '03'
                            );
                            $distinct_name='mybillmyright.mst_user_charge.userid';
                            $data = ($Basemodel->getMultipleJoin_distinctdata_alias($select, $data, $del, $id, $distinct_name, $where_alias, $alias,$order_by));
                            if ($data) 
                            {
                                http_response_code(200);
                                echo trim(json_encode($data));
                            } 
                            else
                                throw new Exception('Bad Request', '400');
                        //}                                                         
                        // }
                        // else
                        //     throw new Exception('csrf error', '403');
                }
            } 
            catch (Exception $e) {
                header('HTTP/1.1 ' . $e->getCode() . ' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }
        }

        public function update_nodal_person()
        {        
            try 
            {
                if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                {
                    throw new Exception('Forbidden','403');
                }
                else
                {
                
                    // if ($_POST['nodal_status'] == 'yes_nodal') $nodal = 'Y';
                    // else $nodal = 'N';
                    // if ($_POST['lottexecutor_status'] == 'yes_lottexecutor') $lott_executor = 'Y';
                    // else $lott_executor = 'N';
                    // if($csrf_check==0)
                    // {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                        $valid    =   true;

                        // if(isset($_POST['sel_office']))
                        //     $office_code    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_office'])));
                        // else
                        //     $office_code= $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->office_code)));

                        $session_details    =   $this->Mybill->session_details();
                        $session_roletypecode            =   $session_details[0]->roletypecode;
                        $session_state_code     =   $session_details[0]->statecode;
                        $session_userid            =   $session_details[0]->userid;


                    
                        $distcode   =   trim(htmlentities($_POST["sel_dist"]));
                        $userid         =   trim(htmlentities($_POST["userid"]));
                        $yesno          =   trim(htmlentities($_POST["yesno"]));

                        $action =   trim(htmlentities($_POST["action"]));
                    
            
                        // $session_usertype_id     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->usertype_id)));
                        // $session_dist_code     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->dist_code)));
                        // $session_hud_code     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->hud_code)));

                        // $state_code     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->state_code)));
                        // $emp_gpfno      =   $this->Etransfer->killChars(trim(htmlentities($_POST['gpf_no'])));
                        // $suffix_code    =   $this->Etransfer->killChars(trim(htmlentities($_POST['suffix'])));
                        // $mobilenumber   =   $this->Etransfer->killChars(trim(htmlentities($_POST['mob_no'])));
                        // $emp_name       =   $this->Etransfer->killChars(trim(htmlentities($_POST['emp_name'])));
                        // $email          =   $this->Etransfer->killChars(trim(htmlentities($_POST['email'])));
                        // $user_type      =   $this->Etransfer->killChars(trim(htmlentities($_POST['user_type'])));
                        // $dob    =   $this->Etransfer->change_date_time_to_database_format(trim(htmlentities($_POST['dob'])),'');

                        // if(isset($_POST['sel_dist']))
                        //     $dist_code    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_dist'])));
                        // else
                        //     $dist_code= $session_dist_code;


                        // if(isset($_POST['sel_hud']))
                        //     $hud_code    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_hud'])));
                        // else 
                        //     $hud_code= $session_hud_code;

                        // $inst_id    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_inst'])));


                        // if($this->Etransfer->has_only_letters($suffix_code,'2','Y')!=1)$valid=false;
                        // if($this->Etransfer->has_only_letters($emp_name,'50','Y')!=1)$valid=false;

                        // if($this->Etransfer->is_int($office_code)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($state_code)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($emp_gpfno)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($mobilenumber)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($user_type)!=1) $isvalid=false;

                        // if($this->Etransfer->validateDate($dob)!=1) $isvalid=false;
                        // if($this->Etransfer->validateEmail($email)!=1) $isvalid=false;



                        if(!($valid))
                            throw new Exception('Extra Characters','413');
                        else
                        {
                            if(!( (empty($distcode)) || (empty($userid)) || (empty($yesno)) ))
                            {
                                
                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.mst_dept_user";

                                $data = array(
                                    'nodal'      => $yesno   
                                );

                                $check = array(
                                    'divisioncode'  => htmlentities($distcode),
                                    'nodal'         => 'Y',
                                );
                                $exists = $Basemodel->getSingleData($check);

                                if ($action == 'update') 
                                {
                                    $id =   trim(htmlentities($userid));
                                    $data['updatedby']=$session_userid;
                                    $data['updatedon']='now()';

                                    $check_id   =   array("userid"=>$id);
                                    $check_update_id_present_in_table   =   $Basemodel->getSingleData($check_id);
                                    if($check_update_id_present_in_table!=null)
                                    {
                                        $exists = $Basemodel->getSingleData($check);

                                        if ((($exists) && ($id == $exists->userid)) || (!$exists))
                                        {
                                            $where = array(
                                                'userid' => $id
                                            );
                                            $updaterow = $Basemodel->update($data, $where);
                                            if($updaterow==true)
                                                throw new Exception('Success Update', '200');
                                            else
                                                throw new Exception('Bad Request', '400');
                                        } 
                                        else
                                            throw new Exception('exists', '409');
                                    }
                                }
                                else    throw new Exception('Bad Request', '400');
                                    
                            }
                            else
                                throw new Exception('Not Accessible (mantatory fields is Empty)', '406'); 
                        }

            
                }
            
                
            
            }
            catch (Exception $e) 
            {
                header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }            


        }


        public function nodalperson_data()
        {

            try 
            {
                if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) 
                {
                    throw new Exception('Forbidden', '403');
                } 
                else 
                {
                    // if($csrf_check==0)
                    // {
                        $isvalid    =   true;
                        // $schemecode   =   $_POST['schemecode'];
                    

                        // if($this->is_int($user_id)!=1) $isvalid=false;

                        // if(!($isvalid))
                        //     throw new Exception('Extra Characters','413');
                        // else
                        // {
                            $Basemodel = new Basemodel;
                            $Basemodel->tablename = "mybillmyright.mst_dept_user";
                            $del = array(
                                'nodal' =>  'Y'
                            );
                            $select = "mybillmyright.mst_dept_user.name,mybillmyright.mst_dept_user.empid,mybillmyright.mst_division.divisioncode,mybillmyright.mst_division.divisionlname";
                            $data_verifer = array(
                                'mybillmyright.mst_division' => "mybillmyright.mst_division.divisioncode = mybillmyright.mst_dept_user.divisioncode",
                            );
                            $id = 'createdon';
                            $alias = 'mybillmyright.mst_dept_user';

                            $order_by = 'DESC';
                            $data = $Basemodel->getMultipleJoin_query($select, $data_verifer, $del, $id, $alias, $order_by);
                        

                            if ($data == null) 
                                echo 0;
                            else 
                            { ?>
                                <div class="table-responsive">
                                    <table id="datatables-basic" class="table table-bordered datatables-basic" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th style="width:5%">S.No</th>
                                                <th style="width:10%">Division Name</th>
                                                <th style="width:10%">Employee Id</th>
                                                <th style="width:10%">Name</th>
                    
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                    
                                            foreach ($data as $value) {
                                            
                                            ?>
                                                <tr>
                                                    <td style="text-align:right"><?php echo htmlentities($i); ?></td>
                                                    <td><?= htmlspecialchars($value->divisionlname)  ?></td>
                                                    <td><?= htmlspecialchars($value->empid)  ?></td>
                                                    <td><?= htmlspecialchars($value->name); ?></td>                              
                                                </tr>
                                            <?php  $i++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div><?php
                            }
                        }



                        //}                                                         
                        // }
                        // else
                        //     throw new Exception('csrf error', '403');
                
                    }
            catch (Exception $e) {
                header('HTTP/1.1 ' . $e->getCode() . ' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }

        }
               
     

    ################################ settings function - End ###############################



}