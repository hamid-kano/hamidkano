<div class="content-body">
    <div class="card">
        <div class="card-header pb-0">
            <h5><?php echo $this->lang->line('Add New Product') ?></h5>
            <hr>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>

        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">
            <form method="post" id="data_form">


                <input type="hidden" name="act" value="add_product">


                <div class="form-group row">


                    <div class="col-sm-6"><label class="col-form-label"
                                                 for="product_name"><?php echo $this->lang->line('Product Name') ?>
                            *</label>
                        <input type="text" placeholder="Product Name"
                               class="form-control margin-bottom required" name="product_name">
                    </div>


                    <div class="col-sm-6"><label class="col-form-label"
                                                 for="product_code"><?php echo $this->lang->line('Product Code') ?></label>
                        <input type="text" placeholder="Product Code"
                               class="form-control" name="product_code">
                    </div>
                </div>
                <div class="form-group row">

                    <div class="col-sm-6"><label class="col-form-label"
                                                 for="product_cat"><?php echo $this->lang->line('Product Category') ?>
                            *</label>
                        <select name="product_cat" id="product_cat" class="form-control">
                            <?php
                            foreach ($cat as $row) {
                                $cid = $row['id'];
                                $title = $row['title'];
                                echo "<option value='$cid'>$title</option>";
                            }
                            ?>
                        </select>
                    </div>


                    <div class="col-sm-6"><label class="col-form-label"
                                                 for="sub_cat"><?php echo $this->lang->line('Sub') ?><?php echo $this->lang->line('Category') ?></label>
                        <select id="sub_cat" name="sub_cat" class="form-control required select-box">

                        </select>


                    </div>
                </div>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Warehouse') ?>*</label>

                    <div class="col-sm-6">
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

                    <label class="col-sm-2 control-label"
                           for="product_price"><?php echo $this->lang->line('Product Retail Price') ?>*</label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="product_price" class="form-control required"
                                   placeholder="0.00" aria-describedby="sizing-addon"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Purchase Order') . $this->lang->line('Price') ?></label>

                    <div class="col-sm-6">
                        <div class="input-group">
                            <span class="input-group-addon"><?php echo $this->config->item('currency') ?></span>
                            <input type="text" name="fproduct_price" class="form-control"
                                   placeholder="0.00" aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)">
                        </div>
                    </div>
                </div>
                <hr>
                <div class="form-group row">


                    <div class="col-sm-4">
                        <div class="input-group">

                            <input type="text" name="product_tax" class="form-control"
                                   placeholder="<?php echo $this->lang->line('Default TAX Rate') ?>"
                                   aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)"><span
                                    class="input-group-addon">%</span>
                        </div>
                    </div>


                    <div class="col-sm-4">
                        <div class="input-group">

                            <input type="text" name="product_disc" class="form-control"
                                   placeholder="<?php echo $this->lang->line('Default Discount Rate') ?>"
                                   aria-describedby="sizing-addon1"
                                   onkeypress="return isNumber(event)"><span
                                    class="input-group-addon">%</span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <small><?php echo $this->lang->line('Discount rate during') ?></small>

                        <small><?php echo $this->lang->line('Tax rate during') ?></small>
                    </div>
                </div>
                <div class="form-group row">


                    <div class="col-sm-4">
                        <input type="text" placeholder="<?php echo $this->lang->line('Stock Units') ?>*"
                               class="form-control margin-bottom required" name="product_qty"
                               onkeypress="return isNumber(event)"></div>

                    <div class="col-sm-4">
                        <input type="text" placeholder="<?php echo $this->lang->line('Alert Quantity') ?>"
                               class="form-control margin-bottom" name="product_qty_alert"
                               onkeypress="return isNumber(event)">
                    </div>
                    
                    <div class="col-sm-4">
                        <input type="text" placeholder="<?php echo $this->lang->line('Items Per Package') ?>"
                               class="form-control margin-bottom" name="items_per_package"
                               onkeypress="return isNumber(event)">
                    </div>

                </div>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"
                           for="product_cat"><?php echo $this->lang->line('Measurement Unit') ?>*</label>

                    <div class="col-sm-4">
                        <select name="unit" class="form-control">
                            <option value=''>None</option>
                            <?php
                            foreach ($units as $row) {
                                $cid = $row['code'];
                                $title = $row['name'];
                                echo "<option value='$cid'>$title - $cid</option>";
                            }
                            ?>
                        </select>


                    </div>
                </div>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('BarCode') ?></label>
                    <div class="col-sm-2">
                        <select class="form-control" name="code_type">
                            <option value="EAN13">EAN13 - Default</option>
                            <option value="UPCA">UPC</option>
                            <option value="EAN8">EAN8</option>
                            <option value="ISSN">ISSN</option>
                            <option value="ISBN">ISBN</option>
                            <option value="C128A">C128A</option>
                            <option value="C39">C39</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <input type="text" placeholder="BarCode Numeric Digit 123112345671"
                               class="form-control margin-bottom" name="barcode"
                               onkeypress="return isNumber(event)">
                        <small>Leave blank if you want auto generated in EAN13.</small>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"><?php echo $this->lang->line('Description') ?></label>

                    <div class="col-sm-8">
                        <textarea placeholder="Description"
                                  class="form-control margin-bottom" name="product_desc"
                        ></textarea>
                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="edate"><?php echo $this->lang->line('Valid') . ' (' . $this->lang->line('To Date') ?>
                        )</label>

                    <div class="col-sm-2">
                        <input type="text" class="form-control required"
                               placeholder="Expiry Date" name="wdate"
                               data-toggle="datepicker" autocomplete="false">
                    </div>
                    <small>Do not change if not applicable</small>
                </div>
                <?php
                foreach ($custom_fields as $row) {
                    if ($row['f_type'] == 'text') { ?>
                        <div class="form-group row">

                            <label class="col-sm-2 col-form-label"
                                   for="custom"><?= $row['name'] ?></label>

                            <div class="col-sm-8">
                                <input type="text" placeholder="<?= $row['placeholder'] ?>"
                                       class="form-control margin-bottom b_input <?= $row['other'] ?>"
                                       name="custom[<?= $row['id'] ?>]">
                            </div>
                        </div>


                    <?php }
                }
                ?>
                <hr>
                <div class="form-group row"><label
                            class="col-sm-2 col-form-label"><?php echo $this->lang->line('Image') ?></label>
                    <div class="col-sm-6">
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <!-- The container for the uploaded files -->
                        <table id="files" class="files"></table>
                        <br>
                        <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
                            <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]">
    </span>
                        <br>
                        <pre>Allowed: gif, jpeg, png (Use light small weight images for fast loading - 200x200)</pre>
                        <br>
                        <!-- The global progress bar -->

                    </div>
                </div>
                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="submit-data" class="btn btn-lg btn-blue margin-bottom"
                               value="<?php echo $this->lang->line('Add product') ?>" data-loading-text="Adding...">
                        <input type="hidden" value="products/addproduct" id="action-url">
                    </div>
                </div>
                <div id="accordionWrapa1" role="tablist" aria-multiselectable="true">

                    <div id="coupon4" class="card-header">
                        <a data-toggle="collapse" data-parent="#accordionWrapa1" href="#accordion41"
                           aria-expanded="true" aria-controls="accordion41"
                           class="card-title lead collapsed"><i class="fa fa-plus-circle"></i>
                            <?php echo $this->lang->line('Products') . ' ' . $this->lang->line('Variations') ?></a>
                    </div>
                    <div id="accordion41" role="tabpanel" aria-labelledby="coupon4"
                         class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="row p-1">
                            <div class="col">
                                <button class="btn btn-blue tr_clone_add">Add Row</button>
                                <hr>
                                <table class="table" id="v_var">
                                    <tr>
                                        <td><select name="v_type[]" class="form-control">
                                                <?php
                                                foreach ($variables as $row) {
                                                    $cid = $row['id'];
                                                    $title = $row['name'];
                                                    $title = $row['name'];
                                                    $variation = $row['variation'];
                                                    echo "<option value='$cid'>$variation - $title </option>";
                                                }
                                                ?>
                                            </select></td>
                                        <td><input value="" class="form-control" name="v_stock[]"
                                                   placeholder="<?php echo $this->lang->line('Stock Units') ?>*">
                                        </td>
                                        <td><input value="" class="form-control" name="v_alert[]"
                                                   placeholder="<?php echo $this->lang->line('Alert Quantity') ?>*">
                                        </td>
                                        <td>
                                            <button class="btn btn-red tr_delete">Delete</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>
                <div id="accordionWrapa2" role="tablist" aria-multiselectable="true">

                    <div id="coupon5" class="card-header">
                        <a data-toggle="collapse" data-parent="#accordionWrapa2" href="#accordion42"
                           aria-expanded="true" aria-controls="accordion41"
                           class="card-title lead collapsed"><i class="fa fa-plus-circle"></i>
                            <?php echo $this->lang->line('Add') . ' ' . $this->lang->line('Products') . ' ' . $this->lang->line('Warehouse') ?>
                        </a>
                    </div>
                    <div id="accordion42" role="tabpanel" aria-labelledby="coupon5"
                         class="card-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="row p-1">
                            <div class="col">
                                <button class="btn btn-blue tr_clone_add_w">Add Row</button>
                                <hr>
                                <table class="table" id="w_var">
                                    <tr>
                                        <td>
                                            <select name="w_type[]" class="form-control">
                                                <?php
                                                foreach ($warehouse as $row) {
                                                    $cid = $row['id'];
                                                    $title = $row['title'];
                                                    echo "<option value='$cid'>$title</option>";
                                                }
                                                ?>
                                            </select></td>
                                        <td><input value="" class="form-control" name="w_stock[]"
                                                   placeholder="<?php echo $this->lang->line('Stock Units') ?>*">
                                        </td>
                                        <td><input value="" class="form-control" name="w_alert[]"
                                                   placeholder="<?php echo $this->lang->line('Alert Quantity') ?>*">
                                        </td>
                                        <td>
                                            <button class="btn btn-red tr_delete">Delete</button>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>


                <input type="hidden" name="image" id="image" value="default.png">

            </form>
        </div>
    </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js'); ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>products/file_handling';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                var img = 'default.png';
                $.each(data.result.files, function (index, file) {
                    $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>products/file_handling?op=delete&name=' + file.name + '" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/product/' + file.name + '"></td></tr>');
                    img = file.name;
                });

                $('#image').val(img);
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();

        var aurl = $(this).attr('data-url');
        var obj = $(this);

        jQuery.ajax({

            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });


    $(document).on('click', ".tr_clone_add", function (e) {
        e.preventDefault();
        var n_row = $('#v_var').find('tbody').find("tr:last").clone();

        $('#v_var').find('tbody').find("tr:last").after(n_row);

    });
    $(document).on('click', ".tr_clone_add_w", function (e) {
        e.preventDefault();
        var n_row = $('#w_var').find('tbody').find("tr:last").clone();

        $('#w_var').find('tbody').find("tr:last").after(n_row);

    });

    $(document).on('click', ".tr_delete", function (e) {
        e.preventDefault();
        $(this).closest('tr').remove();
    });


    $("#sub_cat").select2();
    $("#product_cat").on('change', function () {
        $("#sub_cat").val('').trigger('change');
        var tips = $('#product_cat').val();
        $("#sub_cat").select2({

            ajax: {
                url: baseurl + 'products/sub_cat?id=' + tips,
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (product) {
                    return {
                        product: product,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.title,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });
    });
</script>
