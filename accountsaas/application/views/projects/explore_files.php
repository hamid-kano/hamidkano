<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <div class="grid_3 grid_4">
                    <div class="header-block">
                        <h3 class="title">
                            <?php echo $project['name'] ?>
                        </h3><?php echo $project['status'] ?></div>
                    <p>&nbsp;</p>
                    <div class="row">
                        <div class="col-xl-3 col-lg-6 col-xs-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-block">
                                        <div class="media">
                                            <div class="media-body text-xs-left">
                                                <h3 class="pink" id="dash_0"></h3>
                                                <span><?php echo $this->lang->line('Due') ?></span>
                                            </div>
                                            <div class="media-right media-middle">
                                                <i class="icon-clock3 pink font-large-2 float-xs-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-xs-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-block">
                                        <div class="media">
                                            <div class="media-body text-xs-left">
                                                <h3 class="indigo" id="dash_1"></h3>
                                                <span><?php echo $this->lang->line('Progress') ?></span>
                                            </div>
                                            <div class="media-right media-middle">
                                                <i class="icon-spinner5 indigo font-large-2 float-xs-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-xs-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-block">
                                        <div class="media">
                                            <div class="media-body text-xs-left">
                                                <h3 class="green" id="dash_2"></h3>
                                                <span><?php echo $this->lang->line('Done') ?></span>
                                            </div>
                                            <div class="media-right media-middle">
                                                <i class="icon-clipboard2 green font-large-2 float-xs-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-3 col-lg-6 col-xs-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card-block">
                                        <div class="media">
                                            <div class="media-body text-xs-left">
                                                <h3 class="deep-cyan" id="dash_6"><?php echo $totalt ?></h3>
                                                <span><?php echo $this->lang->line('Total') ?></span>
                                            </div>
                                            <div class="media-right media-middle">
                                                <i class="icon-stats-bars22 deep-cyan font-large-2 float-xs-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>

                <input type="hidden" id="dashurl" value="tools/task_stats">
                <div class="card">
                    <div class="card-body">
                        <div class="card-block">
                            <p></p>
                            <ul class="nav nav-tabs nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active"
                                       aria-controls="active" aria-expanded="true">Summary</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="link-tab" data-toggle="tab" href="#link"
                                       aria-controls="link" aria-expanded="false">Tasks</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="thread-tab" data-toggle="tab" href="#thread"
                                       aria-controls="thread">Thread Mode</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="geopos_milestones-tab" data-toggle="tab" href="#milestones"
                                       aria-controls="milestones">Milestones</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="thread-tab" data-toggle="tab" href="#activities"
                                       aria-controls="activities">Activities</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="linkOpt-tab" data-toggle="tab" href="#files"
                                       aria-controls="files">Files</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="linkOpt-tab" data-toggle="tab" href="#notes"
                                       aria-controls="notes">Notes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="invoices-tab" data-toggle="tab" href="#invoices"
                                       aria-controls="invoices">Invoices</a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div role="tabpanel" class="tab-pane fade active in" id="active"
                                     aria-labelledby="active-tab" aria-expanded="true">
                                    <div class="table-responsive col-sm-12">
                                        <table class="table">

                                            <tbody>
                                            <tr>
                                                <th scope="row">Name</th>
                                                <td>
                                                    <p><?php echo $project['name'] ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Status</th>
                                                <td>
                                                    <p><?php echo $project['status'] ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Progress</th>
                                                <td>
                                                    <p>55</p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Customer</th>
                                                <td>
                                                    <p><?php echo $customer['name'] ?></p>
                                                    <p class="text-muted"><?php echo $customer['email'] ?></p>
                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Start Date</th>
                                                <td>
                                                    <p><?php echo $project['sdate'] ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row">End Date</th>
                                                <td>
                                                    <p><?php echo $project['edate'] ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Tags</th>
                                                <td>
                                                    <p><?php echo $project['tag'] ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Phase</th>
                                                <td>
                                                    <p><?php echo $project['phase'] ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Budget</th>
                                                <td>
                                                    <p><?php echo $project['worth'] ?></p>

                                                </td>

                                            </tr>
                                            <tr>
                                                <th scope="row">Type</th>
                                                <td>
                                                    <p><?php echo $project['ptype'] ?></p>

                                                </td>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="link" role="tabpanel" aria-labelledby="link-tab"
                                     aria-expanded="false"><p><a
                                                href="<?php echo base_url('projects/addtask?id=' . $project['id']) ?>"
                                                class="btn btn-primary btn-sm rounded">
                                            <?php echo $this->lang->line('Add new') . ' ' . $this->lang->line('Task') ?>
                                        </a></p>
                                    <table id="todotable" class="display" cellspacing="0" width="100%">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th><?php echo $this->lang->line('Task') ?></th>
                                            <th><?php echo $this->lang->line('Due Date') ?></th>
                                            <th><?php echo $this->lang->line('Start') ?></th>
                                            <th><?php echo $this->lang->line('Status') ?></th>
                                            <th><?php echo $this->lang->line('Actions') ?></th>


                                        </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>

                                    </table>
                                </div>
                                <!--thread-->
                                <div class="tab-pane fade" id="thread" role="tabpanel" aria-labelledby="thread-tab"
                                     aria-expanded="false">

                                    <ul class="timeline">
                                        <?php $flag = true;
                                        $total = count($thread_list);
                                        foreach ($thread_list as $row) {


                                            ?>
                                            <li class="<?php if (!$flag) {
                                                echo 'timeline-inverted';
                                            } ?>">
                                                <div class="timeline-badge info"><?php echo $total ?></div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?php echo $row['name'] ?></h4>
                                                        <p>
                                                            <small class="text-muted"><i
                                                                        class="glyphicon glyphicon-time"></i> <?php echo $row['emp'] . ' ' . $row['start'] . ' ~ ' . $row['duedate'] ?>
                                                            </small>
                                                        </p>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <p><?php echo $row['description'] ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php $flag = !$flag;
                                            $total--;
                                        } ?>


                                    </ul>


                                </div>
                                <!--thread-->
                                <!--milestones-->
                                <div class="tab-pane fade" id="milestones" role="tabpanel"
                                     aria-labelledby="milestones-tab" aria-expanded="false">
                                    <p><a href="<?php echo base_url('projects/addmilestone?id=' . $project['id']) ?>"
                                          class="btn btn-primary btn-sm rounded">
                                            Add milestone
                                        </a></p>

                                    <ul class="timeline">
                                        <?php $flag = true;
                                        $total = count($milestones);
                                        foreach ($milestones as $row) {


                                            ?>
                                            <li class="<?php if (!$flag) {
                                                echo 'timeline-inverted';
                                            } ?>">
                                                <div class="timeline-badge"
                                                     style="background-color: <?php echo $row['color'] ?>;"><?php echo $total ?></div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?php echo $row['name'] ?></h4>
                                                        <p>
                                                            <small class="text-muted"><i
                                                                        class="glyphicon glyphicon-time"></i> <?php echo $row['sdate'] . ' ~ ' . $row['edate'] ?>
                                                            </small>
                                                        </p>
                                                    </div>
                                                    <div class="timeline-body">
                                                        <p><?php echo $row['exp'];
                                                            if ($row['task']) echo '</p><p><strong>[Task]</strong> ' . $row['task']; ?></p>

                                                    </div>
                                                </div>
                                            </li>
                                            <?php $flag = !$flag;
                                            $total--;
                                        } ?>


                                    </ul>

                                </div>
                                <!--milestones-->
                                <!--activities-->
                                <div class="tab-pane fade" id="activities" role="tabpanel"
                                     aria-labelledby="activities-tab" aria-expanded="false"><p><a
                                                href="<?php echo base_url('projects/addactivity?id=' . $project['id']) ?>"
                                                class="btn btn-primary btn-sm rounded">
                                            Add New Activity
                                        </a></p>
                                    <?php foreach ($activities as $row) { ?>


                                        <div class="form-group row">


                                            <div class="col-sm-10">
                                                <?php

                                                echo '- ' . $row['value'] . '<br><br>';


                                                ?>
                                            </div>
                                        </div>
                                    <?php }
                                    ?>
                                </div>
                                <!--activities-->
                                <!--files-->
                                <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab"
                                     aria-expanded="false"><p>
                                        <?php foreach ($p_files

                                        as $row) { ?>


                                    <div class="form-group row">


                                        <div class="col-sm-12">
                                            <div class="card card-block"><?php


                                                echo '<a href="' . base_url('userfiles/project/' . $row['value']) . '">' . $row['value'] . '</a>';

                                                echo '<br><br>';
                                                ?></div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                    </p>
                                    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Add files...</span>
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
                                <!--Files-->
                                <!--notes-->
                                <div class="tab-pane fade" id="notes" role="tabpanel" aria-labelledby="notes-tab"
                                     aria-expanded="false">
                                    <form method="post" id="data_form">
                                        <div class="form-group row">


                                            <div class="col-sm-12">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10"
                                  name="content"><?php echo $project['note']; ?></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group row">


                                            <div class="col-sm-10">
                                                <input type="submit" class="btn btn-success sub-btn"
                                                       value="<?php echo $this->lang->line('Update') ?> "
                                                       id="submit-data" data-loading-text="Creating...">
                                            </div>
                                        </div>
                                        <input type="hidden" value="projects/set_note" id="action-url">
                                        <input type="hidden" value="<?php echo $project['id']; ?>" name="nid">
                                    </form>
                                </div>
                                <!--notes-->
                                <!--invoices-->
                                <div class="tab-pane fade" id="invoices" role="tabpanel" aria-labelledby="invoices-tab"
                                     aria-expanded="false">
                                    <p><a href="<?php echo base_url('invoices/create?project=' . $project['id']) ?>"
                                          class="btn btn-primary btn-sm rounded">
                                            Create New Invoice
                                        </a></p>

                                    <div class="table-responsive">
                                        <table class="table table-hover mb-1">
                                            <thead>
                                            <tr>
                                                <th><?php echo $this->lang->line('Invoices') ?>#</th>
                                                <th><?php echo $this->lang->line('Status') ?></th>
                                                <th><?php echo $this->lang->line('Due') ?></th>
                                                <th><?php echo $this->lang->line('Amount') ?></th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php

                                            foreach ($invoices as $item) {
                                                echo '<tr>
                                <td class="text-truncate"><a href="' . base_url() . 'invoices/view?id=' . $item['tid'] . '">#' . $item['tid'] . '</a></td>
                              
                                <td class="text-truncate"><span class="tag tag-default st-' . $item['status'] . '">' . $this->lang->line(ucwords($item['status'])) . '</span></td>
                                <td class="text-truncate">' . $item['invoicedate'] . '</td>
                                <td class="text-truncate">' . amountExchange($item['total'], 0, $this->aauth->get_user()->loc) . '</td>
                            </tr>';
                                            } ?>

                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                                <!--invoices-->


                            </div>
                        </div>
                    </div>
                </div>


                <div id="delete_model" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                            </div>
                            <div class="modal-body">
                                <p><?php echo $this->lang->line('delete this task') ?> </p>
                            </div>
                            <div class="modal-footer">
                                <input type="hidden" id="object-id" value="">
                                <input type="hidden" id="action-url" value="tools/delete_i">
                                <button type="button" data-dismiss="modal" class="btn btn-primary"
                                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                                <button type="button" data-dismiss="modal"
                                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="pop_model" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                </button>
                                <h4 class="modal-title"><?php echo $this->lang->line('Change Status'); ?></h4>
                            </div>

                            <div class="modal-body">
                                <form id="form_model">


                                    <div class="row">
                                        <div class="col-xs-12 mb-1"><label
                                                    for="status"><?php echo $this->lang->line('Change Status') ?></label>
                                            <select name="stat" class="form-control mb-1">
                                                <option value="Due">Due</option>
                                                <option value="Progress">Progress</option>
                                                <option value="Done">Done</option>
                                            </select>

                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" class="form-control"
                                               name="tid" id="taskid" value="">
                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                                        <input type="hidden" id="action-url" value="tools/set_task">
                                        <button type="button" class="btn btn-primary"
                                                id="submit_model"><?php echo $this->lang->line('Change Status'); ?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <div id="task_model" class="modal fade">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;
                                </button>
                                <h4 class="modal-title" id="task_title"><?php echo $this->lang->line('Details'); ?></h4>
                            </div>

                            <div class="modal-body">
                                <form id="form_model">


                                    <div class="row">
                                        <div class="col-xs-12 mb-1" id="description">

                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row">
                                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Priority') ?> <strong><span
                                                        id="priority"></span></strong>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned to') ?>
                                            <strong><span
                                                        id="employee"></span></strong>

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned by') ?>
                                            <strong><span
                                                        id="assign"></span></strong>

                                        </div>
                                    </div>

                                    <div class="modal-footer">
                                        <input type="hidden" class="form-control"
                                               name="tid" id="taskid" value="">
                                        <button type="button" class="btn btn-default"
                                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- add task -->
    <script type="text/javascript">

        $(document).ready(function () {

            $('#todotable').DataTable({

                "processing": true,
                "serverSide": true,
                responsive: true,
                <?php datatable_lang();?>
                "order": [],
                "ajax": {
                    "url": "<?php echo site_url('projects/todo_load_list')?>",
                    "type": "POST",
                    data: {
                        'pid':<?php echo $project['id']; ?>,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                    }
                },
                "columnDefs": [
                    {
                        "targets": [1],
                        "orderable": true,
                    },
                ],

            });

            $(function () {
                $('.select-box').select2();

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

            $(document).on('click', ".set-task", function (e) {
                e.preventDefault();
                $('#taskid').val($(this).attr('data-id'));

                $('#pop_model').modal({backdrop: 'static', keyboard: false});

            });


            $(document).on('click', ".view_task", function (e) {
                e.preventDefault();

                var actionurl = 'tools/view_task';
                var id = $(this).attr('data-id');
                $('#task_model').modal({backdrop: 'static', keyboard: false});


                $.ajax({

                    url: baseurl + actionurl,
                    type: 'POST',
                    data: {'tid': id},
                    dataType: 'json',
                    success: function (data) {

                        $('#description').html(data.description);
                        $('#task_title').html(data.name);
                        $('#employee').html(data.employee);
                        $('#assign').html(data.assign);
                        $('#priority').html(data.priority);
                    }

                });

            });
            miniDash();


        });

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
            var url = baseurl + 'projects/file_handling?id=<?php echo $project['id']; ?>',
                uploadButton = $('<button/>')
                    .addClass('btn btn-primary')
                    .prop('disabled', true)
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
                        $(data.context.children()[index])
                            .wrap(link);
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
        });
    </script>