<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="grid_3 grid_4">
            <div class="header-block">
                <h3 class="title">
                    Support
                </h3></div>
            <hr>

            <h6>Please contact us between office hours.</h6>

        </div>
    </div>
</article>

<script type="text/javascript">
    $(document).ready(function () {

        $('#doctable').DataTable({

            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('tickets/tickets_load_list')?>",
                "type": "POST",
                 'data': {'<?=$this->security->get_csrf_token_name()?>': '<?=$this->security->get_csrf_hash(); ?>'}
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
