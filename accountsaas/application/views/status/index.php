<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5><?php echo $this->lang->line('Customer Status')." | ".$customer['name'] ?> <a
                        href="<?php echo base_url('status/create?id='.$customer['id']) ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add New Status') ?>
                </a></h5>
            <a class="heading-elements-toggle"><i class="fa fa-ellipsis-v font-medium-3"></i></a>
            <div class="heading-elements">
                <ul class="list-inline mb-0">
                    <li><a data-action="collapse"><i class="ft-minus"></i></a></li>
                    <li><a data-action="expand"><i class="ft-maximize"></i></a></li>
                    <li><a data-action="close"><i class="ft-x"></i></a></li>
                </ul>
            </div>
        </div>
        <div class="card-body">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>


            <hr>
            <table id="status_table" class="table table-striped table-bordered zero-configuration" cellspacing="0"
                   width="100%">
                <thead>
                <tr>
                    <th><?php echo $this->lang->line('Content') ?></th>
                    <th><?php echo $this->lang->line('Date') ?></th>
                </tr>
                </thead>
                <tbody>
                    <?php foreach ($status as $stat) { ?>
                        <tr>
                        <td><?php echo $stat['content'] ?></td>
                        <td><?php echo $stat['created_at'] ?></td>
                        </tr>
                    <?php } ?>
                </tbody>

                <tfoot>
                <tr>
                    <th><?php echo $this->lang->line('Content') ?></th>
                    <th><?php echo $this->lang->line('Date') ?></th>
                </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $('#status_table').DataTable({
            "processing": true,
            "stateSave": true,
            "order": [[ 1, "desc" ]],
            responsive: true,
            <?php datatable_lang();?>
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": true,
                },
            ],
            dom: 'Blfrtip',
            buttons: [
                {
                    extend: 'excelHtml5',
                    footer: true,
                    exportOptions: {
                        columns: [0, 1]
                    }
                }
            ],
        });
    });
</script>
