<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title"> <?php echo $this->lang->line('Product Category') ?> <a
                        href="<?php echo base_url('productcategory/add') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') . ' ' . $this->lang->line('Category') ?>
                </a> <a
                        href="<?php echo base_url('productcategory/add_sub') ?>"
                        class="btn btn-blue btn-sm rounded">
                    <?php echo $this->lang->line('Add new') . ' - ' . $this->lang->line('Sub') . ' ' . $this->lang->line('Category') ?>
                </a>
            </h5>
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

                <table id="catgtable" class="table table-striped table-bordered zero-configuration">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Total Products') ?></th>
                        <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                        <th><?php echo $this->lang->line('Worth (Sales/Stock)') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>


                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1;
                    foreach ($cat as $row) {
                        $cid = $row['id'];
                        $hash_code = $row['hash_code'];
                        $title = $row['title'];
                        $total = $row['pc'];

                        $qty = +$row['qty'];
                        $salessum = amountExchange($row['salessum'], 0, $this->aauth->get_user()->loc);
                        $worthsum = amountExchange($row['worthsum'], 0, $this->aauth->get_user()->loc);
                        echo "<tr>
                    <td>$i</td>
                    <td><a href='" . base_url("productcategory/view?id=$cid&ref=$hash_code") . "' >$title</a></td>
                    <td>$total</td>
                    <td>$qty</td>
                    <td>$salessum/$worthsum</td>
                    <td><a href='" . base_url("productcategory/view?id=$cid&ref=$hash_code") . "' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> " . $this->lang->line('View') . "</a>&nbsp; <a class='btn btn-blue  btn-sm' href='" . base_url() . "productcategory/report_product?id=" . $cid . "&ref=" .$hash_code. " target='_blank'> <span class='fa fa-pie-chart'></span>" . $this->lang->line('Sales') . "</a>&nbsp;  <a href='" . base_url("productcategory/edit?id=$cid&ref=$hash_code") . "' class='btn btn-warning btn-sm'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a>&nbsp;<a href='#' data-object-id='" . $cid . "' data-object-ref='" . $hash_code . "' class='btn btn-danger btn-sm delete-object' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";


                        $i++;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th><?php echo $this->lang->line('Name') ?></th>
                        <th><?php echo $this->lang->line('Total Products') ?></th>
                        <th><?php echo $this->lang->line('Stock Quantity') ?></th>
                        <th><?php echo $this->lang->line('Worth (Sales/Stock)') ?></th>
                        <th><?php echo $this->lang->line('Action') ?></th>
                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            //datatables
            $('#catgtable').DataTable({
                responsive: true, <?php datatable_lang();?> dom: 'Blfrtip',
                buttons: [
                    {
                        extend: 'excelHtml5',
                        footer: true,
                        exportOptions: {
                            columns: [0, 1, 2, 3, 4]
                        }
                    }
                ],
            });

        });
    </script>
    <div id="delete_model" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Delete') ?></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <p><?php echo $this->lang->line('delete this product category') ?></strong></p>
                </div>
                <div class="modal-footer">
                    <input type="hidden" id="object-id" value="">
                    <input type="hidden" id="object-ref" value="">
                    <input type="hidden" id="action-url" value="productcategory/delete_i">
                    <button type="button" data-dismiss="modal" class="btn btn-primary"
                            id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                    <button type="button" data-dismiss="modal"
                            class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                </div>
            </div>
        </div>
    </div>