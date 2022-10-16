<?php
$due = false;
if ($this->input->get('due')) {
    $due = true;
} ?>
<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h4 class="card-title"><a
                        href="<?php echo base_url('customers') ?>"
                        class="mr-5">
                    <?php echo $this->lang->line('Clients') ?></a> <a
                        href="<?php echo base_url('customers/create') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?></a> <a
                        href="<?php echo base_url('customers?due=true') ?>"
                        class="btn btn-danger btn-sm rounded">
                    <?php echo $this->lang->line('Due') ?><?php echo $this->lang->line('Clients') ?></a></h4>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                          <li>     <a href="#sendMail" data-toggle="modal" data-remote="false"
                           class="btn btn-info btn-sm rounded"
                           data-lang="<?php echo $this->lang->line('Email Selected') ?>"> <span class="fa fa-envelope"></span>
                            <?php echo $this->lang->line('Email Selected') ?></a></li>
                       <li>     <a href="#sendSmsS" data-toggle="modal" data-remote="false"
                           class="btn btn-success btn-sm rounded"
                           data-lang="<?php echo $this->lang->line('SMS Selected') ?>"> <span class="fa fa-mobile"></span>
                            <?php echo $this->lang->line('SMS Selected') ?></a></li>
                    <li><a id="delete_selected"
                           href="#"
                           class="btn btn-danger btn-sm rounded"
                           data-lang="<?php echo $this->lang->line('Delete Selected') ?>">  <span class="fa fa-trash-o"></span>
                            <?php echo $this->lang->line('Delete Selected') ?></a></li>

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

                <table id="clientstable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <?php if ($due) {
                            echo '  <th>' . $this->lang->line('Due') . '</th>';
                        } ?>
                        <th><?php echo $this->lang->line('Address') ?></th>
                        <th><?php echo $this->lang->line('Email') ?></th>
                        <th><?php echo $this->lang->line('Phone') ?></th>
                        <th><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <?php if ($due) {
                            echo '  <th>' . $this->lang->line('Due') . '</th>';
                        } ?>
                        <th><?php echo $this->lang->line('Address') ?></th>
                        <th>Email</th>
                        <th><?php echo $this->lang->line('Mobile') ?></th>
                        <th><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
</div>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Delete Customer</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('are_you_sure_delete_customer') ?></p>
            </div>
            <div class="modal-footer">
                   <input type="hidden" class="form-control"
                           id="object-id" name="deleteid" value="0">

                           <input type="hidden" class="form-control"
                           id="object-ref" name="ref" value="0">

                <input type="hidden" id="action-url" value="customers/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>

<div id="sendMail" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Email Selected') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="sendmail_form"><input type="hidden"
                                                name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                value="<?php echo $this->security->get_csrf_hash(); ?>">



                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>




                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendNowSelected"><?php echo $this->lang->line('Send') ?></button>
            </div>
        </div>
    </div>
    </div>

        <div id="sendSmsS" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('SMS Selected') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="sendsms_form"><input type="hidden"
                                                name="<?php echo $this->security->get_csrf_token_name(); ?>"
                                                value="<?php echo $this->security->get_csrf_hash(); ?>">



                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="message" class="form-control" rows="3" cols="60"></textarea></div>
                    </div>


                    <input type="hidden" id="action-url" value="communication/send_general">


                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendSmsSelected"><?php echo $this->lang->line('Send') ?></button>
            </div>
        </div>
    </div>

      </div>

    <script type="text/javascript">
    $(document).ready(function () {
        $('.summernote').summernote({
            height: 100,
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



        $('#clientstable').DataTable({
            'processing': true,
            'serverSide': true,
            'stateSave': true,
            responsive: true,
            <?php datatable_lang();?>
            'order': [],
            'ajax': {
                'url': "<?php echo site_url('customers/load_list')?>",
                'type': 'POST',
                'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash <?php if ($due) echo ",'due':true" ?> }
            },
            'columnDefs': [
                {
                    'targets': [0],
                    'orderable': false,
                },
            ], dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1, 2, 3, 4]
                    }
                }
            ],
        });


        $(document).on('click', "#delete_selected", function (e) {
            e.preventDefault();
                if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
            alert($(this).attr('data-lang'));
            jQuery.ajax({
                url: "<?php echo site_url('customers/delete_i')?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&<?=$this->security->get_csrf_token_name()?>=' + crsf_hash + '<?php if ($due) echo "&due=true" ?>',
                  dataType: 'json',
                success: function (data) {
                    $("input[name='cust[]']:checked").closest('tr').remove();
                       $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                            $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            });
        });


        //uni sender
$('#sendMail').on('click', '#sendNowSelected', function (e) {
       e.preventDefault();
         $("#sendMail").modal('hide');
                     if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
            jQuery.ajax({
                url: "<?php echo site_url('customers/sendSelected')?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&'+$("#sendmail_form").serialize(),
                  dataType: 'json',
                success: function (data) {
                   $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            });
});

$('#sendSmsS').on('click', '#sendSmsSelected', function (e) {
       e.preventDefault();
         $("#sendSmsS").modal('hide');
                     if ($("#notify").length == 0) {
        $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
    }
            jQuery.ajax({
                url: "<?php echo site_url('customers/sendSmsSelected')?>",
                type: 'POST',
                data: $("input[name='cust[]']:checked").serialize() + '&'+$("#sendsms_form").serialize(),
                  dataType: 'json',
                success: function (data) {
                   $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                }
            });
});



    });


</script>
