<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <form method="post" action="<?php echo base_url('export/crm_now') ?>" class="form-horizontal">
                    <div class="grid_3 grid_4">

                        <h5><?php echo $this->lang->line('Export Customers & Suppliers') ?></h5>
                        <hr>


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

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>