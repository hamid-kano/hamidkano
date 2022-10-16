<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <form method="post" id="data_form" class="form-horizontal">
        <div class="card-body">

            <h5><?php echo $this->lang->line('Online Payment Settings') ?></h5>
            <hr>


            <div class="form-group row">

                <label class="col-sm-5 col-form-label"
                       for="enable"><?php echo $this->lang->line('Enable Online Payment for Invoices') ?></label>

                <div class="col-sm-5">
                    <select class="form-control" name="enable">
                        <option value="<?php echo $online_pay['enable'] ?>">
                            --<?php if ($online_pay['enable'] == 1) {
                                echo $this->lang->line('Yes');
                            } else {
                                echo $this->lang->line('No');
                            } ?>--
                        </option>
                        <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                        <option value="0"><?php echo $this->lang->line('No') ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-5 col-form-label"
                       for="enable"><?php echo $this->lang->line('Enable Bank Payment Button') ?></label>

                <div class="col-sm-5">
                    <select class="form-control" name="bank">
                        <option value="<?php echo $online_pay['bank'] ?>">
                            --<?php if ($online_pay['bank'] == 1) {
                                echo $this->lang->line('Yes');
                            } else {
                                echo $this->lang->line('No');
                            } ?>--
                        </option>
                        <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                        <option value="0"><?php echo $this->lang->line('No') ?></option>
                    </select>
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-5 col-form-label"
                       for="account"><?php echo $this->lang->line('credit-online-payment') ?></label>

                <div class="col-sm-5">
                    <select name="account" class="form-control">

                        <?php
                        echo '<option value="' . $online_pay['default_acid'] . '">--' . $online_pay['holder'] . ' / ' . $online_pay['acn'] . '--</option>';

                        foreach ($acclist as $row) {
                            echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>

                        <div class="form-group row">

                <label class="col-sm-5 col-form-label"
                       for="enable">POS : <?php echo $this->lang->line('Payment').' '.$this->lang->line('Accounts').' '.$this->lang->line('List') ?></label>

                <div class="col-sm-5">
                    <select class="form-control" name="pos_list">
                        <option value="<?php echo $online_pay['bank'] ?>">
                            --<?php if (PAC) {
                                echo $this->lang->line('Yes');
                            } else {
                                echo $this->lang->line('No');
                            } ?>--
                        </option>
                        <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                        <option value="0"><?php echo $this->lang->line('No') ?></option>
                    </select>
                </div>
            </div>


            <div class="form-group row">

                <label class="col-sm-5 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    <input type="hidden" value="paymentgateways/settings" id="action-url">
                </div>
            </div>

        </div>
    </form>

</div>