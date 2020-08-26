<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" type="image/png" sizes="16x16" href="<?php echo base_url();?>assets/images/eye.png">
    <title><?php echo $pageTitle; ?></title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- FontAwesome 4.3.0 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Ionicons 2.0.0 -->
    <link href="<?php echo base_url(); ?>assets/bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. Choose a skin from the css/skins 
         folder instead of downloading all of them to reduce the load. -->
    <link href="<?php echo base_url(); ?>assets/dist/css/skins/_all-skins.min.css" rel="stylesheet" type="text/css" />
    <style>
    	.error{
    		color:red;
    		font-weight: normal;
    	}
    </style>
    <script src="<?php echo base_url(); ?>assets/bower_components/jquery/dist/jquery.min.js"></script>
    <script type="text/javascript">
        var baseURL = "<?php echo base_url(); ?>";
    </script>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
  </head>
  <body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
      
      <header class="main-header">
        <!-- Logo -->
        <a href="<?php echo base_url(); ?>" class="logo">
          <!-- mini logo for sidebar mini 50x50 pixels -->
          <span class="logo-mini">C&A</span>
          <!-- logo for regular state and mobile devices -->
          <span class="logo-lg"><b>D</b>etrec</span>
        </a>
        <!-- Header Navbar: style can be found in header.less -->
        <nav class="navbar navbar-static-top" role="navigation">
          <!-- Sidebar toggle button-->
          <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
            <span class="sr-only">Toggle navigation</span>
          </a>
          <div class="navbar-custom-menu">

            <ul class="nav navbar-nav">
              
              <!-- User Account: style can be found in dropdown.less -->
              <li class="dropdown user user-menu">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                  <img src="<?php echo base_url(); ?>assets/dist/img/<?php echo $uimage; ?>" class="user-image" alt="User Image"/>
                  <span class="hidden-xs"><?php echo $name; ?></span>
                </a>
                <ul class="dropdown-menu">
                  <!-- User image -->
                  <li class="user-header">
                    
                    <img src="<?php echo base_url(); ?>assets/dist/img/<?php echo $uimage; ?>" class="img-circle" alt="User Image" />
                    <p>
                      <?php echo $name; ?>
                      <small><?php echo $role_text; ?></small>
                      <?php echo $role; ?>
                    </p>
                    
                  </li>
                  <!-- Menu Footer-->
                  <li class="user-footer">
                    <div class="pull-left">
                      <a href="<?php echo base_url(); ?>profile" class="btn btn-warning btn-flat"><i class="fa fa-user-circle"></i> Profile</a>
                    </div>
                    <div class="pull-right">
                      <a href="<?php echo base_url(); ?>logout" class="btn btn-default btn-flat"><i class="fa fa-sign-out"></i> Sign out</a>
                    </div>
                  </li>
                </ul>
              </li>
            </ul>
          </div>
        </nav>
      </header>
      <!-- Left side column. contains the logo and sidebar -->
      <aside class="main-sidebar">
        <!-- sidebar: style can be found in sidebar.less -->
        <section class="sidebar">
          <!-- sidebar menu: : style can be found in sidebar.less -->
          <ul class="sidebar-menu" data-widget="tree">
            <li class="header">NAVIGATION</li>
            <li><a href="<?php echo base_url(); ?>home"><i class="fa fa-home"></i> <span>Home</span></i></a></li>
            
            <hr>
            <li><a href="#"><i class="fa fa-calendar"></i> <span>Diarized Files<span class="label label-rouded label-info pull-right">159</span></span></i></a></li>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-rocket"></i> <span>To Do(Today)</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  <span class="label label-rouded label-danger pull-right">12</span>
                </span>
              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-envelope-open-o"></i> Letters<span class="label label-rouded label-info pull-right">4</span></a></li>
                <li><a href="#"><i class="fa fa-comments-o"></i> SMS/Whatsapp<span class="label label-rouded label-info pull-right">2</span></a></li>
                <li><a href="#"><i class="fa fa-phone"></i> Phone<span class="label label-rouded label-info pull-right">1</span></a></li>
                <li><a href="#"><i class="fa fa-calendar-o"></i> Promise to Pay<span class="label label-rouded label-info pull-right">5</span></a></li>
              </ul>
            </li>
            <li>
              <a href="#" >
                <i class="fa fa-comments"></i>
                <span>Messages</span>
              </a>
            </li>
            <?php $this->load->view ( 'email/maillst'); ?>
            <!-- <li class="treeview">
              <a href="#">
                <i class="fa fa-envelope"></i> <span>E-Mail</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left pull-right"></i>
                  <span class="label label-rouded label-warning pull-right">3</span>
                </span>

              </a>
              <ul class="treeview-menu">
                <li><a href="#"><i class="fa fa-inbox"></i>Inbox</a></li>
                <li><a href="#"><i class="fa fa-send"></i>Sent Items</a></li>
                <li><a href="#"><i class="fa fa-trash-o"></i>Deleted</a></li>
                <li><a href="#"><i class="fa fa-thumbs-o-down"></i>Junk Mail</a></li>
                
                <li><a href="#"><i class="fa fa-folder-open-o"></i>*UserFolder1</a></li>
                <li><a href="#"><i class="fa fa-folder-open-o"></i>*UserFolder2</a></li>                
              </ul>
            </li> -->
            
            <hr>
            <li class="treeview">
              <a href="#">
                <i class="fa fa-gavel"></i> <span>Accounts</span>
                <span class="pull-right-container">
                  <i class="fa fa-angle-left"></i>
                </span>
              </a>
              <ul class="treeview-menu">
                <?php if($role == ROLE_ADMIN || $role == ROLE_MANAGER) { ?>
                  <li><a href="#"><i class="fa fa-pencil"></i> Add/Edit</a></li>
                <?php } ?>
                <li><a href="#"><i class="fa fa-binoculars"></i> View</a></li>
                <li><a href="<?php echo base_url(); ?>accsearch"><i class="fa fa-search"></i> Search</a></li>
              </ul>
            </li>
            <li>
              <a href="#" >
                <i class="fa fa-money"></i>
                <span>Receipt</span>
              </a>
            </li>
            <?php if($role == ROLE_ADMIN || $role == ROLE_MANAGER) { ?>

            <li>
              <a href="#" >
                <i class="fa fa-balance-scale"></i>
                <span>Splits</span>
              </a>
            </li>
            <li>
              <a href="#" >
                <i class="fa fa-address-book"></i>
                <span>Clients</span>
              </a>
            </li>
            <li>
              <a href="#" >
                <i class="fa fa-files-o"></i>
                <span>Reports</span>
              </a>
            </li>
            <?php } if($role == ROLE_ADMIN) { ?>
            <li>
              <a href="<?php echo base_url(); ?>userListing">
                <i class="fa fa-users"></i>
                <span>Users</span>
              </a>
            </li>
            
            <?php } ?>
          </ul>
        </section>
        <!-- /.sidebar -->
      </aside>