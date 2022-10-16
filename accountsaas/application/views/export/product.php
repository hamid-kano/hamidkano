<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h6><?php echo $this->lang->line('Products').' '.$this->lang->line('Account Statements') ?></h6>
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


                <div class="row sameheight-container">

                    <div class="col-md-6">
                        <div class="card card-block sameheight-item">

                            <form action="<?php echo base_url() ?>export/cust_products_o" method="post" role="form"><input
                                        type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"
                                           for="pay_cat"><?php echo $this->lang->line('Customer') ?></label>

                                    <div class="col-sm-9">
                                        <select name="customer" class="form-control" id="customer_statement">

                                        </select>


                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-3 control-label"
                                           for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control required"
                                               placeholder="Start Date" name="sdate" id="sdate"
                                               data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-3 control-label"
                                           for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control required"
                                               placeholder="End Date" name="edate"
                                               data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                    <div class="col-sm-4">
                                        <input type="submit" class="btn btn-primary btn-md"
                                               value="<?php echo $this->lang->line('Export') ?>">


                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>



                    <div class="col-md-6">
                        <div class="card card-block sameheight-item">

                            <form action="<?php echo base_url() ?>export/sup_products_o" method="post" role="form"><input
                                        type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                        value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label"
                                           for="pay_cat"><?php echo $this->lang->line('Supplier') ?></label>

                                    <div class="col-sm-9">
                                        <select name="supplier" class="form-control" id="supplier_statement">

                                        </select>


                                    </div>

                                </div>

                                <div class="form-group row">

                                    <label class="col-sm-3 control-label"
                                           for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control date30 required"
                                               placeholder="Start Date" name="sdate"
                                               data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group row">

                                    <label class="col-sm-3 control-label"
                                           for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                    <div class="col-sm-4">
                                        <input type="text" class="form-control required"
                                               placeholder="End Date" name="edate"
                                               data-toggle="datepicker" autocomplete="false">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                                    <div class="col-sm-4">
                                        <input type="submit" class="btn btn-primary btn-md"
                                               value="<?php echo $this->lang->line('Export') ?>">


                                    </div>
                                </div>

                            </form>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $("#customer_statement").select2({
            minimumInputLength: 4,
            tags: [],
            ajax: {
                url: baseurl + 'search/customer_select',
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (customer) {
                    return {
                        customer: customer,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
        $("#supplier_statement").select2({
            minimumInputLength: 3,
            tags: [],
            ajax: {
                url: baseurl + 'search/supplier_select',
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (supplier) {
                    return {
                        supplier: supplier,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
        $('#sdate_2').datepicker('setDate', '<?php echo date('Y-m-d', strtotime('-30 days', strtotime(date('Y-m-d')))); ?>');

    </script>
