<div class="card card-block">
    <div class="card-body">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="product_action" class="card card-block">
            <div class="card">

                <h5><?php echo $this->lang->line('Auto Email SMS') ?></h5>
                <p><?php echo $this->lang->line('Auto Email Send') ?></p>
                <hr>


                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="tzone"><?php echo $this->lang->line('Email') ?></label>

                    <div class="col-sm-4">
                        <select name="email" class="form-control">

                            <?php
                            if ($auto['key1'] == 0) {
                                echo '<option value="' . $auto['key1'] . '">*' . $this->lang->line('No') . '</option>';
                            } else {
                                echo '<option value="' . $auto['key1'] . '">*' . $this->lang->line('Yes') . '</option>';
                            }
                            echo '<option value="1">' . $this->lang->line('Yes') . '</option>
                            <option value="0">' . $this->lang->line('No') . '</option>'; ?>

                        </select>
                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-4 col-form-label"
                           for="tzone">SMS</label>

                    <div class="col-sm-4">
                        <select name="sms" class="form-control">

                            <?php
                            if ($auto['key2'] == 0) {
                                echo '<option value="' . $auto['key2'] . '">*' . $this->lang->line('No') . '</option>';
                            } else {
                                echo '<option value="' . $auto['key2'] . '">*' . $this->lang->line('Yes') . '</option>';
                            }
                            echo '<option value="1">' . $this->lang->line('Yes') . '</option>
                            <option value="0">' . $this->lang->line('No') . '</option>'; ?>

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
</div>
<script type="text/javascript">
    $("#time_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/automail';
        actionProduct(actionurl);
    });
</script>

