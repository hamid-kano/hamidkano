<div class="content-body">
    <div class="card">
        <div class="card-header">
            <h5 class="title"> <?php echo $this->lang->line('Products') ?> <a
                        href="<?php echo base_url('products/add') ?>"
                        class="btn btn-primary btn-sm rounded">
                    <?php echo $this->lang->line('Add new') ?>
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


            <div>
                <?php if (isset($cat[0])) {
                    ?>
                    <h5 class="title"> <?php echo $this->lang->line('Sub') ?><?php echo $this->lang->line('Categories') ?>
                    </h5>
                    <hr>
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
                            $title = $row['title'];
                            $total = $row['pc'];

                            $qty = +$row['qty'];
                            $salessum = amountExchange($row['salessum'], 0, $this->aauth->get_user()->loc);
                            $worthsum = amountExchange($row['worthsum'], 0, $this->aauth->get_user()->loc);
                            echo "<tr>
                    <td>$i</td>
                    <td><a href='" . base_url("productcategory/view?id=$cid&sub=true") . "' >$title</a></td>
                    <td>$total</td>
                    <td>$qty</td>
                    <td>$salessum/$worthsum</td>
                    <td><a href='" . base_url("productcategory/view?id=$cid&sub=true") . "' class='btn btn-success btn-sm'><i class='fa fa-eye'></i> " . $this->lang->line('View') . "</a>&nbsp; <a class='btn btn-pink  btn-sm' href='" . base_url() . "productcategory/report_product?id=" . $cid . "&sub=true' target='_blank'> <span class='fa fa-pie-chart'></span>" . $this->lang->line('Sales') . "</a>&nbsp;  <a href='" . base_url("productcategory/edit?id=$cid") . "' class='btn btn-warning btn-sm'><i class='fa fa-pencil'></i> " . $this->lang->line('Edit') . "</a>&nbsp;<a href='#' data-object-id='" . $cid . "' class='btn btn-danger btn-sm delete-object2' title='Delete'><i class='fa fa-trash'></i></a></td></tr>";


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
                <?php } ?>
                <div class="card-body">


                    <hr>
                    <table id="productstable" class="table table-striped table-bordered zero-configuration">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Stock') ?></th>
                            <th><?php echo $this->lang->line('Code') ?></th>
                            <th><?php echo $this->lang->line('Category') ?></th>
                            <th><?php echo $this->lang->line('Warehouse') ?></th>
                            <th><?php echo $this->lang->line('Price') ?></th>
                            <th><?php echo $this->lang->line('Settings') ?></th>


                        </tr>
                        </thead>
                        <tbody>
                        </tbody>

                        <tfoot>
                        <tr>
                            <th>#</th>
                            <th><?php echo $this->lang->line('Name') ?></th>
                            <th><?php echo $this->lang->line('Stock') ?></th>
                            <th><?php echo $this->lang->line('Code') ?></th>
                            <th><?php echo $this->lang->line('Category') ?></th>
                            <th><?php echo $this->lang->line('Warehouse') ?></th>
                            <th><?php echo $this->lang->line('Price') ?></th>
                            <th><?php echo $this->lang->line('Settings') ?></th>

                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <script type="text/javascript">

            var table;

            $(document).ready(function () {

                //datatables
                table = $('#productstable').DataTable({

                    "processing": true, //Feature control the processing indicator.
                    "serverSide": true, //Feature control DataTables' server-side processing mode.
                    "order": [], //Initial no order.
                    responsive: true,
                    <?php datatable_lang();?>

                    // Load data for the table's content from an Ajax source
                    "ajax": {
                        "url": "<?php if (isset($sub)) {
                            $t = '1';
                        } else {
                            $t = '0';
                        } echo site_url('products/product_list') . '?id=' . $id . '&sub=' . $t;  ?>",
                        "type": "POST",
                        'data': {'<?=$this->security->get_csrf_token_name()?>': crsf_hash}
                    },

                    //Set column definition initialisation properties.
                    "columnDefs": [
                        {
                            "targets": [0], //first column / numbering column
                            "orderable": false, //set not orderable
                        },
                    ], dom: 'Blfrtip',
                    buttons: [
                        {
                            extend: 'excelHtml5',
                            footer: true,
                            exportOptions: {
                                columns: [1, 2, 3, 4, 5, 6]
                            }
                        }
                    ],

                });
                $(document).on('click', ".view-object", function (e) {
                    e.preventDefault();
                    $('#view-object-id').val($(this).attr('data-object-id'));

                    $('#view_model').modal({backdrop: 'static', keyboard: false});

                    var actionurl = $('#view-action-url').val();
                    $.ajax({
                        url: baseurl + actionurl,
                        data: 'id=' + $('#view-object-id').val() + '&' + crsf_token + '=' + crsf_hash,
                        type: 'POST',
                        dataType: 'html',
                        success: function (data) {
                            $('#view_object').html(data);

                        }

                    });

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
                        <p><?php echo $this->lang->line('delete this product') ?></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="object-id" value="">
                        <input type="hidden" id="action-url" value="products/delete_i">
                        <button type="button" data-dismiss="modal" class="btn btn-primary"
                                id="delete-confirm"><?php echo $this->lang->line('Delete') ?></button>
                        <button type="button" data-dismiss="modal"
                                class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="view_model" class="modal  fade">
            <div class="modal-dialog modal-lg">
                <div class="modal-content ">
                    <div class="modal-header">

                        <h4 class="modal-title"><?php echo $this->lang->line('View') ?></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body" id="view_object">
                        <p></p>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" id="view-object-id" value="">
                        <input type="hidden" id="view-action-url" value="products/view_over">

                        <button type="button" data-dismiss="modal"
                                class="btn"><?php echo $this->lang->line('Close') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <div id="delete_model2" class="modal fade">
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
                        <input type="hidden" id="object-id2" value="">
                        <input type="hidden" id="action-url2" value="productcategory/delete_i_sub">
                        <button type="button" data-dismiss="modal" class="btn btn-primary"
                                id="delete-confirm2"><?php echo $this->lang->line('Delete') ?></button>
                        <button type="button" data-dismiss="modal"
                                class="btn"><?php echo $this->lang->line('Cancel') ?></button>
                    </div>
                </div>
            </div>
        </div>