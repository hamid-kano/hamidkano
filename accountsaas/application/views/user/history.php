<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <h5 class="title">
                <?php echo $this->lang->line('Employee') . ' : ' . $employee['name'] ?> <a
                        href="<?php echo base_url('employee/view?id=' . $employee['id']) ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('View') ?>
                </a>
            </h5>
            <table id="emptable" class="display" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <th>#</th>

                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Current') ?></th>

                    <th><?php echo $this->lang->line('Previous') ?></th>

                    <th><?php echo $this->lang->line('Change') ?></th>


                </tr>
                </thead>
                <tbody>
                <?php $i = 1;

                foreach ($history as $row) {
                    $diff = $row['val1'] - $row['val2'];
                    $diffp = $diff / $row['val2'] * 100;
                    echo '<tr> <td>' . $i . '</td>
                  
                    <td>' . $row['val3'] . '</td>
                      <td>' . amountExchange($row['val1'], 0, $employee['loc']) . '</td>
                           <td>' . amountExchange($row['val2'], 0, $employee['loc']) . '</td>
                    <td>' . round($diffp, 2) . '%</td>                 
                
                 
                    </tr>';
                    $i++;
                }
                ?>
                </tbody>
                <tfoot>
                <tr>
                    <th>#</th>

                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Current') ?></th>

                    <th><?php echo $this->lang->line('Previous') ?></th>

                    <th><?php echo $this->lang->line('Change') ?></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</article>
<script type="text/javascript">
    $(document).ready(function () {

        //datatables
        $('#emptable').DataTable({responsive: true});


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
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Deactive Employee</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to deactivate this account ? <br><strong> It will disable this account access
                        to
                        user.</strong></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="employee/disable_user">
                <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete-confirm">Confirm</button>
                <button type="button" data-dismiss="modal" class="btn">Cancel</button>
            </div>
        </div>
    </div>
</div>

<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete'); ?></h4>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="modal-body">
                        <p>Are you sure you want to delete this employee? <br><strong> It may interrupt old invoices,
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