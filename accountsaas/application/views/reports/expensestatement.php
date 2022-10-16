<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4><?php echo $this->lang->line('Expense Statement') ?></h4>
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


        <div class="card-body">
            <div class="col-md-6">
                <div class="card ">

                    <p><?php echo $this->lang->line('This Month Expenses') ?><?php echo amountExchange($income['monthinc'], 0, $this->aauth->get_user()->loc) ?></p>
                    <p id="param1"></p>
                    <p id="param2"></p>


                </div>
            </div>

        </div>

    </div>

</div>
<div class="card card-block">
    <div class="card-body">
        <form method="post" id="product_action" class="form-horizontal">
            <div class="grid_3 grid_4">
                <h6><?php echo $this->lang->line('Custom Range') ?></h6>
                <hr>


                <div class="form-group row">

                    <label class="col-sm-3 col-form-label"
                           for="pay_cat"><?php echo $this->lang->line('Account') ?></label>

                    <div class="col-sm-6">
                        <select name="pay_acc" class="form-control">
                            <option value='0'><?php echo $this->lang->line('All Accounts') ?></option>
                            <?php
                            foreach ($accounts as $row) {
                                $cid = $row['id'];
                                $acn = $row['acn'];
                                $holder = $row['holder'];
                                echo "<option value='$cid'>$acn - $holder</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-3 control-label"
                           for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control required"
                               placeholder="Start Date" name="sdate" id="sdate"
                               data-toggle="datepicker" autocomplete="false">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-3 control-label"
                           for="edate"><?php echo $this->lang->line('To Date') ?></label>

                    <div class="col-sm-4">
                        <input type="text" class="form-control required"
                               placeholder="End Date" name="edate"
                               data-toggle="datepicker" autocomplete="false">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-3 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="hidden" name="check" value="ok">
                        <input type="submit" id="calculate_expense" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Calculate') ?>"
                               data-loading-text="Calculating...">
                    </div>
                </div>
            </div>

        </form>
    </div>
</div>
</div>
