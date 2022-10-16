<article class="content">
    <div class="card card-block">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <div class="card-body">
            <h6>TAX Statement</h6>

            <hr>
            <p><?php echo $filter[2] ?> Report</p>


            <table class="table table-striped" cellspacing="0" width="100%">
                <thead>
                <tr>
                    <?php if ($filter[2] == 'Sales') { ?>
                        <th><?php echo $this->lang->line('Invoice') ?></th>
                        <th><?php echo $this->lang->line('Customer') ?></th>
                        <th>TAX ID</th>
                    <?php } else { ?>

                        <th>Receipt</th>
                        <th><?php echo $this->lang->line('Supplier') ?></th>
                        <th></th>
                    <?php } ?>


                    <th><?php echo $this->lang->line('Amount') ?></th>

                    <th>TAX Amount</th>

                    <th><?php echo $this->lang->line('Balance') ?></th>

                </tr>
                </thead>
                <tbody id="entries">
                </tbody>


            </table>
        </div>
    </div>
</article>
<script type="text/javascript">


    $(document).ready(function () {

        $('#entries').html('<td class="text-lg-center" colspan="5">Data loading...</td>');

        $.ajax({

            url: baseurl + 'reports/taxviewstatements_load',
            type: 'POST',
            data: <?php echo "{'sd':'" . $filter[0] . "','ed':'" . $filter[1] . "','ty':'" . $filter[2] . "','loc':'" . $filter[3] . "','" . $this->security->get_csrf_token_name() . "': crsf_hash}"; ?>,
            dataType: 'html',
            success: function (data) {
                $('#entries').html(data);

            },
            error: function (data) {
                $('#response').html('Error')
            }

        });
    });
</script>
