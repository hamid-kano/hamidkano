<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-body">
        <h5><?php echo $this->lang->line('Invoices') ?> by <?php echo $employee['name'] ?></h5>

        <hr>
        <table id="invoices" class="table table-striped table-bordered zero-configuration">
            <thead>
            <tr>
                <th>No</th>
                <th><?php echo $this->lang->line('Invoice') ?>#</th>
                <th><?php echo $this->lang->line('Customer') ?></th>
                <th><?php echo $this->lang->line('Date') ?></th>
                <th><?php echo $this->lang->line('Total') ?></th>
                <th class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>


            </tr>
            </thead>
            <tbody>
            </tbody>

            <tfoot>
            <tr>
                <th>No</th>
                <th><?php echo $this->lang->line('Invoice') ?>#</th>
                <th><?php echo $this->lang->line('Customer') ?></th>
                <th><?php echo $this->lang->line('Date') ?></th>
                <th><?php echo $this->lang->line('Total') ?></th>
                <th class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

            </tr>
            </tfoot>
        </table>
    </div>
</div>

<div id="delete_invoice" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete Invoice') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('You can not revert') ?></p>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal" class="btn">
                    ><?php echo $this->lang->line('Cancel') ?></button>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#invoices').DataTable({
            "processing": true,
            "serverSide": true,
            responsive: true,
            <?php datatable_lang();?>
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('employee/invoices_list')?>",
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