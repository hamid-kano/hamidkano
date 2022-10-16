<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title">
                <?php echo $this->lang->line('Employee') ?> <a href="<?php echo base_url('employee/add') ?>"
                                                               class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
                </a>
            </h5>
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


                <table id="emptable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                       width="100%">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th>Role</th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th><?php echo $this->lang->line('Actions') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;

                    foreach ($employee as $row) {
                        $aid = $row['id'];
                        $hash_code = $row['hash_code'];
                        $username = $row['username'];
                        $name = $row['name'];
                        $role = user_role($row['roleid']);
                        $status = $row['banned'];

                        if ($status == 1) {
                            $status = 'Deactive';
                            $btn = "<a href='#' data-object-id='" . $aid . "'  data-object1-id='" . $aid . "' data-object-ref='".$hash_code."'  class='btn btn-blue btn-xs delete-object' title='Enable'><i class='icon-eye-slash'></i> Enable</a>";
                        } else {
                            $status = 'Active';
                            $btn = "<a href='#' data-object-ref='".$hash_code."' data-object-id='" . $aid . "' class='btn btn-amber btn-xs delete-object' title='Disable'><i class='fa fa-chain-broken'></i> " . $this->lang->line('Disable') . "</a>";
                        }

                        echo "<tr>
                    <td>$i</td>
                    <td>$name</td>
                    <td>$role</td>                 
                    <td>$status</td>
                    <td><a href='" . base_url("employee/view?id=$aid&ref=".$hash_code."") . "' class='btn btn-success btn-xs'><i class='fa fa-eye'></i> " . $this->lang->line('View') . "</a>&nbsp;&nbsp;$btn&nbsp;&nbsp;<a href='#pop_model' data-toggle='modal' data-remote='false' data-object-id='" . $aid . "' data-object-ref='".$hash_code."' class='btn btn-danger btn-xs delemp' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";
                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th>Role</th>
                        <th><?php echo $this->lang->line('Status') ?></th>
                        <th><?php echo $this->lang->line('Actions') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#emptable').DataTable({
                responsive: true, <?php datatable_lang();?> dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3]
                        }
                    }
                ],
            });


        });

        $('.delemp').click(function (e) {
            e.preventDefault();
            $('#empid').val($(this).attr('data-object-id'));

        });
    </script>


    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title">Deactive Employee</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to deactivate this account ? <br><strong> It will disable this account
                            access
                            to
                            user.</strong></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="action-url" value="employee/disable_user">
                    <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Confirm
                    </button>
                    <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div id="pop_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete'); ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>

                <div class="modal-body">
                    <form id="form_model">


                        <div class="modal-body">
                            <p>Are you sure you want to delete this employee? <br><strong> It may interrupt old
                                    invoices,
                                    disable account is a better option.</strong></p>
                        </div>
                        <div class="modal-footer">


                            <input type="hidden" class="form-control required"
                                   name="empid" id="empid" value="">
                            <button type="button" class="btn btn-default"
                                    data-dismiss="modal"><?php echo $this->lang->line('Close'); ?></button>
                            <input type="hidden" id="action-url" value="employee/delete_user">
                            <button type="button" class="btn btn-primary"
                                    id="submit_model"><?php echo $this->lang->line('Delete'); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>