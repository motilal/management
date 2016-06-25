<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="Motilal Soni">
        <title><?php echo isset($title) ? $title : ''; ?></title>  
        <link href="<?php echo base_url('images/favicon.ico'); ?>" type="image/x-icon" rel="shortcut icon" />   
        <script type="text/javascript">window.paceOptions = {startOnPageLoad: false};</script>
        <script src="<?php echo base_url('asset/admin/pace/pace.min.js'); ?>"></script>

        <link href="<?php echo base_url('css/admin/bootstrap.min.css'); ?>" rel="stylesheet">  
        <link href="<?php echo base_url('css/admin/font-awesome.min.css'); ?>" rel="stylesheet" type="text/css">
        <link href="<?php echo base_url('asset/admin/datatables/dataTables.bootstrap.css'); ?>" rel="stylesheet"> 

        <script src="<?php echo base_url('js/admin/jquery-1.11.3.min.js'); ?>"></script> 
        <script>var SiteUrl = "<?php echo site_url(); ?>";</script>
        <script src="<?php echo base_url('js/admin/bootstrap.min.js'); ?>"></script> 
        <script src="<?php echo base_url('js/admin/metisMenu.min.js'); ?>"></script>  
        <script src="<?php echo base_url('asset/admin/datetimepicker/moment-with-locales.js'); ?>"></script> 

        <?php if (isset($drop_menu_css) && $drop_menu_css) { ?>
            <link href="<?php echo base_url('css/admin/dropmenu.css'); ?>" rel="stylesheet"> 
        <?php } ?>

        <?php if (isset($ckeditor_asset) && $ckeditor_asset) { ?>
            <script type="text/javascript" src="<?php echo base_url("asset/admin/ckeditor/ckeditor.js") ?>"></script>
            <script type="text/javascript" src="<?php echo base_url("asset/admin/ckfinder/ckfinder.js") ?>"></script>
        <?php } ?>

        <?php if (isset($datatable_asset) && $datatable_asset) { ?>    
            <script src="<?php echo base_url('asset/admin/datatables/jquery.dataTables.min.js'); ?>"></script> 
            <script src="<?php echo base_url('asset/admin/datatables/dataTables.bootstrap.min.js'); ?>"></script>
        <?php } ?>

        <?php if (isset($datetimepicker_asset) && $datetimepicker_asset) { ?>    
            <script src="<?php echo base_url('asset/admin/datetimepicker/bootstrap-datetimepicker.min.js'); ?>"></script> 
            <link rel="stylesheet" href="<?php echo base_url('asset/admin/datetimepicker/bootstrap-datetimepicker.css'); ?>" type="text/css" media="screen" /> 
        <?php } ?>   

        <link rel="stylesheet" href="<?php echo base_url('asset/admin/jalert/jAlert-v3.css'); ?>" type="text/css" media="screen" /> 
        <script type="text/javascript" src="<?php echo base_url('asset/admin/jalert/jAlert-v3.min.js'); ?>"></script>
        <script type="text/javascript" src="<?php echo base_url('asset/admin/jalert/jAlert-functions.min.js'); ?>"></script>

        <script src="<?php echo base_url('js/admin/admin.js'); ?>"></script>


        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->

    </head>

    <body>
        <?php echo sanitize_output($this->layout->element('admin/_info_msg_element', $this->_ci_cached_vars, true)); ?>

        <div id="wrapper"> 
            <!-- Navigation -->
            <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0;">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="<?php echo site_url('admin/dashboard'); ?>">Admin Manager v2.0</a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right"> 
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-alerts">
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-comment fa-fw"></i> New Comment
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-twitter fa-fw"></i> 3 New Followers
                                        <span class="pull-right text-muted small">12 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-envelope fa-fw"></i> Message Sent
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-tasks fa-fw"></i> New Task
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a href="#">
                                    <div>
                                        <i class="fa fa-upload fa-fw"></i> Server Rebooted
                                        <span class="pull-right text-muted small">4 minutes ago</span>
                                    </div>
                                </a>
                            </li>
                            <li class="divider"></li>
                            <li>
                                <a class="text-center" href="#">
                                    <strong>See All Alerts</strong>
                                    <i class="fa fa-angle-right"></i>
                                </a>
                            </li>
                        </ul>
                        <!-- /.dropdown-alerts -->
                    </li>
                    <!-- /.dropdown -->
                    <li class="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                            <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                        </a>
                        <ul class="dropdown-menu dropdown-user">
                            <li><a href="<?php echo site_url('admin/settings/profile'); ?>"><i class="fa fa-user fa-fw"></i> User Profile</a>
                            </li>
                            <li><a href="<?php echo site_url('admin/settings'); ?>"><i class="fa fa-gear fa-fw"></i> Settings</a>
                            </li>
                            <li class="divider"></li>
                            <li><a href="<?php echo site_url('admin/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                            </li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
                <!-- /.navbar-top-links -->
                <?php echo sanitize_output($this->layout->element("admin/_sidebar", $this->_ci_cached_vars, true)); ?>
                <!-- /.navbar-static-side -->
            </nav> 
            <?php echo sanitize_output($content_for_layout); ?> 
        </div>
        <!-- /#wrapper -->          
        <link href="<?php echo base_url('css/admin/admin.css'); ?>" rel="stylesheet">  
    </body>
</html>