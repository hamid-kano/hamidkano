<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <form method="post" id="data_form" class="card-body">

                <h5><?php echo $this->lang->line('Add') ?><?php echo $this->lang->line('Custom') ?><?php echo $this->lang->line('Field') ?> </h5>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_name"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Custom Field Name"
                               class="form-control margin-bottom  required" name="f_name">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_type"><?php echo $this->lang->line('Type') ?></label>

                    <div class="col-sm-6">
                        <select class="form-control" name="f_type">
                            <option value="text">Text</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_module"><?php echo $this->lang->line('Module') ?></label>

                    <div class="col-sm-6">
                        <select class="form-control" name="f_module">
                            <option value="1">Customer</option>
                            <option value="4">Product</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_view"><?php echo $this->lang->line('Public View') ?></label>

                    <div class="col-sm-6">
                        <select class="form-control" name="f_view">
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                        <small>Anyone can view out side the application.</small>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_required">Required</label>

                    <div class="col-sm-6">
                        <select class="form-control" name="f_required">
                            <option value="">No</option>
                            <option value="required">Yes</option>
                        </select>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_placeholder">PlaceHolder</label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Field PlaceHolder "
                               class="form-control margin-bottom required" name="f_placeholder">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_placeholder"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Field Description "
                               class="form-control margin-bottom" name="f_description">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/add_custom_field" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>

