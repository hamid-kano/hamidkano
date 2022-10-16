<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Set Goals') ?>
                <small>(in <?php echo $this->config->item('currency') ?>)</small>
            </h5>
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


                <form method="post" id="data_form" class="form-horizontal">


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="income"><?php echo $this->lang->line('Income') ?></label>

                        <div class="col-sm-5">
                            <input type="text" placeholder="Income"
                                   class="form-control margin-bottom  required" name="income"
                                   value="<?php echo $goals['income'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="expense"><?php echo $this->lang->line('Expenses') ?></label>

                        <div class="col-sm-5">
                            <input type="text" placeholder="Expenses"
                                   class="form-control margin-bottom  required" name="expense"
                                   value="<?php echo $goals['expense'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="sales"><?php echo $this->lang->line('Sales') ?></label>

                        <div class="col-sm-5">
                            <input type="text" placeholder="Sales"
                                   class="form-control margin-bottom  required" name="sales"
                                   value="<?php echo $goals['sales'] ?>">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="netincome"><?php echo $this->lang->line('Net Income') ?></label>

                        <div class="col-sm-5">
                            <input type="text" placeholder="Net Income"
                                   class="form-control margin-bottom  required" name="netincome"
                                   value="<?php echo $goals['netincome'] ?>">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Adding...">
                            <input type="hidden" value="tools/setgoals" id="action-url">
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>