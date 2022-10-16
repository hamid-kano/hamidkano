<link rel="stylesheet" type="text/css"
      href="<?= assets_url() ?>app-assets/<?= LTR ?>/core/menu/menu-types/vertical-menu-modern.css">
</head>
<body class="vertical-layout vertical-menu-modern 2-columns   menu-expanded fixed-navbar" data-open="click"
      data-menu="vertical-menu-modern" data-col="2-columns">
<span id="hdata"
      data-df="<?php echo $this->config->item('dformat2'); ?>"
      data-curr="<?php echo currency($this->aauth->get_user()->loc); ?>"></span>
<!-- fixed-top-->
<nav class="header-navbar navbar-expand-md navbar navbar-with-menu fixed-top navbar-semi-dark navbar-shadow">
    <div class="navbar-wrapper">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mobile-menu d-md-none mr-auto"><a
                            class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i
                                class="ft-menu font-large-1"></i></a></li>
                <li class="nav-item"><a class="navbar-brand" href="<?= base_url() ?>dashboard/">
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


                    <li class="dropdown  nav-item"><a class="nav-link nav-link-label" href="#"
                                                      data-toggle="dropdown"><i
                                    class="ficon ft-map-pin success"></i></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-left">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><i
                                                class="ficon ft-map-pin success"></i><?php echo $this->lang->line('Business') . ' ' . $this->lang->line('Location') ?></span>
                                </h6>
                            </li>

                            <li class="dropdown-menu-footer"><span class="dropdown-item text-muted text-center blue"
                                > <?php $loc = location($this->aauth->get_user()->loc);
                                    echo $loc['cname']; ?></span>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item d-none d-md-block nav-link "><a href="<?= base_url() ?>pos_invoices/create"
                                                                        class="btn btn-info btn-md t_tooltip"
                                                                        title="Access POS"><i
                                    class="icon-handbag"></i><?php echo $this->lang->line('POS') ?> </a>
                    </li>
                    <li class="nav-item nav-search"><a class="nav-link nav-link-search" href="#" aria-haspopup="true"
                                                       aria-expanded="false" id="search-input"><i
                                    class="ficon ft-search"></i></a>
                        <div class="search-input">
                            <input class="input" type="text"
                                   placeholder="<?php echo $this->lang->line('Search Customer') ?>"
                                   id="head-customerbox">
                        </div>
                        <div id="head-customerbox-result" class="dropdown-menu ml-5"
                             aria-labelledby="search-input"></div>
                    </li>
                </ul>

                <ul class="nav navbar-nav float-right"><?php if ($this->aauth->get_user()->roleid == 5) { ?>
                        <li class="dropdown nav-item mega-dropdown"><a class="dropdown-toggle nav-link " href="#"
                                                                       data-toggle="dropdown"><?php echo $this->lang->line('Business') ?><?php echo $this->lang->line('Settings') ?></a>
                            <ul class="mega-dropdown-menu dropdown-menu row">
                                <li class="col-md-3">

                                    <div id="accordionWrap" role="tablist" aria-multiselectable="true">
                                        <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading1" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap" href="#accordion1"
                                                   aria-controls="accordion1"><i
                                                            class="fa fa-leaf"></i> <?php echo $this->lang->line('Business') . '  ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion1" role="tabpanel"
                                                 aria-labelledby="heading1" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/company"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Company') . ' ' . $this->lang->line('Settings') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>locations"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Business Locations') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>tools/setgoals"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Set Goals') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading2" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap" href="#accordion2"
                                                   aria-controls="accordion2"> <i
                                                            class="fa fa-calendar"></i><?php echo $this->lang->line('Localisation') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion2" role="tabpanel"
                                                 aria-labelledby="heading2" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/currency"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Currency') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/language"><i
                                                                        class="ft-chevron-right"></i>Languages</a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/dtformat"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Date & Time Format') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/theme"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Theme') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading3" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap" href="#accordion3"
                                                   aria-controls="accordion3"> <i
                                                            class="fa fa-lightbulb-o"></i><?php echo $this->lang->line('Miscellaneous') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion3" role="tabpanel"
                                                 aria-labelledby="heading3" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                     
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/email"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Email Config') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>transactions/categories"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Transaction Categories') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/misc_automail"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Email') . ' ' . $this->lang->line('Alert') ?>
                                                            </a></li>
                                                       
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>
                                <li class="col-md-3">

                                    <div id="accordionWrap1" role="tablist" aria-multiselectable="true">
                                        <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading4" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap1" href="#accordion4"
                                                   aria-controls="accordion4"><i
                                                            class="fa fa-fire"></i><?php echo $this->lang->line('Advanced') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion4" role="tabpanel"
                                                 aria-labelledby="heading4" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>restapi"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('REST API') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>cronjob"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Automatic Corn Job') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/custom_fields"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Custom') ?> <?php echo $this->lang->line('Fields') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/dual_entry"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Dual Entry') . ' ' . $this->lang->line('Accounting') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/logdata"><i
                                                                        class="ft-chevron-right"></i> Application
                                                                Activity Log</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/debug"><i
                                                                        class="ft-chevron-right"></i> Debug Mode </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading2" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap1" href="#accordion5"
                                                   aria-controls="accordion5"> <i
                                                            class="fa fa-shopping-cart"></i><?php echo $this->lang->line('Billing') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion5" role="tabpanel"
                                                 aria-labelledby="heading5" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/discship"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Discount') . ' & ' . $this->lang->line('Shipping') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/prefix"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Prefix') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/billing_terms"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Billing Terms') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/automail"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Auto Email SMS') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/warehouse"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Default') . ' ' . $this->lang->line('Warehouse') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/zero_stock"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Zero Stock') . ' ' . $this->lang->line('Billing') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/pos_style"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('POS') . ' ' . $this->lang->line('Style') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading6" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap1" href="#accordion6"
                                                   aria-controls="accordion6"><i
                                                            class="fa fa-scissors"></i><?php echo $this->lang->line('Tax') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion6" role="tabpanel"
                                                 aria-labelledby="heading6" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/tax"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Tax') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/taxslabs"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Other') . ' ' . $this->lang->line('Tax') . ' ' . $this->lang->line('Settings') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>
                                <li class="col-md-3">

                                    <div id="accordionWrap2" role="tablist" aria-multiselectable="true">
                                        <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading7" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap2" href="#accordion7"
                                                   aria-controls="accordion7"><i
                                                            class="fa fa-flask"></i><?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion7" role="tabpanel"
                                                 aria-labelledby="heading7" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>units"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Measurement Unit') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>units/variations"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Variations') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>units/variables"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Variations') . ' ' . $this->lang->line('Variables') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading8" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap2" href="#accordion8"
                                                   aria-controls="accordion8"> <i
                                                            class="fa fa-money"></i><?php echo $this->lang->line('Payment Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion8" role="tabpanel"
                                                 aria-labelledby="heading8" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/settings"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Payment Settings') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Payment Gateways') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/currencies"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Payment Currencies') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/exchange"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Currency Exchange') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/bank_accounts"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Bank Accounts') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading9" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap2" href="#accordion9"
                                                   aria-controls="accordion9"><i
                                                            class="fa fa-umbrella"></i><?php echo $this->lang->line('CRM') . ' & ' . $this->lang->line('HRM') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion9" role="tabpanel"
                                                 aria-labelledby="heading9" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>employee/auto_attendance"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Self') . ' ' . $this->lang->line('Attendance') ?>
                                                            </a></li>

                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/registration"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('CRM') . ' ' . $this->lang->line('Settings') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>plugins/recaptcha"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Security') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/tickets"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Support Tickets') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>


                                <li class="col-md-3">

                                    <div id="accordionWrap3" role="tablist" aria-multiselectable="true">
                                        <div class="card border-0 box-shadow-0 collapse-icon accordion-icon-rotate">
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading10" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap3" href="#accordion10"
                                                   aria-controls="accordion10"><i
                                                            class="fa fa-magic"></i><?php echo $this->lang->line('Plugins') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion10" role="tabpanel"
                                                 aria-labelledby="heading10" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>plugins/recaptcha"><i
                                                                        class="ft-chevron-right"></i>reCaptcha Security</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>plugins/shortner"><i
                                                                        class="ft-chevron-right"></i> URL Shortener</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>plugins/twilio"><i
                                                                        class="ft-chevron-right"></i> SMS Configuration</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>paymentgateways/exchange"><i
                                                                        class="ft-chevron-right"></i>Currency Exchange
                                                                API</a></li>
                                                        <?php plugins_checker(); ?>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading11" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap3" href="#accordion11"
                                                   aria-controls="accordion11"> <i
                                                            class="fa fa-eye"></i><?php echo $this->lang->line('Templates') . ' ' . $this->lang->line('Settings') ?>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion11" role="tabpanel"
                                                 aria-labelledby="heading8" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>templates/email"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Email') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>templates/sms"><i
                                                                        class="ft-chevron-right"></i> SMS</a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/print_invoice"><i
                                                                        class="ft-chevron-right"></i> <?php echo $this->lang->line('Print Invoice') ?>
                                                            </a></li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>settings/theme"><i
                                                                        class="ft-chevron-right"></i><?php echo $this->lang->line('Theme') ?>
                                                            </a></li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="card-header p-0 pb-1 border-0 mt-1" id="heading12" role="tab">
                                                <a class=" text-uppercase black" data-toggle="collapse"
                                                   data-parent="#accordionWrap3" href="#accordion12"
                                                   aria-controls="accordion12"><i
                                                            class="fa fa-print"></i>POS Printers</a>
                                                </a></div>
                                            <div class="card-collapse collapse mb-1 " id="accordion12" role="tabpanel"
                                                 aria-labelledby="heading12" aria-expanded="true">
                                                <div class="card-content">
                                                    <ul>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>printer/add"><i
                                                                        class="ft-chevron-right"></i>Add Printer</a>
                                                        </li>
                                                        <li><a class="dropdown-item"
                                                               href="<?php echo base_url(); ?>printer"><i
                                                                        class="ft-chevron-right"></i> List Printers</a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                </li>


                            </ul>
                        </li>       <?php } ?>
                    <li class="dropdown dropdown-notification nav-item"><a class="nav-link nav-link-label" href="#"
                                                                           data-toggle="dropdown"><i
                                    class="ficon ft-bell"></i><span
                                    class="badge badge-pill badge-default badge-danger badge-default badge-up"
                                    id="taskcount">0</span></a>
                        <ul class="dropdown-menu dropdown-menu-media dropdown-menu-right">
                            <li class="dropdown-menu-header">
                                <h6 class="dropdown-header m-0"><span
                                            class="grey darken-2"><?php echo $this->lang->line('Pending Tasks') ?></span><span
                                            class="notification-tag badge badge-default badge-danger float-right m-0">New</span>
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
<div class="main-menu menu-fixed menu-dark menu-accordion menu-shadow" data-scroll-to-active="true">
    <!-- Horizontal menu content-->
    <div class="main-menu-content">

        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <?php if ($this->aauth->get_user()->roleid == 5) { ?>
                <li class="p-1"><select class="form-control"
                                        onchange="javascript:location.href = baseurl+'settings/switch_location?id='+this.value;"> <?php
                        $loc = location($this->aauth->get_user()->loc);
                        echo ' <option value="' . $loc['id'] . '"> *' . $loc['cname'] . '*</option>';

                        $loc = locations();
                        foreach ($loc as $row) {
                            echo ' <option value="' . $row['id'] . '"> ' . $row['cname'] . '</option>';
                        }
                        echo ' <option value="0">Master/Default</option>';
                        ?></select>
                </li> <?php } ?>
                <li class="nav-item "><a href="<?= base_url(); ?>dashboard/"><i
                                class="icon-speedometer"></i><span><?= $this->lang->line('Dashboard') ?></span></a>

                </li>
            <?php
            if ($this->aauth->premission(1)) { ?>
                <li class="nav-item has-sub <?php if ($this->li_a == "sales") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="icon-basket-loaded"></i><span><?php echo $this->lang->line('sales') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item"><a
                                    href="#"><i
                                        class="icon-paper-plane"></i><?php echo $this->lang->line('pos sales') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a href="<?= base_url(); ?>pos_invoices/create"
                                    ><?php echo $this->lang->line('New Invoice'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>pos_invoices/create?v2=true"><?= $this->lang->line('New Invoice'); ?>
                                        V2 - Mobile</a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>pos_invoices"><?php echo $this->lang->line('Manage Invoices'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item"><a href="#"><i
                                        class="icon-basket"></i><?php echo $this->lang->line('sales') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a href="<?= base_url(); ?>invoices/create"
                                                         data-toggle="dropdown"><?php echo $this->lang->line('New Invoice'); ?></a>
                                </li>

                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>invoices"><?php echo $this->lang->line('Manage Invoices'); ?></a>
                            </ul>
                        </li>
                        <li class="menu-item"><a href="#"><i
                                        class="icon-call-out"></i><?php echo $this->lang->line('Quotes') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a
                                            href="<?= base_url(); ?>quote/create"><?php echo $this->lang->line('New Quote'); ?></a>
                                </li>

                                <li class="menu-item"><a class="dropdown-item" href="<?php echo base_url(); ?>quote"
                                                         data-toggle="dropdown"><?php echo $this->lang->line('Manage Quotes'); ?></a>
                            </ul>
                        </li>

                        <li class="menu-item"><a href="#"><i
                                        class="ft-radio"></i><?php echo $this->lang->line('Subscriptions') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a
                                            href="<?= base_url(); ?>subscriptions/create"><?php echo $this->lang->line('New Subscription'); ?></a>
                                </li>

                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>subscriptions"><?php echo $this->lang->line('Subscriptions'); ?></a>
                            </ul>
                        </li>
                        <li class="menu-item">
                            <a href="<?php echo base_url(); ?>stockreturn/creditnotes"><i
                                        class="icon-screen-tablet"></i><?php echo $this->lang->line('Credit Notes'); ?>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(2)) { ?>
                <li class="nav-item has-sub <?php if ($this->li_a == "stock") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="ft-layers"></i><span><?php echo $this->lang->line('Stock') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item"><a
                                    href="#"><i
                                        class="ft-list"></i> <?php echo $this->lang->line('Items Manager') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a
                                            href="<?= base_url(); ?>products/add"> <?php echo $this->lang->line('New Product'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>products"><?= $this->lang->line('Manage Products'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item"><a href="<?php echo base_url(); ?>productcategory"><i
                                        class="ft-umbrella"></i><?php echo $this->lang->line('Product Categories'); ?>
                            </a>
                        </li>
                        <li class="menu-item"><a href="<?php echo base_url(); ?>productcategory/warehouse"><i
                                        class="ft-sliders"></i><?php echo $this->lang->line('Warehouses'); ?></a>
                        </li>
                        <li class="menu-item"><a class="dropdown-item"
                                                 href="<?php echo base_url(); ?>products/stock_transfer"><i
                                        class="ft-wind"></i><?php echo $this->lang->line('Stock Transfer'); ?></a>
                        </li>
                        </li>

                        <li class="menu-item"><a href="#"><i
                                        class="icon-handbag"></i> <?php echo $this->lang->line('Purchase Order') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a class="dropdown-item" href="<?= base_url(); ?>purchase/create"
                                                         data-toggle="dropdown"> <?php echo $this->lang->line('New Order'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>purchase"><?= $this->lang->line('Manage Orders'); ?></a>
                                </li>


                            </ul>
                        </li>

                        <li class="menu-item"><a href="#"><i
                                        class="icon-puzzle"></i> <?php echo $this->lang->line('Stock Return') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a
                                            href="<?= base_url(); ?>stockreturn"> <?php echo $this->lang->line('Suppliers') . ' ' . $this->lang->line('Records'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>stockreturn/customer"><?php echo $this->lang->line('Customers') . ' ' . $this->lang->line('Records'); ?></a>
                                </li>


                            </ul>
                        </li>
                        <li class="menu-item"><a href="#"><i
                                        class="ft-target"></i><?php echo $this->lang->line('Suppliers') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a
                                            href="<?= base_url(); ?>supplier/create"><?php echo $this->lang->line('New Supplier'); ?></a>
                                </li>

                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>supplier"><?php echo $this->lang->line('Manage Suppliers'); ?></a>
                            </ul>
                        </li>
                        <li data-menu=""><a class="dropdown-item"
                                            href="<?php echo base_url(); ?>products/custom_label"
                                            data-toggle="dropdown"><i
                                        class="fa fa-barcode"></i><?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Label'); ?>
                            </a>
                        </li>
                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(3)) {
                ?>
                <li class="nav-item has-sub <?php if ($this->li_a == "crm") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="icon-diamond"></i> <span><?php echo $this->lang->line('CRM') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item"><a href="#"><i
                                        class="ft-users"></i> <?php echo $this->lang->line('Clients') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>customers/create"><?php echo $this->lang->line('New Client') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>customers"><?= $this->lang->line('Manage Clients'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item">
                            <a href="<?php echo base_url(); ?>clientgroup"><i
                                        class="icon-grid"></i> <?php echo $this->lang->line('Client Groups'); ?></a>
                        </li>
                        <li class="menu-item"><a href="#"><i
                                        class="fa fa-ticket"></i> <?php echo $this->lang->line('Support Tickets') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>tickets/?filter=unsolved"><?php echo $this->lang->line('UnSolved') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>tickets"><?= $this->lang->line('Manage Tickets'); ?></a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(4)) {
                ?>
                <li class="menu-item  has-sub <?php if ($this->li_a == "project") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="icon-briefcase"></i><span><?= $this->lang->line('Project') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item"><a href="#"><i
                                        class="icon-calendar"></i> <?php echo $this->lang->line('Project Management') ?>
                            </a>
                            <ul class="menu-content">
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>projects/addproject"><?php echo $this->lang->line('New Project') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>projects"><?= $this->lang->line('Manage Projects'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item">
                            <a href="<?php echo base_url(); ?>tools/todo"><i
                                        class="icon-list"></i> <?php echo $this->lang->line('To Do List'); ?></a>
                        </li>

                    </ul>
                </li>
            <?php }
            if (!$this->aauth->premission(4) && $this->aauth->premission(7)) {
                ?>
                <li class="menu-item has-sub <?php if ($this->li_a == "manager") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="icon-briefcase"></i> <span><?php echo $this->lang->line('Project') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item">
                            <a class="dropdown-item" href="<?php echo base_url(); ?>manager/projects"><i
                                        class="icon-calendar"></i> <?php echo $this->lang->line('Manage Projects'); ?>
                            </a>
                        </li>
                        <li class="menu-item">
                            <a href="<?php echo base_url(); ?>manager/todo"><i
                                        class="icon-list"></i> <?php echo $this->lang->line('To Do List'); ?></a>
                        </li>

                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(5)) {
                ?>
                <li class="menu-item  has-sub <?php if ($this->li_a == "accounts") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="icon-calculator"></i><span><?= $this->lang->line('Accounts') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item"><a href="#" data-toggle="dropdown"><i
                                        class="icon-book-open"></i> <?php echo $this->lang->line('Accounts') ?></a>
                            <ul class="menu-content">
                                <li data-menu=""><a href="<?php echo base_url(); ?>accounts"
                                    ><?php echo $this->lang->line('Manage Accounts') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>accounts/balancesheet"><?= $this->lang->line('BalanceSheet'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/accountstatement"><?= $this->lang->line('Account Statements'); ?></a>
                                </li>
                            </ul>
                        </li>
                        <li class="menu-item"><a href="#"><i
                                        class="icon-wallet"></i> <?php echo $this->lang->line('Transactions') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>transactions"><?php echo $this->lang->line('View Transactions') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>transactions/add"><?= $this->lang->line('New Transaction'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>transactions/transfer"><?= $this->lang->line('New Transfer'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>transactions/income"><?= $this->lang->line('Income'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>transactions/expense"><?= $this->lang->line('Expense'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>customers"><?= $this->lang->line('Clients Transactions'); ?></a>
                                </li>
                            </ul>
                        </li>

                    </ul>
                </li>

                <li class="menu-item  has-sub <?php if ($this->li_a == "promo") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="icon-energy"></i> <span><?php echo $this->lang->line('Promo Codes') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item"><a href="#"><i
                                        class="icon-trophy"></i> <?php echo $this->lang->line('Coupons') ?></a>
                            <ul class="menu-content">
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>promo/create"><?php echo $this->lang->line('New Promo') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>promo"><?= $this->lang->line('Manage Promo'); ?></a>
                                </li>
                            </ul>
                        </li>


                    </ul>
                </li>

            <?php }
            if ($this->aauth->premission(10)) {
                ?>
                <li class="menu-item  has-sub <?php if ($this->li_a == "data") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="icon-pie-chart"></i>
                        <span><?php echo $this->lang->line('Data & Reports') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item">
                            <a href="<?php echo base_url(); ?>register"><i
                                        class="icon-eyeglasses"></i> <?php echo $this->lang->line('Business Registers'); ?>
                            </a>
                        </li>

                        <li class="menu-item"><a href="#"><i
                                        class="icon-doc"></i> <?php echo $this->lang->line('Statements') ?></a>
                            <ul class="menu-content">

                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/accountstatement"><?= $this->lang->line('Account Statements'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/customerstatement"><?php echo $this->lang->line('Customer') . ' ' . $this->lang->line('Account Statements') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/supplierstatement"><?php echo $this->lang->line('Supplier') . ' ' . $this->lang->line('Account Statements') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/taxstatement"><?php echo $this->lang->line('TAX') . ' ' . $this->lang->line('Statements'); ?></a>
                                </li>
                            </ul>
                        </li>

                        <li class="menu-item"><a href="#"><i
                                        class="icon-bar-chart"></i> <?php echo $this->lang->line('Graphical Reports') ?>
                            </a>
                            <ul class="menu-content">

                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>chart/product_cat"><?= $this->lang->line('Product Categories'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>chart/trending_products"><?= $this->lang->line('Trending Products'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>chart/profit"><?= $this->lang->line('Profit'); ?></a>
                                </li>

                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>chart/topcustomers"><?php echo $this->lang->line('Top') . ' ' . $this->lang->line('Customers') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>chart/incvsexp"><?php echo $this->lang->line('Income') . ' vs ' . $this->lang->line('Expenses') ?></a>
                                </li>

                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>chart/income"><?= $this->lang->line('Income'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>chart/expenses"><?= $this->lang->line('Expenses'); ?></a>


                            </ul>
                        </li>
                        <li class="menu-item"><a href="#"><i
                                        class="icon-bulb"></i> <?php echo $this->lang->line('Summary') . ' & ' . $this->lang->line('Report') ?>
                            </a>
                            <ul class="menu-content">
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/statistics"><?php echo $this->lang->line('Statistics') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/profitstatement"><?= $this->lang->line('Profit'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/incomestatement"><?php echo $this->lang->line('Calculate Income'); ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/expensestatement"><?php echo $this->lang->line('Calculate Expenses') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/sales"><?php echo $this->lang->line('Sales') ?></a>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/products"><?php echo $this->lang->line('Products') ?></a>
                                </li>
                                </li>
                                <li class="menu-item"><a
                                            href="<?php echo base_url(); ?>reports/commission"><?= $this->lang->line('Employee'); ?> <?= $this->lang->line('Commission'); ?></a>
                                </li>

                            </ul>
                        </li>

                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(6)) {
                ?>
                <li class="menu-item  has-sub <?php if ($this->li_a == "misc") {
                    echo ' open';
                } ?>"><a href="#"><i
                                class="icon-note"></i><span><?php echo $this->lang->line('Miscellaneous') ?></span></a>
                    <ul class="menu-content">
                        <li class="menu-item">
                            <a href="<?php echo base_url(); ?>tools/notes"><i
                                        class="icon-note"></i> <?php echo $this->lang->line('Notes'); ?></a>
                        </li>
                        <li class="menu-item">
                            <a href="<?php echo base_url(); ?>events"><i
                                        class="icon-calendar"></i> <?php echo $this->lang->line('Calendar'); ?></a>
                        </li>
                        <li class="menu-item">
                            <a href="<?php echo base_url(); ?>tools/documents"><i
                                        class="icon-doc"></i> <?php echo $this->lang->line('Documents'); ?></a>
                        </li>


                    </ul>
                </li>
            <?php }
            if ($this->aauth->premission(9)) {
                ?>
                <li class="menu-item  has-sub <?php if ($this->li_a == "emp") {
                    echo ' open';
                } ?>""><a href="#"><i
                            class="ft-file-text"></i><span><?php echo $this->lang->line('HRM') ?></span></a>
                <ul class="menu-content">
                    <li class="menu-item"><a href="#"><i
                                    class="ft-users"></i> <?php echo $this->lang->line('Employees') ?></a>
                        <ul class="menu-content">
                            <li class="menu-item"><a
                                        href="<?php echo base_url(); ?>employee"><?php echo $this->lang->line('Employees') ?></a>
                            </li>
                            <li class="menu-item"><a
                                        href="<?php echo base_url(); ?>employee/permissions"><?= $this->lang->line('Permissions'); ?></a>
                            </li>
                            <li class="menu-item"><a
                                        href="<?php echo base_url(); ?>employee/salaries"><?= $this->lang->line('Salaries'); ?></a>
                            </li>
                            <li class="menu-item"><a
                                        href="<?php echo base_url(); ?>employee/attendances"><?= $this->lang->line('Attendance'); ?></a>
                            </li>
                            <li class="menu-item"><a
                                        href="<?php echo base_url(); ?>employee/holidays"><?= $this->lang->line('Holidays'); ?></a>
                            </li>
                        </ul>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo base_url(); ?>employee/departments"><i
                                    class="icon-folder"></i> <?php echo $this->lang->line('Departments'); ?></a>
                    </li>
                    <li class="menu-item">
                        <a href="<?php echo base_url(); ?>employee/payroll"><i
                                    class="icon-notebook"></i> <?php echo $this->lang->line('Payroll'); ?></a>
                    </li>

                </ul>
                </li>
            <?php }
            if ($this->aauth->get_user()->roleid > 4) {
                ?>
                <li class="menu-item   has-sub <?php if ($this->li_a == "export") {
                    echo ' open';
                } ?>""><a href="#"><i
                            class="ft-bar-chart-2"></i>
                    <span><?php echo $this->lang->line('Backup & Export') . '-' . $this->lang->line('Import'); ?></span></a>
                <ul class="menu-content">
                    <li class="menu-item"><a href="<?php echo base_url(); ?>export/crm"><i
                                    class="fa fa-caret-right"></i> <?php echo $this->lang->line('Export People Data'); ?>
                        </a>
                    </li>
                    <li class="menu-item"><a href="<?php echo base_url(); ?>export/transactions"><i
                                    class="fa fa-caret-right"></i> <?php echo $this->lang->line('Export Transactions'); ?>
                        </a></li>
                    <li class="menu-item"><a href="<?php echo base_url(); ?>export/products"><i
                                    class="fa fa-caret-right"></i> <?php echo $this->lang->line('Export Products'); ?>
                        </a></li>
                    <li><a href="<?php echo base_url(); ?>export/account"><i
                                    class="fa fa-caret-right"></i> <?php echo $this->lang->line('Account Statements'); ?>
                        </a></li>
                    <li><a href="<?php echo base_url(); ?>export/people_products"><i
                                    class="fa fa-caret-right"></i> <?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Account Statements'); ?>
                        </a></li>
                    <li><a
                                href="<?php echo base_url(); ?>export/taxstatement"><i
                                    class="fa fa-caret-right"></i> <?php echo $this->lang->line('TAX') . ' ' . $this->lang->line('Backup & Export'); ?>
                        </a></li>
                    <li><a href="<?php echo base_url(); ?>export/dbexport"><i
                                    class="fa fa-caret-right"></i> <?php echo $this->lang->line('Database Backup'); ?>
                        </a></li>
                    <li><a href="<?php echo base_url(); ?>import/products"><i
                                    class="fa fa-caret-right"></i></i> <?php echo $this->lang->line('Import Products'); ?>
                        </a></li>
                    <li><a href="<?php echo base_url(); ?>import/customers"><i
                                    class="fa fa-caret-right"></i> <?php echo $this->lang->line('Import Customers'); ?>
                        </a></li>
                    <li class="mt-1"></li>


                </ul>


                </li>
            <?php }
            ?>

        </ul>
    </div>
    <!-- /horizontal menu content-->
</div>
<!-- Horizontal navigation-->
<div id="c_body"></div>
<div class="app-content content">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">