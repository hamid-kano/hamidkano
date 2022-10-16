<style type="text/css">
    .sbox-result {
    position: absolute;
    background-color: #fff;
    border-radius: 0 0 5px 5px;
    width: 88%;
    right: 18px;
    display: none;
    z-index: 99;
}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4><?php echo $this->lang->line('Add journal') ?></h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <hr>
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div class="card-body">
                <form method="post" id="data_form">

                    <div class="form-group row ">
                        <div class="col-sm-6"><label class="col-form-label"
                                                     for="date"><?php echo $this->lang->line('Date') ?></label>
                            <input type="text" class="form-control required"
                                   name="date" data-toggle="datepicker"
                                   autocomplete="false">
                        </div>


                        <div class="col-sm-6">
                            <label class="col-form-label" for="note"><?php echo $this->lang->line('Note') ?></label>
                            <textarea class="form-control" name="note"></textarea>
                        </div>
                        
                        <div class="col-sm-6"><label for="toBizName"
                                                     class="caption col-form-label"><?php echo $this->lang->line('C/o') ?>
                                <span
                                        style="color: red;">*</span></label>
                            <input type="hidden" name="payer_type" value="0">
                            <input type="hidden" name="payer_id" id="line[1][customer_id]" value="0">
                            <input type="text" class="form-control required trans-box" name="payer_name" value="غير محدد">
                            <div class="sbox-result" id="1"><ol></ol></div>
                        </div>



                    </div>

                    <input type="hidden" id="lines" value="2">

                    <div id="customerpanel" class="form-group row bg-blue bg-lighten-4 pb-1">

                        <div class="col-sm-3"><label class=" col-form-label"
                                                     for="pay_cat"><?php echo $this->lang->line('Account') ?></label>
                            <select name="line[1][pay_acc]" class="form-control" data-live-search="true">
                                <?php
                                foreach ($accounts as $row) {
                                    $cid = $row['id'];
                                    $acn = $row['acn'];
                                    $holder = $row['holder'];
                                    echo "<option value='$cid'>$acn - $holder</option>";
                                }
                                ?>
                            </select>


                        </div>


                        <div class="col-sm-2"><label class="col-form-label"
                                                     for="debit"><?php echo $this->lang->line('Debit') ?></label>
                            <input type="text" placeholder="Debit"
                                   class="form-control margin-bottom  required debit" name="line[1][debit]" value="0"
                                   onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-2"><label class="col-form-label"
                                                     for="credit"><?php echo $this->lang->line('Credit') ?></label>
                            <input type="text" placeholder="Credit"
                                   class="form-control margin-bottom credit required" name="line[1][credit]" value="0"
                                   onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-4 mb-1">
                            <label class="col-form-label" for="note"><?php echo $this->lang->line('Note') ?></label>
                            <textarea class="form-control" name="line[1][note]"></textarea>
                        </div>


                        <div class="col-sm-3">
                            <select name="line[2][pay_acc]" class="form-control" data-live-search="true">
                                <?php
                                foreach ($accounts as $row) {
                                    $cid = $row['id'];
                                    $acn = $row['acn'];
                                    $holder = $row['holder'];
                                    echo "<option value='$cid'>$acn - $holder</option>";
                                }
                                ?>
                            </select>


                        </div>


                        <div class="col-sm-2">
                            <input type="text" placeholder="Debit"
                                   class="form-control margin-bottom  required debit" name="line[2][debit]" value="0"
                                   onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-2">
                            <input type="text" placeholder="Credit"
                                   class="form-control margin-bottom credit required" name="line[2][credit]" value="0"
                                   onkeypress="return isNumber(event)">
                        </div>

                        <div class="col-sm-4 mb-1">
                            <textarea class="form-control" name="line[2][note]"></textarea>
                        </div>

                    </div>

                    <div class="form-group row">
                        <div class="col-sm-2 offset-sm-5">
                            <span><?php echo $this->lang->line('Debit') ?> :</span> <span id="debit_total">0</span>
                        </div>
                        <div class="col-sm-2">
                            <span><?php echo $this->lang->line('Credit') ?> :</span> <span id="credit_total">0</span>
                        </div>
                    </div>

                    <div class="form-group row">


                        <div class="col-sm-4">
                            <button type="button" class="btn btn-primary" onclick="addNewRow()"><?php echo $this->lang->line('Add Line') ?></button>
                        </div>
                    </div>

                    <form>
                    <div class="form-group">
                        <p>
                            <?php foreach ([] as $row) { ?>


                                <section class="row">


                                    <div data-block="sec" class="col">
                                        <div class=""><?php


                                            echo '<a class="" href="' . base_url('userfiles/journal/' . $row['value']) . '">' . $row['value'] . '</a> &nbsp; &nbsp; <a href="#" class=" danger delete-custom" data-did="1" data-object-id="' . $row['meta_data'] . '"><i class="fa fa-trash"></i></a> ';
                                            echo '<br>';

                                            ?></div>
                                    </div>
                                </section>
                            <?php } ?>
                        </p>
                        <span class="btn btn-success fileinput-button">
                            <i class="glyphicon glyphicon-plus"></i>
                            <span>...</span>
                                                <!-- The file input field used as target for the file upload widget -->
                            <input id="fileupload" type="file" name="files[]" multiple>
                        </span>
                        <br>
                        <br>
                        <!-- The global progress bar -->
                        <div id="progress" class="progress">
                            <div class="progress-bar progress-bar-success"></div>
                        </div>
                        <!-- The container for the uploaded files -->
                        <div id="files" class="files"></div>
                        <br>
                    </div>
                    </form>

                    <div class="form-group row">


                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success btn-lg margin-bottom" disabled
                                   value="<?php echo $this->lang->line('Add journal') ?>"
                                   data-loading-text="Adding...">
                            <input type="hidden" value="journals/save_trans" id="action-url">
                        </div>
                    </div>


                </form>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
                $('select').select2();
            });

            function updateSum() {
                sum_debit = 0;
                $(".debit").each(function() {
                    sum_debit += parseFloat(this.value);
                });
                
                sum_credit = 0;
                $(".credit").each(function() {
                    sum_credit += parseFloat(this.value);
                });
                
                
                if((sum_debit - sum_credit) == 0) {
                    $('#submit-data').removeAttr('disabled');
                } else {
                    $('#submit-data').attr('disabled','on');
                }
                $("#credit_total").html(sum_credit)
                $("#debit_total").html(sum_debit)
            }
            
            $(".debit").keyup(updateSum);

            $(".credit").keyup(updateSum);

            $(".trans-box").keyup(function () {
                var _this = this;
                $.ajax({
                    type: "GET",
                    url: baseurl + 'search_products/party_search2',
                    data: 'keyword=' + $(this).val(),
                    beforeSend: function () {
                        $(this).css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                    },
                    success: function (data) {
                        $(_this).siblings(".sbox-result").show();
                        $(_this).siblings(".sbox-result").html(data);
                        if(!data) {
                            $(_this).siblings(".sbox-result").hide();
                        }
                    }
                });
            });

            function selectCustomer2(type, id, name, el) {
                inputs = $(el).parents('.sbox-result').siblings('input');
                inputs[0].value = type;
                inputs[1].value = id;
                inputs[2].value = name;
                $(el).parents('.sbox-result').hide();
            }

            function addNewRow() {
                var lines_total = parseInt($('#lines').val());
                var current_line = lines_total+1;
                appendData = `
                <div id="line`+current_line+`" style="display: contents;">
                <div class="col-sm-3">
                            <select name="line[`+current_line+`][pay_acc]" class="form-control" data-live-search="true">
                                <?php
                                foreach ($accounts as $row) {
                                    $cid = $row['id'];
                                    $acn = $row['acn'];
                                    $holder = $row['holder'];
                                    echo "<option value='$cid'>$acn - $holder</option>";
                                }
                                ?>
                            </select>


                        </div>


                        <div class="col-sm-2">
                            <input type="text" placeholder="Debit"
                                   class="form-control margin-bottom debit required" name="line[`+current_line+`][debit]" value="0"
                                   onkeypress="return isNumber(event)" onkeyup="updateSum()">
                        </div>

                        <div class="col-sm-2">
                            <input type="text" placeholder="Credit"
                                   class="form-control margin-bottom credit required" name="line[`+current_line+`][credit]" value="0"
                                   onkeypress="return isNumber(event)" onkeyup="updateSum()">
                        </div>

                        <div class="col-sm-4 mb-1">
                            <textarea class="form-control" name="line[`+current_line+`][note]"></textarea>
                        </div>

                        <div class="col-sm-1">
                            <button type="button" onclick="removeRow(`+current_line+`)" class="btn btn-danger"><i class="fa fa-close"></i></button>
                        </div>

                        </div>

                        `;
                $("#customerpanel").append(appendData);
                $('#lines').attr('value',current_line);
                $('select').select2();
            }

            function removeRow(id) {
                $("#line"+id).remove();
                updateSum();
            }
        </script>
<script src="<?php echo assets_url('assets/vendors/js/upload/jquery.iframe-transport.js') ?>"></script>
<script src="<?php echo assets_url('assets/vendors/js/upload/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo assets_url('assets/vendors/js/upload/load-image.all.min.js') ?>"></script>
<script src="<?php echo assets_url('assets/vendors/js/upload/canvas-to-blob.min.js') ?>"></script>
        <!-- The basic File Upload plugin -->
<script src="<?php echo assets_url('assets/vendors/js/upload/jquery.fileupload.js') ?>"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo assets_url('assets/vendors/js/upload/jquery.fileupload-process.js') ?>"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo assets_url('assets/vendors/js/upload/jquery.fileupload-image.js') ?>"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo assets_url('assets/vendors/js/upload/jquery.fileupload-audio.js') ?>"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo assets_url('assets/vendors/js/upload/jquery.fileupload-video.js') ?>"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo assets_url('assets/vendors/js/upload/jquery.fileupload-validate.js') ?>"></script>

<script>
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = baseurl + 'journals/file_handling';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            autoUpload: true,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png|docx|docs|txt|pdf|xls)$/i,
            maxFileSize: 999000,
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        }).on('fileuploadprocessalways', function (e, data) {
            var index = data.index,
                file = data.files[index],
                node = $(data.context.children()[index]);
            if (file.preview) {
                node
                    .prepend('<br>')
                    .prepend(file.preview);
            }
            if (file.error) {
                node
                    .append('<br>')
                    .append($('<span class="text-danger"/>').text(file.error));
            }
            if (index + 1 === data.files.length) {
                data.context.find('button')
                    .text('Upload')
                    .prop('disabled', !!data.files.error);
            }
        }).on('fileuploadprogressall', function (e, data) {
            var progress = parseInt(data.loaded / data.total * 100, 10);
            $('#progress .progress-bar').css(
                'width',
                progress + '%'
            );
        }).on('fileuploaddone', function (e, data) {
            $.each(data.result.files, function (index, file) {
                if (file.url) {
                    var link = $('<a>')
                        .attr('target', '_blank')
                        .prop('href', file.url)
                        .html(file.name);
                        $("#files")
                        .append('<br>')
                        .append(link);
                    var input = $('<input>')
                    .attr('type', 'hidden')
                    .attr('name', 'files[]')
                    .prop('value', file.name);
                    $("#data_form").prepend(input);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $("#files")
                        .append('<br>')
                        .append(error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $("#files")
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });
</script>
