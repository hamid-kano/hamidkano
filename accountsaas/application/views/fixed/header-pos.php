<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="description"
          content="Stack admin is super flexible, powerful, clean &amp; modern responsive bootstrap 4 admin template with unlimited possibilities.">
    <meta name="keywords"
          content="admin template, stack admin template, dashboard template, flat admin template, responsive admin template, web app">
    <?php if (@$title) {
        echo "<title>$title</title >";
    } else {
        echo "<title>Geo POS</title >";
    }
    ?>
    <link rel="apple-touch-icon" href="<?= assets_url() ?>app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?= assets_url() ?>app-assets/images/ico/favicon1.ico">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i%7COpen+Sans:300,300i,400,400i,600,600i,700,700i"
          rel="stylesheet">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/<?= LTR ?>/vendors.css">
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/vendors/css/extensions/unslider.css">
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/vendors/css/weather-icons/climacons.min.css">
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/fonts/meteocons/style.css">
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/vendors/css/charts/morris.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN STACK CSS-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/<?= LTR ?>/app.css">
    <!-- END STACK CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/<?= LTR ?>/core/menu/menu-types/horizontal-menu.css">
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/<?= LTR ?>/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/fonts/simple-line-icons/style.css">
    <link rel="stylesheet" type="text/css"
          href="<?= assets_url() ?>app-assets/<?= LTR ?>/core/colors/palette-gradient.css">
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>app-assets/<?= LTR ?>/pages/chat-application.css">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->
    <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>assets/css/style.css<?= APPVER ?>">
    <?php if (LTR == 'rtl') echo '<link rel="stylesheet" type="text/css" href="' . assets_url() . 'assets/css/style-rtl.css' . APPVER . '">'; ?>
    <link rel="stylesheet" href="<?php echo assets_url('assets/custom/datepicker.min.css') . APPVER ?>">
    <!-- END Custom CSS-->
    <script src="<?= assets_url() ?>app-assets/vendors/js/vendors.min.js"></script>
    <script type="text/javascript" src="<?= assets_url() ?>app-assets/vendors/js/ui/jquery.sticky.js"></script>
    <script type="text/javascript"
            src="<?= assets_url() ?>app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
    <script src="<?= assets_url() ?>app-assets/vendors/js/charts/raphael-min.js"></script>
    <script src="<?= assets_url() ?>app-assets/vendors/js/charts/morris.min.js"></script>

    <script type="text/javascript">var baseurl = '<?php echo base_url() ?>';
        var crsf_token = '<?=$this->security->get_csrf_token_name()?>';
        var crsf_hash = '<?=$this->security->get_csrf_hash(); ?>';
    </script>
    <script src="<?php echo assets_url('assets/myjs/mousetrap.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url('assets/myjs/datepicker.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url(); ?>assets/portjs/accounting.min.js" type="text/javascript"></script>
    <?php accounting() ?>
    
     <link rel="stylesheet" type="text/css" href="https://printjs-4de6.kxcdn.com/print.min.css">

</head>
<body class="horizontal-layout horizontal-menu content-left-sidebar <?php if ($s_mode) echo 'chat-application'; ?>  menu-expanded"
      data-open="hover"
      data-menu="horizontal-menu"
      data-col="2-columns">
<span id="hdata"
      data-df="<?php echo $this->config->item('dformat2'); ?>"
      data-curr="<?php echo currency($this->aauth->get_user()->loc); ?>"></span>
<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu navbar-static-top navbar-dark bg-gradient-x-grey-blue navbar-border navbar-brand-center">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item d-md-none"><a class="navbar-brand" href="<?= base_url() ?>dashboard/"><img
                                class="brand-logo" alt="logo"
                                src="<?php echo base_url(); ?>userfiles/theme/logo-header.png">
                    </a></li>
                <li class="nav-item d-md-none"><a class="nav-link open-navbar-container" data-toggle="collapse"
                                                  data-target="#navbar-mobile"><i class="fa fa-ellipsis-v"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content">
            <div class="collapse navbar-collapse" id="navbar-mobile">
                <ul class="nav navbar-nav mr-auto float-left">
                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-menu-main menu-toggle hidden-xs"
                                                              href="#"><i class="ft-menu"></i></a></li>

                    <li class="nav-item d-none d-md-block"><a class="nav-link nav-link-expand" href="#"><i
                                    class="ficon ft-maximize"></i></a></li>
                    <li class="nav-item d-none d-md-block nav-link "><a href="<?= base_url() ?>dashboard"
                                                                        class="btn btn-amber btn-md t_tooltip"
                                                                        title="Access POS"><i
                                    class="icon-speedometer"></i><?php echo $this->lang->line('Dashboard') ?> </a>
                    </li>
                    <li class="nav-item d-none d-md-block nav-link "><a class="btn btn-blue btn-md t_tooltip"
                                                                        title="View Register" data-toggle="modal"
                                                                        data-target="#register"><i
                                    class="icon-drawer"></i><?php echo $this->lang->line('Register') ?> </a>
                    </li>
                    
                    <li class="nav-item d-none d-md-block nav-link ">  
                    <a class="btn btn-black btn-md" target="_balnk"
                                       href="<?= base_url() ?>pos_invoices/register_print"><?php echo $this->lang->line('Register Summery') ?></a>
                                      </li>             
                    <li class="nav-item d-none d-md-block nav-link "><a data-toggle="modal"
                                                                        data-target="#close_register"
                                                                        class="btn btn-danger btn-md t_tooltip"
                                                                        title="Close Register"> <i
                                    class="icon-close"></i></a>
                    </li>

                </ul>

                <ul class="nav navbar-nav float-right">
                    <li class=" nav-item"><a class="nav-link" data-toggle="modal" data-target="#shortkeyboard"><i
                                    class="fa fa-keyboard-o
"></i></a></li>
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"><i
                                    class="ficon ft-bell"></i><span
                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"
                                    id="taskcount">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Pending Tasks') ?></span><span
                                            class="notification-tag badge badge-default badge-danger float-right m-0">5 New</span>
                                </h6>
                            </li>
                            <li class="scrollable-container media-list" id="tasklist"></li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                                                href="<?php echo base_url('manager/todo') ?>"><?php echo $this->lang->line('Manage tasks') ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"><i
                                    class="ficon ft-mail"></i><span
                                    class="badge badge-pill badge-default badge-info badge-default badge-up"><?php echo $this->aauth->count_unread_pms() ?></span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Messages') ?></span><span
                                            class="notification-tag badge badge-default badge-warning float-right m-0"><?php echo $this->aauth->count_unread_pms() ?><?php echo $this->lang->line('new') ?></span>
                                </h6>
                            </li>
                            <li class="scrollable-container media-list">
                                <?php $list_pm = $this->aauth->list_pms(6, 0, $this->aauth->get_user()->id, false);

                                foreach ($list_pm as $row) {

                                    echo '<a href="' . base_url('messages/view?id=' . $row->pid) . '">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm  rounded-circle"><img src="' . base_url('userfiles/employee/' . $row->picture) . '" alt="avatar"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row->name . '</h6>
                          <p class="notification-text font-small-3 text-muted">' . $row->{'title'} . '</p><small>
                            <time class="media-meta text-muted" datetime="' . $row->{'date_sent'} . '">' . $row->{'date_sent'} . '</time></small>
                        </div>
                      </div></a>';
                                } ?>    </li>
                            <li class="dropdown-menu-footer"><a class="dropdown-item text-muted text-center"
                                                                href="<?php echo base_url('messages') ?>"><?php echo $this->lang->line('Read all messages') ?></a>
                            </li>
                        </ul>
                    </li>
                    <?php if ($this->aauth->auto_attend()) { ?>
                        <li class="dropdown dropdown-d nav-item">


                            <?php if ($this->aauth->clock()) {

                                echo ' <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon spinner icon-clock"></i><span class="badge badge-pill badge-default badge-success badge-default badge-up">' . $this->lang->line('On') . '</span></a>';

                            } else {
                                echo ' <a class="nav-link nav-link-label" href="#" data-toggle="dropdown"><i class="ficon icon-clock"></i><span class="badge badge-pill badge-default badge-warning badge-default badge-up">' . $this->lang->line('Off') . '</span></a>';
                            }
                            ?>

                            <ul class="dropdown-menu dropdown-menu-right border-primary border-lighten-3 text-xs-center">
                                <br><br>
                                <?php echo '<span class="p-1 text-bold-300">' . $this->lang->line('Attendance') . ':</span>';
                                if (!$this->aauth->clock()) {
                                    echo '<a href="' . base_url() . '/dashboard/clock_in" class="btn btn-outline-success  btn-outline-white btn-md ml-1 mr-1" ><span class="icon-toggle-on" aria-hidden="true"></span> ' . $this->lang->line('Clock') . ' ' . $this->lang->line('In') . ' <i
                                    class="ficon icon-clock spinner"></i></a>';
                                } else {
                                    echo '<a href="' . base_url() . '/dashboard/clock_out" class="btn btn-outline-danger  btn-outline-white btn-md ml-1 mr-1" ><span class="icon-toggle-off" aria-hidden="true"></span> ' . $this->lang->line('Clock') . ' ' . $this->lang->line('Out') . ' </a>';
                                }
                                ?>

                                <br><br>
                            </ul>
                        </li>
                    <?php } ?>
                    <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link"
                                                                   href="#" data-toggle="dropdown"><span
                                    class="avatar avatar-online"><img
                                        src="<?php echo base_url('userfiles/employee/thumbnail/' . $this->aauth->get_user()->picture) ?>"
                                        alt="avatar"><i></i></span><span
                                    class="user-name"><?php echo $this->lang->line('Account') ?></span></a>
                        <div class="dropdown-menu dropdown-menu-right"><a class="dropdown-item"
                                                                          href="<?php echo base_url(); ?>user/profile"><i
                                        class="ft-user"></i> <?php echo $this->lang->line('Profile') ?></a>
                            <a href="<?php echo base_url(); ?>user/attendance"
                               class="dropdown-item"><i
                                        class="fa fa-list-ol"></i><?php echo $this->lang->line('Attendance') ?></a>
                            <a href="<?php echo base_url(); ?>user/holidays"
                               class="dropdown-item"><i
                                        class="fa fa-hotel"></i><?php echo $this->lang->line('Holidays') ?></a>

                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="<?php echo base_url('user/logout'); ?>"><i
                                        class="ft-power"></i> <?php echo $this->lang->line('Logout') ?></a>
                        </div>
                    </li>
                </ul>

            </div>
        </div>
    </div>
</nav>

<!-- ////////////////////////////////////////////////////////////////////////////-->
<!-- Horizontal navigation-->

<!-- Horizontal navigation-->
<div id="notify" class="alert" style="display:none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>

    <div class="message"></div>
</div>
<div id="thermal_a" class="alert alert-success" style="display:none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>

    <div class="message"></div>
</div>
<div id="c_body"></div>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">


<?php /*
<!DOCTYPE html>
<html lang="en" data-textdirection="ltr" class="loading">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">

    <?php if (@$title) {
        echo "<title>$title</title >";
    } else {
        echo "<title>Geo POS</title >";
    }
    ?>
    <link rel="apple-touch-icon" sizes="60x60" href="<?php echo assets_url(); ?>assets/images/ico/apple-icon-60.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?php echo assets_url(); ?>assets/images/ico/apple-icon-76.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?php echo assets_url(); ?>assets/images/ico/apple-icon-120.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?php echo assets_url(); ?>assets/images/ico/apple-icon-152.png">
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo assets_url(); ?>assets/images/ico/favicon.ico">
    <link rel="shortcut icon" type="image/png" href="<?php echo assets_url(); ?>assets/images/ico/favicon-32.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-touch-fullscreen" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="default">
    <!-- BEGIN VENDOR CSS-->
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url('assets/' . LTR . '/bootstrap.css'); ?>">
    <!-- font icons-->
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url('assets/fonts/icomoon.css'); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url(); ?>assets/fonts/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url(); ?>assets/vendors/css/extensions/pace.css">
    <!-- END VENDOR CSS-->
    <!-- BEGIN ROBUST CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url('assets/' . LTR . '/bootstrap-extended.css') . APPVER; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url('assets/' . LTR . '/app.css') . APPVER; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url('assets/' . LTR . '/colors.css'); ?>">
    <!-- END ROBUST CSS-->
    <!-- BEGIN Page Level CSS-->
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url('assets/' . LTR . '/core/menu/menu-types/vertical-menu.css'); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url('assets/' . LTR . '/core/menu/menu-types/vertical-overlay-menu.css'); ?>">
    <link rel="stylesheet" type="text/css"
          href="<?php echo assets_url('assets/' . LTR . '/core/colors/palette-gradient.css'); ?>">
    <link rel="stylesheet" href="<?php echo assets_url('assets/custom/datepicker.min.css') . APPVER ?>">
    <link rel="stylesheet" href="<?php echo assets_url('assets/custom/jquery.dataTables.css') . APPVER ?>">
    <link rel="stylesheet" href="<?php echo assets_url('assets/custom/summernote-bs4.css') . APPVER; ?>">
    <link rel="stylesheet" href="<?php echo assets_url('assets/custom/select2.min.css') . APPVER; ?>">
    <link rel="stylesheet" href="<?php echo assets_url('assets/tooltipster/css/tooltipster.bundle.min.css') . APPVER; ?>">
    <!-- END Page Level CSS-->
    <!-- BEGIN Custom CSS-->

    <link rel="stylesheet" type="text/css" href="<?php echo assets_url('assets/' . LTR . '/style.css') . APPVER; ?>">
    <link rel="stylesheet" type="text/css" href="<?php echo assets_url('assets/' . LTR . '/custom.css') . APPVER; ?>">
    <link rel="stylesheet" href="<?php echo assets_url('assets/custom/style.css') . APPVER; ?>">
    <!-- END Custom CSS-->

    <script src="<?php echo assets_url(); ?>assets/js/core/libraries/jquery.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url('assets/tooltipster/js/tooltipster.bundle.min.js') . APPVER; ?>"></script>
    <script>
        $(document).ready(function () {
            $('.t_tooltip').tooltipster();

        });
    </script>
    <script src="<?php echo assets_url(); ?>assets/vendors/js/ui/tether.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url(); ?>assets/js/core/libraries/bootstrap.min.js" type="text/javascript"></script>


    <script src="<?php echo assets_url(); ?>assets/portjs/raphael.min.js" type="text/javascript"></script>
    <script src="<?php echo assets_url(); ?>assets/portjs/morris.min.js" type="text/javascript"></script>


    <script src="<?php echo assets_url('assets/myjs/datepicker.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url('assets/myjs/summernote-bs4.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url('assets/myjs/select2.min.js') . APPVER; ?>"></script>


    <script type="text/javascript">var baseurl = '<?php echo base_url() ?>';
        var crsf_token = '<?=$this->security->get_csrf_token_name()?>';
        var crsf_hash = '<?=$this->security->get_csrf_hash(); ?>';</script>
    <script src="<?php echo assets_url('assets/portjs/jquery.validate.min.js') . APPVER; ?>"></script>
    <script src="<?php echo assets_url('assets/portjs/jquery.payment.min.js') . APPVER; ?>"></script>

    <script src="<?php echo assets_url('assets/js/mousetrap.min.js') . APPVER; ?>"></script>

</head>
<body data-open="click" data-menu="vertical-menu" data-col="1-column"
      class="vertical-layout vertical-menu 1-column  fixed-navbar"><span id="hdata"
                                                                         data-df="<?php echo $this->config->item('dformat2'); ?>"
                                                                         data-curr="<?php echo currency($this->aauth->get_user()->loc); ?>"></span>

<!-- navbar-fixed-top-->
<nav id="pos0" class="header-navbar navbar navbar-with-menu navbar-fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav">
                <li class="nav-item mobile-menu hidden-md-up float-xs-left"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs"><i class="icon-menu5 font-large-1"></i></a>
                </li>
                <li class="nav-item"><a href="<?php echo base_url() ?>dashboard/" class="navbar-brand nav-link"><img
                                alt="branding logo" src="<?php echo base_url(); ?>userfiles/theme/logo-header.png"
                                data-expand="<?php echo base_url(); ?>userfiles/theme/logo-header.png"
                                data-collapse="<?php echo assets_url(); ?>assets/images/logo/logo-80x80.png"
                                class="brand-logo height-50"></a></li>
                <li class="nav-item hidden-md-up float-xs-right"><a data-toggle="collapse" data-target="#navbar-mobile"
                                                                    class="nav-link open-navbar-container"><i
                                class="icon-ellipsis pe-2x icon-icon-rotate-right-right"></i></a></li>
            </ul>
        </div>
        <div class="navbar-container content container-fluid">
            <div id="navbar-mobile" class="collapse navbar-toggleable-sm">
                <ul class="nav navbar-nav">

                    <li class="nav-item hidden-sm-down"><a href="#" class="nav-link nav-link-expand"><i
                                    class="icon icon-expand2"></i></a></li>
                    <li class="nav-item hidden-sm-down"><a href="<?= base_url() ?>"
                                                           class="btn btn-success upgrade-to-pro"><?php echo $this->lang->line('Switch to Dashboard') ?></a>
                        &nbsp; &nbsp;
                    </li>
                    <li class="nav-item hidden-sm-down"><a class="btn upgrade-to-pro btn-indigo t_tooltip white"
                                                           title="<?php echo $this->lang->line('Your Register') ?>"
                                                           data-toggle="modal" data-target="#register">&nbsp;<i
                                    class="icon-drawer"></i> </a> &nbsp; &nbsp;
                    </li>
                    <li class="nav-item hidden-sm-down"><a data-toggle="modal" data-target="#close_register"
                                                           class="btn upgrade-to-pro btn-teal white t_tooltip"
                                                           title="<?php echo $this->lang->line('Close') . ' ' . $this->lang->line('Your Register') ?>">&nbsp;<i
                                    class="icon-close-circled"></i> </a> &nbsp; &nbsp;
                    </li>
                    <li class="nav-item hidden-sm-down"><input type="text"
                                                               placeholder="<?php echo $this->lang->line('Search Customer') ?>"
                                                               id="head-customerbox"
                                                               class="nav-link menu-search form-control round"/></li>
                </ul>
                <div id="head-customerbox-result" class="dropdown dropdown-notification"></div>
                <ul class="nav navbar-nav float-xs-right">
                    <li class="dropdown dropdown-language nav-item"><a class="nav-link"><i
                                    class="icon-location22"></i><span
                                    class="selected-language"><?php $loc = location($this->aauth->get_user()->loc);
                                echo $loc['cname']; ?></span></a>

                    </li>
                    <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown"
                                                                           class="nav-link nav-link-label"><i
                                    class="ficon icon-bell4"></i><span
                                    class="tag tag-pill tag-default tag-danger tag-default tag-up"
                                    id="taskcount">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Pending Tasks') ?></span>
                                </h6>
                            </li>
                            <li class="list-group scrollable-container" id="tasklist"></li>
                            <li class="dropdown-menu-footer"><a href="<?php echo base_url('manager/todo') ?>"
                                                                class="dropdown-item text-muted text-xs-center"><?php echo $this->lang->line('Manage tasks') ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-notification nav-item"><a href="#" data-toggle="dropdown"
                                                                           class="nav-link nav-link-label"><i
                                    class="ficon icon-mail6"></i><span
                                    class="tag tag-pill tag-default tag-info tag-default tag-up"><?php echo $this->aauth->count_unread_pms() ?></span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">

                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Messages') ?></span>
                                </h6>
                            </li>
                            <li class="list-group scrollable-container">


                                <?php $list_pm = $this->aauth->list_pms(6, 0, $this->aauth->get_user()->id, false);

                                foreach ($list_pm as $row) {

                                    echo '<a href="' . base_url('messages/view?id=' . $row->pid) . '" class="list-group-item">
                      <div class="media">
                        <div class="media-left"><span class="avatar avatar-sm avatar-online rounded-circle"><img src="' . base_url('userfiles/employee/' . $row->picture) . '"><i></i></span></div>
                        <div class="media-body">
                          <h6 class="media-heading">' . $row->name . '</h6>
                          <p class="notification-text font-small-3 text-muted">' . $row->{'title'} . '</p><small>
                            <time datetime="2015-06-11T18:29:20+08:00" class="media-meta text-muted">' . $row->{'date_sent'} . '</time></small>
                        </div>
                      </div></a>';
                                } ?>

                            </li>
                            <li class="dropdown-menu-footer"><a href="<?php echo base_url('messages') ?>"
                                                                class="dropdown-item text-muted text-xs-center"><?php echo $this->lang->line('Read all messages') ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown dropdown-user nav-item"><a href="#" data-toggle="dropdown"
                                                                   class="dropdown-toggle nav-link dropdown-user-link"><span
                                    class="avatar avatar-online"><img
                                        src="<?php echo base_url('userfiles/employee/thumbnail/' . $this->aauth->get_user()->picture) ?>"
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
<div id="pos1" class="float-xs-right"><span class="pageover_b"><a data-toggle="modal" data-target="#shortkeyboard"><i
                    class="icon icon-keyboard indigo
"></i></a> &nbsp; <a id="hide_header"><i
                    class="icon icon-android-arrow-dropdown-circle blue-grey
"></i></a></span>
</div>
<!-- ////////////////////////////////////////////////////////////////////////////-->
<!-- / main menu-->
 */