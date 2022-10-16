<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $employee['name'] ?></h5>
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


                        <div class="">
                            <img alt="image" class="card-img-top img-fluid"
                                 src="<?php echo base_url('userfiles/employee/' . $employee['picture']); ?>">
                        </div>
                        <hr>
                        <div class="">
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
                            <div class="row m-t-lg">
                                <div class="col-md-12">
                                    <strong><?php echo $this->lang->line('Salary') ?></strong> <?php
                                    echo ' ' . amountExchange($employee['salary'], 0, $this->aauth->get_user()->loc); ?>
                                </div>

                            </div>


                        </div>


                    </div>
                    <div class="col-md-8">
                        <div class="card card-block">
                            <div class="container">
                                <div class="row mb-2">
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">
                                            <div class="icon">
                                                <i class="icon-file-text-o"></i>
                                            </div>
                                            <div class="text">


                                            </div>
                                            <div class="options">
                                                <a href="<?php echo base_url('employee/invoices?id=' . $eid) ?>"
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
                                                <a href="<?php echo base_url('employee/transactions?id=' . $eid) ?>"
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


                                            <div class="options">
                                                <a href="<?php echo base_url('user/update?id=' . $eid) ?>"
                                                   class="btn btn-info btn-block"><i
                                                            class="fa fa-user"></i> <?php echo $this->lang->line('Edit') ?> <?php echo $this->lang->line('Account') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">


                                            <div class="options">
                                                <a href="<?php echo base_url('user/updatepassword?id=' . $eid) ?>"
                                                   class="btn btn-primary btn-block"><i
                                                            class="fa fa-key"></i> <?php echo $this->lang->line('Change Password') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">


                                            <div class="options">
                                                <a href="<?php echo base_url('user/salary?id=' . $eid) ?>"
                                                   class="btn btn-pink btn-block"><i
                                                            class="fa fa-money"></i> <?php echo $this->lang->line('Salary') ?>
                                                </a>
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-sm-6">
                                        <div class="hero-widget well well-sm">


                                            <p class="text-muted"><?php echo $this->lang->line('Your Signature') ?></p>

                                            <img alt="image" class="card-img-top img-fluid"
                                                 src="<?php echo base_url('userfiles/employee_sign/' . $employee['sign']); ?>">
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