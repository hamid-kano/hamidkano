<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Export Customers & Suppliers') ?></h5>
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


                <form method="post" action="<?php echo base_url('export/crm_now') ?>" class="form-horizontal">
                    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>"
                           value="<?php echo $this->security->get_csrf_hash(); ?>">


                    <div class="form-group row">
                        <div class="col-sm-4">
                            <select name="type" class="form-control">
                                <option value="1"><?php echo $this->lang->line('Customers') ?></option>
                                <option value="2"><?php echo $this->lang->line('Suppliers') ?></option>
                            </select>
                        </div>
                    </div>


                    <div class="form-group row">


                        <div class="col-sm-4">
                            <input type="submit" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Export File') ?>"
                                   data-loading-text="Updating...">

                        </div>
                    </div>


                </form>
            </div>

        </div>
    </div>
</div>