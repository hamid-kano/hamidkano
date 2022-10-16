<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add Business Location') ?></h5>
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


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="name"><?php echo $this->lang->line('Name') ?></label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Name"
                                   class="form-control margin-bottom  required" name="name">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="address"><?php echo $this->lang->line('Address') ?></label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Address"
                                   class="form-control margin-bottom  required" name="address">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="city"><?php echo $this->lang->line('City') ?></label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="City"
                                   class="form-control margin-bottom  required" name="city">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for=region"><?php echo $this->lang->line('Region') ?></label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Region"
                                   class="form-control margin-bottom" name="region">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="country"><?php echo $this->lang->line('Country') ?></label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Country"
                                   class="form-control margin-bottom" name="country">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="postbox"><?php echo $this->lang->line('Postbox') ?></label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="postbox"
                                   class="form-control margin-bottom" name="postbox">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="phone"><?php echo $this->lang->line('Phone') ?></label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Phone"
                                   class="form-control margin-bottom" name="phone">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="email"><?php echo $this->lang->line('Email') ?></label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="Email"
                                   class="form-control margin-bottom" name="email">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="taxid"><?php echo $this->lang->line('TAX ID') ?></label>

                        <div class="col-sm-8">
                            <input type="text" placeholder="taxid"
                                   class="form-control margin-bottom" name="taxid">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="taxid"><?php echo $this->lang->line('Default') ?><?php echo $this->lang->line('Warehouse') ?></label>
                        <div class="col-sm-8">
                            <select name="wid"
                                    class="selectpicker form-control round">
                                <?php echo $this->common->default_warehouse();
                                echo '<option value="0">' . $this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                } ?>

                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="taxid"><?php echo $this->lang->line('Payment Currency client') ?></label>

                        <div class="col-sm-4">
                            <select name="cur_id"
                                    class="selectpicker form-control">
                                <option value="0">Default</option>
                                <?php foreach ($currency as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                } ?>

                            </select>
                        </div>
                    </div>
                    <hr>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="account"><?php echo $this->lang->line('credit-online-payment') ?></label>

                        <div class="col-sm-5">
                            <select name="account" class="form-control">

                                <?php


                                foreach ($accounts as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>


                    <hr>


                    <div class="form-group row"><label
                                class="col-sm-2 col-form-label"><?php echo $this->lang->line('Company Logo') ?></label>
                        <div class="col-sm-6">

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
                            <pre>Allowed: gif, jpeg, png</pre>
                            <br>
                            <!-- The global progress bar -->
                            <div id="progress" class="progress">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                            <input type="hidden" value="locations/create" id="action-url">
                        </div>
                    </div>

                    <input type="hidden" name="image" id="image" value="logo.png">
                </form>
            </div>
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
        var url = '<?php echo base_url() ?>locations/file_handling';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                var img = 'default.png';
                $.each(data.result.files, function (index, file) {
                    $('#files').html('<tr><td><a data-url="<?php echo base_url() ?>locations/file_handling?op=delete&name=' + file.name + '" class="aj_delete"><i class="btn-danger btn-sm icon-trash-a"></i> ' + file.name + ' </a><img style="max-height:200px;" src="<?php echo base_url() ?>userfiles/company/' + file.name + '"></td></tr>');
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
</script>