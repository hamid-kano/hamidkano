<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card card-block ">


        <form method="post" id="data_form" class="card-body">

            <h5><?php echo $this->lang->line('Add') ?><?php echo $this->lang->line('Variations') ?></h5>
            <hr>

            <div class="form-group row">
                <label class="col-sm-1 col-form-label" for="name"><?php echo $this->lang->line('Name') ?></label>
                <div class="col-sm-4">
                    <input type="text" placeholder="Name"
                           class="form-control margin-bottom round required" name="name">
                </div>
            </div>

            <div class="form-group row">

                <label class="col-sm-1 col-form-label"
                       for="pvars"><?php echo $this->lang->line('Variations') ?>*</label>

                <div class="col-sm-4">
                    <select name="pvars" class="form-control round">
                        <?php
                        foreach ($variations as $row) {
                            $cid = $row['id'];
                            $title = $row['name'];
                            echo "<option value='$cid'>$title</option>";
                        }
                        ?>
                    </select>


                </div>
            </div>


            <div class="form-group row">
                <label class="col-sm-2 col-form-label"></label>
                <div class="col-sm-4">
                    <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                           value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                    <input type="hidden" value="units/create_vb" id="action-url">
                </div>
            </div>


        </form>
    </div>
</div>