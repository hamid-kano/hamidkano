<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="product_action" class="card-body">
            <div class="card card-block">

                <h5><?php echo $this->lang->line('Edit Tax Details') ?></h5>
                <hr>


                <input type="hidden" name="id" value="<?php echo $company['id'] ?>">


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="taxstatus"><?php echo $this->lang->line('TAX Status') ?></label>

                    <div class="col-sm-6">
                        <select name="taxstatus" class="form-control">

                            <?php echo $taxlist; ?>

                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="taxstatus">GST Type</label>

                    <div class="col-sm-6">
                        <select name="gst_type" class="form-control">

                            <?php if (GST_INCL == 'inclusive') {
                                echo '<option value="inclusive">*Inclusive*</option>';


                            } else {
                                echo '<option value="yes">*Exclusive*</option>';


                            } ?>
                            <option value="inclusive">Inclusive</option>
                            <option value="yes">Exclusive</option>

                        </select>
                        <small>Applicable only if TAX Status is GST</small>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label" for="taxid"><?php echo $this->lang->line('TAX ID') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="taxid"
                               class="form-control margin-bottom" name="taxid"
                               value="<?php echo $company['taxid'] ?>">
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
        var actionurl = baseurl + 'settings/tax';
        actionProduct(actionurl);
    });
</script>

