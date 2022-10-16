<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="product_action" class="form-horizontal">
            <div class="card-body">

                <h5><?php echo $this->lang->line('Default') ?><?php echo $this->lang->line('Warehouse') ?></h5>

                <hr>


                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="tzone"><?php echo $this->lang->line('Warehouse') ?></label>

                    <div class="col-sm-4">
                        <select name="wid" class="form-control">

                            <?php
                            echo '<option value="' . $ware['key1'] . '">*' . $this->lang->line('Do not change') . '</option>';
                            echo '<option value="0">*' . $this->lang->line('All') . '</option>';
                            foreach ($warehouses as $row) {
                                echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                            }
                            ?>

                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="time_update" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    </div>
                </div>

            </div>
        </form>
    </div>
</article>
<script type="text/javascript">
    $("#time_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/warehouse';
        actionProduct(actionurl);
    });
</script>

