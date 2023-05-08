<!doctype html>
<html lang="en">
   <head>
     
        <meta charset="utf-8" />
        <title>Commercial Tax</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesbrand" name="author" />
        <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">        Bootstrap Css -->
        <link href="<?php echo URLROOT; ?>public/dash/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />


        <!-- custom Css -->
        <link href="<?php echo URLROOT; ?>public/dash/css/custom/custom.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="<?php echo URLROOT; ?>public/dash/css/icons.min.css" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="<?php echo URLROOT; ?>public/dash/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />
        <!-- Bootstrap fontawesome Css
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet"/> -->
        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

    </head>
    <body data-sidebar="dark" data-layout-mode="light">

    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
        <!-- Begin page -->
        <div id="layout-wrapper">

            <header id="page-topbar">
            <?php include_once('./public/dash/layout/logo_header.php') ?>

                <div class="navbar-header" style="background-color: #1E3D5D;">
                    <div class="d-flex">
                        <!-- LOGO -->
                        <div class="navbar-brand-box">
                           

                        </div>

                        <button type="button" class="btn btn-sm px-3 font-size-16 header-item waves-effect" id="vertical-menu-btn">
                            <i class="fa fa-fw fa-bars" style="color: white;"></i>
                        </button>
                    </div>
                    <?php 
                            $session_details = $this->session_details();
                            $name = $session_details[0]->name;
                            ?>
                    <div class="d-flex">
                        <div class="dropdown d-inline-block">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="color: white;">
                            <span >Welcome</span>

                                <span class="d-xl-inline-block ms-1" key="t-henry"><?php echo $name ?></span>
                                <i class="mdi mdi-chevron-down d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <a class="dropdown-item" href="<?php echo URLROOT; ?>Mybill/profile"><i class="bx bx-user font-size-16 align-middle me-1"></i> <span key="t-profile">Profile</span></a>
                                
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="<?= URLROOT; ?>Mybill/logout"><i class="bx bx-power-off font-size-16 align-middle me-1 text-danger"></i> <span key="t-logout">Logout</span></a>
                            </div>
                        </div>

                      

                    </div>
                    
                </div>

            </header>
            <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script> 
<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
            <script>
               
                  var $area = $(document),
        idleActions = [
            {
                milliseconds: 18000000, // 3 seconds
                action: function () 
                { 
                    $.ajax({
                        url:'<?php echo URLROOT;?>Citizen/logout',
                        paging:"true",
                        dataType: "html", 
                        success:function(data)
                        {
                            // header("Location: " . URLROOT . "user/login");
                            window.location.href = '<?php echo URLROOT; ?>';
                            // $('#sidebar_div').html(data); 

                        }
                    });
                }
            },
        ];


        function Eureka (event, times, undefined) 
    {
        var idleTimer = $area.data('idleTimer');
        if (times === undefined) times = 0;
        if (idleTimer) {
            clearTimeout($area.data('idleTimer'));
        }
        if (times < idleActions.length) {
            $area.data('idleTimer', setTimeout(function () {
                idleActions[times].action(); // run the first action
                Eureka(null, ++times); // setup the next action
            }, idleActions[times].milliseconds));
        } else {
            // final action reached, prevent further resetting
            $area.off('mousemove click', Eureka);
        }
    };

   

     <?php
     if (isset($_SESSION['user']))
     {?>
      $area
        .data('idle', null)
        .on('mousemove click', Eureka);

        Eureka();<?php
     }?>


        </script>