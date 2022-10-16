<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4><?php echo $this->lang->line('POS Register Summary'); ?></h4>
            <hr>
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


        </div>
        <div class="font-large-x1 purple p-1" id="param1"></div>
        <div class="card-body">
            <div class="card card-block">
                <form method="get" action="<?= base_url('pos_invoices/register_summary_print') ?>">
                    <div>
                        <div class="form-group row">

                            <label class="col-sm-3 control-label"
                                   for="open_date"><?php echo $this->lang->line('From Date') ?></label>

                            <div class="col-sm-3">
                                <input type="text" class="form-control required"
                                       placeholder="Start Date" name="open_date" id="open_date"
                                       data-toggle="datepicker" autocomplete="false">
                            </div>
                                <label class="col-sm-3 control-label"
                                   for="open_time"><?php echo $this->lang->line('From Time') ?></label>

                            <div class="col-sm-3">

         <input type="time" name="open_time" value="00:00" />
                            </div>
                            <label class="col-sm-3 control-label"
                                   for="open_t_date"><?php echo $this->lang->line('To Date') ?></label>

                            <div class="col-sm-3">
                                <input type="text" class="form-control required"
                                       placeholder="End Date" name="open_t_date" id="open_t_date"
                                       data-toggle="datepicker" autocomplete="false">
                            </div>
                              <label class="col-sm-3 control-label"
                                   for="open_t_time"><?php echo $this->lang->line('To Time') ?></label>

                            <div class="col-sm-3">
                                   <input type="time" name="open_t_time" value="00:00" />
                            </div>
                            
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-3 col-form-label"></label>

                            <div class="col-sm-4">
                                <input type="hidden" name="check" value="ok">
                                <input type="submit" class="btn btn-success margin-bottom"
                                       value="<?php echo $this->lang->line('Print') ?>">
                            </div>
                        </div>
                    </div>

                </form>
            </div>
        </div>
    </div>
