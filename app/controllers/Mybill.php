<?php


class Mybill extends Controller
{

    public function __construct()
    {

        
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



        $this->nic_roleid   =   '01';
        $this->adc_roleid	=	'02';
        $this->jc_roleid	=	'03';
        $this->dc_roleid	=	'04';
        $this->ac_roleid	=	'05';

        $this->nic_roletypecode   =   '01';
        $this->adc_roletypecode	=	'02';
        $this->jc_roletypecode	=	'03';
        $this->dc_roletypecode	=	'04';
        $this->ac_roletypecode	=	'05';
        $this->citizen_roletypecode    =   '06';
   $this->cto_roletypecode    =   '07';
      
       
    }

     /*################################### --- View - Menu --- ###################################*/
     
        public function menu()
        {
            $this->view('menus/menu');
        }

        public function role()
        {
            $this->view('menus/role');
        }
    
        public function manage_role()
        {
            // $this->validpermission($this->permissionID());
            $this->view('menus/managerole');
        }

    /*################################### --- View - Menu --- ###################################*/


    /*################################### --- View - Citizen --- ###################################*/

        public function citizen_dashboard()
        {
            $this->view('citizen/dash');
        }


 public function bill_status()
        {
            $this->view('citizen/bill_status');
        }

        public function dashboard()
        {
            $this->view('department/dashboard');
        }
        public function mybill()
        {
            //$this->validpermission($this->permissionID());
            $this->view('citizen/bill');
        }
        public function bill_history()
        {
            $this->view('citizen/bill_history');
        }
        public function profile()
        {
            $this->view('citizen/profile');
        }
        public function change_password()
        {
            $this->view('citizen/change_password');
        }

    /*################################### --- View - Citizen --- ###################################*/



    ################################ view - user_management - Start ###############################

        public function create_user()
        {
            $this->validpermission($this->permissionID());
            $this->view('user_management/mst_create_user');
        }
        public function view_user()
        {
            // $this->validpermission($this->permissionID());
            $this->view('user_management/view_dept_user');
        }
        public function create_charge()
        {
            $this->validpermission($this->permissionID());
            $this->view('user_management/create_charge');
        }
        public function view_charge()
        {
            // $this->validpermission($this->permissionID());
            $this->view('user_management/view_charge');
        }
  public function view_usercharge()
        {
            // $this->validpermission($this->permissionID());
            $this->view('user_management/view_usercharge');
        }
        public function assign_charge()
        {
            $this->validpermission($this->permissionID());
            $this->view('user_management/assign_charge');
        }
        public function additional_charge()
        {
            $this->validpermission($this->permissionID());
            $this->view('user_management/additional_charge');
        }

        public function unassign_charge()
        {
            $this->validpermission($this->permissionID());
            $this->view('user_management/unassign_charge');
        }


    ################################ view_user_management - End ###############################


    ################################ view - Configuration - Start ###############################

  ################################ view - Configuration - Start ###############################

      public function configuration_settings()
      {
        //   $this->validpermission($this->permissionID());
          $this->view('configuration/settings');
      }

      public function update_nodal()
      {
        //   $this->validpermission($this->permissionID());
          $this->view('configuration/update_nodal_person');
      }


      

    ################################ view - Configuration - Start ###############################


    ################################ view - Configuration - Start ###############################


    ############################## Permission Functions - Start ###############################################
        public function permissionID()
        {
            // echo 'permission';
            $url = $_SERVER ['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
            // $url = $_SERVER['SERVER_NAME’] . $_SERVER['REQUEST_URI'];
        
            $final = explode("/", $url);
            $final = $final[3];
            $url = $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

        
            $local = URLROOT;
            $final = explode("//", $url);
            $final = explode("?", $url);
            $final1 = explode("//", $local);
            $furl = explode($final1[1], $final[0]);
            $Basemodel = new Basemodel;
            $Basemodel->tablename = "mybillmyright.mst_menu";
            $id = 'menuname';
            $status = array(
                'menuurl' => $furl[1]
            );
            $data = ($Basemodel->getMultipleData($status, $id));
            foreach ($data as $value) {
            }
            $this->active_page_code =   $value->page_code;
            return $value->menuid;
        }



        private function validpermission($page)
        {
            $Basemodel = new Basemodel;

            if (!$Basemodel->userpermission($page))
            {
                header("Location: " . URLROOT . "");
            }
            else
            {
                $this->getting_active_menuname($page);
                // $Basemodel = new Basemodel;
                // $Basemodel->tablename = "nursecounsil.mst_menuitems";
                // $id = 'menuname';
                // $status = array(
                //     'menuid' => $page
                // );
                // $data = ($Basemodel->getMultipleData($status, $id));
            
                // $active_menu=$page;
                // echo $active_menu;
            }
        }

        // public function setcharge()
        // {
        //     if (!empty($_REQUEST['change_charge'])) {
        //         $userid = $_SESSION['user']->userid;
        //         $Basemodel = new Basemodel;

        //         if($_SESSION['user']->role==    10)
        //         $Basemodel->tablename = "mybillmyright.mst_user";
        //         else

        //         $Basemodel->tablename = "mybillmyright.mst_user_charge";
        //         $del = array(
        //             'userid' => $userid,
        //             'chargeid' => $_REQUEST['change_charge']
        //         );
        //         $id = 'charge_id';
        //         $data = $Basemodel->getMultipleData($del, $id);
        //         if (!empty($data)) {
        //             $_SESSION['charge']['id'] = $_REQUEST['change_charge'];
        //             $rolepermission = $Basemodel->role_permission($_SESSION['charge']['id']);
        //             $_SESSION['charge']['data'] = $rolepermission;

        //         }
        //         // header("Location: " . URLROOT . "Etransfer/dashboard");
        //     }
        

        // }

        public function getting_active_menuname($set_activemenu)
        {
            if($set_activemenu=='get')
            {
                return $this->active_menu;
            }
            else
            {
                $this->active_menu=$set_activemenu;
            }   
        }


    ############################## Permission Functions - End ###############################################




    /*################################### --- Common Function --- ###################################*/
	function change_date_time_to_database_format($date_time, $with_time)
        {
            $date_time = explode(' ', ltrim($date_time));
            $date = strtr($date_time[0], '/', '-');
            $date = date("Y-m-d", strtotime($date));

            // 2022-06-15 17:00:00
            if ($with_time == 'Y') {
                $time = date("H:i:s", strtotime($date_time[1] . $date_time[2]));
                $date = $date . " " . $time;
            }
            return ($date);
        }

        public function session_details()
        {

            $userid = $_SESSION['user']->userid;

            $Basemodel = new Basemodel;
            if($_SESSION['user']->roletypecode == $this->citizen_roletypecode)
            {
                $Basemodel->tablename = "mybillmyright.mst_user";
            }
            else
        

            $Basemodel->tablename = "mybillmyright.mst_dept_user";
            $del = array(
                'userid' => $userid
            );
            $id = 'userid';
            $data1 = ($Basemodel->getMultipleData($del, $id));
            return $data1;
        }

        public function logout()
        {
            $session_details = $this->session_details();
            $user_id    =    $session_details[0]->userid;
            session_destroy();
            $Basemodel = new Basemodel;
            $Basemodel->tablename = "mybillmyright.mst_userlogindetail";
            $data = array('logouttime' => 'now()', 'logoutstatus' =>  '0');
            $where = array(
                'userid' => $user_id,
            );
            $insert =  $Basemodel->update($data, $where);
            header("Location: " . URLROOT);
        }

    

        
        public function check_profile_update()
        {
            // $csrf_check=$this->checkCSRF();

            try {
                if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) {
                    throw new Exception('Forbidden', '403');
                } else {
                    // if($csrf_check==0)
                    // {
                    $isvalid    =   true;
                    $session_details = $this->session_details();
                    $user_id    =  $session_details[0]->userid;

                    // if($this->is_int($user_id)!=1) $isvalid=false;

                    // if(!($isvalid))
                    //     throw new Exception('Extra Characters','413');
                    // else
                    // {
                    $Basemodel = new Basemodel;
                    $Basemodel->tablename = "mybillmyright.mst_user";
                    $del = array(
                        'userid' => $user_id
                    );
                    $id = 'userid';
                    $data1 = ($Basemodel->getMultipleData($del, $id));
                    if ($data1) {
                        http_response_code(200);
                        echo json_encode($data1[0]->profile_update);
                    } else
                        throw new Exception('Bad Request', '400');
                    //}                                                         
                    // }
                    // else
                    //     throw new Exception('csrf error', '403');
                }
            } catch (Exception $e) {
                header('HTTP/1.1 ' . $e->getCode() . ' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }
        }

        public function updating_profile()
        {
            // $csrf_check=$this->checkCSRF();

            try {
                if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) {
                    throw new Exception('Forbidden', '403');
                } else {
                    $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                    $isvalid    =   true;
                
                    $session_details = $this->session_details();
                    
                    $user_id    =    $session_details[0]->userid;
                    if ($_POST['page'] == 'profile_update') {
                        $address1    =   trim(htmlentities($_POST["add1"]));
                        $address2    =   trim(htmlentities($_POST["add2"]));
                        $pincode    =   trim(htmlentities($_POST["pincode"]));
                    } else {
                        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
                        $user_id    =   $session_details[0]->userid;
                        $address1    =   trim(htmlentities($_POST["address1"]));
                        $address2    =   trim(htmlentities($_POST["address2"]));
                        $pincode    =   trim(htmlentities($_POST["pincode"]));
                    }
                    $Basemodel = new Basemodel;
                    $Basemodel->tablename = "mybillmyright.mst_user";
                    $del = array(
                        'userid' => $user_id
                    );
                    $id = 'userid';
                    $data1 = ($Basemodel->getMultipleData($del, $id));
                    if ($data1) {
                        $Basemodel = new Basemodel;
                        $Basemodel->tablename = "mybillmyright.mst_userlog";
                        $del = array(
                            'userid' => $user_id
                        );
                        $id = 'userid';
                    
                            $Basemodel = new Basemodel;
                            $Basemodel->tablename = "mybillmyright.mst_userlog";
                            $del = array(
                                'userid'        =>  $user_id,
                                'schemecode'    =>  $data1[0]->schemecode,
                                'email'         =>  $data1[0]->email,
                                'pwd'           =>  $data1[0]->pwd,
                                'name'          =>  $data1[0]->name,
                                'mobilenumber'  =>  $data1[0]->mobilenumber,
                                'statecode'     =>  $data1[0]->statecode,
                                'distcode'      =>  $data1[0]->distcode,
                                'ipaddress'     =>  $data1[0]->ipaddress,
                                'deviceid'      =>  $data1[0]->deviceid,
                                'createdby'     =>  $data1[0]->createdby,
                                'createdon'     =>  $data1[0]->createdon,
                                'updatedby'     =>  $data1[0]->updatedby,
                                'updatedon'     =>  $data1[0]->updatedon,
                                'statusflag'    =>  1,
                            );
                            $insert_mst_userlog = $Basemodel->insert($del);
                            if ($insert_mst_userlog) {
                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.mst_user";
                                $data = array('addr1' => $address1, 'addr2' =>  $address2, 'pincode' => $pincode, 'profile_update' => 'Y', 'updatedon' => 'now()', 'updatedby' => $user_id);
                                $where = array(
                                    'userid' => $user_id,
                                );
                                $updaterow = $Basemodel->update($data, $where);
                                if ($updaterow)
                                    throw new Exception('success', '200');
                                else
                                    throw new Exception('prb in mst_user updation ', '601');
                            } else throw new Exception('prb in insert into mst_userlog ', '602');
                        
                    } else
                        throw new Exception('Bad Request', '400');
                    //}                                                         
                    // }
                    // else
                    //     throw new Exception('csrf error', '403');
                }
            } catch (Exception $e) {
                header('HTTP/1.1 ' . $e->getCode() . ' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }
        }


        public function get_distcode_basedon_selection()
        {
            // $csrf_check=$this->checkCSRF();

            try {
                if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) 
                {
                    throw new Exception('Forbidden', '403');
                } 
                else 
                {
                    // if($csrf_check==0)
                    // {
                    $isvalid    =   true;
                    $session_details = $this->session_details();
                    $user_id    =  $session_details[0]->userid;

                    $roleid     =   $_POST['roleid'];

                    $del    =   [];

                    if(($roleid==$this->jc_roleid)||($roleid==$this->dc_roleid)||($roleid==$this->ac_roleid)||($roleid==$this->cto_roletypecode))
                    {
                        $del ['divisioncode']   =   $_POST['divisioncode'];
                        // $divisioncode   =    $_POST['divisioncode'];
                        if(($roleid==$this->dc_roleid)||($roleid==$this->ac_roleid)||($roleid==$this->cto_roletypecode))
                        {
                            $del ['zonecode']   =   $_POST['zonecode'];
                            // $zonecode   =    $_POST['zonecode'];
                            if(($roleid==$this->ac_roleid)||($roleid==$this->cto_roletypecode))
                            {
                                $del ['circleid']   =   $_POST['circlecode'];
                                // $circlecode   =    $_POST['circlecode'];
                            }
                        }
                    }

                  



                    // if($this->is_int($user_id)!=1) $isvalid=false;

                    // if(!($isvalid))
                    //     throw new Exception('Extra Characters','413');
                    // else
                    // {


                    
                        $Basemodel = new Basemodel;
                        $Basemodel->tablename = "mybillmyright.mst_circle";
                                
                        $select = "mybillmyright.mst_circle.distcode";
                        $data=  array();
                        $alias = 'mybillmyright.mst_circle';
                        $id = 'divisioncode';
                        $where_alias='mybillmyright.mst_circle';
                        $order_by = 'ASC';
                        $distinct_name='mybillmyright.mst_circle.divisioncode';
                        $data = ($Basemodel->getMultipleJoin_distinctdata_alias($select, $data, $del, $id, $distinct_name, $where_alias, $alias,$order_by));
                        if ($data) 
                        {
                            http_response_code(200);
                            echo json_encode($data[0]->distcode);
                        } 
                        else
                            throw new Exception('Bad Request', '400');
                    //}                                                         
                    // }
                    // else
                    //     throw new Exception('csrf error', '403');
                }
            } catch (Exception $e) {
                header('HTTP/1.1 ' . $e->getCode() . ' Internal Server Booboo');
                header('Content-Type: application/json');
                echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
            }
        }


        public function get_divisiondata_basedon_roletype()
        {
            try {
                if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) 
                {
                    throw new Exception('Forbidden', '403');
                } 
                else 
                {
                    // if($csrf_check==0)
                    // {
                        $isvalid    =   true;
                        $roletypecode   =   $_POST['roletypecode'];

                        // if($this->is_int($user_id)!=1) $isvalid=false;

                        // if(!($isvalid))
                        //     throw new Exception('Extra Characters','413');
                        // else
                        // {

                            if(($roletypecode=='05')||($roletypecode=='07'))
                            {
                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.mst_circle";
                                $del = array(
                                    "roletypecode" => $roletypecode
                                );
                                        
                                $select = "mybillmyright.mst_circle.divisioncode,mybillmyright.mst_division.divisionlname";
                                $data=  array(
                                    'mybillmyright.mst_division' => "mybillmyright.mst_division.divisioncode = mybillmyright.mst_circle.divisioncode",
                                );
                                $alias = 'mybillmyright.mst_circle';
                                $id = 'divisioncode';
                                $where_alias='mybillmyright.mst_circle';
                                $order_by = 'ASC';
                                $distinct_name='mybillmyright.mst_circle.divisioncode';
                                $data = ($Basemodel->getMultipleJoin_distinctdata_alias($select, $data, $del, $id, $distinct_name, $where_alias, $alias,$order_by));
                                // print_r($data);
                            }
                            else
                            {
                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.mst_division";
                                $id = 'divisionlname';
                                $data = ($Basemodel->getMultipleData(array('statusflag' => 'Y'), $id));
                            }


                           
                        
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



        public function get_zonedata_basedon_division()
        {
            try {
                if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) 
                {
                    throw new Exception('Forbidden', '403');
                } 
                else 
                {
                    // if($csrf_check==0)
                    // {
                        $isvalid    =   true;
                        $divisioncode   =   $_POST['divisioncode'];

                        $roletypecode   =   $_POST['roletypecode'];

                        // if($this->is_int($user_id)!=1) $isvalid=false;

                        // if(!($isvalid))
                        //     throw new Exception('Extra Characters','413');
                        // else
                        // {

                            
            

                            if(($roletypecode == $this->ac_roletypecode)||($roletypecode == $this->cto_roletypecode))
                            {
                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.mst_circle";
                                $del = array(
                                    "divisioncode" => $divisioncode,
                                    "roletypecode" => $roletypecode
                                );
                                        
                                $select = "mybillmyright.mst_circle.zonecode,mybillmyright.mst_zone.zonelname";
                                $data=  array(
                                    'mybillmyright.mst_zone' => "mybillmyright.mst_zone.zonecode = mybillmyright.mst_circle.zonecode",
                                );
                                $alias = 'mybillmyright.mst_circle';
                                $id = 'divisioncode';
                                $where_alias='mybillmyright.mst_circle';
                                $order_by = 'ASC';
                                $distinct_name='mybillmyright.mst_circle.divisioncode';
                                $data = ($Basemodel->getMultipleJoin_distinctdata_alias($select, $data, $del, $id, $distinct_name, $where_alias, $alias,$order_by));
    
                            }
                            else
                            {
                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.mst_circle";
                                $del = array(
                                    "divisioncode" => $divisioncode
                                );
                                        
                                $select = "mybillmyright.mst_circle.zonecode,mybillmyright.mst_zone.zonelname";
                                $data=  array(
                                    'mybillmyright.mst_zone' => "mybillmyright.mst_zone.zonecode = mybillmyright.mst_circle.zonecode",
                                );
                                $alias = 'mybillmyright.mst_circle';
                                $id = 'divisioncode';
                                $where_alias='mybillmyright.mst_circle';
                                $order_by = 'ASC';
                                $distinct_name='mybillmyright.mst_circle.divisioncode';
                                $data = ($Basemodel->getMultipleJoin_distinctdata_alias($select, $data, $del, $id, $distinct_name, $where_alias, $alias,$order_by));
    
                            
                            }

                         
                        
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



        public function get_circledata_basedon_division_zone()
        {
            try {
                if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) 
                {
                    throw new Exception('Forbidden', '403');
                } 
                else 
                {
                    // if($csrf_check==0)
                    // {
                        $isvalid    =   true;
                        $divisioncode   =   $_POST['divisioncode'];
                        $zonecode       =   $_POST['zonecode'];
                        $roletypecode   =   $_POST['roletypecode'];


                        // if($this->is_int($user_id)!=1) $isvalid=false;

                        // if(!($isvalid))
                        //     throw new Exception('Extra Characters','413');
                        // else
                        // {



                            
                         
                            $Basemodel = new Basemodel;
                            $Basemodel->tablename = "mybillmyright.mst_circle";
                            $del = array(
                                "divisioncode" => $divisioncode,
                                "zonecode"      =>  $zonecode,
                                "roletypecode" => $roletypecode
                            );
                            $select = "mybillmyright.mst_circle.circleid,mybillmyright.mst_circle.circlename";
                            $data = array(               
                            );
                            $id = 'circleid';
                            $alias = 'mybillmyright.mst_circle';
                            $order_by = 'ASC';
                    
                            $data = $Basemodel->getMultipleJoin_query($select, $data, $del, $id, $alias, $order_by);
            

                            

                        
                        
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
     


    /*################################### --- Common Function --- ###################################*/



  /*################################### --- Dashboard Function start --- ###################################*/
     
               public function invoice_count()
               {
                $Basemodel = new Basemodel;
            $Basemodel->fnname = "mybillmyright.fn_get_dashboardabstract_citizendet";

            $roletypecode = $_SESSION['user']->roletypecode;
            $divisioncode = $_SESSION['user']->divisioncode;
            $distcode = $_SESSION['user']->distcode;
            $zonecode = $_SESSION['user']->zonecode;
            $circleid = $_SESSION['user']->circleid;
            if ($divisioncode == Null or '')  $divisioncode = 'A';
            if ($distcode == Null or '')  $distcode = 'A';
            if ($zonecode == Null or '')  $zonecode = 'A';
            if ($circleid == Null or '')  $circleid = 0;
               $getting_invoice_count = array(
               'roletype' => $roletypecode,
               'division' =>$divisioncode,
               'dist' => $distcode,
               'zone' =>$zonecode ,
               'circle' => $circleid
            );           
            $resultdata1 = $Basemodel->procedure($getting_invoice_count);
            $result = json_decode($resultdata1['fn_get_dashboardabstract_citizendet'], true);
            return $result;

        }


        public function user_count()
               {
                $Basemodel = new Basemodel;
            $Basemodel->fnname = "mybillmyright.fn_get_dashboardabstract_deptuser";

            $roletypecode = $_SESSION['user']->roletypecode;
            $divisioncode = $_SESSION['user']->divisioncode;
            $distcode = $_SESSION['user']->distcode;
            $zonecode = $_SESSION['user']->zonecode;
            $circleid = $_SESSION['user']->circleid;
            
            if ($divisioncode == Null or '')  $divisioncode = 'A';
            if ($distcode == Null or '')  $distcode = 'A';
            if ($zonecode == Null or '')  $zonecode = 'A';
            if ($circleid == Null or '')  $circleid = 0;
               $getting_invoice_count = array(
               'roletype' => $roletypecode,
               'division' =>$divisioncode,
               'dist' => $distcode,
               'zone' =>$zonecode ,
               'circle' => $circleid
            );           
            $resultdata1 = $Basemodel->procedure($getting_invoice_count);
            $result = json_decode($resultdata1['fn_get_dashboardabstract_deptuser'], true);
            return $result;

        }
                 
    /*################################### --- Dashboard Function End --- ###################################*/














         /**
         *  Author: Stalin Thomas
         * 
         * Content : Allotment Module
         * 
         * Date  : 05-05-2023
         * 
         * 
         */
        public function selection_allotment()
        {
            //$this->validpermission($this->permissionID());
            $this->view('allotment/selectionallotment');
        }

        public function verify_allotment()
        {
            //$this->validpermission($this->permissionID());
            $this->view('allotment/verifyallotment');
        }
        public function test_allotment()
        {
            //$this->validpermission($this->permissionID());
            $this->view('allotment/testallotment');
        }

        public function allotment_tab()
        {
            //$this->validpermission($this->permissionID());
            $this->view('allotment/tab');
        }
         /**
         *  Author: Stalin Thomas
         * 
         * Content : Allotment Module
         * 
         * Date  : 05-05-2023
         * 
         * 
         */




}