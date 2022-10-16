<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Client Group') . '- ' . $group['title'] ?></h5> <a href="#sendMail"
                                                                                                 data-toggle="modal"
                                                                                                 data-remote="false"
                                                                                                 class="btn btn-primary btn-sm"><i
                        class="fa fa-envelope"></i> <?php echo $this->lang->line('Send Group Message') ?> </a>
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


                <table id="fclientstable" class="table table-striped table-bordered zero-configuration" cellspacing="0">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Address') ?></th>
                        <th><?php echo $this->lang->line('Email') ?></th>
                        <th><?php echo $this->lang->line('Mobile') ?></th>
                        <th><?php echo $this->lang->line('Settings') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                    </tbody>

                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Address') ?></th>
                        <th><?php echo $this->lang->line('Email') ?></th>
                        <th><?php echo $this->lang->line('Mobile') ?></th>
                        <th><?php echo $this->lang->line('Settings') ?></th>
                    </tr>
                    </tfoot>
                </table>

            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            $('#fclientstable').DataTable({

                "processing": true, //Feature control the processing indicator.
                "serverSide": true, //Feature control DataTables' server-side processing mode.
                "order": [], //Initial no order.
                responsive: true,
                <?php datatable_lang();?>

                // Load data for the table's content from an Ajax source
                "ajax": {
                    "url": "<?php echo site_url('clientgroup/grouplist') . '?id=' . $group['id']; ?>",
                    "type": "POST",
                    'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
                },

                //Set column definition initialisation properties.
                "columnDefs": [
                    {
                        "targets": [0], //first column / numbering column
                        "orderable": false, //set not orderable
                    },
                ],

            });

        });
    </script>
    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this customer') ?> </p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="customers/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?> </button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?> </button>
                </div>
            </div>
        </div>
    </div>

    <div id="sendMail" class="modal fade">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Email to group') ?> </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body" id="emailbody">
                    <form id="sendmail_form">


                        <div class="row">
                            <div class="col mb-1"><label
                                        for="shortnote"><?php echo $this->lang->line('Group Name') ?> </label>
                                <input type="text" class="form-control"
                                       value="<?php echo $group['title'] ?>"></div>
                        </div>
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
                                <textarea name="text" class="summernote" id="contents" title="Contents"></textarea>
                            </div>
                        </div>

                        <input type="hidden" class="form-control"
                               name="gid" value="<?php echo $group['id'] ?>">
                                <input type="hidden" class="form-control"
                               name="ref_id" value="<?php echo $group['hash_code'] ?>">
                        <input type="hidden" id="action-url" value="clientgroup/sendGroup">


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?> </button>
                    <button type="button" class="btn btn-primary"
                            id="sendNow"><?php echo $this->lang->line('Send') ?> </button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(function () {
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

            $('form').on('submit', function (e) {
                e.preventDefault();
                alert($('.summernote').summernote('code'));
                alert($('.summernote').val());
            });
        });
    </script>