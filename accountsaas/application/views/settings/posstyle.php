<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="product_action" class="form-horizontal">
            <div class="card-body">

                <h5><?php echo $this->lang->line('POS') ?> Style</h5>
                <hr>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_name"><?php echo $this->lang->line('POS') ?></label>

                    <div class="col-sm-6"><select name="pstyle" class="form-control">

                            <?php switch (POSV) {
                                case '1' :
                                    echo '<option value="1">** Standard Version **</option>';
                                    break;
                                case '2' :
                                    echo '<option value="2">** Extended Version**</option>';
                                    break;

                            } ?>
                            <option value="1">Standard Version</option>
                            <option value="2">Extended Version</option>


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
        var actionurl = baseurl + 'settings/pos_style';
        actionProduct(actionurl);
    });
</script>
