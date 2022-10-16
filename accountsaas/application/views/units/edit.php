<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-body">


        <form method="post" id="data_form" class="form-horizontal">

            <h5><?php echo $this->lang->line('Edit') ?></h5>
            <hr>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Name') ?></label>

                <div class="col-sm-4">
                    <input type="text" placeholder="Name"
                           class="form-control margin-bottom  required" name="name" value="<?php echo $name ?>">
                </div>
            </div>
            <div class="form-group row">

                <label class="col-sm-2 col-form-label" for="address"><?php echo $this->lang->line('Code') ?></label>

                <div class="col-sm-4">
                    <input type="text" placeholder="Code"
                           class="form-control margin-bottom  required" name="code" value="<?php echo $code ?>"
                           maxlength="4">
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Edit') ?>" data-loading-text="Adding...">
                    <input type="hidden" value="units/edit" id="action-url">
                    <input type="hidden" value="<?php echo $id ?>" name="id">
                </div>
            </div>


        </form>
    </div>
</div>
