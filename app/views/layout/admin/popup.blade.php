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
        <script src="<?php echo URL::to('/');?>/assets/jquery/jquery-2.1.3.min.js"></script>
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
        @yield('content')
        <script type="text/javascript">var baseUrl = '<?php echo base_url();?>';</script>
        
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