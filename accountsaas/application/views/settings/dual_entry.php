<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Dual Entry') . ' & ' . $this->lang->line('Accounting') ?></h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="product_action" class="form-horizontal">
                    <div class="card card-block">


                        <p class="alert alert-danger">Please do not enable this feature without proper understanding of
                            dual entry accounting system.</p>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="dual"><?php echo $this->lang->line('Dual Entry') ?></label>

                            <div class="col-sm-6">
                                <select name="dual" class="form-control">
                                    <option value="<?= $discship['key1'] ?>">
                                        *<?php if ($discship['key1']) echo $this->lang->line('Yes'); else  echo $this->lang->line('No') ?>
                                        *
                                    </option>
                                    <option value="1"><?php echo $this->lang->line('Yes') ?> </option>
                                    <option value="0"><?php echo $this->lang->line('No') ?></option>


                                </select>
                            </div>
                        </div>

                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="dual_inv"><?php echo $this->lang->line('Default') . ' ' . $this->lang->line('Invoice') . ' ' . $this->lang->line('Account') ?></label>

                            <div class="col-sm-6">
                                <select name="dual_inv" class="form-control">
                                    <option value="<?= $discship['key2'] ?>">*--Do not change--*</option>
                                    <?php foreach ($acclist as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="dual_pur"><?php echo $this->lang->line('Default') . ' ' . $this->lang->line('Purchase Order') . ' ' . $this->lang->line('Account') ?></label>

                            <div class="col-sm-6">
                                <select name="dual_pur" class="form-control">
                                    <option value="<?= $discship['url'] ?>">*--Do not change--*</option>
                                    <?php foreach ($acclist as $row) {
                                        echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                    }
                                    ?>
                                </select>

                            </div>
                        </div>


                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"></label>

                            <div class="col-sm-4">
                                <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                                       value="<?php echo $this->lang->line('Update') ?>"
                                       data-loading-text="Updating...">
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $("#billing_update").click(function (e) {
        e.preventDefault();
        var actionurl = baseurl + 'settings/dual_entry';
        actionProduct(actionurl);
    });
</script>

