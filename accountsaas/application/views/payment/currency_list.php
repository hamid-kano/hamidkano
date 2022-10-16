<div class="card card-block">
    <div id="notify" class="alert alert-success" style="display:none;">
        <a href="#" class="close" data-dismiss="alert">&times;</a>

        <div class="message"></div>
    </div>
    <div class="card-body">
        <h5 class="title"> <?php echo $this->lang->line('Customer Invoice Payment') ?> <a
                    href="<?php echo base_url('paymentgateways/add_currency') ?>"
                    class="btn btn-primary btn-sm rounded">
                <?php echo $this->lang->line('Add new') ?>
            </a>
        </h5>
        <hr>
        <p>You can add invoice currencies here, these currencies can be selected during an invoice creation. The
            exchange rate and other tasks will automatically handled by application. Please make sure enter correct
            ISO currency code to get automatic exchange rate updates and receive payment using payment gateways with
            converted amount.</p>
        <hr>

        <table id="datgtable" class="table table-striped table-bordered zero-configuration" cellspacing="0"
               width="100%">
            <thead>
            <tr>
                <th>#</th>
                <th>ISO CODE</th>
                <th>Symbol</th>
                <th>Exchange Rate</th>
                <th><?php echo $this->lang->line('Action') ?></th>


            </tr>
            </thead>
            <tbody>
            <?php $i = 1;
            foreach ($currency_list as $row) {
                $cid = $row['id'];
                $title = $row['code'];
                $enable = $row['symbol'];
                $dev_mode = $row['rate'];

                echo "<tr>
                    <td>$i</td>
                    <td>$title</td>
                    <td>$enable</td>
                    <td>$dev_mode</td>
                  
                    <td><a href='" . base_url("paymentgateways/edit_currency?id=$cid&ref=".$row['hash_code']."") . "' class='btn btn-cyan btn-xs'><i class='icon-pencil'></i> " . $this->lang->line('Edit') . "</a> <a href='#' data-object-id='" . $cid . "' class='btn btn-danger btn-xs delete-object' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";
                $i++;
            }
            ?>
            </tbody>
            <tfoot>
            <tr>
                <th>#</th>
                <th>ISO CODE</th>
                <th>Symbol</th>
                <th>Exchange Rate</th>
                <th><?php echo $this->lang->line('Action') ?></th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>
<div id="delete_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
            </div>

            <div class="modal-footer">
                <input type="hidden" id="object-id" value="">
                <input type="hidden" id="action-url" value="paymentgateways/delete_currency">
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

        //datatables
        $('#datgtable').DataTable({responsive: true});

    });
</script>
