<link rel="stylesheet" type="text/css"
      href="<?= assets_url() ?>app-assets/vendors/css/calendars/fullcalendar.min.css?v=<?= APPVER ?>">
<link href="<?php echo assets_url(); ?>assets/c_portcss/bootstrapValidator.min.css?v=<?= APPVER ?>" rel="stylesheet"/>
<link href="<?php echo assets_url(); ?>assets/c_portcss/bootstrap-colorpicker.min.css?v=<?= APPVER ?>"
      rel="stylesheet"/>
<!-- Custom css  -->
<link href="<?php echo assets_url(); ?>assets/c_portcss/custom.css?v=<?= APPVER ?>" rel="stylesheet"/>

<script src='<?php echo assets_url(); ?>assets/c_portjs/bootstrap-colorpicker.min.js?v=<?= APPVER ?>'></script>
<script src="<?= assets_url() ?>app-assets/vendors/js/extensions/moment.min.js?v=<?= APPVER ?>"></script>
<script src="<?= assets_url() ?>app-assets/vendors/js/extensions/fullcalendar.min.js?v=<?= APPVER ?>"></script>
<script src='<?php echo assets_url(); ?>assets/c_portjs/main.js?v=<?= APPVER ?>'></script>
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Add Project') ?></h5>
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

                    <div class="form-group row bg-purple bg-lighten-4 ">

                        <div class="col-md-10"><label class="col col-form-label"
                                                      for="name"><?php echo $this->lang->line('Title') ?></label>
                            <input type="text" placeholder="Project Title"
                                   class="form-control mb-1 required" name="name">
                        </div>
                    </div>

                    <div class="form-group row">


                        <div class="col-md-4 bg-blue bg-lighten-4 rounded"><label class="col col-form-label"
                                                                                  for="name"><?php echo $this->lang->line('Status') ?></label>
                            <select name="status" class="form-control mb-1">
                                <?php echo " <option value='Waiting'>" . $this->lang->line('Waiting') . "</option>
                            <option value='Pending'>" . $this->lang->line('Pending') . "</option>
                            <option value='Terminated'>" . $this->lang->line('Terminated') . "</option>
                            <option value='Finished'>" . $this->lang->line('Finished') . "</option>
                            <option value='Progress'>" . $this->lang->line('Progress') . "</option>"; ?>
                            </select>
                        </div>


                        <div class="col-md-4 border-blue-grey rounded"><label class="col col-form-label"
                                                                              for="progress"><?php echo $this->lang->line('Progress') ?>
                                (in %)</label>
                            <input type="range" min="0" max="100" value="0" class="slider" id="progress"
                                   name="progress">
                            <p><span id="prog"></span></p>

                        </div>


                        <div class="col-md-4 bg-blue bg-lighten-4 rounded"><label class="col col-form-label"
                                                                                  for="pay_cat"><?php echo $this->lang->line('Priority') ?></label>
                            <select name="priority" class="form-control mb-1">
                                <option value='Low'>Low</option>
                                <option value='Medium'>Medium</option>
                                <option value='High'>High</option>
                                <option value='Urgent'>Urgent</option>
                            </select>


                        </div>
                    </div>
                    <div class="form-group row">


                        <div class="col-md-4 border-blue-grey rounded"><label class="col col-form-label"
                                                                              for="pay_cat"><?php echo $this->lang->line('Customer') ?></label>
                            <select name="customer" class="form-control mb-1" id="customer_statement">
                                <option value="0"><?php echo $this->lang->line('Select Customer') ?></option>

                            </select>


                        </div>


                        <div class="col-md-4  rounded bg-blue bg-lighten-4"><label class="col col-form-label"
                                                                                   for="name"><?php echo $this->lang->line('Customer Can View') ?></label>
                            <select name="customerview" class="form-control mb-1">
                                <option value='true'>True</option>
                                <option value='false'>False</option>
                            </select>
                        </div>


                        <div class="col-md-4 border-blue rounded">
                            <label class="col col-form-label"
                                   for="name"><?php echo $this->lang->line('Customer Can Comment') ?></label>
                            <select name="customercomment" class="form-control mb-1">
                                <option value='true'>True</option>
                                <option value='false'>False</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">


                        <div class="col-md-4 rounded bg-blue bg-lighten-4"><label class="col col-form-label"
                                                                                  for="worth"><?php echo $this->lang->line('Budget') ?></label>
                            <input type="text" placeholder="Budget" onkeypress="return isNumber(event)"
                                   class="form-control mb-1  required" name="worth" value="0">
                        </div>

                        <div class="col-md-4 border-blue rounded"><label class="control-label"
                                                                         for="edate"><?php echo $this->lang->line('Start Date') ?></label>
                            <input type="text" class="form-control  required"
                                   placeholder="Start Date" name="sdate"
                                   data-toggle="datepicker" autocomplete="false">
                        </div>


                        <div class="col-md-4 rounded bg-blue bg-lighten-4"><label class="control-label"
                                                                                  for="edate"><?php echo $this->lang->line('Due Date') ?></label>
                            <input type="text" id="pdate_2" class="form-control  required edate"
                                   placeholder="End Date" name="edate"
                                   autocomplete="false"
                                   value="<?php echo dateformat(date('Y-m-d', strtotime('+30 days', strtotime(date('Y-m-d'))))) ?>">
                        </div>


                    </div>


                    <div class="form-group row">


                        <div class="col-md-8 rounded bg-grey-blue bg-lighten-4"><label class="col col-form-label"
                                                                                       for="employee[]"><?php echo $this->lang->line('Assign to') ?></label>
                            <select name="employee[]" class="form-control mb-1 required select-box" multiple="multiple">
                                <?php
                                foreach ($emp as $row) {
                                    $cid = $row['id'];
                                    $title = $row['name'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select>


                        </div>


                        <div class="col-md-4   border-blue rounded "><label class="col-form-label"
                                                                            for="phase"><?php echo $this->lang->line('Phase') ?></label>
                            <input type="text" placeholder="Phase A,B,C"
                                   class="form-control mb-1  required" name="phase">
                        </div>
                    </div>

                    <div class="form-group row">


                        <div class="col-md-4 border-blue rounded"><label class="col col-form-label"
                                                                         for="name">Link to calendar</label>
                            <select name="link_to_cal" class="form-control mb-1" id="link_to_cal">
                                <option value='0'>No</option>
                                <option value='1'>Mark Deadline(End Date)</option>
                                <option value='2'>Mark Start to End Date</option>
                            </select>
                        </div>


                        <div class="col-md-8 rounded bg-blue bg-lighten-4"><label class="col col-form-label"
                                                                                  for="tags"><?php echo $this->lang->line('Tags') ?></label>
                            <input type="text" placeholder="Tags"
                                   class="form-control margin-bottom  required" name="tags">
                        </div>
                    </div>

                    <div id="hidden_div" class="row form-group" style="display: none">
                        <label class="col-md-2 control-label" for="color">Color</label>
                        <div class="col-md-4">
                            <input id="color" name="color" type="text" class="form-control input-md"
                                   readonly="readonly" value="#265872"/>
                            <span class="help-block">Click to pick a color</span>
                        </div>
                    </div>

                    <div class="form-group row">

                        <label class="col-sm-2 control-label"
                               for="content"><?php echo $this->lang->line('Note') ?></label>

                        <div class="col-sm-10">
                        <textarea class="summernote"
                                  placeholder=" Note"
                                  autocomplete="false" rows="10" name="content"></textarea>
                        </div>
                    </div>


                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"
                               for="name">Task Communication</label>

                        <div class="col-sm-4">
                            <select name="ptype" class="form-control">
                                <option value='0'>No</option>
                                <option value='1'>Emails to team</option>
                                <option value='2'>Emails to team, customer</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">

                        <label class="col-sm-2 col-form-label"></label>

                        <div class="col-sm-4">
                            <input type="submit" id="submit-data" class="btn btn-success margin-bottom"
                                   value="<?php echo $this->lang->line('Add') ?>" data-loading-text="Adding...">
                            <input type="hidden" value="projects/addproject" id="action-url">

                        </div>
                    </div>


                </form>
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

        $("#customer_statement").select2({
            minimumInputLength: 4,
            tags: [],
            ajax: {
                url: baseurl + 'search/customer_select',
                dataType: 'json',
                type: 'POST',
                quietMillis: 50,
                data: function (customer) {
                    return {
                        customer: customer,
                        '<?=$this->security->get_csrf_token_name()?>': crsf_hash
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (item) {
                            return {
                                text: item.name,
                                id: item.id
                            }
                        })
                    };
                },
            }
        });

        $('.edate').datepicker({autoHide: true, format: '<?php echo $this->config->item('dformat2'); ?>'});
        var slider = $('#progress');
        var textn = $('#prog');
        textn.text(slider.val() + '%');
        $(document).on('change', slider, function (e) {
            e.preventDefault();
            textn.text($('#progress').val() + '%');

        });
    </script>