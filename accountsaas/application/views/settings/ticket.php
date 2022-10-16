<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="product_action" class="form-horizontal">
            <div class="card-body">

                <h5><?php echo $this->lang->line('Support Tickets') ?></h5>
                <hr>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('Support Tickets') . ' ' . $this->lang->line('Module') ?> </label>

                    <div class="col-sm-6"><select name="service" class="form-control">

                            <?php if ($support['key1'] == 1) {
                                echo '<option value="1">*' . $this->lang->line('On') . '*</option>';


                            } ?>
                            <option value="0"><?php echo $this->lang->line('Off') ?></option>
                            <option value='1'><?php echo $this->lang->line('On') ?></option>


                        </select>
                        <small>(In Customer Login)</small>

                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="taxstatus"><?php echo $this->lang->line('Activity Email') ?></label>

                    <div class="col-sm-6">
                        <select name="email" class="form-control">

                            <?php if ($support['key2'] == 1) {
                                echo '<option value="1">*' . $this->lang->line('On') . '*</option>';


                            } ?>
                            <option value="0"><?php echo $this->lang->line('Off') ?></option>
                            <option value='1'><?php echo $this->lang->line('On') ?></option>

                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="taxstatus"><?php echo $this->lang->line('Email') ?></label>

                    <div class="col-sm-6">
                        <input type="email" name="support" class="form-control" value="<?php echo $support['url'] ?>">


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Support Signature') ?></label>

                    <div class="col-sm-8">


                        <textarea name="signature" class="summernote"
                        ><?php echo $support['other'] ?></textarea>
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
        var actionurl = baseurl + 'settings/tickets';
        actionProduct(actionurl);
    });
</script>
<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 250,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']]

            ]
        });
    });
</script>

