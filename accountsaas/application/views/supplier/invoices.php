<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">
            <h5><?php echo $this->lang->line('Orders') ?></h5>

            <hr>
            <div class="card card-block">
                <h4><?php echo $this->lang->line('Supplier Details') ?></h4>
                <hr>
                <div class="row m-t-lg">
                    <div class="col-md-1">
                        <strong><?php echo $this->lang->line('Name') ?></strong>
                    </div>
                    <div class="col-md-10">
                        <?php echo $details['name'] ?>
                    </div>

                </div>
                <div class="row m-t-lg">
                    <div class="col-md-1">
                        <strong><?php echo $this->lang->line('Email') ?></strong>
                    </div>
                    <div class="col-md-10">
                        <?php echo $details['email'] ?>
                    </div>

                </div>
            </div>
            <hr>
            <table id="invoices" class="table table-striped table-bordered zero-configuration">
                <thead>
                <tr>
                    <th><?php echo $this->lang->line('No') ?></th>
                    <th><?php echo $this->lang->line('Order') ?> #</th>

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
                    <th><?php echo $this->lang->line('No') ?></th>
                    <th><?php echo $this->lang->line('Order') ?> #</th>

                    <th><?php echo $this->lang->line('Date') ?></th>
                    <th><?php echo $this->lang->line('Total') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                    <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

                </tr>
                </tfoot>
            </table>
        </div>
    </div>


</article>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>
            <div class="modal-body">
                <p><?php echo $this->lang->line('delete this order') ?></p>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="object-ref" value="">
                <input type="hidden" id="action-url" value="purchase/delete_i">
                <button type="button" data-dismiss="modal" class="btn btn-primary"
                        id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                <button type="button" data-dismiss="modal"
                        class="btn"><?php echo $this->lang->line('Cancel') ?></button>
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
                "url": "<?php echo site_url('supplier/inv_list')?>",
                "type": "POST",
                "data": {'cid':<?php echo $_GET['id'] ?>, '<?=$this->security->get_csrf_token_name()?>': crsf_hash}
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                },
            ], dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [1, 2, 3, 4, 5]
                    }
                }
            ],

        });

    });
</script>