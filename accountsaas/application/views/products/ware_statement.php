<div class="content-body">
    <div class="card card-body">
        <div class="">
            <h4><?php echo $product['title'] . ' ';
                echo $this->lang->line('Statements') ?></h4>
            <div class="card ">


                <div class="row ">
                    <div class="col-md-12 m-1">
                        <form action="<?php echo base_url() ?>productcategory/warehouse_report" method="post"
                              role="form">
                            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                   value="<?php echo $this->security->get_csrf_hash(); ?>">
                            <input name="id" type="hidden" value="<?php echo $product['id'] ?>">
                            <div class="form-group row">
                                <label class="col-sm-2 col-form-label"
                                       for="pay_cat"><?php echo $this->lang->line('Type') ?></label>

                                <div class="col-md-4">
                                    <select name="r_type" class="form-control">

                                        <option value='1'><?php echo $this->lang->line('Sales') ?></option>
                                        <option value='2'><?php echo $this->lang->line('Purchase Order') ?></option>
                                        <option value='3'><?php echo $this->lang->line('Stock Transfer') ?></option>

                                    </select>


                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-md-2 control-label"
                                       for="sdate"><?php echo $this->lang->line('From Date') ?></label>

                                <div class="col-md-4">
                                    <input type="text" class="form-control required"
                                           placeholder="Start Date" name="s_date" id="sdate"
                                           autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-md-2 control-label"
                                       for="edate"><?php echo $this->lang->line('To Date') ?></label>

                                <div class="col-md-4">
                                    <input type="text" class="form-control required"
                                           placeholder="End Date" name="e_date"
                                           data-toggle="datepicker" autocomplete="false">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label class="col-md-2 col-form-label" for="pay_cat"></label>

                                <div class="col-md-4">
                                    <input type="submit" class="btn btn-primary btn-md" value="View">


                                </div>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

        </div>

    </div>

</div>