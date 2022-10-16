<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add Promo') ?></h5>
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
            <div class="card-body">


                <form method="post" id="data_form" class="form-horizontal">


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="code"><?php echo $this->lang->line('Code') ?></label>

                        <div class="col-sm-4">
                            <input type="text" placeholder="Code"
                                   class="form-control margin-bottom  required" name="code"
                                   value="<?php echo $this->coupon->generate(8) ?>">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="amount"><?php echo $this->lang->line('Amount') ?></label>

                        <div class="col-sm-4">
                            <input type="text" placeholder="Amount"
                                   class="form-control margin-bottom  required" name="amount" value="0"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="qty"><?php echo $this->lang->line('Qty') ?></label>

                        <div class="col-sm-2">
                            <input type="number" placeholder="Amount"
                                   class="form-control margin-bottom  required" name="qty" value="1">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="valid"><?php echo $this->lang->line('Valid') ?></label>

                        <div class="col-sm-2">
                            <input type="text" class="form-control required"
                                   placeholder="Start Date" name="valid"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>
                    <div class="form-group row"><label class="col-sm-2 col-form-label"
                                                       for="link_ac"><?php echo $this->lang->line('Link to account') ?></label>
                        <div class="col-sm-6">
                            <fieldset>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="link_ac" id="customRadio1"
                                           value="yes" checked="">
                                    <label class="custom-control-label"
                                           for="customRadio1"><?php echo $this->lang->line('Yes') ?> &nbsp;</label>
                                </div>
                            </fieldset>
                            <fieldset>
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" name="link_ac" id="customRadio2"
                                           value="no">
                                    <label class="custom-control-label"
                                           for="customRadio2"><?php echo $this->lang->line('No') ?></label>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_acc"><?php echo $this->lang->line('Account') ?></label>

                        <div class="col-sm-4">
                            <select name="pay_acc" class="form-control">
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

                        <label class="col-sm-2 control-label"
                               for="note"><?php echo $this->lang->line('Note') ?></label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Short Note"
                                   class="form-control margin-bottom" name="note">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                            <input type="hidden" value="promo/create" id="action-url">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>