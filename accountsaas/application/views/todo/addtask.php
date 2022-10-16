<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add Task') ?> </h5>
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
                               for="name"><?php echo $this->lang->line('Title') ?></label>

                        <div class="col-sm-10">
                            <input type="text" placeholder="Task Title"
                                   class="form-control margin-bottom  required" name="name">
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="name"><?php echo $this->lang->line('Status') ?></label>

                        <div class="col-sm-4">
                            <select name="status" class="form-control">
                                <?php echo "<option value='Due'>" . $this->lang->line('Due') . "</option>
                            <option value='Done'>" . $this->lang->line('Done') . "</option>
                            <option value='Progress'>" . $this->lang->line('Progress') . "</option>";
                                ?>

                            </select>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Priority') ?></label>

                        <div class="col-sm-4">
                            <select name="priority" class="form-control">
                                <option value='Low'>Low</option>
                                <option value='Medium'>Medium</option>
                                <option value='High'>High</option>
                                <option value='Urgent'>Urgent</option>
                            </select>


                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="edate"><?php echo $this->lang->line('Start Date') ?></label>

                        <div class="col-sm-2">
                            <input type="text" class="form-control required"
                                   placeholder="Start Date" name="staskdate"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="edate"><?php echo $this->lang->line('Due Date') ?></label>

                        <div class="col-sm-2">
                            <input type="text" class="form-control required"
                                   placeholder="End Date" name="taskdate"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="pay_cat"><?php echo $this->lang->line('Assign to') ?></label>

                        <div class="col-sm-4">
                            <select name="employee" class="form-control select-box">
                                <?php
                                foreach ($emp as $row) {
                                    $cid = $row['id'];
                                    $title = $row['name'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>


                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="content"><?php echo $this->lang->line('Description') ?></label>

                        <div class="col-sm-10">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10" name="content"></textarea>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add Task') ?>" data-loading-text="Adding...">
                            <input type="hidden" value="tools/save_addtask" id="action-url">
                        </div>
                    </div>


                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">

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
</script>