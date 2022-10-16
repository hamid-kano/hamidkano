<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <form method="post" id="data_form" class="form-horizontal">
        <div class="card-body">

            <h5><?php echo $this->lang->line('Add Bank Account') ?></h5>
            <hr>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Name') ?></label>

                <div class="col-sm-8">
                    <input type="text"
                           class="form-control margin-bottom  required" name="name">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="acn"><?php echo $this->lang->line('Account Number') ?></label>

                <div class="col-sm-8">
                    <input type="text"
                           class="form-control margin-bottom  required" name="acn">
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="key2"><?php echo $this->lang->line('IBAN') ?></label>

                <div class="col-sm-8">
                    <input type="text"
                           class="form-control margin-bottom  required" name="code">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="enable"><?php echo $this->lang->line('Enable Account') ?></label>

                <div class="col-sm-8">
                    <select class="form-control" name="enable">
                        <option value="Yes"><?php echo $this->lang->line('Yes') ?></option>
                        <option value="No"><?php echo $this->lang->line('No') ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="note">Bank</label>

                <div class="col-sm-8">
                    <input type="text"
                           class="form-control margin-bottom  required" name="bank">
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="address">Branch</label>

                <div class="col-sm-8">
                    <input type="text"
                           class="form-control margin-bottom  required" name="branch">
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"
                       for="address"><?php echo $this->lang->line('Address') ?></label>

                <div class="col-sm-8">
                    <input type="text"
                           class="form-control margin-bottom  required" name="address">
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    <input type="hidden" value="paymentgateways/add_bank_ac" id="action-url">
                </div>
            </div>

        </div>
    </form>

</div>