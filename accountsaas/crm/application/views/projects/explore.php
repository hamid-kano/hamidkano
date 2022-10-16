<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
            <div class="card card-block">
                <div id="notify" class="alert alert-success" style="display:none;">
                    <a href="#" class="close" data-dismiss="alert">&times;</a>

                    <div class="message"></div>
                </div>
                <?php if ($comment) {

                    echo '<div class="alert alert-success" >
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message">Comment Added!</div>  </div>';


                } ?>
                <div class="grid_3 grid_4">
                    <div class="header-block">
                        <h3 class="title">
                            <?php echo $project['name'] ?>
                        </h3><?php echo $project['status'] ?></div>
                    <p>&nbsp;</p>


                    <input type="hidden" id="dashurl" value="projects/task_stats?id=<?php echo $project['id']; ?>">
                    <div class="card">
                        <div class="card-body">
                            <div class="card-block">
                                <p></p>
                                <ul class="nav nav-tabs nav-justified">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="active-tab" data-toggle="tab" href="#active"
                                           aria-controls="active" aria-expanded="true"><?php echo $this->lang->line('Summary') ?></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="link-tab" data-toggle="tab" href="#link"
                                           aria-controls="link" aria-expanded="false"><?php echo $this->lang->line('Tasks') ?></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="thread-tab" data-toggle="tab" href="#thread"
                                           aria-controls="thread"><?php echo $this->lang->line('Thread') ?></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="milestones-tab" data-toggle="tab" href="#milestones"
                                           aria-controls="milestones"><?php echo $this->lang->line('Milestones') ?></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="linkOpt-tab" data-toggle="tab" href="#files"
                                           aria-controls="files"><?php echo $this->lang->line('Files') ?></a>
                                    </li>

                                    <li class="nav-item">
                                        <a class="nav-link" id="invoices-tab" data-toggle="tab" href="#invoices"
                                           aria-controls="invoices"><?php echo $this->lang->line('Invoices') ?></a>
                                    </li>
                                    <?php if ($comments_list) { ?>
                                    <li class="nav-item">
                                        <a class="nav-link" id="comments-tab" data-toggle="tab" href="#comments"
                                           aria-controls="comments"><?php echo $this->lang->line('Comments') ?></a> <?php } ?>
                                    </li>
                                </ul>
                                <div class="tab-content px-1 pt-1">
                                    <div role="tabpanel" class="tab-pane fade active in" id="active"
                                         aria-labelledby="active-tab" aria-expanded="true">
                                        <div class="table-responsive col-sm-12">
                                            <table class="table">

                                                <tbody>
                                                <tr>
                                                    <th scope="row"><?php echo $this->lang->line('Name') ?></th>
                                                    <td>
                                                        <p><?php echo $project['name'] ?></p>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row"><?php echo $this->lang->line('Priority') ?></th>
                                                    <td>
                                                        <p><?php echo $project['priority'] ?></p>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row"><?php echo $this->lang->line('Status') ?></th>
                                                    <td>
                                                        <p><?php echo $project['status'] ?></p>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row"><?php echo $this->lang->line('Progress') ?></th>
                                                    <td>

                                                        <p><span id="prog"><?php echo $project['progress'] ?>%</span>
                                                        </p>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row"><?php echo $this->lang->line('Customer') ?></th>
                                                    <td>
                                                        <p><?php echo $project['customer'] ?></p>
                                                        <p class="text-muted"><?php echo $project['email'] ?></p>
                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row"><?php echo $this->lang->line('Start Date') ?></th>
                                                    <td>
                                                        <p><?php echo $project['sdate'] ?></p>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row"><?php echo $this->lang->line('Due Date') ?></th>
                                                    <td>
                                                        <p><?php echo $project['edate'] ?></p>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row"><?php echo $this->lang->line('Tags') ?></th>
                                                    <td>
                                                        <p><?php echo $project['tag'] ?></p>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row"><?php echo $this->lang->line('Phase') ?></th>
                                                    <td>
                                                        <p><?php echo $project['phase'] ?></p>

                                                    </td>

                                                </tr>
                                                <tr>
                                                    <th scope="row"><?php echo $this->lang->line('Budget') ?></th>
                                                    <td>
                                                        <p><?php echo amountFormat($project['worth']) ?></p>

                                                    </td>

                                                </tr>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <div class="tab-pane fade" id="link" role="tabpanel" aria-labelledby="link-tab"
                                         aria-expanded="false"><p></p>
                                        <table id="todotable" class="display" cellspacing="0" width="100%">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th><?php echo $this->lang->line('Task') ?></th>
                                                <th><?php echo $this->lang->line('Due Date') ?></th>
                                                <th><?php echo $this->lang->line('Start') ?></th>
                                                <th><?php echo $this->lang->line('Status') ?></th>


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


                                        <ul class="timeline">
                                            <?php $flag = true;
                                            $total = count($milestones);
                                            foreach ($milestones as $row) {


                                                ?>
                                                <li data-block="sec" class="<?php if (!$flag) {
                                                    echo 'timeline-inverted';
                                                } ?>">
                                                    <div class="timeline-badge"
                                                         style="background-color: <?php echo $row['color'] ?>;"><?php echo $total ?></div>
                                                    <div class="timeline-panel">
                                                        <div class="timeline-heading">
                                                            <h4 class="timeline-title"><?php echo $row['name'] ?></h4>
                                                            <p>
                                                                <small class="text-muted"><i
                                                                            class="icon-time"></i> <?php echo $row['sdate'] . ' ~ ' . $row['edate'] . '</small>'; ?>
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

                                    <!--activities-->
                                    <!--files-->
                                    <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="files-tab"
                                         aria-expanded="false">
                                        <p>
                                            <?php foreach ($p_files as $row) { ?>


                                                <section class="form-group row">


                                                    <div data-block="sec" class="col-sm-12">
                                                        <div class="card card-block"><?php


                                                            echo '<a href="' . base_url('../userfiles/project/' . $row['value']) . '">' . ($row['key3'] ?? $row['value']) . '</a>';

                                                            echo '<br><br>';
                                                            ?></div>
                                                    </div>
                                                </section>
                                            <?php } ?>
                                        </p>


                                    </div>
                                    <!--Files-->

                                    <!--invoices-->
                                    <div class="tab-pane fade" id="invoices" role="tabpanel"
                                         aria-labelledby="invoices-tab" aria-expanded="false">


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
                                <td class="text-truncate"><a href="' . base_url() . 'invoices/view?id=' . $item['id'] . '">#' . $item['tid'] . '</a></td>
                              
                                <td class="text-truncate"><span class="tag tag-default st-' . $item['status'] . '">' . $this->lang->line(ucwords($item['status'])) . '</span></td>
                                <td class="text-truncate">' . $item['invoicedate'] . '</td>
                                <td class="text-truncate">' . $this->config->item('currency') . ' ' . amountFormat($item['total']) . '</td>
                            </tr>';
                                                } ?>

                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                    <!--invoices-->
                                    <!--comments-->
                                    <div class="tab-pane fade" id="comments" role="tabpanel"
                                         aria-labelledby="comments-tab" aria-expanded="false">
                                        <?php if ($comments_list) {
                                            echo form_open_multipart('projects/explore'); ?>
                                            <div class="form-group row">


                                                <div class="col-sm-12">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10" name="content"></textarea>
                                                </div>
                                            </div>
                                            <div class="form-group row">


                                                <div class="col-sm-10">
                                                    <input type="submit" class="btn btn-success sub-btn"
                                                           value="Comment"
                                                           id="submit-data2" data-loading-text="Creating...">
                                                </div>
                                            </div>

                                            <input type="hidden" value="<?php echo $project['id']; ?>" name="nid">
                                            </form> <?php }
                                        echo '<ul class="timeline">';
                                        $flag = true;
                                        $total = count($comments_list);
                                        foreach ($comments_list as $row) {


                                            ?>
                                            <li class="<?php if (!$flag) {
                                                echo 'timeline-inverted';
                                            } ?>">
                                                <div class="timeline-badge info"><?php echo $total ?></div>
                                                <div class="timeline-panel">
                                                    <div class="timeline-heading">
                                                        <h4 class="timeline-title"><?php if ($row['key3']) echo $row['customer'] . ' Reply <small>(Customer)</small>'; else echo $row['employee'] . ' Reply <small>(Employee)</small>'; ?></h4>

                                                    </div>
                                                    <div class="timeline-body">
                                                        <p><?php echo $row['value'] ?></p>
                                                    </div>
                                                </div>
                                            </li>
                                            <?php $flag = !$flag;
                                            $total--;
                                        } ?>


                                        </ul>


                                    </div>
                                    <!--comments-->


                                </div>
                            </div>
                        </div>
                    </div>


                    <!-- add task -->
                    <!--dynamic delete -->

                    <!--dynamic delete 2-->

                    <script type="text/javascript">

                        $(document).ready(function () {

                            $('#todotable').DataTable({

                                "processing": true,
                                "serverSide": true,
                                "order": [],
                                "ajax": {
                                    "url": "<?php echo site_url('projects/todo_load_list')?>",
                                    "type": "POST",
                                    data: {'pid':<?php echo $project['id']; ?>,'<?=$this->security->get_csrf_token_name(); ?>': '<?=$this->security->get_csrf_hash(); ?>'}
                                },
                                "columnDefs": [
                                    {
                                        "targets": [1],
                                        "orderable": true,
                                    },
                                ],

                            });


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
