<?php

class Citizen extends Controller
{

    public function __construct()
    {
        $this->Mybill = $this->controller('Mybill');
        $this->userModel = $this->model('Users');
        $this->mailModel = $this->model('mail');
        $this->Basemodel = $this->model('Basemodel');
        if (!isset($_SESSION['user'])) {
           
            header("Location: " . URLROOT . "");
        }
       
    }

    public function dashboard()
    {
        $this->view('citizen/dash');
    }
    public function mybill()
    {
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






    public function bill_upload()
    {
        $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);

        $session_details    =   $this->Mybill->session_details();
        $user_id            =   $session_details[0]->userid;
        $mobilenumber       =   $session_details[0]->mobilenumber;
        $statecode          =   $session_details[0]->statecode;
     
        $now                =   date("Y-m-d H:i:s");
        $configcode         =   '03';
        $billnumber         =   trim(htmlspecialchars($_POST['bill_number']));
                        $bill_date=$this->Mybill->change_date_time_to_database_format($_POST['bill_date'],'');

       
        $shop_name          =   trim(htmlspecialchars($_POST['shop_name']));
        $shop_dist          =   trim(htmlspecialchars($_POST['shop_dist']));
        $bill_amount        =   trim(htmlspecialchars($_POST['bill_amount']));
        $action             =   trim(htmlspecialchars($_POST['action']));
        $file_upload_status =   trim(htmlspecialchars($_POST['file_upload_status']));
        $uploadfile_count   =   count($_FILES);

 

        if ($action == 'update')   $id=$_POST['bill_update_id'];

        $check = array(
            'billnumber' =>  $billnumber,
            'billdate'=>$bill_date,
            'distcode' => $shop_dist,
            'mobilenumber'=>$mobilenumber
        );

        if($_FILES['bill_upload']['name'])
        {
         


            $dist_code   =    $shop_dist;
            $explod_bill_purchase_date  =   explode('/',$_POST['bill_date']);
            $year   =   $explod_bill_purchase_date[2];
            $month   =   $explod_bill_purchase_date[1];

            $bill_uploads = "/home/apache2438/htdocs/citizen_new/ctax/gstweb/uploads/";
          

            if(!(is_dir($bill_uploads.$year)))     // /home/apache2438/htdocs/citizen_new/ctax/gstweb/uploads/bills/2023
            mkdir($bill_uploads.$year, 0755, true);

            if(!(is_dir($bill_uploads.$year.'/'.$dist_code)))     // /home/apache2438/htdocs/citizen_new/ctax/gstweb/uploads/bills/2023/586
            mkdir($bill_uploads.$year.'/'.$dist_code, 0755, true);

            if(!(is_dir($bill_uploads. $year.'/'.$dist_code.'/'.$month)))     // /home/apache2438/htdocs/citizen_new/ctax/gstweb/uploads/bills/2023/586/02
            mkdir($bill_uploads.$year.'/'.$dist_code.'/'.$month, 0755, true);

            
            $file_uplodated_path    =   $bill_uploads. $year.'/'.$dist_code.'/'.$month.'/';


            $filename= $_FILES['bill_upload']['name'];

            $filetmpName =  md5(time() . "_" . $filename);


            $target_file    =    $file_uplodated_path . basename($filetmpName);
            $db_store_path  =   $year.'/'.$dist_code.'/'.$month.'/'.basename($filetmpName);
            if(file_exists($target_file))
            {
                echo 'ji';
            }
            else
            {
                move_uploaded_file($_FILES['bill_upload']['tmp_name'],$target_file);
                if(file_exists($target_file))
                {
                  
                    $mime_type = mime_content_type($target_file); //File Type
                    $bytes = filesize($target_file); //finding size of the file

                    if ($bytes >= 1073741824) 
                        $bytes = number_format($bytes / 1073741824, 2) . ' GB';
                    elseif ($bytes >= 1048576) 
                        $bytes = number_format($bytes / 1048576, 2) . ' MB';
                    elseif ($bytes >= 1024)
                        $bytes = number_format($bytes / 1024, 2) . ' KB';
                    elseif ($bytes > 1)
                        $bytes = $bytes . ' bytes';
                    elseif ($bytes == 1)
                        $bytes = $bytes . ' byte';
                    else
                        $bytes = '0 bytes';


                }
                

            }
          
                       
        }
  

        try 
        {
            if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) {
                throw new Exception('Forbidden', '403');
            }
            else
            {

                $Basemodel  =   new Basemodel;
                $ack_no = $Basemodel->get_acknowledgement_number($bill_date,$billnumber,$bill_amount);


                $Basemodel = new Basemodel;
                $Basemodel->tablename = "mybillmyright.billdetail";
                
                $data=[
                    'userid' =>  $user_id,
                    'configcode'=> $configcode,
                    'mobilenumber'=>$mobilenumber,
                    'billnumber' =>  $billnumber,
                    'billdate'=>$bill_date,
                    'shopname' => $shop_name,
                    'billamount' => $bill_amount,
                    'statecode' => $statecode,
                    'distcode' => $shop_dist,
                    'acknumber'=> $ack_no,
                    'uploadedby' => $user_id,
                    'uploadedon' => $now,
                    'statusflag' => 'N',
                ];

                if($_FILES['bill_upload']['name'])
                {
                     $data['filename']=$filetmpName;
                    $data['fileextension']=$extension;
                    $data['filesize']=$bytes;
                    $data['mimetype']=$mime_type;
                    $data['filepath']=$db_store_path;                }
                // print_r($data); 
                if ($action == 'insert') 
                {
                    $exists = $Basemodel->getSingleData($check);
                    if ($exists == '') 
                    {
                    $insert_fileupload = $Basemodel->insert($data);
                   
                    if ($insert_fileupload)
                    {
                        http_response_code(200);
                        // $output = 'v:'.$ack_no;
            echo json_encode(array('ack_no' => $ack_no));
                        // throw new Exception('success', '200');
                    }
                    else
                        throw new Exception('Not Inserted', '601');
                    } 
                    else
                        throw new Exception('exists', '409');

                }
                if ($action == 'update') 
                {
                    $check_id=array("billdetailid"=>$id);

                    $check_update_id_present_in_table=$Basemodel->getSingleData($check_id);

                    if($check_update_id_present_in_table!=null)
                    {
                        $exists = $Basemodel->getSingleData($check);
                        if ((($exists) && ($id == $exists->billdetailid)) || (!$exists))
                         {
                        $where = array('billdetailid' => $id);
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



            }
        
        }
        catch (Exception $e) 
        {
            header('HTTP/1.1 ' . $e->getCode() . ' Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }
    }
 
    public function bill_data()
    {
        $Basemodel = new Basemodel;
        $Basemodel->tablename = "mybillmyright.billdetail";
        $session_details =  $this->Mybill->session_details();
        $user_id    =   $session_details[0]->userid;
    
        $data = $Basemodel->getting_current_data($user_id);
            if($data){
            ?>
        
            <div class="table-responsive">
                <table id="datatables-basic" class="table table-bordered datatables-basic" style="width:100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Invoice Number</th>
                            <th>Shop Name</th>
                            <th>Shop District</th>
                            <th>Date of Purchase</th>
                            <th>Invoice Amount</th>
                            <th>invoice copy</th>
                            <th>Acknowledgement Number</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody><?php
                        $i = 1;
                        foreach ($data as $value) 
                        { ?>
                            <tr>
                                <td style="text-align:right"><?php echo htmlentities($i); ?></td>
                                <td ><?php echo htmlentities($value['billnumber']); ?></td>
                                <td ><?php echo htmlentities($value['shopname']); ?></td>
                                <td ><?php echo htmlentities($value['distename']); ?></td>
                                <td ><?php echo htmlentities(date("d-m-Y", strtotime($value['billdate']))); ?></td>
                                <td ><?php echo htmlentities($value['billamount']); ?></td>
                                <td>
                                    <a href="<?php echo 'https://rtionline.tn.gov.in/ctax/gstweb/uploads/'; ?><?php echo htmlentities($value['filepath']); ?>" target="_blank"> <?php echo $value['filename']; echo'.' ;echo $value['fileextension']; ?></a>
                                </td>
                                <td ><?php echo htmlentities($value['acknumber']); ?></td>
                                <td><?php

                                if($value['statusflag'] == 'N'){?>

                                <center><a name="edit_bill"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Edit" class="edit_bill" id=<?php echo htmlentities($value['billdetailid']); ?>><i class="fa fa-pencil   editicon"  aria-hidden="true"></i></a>
                                <a name="freeze_bill" class="freeze_bill" id=<?php echo htmlentities($value['billdetailid']); ?>><i class="fa fa-forward forward_icon"  data-bs-toggle="tooltip" data-bs-placement="bottom" title="Forward" aria-hidden="true"></i></a>
                                </center>


                                <?php     }
                                    else{?>
                                    <center>

                                        <span class="badge bg-success">Finalized</span>

                                    </center>
                                  <?php  }                               
                            
                                        ?>
                                        
                                </td>
       
                            </tr><?php
                            $i++;
                        } ?>
                    </tbody>
                </table>
            </div>
            <?php
        }else{
            echo 0;
        }
       
      
        
    }

    public function bill_data_history()
    {
        $from_date='';
        $to_date='';
        if($_POST['from_date'])
            $from_date=  ($_POST['from_date']);
        if($_POST['to_date'])
            $to_date= ($_POST['to_date']);



        $Basemodel = new Basemodel;
        $Basemodel->tablename = "mybillmyright.billdetail";
        $session_details = $this->Mybill->session_details();
        $user_id    =   $session_details[0]->userid;
        $flag= 'Y';
       
            if(($from_date)&&($to_date))
            {
                $data = $Basemodel->get_bill_history_from_to($user_id,$flag,$from_date,$to_date);

            }
            else
            {
                $data = $Basemodel->getting_last_3m_data($user_id,$flag);
            }

       
            if($data){
            ?>
        
            <div class="table-responsive">
                <table id="datatables-basic" class="table table-bordered datatables-basic" style="width:100%">
                    <thead>
                        <tr>
                            <th>S.No</th>
                            <th>Invoice Number</th>
                            <th>Shop Name</th>
                            <th>Shop District</th>
                            <th>Date of Purchase</th>
                            <th>Invoice Amount</th>
                            <th>invoice copy</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody><?php
                        $i = 1;
                        foreach ($data as $value) 
                        { 
                            ?>
                            <tr>
                                <td style="text-align:right"><?php echo htmlentities($i); ?></td>
                                <td ><?php echo htmlentities($value['billnumber']); ?></td>
                                <td ><?php echo htmlentities($value['shopname']); ?></td>
                                <td ><?php echo htmlentities($value['distename']); ?></td>
                                <td ><?php echo htmlentities(date("d-m-Y", strtotime($value['billdate']))); ?></td>
                                <td ><?php echo htmlentities($value['billamount']); ?></td>
                                <td>
                                    <a href="<?php echo htmlentities(URLROOT); ?><?php echo htmlentities($value['filepath']); ?>" target="_blank"> <?php echo $value['filename']; echo'.' ;echo $value['fileextension']; ?></a>
                                </td>
                                <td><?php

                                if($value['statusflag'] == 'Y'){?>

        <center>

        <span class="badge bg-success">Finalise</span>

        </center>

                                <?php     }
                                    else{?>
                                  
                                  <?php  }                               
                            
                                        ?>
                                        
                                </td>
       
                            </tr><?php
                            $i++;
                        } ?>
                    </tbody>
                </table>
            </div>
            <?php
        }else{
            echo 0;
        }
       
      
        
    }


    public function edit_bill()
    {
        $id = $_POST['id'];
        $Basemodel = new Basemodel;
        $Basemodel->tablename = "mybillmyright.billdetail";
    
            $updatebill = $Basemodel->getSingleData(array(
                "billdetailid" => $id
            ));
            if (!$updatebill) {
                header("Location: " . URLROOT . "Pages");
            }
            echo json_encode($updatebill);
        
    }

     public function getting_config_details()
     {
        $dist= $_POST['dist'];
        try {
            if (!(($_SERVER['REQUEST_METHOD'] == 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post'))) {
                throw new Exception('Forbidden', '403');
            } else {
                $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
              
              
                $Basemodel = new Basemodel;
                $Basemodel->tablename = "mybillmyright.mst_config";

                $del = array(
                    'distcode' => $dist
                );
                $id = 'configid';
                $data1 = ($Basemodel->getMultipleData($del, $id));
                echo json_encode($data1);
            }
        } catch (Exception $e) {
            header('HTTP/1.1 ' . $e->getCode() . 'Internal Server Booboo');
            header('Content-Type: application/json');
            echo json_encode(array('message' => $e->getMessage(), 'code' => $e->getCode()));
        }
    
    
    }

    public function forward_billdata()
    {
        try 
        {
            if(!(($_SERVER['REQUEST_METHOD']== 'POST') || ($_SERVER['REQUEST_METHOD'] == 'post')))
            {
                throw new Exception('Forbidden','403');
            }
            else
            {
              
                    $_POST  = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);

                    $id = htmlspecialchars($_POST['id']);

                   
                        if(!( (empty($id)) ))
                        {
                            $Basemodel = new Basemodel;
                            $Basemodel->tablename = "mybillmyright.billdetail";
                            $get_bill_data = $Basemodel->getSingleData(array(
                                "billdetailid" => $id
                            ));
                            if($get_bill_data)
                            {
                                $Basemodel = new Basemodel;
                                $Basemodel->tablename = "mybillmyright.billdetail";
                                $data = array(
                                    'statusflag' => trim('Y'),
                                );
                                $where = array(
                                    'billdetailid' => $id,
                                );
                                $updaterow = $Basemodel->update($data, $where);

                                if($updaterow)
                                    throw new Exception('Sucess', '200'); 
                                else
                                    throw new Exception('Bad Request', '400');
                            }
                            else
                                throw new Exception('id not present', '404');                           
                        }
                        else
                            throw new Exception('Not Accessible (mantatory fields is Empty)', '406'); 
                  
                    throw new Exception('csrf error', '403');
        
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


  

