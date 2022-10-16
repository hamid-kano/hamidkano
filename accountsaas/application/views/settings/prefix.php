<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Prefix') ?></h5>
            <hr>
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


                    <input type="hidden" name="id" value="<?php echo $company['id'] ?>">
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="invoiceprefix"><?php echo $this->lang->line('Invoice Prefix') ?></label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="invoiceprefix"
                                   class="form-control margin-bottom  required" name="invoiceprefix"
                                   value="<?php echo $company['prefix'] ?>" maxlength="5">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="invoiceprefix">POS <?php echo $this->lang->line('Invoice Prefix') ?></label>

                        <div class="col-sm-6">
                            <input type="text" placeholder="pos_prefix"
                                   class="form-control margin-bottom  required" name="pos_prefix"
                                   value="<?php echo $prefix['pos'] ?>" maxlength="5">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="invoiceprefix"><?php echo $this->lang->line('Quote') . ' ' . $this->lang->line('Prefix') ?></label>

                        <div class="col-sm-6">
                            <input type="text"
                                   class="form-control margin-bottom  required" name="q_prefix"
                                   value="<?php echo $prefix['name'] ?>" maxlength="5">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="invoiceprefix"><?php echo $this->lang->line('Purchase Order') . ' ' . $this->lang->line('Prefix') ?></label>

                        <div class="col-sm-6">
                            <input type="text"
                                   class="form-control margin-bottom  required" name="p_prefix"
                                   value="<?php echo $prefix['key1'] ?>" maxlength="5">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="invoiceprefix"><?php echo $this->lang->line('Subscription') . ' ' . $this->lang->line('Prefix') ?></label>

                        <div class="col-sm-6">
                            <input type="text"
                                   class="form-control margin-bottom  required" name="r_prefix"
                                   value="<?php echo $prefix['key2'] ?>" maxlength="5">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="invoiceprefix"><?php echo $this->lang->line('Stock Return') . ' ' . $this->lang->line('Prefix') ?></label>

                        <div class="col-sm-6">
                            <input type="text"
                                   class="form-control margin-bottom  required" name="s_prefix"
                                   value="<?php echo $prefix['url'] ?>" maxlength="5">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="invoiceprefix"><?php echo $this->lang->line('Transactions') . ' ' . $this->lang->line('Prefix') ?></label>

                        <div class="col-sm-6">
                            <input type="text"
                                   class="form-control margin-bottom  required" name="t_prefix"
                                   value="<?php echo $prefix['method'] ?>" maxlength="5">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="invoiceprefix"><?php echo $this->lang->line('Others') . ' ' . $this->lang->line('Prefix') ?></label>

                        <div class="col-sm-6">
                            <input type="text"
                                   class="form-control margin-bottom  required" name="o_prefix"
                                   value="<?php echo $prefix['other'] ?>" maxlength="5">
                            <small>-</small>
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="billing_update" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
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
        var actionurl = baseurl + 'settings/prefix';
        actionProduct(actionurl);
    });
</script>

