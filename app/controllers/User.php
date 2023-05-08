<?php
class User extends Controller
{

    public function __construct()
    {
        $this->userModel = $this->model('Users');
        $this->mailModel = $this->model('mail');
        $this->Basemodel = $this->model('Basemodel');
    }


    public function login()
    {
        $this->view('web/login');
    }
    public function dept_login()
    {
        $this->view('web/dept_login');
    }

    

    public function validate_login()
    {
        try 
        {
            if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) 
                throw new Exception('Forbidden', '403');
            else 
            {
                $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
               
                $password = base64_decode($_POST["password"]);
                $page = $_POST["page"];



                $Basemodel = new Basemodel;
                if( $page == 'citizen_login')
                {
                    $mobilenumber = base64_decode($_POST["username"]);
                    $Basemodel->tablename="mybillmyright.mst_user";
                    $status=array("mobilenumber"=>$mobilenumber,"pwd"=>$password);

                }
                if( $page == 'dept_login') 
                {
                    $email_id = base64_decode($_POST["email_id"]);
                    $Basemodel->tablename="mybillmyright.mst_dept_user";
                    $status=array("email"=>$email_id,"pwd"=>$password);
                }
                  
               
              
                $data=$Basemodel->getSingleData($status);

                if($data)
                {
                    $_SESSION['user'] = $data;
                  
                    $now = date("Y-m-d H:i:s");
                    $data = [
                        'userid' =>$_SESSION['user']->userid ,
                        'mobilenumber'=>$_SESSION['user']->mobilenumber,
                        'ipaddress' =>  $this->get_client_ip(),
                        'deviceid' => 'W',
                        'logintime' => $now,
                        'logoutstatus' => '1'

                    ];
                    $Basemodel = new Basemodel;
                    $Basemodel->tablename = "mybillmyright.mst_userlogindetail";
                    $userid = $Basemodel->insert($data);
                    if($page == 'dept_login') 
                    {
                        $Basemodel = new Basemodel;
                        $_SESSION['charge']['id']   =  $Basemodel->getdefaultcharge();
                       
                        $_SESSION['charge']['data']=$Basemodel->role_permission($_SESSION['charge']['id']);

                     
                    }
                    if( $page == 'citizen_login')
                    {
                        
                        $Basemodel = new Basemodel;
                        $_SESSION['charge']['id']   =  $Basemodel->getdefaultcharge_citizen();
                        $_SESSION['charge']['data']=$Basemodel->role_permission($_SESSION['charge']['id']);
                       
                    }

                    
                   
                    throw new Exception('success','200');

                }
                else     throw new Exception('Invalid login','401');
            }
        } 
        catch (Exception $e) 
        {
            header('HTTP/1.1 ' . $e->getCode() . ' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }
    }

    public function register()
    {
        try 
        {
            if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) 
                throw new Exception('Forbidden', '403');
            else 
            {
                $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);

                $Basemodel = new Basemodel;
                $Basemodel->tablename = "mybillmyright.mst_role";

                $check = array(
                    'roletypecode'   =>  '06',
                );
                $exists = $Basemodel->getSingleData($check);

                $roleid =   $exists->roleid;

                
                $Basemodel = new Basemodel;
                $Basemodel->tablename = "mybillmyright.mst_charge";

                $check = array(
                    'roletypecode'   =>  '06',
                );
                $exists = $Basemodel->getSingleData($check);

                $chargeid =   $exists->chargeid;


                $now = date("Y-m-d H:i:s");
                $mobilenumber = base64_decode($_POST["mobilenumber"]);
                $name = trim(htmlentities($_POST["name"]));
                $dist =  trim(htmlentities($_POST["distcode"]));
                $device =  trim(htmlentities($_POST["deviceid"]));
                $data = [
                    'mobilenumber' => $mobilenumber,
                    'name' => $name,
                    'pwd' =>  $_POST["pwd"],
                    'email' => base64_decode($_POST["email"]),
                    'distcode' => $dist,
                    'deviceid' => $device,
                    'ipaddress' => $this->get_client_ip(),
                    'createdon' => $now,
                    'updatedon' => $now,
                    'createdby' => 1,
                    'updatedby' => 1,
                    'chargeid' =>  $chargeid,
                    'roleid'    =>  $roleid,
                    'roletypecode'  =>  '06'
                ];
                $Basemodel = new Basemodel;
                $Basemodel->tablename = "mybillmyright.mst_user";
                $check = array(
                    'mobilenumber' => trim($mobilenumber),
                );
                $exists = $Basemodel->getSingleData($check);    //Checking password 
                if ($exists) 
                    throw new Exception('Already Exists','406');
                else 
                {
                    $Basemodel = new Basemodel;
                    $Basemodel->tablename = "mybillmyright.mst_user";
                    $userid = $Basemodel->insert($data);
                    throw new Exception('Success','200');
                }
            }
        } 
        catch (Exception $e) 
        {
            header('HTTP/1.1 ' . $e->getCode() . ' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }
    }

    public function get_client_ip() 
    {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }


    
}
