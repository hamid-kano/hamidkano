<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4 card card-block">
            <h5 class="title"> <?php echo $this->lang->line('BarCode') ?>
            </h5>

            <hr>
            <form action="<?php echo base_url() ?>barcode/view" method="post" role="form">
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Warehouse') ?></label>

                    <div class="col-sm-4">
                        <select name="product_warehouse" class="form-control">
                            <?php
                            foreach ($warehouse as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Product Category') ?></label>

                    <div class="col-sm-4">
                        <select name="product_cat" class="form-control">
                            <?php
                            foreach ($cat as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="format">Format</label>

                    <div class="col-sm-4">
                        <select name="product_cat" class="form-control">
                            <option value='html'>HTML</option>
                            <option value='htmllist'>HTML List</option>
                            <option value='pdf'>PDF</option>
                            <option value='pdflist'>PDF</option>
                        </select>


                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-label" for="pay_cat"></label>

                    <div class="col-sm-4">
                        <input type="submit" class="btn btn-primary btn-md" value="Print">


                    </div>
                </div>

            </form>
        </div>
    </div>
</article>
