<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5>Edit Product Category</h5>
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


                <form method="post" id="data_form" class="form-horizontal">


                    <input type="hidden" name="catid" value="<?php echo $productcat['id'] ?>">
                    <input type="hidden" name="ref" value="<?php echo $productcat['hash_code'] ?>">


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label" for="product_cat_name">Category Name</label>

                        <div class="col-sm-6">
                            <input type="text"
                                   class="form-control margin-bottom  required" name="product_cat_name"
                                   value="<?php echo $productcat['title'] ?>">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label">Description</label>

                        <div class="col-sm-6">


                            <input type="text" name="product_cat_desc" class="form-control required"
                                   aria-describedby="sizing-addon1" value="<?php echo $productcat['extra'] ?>">

                        </div>

                    </div>

                    <?php if ($productcat['c_type']) { ?>
                        <input type="hidden" value="1" name="cat_type">
                        <input type="hidden" value="<?= $productcat['rel_id'] ?>" name="old_cat_type">
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="product_cat"><?php echo $this->lang->line('Category') ?></label>

                            <div class="col-sm-6">
                                <select name="cat_rel" class="form-control">
                                    <?php
                                    echo "<option value='" . $productcat['rel_id'] . "'>--" . $this->lang->line('Do not change') . "--</option>";

                                    foreach ($cat as $row) {
                                        $cid = $row['id'];
                                        $title = $row['title'];
                                        echo "<option value='$cid'>$title</option>";
                                    }
                                    ?>
                                </select>


                            </div>
                        </div>
                        <?php
                    } else {
                        ?>
                        <input type="hidden" value="0" name="cat_type">
                        <?php
                    }
                    ?>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="Update" data-loading-text="Updating...">
                            <input type="hidden" value="productcategory/editcat" id="action-url">
                        </div>
                    </div>


                </form>
            </div>

        </div>

