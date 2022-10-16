<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <title>CRM</title>
        <?php 
            $ltr = '';
        if($this->session->userdata('user_details')[0]->lang == "arabic") {
            $ltr = '-rtl';
        ?>
    <link rel="stylesheet" href="<?php echo assets_url('crm-assets/arabic/style.css'); ?>">
    <?php } ?>
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo assets_url(); ?>crm-assets/images/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo assets_url(); ?>crm-assets/images/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo assets_url(); ?>crm-assets/images/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo assets_url(); ?>crm-assets/images/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo assets_url(); ?>crm-assets/images/ico/favicon1.ico">
    <link rel="shortcut icon" type="image/png" href="<?php echo assets_url(); ?>crm-assets/images/ico/favicon-32.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>crm-assets/css<?= $ltr ?>/bootstrap.css">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>crm-assets/fonts/icomoon.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url(); ?>crm-assets/fonts/flag-icon-css/css<?= $ltr ?>/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>crm-assets/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>crm-assets/css<?= $ltr ?>/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>crm-assets/css<?= $ltr ?>/app.css">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>crm-assets/css<?= $ltr ?>/colors.css">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url(); ?>crm-assets/css<?= $ltr ?>/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url(); ?>crm-assets/css<?= $ltr ?>/core/menu/menu-types/vertical-overlay-menu.css">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>crm-assets/css/core/colors/palette-gradient.css">
    <link rel="stylesheet" href="<?php echo assets_url('crm-assets/custom/datepicker.min.css') ?>">
    <link rel="stylesheet" href="<?php echo assets_url('crm-assets/custom/jquery.dataTables.css') ?>">
    <link rel="stylesheet" href="<?php echo assets_url('crm-assets/custom/summernote-bs4.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets_url('crm-assets/custom/style.css'); ?>">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>/crm-assets/css/style.css?ver=1324">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>/crm-assets/css/custom.css">
    <!-- END Custom CSS-->
    <script src="<?php echo assets_url(); ?>crm-assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url(); ?>crm-assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url(); ?>crm-assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url(); ?>crm-assets/portjs/raphael.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url(); ?>crm-assets/portjs/morris.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url(); ?>crm-assets/js/summernote-bs4.min.js" type="text/javascript"></script>
    <script type="text/javascript">var baseurl = '<?php echo assets_url() ?>';</script>
    <script src="<?php echo assets_url('crm-assets/js/icheck.min.js'); ?>"></script>
    <script src="<?php echo assets_url('crm-assets/js/jquery.form-validator.min.js'); ?>"></script>
    <script src="<?php echo assets_url('crm-assets/js/custom.js'); ?>"></script>
</head>
<body data-open="click" data-menu="vertical-menu" data-col="2-columns"
      class="vertical-layout vertical-menu 2-columns  fixed-navbar  menu-expanded">

<!-- navbar-fixed-top-->
<nav class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav">
                <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a>
                </li>
                <li class="nav-item logo"><a href="<?php echo base_url() ?>" class="navbar-brand nav-link"><img
                                alt="branding logo"
                                src="<?php echo substr_replace(base_url(), '', -4); ?>userfiles/theme/logo-header.png"
                                data-expand="<?php echo substr_replace(base_url(), '', -4); ?>userfiles/theme/logo-header.png"
                                data-collapse="<?php echo substr_replace(base_url(), '', -4); ?>userfiles/theme/logo-header.png"
                                class="brand-logo height-50"></a></li>
                <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile"
                                                                    class="nav-link open-navbar-container"><i
                                class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content container-fluid">
            <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                <ul class="nav navbar-nav">
                    <li class="nav-item hidden-sm-down"><a class="nav-link nav-menu-main menu-toggle hidden-xs"><i
                                    class="icon-menu5"> </i></a></li>
                    <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i
                                    class="icon icon-expand2"></i></a></li>

                </ul>
                <ul class="nav navbar-nav float-xs-right">



                    <li class="dropdown dropdown-user nav-item"><a href="#" data-toggle="dropdown"
                                                                   class="dropdown-toggle nav-link dropdown-user-link"><span
                                    class="avatar avatar-online"><img
                                        src="<?php echo assets_url(); ?>crm-assets/images/user.png"
                                        alt="avatar"><i></i></span></a>
                        <div class="dropdown-menu dropdown-menu-right"><a href="<?php echo base_url(); ?>user/profile"
                                                                          class="dropdown-item"><i
                                        class="icon-head"></i><?php echo $this->lang->line('Profile') ?></a>
                            <div class="dropdown-divider"></div>
                            <a href="<?php echo base_url('user/logout'); ?>" class="dropdown-item"><i
                                        class="icon-power3"></i> <?php echo $this->lang->line('Logout') ?></a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->


<!-- main menu-->
<div data-scroll-to-active="true" class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" id="side">
    <!-- main menu header-->

    <!-- / main menu header-->
    <!-- main menu content-->
    <div class="main-menu-content">
        <ul id="main-menu-navigation" data-menu="menu-navigation" class="navigation navigation-main mt-2">

            <li class="nav-item <?php if ($this->uri->segment(1) == "invoices") {
                echo 'active';
            } ?>">
                <a href="<?php echo base_url(); ?>invoices/"> <i class="icon-file-text"></i><span class="menu-title"> <?php echo $this->lang->line('Invoices'); ?> </span></a>
            </li>
            <li class="nav-item <?php if ($this->uri->segment(1) == "rec_invoices") {
                echo 'active';
            } ?>">
                <a href="<?php echo base_url(); ?>subscriptions/"> <i class="icon-android-calendar"></i><span class="menu-title"> <?php echo $this->lang->line('Subscriptions'); ?> </span></a>
            </li>
            <li class="nav-item <?php if ($this->uri->segment(1) == "quote") {
                echo 'active';
            } ?>">
                <a href="<?php echo base_url(); ?>quote/"> <i class="icon-file"></i><span class="menu-title"> <?php echo $this->lang->line('Quotes'); ?> </span></a>
            </li>
            <li class="nav-item <?php if($this->uri->segment(2) == "recharge") echo "active"; ?>">
                <a href="<?php echo base_url("payments/recharge"); ?>"><i class="icon-credit-card2"></i>
                    <span><?php echo $this->lang->line('Recharge Account'); ?></span></a>
            </li>
            <li class="nav-item <?php if($this->uri->segment(1) == "payments") echo "active"; ?>">
                <a href="<?php echo base_url("payments"); ?>"><i class="icon-cash"></i>
                    <span><?php echo $this->lang->line('Payment History'); ?></span></a>
            </li>
            <li class="nav-item <?php if($this->uri->segment(1) == "tickets") echo "active"; ?>">
                <a href="<?php echo base_url("tickets"); ?>"><i class="icon-ticket"></i>
                    <span><?php echo $this->lang->line('Support Tickets') ?></span></a>
            </li>
            <li class="nav-item <?php if($this->uri->segment(1) == "projects") echo "active"; ?>">
                <a href="<?php echo base_url("projects"); ?>"><i class="icon-stack"></i>
                    <span><?php echo $this->lang->line('Project'); ?></span></a>
            </li>
            <li class="nav-item <?php if ($this->uri->segment(2) == "profile") {
                echo 'active';
            } ?>">
                <a href="<?php echo base_url(); ?>user/profile"> <i class="icon-user1"></i><span class="menu-title"> <?php echo $this->lang->line('Profile') ?> </span></a>
            </li>
            <li class="nav-item <?php if ($this->uri->segment(1) == "address") {
                echo 'active';
            } ?>">
                <a href="<?php echo base_url(); ?>user/address"> <i class="icon-address-book"></i><span class="menu-title"> <?php echo $this->lang->line('Address') ?> </span></a>
            </li>


        </ul>
    </div>
    <!-- /main menu content-->
    <!-- main menu footer-->
    <!-- include includes/menu-footer-->
    <!-- main menu footer-->
    <div id="rough"></div>
</div>
<!-- / main menu-->