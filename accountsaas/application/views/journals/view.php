<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Journal') ?> </h5><?php echo '<a href="' . base_url() . 'journals/print_t?id=' . $journal['id'] . '&ref=' . $journal['hash_code'] . '" class="btn btn-info btn-xs"  title="Print"><span class="fa fa-print"></span></a>'; ?>
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
            <hr>
            <div class="card-body">
                <div class="row">

                    <hr>
                    <div class="col-md-12">
                        <address>
                            <?php $loc = location(0);
                            echo '<strong>' . $loc['cname'] . '</strong><br>' .
                                $loc['address'] . '<br>' . $loc['city'] . ', ' . $loc['region'] . '<br>' . $loc['country'] . ' -  ' . $loc['postbox'] . '<br> ' . $this->lang->line('Phone') . ': ' . $loc['phone'] . '<br>  ' . $this->lang->line('Email') . ': ' . $loc['email'];
                            ?>
                        </address>
                    </div>

                </div>
                <hr>
                <div class="row">


                    <?php echo '<div class="col-md-6">
                    <p>' . $this->lang->line('sum journal') . ' : ' . amountExchange($journal['sum'], 0, $this->aauth->get_user()->loc) . ' </p>
                    <p>' . $this->lang->line('Note') . ' : ' . $journal['note'] . '</p>
                </div>

                <div class="col-md-6 text-right">
                    <p>' . $this->lang->line('Date') . ' : ' . dateformat($journal['date']) . '</p><p> ID : '. $journal['id'] . '</p>
            </div>'; ?>
            <div class="col-md-12">

                <table class="table table-bordered">
                    <thead>
                        <th><?php echo $this->lang->line('Account') ?></th>
                        <th><?php echo $this->lang->line('Payer') ?></th>
                        <th><?php echo $this->lang->line('Debit') ?></th>
                        <th><?php echo $this->lang->line('Credit') ?></th>
                        <th><?php echo $this->lang->line('Note') ?></th>
                    </thead>
                    <tbody>
                        <?php foreach ($transactions as $transaction) { ?>
                            <tr>
                            <td><?php echo $transaction['account'] ?></td>
                            <td><?php echo $transaction['payer'] ?></td>
                            <td><?php echo $transaction['debit'] ?></td>
                            <td><?php echo $transaction['credit'] ?></td>
                            <td><?php echo $transaction['note'] ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <div class="col-md-12">
                <hr>
                <h1><?php echo $this->lang->line('Attachments') ?></h1>
                <form>
                    <div class="form-group">
                        <p>
                            <?php foreach (explode(',', $journal['files']) as $row) {
                                if($row) {
                             ?>


                                <section class="row">


                                    <div data-block="sec" class="col">
                                        <div class=""><?php


                                            echo '<a class="" href="' . base_url('userfiles/journal/' . $row) . '">' . $row . '</a> &nbsp; &nbsp; <a href="#" class=" danger delete-custom" data-did="1" data-object-id="' . $row . '"><i class="fa fa-trash"></i></a> ';
                                            echo '<br>';

                                            ?></div>
                                    </div>
                                </section>
                            <?php } } ?>
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
            </div>

                </div>

            </div>
        </div>
    </div>

    <div id="delete_model_1" class="modal fade">
    <form id="mform_1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="journal_id" value="<?php echo $journal['id']; ?>">
                    <input type="hidden" id="object-id_1" value="" name="object_id">
                    <input type="hidden" id="action-url_1" value="journals/delete_file">
                    <button type="button" data-dismiss="modal" class="btn btn-primary delete-confirm"
                            id="delete-confirm_1"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </form>
    </div>
</div>

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
        var url = baseurl + 'journals/file_handling?id=<?php echo $journal['id'] ?>';
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