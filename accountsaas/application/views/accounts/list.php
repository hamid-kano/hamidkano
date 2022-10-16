<div class="content-body">
    <div class="row">
        <div class="col-xl-6 col-md-12">
            <div class="card overflow-hidden">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="bg-primary p-2 media-middle">
                            <i class="fa fa-briefcase font-large-2 white"></i>
                        </div>
                        <div class="media-body p-2">
                            <h4><?php echo $this->lang->line('Balance') ?></h4>
                            <span><?php echo $this->lang->line('Total') ?></span>
                        </div>
                        <div class="media-right p-2 media-middle">
                            <h1 class="success"><span
                                        id="dash_0"></span></h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-6 col-md-12">
            <div class="card">
                <div class="card-content">
                    <div class="media align-items-stretch">
                        <div class="bg-warning p-2 media-middle">
                            <i class="fa fa-list-alt font-large-2  white"></i>
                        </div>
                        <div class="media-body p-2">
                            <h4><?php echo $this->lang->line('Accounts') ?></h4>
                            <span><?php echo $this->lang->line('Total') ?></span>
                        </div>
                        <div class="media-right p-2 media-middle">
                            <h1 class="cyan" id="dash_1">0</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Accounts') ?> <a
                        href="<?php echo base_url('accounts/add') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?></a></h5>
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


                <div class="table-responsive">
                    <table id="acctable" class="table table-hover mb-1" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Account No') ?></th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Balance') ?></th>
                            <th><?php echo $this->lang->line('Analytical') ?></th>
                            <th><?php echo $this->lang->line('Account Nature') ?></th>
                            <th><?php echo $this->lang->line('Actions') ?></th>


                        </tr>
                        </thead>
                        <tbody>
                        <?php $i = 1;
                        foreach ($accounts as $row) {
                            $aid = $row['id'];
                            $acn = $row['acn'];
                            $hash_code = $row['hash_code'];
                            $holder = $row['holder'];
                            $balance = amountExchange($row['lastbal'], 0, $this->aauth->get_user()->loc);
                            $qty = $row['adate'];
                            echo "<tr>
                    <td>$i</td>
                    <td>$acn</td>
                    <td>$holder</td>
                 
                    <td>$balance</td>
                    <td>".($row['analytical'] ? $this->lang->line('true') : $this->lang->line('false'))."</td>
                    <td>".($row['type'] ? $this->lang->line(ucwords($row['type'])) : $this->lang->line('Not Set'))."</td>
                    <td><a href='" . base_url("accounts/view?id=$aid&&ref=$hash_code") . "' class='btn btn-success btn-xs'><i class='fa fa-eye'></i>  " . $this->lang->line('View') . "</a>&nbsp;<a href='" . base_url("accounts/edit?id=$aid&&ref=$hash_code") . "' class='btn btn-warning btn-xs'><i class='fa fa-pencil'></i>  " . $this->lang->line('Edit') . "</a>&nbsp;<a href='#' data-object-ref='" . $hash_code . "'  data-object-id='" . $aid . "' class='btn btn-danger btn-xs delete-object' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";
                            $i++;
                        }
                        ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Account No') ?></th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Balance') ?></th>
                            <th><?php echo $this->lang->line('Analytical') ?></th>
                            <th><?php echo $this->lang->line('Account Nature') ?></th>
                            <th><?php echo $this->lang->line('Actions') ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <input type="hidden" id="dashurl" value="accounts/account_stats">
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#acctable').DataTable({
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
            miniDash();

        });
    </script>
    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete Account') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('Delete account message') ?></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="object-ref" value="">
                    <input type="hidden" id="action-url" value="accounts/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>