<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <form method="post" id="data_form" class="form-horizontal">
            <div class="grid_3 grid_4">

                <h5> <?php echo $this->lang->line('POS') ?><?php echo $this->lang->line('Online Payment Settings') ?></h5>
                <hr>


                <div class="form-group row">

                    <label class="col-sm-5 col-form-label"
                           for="enable"><?php echo $this->lang->line('Default') ?><?php echo $this->lang->line('POS') ?><?php echo $this->lang->line('Payment Gateways') ?></label>

                    <div class="col-sm-5">
                        <select class="form-control" name="gateway"><?php
                            echo "<option value='" . $current['key1'] . "'>--" . $this->lang->line('Do not change') . "--</option>";

                            foreach ($gateway as $row) {
                                $cid = $row['id'];
                                $title = $row['name'];
                                if ($row['surcharge'] > 0) {
                                    $surcharge_t = true;
                                    $fee = '+( ' . amountFormat_s($row['surcharge']) . ' %)';
                                } else {
                                    $fee = '';
                                }
                                echo "<option value='$cid'>$title $fee</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-5 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                        <input type="hidden" value="paymentgateways/pos_default" id="action-url">
                    </div>
                </div>

            </div>
        </form>

    </div>

</article>

