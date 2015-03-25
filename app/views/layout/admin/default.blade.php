<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title> 
            <?php echo Config::get('billing.site_name');?> 
            <?php echo  !empty($title)?" - ".$title:'';?>
        </title>
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <?php /*<link href="<?php echo URL::to('/');?>/assets/iconic/css/ionic.min.css" rel="stylesheet" type="text/css" />*/?>
        <link href="<?php echo URL::to('/');?>/assets/bootsrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL::to('/');?>/assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
        <!-- Ionicons -->
        
        <!-- Theme style -->
        <link href="<?php echo URL::to('/');?>/styles/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL::to('/');?>/assets/dataTables/bootstrap/3/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
        <link href="<?php echo URL::to('/');?>/assets/dataTables/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
        <?php 
            if(isset($cssIncludes)) {
                foreach($cssIncludes as $style){
                    $fileInfo = Config::Get('Includes.styles.'.$style);
                    echo '<link href="'.$fileInfo['file'].'" rel="stylesheet" type="text/css" />';
                }
            }
        ?>
        <link href="<?php echo URL::to('/');?>/styles/style.css" rel="stylesheet" type="text/css" />

        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
          <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
          <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
        <![endif]-->
    </head>
    <body class="skin-blue">
        <!-- header logo: style can be found in header.less -->
        <header class="header">
            <a href="<?php echo URL::to('/');?>/admin/dashboard" class="logo">
                <!-- Add the class icon to your logo image or logo icon to add the margining -->
                Daavani - Billing 
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </a>
                <div class="navbar-right">
                    <ul class="nav navbar-nav">
                        
                        
                      
                        
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="glyphicon glyphicon-user"></i>
                                <span><?php echo Auth::user()->first_name.' '.Auth::user()->last_name;?> <i class="caret"></i></span>
                            </a>
                            <ul class="dropdown-menu">
                               
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="#" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="<?php echo base_url();?>/logout" class="btn btn-default btn-flat">Sign out</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <div class="wrapper row-offcanvas row-offcanvas-left">
            <!-- Left side column. contains the logo and sidebar -->
            <aside class="left-side sidebar-offcanvas">
                <!-- sidebar: style can be found in sidebar.less -->
                <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="<?php echo URL::to('/');?>/images/daavani-girl.jpg" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p>Hello, <?php echo Auth::user()->first_name.' '.Auth::user()->last_name;?></p>

                        </div>
                    </div>
                    <?php $menu = isset($menu)?$menu:''; ?>
                    <!-- sidebar menu: : style can be found in sidebar.less -->
                    <ul class="sidebar-menu">
                        <li class='<?php echo ($menu == 'dashboard')?" active":"";?>' >
                            <a href="<?php echo base_url();?>/admin/dashboard">
                                <i class="fa fa-dashboard"></i> <span>Dashboard</span>
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>/admin/products">
                                <i class="fa fa-barcode"></i> <span>Products</span> 
                            </a>
                        </li>
                        <li class="<?php echo ($menu == 'category')?" active":"";?>">
                            <a href="<?php echo base_url();?>/admin/categories">
                                <i class="fa fa-toggle-down"></i> <span>Categories</span> 
                            </a>
                        </li>
                        <li class='<?php echo ($menu == 'properties')?" active":"";?>' >
                            <a href="<?php echo base_url();?>/admin/properties">
                                <i class="fa fa-check-circle"></i> <span>Properties</span> 
                            </a>
                        </li>
                        <li class='<?php echo ($menu == 'batch')?" active":"";?>' >
                            <a href="<?php echo base_url();?>/admin/batch">
                                <i class="fa fa-group"></i> <span>Batches</span> 
                            </a>
                        </li>
                        <li class='<?php echo ($menu == 'shops')?" active":"";?>' >
                            <a href="<?php echo base_url();?>/admin/shops">
                                <i class="fa fa-shopping-cart"></i> <span>Shops</span> 
                            </a>
                        </li>
                        <li>
                            <a href="<?php echo base_url();?>/admin/reports">
                                <i class="fa fa-info"></i> <span>Reports</span> 
                            </a>
                        </li>
                        
                    </ul>
                </section>
                <!-- /.sidebar -->
            </aside>

            <!-- Right side column. Contains the navbar and content of the page -->
            <aside class="right-side">
              @yield('content')
            </aside><!-- /.right-side -->
        </div><!-- ./wrapper -->
        <script type="text/javascript">var baseUrl = '<?php echo base_url();?>';</script>
        <script src="<?php echo URL::to('/');?>/assets/jquery/jquery-2.1.3.min.js"></script>
        <script src="<?php echo URL::to('/');?>/assets/bootsrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="<?php echo URL::to('/');?>/assets/AdminLTE/app.js" type="text/javascript"></script>
        <script src="<?php echo URL::to('/');?>/assets/dataTables/js/jquery.dataTables.min.js" type="text/javascript"></script>
        
        <?php 
            if(isset($scriptIncludes)) {
                foreach($scriptIncludes as $script){
                    $fileInfo = Config::Get('Includes.scripts.'.$script);
                    echo '<script src="'.$fileInfo['file'].'"  type="text/javascript"></script>';
                }
            }
        ?>
        <script type="text/javascript" src="<?php echo base_url();?>/assets/dataTables/bootstrap/3/dataTables.bootstrap.js"></script>
        
    </body>
</html>
