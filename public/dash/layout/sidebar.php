<div class="vertical-menu">

<div data-simplebar class="h-100">
<?php $lang_val='en';
    $active_menu_parent_id  = '';
    $active =   '';?>

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            <li class="" key="t-menu"><h4>Menu</h4></li>
            
                <br><?php
                $Basemodel = new Basemodel;
                $Basemodel->tablename = "mybillmyright.mst_menu";
                $del = array('status'=>'Y');
                $select = "mybillmyright.mst_menu.menuname,mybillmyright.mst_menu.status,mybillmyright.mst_menu.menuurl,mybillmyright.mst_menu.status,mybillmyright.mst_menu.menuid,mybillmyright.mst_menu.parentid,mybillmyright.mst_menu.levelid,mybillmyright.mst_menu.key";
                $data = array();
                $id = 'order_id';
                $status_flag = array('Y' => 'Active', 'N' => 'InActive');
                $data = $Basemodel->getMultipleJoin($select, $data, $del, $id);
                // print_r($data);
                // print_r($_SESSION['charge']['data']);
                $i = 0;
                foreach ($data as $value)               // looping all menu names
                {
                    $parent_id='N';
                    if ($value->parentid == 0 && $value->levelid == 1) 
                    {
                        $parent_menuid = $value->menuid;
                        if ($lang_val == 'ta') 
                            $parent_menuname = $value->menu_ta_name;
                        if (($lang_val == 'en') || ($lang_val == '') || ($lang_val == null)) 
                            $parent_menuname = $value->menuname;
                        
                        $count = 0;
                        
                        if($Basemodel->userpermission($value->menuid))
                            $parent_id='Y';
                    
                        else
                        {
                            foreach ($data as $value1) 
                            {
                                if ($parent_menuid == $value1->parentid && $value1->levelid == 2 && $Basemodel->userpermission($value1->menuid))                
                                {
                                    if ('trans_request' == $value1->key) 
                                    {
                                        if ($enable_tranfer_request == 'Y') 
                                            $count++;
                                    }
                                    else
                                        $count++;
                                }
                            }
                        }
                        if($count > 0)
                        {

                            if($active_menu_parent_id==$parent_menuid)
                            { ?>
                                <li class="sidebar-item active">
                                    <a data-bs-target="#ui<?php echo htmlentities($value->menuid); ?>" data-bs-toggle="collapse" class="sidebar-link"><?php
                            } else
                            {?>
                                <li class="sidebar-item">
                                    <a data-bs-target="#ui<?php echo htmlentities($value->menuid); ?>" data-bs-toggle="collapse" class="sidebar-link collapsed"><?php
                            }
                            ?>
                                <i class="bx bx-receipt"></i> <span class="align-middle"><?php echo htmlentities($parent_menuname); ?> </span>
                                    </a><?php
                                
                                if($active_menu_parent_id==$parent_menuid)
                                {?>
                                    <ul id="ui<?php echo htmlentities($parent_menuid) ?>" class="sidebar-dropdown list-unstyled collapse show" data-bs-parent="#sidebar_div"><?php
                                }
                                else
                                {?>
                                    <ul id="ui<?php echo htmlentities($parent_menuid) ?>" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar_div"><?php
                                }
                                foreach ($data as $value1) 
                                {

                                    if ($lang_val == 'ta') 
                                        $sub_menu_name = $value1->menu_ta_name;
                                    if (($lang_val == 'en') || ($lang_val == '') || ($lang_val == null)) 
                                        $sub_menu_name = $value1->menuname;
                                    
                                        if ($parent_menuid == $value1->parentid && $value1->levelid == 2 && $Basemodel->userpermission($value1->menuid)) 
                                        {
                                            if ($value1->menuid == $active) 
                                            { ?>
                                                <li class="sidebar-item active"><a class="sidebar-link" href="<?= URLROOT . $value1->menuurl ?>"><i class="align-middle me-2 fas icon_color fa fa-files-o"></i><?php echo htmlentities($sub_menu_name); ?> </a></li><?php
                                            }
                                            else 
                                            { ?>
                                                <li class="sidebar-item  "><a class="sidebar-link" href="<?= URLROOT . $value1->menuurl ?>" onclick="get_menuname('<?php echo htmlentities($value1->key) ?>')"><i class="align-middle me-2 fas icon_color fa-fw fa-file"></i><?php echo htmlentities($sub_menu_name); ?> </a></li> <?php
                                            }
                                        }
                                    
                                } ?>
                            </ul>
                            </li><?php
                        }

                        ?>

                        <?php
                
                        if($parent_id=='Y')
                        {
                        

                            if($active_menu_parent_id==$parent_menuid)
                            {?>
                                <li >
                                    
                                    <a  href="<?= URLROOT . htmlentities($value->menuurl) ?>"class="sidebar-link " >
                                    <i class="bx bx-home-circle"></i> <span class="align-middle"><?php echo htmlentities($parent_menuname); ?> </span><?php
                            }
                            else
                            {?>
                                <li class="sidebar-item ">
                                    <a href="<?= URLROOT . htmlentities($value->menuurl) ?>" class="sidebar-link " >
                                    <i class="bx bx-home-circle"></i> <span class="align-middle"><?php echo htmlentities($parent_menuname); ?> </span><?php
                            }
                            ?>
                            </i></a></li><?php
                        }

                        
                    
                    }
                } ?>
        </ul>

    </div>
    <!-- Sidebar -->
</div>
</div>