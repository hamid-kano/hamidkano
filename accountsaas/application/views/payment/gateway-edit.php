<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <form method="post" id="data_form" class="form-horizontal">
        <div class="card-body">

            <h5><?php echo $this->lang->line('Edit Gateway Details') . ' ( ' . $gateway['name'] ?>)</h5>
            <hr>


            <input type="hidden" name="gid" value="<?php echo $gateway['id'] ?>">

            <div class="form-group row">

                <label class="col-sm-4 col-form-label"
                       for="currency"><?php echo $this->lang->line('Currency Code') ?>
                    <small>(i.e. USD,AUD)</small>
                </label>

                <div class="col-sm-8">
                    <input type="text"
                           class="form-control margin-bottom  required" name="currency"
                           value="<?php echo $gateway['currency'] ?>">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-4 col-form-label" for="key1"><?php echo $this->lang->line('API Key') ?></label>

                <div class="col-sm-8">
                    <input type="text"
                           class="form-control margin-bottom  required" name="key1"
                           value="<?php echo $gateway['key1'] ?>">
                </div>
            </div>
            <?php if ($gateway['key2'] != 'none') { ?>
                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="key2"><?php echo $this->lang->line('Key 2') ?></label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="key2"
                               value="<?php echo $gateway['key2'] ?>">
                    </div>
                </div>
            <?php } ?>

            <?php if ($gateway['extra'] != 'none') { ?>
                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="key2"><?php echo $this->lang->line('Other') ?></label>

                    <div class="col-sm-8">
                        <input type="text"
                               class="form-control margin-bottom  required" name="key2"
                               value="<?php echo $gateway['extra'] ?>">
                    </div>
                </div>
            <?php } ?>

            <div class="form-group row">

                <label class="col-sm-4 col-form-label"
                       for="enable"><?php echo $this->lang->line('Enable Gateway') ?></label>

                <div class="col-sm-8">
                    <select class="form-control" name="enable">
                        <option value="<?php echo $gateway['enable'] ?>">
                            --<?php echo $this->lang->line($gateway['enable']) ?>--
                        </option>
                        <option value="Yes"><?php echo $this->lang->line('Yes') ?></option>
                        <option value="No"><?php echo $this->lang->line('No') ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-4 col-form-label"
                       for="devmode"><?php echo $this->lang->line('Test Mode') ?></label>

                <div class="col-sm-8">
                    <select class="form-control" name="devmode">
                        <option value="<?php echo $gateway['dev_mode'] ?>">--<?php echo $gateway['dev_mode'] ?>--
                        </option>
                        <option value="true">true</option>
                        <option value="false">false</option>
                    </select>
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-4 col-form-label"
                       for="key2"><?php echo $this->lang->line('Processing Fee') ?> (in %)</label>

                <div class="col-sm-8">
                    <input type="text"
                           class="form-control margin-bottom  required" name="p_fee"
                           value="<?php echo $gateway['surcharge'] ?>">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-4 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    <input type="hidden" value="paymentgateways/edit" id="action-url">
                </div>
            </div>

        </div>
    </form>

</div>