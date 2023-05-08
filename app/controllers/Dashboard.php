<?php

class Dashboard extends Controller
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


    public function dashboardreport()
    {
        $session_details            =   $this->Mybill->session_details();
        $session_roletypecode       =   $session_details[0]->roletypecode;
        $session_divisioncode       =   $session_details[0]->divisioncode ;
        $session_zonecode           =   $session_details[0]->zonecode ;
        $session_circleid           =   $session_details[0]->circleid ;
        $session_distcode           =   $session_details[0]->distcode ;

        $getting_data   =   $_POST['action'];


        if($session_divisioncode == '') $session_divisioncode='A';
        if($session_zonecode == '')     $session_zonecode='A';
        if($session_distcode == '')     $session_distcode='A';
        if($session_circleid == '')     $session_circleid=0;





        $Basemodel = new Basemodel;
        $Basemodel->fnname = "mybillmyright.fn_get_dashboarddescription_deptuser";
        $getting_totalpost = array(
            'roleid'            =>  $session_roletypecode,
            'divisioncode'      =>  $session_divisioncode,
            'distcode'          =>  $session_distcode,
            'zonecode'          =>  $session_zonecode,
            'circleid'          =>  $session_circleid,
          
            'data_name'         =>  $getting_data
        );
        $resultdata1 = $Basemodel->procedure($getting_totalpost);
        $resultdata = json_decode($resultdata1['fn_get_dashboarddescription_deptuser'], true);
       
        http_response_code(200);

            if ($resultdata == '') 
            { ?>
                <center> No Data Available </center>
                <br><?php
            } 
            else 
            { ?>
                <div class="table-responsive">
                    <table id="dashboard_table" class="table table-bordered datatables-basic" style="width:100%">
                        <thead>
                            <tr>
                                <th>S.No</th>    
                                <?php
                            
                                if($getting_data == 'create_user')
                                {?>
                                    <th>Employee Name</th>
                                    <th>Role Type</th>
                                    <th>Division</th>
                                    <th>Zone</th>
                                    <th>Circle</th>
                                    <th>DOB</th>
                                    <th >Mobile No</th>
                                    <th>Email</th><?php
                                }
                                else if($getting_data == 'create_charge')
                                {?>
                                       
                                    <th>Role Type</th>
                                    <th>Division</th>
                                    <th>Zone</th>
                                    <th>Circle</th>
                                    <th>District</th>
                                    <th>Charge Description</th><?php

                                }
                                if($getting_data == 'assigned_charge')
                                {?>
                                    <th>Role Type</th>
                                    <th>Employee Id</th>
                                    <th>Name</th>
                                    <th>Charge Description</th>
                                    
                                    <th>Division</th>
                                    <th>District</th>
                                    <th>Zone</th>
                                    <th>Circle</th><?php
                                }?>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $i = 1;
                                foreach ($resultdata as $value) 
                                { ?>
                                    <tr><?php
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

                                        if($getting_data == 'create_user')
                                        {?>
                                            <td class="text-end"><?php echo htmlentities($i); ?></td>
                                            <td><?=htmlspecialchars($value['name']); ?></td>
                                            <td><?=htmlspecialchars($value['roletypelname']); ?></td>
                                            <td><?=htmlspecialchars($division_name); ?></td>
                                            <td><?=htmlspecialchars($zone_name); ?></td>
                                            <td><?=htmlspecialchars($circle_name); ?></td>
                                            <td><?=htmlspecialchars(date("d-m-Y", strtotime(($value['dateofbirth'])))); ?></td>
                                            <td><?=htmlspecialchars($value['mobilenumber']); ?></td>
                                            <td><?=htmlspecialchars($value['email']); ?></td><?php
                                        }
                                        else if($getting_data == 'create_charge')
                                        {?>
                                               
                                            <td class="text-end"><?php echo htmlentities($i); ?></td>
                                            <td><?=htmlspecialchars($value['roletypelname']); ?></td>
                                            <td ><?=htmlspecialchars($division_name); ?></td>
                                            <td ><?=htmlspecialchars($zone_name); ?></td>
                                            <td ><?=htmlspecialchars($circle_name); ?></td>
                                            <td> <?php echo htmlentities($value['distename']);?></td>
                                            <td><?=htmlspecialchars($value['chargedescription']); ?></td><?PHP
    
                                        }
                                        if($getting_data == 'assigned_charge')
                                        {?>
                                            <td class="text-end"><?php echo htmlentities($i); ?></td>
                                            <td><?=htmlspecialchars($value['roletypelname']); ?></td>
                                            <td> <?php echo htmlentities($value['name']);?></td>
                                            <td> <?php echo htmlentities($value['empid']);?></td>
                                            <td><?=htmlspecialchars($value['chargedescription']); ?></td>
                                            <td ><?=htmlspecialchars($division_name); ?></td>
                                            <td> <?php echo htmlentities($value['distename']);?></td>
                                            <td ><?=htmlspecialchars($zone_name); ?></td>
                                            <td ><?=htmlspecialchars($circle_name); ?></td><?php
                                        }?>


                                                          
                                      
                                    </tr><?php
                                    $i++;
                                } ?>
                        </tbody>
                    </table>
                </div><?php
            }
        } 

    



}

?>