<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card card-block">


            <form method="post" id="data_form" class="form-horizontal">

                <h5><?php echo $this->lang->line('Edit') . ' ' . $this->lang->line('Department') ?></h5>
                <hr>

                <input type="hidden"
                       name="did"
                       value="<?php echo $department['id'] ?>">


                <div class="form-group row">

                    <label class="col-sm-3 col-form-label" for="note"><?php echo $this->lang->line('Name') ?></label>

                    <div class="col-sm-8">
                        <input type="text" placeholder="Department Name"
                               class="form-control margin-bottom b_input required" name="name"
                               value="<?php echo $department['val1'] ?>">
                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-3 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                               value="<?php echo $this->lang->line('Edit') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="employee/editdep" id="action-url">
                    </div>
                </div>


            </form>
        </div>
    </div>
</article>