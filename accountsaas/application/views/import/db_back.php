<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <form method="post" action="<?php echo base_url('export/dbexport_c') ?>" class="form-horizontal">
                    <div class="grid_3 grid_4">

                        <h5><?php echo $this->lang->line('Backup Database') ?></h5>
                        <hr>


                        <div class="form-group row">

                            <?php echo $this->lang->line('backup you database') ?>
                        </div>


                        <div class="form-group row">


                            <div class="col-sm-4">
                                <input type="submit" class="btn btn-success margin-bottom"
                                       value="<?php echo $this->lang->line('Backup') ?>"
                                       data-loading-text="Updating...">

                            </div>
                        </div>

                    </div>
                </form>
            </div>

        </div>
    </div>
</div>