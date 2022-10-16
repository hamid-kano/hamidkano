<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="product_action" class="form-horizontal">
            <div class="card-body">

                <h5><?php echo $this->lang->line('CRM') ?><?php echo $this->lang->line('Settings') ?></h5>
                <hr>


                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Self') ?> <?php echo $this->lang->line('Customer') ?>  <?php echo $this->lang->line('Registration') ?>
                        Registration</label>

                    <div class="col-sm-6"><select name="register" class="form-control">

                            <?php switch ($current['key1']) {
                                case '1' :
                                    echo '<option value="1">** ' . $this->lang->line('Yes') . ' **</option>';
                                    break;
                                case '0' :
                                    echo '<option value="0">**' . $this->lang->line('No') . '**</option>';
                                    break;

                            } ?>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>


                        </select>

                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Customer') ?> Registration With Email
                        Verification</label>

                    <div class="col-sm-6"><select name="email_conf" class="form-control">

                            <?php switch ($current['url']) {
                                case '1' :
                                    echo '<option value="1">** ' . $this->lang->line('Yes') . ' **</option>';
                                    break;
                                case '0' :
                                    echo '<option value="0">**' . $this->lang->line('No') . '**</option>';
                                    break;

                            } ?>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>


                        </select>

                    </div>
                </div>

                <hr>

                <div class="form-group row"><p class="m-1">Send automatic Email during customer registration by
                        employee. Please do not enable this feature unnecessarily, it may slow the customer registration
                        process as the application will connect to email server if your email is slow.
                    </p>
                    <label class="col-sm-4 col-form-label"
                           for="product_name">Auto Email Customer Details (Registration by Employee) </label>

                    <div class="col-sm-6"><select name="automail" class="form-control">

                            <?php switch ($current['other']) {
                                case '1' :
                                    echo '<option value="1">** ' . $this->lang->line('Yes') . ' **</option>';
                                    break;
                                case '0' :
                                    echo '<option value="0">**' . $this->lang->line('No') . '**</option>';
                                    break;

                            } ?>
                            <option value="1"><?php echo $this->lang->line('Yes') ?></option>
                            <option value="0"><?php echo $this->lang->line('No') ?></option>


                        </select>

                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    </div>
                </div>

            </div>
        </form>
    </div>

</article>
<script type="text/javascript">
    $("#billing_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/registration';
        actionProduct(actionurl);
    });
</script>
