<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h3><?php echo $account['holder'] . ' ';
                echo $this->lang->line('Details') ?></h3>
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
                    <div class="col-sm-6">

                        <div class="stat">
                            <div class="name"> <?php echo $this->lang->line('Account No') ?></div>
                            <div class="value"> <?php echo $account['acn'] ?></div>

                        </div>
                        <hr>
                    </div>
                    <div class="col-sm-6 stat-col">

                        <div class="stat">
                            <div class="name"> <?php echo $this->lang->line('Name') ?></div>
                            <div class="value"> <?php echo $account['holder'] ?></div>

                        </div>
                        <hr>
                    </div>

                    <div class="col-sm-6 stat-col">

                        <div class="stat">
                            <div class="name"><?php echo $this->lang->line('Balance') ?></div>
                            <div class="value font-medium-2 font-weight-bold"> <?= amountExchange(abs($account['lastbal']), 0, $this->aauth->get_user()->loc) ?></div>

                        </div>
                        <hr>
                    </div>
                    <div class="col-sm-6 stat-col">

                        <div class="stat">
                            <div class="name"> <?php echo $this->lang->line('Opening Date') ?></div>
                            <div class="value"> <?php echo dateformat_time($account['adate']) ?></div>

                        </div>
                        <hr>
                    </div>
                    <div class="col-sm-6 stat-col">

                        <div class="stat">
                            <div class="name"> <?php echo $this->lang->line('Note') ?></div>
                            <div class="value"> <?php echo $account['code'] ?></div>

                        </div>
                        <hr>
                    </div>
                    <div class="col-sm-6 stat-col">

                        <div class="stat">
                            <div class="name"> <?php echo $this->lang->line('Type') ?></div>
                            <div class="value"> <?php echo $account['account_type'] ?></div>

                        </div>
                        <hr>
                    </div>
                </div>


                <div class="row ">
                    <div class="col-md-12 m-1">
                        <form action="<?php echo base_url() ?>reports/viewstatement" method="post"
                              role="form">
                            <input type="hidden"
                                   name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                   value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input name="pay_acc" type="hidden" value="<?php echo $account['id'] ?>">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('Type') ?></label>

                                <div class="col-md-4">
                                    <select name="trans_type" class="form-control">
                                        <option value='All'><?php echo $this->lang->line('All Transactions') ?></option>
                                        <option value='Expense'><?php echo $this->lang->line('Debit') ?></option>
                                        <option value='Income'><?php echo $this->lang->line('Credit') ?></option>
                                    </select>


                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-md-2 control-label"
                                       for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                                <div class="col-md-4">
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="sdate" id="sdate"
                                           autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-md-2 control-label"
                                       for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                <div class="col-md-4">
                                    <input type="text" class="form-control required"
                                           placeholder="End Date" name="edate"
                                           data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="pay_cat"></label>

                                <div class="col-md-4">
                                    <input type="submit" class="btn btn-primary btn-md" value="View">


                                </div>
                            </div>

                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>