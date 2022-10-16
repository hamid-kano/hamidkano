<article class="content">
    <div class="card card-block">
        <?php if ($response == 1) {
            echo '<div id="notify" class="alert alert-success">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message">' . $responsetext . '</div>
        </div>';
        } else if ($response == 0) {
            echo '<div id="notify" class="alert alert-danger">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message">' . $responsetext . '</div>
        </div>';
        } else {
            echo ' <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>';

        } ?>
        <div class="grid_3 grid_4"><h4 class="ar-text-right"><?php echo $thread_info['subject'] ?></h4>
            <p class="card card-block direction-rtl"><?php echo '<strong>'.$this->lang->line('Created On').'</strong> ' . $thread_info['created'];
                echo '<br><strong>'.$this->lang->line('Customer Name').'</strong>  :  ' . $thread_info['name'];
                echo '<br><strong>'.$this->lang->line('Status').'</strong>  :   <span id="pstatus">' . $this->lang->line($thread_info['status']);
                if($project) {
                echo '<br><strong>'.$this->lang->line('Project').'</strong> :  <a href="'.base_url('projects/explore?id=' . $project['prj']).'" target="_blank">' . $project['name'].'</a>';
                }
                ?></span></p>
            <?php foreach ($thread_list as $row) { ?>


                <div class="form-group row">


                    <div class="col-sm-10">
                        <div class="card card-block"><?php
                            if ($row['custo']) echo 'Customer <strong>' . $row['custo'] . '</strong> Replied<br><br>';

                            if ($row['emp']) echo 'Employee <strong>' . $row['emp'] . '</strong> Replied<br><br>';

                            echo $row['message'] . '';

                            if ($row['attach']) { 
                                echo '<br><br><strong>Attachment: </strong><br>';
                                foreach (json_decode($row['attach']) as $attach) {
                                    echo '<a href="' . substr_replace(base_url(), '', -4) . 'userfiles/support/' . $attach . '" target="_blank">' . $attach . '</a><br>';
                                }
                            }
                            ?></div>
                    </div>
                </div>
            <?php }

           {
                echo form_open_multipart('tickets/thread?id=' . $thread_info['id']); ?>

                <h5><?php echo $this->lang->line('Your Response') ?></h5>
                <hr>

                <div class="form-group row">

                    <label class="col-sm-2 control-label"
                           for="edate">Reply</label>

                    <div class="col-sm-10">
                        <textarea class="summernote"
                                  placeholder=" Message"
                                  autocomplete="false" rows="10" name="content"></textarea>
                    </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-2 col-form-label" for="name"><?php echo $this->lang->line('Attachments') ?></label>

                            <span class="btn btn-success fileinput-button">
            <i class="glyphicon glyphicon-plus"></i>
                                <!-- The file input field used as target for the file upload widget -->
            <input id="fileupload" type="file" name="files[]">
        </span>
                            <br>
                            <br>
                            <!-- The global progress bar -->
                            <div id="progress" class="progress offset-sm-2" style="width: auto;">
                                <div class="progress-bar progress-bar-success"></div>
                            </div>
                            <!-- The container for the uploaded files -->
                            <div id="files" class="files offset-sm-2"></div>
                            </div>

                <?php if ($captcha_on) {
                    echo '<script src="https://www.google.com/recaptcha/api.js"></script>
									 <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4"><fieldset class="form-group position-relative has-icon-left">
                                      <div class="g-recaptcha" data-sitekey="' . $captcha . '"></div>
                                    </fieldset></div>
                </div>';
                } ?>


                <div class="form-group row">

                    <label class="col-sm-2 col-form-label"></label>

                    <div class="col-sm-4">
                        <input type="submit" id="document_add" class="btn btn-success margin-bottom"
                               value="Update" data-loading-text="Updating...">
                    </div>
                </div>


                </form>
            <?php } ?>
        </div>
    </div>
</article>
<script src="<?php echo assets_url('crm-assets/vendors/js/upload/jquery.iframe-transport.js') ?>"></script>
<script src="<?php echo assets_url('crm-assets/vendors/js/upload/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo assets_url('crm-assets/vendors/js/upload/load-image.all.min.js') ?>"></script>
<script src="<?php echo assets_url('crm-assets/vendors/js/upload/canvas-to-blob.min.js') ?>"></script>
<!-- The basic File Upload plugin -->
<script src="<?php echo assets_url('crm-assets/vendors/js/upload/jquery.fileupload.js') ?>"></script>
<!-- The File Upload processing plugin -->
<script src="<?php echo assets_url('crm-assets/vendors/js/upload/jquery.fileupload-process.js') ?>"></script>
<!-- The File Upload image preview & resize plugin -->
<script src="<?php echo assets_url('crm-assets/vendors/js/upload/jquery.fileupload-image.js') ?>"></script>
<!-- The File Upload audio preview plugin -->
<script src="<?php echo assets_url('crm-assets/vendors/js/upload/jquery.fileupload-audio.js') ?>"></script>
<!-- The File Upload video preview plugin -->
<script src="<?php echo assets_url('crm-assets/vendors/js/upload/jquery.fileupload-video.js') ?>"></script>
<!-- The File Upload validation plugin -->
<script src="<?php echo assets_url('crm-assets/vendors/js/upload/jquery.fileupload-validate.js') ?>"></script>

<script>
    var baseurl = '<?php echo base_url() ?>';
    var crsf_token = '<?=$this->security->get_csrf_token_name()?>';
    var crsf_hash = '<?=$this->security->get_csrf_hash(); ?>';
    /*jslint unparam: true, regexp: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = baseurl + 'tickets/file_handling',
            uploadButton = $('<button/>')
                .addClass('btn btn-primary')
                .prop('disabled', true)
                .prop('type', 'button')
                .text('Processing...')
                .on('click', function () {
                    var $this = $(this),
                        data = $this.data();
                    $this
                        .off('click')
                        .text('Abort')
                        .on('click', function () {
                            $this.remove();
                            data.abort();
                        });
                    data.submit().always(function () {
                        $this.remove();
                    });
                });
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            autoUpload: false,
            acceptFileTypes: /(\.|\/)(gif|jpe?g|png|docx|docs|txt|pdf|xls|xlsx|apk|zip|rar|ai)$/i,
            // Enable image resizing, except for Android and Opera,
            // which actually support image resizing, but fail to
            // send Blob objects via XHR requests:
            disableImageResize: /Android(?!.*Chrome)|Opera/
                .test(window.navigator.userAgent),
            previewMaxWidth: 100,
            previewMaxHeight: 100,
            previewCrop: true
        }).on('fileuploadadd', function (e, data) {
            data.context = $('<div/>').appendTo('#files');
            $.each(data.files, function (index, file) {
                var node = $('<p/>')
                    .append($('<span/>').text(file.name));
                if (!index) {
                    node
                        .append('<br>')
                        .append(uploadButton.clone(true).data(data));
                }
                node.appendTo(data.context);
            });
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
                        .prop('href', file.url);
                    var input = $('<input>')
                        .attr('name', 'uploadedFiles[]')
                        .prop('type', 'hidden')
                        .prop('value', file.name)
                        .prop('id', file.name);
                    $(data.context.children()[index])
                        .wrap(link);
                        $(data.context.children()[index]).prepend(input);
                } else if (file.error) {
                    var error = $('<span class="text-danger"/>').text(file.error);
                    $(data.context.children()[index])
                        .append('<br>')
                        .append(error);
                }
            });
        }).on('fileuploadfail', function (e, data) {
            $.each(data.files, function (index) {
                var error = $('<span class="text-danger"/>').text('File upload failed.');
                $(data.context.children()[index])
                    .append('<br>')
                    .append(error);
            });
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    }).on('fileuploadsubmit', function (e, data) {
  data.formData = {'<?=$this->security->get_csrf_token_name()?>': crsf_hash};
});
    $(function () {
        $('.summernote').summernote({
            height: 250,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });
    });
</script>