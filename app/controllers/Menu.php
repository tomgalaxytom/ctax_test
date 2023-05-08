<?php
class Menu extends Controller
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

    public function insert_update_menu()
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
                    $valid =   true;


                   
                    $menu_name  =   $_POST['menu'];
                    $cat_sub    =   $_POST['cat_sub'];
                    $menu_url   =   $_POST['menu_url'];
                    $key        =   $_POST['key'];
                    $status_flag    =   $_POST['status_flag'];
                    $state_code     =   '33';
                    $user_id        =   1;
                    $action         =   $_POST["action"];
                  
                    // $id = $this->Etransfer->decryption($_POST['menuid'],$this->Etransfer->key);
                    // $menu_name            =   $this->Etransfer->killChars(trim(htmlentities($_POST['menu'])));
                    // $cat_sub            =   $this->Etransfer->killChars(trim(htmlentities($_POST['cat_sub'])));
                    // $menu_url            =   $this->Etransfer->killChars(trim(htmlentities($_POST['menu_url'])));
                    // $key            =   $this->Etransfer->killChars(trim(htmlentities($_POST['key'])));
                    // $status_flag            =   $this->Etransfer->killChars(trim(htmlentities($_POST['status_flag'])));

                    // $state_code             = $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->state_code)));
                    // $user_id    =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->user_id)));
                    // $action    =   trim(htmlentities($_POST["action"]));

                    if ($status_flag == 'active') $flag = 'Y';
                    else $flag = 'N';
                    if ($cat_sub == 1)  $cat_name = 0;
                    else    $cat_name   =   $_POST['cat_name'];
                    // else    $cat_name            =   $this->Etransfer->killChars(trim(htmlentities($_POST['cat_name'])));

                    // if($this->Etransfer->has_only_letters($menu_name,'50','Y')!=1)$valid=false;
                  
                    // // if($this->Etransfer->has_only_letters($menu_url,'200','Y')!=1)$valid=false;
                    // if($this->Etransfer->has_underscore_and_letters_only($key,'30','Y')!=1)$valid=false;
                   
                    // if($this->Etransfer->is_int($cat_sub)!=1)$valid=false;
                   
                    // if ($cat_sub == 1) 
                    // {
                    //     if($this->Etransfer->is_int($cat_name)!=1)$valid=false;
                    // }
                   
                    // if($this->Etransfer->is_int($state_code)!=1)$valid=false;
                    // if($this->Etransfer->is_int($user_id)!=1)$valid=false;

                  
                    if ($action == 'update') 
                    {
                        $id =   $_POST['menuid'];
                        // if($this->Etransfer->is_int($id)!=1)$valid=false;
                    }
                    
                   

                    if(!($valid))
                        throw new Exception('Extra Characters','413');
                    else
                    {
                        if(!( (empty($menu_name)) || (empty($menu_url)) || (empty($key)) || (empty($cat_sub))  || (empty($state_code)) || (empty($user_id))))
                        {
                            
                            $Basemodel = new Basemodel;
                            $Basemodel->tablename = "mybillmyright.mst_menu";

                            $data = array(
                                // 'state_code'    => $state_code,
                                'menuname'      => $menu_name,
                                'levelid'       => $cat_sub,
                                'parentid'     => $cat_name,
                                'menuurl'       => $menu_url,
                                'key'           => $key,
                                'status'        => $flag,                    
                            );

                            $check = array(
                                'menuname' => htmlentities($menu_name),
                                'menuurl' => htmlentities($menu_url),
                            );
                            $exists = $Basemodel->getSingleData($check);

                            if ($action == 'insert') 
                            {
                                $data['createdby']=$user_id;
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
                                $data['updatedby']=$user_id;
                                $data['updatedon']='now()';

                                $check_id   =   array("menuid"=>$id);
                                $check_update_id_present_in_table   =   $Basemodel->getSingleData($check_id);
                                if($check_update_id_present_in_table!=null)
                                {
                                    $exists = $Basemodel->getSingleData($check);

                                    if ((($exists) && ($id == $exists->menuid)) || (!$exists))
                                    {
                                        $where = array(
                                            'menuid' => $id
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


    public function getting_menus_data()
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

                    $session_details    =   $this->Mybill->session_details();
                    $session_roleid         =   $session_details[0]->roletypecode;

                    // if(!($isvalid))
                    //     throw new Exception('Extra Characters','413');
                    // else
                    // {
                    //     if(!( (empty($state_tname)) || (empty($state_ename)) || (empty($state_id)) ))
                    //     {

                    //     }
                    //     else
                    //         throw new Exception('Not Accessible (mantatory fields is Empty)', '406'); 

                    // }

                    // $Basemodel = new Basemodel;
                    // $Basemodel->tablename = "mybillmyright.mst_menu";
                    // $del = array();
                    // $select = "mybillmyright.mst_menu.menuname,mybillmyright.mst_menu.menuurl,mybillmyright.mst_menu.status,mybillmyright.mst_menu.menuid";
                    // $data = array(
                    // );
                    // $id = 'menuname';
                    $status_flag = array(
                        'Y' => 'Active',
                        'N' => 'InActive'
                    );
                    // $data = $Basemodel->getMultipleJoin($select, $data, $del, $id);

                    $Basemodel  =   new Basemodel;
                    $data = $Basemodel->getmenu_data();
                   
                    http_response_code(200);


                    if($data)
                    {?>
                        <div class="table-responsive">
                            <table id="datatables-basic" class="table table-bordered datatables-basic " style="width:100%">
                                <thead>
                                    <tr>
                                        <th>S.No</th>
                                
                                        <th>Menu Name</th>
                                        <th>Category Name </th>
                                        <th>Menu Url</th>

                                        <th>Status</th>
                                        <?php  if($session_roleid  ==  $this->nic_roleid){ ?>
                                            <th>Action</th> <?php
                                        }?>
                                        
                                    </tr>
                                </thead>
                                <tbody><?php 
                                    $i = 1;

                                    foreach ($data as $value) 
                                    {
                                        if($value['category_name'])
                                            $category_name  =   $value['category_name'];
                                        else
                                            $category_name  =   ' - ';
                                        ?> 
                                        <tr>
                                            <td><?php echo htmlentities($i); ?></td>
                                            <td><?= htmlspecialchars($value['menuname']); ?></td>
                                            <td><?= htmlspecialchars($category_name); ?></td>
                                            <td><?= htmlspecialchars($value['menuurl']); ?></td>
                                            <td><?= htmlspecialchars($status_flag[$value['status']]); ?></td><?php
                                            if($session_roleid  ==  $this->nic_roleid)
                                            { ?>
                                                <td>
                                                    <center><a name="edit_privillage" class="edit_privillage" data-bs-toggle="tooltip" data-bs-placement="bottom" title="edit" id=<?php echo htmlentities($value['menuid']); ?>><i class="fa fa-pencil editicon" aria-hidden="true"></i></a> </center>
                                                </td> <?php
                                            }?>
                                        </tr><?php 
                                        $i++;
                                    }?>
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



    public function edit_menu()
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

                     $id    =   $_POST['id'];

                    // $id=$this->Etransfer->decryption($_POST['id'],$this->Etransfer->key);
                    // if($this->Etransfer->is_int($id)!=1) $isvalid=false;

                    if(!($isvalid))
                        throw new Exception('Extra Characters','413');
                    else
                    {
                        $Basemodel = new Basemodel;
                        $Basemodel->tablename = "mybillmyright.mst_menu";
                        if(!( (empty($id)) ))
                        {
                            $check_id=array("menuid"=>$id);
                            $check_update_id_present_in_table=$Basemodel->getSingleData($check_id);
                            if($check_update_id_present_in_table!=null)
                            {
                                http_response_code(200);
                                echo json_encode($check_update_id_present_in_table);
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
                                        "roleid" =>$value->roleid,
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

    function get_roletype_basedon_usertype()
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
 
                     $user_type    = $_POST['usertypecode'];
 
                     // $user_type            =   $this->Etransfer->killChars(trim(htmlentities($_POST['user_type'])));
 
                     // if($this->Etransfer->is_int($user_type)!=1) $isvalid=false;
 
                     if(!($isvalid))
                         throw new Exception('Extra Characters','413');
                     else
                     {
                         $Basemodel = new Basemodel;
                         $Basemodel->tablename = "mybillmyright.mst_roletype";
                         if(!( (empty($user_type)) ))
                         {
                             $get_data   =   $Basemodel->getMultipleData(array('usertypecode' => $user_type), 'roletypelname');
                            
                            
                             if($get_data!=null)
                             {
                                 http_response_code(200);
                                 foreach ($get_data as $value) 
                                 { 
                                     $role_data[] = array(
                                         "roletypecode" =>$value->roletypecode,
                                     // "roleid" => $this->Etransfer->encryption($value->roleid,$this->Etransfer->key),
                                         "roletypelname" => $value->roletypelname,
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

    function get_roleaction_basedon_roletype()
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
 
                     $roletype    = $_POST['roletypecode'];
 
                     // $user_type            =   $this->Etransfer->killChars(trim(htmlentities($_POST['user_type'])));
 
                     // if($this->Etransfer->is_int($user_type)!=1) $isvalid=false;
 
                     if(!($isvalid))
                         throw new Exception('Extra Characters','413');
                     else
                     {
                         $Basemodel = new Basemodel;
                         $Basemodel->tablename = "mybillmyright.mst_roleaction";
                         if(!( (empty($roletype)) ))
                         {
                             $get_data   =   $Basemodel->getMultipleData(array('roletypecode' => $roletype), 'roleactionlname');
                            
                            
                             if($get_data!=null)
                             {
                                 http_response_code(200);
                                 foreach ($get_data as $value) 
                                 { 
                                     $role_data[] = array(
                                         "roleactioncode" =>$value->roleactioncode,
                                     // "roleid" => $this->Etransfer->encryption($value->roleid,$this->Etransfer->key),
                                         "roleactionlname" => $value->roleactionlname,
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



    public function get_chargeaction_basedon_usertype()
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

                    $usertype_id    =   $_POST['usertype_id'];

                    // $usertype_id            =   $this->Etransfer->killChars(trim(htmlentities($_POST['usertype_id'])));

                    // if($this->Etransfer->is_int($usertype_id)!=1) $isvalid=false;

                    if(!($isvalid))
                        throw new Exception('Extra Characters','413');
                    else
                    {
                        $Basemodel = new Basemodel;
                        $Basemodel->tablename = "mybillmyright.mst_charge_action";
                        if(!( (empty($usertype_id)) ))
                        {
                            $get_data   =   $Basemodel->getMultipleData(array('usertype_id' => $usertype_id), 'charge_action_code');
                           
                            if($get_data!=null)
                            {
                                http_response_code(200);
                                 echo json_encode($get_data);
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








    public function editrole()
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

                    $role   =   $_POST['edit_role'];

                    // $role     =   $this->Etransfer->killChars(trim(htmlentities($this->Etransfer->decryption($_POST['edit_role'],$this->Etransfer->key))));

                    // if($this->Etransfer->is_int($role)!=1) $isvalid=false;

                    if(!($isvalid))
                        throw new Exception('Extra Characters','413');
                    else
                    {
                        if(!( (empty($role)) ))
                        {
                            $database = new database;
                            $database->query("SELECT menuname,key from mybillmyright.mst_menu_mapping
                            LEFT JOIN jsonb_array_elements_text((control_json -> '1') ) as config
                            ON TRUE
                            LEFT JOIN mybillmyright.mst_menu ON  (config) = mybillmyright.mst_menu.menuid ::text  where roleid=$role");
                            $data = $database->resultSet1();

                            if($data)
                            {
                                foreach ($data as $value) 
                                {
                                    $menunames[] = $value['key'];
                                }
                                http_response_code(200);
                                echo json_encode($menunames);
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


    public function role_data()
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

                    $show_data='Y';
                    $role_id=0;

                    if(isset($_POST['role_id']))
                    {
                        if($_POST['role_id']=='')
                        {
                            $show_data='N';
                        }
                            
                        else
                        {
                            $role_id  = $_POST['role_id'];
                            // $role_id     =   $this->Etransfer->killChars(trim(htmlentities($this->Etransfer->decryption($_POST['role_id'],$this->Etransfer->key))));
                            // if($this->Etransfer->is_int($role_id)!=1) $isvalid=false;
                        }
                    }

                    if(!($isvalid))
                        throw new Exception('Extra Characters','413');
                    else
                    {
                       
                        if($show_data=='Y')
                        {
                            $Basemodel = new Basemodel;
                            $Basemodel->fnname = "mybillmyright.fn_get_role_menu_det_jsondata";
                            $getting_totalpost = array(
                                'roleid'       =>  $role_id,
                                'menu'          =>  'N'
                            );
                            $resultdata1 = $Basemodel->procedure($getting_totalpost);
                            $result = json_decode($resultdata1['fn_get_role_menu_det_jsondata'], true);
                            http_response_code(200);
                            if($result)
                            {?>

                                <div class="table-responsive">
                                    <table id="datatables-basic" class="table table-bordered datatables-basic" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>S.No</th>
                                                <th>Role Name</th>
                                              
                                                <th>Menu Name</th>
                                            </tr>
                                        </thead>
                                        <tbody><?php 
                                            $i = 1;
                                            foreach ($result as $value)
                                            {
                                                $specific_role_id= $value['roleid'];

                                                $Basemodel = new Basemodel;
                                                $Basemodel->fnname = "mybillmyright.fn_get_role_menu_det_jsondata";
                                                $getting_totalpost = array(
                                                    'role_id'       =>  $specific_role_id,
                                                    'menu'          =>  'Y'
                                                );
                                                $resultdata2 = $Basemodel->procedure($getting_totalpost);
                                                $result1 = json_decode($resultdata2['fn_get_role_menu_det_jsondata'], true);

                                                $comma='';
                                                $menunames='';
                                                foreach($result1 as $value1)
                                                {
                                                    $menunames =  $menunames . $comma . "" .$value1['menuname'] . "";
                                                    $comma = ",";
                                                }?>
                                                <tr>
                                                    <td><?php echo htmlentities($i); ?></td>
                                                    <td><?=htmlspecialchars($value['rolesname']); ?></td>
                                                  
                                                    <td><?=htmlspecialchars($menunames); ?></td>
                                                </tr><?php 
                                                $i++;
                            
                                            }?>
                                        </tbody>
                                    </table>
                                </div><?php
                            }
                        }
                        else
                            echo 0;
                        
                       
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


    public function update_role()
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
                        $valid =   true;


                        $usertypeid    =    $_POST['usertypeid'];
                        $roleid        =   $_POST['roleid'];
                        $userid        =   1;
          
                        // $usertype_id        =   $this->Etransfer->killChars(trim(htmlentities($_POST['user_type'])));
                        // $role_id            =   $this->Etransfer->killChars(trim(htmlentities($this->Etransfer->decryption($_POST['role_short'],$this->Etransfer->key))));
                        // $user_id    =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->user_id)));

                      
                        $action    =   trim(htmlentities($_POST["action"]));
        
                        // if($this->Etransfer->is_int($usertype_id)!=1)$valid=false;
                        // if($this->Etransfer->is_int($user_id)!=1)$valid=false;
                        // if($this->Etransfer->is_int($role_id)!=1)$valid=false;

                        $Basemodel = new Basemodel;
                        $Basemodel->tablename = "mybillmyright.mst_menu_mapping";
                        $check = array(
                            'roleid' => trim($roleid)
                        );
                        $exists = $Basemodel->getSingleData($check);
    
                        if(!($valid))
                            throw new Exception('Extra Characters','413');
                        else
                        {
                            if(!( (empty($usertypeid)) || (empty($roleid)) || (empty($userid))))
                            {
                                
                                if ($action == 'update') 
                                {
                                    $usertypeid    =   $usertypeid;
                                   
                                    if ($exists) 
                                    {
                                        if ($roleid != $exists->roleid)   throw new Exception('exists', '409');
                                        else 
                                        {
                                            $Basemodel = new Basemodel;
                                            $Basemodel->tablename = "mybillmyright.mst_menu";
                                            $del = array(
                                                'levelid' => '2',
                                                'status'    =>  'Y'
                                            );
                                            $select = "mybillmyright.mst_menu.menuname,mybillmyright.mst_menu.menuurl,mybillmyright.mst_menu.status,mybillmyright.mst_menu.menuid,mybillmyright.mst_menu.parentid,mybillmyright.mst_menu.levelid,mybillmyright.mst_menu.key";
                                            $data = array();
                                            $id = 'menuname';
                                            $data = $Basemodel->getMultipleJoin($select, $data, $del, $id);
                                            $val = "[";
                                            $comma = "";
                                            foreach ($data as $value) 
                                            {
                                                if ($_POST["$value->key"] == 1) 
                                                {
                                                    $val =  $val . $comma . '"' . $value->menuid . '"';
                                                    $comma = ",";
                                                }
                                            }

                                            if($_POST['usertypeid'] == 1)
                                            $dashboard = '11';
                                        else 
                                            $dashboard = '12';
                                            $add_dashboard = $val . ',' . $dashboard ;
                                            $val = $add_dashboard . "]";
                                            $jsonb_value = '{"1": ' . $val . '}';

        
                                            
                                            $Basemodel = new Basemodel;
                                            $Basemodel->tablename = "mybillmyright.mst_menu_mapping";
                        
                                            $data = array(
                                                'control_json' =>  $jsonb_value,
                                            );
                                            $where = array(
                                                'roleid' => $roleid
                                            );
                                            $updaterow = $Basemodel->update($data, $where);
                                            if($updaterow==true)
                                                throw new Exception('Success Update', '200');
                                            else
                                                throw new Exception('Bad Request', '400');
                                        }
                                       
                                    }
                                    else    throw new Exception('Bad Request', '400');
                                }
                                    
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




  
    public function insert_update_role()
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

                    // $usertype_id    =   $_POST['user_type'];
                    $role_sname     =   $_POST['role_short'];
                    // $role_lname     =   $_POST['role_long'];
                    $usertypecode     =   $_POST['usertypecode'];
                    $roletypecode     =   $_POST['roletypecode'];
                    $roleactioncode     =   $_POST['roleactioncode'];
                    $user_id        =   1;
                    $state_code     =   '33';
                    // $action_code        =  $_POST['action_code'];


                    // $usertype_id        =   $this->Etransfer->killChars(trim(htmlentities($_POST['user_type'])));
                    // $role_sname         =   $this->Etransfer->killChars(trim(htmlentities($_POST['role_short'])));
                    // $role_lname         =   $this->Etransfer->killChars(trim(htmlentities($_POST['role_long'])));

                    // $action_code        =   $this->Etransfer->killChars(trim(htmlentities($_POST['action_code'])));
                    // $user_id            =   $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->user_id)));

                    // $state_code             = $this->Etransfer->killChars(trim(htmlentities($_SESSION['user']->state_code)));

                    $action    =   trim(htmlentities($_POST["action"]));
                 
    
                    // if($this->Etransfer->is_int($usertype_id)!=1)$valid=false;
                    // if($this->Etransfer->is_int($user_id)!=1)$valid=false;
                    // if($this->Etransfer->is_int($action_code)!=1)$valid=false;
                    // if($this->Etransfer->is_int($state_code)!=1)$valid=false;

                    // if($this->Etransfer->has_only_letters($role_sname,'50','Y')!=1)$valid=false;
                    // if($this->Etransfer->has_only_letters($role_lname,'100','Y')!=1)$valid=false;

              
                    if(!($isvalid))
                        throw new Exception('Extra Characters','413');
                    else
                    {
                        if(!( (empty($role_sname)) || (empty($roletypecode))   || (empty($user_id))  || (empty($state_code)) ))
                        {
                           
                            $Basemodel = new Basemodel;
                            $Basemodel->tablename = "mybillmyright.mst_role";
                            $flag='Y';

                            $data = array(
                                'rolesname'    =>  $role_sname,
                                // 'rolelname'   =>  $role_lname,
                                // 'usertype_id'   =>  $usertype_id,
                                // 'action_code'   =>  $action_code,
                                'status'        =>  $flag,
                                'createdby'    =>  $user_id,
                                'createdon'    =>  'now()',
                                'statecode'    =>  $state_code,
                                'usertypecode'  =>  $usertypecode,
                                'roletypecode'  =>  $roletypecode,
                                'roleactioncode'    =>  $roleactioncode
                            );

                         
                          


                            if ($action  == 'insert')
                            {
                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.mst_role";

                                $check = array(
                                    'rolesname'   =>  $role_sname,
                                    // 'action_code'   =>  $action_code,
                                );
                                $exists = $Basemodel->getSingleData($check);

                                if ($exists == '')
                                {
                                    $insert_to_role_table   =   $Basemodel->insert($data);
                                    if($insert_to_role_table)
                                    {

                                        $Basemodel = new Basemodel;
                                        $Basemodel->tablename = "mybillmyright.mst_role";

                                        $check = array(
                                            'rolesname'        =>  $role_sname,
                                            'roletypecode'  =>  $roletypecode,
                                            'roleactioncode'    =>  $roleactioncode
                                            // "rolelname"        =>  $role_lname,
                                            // 'usertype_id'       =>  $usertype_id,
                                            // 'action_code'       =>  $action_code,
                                        );
                                        $exists = $Basemodel->getSingleData($check);



                                        $role_id=$exists->roleid;
                
                                        $Basemodel = new Basemodel;
                                        $Basemodel->tablename = "mybillmyright.mst_menu";
                                        $del = array(
                                            'levelid' => '2','status'=>'Y'
                                        );
                                        $select = "mybillmyright.mst_menu.menuname,mybillmyright.mst_menu.menuurl,mybillmyright.mst_menu.status,mybillmyright.mst_menu.menuid,mybillmyright.mst_menu.parentid,mybillmyright.mst_menu.levelid,mybillmyright.mst_menu.key";
                                        $data = array();
                                        $id = 'menuname';
                                        $status_flag = array(
                                            'Y' => 'Active',
                                            'N' => 'InActive'
                                        );
                                        $data = $Basemodel->getMultipleJoin($select, $data, $del, $id);
                                        $val = "[";
                                        $comma = "";
                                        foreach ($data as $value)
                                        {
                                            if($_POST["$value->key"]==1)
                                            {
                                                $val =  $val . $comma . '"' . $value->menuid . '"';
                                                $comma = ",";
                                            }
                                        }
                                        if($_POST['usertypecode'] == 1)
                                            $dashboard = '11';
                                        else 
                                            $dashboard = '12';
                                        $add_dashboard = $val . ',' . $dashboard ;
                                        $val = $add_dashboard . "]";
                                       
                                        $jsonb_value='{"1": '.$val .'}';

                                        // print_r( $jsonb_value);
                    
                                        $Basemodel = new Basemodel;
                                        $Basemodel->tablename = "mybillmyright.mst_menu_mapping";
                                        $data = array(
                                            'roleid' => $role_id,
                                            'control_json' =>  $jsonb_value,
                                        );
                                        $insert_to_menutable    =   $Basemodel->insert($data);
                                        if($insert_to_menutable==true)
                                            throw new Exception('Success Update', '200');
                                        else
                                            throw new Exception('Bad Request', '400');
                                    }
                                    else    throw new Exception('Bad Request', '400');
                                }
                                else throw new Exception('exists', '409');
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








}
?>