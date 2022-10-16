<div id="notify" class="alert alert-success" style="display:none;">
    <a href="#" class="close" data-dismiss="alert">&times;</a>

    <div class="message"></div>
</div>
<div class="row">
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center">
                            <i class="fa fa-clock-o primary font-large-2 float-left"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 class="pink" id="dash_0"></h3>
                            <span><?php echo $this->lang->line('Waiting') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center">
                            <i class="fa fa-exchange warning font-large-2 float-left"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 class="indigo" id="dash_1"></h3>
                            <span><?php echo $this->lang->line('Progress') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center">
                            <i class="fa fa-flag-checkered success font-large-2 float-left"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 class="green" id="dash_2"></h3>
                            <span><?php echo $this->lang->line('Finished') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-3 col-lg-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <div class="media d-flex">
                        <div class="align-self-center">
                            <i class="fa fa-dot-circle-o danger font-large-2 float-left"></i>
                        </div>
                        <div class="media-body text-right">
                            <h3 class="deep-cyan" id="dash_6"><?php echo $totalt ?></h3>
                            <span><?php echo $this->lang->line('Total') ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card card-block">
    <div class="card-body">
        <div class="header-block">
            <h3 class="title">
                <?php echo $this->lang->line('Projects') ?>
                </a>
            </h3></div>
        <p>&nbsp;</p>


        <table id="ptable" class="table table-striped table-bordered zero-configuration">
            <thead>
            <tr>
                <th>#</th>
                <th><?php echo $this->lang->line('Project') ?></th>
                <th><?php echo $this->lang->line('Due Date') ?></th>
                <th><?php echo $this->lang->line('Customer') ?></th>
                <th><?php echo $this->lang->line('Status') ?></th>

                <th><?php echo $this->lang->line('Actions') ?></th>


            </tr>
            </thead>
            <tbody>

            </tbody>

        </table>
    </div>
</div>
<input type="hidden" id="dashurl" value="manager/projects_stats">


<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this project') ?> </p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="projects/delete_i">
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
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
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned to') ?> <strong><span
                                        id="employee"></span></strong>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 mb-1"><?php echo $this->lang->line('Assigned by') ?> <strong><span
                                        id="assign"></span></strong>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="taskid" value="">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

    $(document).ready(function () {

        $('#ptable').DataTable({

            "processing": true,
            "serverSide": true,
            "stateSave": true,
            responsive: true,
            <?php datatable_lang();?>
            "order": [[2, "asc"]],
            "ajax": {
                "url": "<?php echo site_url('manager/project_load_list')?>",
                "type": "POST",
                "data": {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": true,
                },
            ],

        });

        $(document).on('click', ".set-task", function (e) {
            e.preventDefault();
            $('#taskid').val($(this).attr('data-id'));
            $('#pop_model').modal({backdrop: 'static', keyboard: false});

        });


        $(document).on('click', ".view_task", function (e) {
            e.preventDefault();

            var actionurl = 'projects/view_project';
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