<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-body">
        <h5><?php echo $this->lang->line('Transactions') ?> by <?php echo $employee['name'] ?></h5>

        <p>&nbsp;</p>
        <table id="alltranstable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th><?php echo $this->lang->line('Date') ?></th>
                <th><?php echo $this->lang->line('Debit') ?></th>
                <th><?php echo $this->lang->line('Credit') ?></th>
                <th><?php echo $this->lang->line('Account') ?></th>
                <th><?php echo $this->lang->line('Payer') ?></th>
                <th><?php echo $this->lang->line('Method') ?></th>
                <th><?php echo $this->lang->line('Action') ?></th>
            </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th><?php echo $this->lang->line('Date') ?></th>
                <th><?php echo $this->lang->line('Debit') ?></th>
                <th><?php echo $this->lang->line('Credit') ?></th>
                <th><?php echo $this->lang->line('Account') ?></th>
                <th><?php echo $this->lang->line('Payer') ?></th>
                <th><?php echo $this->lang->line('Method') ?></th>
                <th><?php echo $this->lang->line('Action') ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<script type="text/javascript">

    var table;

    $(document).ready(function () {

        table = $('#alltranstable').DataTable({
            "processing": true,
            "serverSide": true,
            responsive: true,
            <?php datatable_lang();?>
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('employee/translist')?>",
                "type": "POST",
                data: {'eid': '<?php echo $employee['id'] ?>', '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ],

        });

    });
</script>

<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this transaction') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="transactions/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>