<div class="content-body">
    <div class="card">
        <div class="card-content">
            <div id="notify" class="alert alert-success" style="display:none;">
                <a href="#" class="close" data-dismiss="alert">&times;</a>

                <div class="message"></div>
            </div>
            <div id="invoice-template" class="card-body">
                <div class="row wrapper white-bg page-heading">

                    <div class="col-lg-12">
                        <?php
                        $validtoken = hash_hmac('ripemd160', 'p' . $invoice['iid'], $this->config->item('encryption_key'));
                        $link = base_url('billing/purchase?id=' . $invoice['iid'] . '&token=' . $validtoken.'&ref='.$ref.'');
                        if ($invoice['status'] != 'canceled') { ?>
                            <div class="title-action">
                            <a href="<?php echo 'edit?id=' . $invoice['iid'].'&ref='.$ref; ?>" class="btn btn-warning"><i
                                        class="fa fa-pencil"></i> <?php echo $this->lang->line('Edit Order') ?> </a>

                            <a href="#part_payment" data-toggle="modal" data-remote="false" data-type="reminder"
                               class="btn btn-large btn-success" title="Partial Payment"
                            ><span class="fa fa-money"></span> <?php echo $this->lang->line('Make Payment') ?> </a>

                            <div class="btn-group">
                                <button type="button" class="btn btn-primary dropdown-toggle" data-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                            <span
                                    class="fa fa-envelope-o"></span> <?php echo $this->lang->line('Send') ?>
                                </button>
                                <div class="dropdown-menu"><a href="#sendEmail" data-toggle="modal"
                                                              data-remote="false" class="dropdown-item sendbill"
                                                              data-type="purchase"><?php echo $this->lang->line('Purchase Request') ?></a>


                                </div>

                            </div>

                            <div class="btn-group ">
                                <button type="button" class="btn btn-success btn-min-width dropdown-toggle"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                            class="fa fa-print"></i> <?php echo $this->lang->line('Print Order') ?>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item"
                                       href="<?= base_url('billing/printorder?id=' . $invoice['iid'] . '&token=' . $validtoken.'&ref= '.$ref); ?>"><?php echo $this->lang->line('Print') ?></a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item"
                                       href="<?= base_url('billing/printorder?id=' . $invoice['iid'] . '&token=' . $validtoken.'&ref= '.$ref); ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>

                                </div>
                            </div>
                            <a href="<?php echo $link; ?>" class="btn btn-primary"><i
                                        class="fa fa-globe"></i> <?php echo $this->lang->line('Public Preview') ?>
                            </a>

                            <a href="#pop_model" data-toggle="modal" data-remote="false"
                               class="btn btn-large btn-success" title="Change Status"
                            ><span class="fa fa-retweet"></span> <?php echo $this->lang->line('Change Status') ?></a>
                            <a href="#cancel-bill" class="btn btn-danger" id="cancel-bill_p"><i
                                        class="fa fa-minus-circle"> </i> <?php echo $this->lang->line('Cancel') ?>
                            </a>

                            </div><?php
                            if ($invoice['multi'] > 0) {

                                echo '<div class="tag tag-info text-xs-center mt-2">' . $this->lang->line('Payment currency is different') . '</div>';
                            }
                        } else {
                            echo '<h2 class="btn btn-oval btn-danger">' . $this->lang->line('Cancelled') . '</h2>';
                        } ?>
                    </div>
                </div>

                <!-- Invoice Company Details -->
                <div id="invoice-company-details" class="row mt-2">
                    <div class="col-md-6 col-sm-12 text-xs-center text-md-left"><p></p>
                        <img src="<?php $loc = location($invoice['loc']);
                        echo base_url('userfiles/company/' . $loc['logo']) ?>"
                             class="img-responsive p-1 m-b-2" style="max-height: 120px;">
                        <p class="ml-2"><?= $loc['cname'] ?></p>
                    </div>
                    <div class="col-md-6 col-sm-12 text-xs-center text-md-right">
                        <h2><?php echo $this->lang->line('Purchase Order') ?></h2>
                        <p class="pb-1"> <?php echo prefix(2) . $invoice['tid'] . '</p>
                            <p class="pb-1">' . $this->lang->line('Reference') . ':' . $invoice['refer'] . '</p>'; ?>
                        <ul class="px-0 list-unstyled">
                            <li><?php echo $this->lang->line('Gross Amount') ?></li>
                            <li class="lead text-bold-800"><?php echo amountExchange($invoice['total'], 0, $this->aauth->get_user()->loc) ?></li>
                        </ul>
                    </div>
                </div>
                <!--/ Invoice Company Details -->

                <!-- Invoice Customer Details -->
                <div id="invoice-customer-details" class="row pt-2">
                    <div class="col-sm-12 text-xs-center text-md-left">
                        <p class="text-muted"><?php echo $this->lang->line('Bill From') ?></p>
                    </div>
                    <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                        <ul class="px-0 list-unstyled">


                            <li class="text-bold-800"><a
                                        href="<?php echo base_url('supplier/view?id=' . $invoice['cid']) ?>"><strong
                                            class="invoice_a"><?php echo $invoice['name'] . '</strong></a></li><li>' . $invoice['address'] . '</li><li>' . $invoice['city'] . ',' . $invoice['country'] . '</li><li>' . $this->lang->line('Phone') . ': ' . $invoice['phone'] . '</li><li>' . $this->lang->line('Email') . ': ' . $invoice['email']; ?>
                            </li>
                        </ul>

                    </div>
                    <div class="offset-md-3 col-md-3 col-sm-12 text-xs-center text-md-left">
                        <?php echo '<p><span class="text-muted">' . $this->lang->line('Order Date') . ' :</span> ' . dateformat($invoice['invoicedate']) . '</p> <p><span class="text-muted">' . $this->lang->line('Due Date') . ' :</span> ' . dateformat($invoice['invoiceduedate']) . '</p>  <p><span class="text-muted">' . $this->lang->line('Terms') . ' :</span> ' . $invoice['termtit'] . '</p>';
                        ?>
                    </div>
                </div>
                <!--/ Invoice Customer Details -->

                <!-- Invoice Items Details -->
                <div id="invoice-items-details" class="pt-2">
                    <div class="row">
                        <div class="table-responsive col-sm-12">
                            <table class="table table-striped">
                                <thead>
                                <?php if ($invoice['taxstatus'] == 'cgst'){ ?>

                                <tr>
                                    <th>#</th>
                                    <th><?php echo $this->lang->line('Description') ?></th>
                                    <th class="text-xs-left"><?php echo $this->lang->line('HSN') ?></th>
                                    <th class="text-xs-left"><?php echo $this->lang->line('Rate') ?></th>
                                    <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                                    <th class="text-xs-left"><?php echo $this->lang->line('Discount') ?></th>
                                    <th class="text-xs-left"><?php echo $this->lang->line('CGST') ?></th>
                                    <th class="text-xs-left"><?php echo $this->lang->line('SGST') ?></th>
                                    <th class="text-xs-left"><?php echo $this->lang->line('Amount') ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php $c = 1;
                                $sub_t = 0;

                                foreach ($products as $row) {
                                    $sub_t += $row['price'] * $row['qty'];
                                    $gst = $row['totaltax'] / 2;
                                    $rate = $row['tax'] / 2;
                                    echo '<tr>
<th scope="row">' . $c . '</th>
                            <td>' . $row['product'] . '</td> 
                            <td>' . $row['code'] . '</td>                          
                            <td>' . amountExchange($row['price'], 0, $this->aauth->get_user()->loc) . '</td>
                             <td>' . amountFormat_general($row['qty']) . $row['unit'] . '</td>
                              <td>' . amountExchange($row['totaldiscount'], 0, $this->aauth->get_user()->loc) . ' (' . amountFormat_s($row['discount']) . $this->lang->line($invoice['format_discount']) . ')</td>
                            <td>' . amountExchange($gst, 0, $this->aauth->get_user()->loc) . ' (' . amountFormat_s($rate) . '%)</td>
                             <td>' . amountExchange($gst, 0, $this->aauth->get_user()->loc) . ' (' . amountFormat_s($rate) . '%)</td>                           
                            <td>' . amountExchange($row['subtotal'], 0, $this->aauth->get_user()->loc) . '</td>
                        </tr>';

                                    echo '<tr><td colspan=5>' . $row['product_des'] . '</td></tr>';
                                    $c++;
                                } ?>

                                </tbody>
                                <?php

                                } elseif ($invoice['taxstatus'] == 'igst') {
                                    ?>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line('Description') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('HSN') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Rate') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Discount') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('IGST') ?></th>

                                        <th class="text-xs-left"><?php echo $this->lang->line('Amount') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c = 1;
                                    $sub_t = 0;

                                    foreach ($products as $row) {
                                        $sub_t += $row['price'] * $row['qty'];

                                        echo '<tr>
<th scope="row">' . $c . '</th>
                            <td>' . $row['product'] . '</td> 
                            <td>' . $row['code'] . '</td>                          
                            <td>' . amountExchange($row['price'], 0, $this->aauth->get_user()->loc) . '</td>
                             <td>' . amountFormat_general($row['qty']) . $row['unit'] . '</td>
                              <td>' . amountExchange($row['totaldiscount'], 0, $this->aauth->get_user()->loc) . ' (' . amountFormat_s($row['discount']) . $this->lang->line($invoice['format_discount']) . ')</td>
                            <td>' . amountExchange($row['totaltax'], 0, $this->aauth->get_user()->loc) . ' (' . amountFormat_s($row['tax']) . '%)</td>
                                            
                            <td>' . amountExchange($row['subtotal'], 0, $this->aauth->get_user()->loc) . '</td>
                        </tr>';

                                        echo '<tr><td colspan=5>' . $row['product_des'] . '</td></tr>';
                                        $c++;
                                    } ?>

                                    </tbody>
                                    <?php
                                } else {
                                    ?>
                                    <tr>
                                        <th>#</th>
                                        <th><?php echo $this->lang->line('Description') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Rate') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Qty') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Tax') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Discount') ?></th>
                                        <th class="text-xs-left"><?php echo $this->lang->line('Amount') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $c = 1;
                                    $sub_t = 0;

                                    foreach ($products as $row) {
                                        $sub_t += $row['price'] * $row['qty'];
                                        echo '<tr>
<th scope="row">' . $c . '</th>
                            <td>' . $row['product'] . '</td>                           
                            <td>' . amountExchange($row['price'], 0, $this->aauth->get_user()->loc) . '</td>
                             <td>' . amountFormat_general($row['qty']) . $row['unit'] . '</td>
                            <td>' . amountExchange($row['totaltax'], 0, $this->aauth->get_user()->loc) . ' (' . amountFormat_s($row['tax']) . '%)</td>
                            <td>' . amountExchange($row['totaldiscount'], 0, $this->aauth->get_user()->loc) . ' (' . amountFormat_s($row['discount']) . $this->lang->line($invoice['format_discount']) . ')</td>
                            <td>' . amountExchange($row['subtotal'], 0, $this->aauth->get_user()->loc) . '</td>
                        </tr>';

                                        echo '<tr><td colspan=5>' . $row['product_des'] . '</td></tr>';
                                        $c++;
                                    } ?>

                                    </tbody>
                                <?php } ?>
                            </table>
                        </div>
                    </div>
                    <p></p>
                    <div class="row">
                        <div class="col-md-7 col-sm-12 text-xs-center text-md-left">


                            <div class="row">
                                <div class="col-md-8"><p
                                            class="lead"><?php echo $this->lang->line('Payment Status') ?>:
                                        <u><strong
                                                    id="pstatus"><?php echo $this->lang->line(ucwords($invoice['status'])) ?></strong></u>
                                    </p>
                                    <p class="lead"><?php echo $this->lang->line('Payment Method') ?>: <u><strong
                                                    id="pmethod"><?php echo $this->lang->line($invoice['pmethod']) ?></strong></u>
                                    </p>

                                    <p class="lead mt-1"><br><?php echo $this->lang->line('Note') ?>:</p>
                                    <code>
                                        <?php echo $invoice['notes'] ?>
                                    </code>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-12">
                            <p class="lead"><?php echo $this->lang->line('Total Due') ?></p>
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td><?php echo $this->lang->line('Sub Total') ?></td>
                                        <td class="text-xs-right"> <?php echo amountExchange($sub_t, 0, $this->aauth->get_user()->loc) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $this->lang->line('TAX') ?></td>
                                        <td class="text-xs-right"><?php echo amountExchange($invoice['tax'], 0, $this->aauth->get_user()->loc) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $this->lang->line('Discount') ?></td>
                                        <td class="text-xs-right"><?php echo amountExchange($invoice['discount'], 0, $this->aauth->get_user()->loc) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $this->lang->line('Shipping') ?></td>
                                        <td class="text-xs-right"><?php echo amountExchange($invoice['shipping'], 0, $this->aauth->get_user()->loc) ?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-bold-800"><?php echo $this->lang->line('Total') ?></td>
                                        <td class="text-bold-800 text-xs-right"> <?php echo amountExchange($invoice['total'], 0, $this->aauth->get_user()->loc) ?></td>
                                    </tr>
                                    <tr>
                                        <td><?php echo $this->lang->line('Payment Made') ?></td>
                                        <td class="pink text-xs-right">
                                            (-) <?php echo ' <span id="paymade">' . amountExchange($invoice['pamnt'], 0, $this->aauth->get_user()->loc) ?></span></td>
                                    </tr>
                                    <tr class="bg-grey bg-lighten-4">
                                        <td class="text-bold-800"><?php echo $this->lang->line('Balance Due') ?></td>
                                        <td class="text-bold-800 text-xs-right"> <?php $myp = '';
                                            $rming = $invoice['total'] - $invoice['pamnt'];
                                            if ($rming < 0) {
                                                $rming = 0;

                                            }
                                            echo ' <span id="paydue">' . amountExchange($rming, 0, $this->aauth->get_user()->loc) . '</span></strong>'; ?></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="text-xs-center">
                                <p><?php echo $this->lang->line('Authorized person') ?></p>
                                <?php echo '<img src="' . base_url('userfiles/employee_sign/' . $employee['sign']) . '" alt="signature" class="height-100"/>
                                    <h6>(' . $employee['name'] . ')</h6>
                                    <p class="text-muted">' . user_role($employee['roleid']) . '</p>'; ?>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Invoice Footer -->

                <div id="invoice-footer"><p class="lead"><?php echo $this->lang->line('Debit Transactions') ?>:</p>
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('Date') ?></th>
                            <th><?php echo $this->lang->line('Method') ?></th>
                            <th><?php echo $this->lang->line('Debit') ?></th>
                            <th><?php echo $this->lang->line('Credit') ?></th>
                            <th><?php echo $this->lang->line('Note') ?></th>


                        </tr>
                        </thead>
                        <tbody id="activity">
                        <?php foreach ($activity as $row) {

                            echo '<tr>
                            <td>' . $row['date'] . '</td>
                            <td>' . $this->lang->line($row['method']) . '</td>
                            <td>' . amountExchange($row['debit'], 0, $this->aauth->get_user()->loc) . '</td>
                             <td>' . amountExchange($row['credit'], 0, $this->aauth->get_user()->loc) . '</td>
                            <td>' . $row['note'] . '</td>
                        </tr>';
                        } ?>

                        </tbody>
                    </table>

                    <div class="row">

                        <div class="col-md-7 col-sm-12">

                            <h6><?php echo $this->lang->line('Terms & Condition') ?></h6>
                            <p> <?php

                                echo '<strong>' . $invoice['termtit'] . '</strong><br>' . $invoice['terms'];
                                ?></p>
                        </div>

                    </div>

                </div>
                <!--/ Invoice Footer -->
                <hr>
                <pre><?php echo $this->lang->line('Public Access URL') ?>: <?php
                    echo $link ?></pre>
                <div class="row">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('Files') ?></th>


                        </tr>
                        </thead>
                        <tbody id="activity">
                        <?php foreach ($attach as $row) {

                            echo '<tr><td><a data-url="' . base_url() . 'purchase/file_handling?op=delete&name=' . $row['col1'] . '&invoice=' . $invoice['iid'] . '" class="aj_delete"><i class="btn-danger btn-lg fa fa-trash"></i></a> <a class="n_item" href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"> ' . $row['col1'] . ' </a></td></tr>';
                        } ?>

                        </tbody>
                    </table>

                </div>
                <div class="card">
                    <!-- The fileinput-button span is used to style the file input field as button -->
                    <span class="btn btn-success fileinput-button">
        <i class="glyphicon glyphicon-plus"></i>
        <span>Select files...</span>
                        <!-- The file input field used as target for the file upload widget -->
        <input id="fileupload" type="file" name="files[]" multiple>
    </span>
                    <br>
                    <pre>Allowed: gif, jpeg, png, docx, docs, txt, pdf, xls </pre>
                    <br>
                    <!-- The global progress bar -->
                    <div id="progress" class="progress">
                        <div class="progress-bar progress-bar-success"></div>
                    </div>
                    <!-- The container for the uploaded files -->
                    <table id="files" class="files"></table>
                    <br>
                </div>
            </div>

        </div>
    </div>
</div>
<script src="<?php echo assets_url('assets/myjs/jquery.ui.widget.js') ?>"></script>
<script src="<?php echo assets_url('assets/myjs/jquery.fileupload.js') ?>"></script>
<script>
    /*jslint unparam: true */
    /*global window, $ */
    $(function () {
        'use strict';
        // Change this to the location of your server-side upload handler:
        var url = '<?php echo base_url() ?>purchase/file_handling?id=<?php echo $invoice['iid'] ?>';
        $('#fileupload').fileupload({
            url: url,
            dataType: 'json',
            formData: {'<?=$this->security->get_csrf_token_name()?>': crsf_hash},
            done: function (e, data) {
                $.each(data.result.files, function (index, file) {
                    $('#files').append('<tr><td><a data-url="<?php echo base_url() ?>purchase/file_handling?op=delete&name=' + file.name + '&invoice=<?php echo $invoice['iid'] ?>" class="aj_delete"><i class="btn-danger btn-sm fa fa-trash"></i> ' + file.name + ' </a></td></tr>');
                });
            },
            progressall: function (e, data) {
                var progress = parseInt(data.loaded / data.total * 100, 10);
                $('#progress .progress-bar').css(
                    'width',
                    progress + '%'
                );
            }
        }).prop('disabled', !$.support.fileInput)
            .parent().addClass($.support.fileInput ? undefined : 'disabled');
    });

    $(document).on('click', ".aj_delete", function (e) {
        e.preventDefault();
        var aurl = $(this).attr('data-url');
        var obj = $(this);
        jQuery.ajax({
            url: aurl,
            type: 'GET',
            dataType: 'json',
            success: function (data) {
                obj.closest('tr').remove();
                obj.remove();
            }
        });

    });
</script>
<!-- Modal HTML -->
<div id="part_payment" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Debit Payment Confirmation') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form class="payment">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-addon"><?php echo $this->config->item('currency') ?></div>
                                <input type="text" class="form-control" placeholder="Total Amount" name="amount"
                                       id="rmpay" value="<?php echo $rming ?>">
                            </div>

                        </div>
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-calendar4"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control required" id="tsn_date"
                                       placeholder="Billing Date" name="paydate"
                                       value="<?php echo dateformat($this->config->item('date')); ?>">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Payment Method') ?></label>
                            <select name="pmethod" class="form-control mb-1">
                                <option value="Cash"><?php echo $this->lang->line('Cash') ?></option>
                                <option value="Card"><?php echo $this->lang->line('Card') ?></option>
                                <option value="Bank">Bank</option>
                            </select><label for="account"><?php echo $this->lang->line('Account') ?></label>

                            <select name="account" class="form-control">
                                <?php foreach ($acclist as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['holder'] . ' / ' . $row['acn'] . '</option>';
                                }
                                ?>
                            </select></div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Note') ?></label>
                            <input type="text" class="form-control"
                                   name="shortnote" placeholder="Short note"
                                   value="Payment for purchase #<?php echo $invoice['tid'] ?>"></div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="invoiceid" value="<?php echo $invoice['iid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" name="cid" value="<?php echo $invoice['cid'] ?>"><input type="hidden"
                                                                                                     name="cname"
                                                                                                     value="<?php echo $invoice['name'] ?>">
                        <button type="button" class="btn btn-primary"
                                id="purchasepayment"><?php echo $this->lang->line('Do Payment') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- cancel -->
<div id="cancel_bill" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title"><?php echo $this->lang->line('Cancel Purchase Order') ?></h4>
            </div>
            <div class="modal-body">
                <form class="cancelbill">
                    <div class="row">
                        <div class="col">
                            <?php echo $this->lang->line('this action! Are you sure') ?>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" class="form-control"
                               name="tid" value="<?php echo $invoice['iid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"> <?php echo $this->lang->line('Close') ?></button>
                        <button type="button" class="btn btn-primary"
                                id="send"> <?php echo $this->lang->line('Cancel') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>

<!-- Modal HTML -->
<div id="sendEmail" class="modal fade">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">Email</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div id="request">
                <div id="ballsWaveG">
                    <div id="ballsWaveG_1" class="ballsWaveG"></div>
                    <div id="ballsWaveG_2" class="ballsWaveG"></div>
                    <div id="ballsWaveG_3" class="ballsWaveG"></div>
                    <div id="ballsWaveG_4" class="ballsWaveG"></div>
                    <div id="ballsWaveG_5" class="ballsWaveG"></div>
                    <div id="ballsWaveG_6" class="ballsWaveG"></div>
                    <div id="ballsWaveG_7" class="ballsWaveG"></div>
                    <div id="ballsWaveG_8" class="ballsWaveG"></div>
                </div>
            </div>
            <div class="modal-body" id="emailbody" style="display: none;">
                <form id="sendbill">
                    <div class="row">
                        <div class="col">
                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-envelope-o"
                                                                     aria-hidden="true"></span></div>
                                <input type="text" class="form-control" placeholder="Email" name="mailtoc"
                                       value="<?php echo $invoice['email'] ?>">
                            </div>

                        </div>

                    </div>


                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Supplier') ?></label>
                            <input type="text" class="form-control"
                                   name="customername" value="<?php echo $invoice['name'] ?>"></div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Subject') ?></label>
                            <input type="text" class="form-control"
                                   name="subject" id="subject">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col mb-1"><label
                                    for="shortnote"><?php echo $this->lang->line('Message') ?></label>
                            <textarea name="text" class="summernote" id="contents" title="Contents"></textarea></div>
                    </div>

                    <input type="hidden" class="form-control"
                           id="invoiceid" name="tid" value="<?php echo $invoice['iid'] ?>">
                    <input type="hidden" class="form-control"
                           id="emailtype" value="">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default"
                        data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                <button type="button" class="btn btn-primary"
                        id="sendM"><?php echo $this->lang->line('Send') ?></button>
            </div>
        </div>
    </div>
</div>

<div id="pop_model" class="modal fade">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Change Status') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>

            <div class="modal-body">
                <form id="form_model">


                    <div class="row">
                        <div class="col mb-1"><label
                                    for="pmethod"><?php echo $this->lang->line('Mark As') ?></label>
                            <select name="status" class="form-control mb-1">
                                <option value="paid"><?php echo $this->lang->line('Paid') ?></option>
                                <option value="due"><?php echo $this->lang->line('Due') ?></option>
                                <option value="partial"><?php echo $this->lang->line('Partial') ?></option>
                            </select>

                        </div>
                    </div>

                    <div class="modal-footer">
                        <input type="hidden" class="form-control required"
                               name="tid" id="invoiceid" value="<?php echo $invoice['iid'] ?>">
                        <button type="button" class="btn btn-default"
                                data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                        <input type="hidden" id="action-url" value="purchase/update_status">
                        <button type="button" class="btn btn-primary"
                                id="submit_model"><?php echo $this->lang->line('Change Status') ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(function () {
        $('.summernote').summernote({
            height: 100,
            toolbar: [
                // [groupName, [list of button]]
                ['style', ['bold', 'italic', 'underline', 'clear']],
                ['font', ['strikethrough', 'superscript', 'subscript']],
                ['fontsize', ['fontsize']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['height', ['height']],
                ['fullscreen', ['fullscreen']],
                ['codeview', ['codeview']]
            ]
        });

        $('#sendM').on('click', function (e) {
            e.preventDefault();

            sendBill($('.summernote').summernote('code'));

        });
    });

    $(document).on('click', "#cancel-bill_p", function (e) {
        e.preventDefault();

        $('#cancel_bill').modal({backdrop: 'static', keyboard: false}).one('click', '#send', function () {
            var acturl = 'transactions/cancelpurchase';
            cancelBill(acturl);

        });
    });
</script>
