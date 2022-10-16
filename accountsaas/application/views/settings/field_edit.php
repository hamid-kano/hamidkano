<article class="content-body">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <form method="post" id="data_form" class="card-body">

                <h5><?php echo $this->lang->line('Edit') ?><?php echo $this->lang->line('Custom') ?><?php echo $this->lang->line('Field') ?> </h5>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_name"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Custom Field Name"
                               class="form-control margin-bottom  required" name="f_name"
                               value="<?= $customfields['name'] ?>">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_view"><?php echo $this->lang->line('Public View') ?></label>

                    <div class="col-sm-6">
                        <select class="form-control" name="f_view">
                            <?php if ($customfields['f_view']) echo ' <option value="required">**Yes**</option>'; ?>
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
                            <?php if ($customfields['other']) echo ' <option value="required">**Yes**</option>'; ?>
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
                               class="form-control margin-bottom required" name="f_placeholder"
                               value="<?= $customfields['placeholder'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="f_placeholder"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-6">
                        <input type="text" placeholder="Field Description "
                               class="form-control margin-bottom" name="f_description"
                               value="<?= $customfields['value_data'] ?>">
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="settings/edit_custom_field" id="action-url">
                        <input type="hidden" value="<?= $customfields['id'] ?>" name="fid">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>

