<?php
class User_management extends Controller
{
    public function __construct()
    {
        $this->Mybill = $this->controller('Mybill');

        $this->Basemodel = $this->model('Basemodel');
               
        if (!isset($_SESSION['user'])) {
            header("Location: " . URLROOT . "");
        }

        if (isset($_SESSION['charge']['id'])) {
            $Basemodel = new Basemodel;
            $Basemodel->role_permission($_SESSION['charge']['id']);
        } 

       

        $this->nic_roleid   =    $this->Mybill->nic_roletypecode;
        $this->adc_roleid	=	 $this->Mybill->adc_roletypecode;
        $this->jc_roleid	=	 $this->Mybill->jc_roletypecode;
        $this->dc_roleid	=	 $this->Mybill->dc_roletypecode;
        $this->ac_roleid	=	 $this->Mybill->ac_roletypecode;
        $this->cto_roletypecode =    $this->Mybill->cto_roletypecode;


      

      
    }

    







    #################################### Create_user Function - Start  #########################################


        public function usercreation_data()
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
                    // if($csrf_check==0)
                    // {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                        $isvalid    =   true;
                        
                        $user_id        =   $_SESSION['user']->userid;
                        $page_name      =   $_POST['page_name'];


                        // $action_code    =   $this->Etransfer->killChars(trim(htmlentities($this->Etransfer->get_session_actioncode_or_name('code'))));

                        // $office_code    =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->office_code)));
                        // $dist_code      =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->dist_code)));
                        // $hud_code       =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->hud_code)));
                        // $inst_id        =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->inst_id)));
                        // $usertype_id        =   $this->Etransfer->killChars(trim(htmlentities( $_SESSION['user']->usertype_id)));
                        // $user_id        =   $this->Etransfer->killChars(trim(htmlentities( $_SESSION['user']->user_id)));

                        // if($this->Etransfer->is_int($action_code)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($usertype_id)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($user_id)!=1) $isvalid=false;

                        // if(($usertype_id == 4)||($usertype_id == 3) || ($usertype_id == 5))
                        // {
                        //     if($this->Etransfer->is_int($office_code)!=1) $isvalid=false;
                        //     if(($usertype_id == 3) || ($usertype_id == 4))
                        //     {
                        //         if($office_code == '04')
                        //         {
                        //             if($this->Etransfer->is_int($hud_code)!=1) $isvalid=false;
                        //         }
                        //         if($this->Etransfer->is_int($dist_code)!=1) $isvalid=false;
                        //         if($usertype_id == 4)
                        //         {
                        //             if($this->Etransfer->is_int($inst_id)!=1) $isvalid=false;
                        //         }
                        //     }
                        // }

                        if(!($isvalid))
                            throw new Exception('Extra Characters','413');
                        else
                        {
                            if(!( (empty($user_id))  ))
                            {
                                // $Basemodel = new Basemodel;
                                // $Basemodel->tablename = "nursecounsil.mst_user";
                                // if($action_code==50)
                                //     $del=array();
                                // if($action_code==60)
                                //     $del=array('office_code'=>$office_code);           
                                // if($action_code==40)
                                //     $del=array('office_code'=>$office_code,'dist_code'=>$dist_code);
                                // if(($action_code==30)||($action_code==20)||($action_code==10))       
                                //     $del=array('office_code'=>$office_code,'dist_code'=>$dist_code,'inst_id'=>$inst_id);
                            
                                // if(($action_code==40)||($action_code==30)||($action_code==20)||($action_code==10))
                                // {
                                //     if($office_code == '04')
                                //         $hud_code=$hud_code;
                                //     else
                                //         $hud_code   =   'A';
                                // }
                                // else
                                //     $hud_code   =   'A';
                            
                        
                                // if($office_code == '')
                                //     $office_code='A';
                                // else
                                //     $office_code=$office_code;
                        
                                // if($dist_code == '')
                                //     $dist_code='A';
                                // else
                                //     $dist_code=$dist_code;
                        
                                // if($inst_id == '')
                                //     $inst_id=0;
                                // else
                                //     $inst_id=$inst_id;
                        
                        
                                $session_details    =   $this->Mybill->session_details();
                                $session_userid         =   $session_details[0]->userid;
                                $session_roleid         =   $session_details[0]->roletypecode;
                                $session_divisioncode   =   $session_details[0]->divisioncode ;
                                $session_zonecode       =   $session_details[0]->zonecode ;
                                $session_circleid       =   $session_details[0]->circleid ;
                                $session_distcode       =   $session_details[0]->distcode ;

                                if(( $session_roleid ==  $this->nic_roleid)||($session_roleid == $this->adc_roleid))
                                {
                                    $session_divisioncode   =   'A';
                                    $session_zonecode       =   'A';
                                    $session_circleid       =   0;
                                    $session_distcode       =   'A';
                                }
                                else if(( $session_roleid == $this->jc_roleid)||($session_roleid ==  $this->dc_roleid))
                                {
                                    if( $session_roleid == $this->jc_roleid)
                                        $session_zonecode       =   'A';
                                    $session_circleid       =   0;
                                }
        


                        
                                $Basemodel = new Basemodel;
                                $Basemodel->fnname = "mybillmyright.fn_deptuserdetails_jsondata";
                                $getting_totalpost = array(
                                    'roleid'            =>  $session_roleid,
                                    'divisioncode'      =>  $session_divisioncode,
                                    'zonecode'          =>  $session_zonecode,
                                    'circleid'          =>  $session_circleid,
                                    'distcode'          =>  $session_distcode,
                                    'user_id'           =>  $session_userid
                                );
                                $resultdata1 = $Basemodel->procedure($getting_totalpost);
                                $data = json_decode($resultdata1['fn_deptuserdetails_jsondata'], true);
                                http_response_code(200);

                                // foreach ($data as $value)
                                //                 {
                                                    
                                                    
                                //                 }
                        
                                if($data!=null)
                                {
                                    $i = 1;?>
                                    <div class="table-responsive"> 
                                        <table id="datatables-basic" class="table table-bordered datatables-basic responsive disaplay nowrap" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <!-- <th>GPF/CPS No</th> -->
                                                    <th>Employee Name</th>
                                                    <th>Role Type</th>
                                                    <th>Division</th>
                                                    <th>Zone</th>
                                                    <th>Circle</th>
                                                    <th>DOB</th>
                                                    <th >Mobile No</th>
                                                    <th>Email</th>
                                                    <?php if($page_name=='form')
                                                    {?>
                                                        <th class="all">Action</th><?php
                                                    }?>
                                                
                                                   
                                                </tr>
                                            </thead>
                                            <tbody><?php    
                                              
                                                foreach ($data as $value)
                                                {
                                                                                                          ?> 
                                                        <tr>
                                                            <td class="text-end"><?php echo htmlentities($i); ?></td>
                                                            <!-- <td><?=htmlspecialchars($value['emp_gpfno']);echo htmlentities('/');echo htmlentities($value['suffix_name']) ?></td> -->
                                                            <td><?=htmlspecialchars($value['name']); ?></td>
                                                            <td><?=htmlspecialchars($value['roletypelname']); ?></td>
                                                            <td><?=htmlspecialchars($value['divisionlname']); ?></td>
                                                            <td><?=htmlspecialchars($value['zonelname']); ?></td>
                                                            <td><?=htmlspecialchars($value['circlename']); ?></td>
                                                          
                                                            <td><?=htmlspecialchars(date("d-m-Y", strtotime(($value['dateofbirth'])))); ?></td>
                                                            <td><?=htmlspecialchars($value['mobilenumber']); ?></td>
                                                            <td><?=htmlspecialchars($value['email']); ?></td>
                                                            
                                                        
                                                            <?php if($page_name=='form')
                                                    {?>
                                                            <td> 
                        
                                                                <center>
                                                                <!-- <img src="..." alt="..." class="rounded"> -->
                                                                <a name="edit_dept_user" class="edit_dept_user" data-bs-toggle="tooltip" data-bs-placement="bottom" title="edit" id=<?php echo htmlentities($value['userid']); ?>><i class="fa fa-pencil  editicon"  aria-hidden="true"></i></a> 

                                                                </center>
                                                            </td>
                                                            <?php
                                                    }?>
                                                        </tr><?php 
                                                    
                                                    $i++;
                                                }?>
                                            </tbody>
                                        </table>
                                    </div><?php
                                } 
                                else
                                    echo 0;                    
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
        
        public function insert_update_createuser()
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
                  
                    // if ($_POST['nodal_status'] == 'yes_nodal') $nodal = 'Y';
                    // else $nodal = 'N';
                    // if ($_POST['lottexecutor_status'] == 'yes_lottexecutor') $lott_executor = 'Y';
                    // else $lott_executor = 'N';
                    // if($csrf_check==0)
                    // {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                        $isvalid    =   true;

                        // if(isset($_POST['sel_office']))
                        //     $office_code    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_office'])));
                        // else
                        //     $office_code= $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->office_code)));

                        $action =   trim(htmlentities($_POST["action"]));
                        $mobilenumber =   trim(htmlentities($_POST["mob_no"]));
                        $emp_name =   trim(htmlentities($_POST["emp_name"]));
                        $empid =   trim(htmlentities($_POST["emp_id"]));
                        $email =   trim(htmlentities($_POST["email"]));
                        $roleid =   trim(htmlentities($_POST["roleid"]));
                        $action =   trim(htmlentities($_POST["action"]));
                      
                        $dob=$this->Mybill->change_date_time_to_database_format($_POST['dob'],'');


				        $distcode    =  date($_POST['distcode'])  ;

                        $session_details    =   $this->Mybill->session_details();
                        $session_userid            =   $session_details[0]->userid;
                        $state_code             =   $session_details[0]->statecode;
                        $session_roleid             =   $session_details[0]->roletypecode;
                        $session_divisioncode             =   $session_details[0]->divisioncode ;
                        $session_zonecode             =   $session_details[0]->zonecode ;

                      

                        if(($roleid  ==  $this->jc_roleid)||($roleid  ==   $this->dc_roleid)||($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                        {
                            if(($session_roleid   ==  $this->jc_roleid)||($session_roleid   ==   $this->dc_roleid))
                            {
                                $divisioncode   =   $session_divisioncode;
                                if(($session_roleid   ==   $this->dc_roleid))
                                    $zonecode   =   $session_zonecode;
                                else
                                    $zonecode       =   $_POST['sel_zone'];
                            }
                            else
                            {
                              
                                $divisioncode   =   $_POST['sel_division'];
                                $zonecode       =   $_POST['sel_zone'];
                            }
                         
                            if(($roleid  ==   $this->dc_roleid)||($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                            {
                                if(($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                                {
                                    $circleid   =   $_POST['sel_circle'];
                                }
                            }
                        }




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


                        $Basemodel = new Basemodel;
                        $Basemodel->tablename = "mybillmyright.mst_dept_user";
            
                        //checking already exists
                        $check = array(
                            // 'emp_gpfno'         => htmlentities($_POST['gpf_no']),
                            // 'suffix_code'   => htmlentities($_POST['suffix']),
                             'empid'   => htmlentities($_POST['emp_id']),
                            
                            // 'dob'           => trim(date($_POST['dob'])) ,                  
                        );
                        $exists = $Basemodel->getSingleData($check);

                        //checking email id already exists
                        $check = array(
                            'email' => $_POST['email'],
                        );
                        $email_exists = $Basemodel->getSingleData($check);

                         //checking Mobile number already exists
                        $check = array(
                            'mobilenumber' => $mobilenumber,
                        );
                        $mob_no_exists = $Basemodel->getSingleData($check);
    
                        if(!($isvalid))
                            throw new Exception('Extra Characters','413');
                        else
                        {
                            if(!( (empty($state_code)) || (empty($dob)) ||   (empty($mobilenumber)) ||  (empty($emp_name)) || (empty($empid)) || (empty($email))  ||  (empty($roleid)) ))
                            {
                               

                                $data = array(
                                    // 'emp_gpfno'     =>  $emp_gpfno, // Getting values
                                    // 'suffix_code'   =>  $suffix_code,
                                    'name'          =>  $emp_name,
                                    // 'statusflag'   => true,
                                    'dateofbirth'           =>  $dob ,
                                    'distcode'           =>  $distcode ,
                                    'mobilenumber'  =>  $mobilenumber,
                                    'email'         =>  $email,
                                    // 'office_code'   =>  $office_code,
                                    'statecode'    =>  $state_code,
                                    'roletypecode'   =>  $roleid,
                                    'empid'     =>  $empid,
                                    // 'nodal'     =>  $nodal,
                                    // 'lott_executor'     =>  $lott_executor
                                );

                                if(($roleid  ==  $this->jc_roleid)||($roleid  ==   $this->dc_roleid)||($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                                {
                                    $data['divisioncode']=htmlentities($divisioncode);
                                    if(($roleid  ==   $this->dc_roleid)||($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                                    {
                                        $data['zonecode']=htmlentities($zonecode);
                                        if(($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                                        {
                                            $data['circleid']=htmlentities($circleid);
                                        }
                                    }
                                }
                                
                            
                                
                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.mst_dept_user";
                                if ($action == 'insert')
                                {
                                    if ($exists == '') //If not exists.. insert into table
                                    {
                                        if ($email_exists == '') //If not exists.. insert into table
                                        {
                                            if($mob_no_exists   ==  '')
                                            {
                                                $data['createdby']=$session_userid;
                                                $data['createdon']='now()';
                                                $insert_data    =   $Basemodel->insert($data);
                                                if($insert_data)
                                                    throw new Exception('success', '200');
                                                else 
                                                    throw new Exception('Bad Request', '400');
                                            }
                                            else   throw new Exception('Mobile number Already exists', '653'); 
                                        }
                                        else
                                            throw new Exception('Email Already exists', '651'); 
                                    }
                                    else //Otherwise display error msg as 'Already exists'
                                        throw new Exception('Gpfno and Suffix Code already exists', '652');                                         
                                }
                                else if ($action == 'update')
                                {
                                    $isvalid    =   true;

                                    $update='N';
                                    // $id    =   $this->Etransfer->killChars(trim(htmlentities($this->Etransfer->decryption($_POST['userid'],$this->Etransfer->key))));
                                    // if($this->Etransfer->is_int($id)!=1) $isvalid=false;
                                    $id=    $_POST['userid'];

                                    if(!($isvalid))
                                        throw new Exception('Extra Characters','413');
                                    else
                                    {
                                        $Basemodel = new Basemodel;
                                        $Basemodel->tablename = "mybillmyright.mst_dept_user";
                                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                                        $where_data = array(
                                            'userid' => $id,
                                        );
                                        $get_userdel =   $Basemodel->getMultipleData($where_data,'userid');
    
                                        if($get_userdel)
                                        {
                                            //checking gpf_no and suffix code already exists
                                            if (($exists && $id == $exists->userid)||(!$exists))
                                                $update='Y';
                                            else
                                                $update='N';
    
                                            //if not exists again checking email id already exists or not
                                            if($update=='Y')
                                            {
                                                if (($email_exists && $id == $email_exists->userid)||(!$email_exists)  )//If not exists.. insert into table
                                                {
                                                    if (($mob_no_exists && $id == $mob_no_exists->userid)||(!$mob_no_exists)  )//If not exists.. insert into table
                                                    {
                                                        $data['updatedby']=$session_userid;
                                                        $data['updatedon']='now()';
                                                        $where = array('userid' => $id);
                                                        $updaterow = $Basemodel->update($data, $where);
                                                        if($updaterow)
                                                            throw new Exception('success', '200');
                                                        else 
                                                            throw new Exception('Bad Request', '400');
                                                    }
                                                    else   throw new Exception('Mobile number Already exists', '653'); 
                                                }
                                                else        //email already exists
                                                    throw new Exception('Email Already exists', '651'); 
                                            }
                                            else //gpfno,suffix already exist
                                                throw new Exception('Gpfno and Suffix Code already exists', '652'); 
                                        }
                                    }  
                                }
                                else
                                    throw new Exception('Bad Request', '400');    
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

         
        public function edit_dept_user()
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
                    // if($csrf_check==0)
                    // {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                        $isvalid    =   true;

                        $id = $_POST['id'];

                        // $id    =   $this->Etransfer->killChars(trim(htmlentities($this->Etransfer->decryption($_POST['id'],$this->Etransfer->key))));

                        // if($this->Etransfer->is_int($id)!=1) $isvalid=false;

                        if(!($isvalid))
                            throw new Exception('Extra Characters','413');
                        else
                        {
                            if(!( (empty($id))  ))
                            {
                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.mst_dept_user";
                                $get_dept_user_data = $Basemodel->getSingleData(array(
                                    "userid" => $id
                                ));
                                if($get_dept_user_data)
                                {
                                    http_response_code(200);
                                    echo json_encode($get_dept_user_data);
                                }
                                else
                                    throw new Exception('Bad Request', '400');    
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


    #################################### Create_user Function - End  #########################################


    #################################### Create_charge Function - Start  #########################################


 
        public function chargecreation_data()
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
                    // if($csrf_check==0)
                    // {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                        $isvalid    =   true;
                        
                        $user_id        =   $_SESSION['user']->userid;
                        $page_name      =   $_POST['page_name'];

                        // $action_code    =   $this->Etransfer->killChars(trim(htmlentities($this->Etransfer->get_session_actioncode_or_name('code'))));

                        // $office_code    =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->office_code)));
                        // $dist_code      =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->dist_code)));
                        // $hud_code       =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->hud_code)));
                        // $inst_id        =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->inst_id)));
                        // $usertype_id        =   $this->Etransfer->killChars(trim(htmlentities( $_SESSION['user']->usertype_id)));
                        // $user_id        =   $this->Etransfer->killChars(trim(htmlentities( $_SESSION['user']->user_id)));

                        // if($this->Etransfer->is_int($action_code)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($usertype_id)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($user_id)!=1) $isvalid=false;

                        // if(($usertype_id == 4)||($usertype_id == 3) || ($usertype_id == 5))
                        // {
                        //     if($this->Etransfer->is_int($office_code)!=1) $isvalid=false;
                        //     if(($usertype_id == 3) || ($usertype_id == 4))
                        //     {
                        //         if($office_code == '04')
                        //         {
                        //             if($this->Etransfer->is_int($hud_code)!=1) $isvalid=false;
                        //         }
                        //         if($this->Etransfer->is_int($dist_code)!=1) $isvalid=false;
                        //         if($usertype_id == 4)
                        //         {
                        //             if($this->Etransfer->is_int($inst_id)!=1) $isvalid=false;
                        //         }
                        //     }
                        // }

                        if(!($isvalid))
                            throw new Exception('Extra Characters','413');
                        else
                        {
                            if(!( (empty($user_id))  ))
                            {
                                // $Basemodel = new Basemodel;
                                // $Basemodel->tablename = "nursecounsil.mst_user";
                                // if($action_code==50)
                                //     $del=array();
                                // if($action_code==60)
                                //     $del=array('office_code'=>$office_code);           
                                // if($action_code==40)
                                //     $del=array('office_code'=>$office_code,'dist_code'=>$dist_code);
                                // if(($action_code==30)||($action_code==20)||($action_code==10))       
                                //     $del=array('office_code'=>$office_code,'dist_code'=>$dist_code,'inst_id'=>$inst_id);
                            
                                // if(($action_code==40)||($action_code==30)||($action_code==20)||($action_code==10))
                                // {
                                //     if($office_code == '04')
                                //         $hud_code=$hud_code;
                                //     else
                                //         $hud_code   =   'A';
                                // }
                                // else
                                //     $hud_code   =   'A';
                            
                        
                                // if($office_code == '')
                                //     $office_code='A';
                                // else
                                //     $office_code=$office_code;
                        
                                // if($dist_code == '')
                                //     $dist_code='A';
                                // else
                                //     $dist_code=$dist_code;
                        
                                // if($inst_id == '')
                                //     $inst_id=0;
                                // else
                                //     $inst_id=$inst_id;

                                
                                $session_details    =   $this->Mybill->session_details();
                                $session_userid         =   $session_details[0]->userid;
                                $session_roleid         =   $session_details[0]->roletypecode;
                                $session_divisioncode   =   $session_details[0]->divisioncode ;
                                $session_zonecode       =   $session_details[0]->zonecode ;
                                $session_circleid       =   $session_details[0]->circleid ;
                                $session_distcode       =   $session_details[0]->distcode ;

                                if(( $session_roleid ==  $this->nic_roleid)||($session_roleid == $this->adc_roleid))
                                {
                                    $session_divisioncode   =   'A';
                                    $session_zonecode       =   'A';
                                    $session_circleid       =   0;
                                    $session_distcode       =   'A';
                                }
                                else if(( $session_roleid ==$this->jc_roleid)||($session_roleid ==  $this->dc_roleid))
                                {
                                    if( $session_roleid == $this->jc_roleid)
                                        $session_zonecode       =   'A';
                                    $session_circleid       =   0;
                                }
        

          
                        
                                $Basemodel = new Basemodel;
                                $Basemodel->fnname = "mybillmyright.fn_chargedetails_jsondata";
                                $getting_totalpost = array(
                                    'roleid'            =>  $session_roleid,
                                    'divisioncode'      =>  $session_divisioncode,
                                    'zonecode'          =>  $session_zonecode,
                                    'circleid'          =>  $session_circleid,
                                    'distcode'          =>  $session_distcode,
                                    'user_id'           =>  $_SESSION['charge']['id']
                                );
                                $resultdata1 = $Basemodel->procedure($getting_totalpost);
                                $data = json_decode($resultdata1['fn_chargedetails_jsondata'], true);
                                http_response_code(200);
                                // $Basemodel = new Basemodel;
                                // $Basemodel->fnname = "nursecounsil.fn_get_charge_details_jsondata";
                                // $getting_totalpost = array(
                                //     'usertype_id'       =>  $_SESSION['user']->usertype_id,
                                //     'office_code'       =>  $office_code,
                                //     'dist_code'         =>  $dist_code,
                                //     'hud_code'          =>  $hud_code,
                                //     'inst_code'         =>  $inst_id,
                                //     'charge_id'         =>  $_SESSION['charge']['id']
                                // );
                                // $resultdata1 = $Basemodel->procedure($getting_totalpost);
                                // $data = json_decode($resultdata1['fn_get_charge_details_jsondata'], true);
                                // http_response_code(200);
                        
                                if($data!=null)
                                {
                                    $i = 1;?>
                                    <div class="table-responsive">
                                        <table id="datatables-basic" class="table table-bordered datatables-basic text-start" style="width:100%">
                                            <thead>
                                                <tr>
                                                <th>S.No</th>
                                                <th>Role Type</th>
                                                <th>Division</th>
                                                <th>Zone</th>
                                                <th>Circle</th>
                                                <th>District</th>
                                                <!-- <th>Category</th> -->
                                                <th>Charge Description</th>
                                               <?php if($page_name=='form')
                                               {?>
 <th>Action</th><?php
                                               }?>
                                            
                                               
                                                    
                                                </tr>
                                            </thead>
                                            <tbody><?php      
                                                foreach ($data as $value)
                                                {
                                                    if($value['divisionlname']!='')
                                                        $division_name=$value['divisionlname'];
                                                    else
                                                        $division_name=' - ';
                                                    if($value['zonelname']!='')
                                                        $zone_name=$value['zonelname'];
                                                    else
                                                        $zone_name=' - ';

                                                    if($value['circlename']!='')
                                                        $circle_name=$value['circlename'];
                                                    else
                                                        $circle_name=' - ';
                                                    
                                                
                                                        ?> 
                                                        <tr>
                                                            <td class="text-end"><?php echo htmlentities($i); ?></td>
                                                            <td><?=htmlspecialchars($value['roletypelname']); ?></td>
                                                            <td ><?=htmlspecialchars($division_name); ?></td>

                                                            <td ><?=htmlspecialchars($zone_name); ?></td>
                                                            <td ><?=htmlspecialchars($circle_name); ?></td>
                                                            <td> <?php echo htmlentities($value['distename']);?></td>
                                                            <td><?=htmlspecialchars($value['chargedescription']); ?></td>
                                                          
                                                            <?php if($page_name=='form')
                                               {?>
                                                            <td>
                                                            <center><a name="edit_charge" class="edit_charge" data-bs-toggle="tooltip" data-bs-placement="bottom" title="edit" id=<?php echo  htmlentities($value['chargeid']); ?>><i class="fa  fa-pencil editicon"  aria-hidden="true"></i></a> </center>

                                                            </td><?php
                                               }?>
                                                        </tr><?php 
                                                    $i++;
                                                }?>
                                            </tbody>
                                        </table>
                                    </div><?php
                                } 
                                else
                                    echo 0;                    
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

        public function edit_charge()
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
                    // if($csrf_check==0)
                    // {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                        $isvalid    =   true;

                        $id   = $_POST['id'];

                        // $id    =   $this->Etransfer->killChars(trim(htmlentities($this->Etransfer->decryption($_POST['id'],$this->Etransfer->key))));

                        // if($this->Etransfer->is_int($id)!=1) $isvalid=false;

                        if(!($isvalid))
                            throw new Exception('Extra Characters','413');
                        else
                        {
                            if(!( (empty($id))  ))
                            {

                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.mst_charge";
                                $data = $Basemodel->getSingleData(array(
                                    "chargeid" => $id
                                ));




                                if($data)
                                {
                                    http_response_code(200);
                                    echo json_encode($data);
                                }
                                else
                                    throw new Exception('Bad Request', '400');    
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

        public function insert_update_createcharge()
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
                    // if($csrf_check==0)
                    // {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                        $isvalid    =   true;


                        $action =   trim(htmlentities($_POST["action"]));
                        $charge_des =   trim(htmlentities($_POST["charge_des"]));
                       
                        $roleid =   trim(htmlentities($_POST["roleid"]));
                      

                      
                        $distcode    =  trim($_POST['distcode'])  ;


                        $session_details    =   $this->Mybill->session_details();
                        $session_userid            =   $session_details[0]->userid;
                        $state_code             =   $session_details[0]->statecode;
                        $session_roleid             =   $session_details[0]->roletypecode;
                        $session_divisioncode             =   $session_details[0]->divisioncode ;
                        $session_zonecode             =   $session_details[0]->zonecode ;


                        if(($roleid  ==  $this->jc_roleid)||($roleid  ==   $this->dc_roleid)||($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                        {
                            if(($session_roleid   ==  $this->jc_roleid)||($session_roleid   ==   $this->dc_roleid))
                            {
                                $divisioncode   =   $session_divisioncode;
                                if(($session_roleid   ==   $this->dc_roleid))
                                    $zonecode   =   $session_zonecode;
                                else
                                    $zonecode       =   $_POST['sel_zone'];
                            }
                            else
                            {
                                $divisioncode   =   $_POST['sel_division'];
                                $zonecode       =   $_POST['sel_zone'];
                            }
                         
                            if(($roleid  ==   $this->dc_roleid)||($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                            {
                                if(($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                                {
                                    $circleid   =   $_POST['sel_circle'];
                                }
                            }
                        }
                        $roleactioncode       =   $_POST['roleactioncode'];
                       

                        // if(isset($_POST['sel_office']))
                        //     $office_code    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_office'])));
                        // else
                        //     $office_code= $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->office_code)));

                        // $action =   trim(htmlentities($_POST["action"]));

                        // $session_usertype_id     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->usertype_id)));
                        // $session_dist_code     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->dist_code)));
                        // $session_hud_code     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->hud_code)));
                        // $session_user_id     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->user_id)));

                        // $state_code     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->state_code)));
                        // $charge_role      =   $this->Etransfer->killChars(trim(htmlentities($_POST['charge_role'])));
                        // $user_type      =   $this->Etransfer->killChars(trim(htmlentities($_POST['user_type'])));
                        // $sel_category      =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_category'])));
                        // $charge_des      =   $this->Etransfer->killChars(trim(htmlentities($_POST['charge_des'])));

                        
                        // if(isset($_POST['sel_dist']))
                        //     $dist_code    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_dist'])));
                        // else
                        //     $dist_code= $session_dist_code;


                        // if(isset($_POST['sel_hud']))
                        //     $hud_code    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_hud'])));
                        // else 
                        //     $hud_code= $session_hud_code;

                        // $inst_id    =   $this->Etransfer->killChars(trim(htmlentities($_POST['sel_inst'])));


                        // $Basemodel = new Basemodel;
                        // $Basemodel->tablename = "nursecounsil.mst_config";
                        // $check = array(
                        //     'scheme_code'           => htmlentities($sel_category),
                        //     'state_code'            => htmlentities($state_code),
                        //     'office_code'           => trim(htmlentities($office_code)) ,     
                        // );
                        // $exists = $Basemodel->getSingleData($check);
                        // if($exists)
                        // {
                        //     $config_code=$exists->config_code;
                        //     $category_code=$exists->category_code;
                        // }
                       


                        // $Basemodel = new Basemodel;
                        // $Basemodel->tablename = "nursecounsil.mst_role";
                        // $check = array(
                        //     'roleid'            => $charge_role        
                        // );
                        // $role_data = $Basemodel->getSingleData($check);
                        // $action_code=$role_data->action_code;

                        // if($this->Etransfer->has_only_letters($charge_des,'100','Y')!=1)$valid=false;


                        // if($this->Etransfer->is_int($office_code)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($state_code)!=1) $isvalid=false;
                        // if($exists)
                        // {
                        //     if($this->Etransfer->is_int($config_code)!=1) $isvalid=false;
                        //     if($this->Etransfer->is_int($category_code)!=1) $isvalid=false;
                        // }
                        // if($this->Etransfer->is_int($action_code)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($user_type)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($session_user_id)!=1) $isvalid=false;

                        if(!($isvalid))
                            throw new Exception('Extra Characters','413');
                        else
                        {
                           
                                if(!( (empty($charge_des))  || (empty($state_code)) || (empty($roleid)) || (empty($session_userid)) ))
                                {
                                    
                                    $Basemodel = new Basemodel;
                                    $Basemodel->tablename = "mybillmyright.mst_role";
                                    $check = array(
                                        'roleactioncode'            => $roleactioncode        
                                    );
                                    $role_data = $Basemodel->getSingleData($check);

                                    if($role_data)
                                    {
                                        $insert_roleid=$role_data->roleid;

                                        $flag   =   'Y';
                                        $data = array(
                                            'roletypecode'               => htmlentities($roleid) ,
                                            'chargedescription'    => htmlentities($charge_des),
                                            'roleactioncode'        =>  htmlentities($roleactioncode),
                                            'roleid'                =>  htmlentities($insert_roleid)
                                        );
    
                                            
                                        if(($roleid  ==  $this->jc_roleid)||($roleid  ==   $this->dc_roleid)||($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                                        {
                                            $data['distcode']   =   htmlentities($distcode);
                                            $data['divisioncode']=htmlentities($divisioncode);
                                            if(($roleid  ==   $this->dc_roleid )||($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                                            {
                                                $data['zonecode']=htmlentities($zonecode);
                                                if(($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                                                {
                                                    $data['circleid']=htmlentities($circleid);
                                                }
                                            }
                                        }
    
                                       
    
                                        $Basemodel = new Basemodel;
                                        $Basemodel->tablename = "mybillmyright.mst_charge";
    
                                        $check = array(
                                            'roletypecode'               => htmlentities($roleid) ,
                                            'roleactioncode'        =>  htmlentities($roleactioncode)  
                                        );
    
    
                                        if(($roleid  ==  $this->jc_roleid)||($roleid  ==   $this->dc_roleid)||($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                                        {
                                            $check['divisioncode']=htmlentities($divisioncode);
                                            if(($roleid  ==   $this->dc_roleid)||($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                                            {
                                                $check['zonecode']=htmlentities($zonecode);
                                                if(($roleid  ==  $this->ac_roleid)||($roleid  ==  $this->cto_roletypecode))
                                                {
                                                    $check['circleid']=htmlentities($circleid);
                                                }
                                            }
                                        }
    
          
                                    
                                        $exists = $Basemodel->getSingleData($check);
    
                                        if ($action == 'insert')
                                        {
                                            // $max_code=$Basemodel->get_maxid('charge_code');
                            
                                            // if($max_code==0)
                                            //     $max_code=1;
                                            // else
                                            //     $max_code=$max_code+1;
    
                                            // $data['charge_code']= $max_code;
    
                                            $data['createdby']=$session_userid;
                                            $data['createdon']='now()';
                                                    
                                            if ($exists == '') //If not exists.. insert into table
                                            {
                                                if($Basemodel->insert($data))
                                                    throw new Exception('Success', '200');
                                                else
                                                    throw new Exception('Bad Request', '400');
                                            } 
                                            else  throw new Exception('exists', '409');                          
                                        }
                                        else if ($action == 'update')
                                        {
                                            $isvalid    =   true;
    
                                            $update='N';
    
                                            $id =   $_POST['chargeid'];
                                            // $id    =   $this->Etransfer->killChars(trim(htmlentities($this->Etransfer->decryption($_POST['userid'],$this->Etransfer->key))));
                                            // if($this->Etransfer->is_int($id)!=1) $isvalid=false;
    
                                            if(!($isvalid))
                                                throw new Exception('Extra Characters','413');
                                            else
                                            {
                                                
                                                $Basemodel = new Basemodel;
                                                $Basemodel->tablename = "mybillmyright.mst_charge";
                                                $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                                                $where_data = array(
                                                    'chargeid' => $id,
                                                );
                                                $get_chargedel =   $Basemodel->getMultipleData($where_data,'chargeid');
    
                                                if($get_chargedel)
                                                {
                                                    $data['updatedby']=$session_userid;
                                                    $data['updatedon']='now()';
                                    
                                                    if (($exists && $id == $exists->chargeid)||(!$exists))//If not exists.. insert into table
                                                    {
                                                        $where = array('chargeid' => $id);
                                                        $updaterow = $Basemodel->update($data, $where);
                                                        if($updaterow)
                                                            throw new Exception('Success', '200');
                                                        else
                                                            throw new Exception('Bad Request', '400');
                                                    }
                                                    else  throw new Exception('exists', '409');                          
                                                }
                                            }  
                                        }
                                        else
                                            throw new Exception('Bad Request', '400'); 
                                    }
                                    else
                                        throw new Exception('Role not created', '691'); 

                                     
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



        
        public function get_roleaction_basedon_roletype()
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
                    // if($csrf_check==0)
                    // {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                        $isvalid    =   true;
                        // $usertype_id    =   $this->Etransfer->killChars(trim(htmlentities($_POST['usertype_id'])));

                        $roletypecode   =   $_POST['roletypecode'];
                        // if($this->Etransfer->is_int($usertype_id)!=1) $isvalid=false;

                        if(!($isvalid))
                            throw new Exception('Extra Characters','413');
                        else
                        {
                            if(!( (empty($roletypecode))  ))
                            {
                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.mst_roleaction";
                                $id = 'roleactionlname';
                                $data = ($Basemodel->getMultipleData(array('roletypecode' => $roletypecode), $id));
                                if($data)
                                {
                                    http_response_code(200);
                                    echo json_encode($data);
                                }
                                else    throw new Exception('Bad Request', '400'); 
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


    #################################### Create_charge Function - End  #########################################


    #################################### assign_charge Function - Start  #########################################

        public function get_assign_charge()
        {
            // $csrf_check=$this->Etransfer->checkCSRF();
        
            try 
            {
                if(!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD']== 'post')))
                    throw new Exception('Forbidden','403');

                else
                {
                    // if($csrf_check==0)
                    // {
        
              
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

                        // $usertype_id=$this->Etransfer->killChars(trim(htmlentities($_POST['usertype_id'])));
                        // $office_code=$this->Etransfer->killChars(trim(htmlentities($_POST['directorate'])));
                        // $hud_code=$this->Etransfer->killChars(trim(htmlentities($_POST['hud_code'])));
                        // $inst_id=$this->Etransfer->killChars(trim(htmlentities($_POST['inst_code'])));
                        // $dist_code=$this->Etransfer->killChars(trim(htmlentities($_POST['dist_code'])));

                        $distcode   =   $_POST['distcode'];
                        $roleid   =   $_POST['roleid'];
                        $divisioncode   =   $_POST['divisioncode'];
                        $zonecode   =   $_POST['zonecode'];
                        $circleid   =   $_POST['circleid'];

                   
                        if(($roleid == $this->jc_roleid) || ($roleid ==  $this->dc_roleid) || ($roleid == $this->ac_roleid) )
                        {
                            if(($roleid == $this->jc_roleid) )  
                            {
                                $zonecode   =   'A';
                                $circleid   =   0   ;
                            }
                            if(($roleid ==  $this->dc_roleid) )  
                                $circleid   =   0   ;

                        }
                        elseif(($roleid == $this->adc_roleid))
                        {
                           
                            $divisioncode   =   'A';
                            $zonecode   =   'A';
                            $circleid   =   0   ;
                            $distcode   =   'A';
                        }

           


                        // if(($usertype_id == 4) || ($usertype_id == 3) )
                        // {
                        //     if(!($office_code == '04'))
                        //         $hud_code   =   'A';
                           
                        //     if(!($usertype_id==4))
                        //         $inst_id=0;
                        // }
                        // if(($usertype_id == 5))
                        // {
                        //     $dist_code='A';
                        //     $inst_id=0;
                        //     $hud_code   =   'A';
                        // }
        
                        $valid=true;
        
                        // if($this->Etransfer->is_int($usertype_id)!=1)$valid=false;
        
                        // if($this->Etransfer->is_int($office_code)!=1)$valid=false;
        

                        // if($dist_code=='A')
                        // {
                        //     if($this->Etransfer->has_only_letters($dist_code,'1','Y')!=1)$valid=false;
                        // }
                        // else
                        // {
                        //     if($this->Etransfer->is_int($dist_code)!=1)$valid=false;
                        // }

                        // if($hud_code=='A')
                        // {
                        //     if($this->Etransfer->has_only_letters($hud_code,'1','Y')!=1)$valid=false;
                        // }
                        // else
                        // {
                        //     if($this->Etransfer->is_int($hud_code)!=1)$valid=false;
                        // }
                        // if($this->Etransfer->is_int($inst_id)!=1)$valid=false;

                        
                        if(!($valid))
                            throw new Exception('Extra Characters','413');   
                        else
                        {
                            if(!( (empty($roleid)) || (empty($divisioncode)) || (empty($zonecode))   || (empty($distcode)) ))
                            {
                                $Basemodel = new Basemodel;
                                $Basemodel->fnname = "mybillmyright.fn_getcharge_basedon_roleid";
                                $getting_totalpost = array(
                                    'usertype_id'       =>  $roleid,
                                    'division_code'       =>  $divisioncode,
                                    'zonecode'         =>  $zonecode,
                                    'circleid'          =>  $circleid,
                                    'distcode'         =>  $distcode,
                                );
                                $resultdata1 = $Basemodel->procedure($getting_totalpost);
                                $data = json_decode($resultdata1['fn_getcharge_basedon_roleid'], true);
                                
                                if ($data) 
                                {
                                    foreach ($data as $value)
                                    {
                                        $assigncharge_data[] = array(
                                            "chargeid" => $value['chargeid'],
                                            "chargedescription" => $value['chargedescription'],
                                            // "config_code"   =>  $value['config_code'],
                                            // "categeory_name"    =>  $value['category_lname']
                                            
                                        );
                                    }
                                    echo json_encode($assigncharge_data);                                                                    
                                    http_response_code(200);
                                }    
                                else
                                    throw new Exception('Bad Request','400');   
                            }
                            else
                                throw new Exception('Not Accessible (mantatory fields is Empty)', '406'); 
                        }
                    // }
                    // else throw new Exception('csrf erro22r', '403');
                    
                }
            }
            catch (Exception $e) 
            {
                header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }     
        
        }

        public function assign_user_data()
        {
            // $csrf_check=$this->Etransfer->checkCSRF();
        
            try 
            {
                if(!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
                    throw new Exception('Forbidden','403');
                else
                {
                    // if($csrf_check==0)
                    // { 

                        $isvalid        =   true;

                        $session_details        =   $this->Mybill->session_details();
                        $session_userid         =   $session_details[0]->userid;
                        $session_roleid         =   $session_details[0]->roletypecode;
                        $session_divisioncode   =   $session_details[0]->divisioncode ;
                        $session_zonecode       =   $session_details[0]->zonecode ;
                        $session_circleid       =   $session_details[0]->circleid ;
                        $session_distcode       =   $session_details[0]->distcode ;

                        if(( $session_roleid ==  $this->nic_roleid)||($session_roleid == $this->adc_roleid))
                        {
                            $session_divisioncode   =   'A';
                            $session_zonecode       =   'A';
                            $session_circleid       =   0;
                            $session_distcode       =   'A';
                        }
                        else if(( $session_roleid == $this->jc_roleid)||($session_roleid ==  $this->dc_roleid))
                        {
                            if( $session_roleid == $this->jc_roleid)
                                $session_zonecode       =   'A';
                            $session_circleid       =   0;
                        }


                        // $action_code    =   $this->Etransfer->killChars(trim(htmlentities($this->Etransfer->get_session_actioncode_or_name('code'))));
                        // $usertype_id    =   $this->Etransfer->killChars(trim(htmlentities( $_SESSION['user']->usertype_id)));
                        // $user_id        =   $this->Etransfer->killChars(trim(htmlentities( $_SESSION['user']->user_id)));

                        // $office_code    =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->office_code)));
                        // $dist_code      =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->dist_code)));
                        // $hud_code       =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->hud_code)));
                        // $inst_id        =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->inst_id)));

                        // if($this->Etransfer->is_int($action_code)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($usertype_id)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($user_id)!=1) $isvalid=false;

                        // if(($usertype_id == 4)||($usertype_id == 3) || ($usertype_id == 5))
                        // {
                        //     if($this->Etransfer->is_int($office_code)!=1) $isvalid=false;
                        //     if(($usertype_id == 3) || ($usertype_id == 4))
                        //     {
                        //         if($office_code == '04')
                        //         {
                        //             if($this->Etransfer->is_int($hud_code)!=1) $isvalid=false;
                        //         }
                        //         if($this->Etransfer->is_int($dist_code)!=1) $isvalid=false;
                        //         if($usertype_id == 4)
                        //         {
                        //             if($this->Etransfer->is_int($inst_id)!=1) $isvalid=false;
                        //         }
                        //     }
                        // }

                        if(!($isvalid))
                            throw new Exception('Extra Characters','413');
                        else
                        {
                            if(!(  (empty($session_userid))  ))
                            {
                                // if(($action_code==40)||($action_code==30)||($action_code==20)||($action_code==10))
                                // {
                                //     if(!($office_code == '04'))
                                //         $hud_code   =   'A';
                                // }
                                // else
                                //     $hud_code   =   'A';
                        
                                // if($office_code == '')
                                //     $office_code='A';
                        
                                // if($dist_code == '')
                                //     $dist_code='A';
                            
                                // if($inst_id == '')
                                //     $inst_id=0;
                              
                                $Basemodel = new Basemodel;
                                $Basemodel->fnname = "mybillmyright.fn_assigningcharge_jsondata";
                                 $getting_totalpost = array(
                                    'roleid'            =>  $session_roleid,
                                    'divisioncode'      =>  $session_divisioncode,
                                    'zonecode'          =>  $session_zonecode,
                                    'distcode'          =>  $session_distcode,
                                    'circleid'          =>  $session_circleid,
                                  
                                    'user_id'           =>  $session_userid
                                );
                                
                              
                                $resultdata1 = $Basemodel->procedure($getting_totalpost);
                                $data = json_decode($resultdata1['fn_assigningcharge_jsondata'], true);
                                http_response_code(200);
                                
                                if($data!=null)
                                {
                                    $i = 1;?>
                                    <div class="table-responsive">
                                        <table id="datatables-basic" class="table table-bordered datatables-basic text-end" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>S.No</th>
                                                    <!-- <th>GPF/CPS No</th> -->
                                                    <th>Employee Name</th>
                                                    <th>Division</th>
                                                  
                                                    <th>Zone</th>
                                                    <th>Circle</th>
                                                    <th>District</th>
                                                    
                
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody><?php
                                                foreach ($data as $value) 
                                                {
                                                    if ($value['distename'] != '')
                                                    {
                                                        $dist_name  =    $value['distename'];
                                                    }
                                                        
                                                    else
                                                        $dist_name = ' - ';

                                                    if ($value['divisionlname'] != '')
                                                        $division_name = $value['divisionlname'];
                                                    else
                                                        $division_name = ' - ';


                                                        if ($value['zonelname'] != '')
                                                        $zone_name = $value['zonelname'];
                                                    else
                                                        $zone_name = ' - ';

                                                        if ($value['circlename'] != '')
                                                        $circle_name = $value['circlename'];
                                                    else
                                                        $circle_name = ' - ';
                
                                                    if ($_SESSION['user']->userid == $value['userid'])
                                                        continue;
                                                    else 
                                                    {?>
                                                        <tr>
                                                            <td class="text-end"><?php echo $i; ?></td>
                                                            <td class="text-start"><?= htmlspecialchars($value['name']); ?></td>
                                                            <td class="text-start"><?= htmlspecialchars($division_name); ?></td>
                                                            <td class="text-start"><?= htmlspecialchars($zone_name); ?></td>
                                                         
                                                            <td class="text-start"><?= htmlspecialchars($circle_name); ?></td>
                                                            <td class="text-start"><?= htmlspecialchars($dist_name); ?></td>
                
                                                            <td>
                                                                <center><a name="edit_assign_charge" data-bs-toggle="tooltip" data-bs-placement="bottom" title="edit" class="edit_assign_charge" id=<?php echo htmlentities($value['userid']) ?>><i class="fa fa-pencil  editicon"></i></a> </center>
                                                            </td>
                
                                                        </tr><?php
                                                    }
                                                    $i++;
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div><?php
                                }
                                else
                                {
                                    echo 'No_data';
                                } 
                            }
                            else
                                throw new Exception('Not Accessible (mantatory fields is Empty)', '406');
                        }
                    // }
                    // else throw new Exception('csrf error', '403');
                }
            }
            catch (Exception $e) 
            {
                header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }
        
        }

                     public function insert_update_assigncharge()
        {    
            // $csrf_check=$this->Etransfer->checkCSRF();
            try 
            {
                if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD']== 'post')))
                    throw new Exception('Forbidden','403');
                else
                {
                    // if($csrf_check==0)
                    // {
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                        $insert_success = 'N';
                        $Basemodel = new Basemodel;
                        $Basemodel->tablename = "mybillmyright.mst_user_charge";
                        $flag = 'Y';

                         //Getting form informations
                        $userid             =   $_POST['userid'];
                        $divisioncode       =   $_POST['sel_division'];
                        $zonecode           =   $_POST['sel_zone'];
                        $circleid           =   $_POST['sel_circle'];
                        $userid             =   $_POST['userid'];
                        $assign_charge      =   $_POST['assign_charge'];
                        $button_action      =   trim(htmlentities($_POST['action']));
                        $roletypecode             =   trim(htmlentities($_POST['roleid']));
                        $distcode           =   $_POST['sel_district'];


                        $session_details    =   $this->Mybill->session_details();
                        $session_userid     =   $session_details[0]->userid;
                        $state_code         =   $session_details[0]->statecode;
                       





                    //     //Getting form informations
                    //     $user_id            =   $this->Etransfer->killChars(trim(htmlentities($_POST['user'])));
                    //     $office_code        =   $this->Etransfer->killChars(trim(htmlentities($_POST['directorate'])));
                    //     $assign_charge      =   $_POST['assign_charge'];
                    //     $button_action        =   trim(htmlentities($_POST['action']));

                    //     $session_usertype_id     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->usertype_id)));
                    //     $session_dist_code     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->dist_code)));
                    //     $session_hud_code     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->hud_code)));
                    //     $session_user_id     =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->user_id)));
                    //     $flag                   =   'Y';



                        for ($i = 0; $i < count($assign_charge); $i++) 
                        {
                            $Basemodel = new Basemodel;
                            $Basemodel->tablename = "mybillmyright.mst_charge";
                            $charge_details = $Basemodel->getMultipleData(array('chargeid' =>  $assign_charge[$i]), 'chargeid');

                            $chargeid   =  $assign_charge[$i];
                            $roleid = $charge_details[0]->roleid;


                            // $config_code = $charge_details[0]->config_code;

                            // if( ($usertype_id == 3)  || ($usertype_id == 4) )
                            // {
                            //     if($office_code=='04')
                            //     {
                            //         $hud_code = $this->Etransfer->killChars(trim(htmlentities($_POST['hud'])));
                            //         $Basemodel->tablename = "nursecounsil.mst_hud";
                            //         $id = 'hud_name';
                            //         $del = array('hud_code' => $hud_code);
                            //         $data1 = $Basemodel->getMultipleData($del, $id);
                            //         $dist_code = $data1[0]->dist_code;
                            //     }
                            //     else
                            //         $dist_code = $this->Etransfer->killChars(trim(htmlentities($_POST['district'])));

                            //     if($usertype_id == 4)
                            //         $inst_id        =   $this->Etransfer->killChars(trim(htmlentities($_POST['institution'])));
                            // }


                            //Checking values are in correct format

                            $isvalid=true;

                            // if($this->Etransfer->is_int($user_id)!=1) $isvalid=false;
                            // if($this->Etransfer->is_int($office_code)!=1) $isvalid=false;
                            // if($this->Etransfer->is_int($charge_id)!=1) $isvalid=false;
                            // if($this->Etransfer->is_int($usertype_id)!=1) $isvalid=false;
                        

                            // if ($usertype_id == 3) 
                            // {
                            //     if($office_code=='04')
                            //     {
                            //         if($this->Etransfer->is_int($hud_code)!=1) $isvalid=false;
                            //     }
                            //     if($this->Etransfer->is_int($dist_code)!=1) $isvalid=false;
                            // }
                            // if ($usertype_id == 4) 
                            // {
                            //     if($office_code=='04')
                            //     {
                            //         if($this->Etransfer->is_int($hud_code)!=1) $isvalid=false;
                            //     }
                            
                            //     if($this->Etransfer->is_int($dist_code)!=1) $isvalid=false;
                            
                            //     if($this->Etransfer->is_int($inst_id)!=1) $isvalid=false;
                            // }


                            if(!($isvalid))
                                throw new Exception('Extra Characters','413');

                            else
                            {
                               
                                $flag = 'Y';

                                if (! ( (empty($userid))  || (empty($chargeid)) || (empty($roleid)) || (empty($session_userid)) )) 
                                {
                                      //binding data into array
                                    $data = array(
                                        'statecode'            =>  $state_code,
                                        'userid'               => $userid,
                                      
                                        'statusflag'           => $flag,
                                        'createdby'            => $session_userid,
                                        'createdon'            => 'now()',
                                        'charge_from'           => 'now()', 
                                        'chargeid'             =>  $chargeid, 
                                        'roletypecode'           =>  $roletypecode, 
                                        'roleid'                =>  $roleid
                                        // 'config_code'           =>  $config_code, 
                                    );

                                  

                                  

                                    if (($roletypecode == $this->jc_roleid)||($roletypecode ==  $this->dc_roleid) ||($roletypecode == $this->ac_roleid) ) 
                                    {
                                        $data['distcode']   =   $distcode;
                                        $data['divisioncode'] = $divisioncode;
                                        if(($roletypecode  ==   $this->dc_roleid)||($roletypecode  ==  $this->ac_roleid))
                                            $data['zonecode'] = $zonecode;
                                        if($roletypecode  ==  $this->ac_roleid)
                                            $data['circleid'] = $circleid;
                                    }
                                   
                                    
                                    if ($button_action == 'insert') 
                                    {
                                        $Basemodel = new Basemodel;
                                        $Basemodel->tablename = "mybillmyright.mst_user_charge";
                                        $check = array(
                                            'userid' => $userid,
                                            'chargeid' =>  $assign_charge[$i]
                                        );

                                        $exists = $Basemodel->getSingleData($check);

                                        if ($exists == '') //If not exists.. insert into table
                                        {
                                            $insert_success = 'Y';
                                            $Basemodel->insert($data);
                                        } 
                                        else //Otherwise display error msg as 'Already exists'
                                            throw new Exception('exists', '409');
                                    }
                                } 
                                else throw new Exception('Not Accessible', '406');
                            }
                        }

                        if ($insert_success == 'Y') 
                        {
                            $page_name  =   $_POST["page_name"];
                            if ($button_action == 'insert') 
                            {
                                if ( $page_name  == 'assign_charge') 
                                {
                                    $otp ='test123';      //generate random numbers for password
                                    $pwd = md5('test123');
                                    $Basemodel = new Basemodel;

                                    $Basemodel->tablename = "mybillmyright.mst_dept_user";
                                   
                                    $data = array('pwd'          =>   $pwd, 
                                                    'profile_update'  =>  'Y' );
                                
                                    $where = array('userid' => $userid);
                                    $updaterow = $Basemodel->update($data, $where);

                                    

                                }

                                // throw new Exception('Success', '200');

                                $Basemodel = new Basemodel;
                                $Basemodel->fnname = "mybillmyright.fn_getspecificuser_allcharges_del";
                                $getting_totalpost = array(
                                    'user_id'           =>$userid,
                                    'charge_id'         =>  0
                                );
                                $resultdata1 = $Basemodel->procedure($getting_totalpost);
                                $result = json_decode($resultdata1['fn_getspecificuser_allcharges_del'], true);

                                $assigned_charge = '';
                                $comma = "";

                                foreach ($result as $value) 
                                {
                                    $assigned_charge =  $assigned_charge . $comma . "" . htmlentities($value['roleactionlname']) . "";
                                    $comma = ",";
                                }

                                $username = $result[0]['name'];
                                $email_address = $result[0]['email'];
                                $divisionlname = $result[0]['divisionlname'];
                                $roletypelname    =   $result[0]['roletypelname'];
                                $distename    =   $result[0]['distename'];
                                $user_charge_created_on = date("d-m-Y h:i", strtotime($result[0]['usercharge_createdon']));
                                $otp    =   'test123';
                                if ($_POST["page_name"] == 'assign_charge') 
                                {
                                    $subject = 'One Time Password';

                                    $mail_body =
                                    '<b>Login Details<b> 
                                    <br> Name : ' . $username . ' 
                                    <br> Username : ' . $email_address . ' 
                                    <br> OTP (One Time Password) is <b>' . $otp;

                                    if (($roletypecode == '03') || ($roletypecode == '04') ||($roletypecode == '05')||($roletypecode == '07') )
                                    {
                                        $mail_body=$mail_body . '<br>Division : ' . $divisionlname . '</b>
                                        <br>District : ' . $distename ;
                                    }

                                    
                                    

                                    if (($roletypecode == '04') ||($roletypecode == '05')||($roletypecode == '07') )
                                    {
                                        $zonename = $result[0]['zonelname'];
                                    
                                        if(($roletypecode == '05')||($roletypecode == '07'))
                                            $circlename = $result[0]['circlename'];
                                    
                                        $mail_body=$mail_body . '<br>Zone : ' . $zonename;
                                        
                                        $mail_body  =   $mail_body;
                                        if(($roletypecode == '05')||($roletypecode == '07'))
                                            $mail_body  =   $mail_body . '<br>Circle : ' . $circlename;                            
                                    }
                                    $mail_body  =   $mail_body . '<br>Charge : ' . $assigned_charge . '  <br>Charge Assigned From : ' . $user_charge_created_on;     
                                }


                                // if ($_POST["page_name"] == 'additional_charge') 
                                // {
                                //     $subject = 'Additional Charge';
                                //     $otp    =   'test123';
                                //     $mail_body =
                                //     '<b>Login Details<b> 
                                //     <br> Name : ' . $username . ' 
                                //     <br> Username : ' . $email_address . ' 
                                //     <br> OTP (One Time Password) is <b>' . $otp . '</b>
                                //     <br>Directorate : ' . $office_name ;
                        
                                //     if (($usertype_id == 4) ||($usertype_id == 3) )
                                //     {
                                //         $dist_name = $result[0]['dist_ename'];
                                    
                                //         if($usertype_id == 4)
                                //             $inst_name = $result[0]['inst_lname'];
                                    
                                //         $hud_code   =   $result[0]['hud_name'];
                                    
                                    
                                //         $mail_body=$mail_body . '<br>District : ' . $dist_name;
                                    
                                //         if($result[0]['office_code']=='04')
                                //             $mail_body  =   $mail_body . '<br>Hud : ' . $result[0]['hud_name'];
                                        
                                //         $mail_body  =   $mail_body;
                                //         if($usertype_id=='4')
                                //             $mail_body  =   $mail_body . '<br>Institution : ' . $inst_name;                            
                                //     }
                                //     $mail_body  =   $mail_body . '<br>Charge : ' . $assigned_charge . ' - Charge Assigned From : ' . $user_charge_created_on;

                                //     // if ($result[0]['usertype_id'] == 4) 
                                //     // {
                                //     //     $dist_name = $result[0]['dist_ename'];
                                //     //     $inst_name = $result[0]['inst_lname'];
                                //     //     $mail_body =
                                //     //         '<b>Additional charge <b> 
                                //     //     <br> Name : ' . $username . ' 
                                //     //     <br> Username : ' . $email_address . ' 
                                //     //     <br>Directorate : ' . $office_name . '
                                //     //     <br>District : ' . $dist_name . '
                                //     //     <br>Institution : ' . $inst_name . '
                                //     //     <br>Charge : ' . $assigned_charge . ' - Additional Charge Assigned From : ' . $user_charge_created_on;
                                //     // }
                                //     // if ($result[0]['usertype_id'] == 3) 
                                //     // {
                                //     //         $dist_name = $result[0]['dist_ename'];
                                //     //         $mail_body =
                                //     //             '<b>Login Details<b> 
                                //     //     <br> Name : ' . $username . ' 
                                //     //     <br> Username : ' . $email_address . ' 
                                //     //     <br>Directorate : ' . $office_name . '
                                //     //     <br>District : ' . $dist_name . '
                                //     //     <br>Charge : ' . $assigned_charge . ' - Additional Charge Assigned From : ' . $user_charge_created_on;
                                //     // }
                                //     // if ($result[0]['usertype_id'] == 5)
                                //     // {
                                //     //     $mail_body =
                                //     //         '<b>Login Details<b> 
                                //     //     <br> Name : ' . $username . ' 
                                //     //     <br> Username : ' . $email_address . ' 
                                //     //     <br>Directorate : ' . $office_name . '
                                //     //     <br>Charge : ' . $assigned_charge . ' - Additional Charge Assigned From : ' . $user_charge_created_on;
                                //     // }

                                    
                                // }
                                
                                $mail = new mail;

                                $calling_mail= $mail->send_mail($email_address,$username,$subject,$mail_body);

                                
                                if (!($calling_mail))
                                {
                                     echo 'Message could not be sent.';
                                    echo 'Mailer Error: ' .  $calling_mail->ErrorInfo; 
                                    throw new Exception('Mail not sent', '424');
                                }
                                else
                                    throw new Exception('Success', '200');
                                 
                                
                            }
                        }
                    // }
                    // else throw new Exception('csrf error', '403');
                }
            }
            catch (Exception $e) 
            {
                header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }
        }
        public function edit_assign_charge()
        {
            // $csrf_check=$this->Etransfer->checkCSRF();

            try 
            {
                if(!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD']== 'post')))
                {
                    throw new Exception('Forbidden','403');
                }
                else
                {
                    // if($csrf_check==0)
                    // {
                        $valid  =   true;
                        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
                        $id =   $_POST['id'];
                        // $id=$this->Etransfer->decryption($_POST['id'],$this->Etransfer->key);
                        // $valid  =   $this->Etransfer->is_int($id);
                        if(!($valid))
                            throw new Exception('Extra Characters','413');   
                        else
                        {
                            if(!( (empty($id)) ))
                            {
                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.mst_dept_user";

                                $get_charge_data = $Basemodel->getSingleData(array(
                                    "userid" => $id
                                ));
                                if ($get_charge_data) 
                                {
                                    echo json_encode($get_charge_data);                                                                    
                                    http_response_code(200);
                                } 
                                else
                                    throw new Exception('Bad Request','400');   
                            }
                            else    throw new Exception('Not Accessible (mantatory fields is Empty)', '406'); 
                        }
                    // }
                    // else throw new Exception('csrf error', '403');
                    
                }
            }
            catch (Exception $e) 
            {
                header('HTTP/1.1 '.$e->getCode().' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }
        }

    #################################### assign_charge Function - End  #########################################

   #################################### view_usercharge Function - Start  #########################################
    
        public function usercharge_data()
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
                    // if($csrf_check==0)
                    // {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                        $isvalid    =   true;
                        
                        $user_id        =   $_SESSION['user']->userid;
                        $page_name      =   $_POST['page_name'];

                        // $action_code    =   $this->Etransfer->killChars(trim(htmlentities($this->Etransfer->get_session_actioncode_or_name('code'))));

                        // $office_code    =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->office_code)));
                        // $dist_code      =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->dist_code)));
                        // $hud_code       =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->hud_code)));
                        // $inst_id        =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->inst_id)));
                        // $usertype_id        =   $this->Etransfer->killChars(trim(htmlentities( $_SESSION['user']->usertype_id)));
                        // $user_id        =   $this->Etransfer->killChars(trim(htmlentities( $_SESSION['user']->user_id)));

                        // if($this->Etransfer->is_int($action_code)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($usertype_id)!=1) $isvalid=false;
                        // if($this->Etransfer->is_int($user_id)!=1) $isvalid=false;

                        // if(($usertype_id == 4)||($usertype_id == 3) || ($usertype_id == 5))
                        // {
                        //     if($this->Etransfer->is_int($office_code)!=1) $isvalid=false;
                        //     if(($usertype_id == 3) || ($usertype_id == 4))
                        //     {
                        //         if($office_code == '04')
                        //         {
                        //             if($this->Etransfer->is_int($hud_code)!=1) $isvalid=false;
                        //         }
                        //         if($this->Etransfer->is_int($dist_code)!=1) $isvalid=false;
                        //         if($usertype_id == 4)
                        //         {
                        //             if($this->Etransfer->is_int($inst_id)!=1) $isvalid=false;
                        //         }
                        //     }
                        // }

                        if(!($isvalid))
                            throw new Exception('Extra Characters','413');
                        else
                        {
                            if(!( (empty($user_id))  ))
                            {
                                // $Basemodel = new Basemodel;
                                // $Basemodel->tablename = "nursecounsil.mst_user";
                                // if($action_code==50)
                                //     $del=array();
                                // if($action_code==60)
                                //     $del=array('office_code'=>$office_code);           
                                // if($action_code==40)
                                //     $del=array('office_code'=>$office_code,'dist_code'=>$dist_code);
                                // if(($action_code==30)||($action_code==20)||($action_code==10))       
                                //     $del=array('office_code'=>$office_code,'dist_code'=>$dist_code,'inst_id'=>$inst_id);
                            
                                // if(($action_code==40)||($action_code==30)||($action_code==20)||($action_code==10))
                                // {
                                //     if($office_code == '04')
                                //         $hud_code=$hud_code;
                                //     else
                                //         $hud_code   =   'A';
                                // }
                                // else
                                //     $hud_code   =   'A';
                            
                        
                                // if($office_code == '')
                                //     $office_code='A';
                                // else
                                //     $office_code=$office_code;
                        
                                // if($dist_code == '')
                                //     $dist_code='A';
                                // else
                                //     $dist_code=$dist_code;
                        
                                // if($inst_id == '')
                                //     $inst_id=0;
                                // else
                                //     $inst_id=$inst_id;

                                
                                $session_details    =   $this->Mybill->session_details();
                                $session_userid         =   $session_details[0]->userid;
                                $session_roleid         =   $session_details[0]->roletypecode;
                                $session_divisioncode   =   $session_details[0]->divisioncode ;
                                $session_zonecode       =   $session_details[0]->zonecode ;
                                $session_circleid       =   $session_details[0]->circleid ;
                                $session_distcode       =   $session_details[0]->distcode ;

                                if(( $session_roleid ==  $this->nic_roleid)||($session_roleid == $this->adc_roleid))
                                {
                                    $session_divisioncode   =   'A';
                                    $session_zonecode       =   'A';
                                    $session_circleid       =   0;
                                    $session_distcode       =   'A';
                                }
                                else if(( $session_roleid ==$this->jc_roleid)||($session_roleid ==  $this->dc_roleid))
                                {
                                    if( $session_roleid == $this->jc_roleid)
                                        $session_zonecode       =   'A';
                                    $session_circleid       =   0;
                                }
        

        
                        
                                $Basemodel = new Basemodel;
                                $Basemodel->fnname = "mybillmyright.fn_assigned_usercharge_jsondata";
                                $getting_totalpost = array(
                                    'roleid'            =>  $session_roleid,
                                    'divisioncode'      =>  $session_divisioncode,
                                    'zonecode'          =>  $session_zonecode,
                                    'distcode'          =>  $session_distcode,
                                    'circleid'          =>  $session_circleid,
                                   
                                    'user_id'           =>  $user_id
                                );
                                
                                $resultdata1 = $Basemodel->procedure($getting_totalpost);
                                $data = json_decode($resultdata1['fn_assigned_usercharge_jsondata'], true);
                                http_response_code(200);
                                // $Basemodel = new Basemodel;
                                // $Basemodel->fnname = "nursecounsil.fn_get_charge_details_jsondata";
                                // $getting_totalpost = array(
                                //     'usertype_id'       =>  $_SESSION['user']->usertype_id,
                                //     'office_code'       =>  $office_code,
                                //     'dist_code'         =>  $dist_code,
                                //     'hud_code'          =>  $hud_code,
                                //     'inst_code'         =>  $inst_id,
                                //     'charge_id'         =>  $_SESSION['charge']['id']
                                // );
                                // $resultdata1 = $Basemodel->procedure($getting_totalpost);
                                // $data = json_decode($resultdata1['fn_get_charge_details_jsondata'], true);
                                // http_response_code(200);
                        
                                if($data!=null)
                                {
                                    $i = 1;?>
                                    <div class="table-responsive">
                                        <table id="datatables-basic" class="table table-bordered datatables-basic text-start" style="width:100%">
                                            <thead>
                                                <tr>
                                                <th>S.No</th>
                                                <th>Role Type</th>
                                                <th>Employee Id</th>
                                                <th>Name</th>
                                                <th>Charge Description</th>
                                                
                                                <th>Division</th>
                                                <th>District</th>
                                                <th>Zone</th>
                                                <th>Circle</th>
                                               
                                                <!-- <th>Category</th> -->
                                              
                                            <?php if($page_name=='form')
                                            {?>
                                                <th>Action</th><?php
                                            }?>
                                            
                                            
                                                    
                                                </tr>
                                            </thead>
                                            <tbody><?php      
                                                foreach ($data as $value)
                                                {
                                                    if($value['divisionlname']!='')
                                                        $division_name=$value['divisionlname'];
                                                    else
                                                        $division_name=' - ';
                                                    if($value['zonelname']!='')
                                                        $zone_name=$value['zonelname'];
                                                    else
                                                        $zone_name=' - ';

                                                    if($value['circlename']!='')
                                                        $circle_name=$value['circlename'];
                                                    else
                                                        $circle_name=' - ';
                                                    
                                                
                                                        ?> 
                                                        <tr>
                                                            <td class="text-end"><?php echo htmlentities($i); ?></td>
                                                            <td><?=htmlspecialchars($value['roletypelname']); ?></td>
                                                            <td> <?php echo htmlentities($value['name']);?></td>
                                                            <td> <?php echo htmlentities($value['empid']);?></td>
                                                            <td><?=htmlspecialchars($value['chargedescription']); ?></td>
                                                            <td ><?=htmlspecialchars($division_name); ?></td>
                                                            <td> <?php echo htmlentities($value['distename']);?></td>
                                                            <td ><?=htmlspecialchars($zone_name); ?></td>
                                                            <td ><?=htmlspecialchars($circle_name); ?></td>
                                                           
                                                         
                                                        
                                                            <?php if($page_name=='form')
                                            {?>
                                                            <td>
                                                            <center><a name="edit_charge" class="edit_charge" data-bs-toggle="tooltip" data-bs-placement="bottom" title="edit" id=<?php echo  htmlentities($value['chargeid']); ?>><i class="fa  fa-pencil editicon"  aria-hidden="true"></i></a> </center>

                                                            </td><?php
                                            }?>
                                                        </tr><?php 
                                                    $i++;
                                                }?>
                                            </tbody>
                                        </table>
                                    </div><?php
                                } 
                                else
                                    echo 0;                    
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

    #################################### view_usercharge Function - End  #########################################




  



}

?>