<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <form method="post" id="data_form" class="form-horizontal">
        <div class="card-body">

            <h5><?php echo $this->lang->line('Edit Transaction Category') ?></h5>
            <hr>
            <input type="hidden" name="catid" value="<?php echo $cat['id'] ?>">
             <input type="hidden" name="ref" value="<?php echo $cat['hash_code'] ?>">
            <div class="form-group row">
                <label class="col-sm-2 col-form-label"
                       for="product_cat_name"><?php echo $this->lang->line('Category Name') ?></label>

                <div class="col-sm-8">
                    <input type="text"
                           class="form-control margin-bottom  required" name="cat_name"
                           value="<?php echo $cat['name'] ?>">
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-2 col-form-label"></label>

                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Update') ?>" data-loading-text="Updating...">
                    <input type="hidden" value="transactions/editcatsave" id="action-url">
                </div>
            </div>

        </div>
    </form>
</div>