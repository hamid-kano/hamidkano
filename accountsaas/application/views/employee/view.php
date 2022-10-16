<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Employee Details') ?></h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">


                <div class="row">
                    <div class="col-md-4 border-right">

                        <img alt="image" class="img-responsive col"
                             src="<?php echo base_url('userfiles/employee/' . $employee['picture']); ?>">

                        <hr>

                        <h4><strong><?php echo $employee['name'] ?></strong></h4>
                        <p><i class="icon-map-marker"></i> <?php echo $employee['city'] ?></p>

                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('Address') ?>
                                    : </strong><?php echo $employee['address'] ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('City') ?>
                                    : </strong><?php echo $employee['city'] ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('Region') ?>
                                    : </strong><?php echo $employee['region'] ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('Country') ?>
                                    : </strong><?php echo $employee['country'] ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('PostBox') ?>
                                    : </strong><?php echo $employee['postbox'] ?>
                            </div>

                        </div>
                        <hr>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong><?php echo $this->lang->line('Phone') ?></strong> <?php echo $employee['phone']; ?>
                            </div>

                        </div>
                        <div class="row m-t-lg">
                            <div class="col-md-12">
                                <strong>EMail</strong> <?php echo $employee['email']; ?>
                            </div>

                        </div>


                    </div>

                    <div class="col-md-8">
                        <div class="card card-block">
                            <div class="container">
                                <div id="notify" class="alert alert-success" style="display:none;">
                                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                                    <div class="message"></div>
                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">
                                            <div class="icon">
                                                <i class="icon-file-text-o"></i>
                                            </div>
                                            <div class="text">


                                            </div>
                                            <div class="options">
                                                <a href="<?php echo base_url('employee/invoices?id=' . $eid.'&ref='.$ref) ?>"
                                                   class="btn btn-primary btn-block"><i
                                                            class="icon-eye"></i> <?php echo $this->lang->line('Invoices') ?> <?php echo $this->lang->line('View') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">
                                            <div class="icon">
                                                <i class="icon-book"></i>
                                            </div>
                                            <div class="text">


                                            </div>
                                            <div class="options">
                                                <a href="<?php echo base_url('employee/transactions?id=' . $eid.'&ref='.$ref) ?>"
                                                   class="btn btn-purple btn-block"><i
                                                            class="icon-eye"></i> <?php echo $this->lang->line('Transactions') ?> <?php echo $this->lang->line('View') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">
                                            <div class="icon">
                                                <i class="icon-quote"></i>
                                            </div>
                                            <div class="text">


                                            </div>
                                            <div class="options">
                                                <a href="<?php echo base_url('quote?eid=' . $eid.'&ref='.$ref) ?>"
                                                   class="btn btn-pink btn-block"><i
                                                            class="icon-eye"></i> <?php echo $this->lang->line('Quotes') ?> <?php echo $this->lang->line('View') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">
                                            <div class="icon">
                                                <i class="icon-projector"></i>
                                            </div>
                                            <div class="text">


                                            </div>
                                            <div class="options">
                                                <a href="<?php echo base_url('projects?eid=' . $eid.'&ref='.$ref) ?>"
                                                   class="btn btn-success btn-block"><i
                                                            class="icon-eye"></i> <?php echo $this->lang->line('Projects') ?> <?php echo $this->lang->line('View') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">
                                            <div class="icon">
                                                <i class="icon-tasks"></i>
                                            </div>
                                            <div class="text">


                                            </div>
                                            <div class="options">
                                                <a href="#pop_model" data-toggle="modal" data-remote="false"
                                                   class="btn btn-purple btn-block"><i
                                                            class="icon-eye"></i> <?php echo $this->lang->line('Sales') ?> <?php echo $this->lang->line('View') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">
                                            <div class="icon">
                                                <i class="icon-money4"></i>
                                            </div>
                                            <div class="text">


                                            </div>
                                            <div class="options">
                                                <a href="#pop_model2" data-toggle="modal" data-remote="false"
                                                   class="btn btn-blue btn-block"><i
                                                            class="icon-eye"></i> <?php echo $this->lang->line('Total Income') ?> <?php echo $this->lang->line('View') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <div class="row mb-2">

                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">


                                            <div class="options">
                                                <a href="<?php echo base_url('employee/update?id=' . $eid.'&ref='.$ref) ?>"
                                                   class="btn btn-info btn-block"><i
                                                            class="fa fa-user"></i> <?php echo $this->lang->line('Edit') ?> <?php echo $this->lang->line('Account') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">


                                            <div class="options">
                                                <a href="<?php echo base_url('employee/updatepassword?id=' . $eid.'&ref='.$ref) ?>"
                                                   class="btn btn-primary btn-block"><i
                                                            class="fa fa-key"></i> <?php echo $this->lang->line('Change Password') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="pop_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Calculate Total Sales') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_model">


                        <div class="row">
                            <div class="col mb-1"><label
                                        for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                                <?php echo $this->lang->line('Do you want mark') ?>

                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" class="form-control required"
                                   name="eid" id="invoiceid" value="<?php echo $eid ?>">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                            <input type="hidden" id="action-url" value="employee/calc_sales">
                            <button type="button" class="btn btn-primary"
                                    id="submit_model"><?php echo $this->lang->line('Yes') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="pop_model2" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Calculate Income') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_model2">


                        <div class="row">
                            <div class="col mb-1"><label for="pmethod">Mark As</label>
                                Do you want to calculate total income expenses of this employee ?
                            </div>
                        </div>

                        <div class="modal-footer">
                            <input type="hidden" class="form-control required"
                                   name="eid" id="invoiceid" value="<?php echo $eid ?>">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <input type="hidden" id="action-url" value="employee/calc_income">
                            <button type="button" class="btn btn-primary" id="submit_model2">Yes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>