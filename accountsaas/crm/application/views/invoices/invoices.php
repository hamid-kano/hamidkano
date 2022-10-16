<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <?php if ($this->session->flashdata("messagePr")) { ?>
                <div class="alert alert-info">
                    <?php echo $this->session->flashdata("messagePr") ?>
                </div>
            <?php } ?>
            <div class="card card-block">
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('Invoices') ?></h3>
                    <p><br></p>
                    <div class="table-responsive">
                    <table id="invoices" class="cell-border example1 table table-striped table1 delSelTable" >
                        <thead>
                        <tr>

                            <th><?php echo $this->lang->line('No') ?></th>
                            <th>#</th>
                            <th><?php echo $this->lang->line('customer') ?></th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Amount') ?></th>
                            <th  class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>

                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                        <tr>
                            <th><?php echo $this->lang->line('No') ?></th>
                            <th>#</th>
                            <th><?php echo $this->lang->line('customer') ?></th>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Amount') ?></th>
                            <th  class="no-sort"><?php echo $this->lang->line('Status') ?></th>
                            <th class="no-sort"><?php echo $this->lang->line('Settings') ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
                </div>
            </div>
        </div>


    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {

        var table = $('#invoices').DataTable({
            "processing": true,
            "serverSide": true,
            "responsive": true,
            "order": [],
            "ajax": {
                "url": "<?php echo site_url('invoices/ajax_list')?>",
                "type": "POST",
                'data': {'<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash(); ?>'}
            },
            "columnDefs": [
                {
                    "targets": [0],
                    "orderable": false,
                }
            ],

        });

    });
</script>
