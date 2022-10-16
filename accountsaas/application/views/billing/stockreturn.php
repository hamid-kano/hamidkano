<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>

        <div class="content-body">
            <section class="card">
                <div id="invoice-template" class="card-body">
                    <div class="row wrapper white-bg page-heading">

                        <div class="col-lg-12">
                            <?php $rming = $invoice['total'] - $invoice['pamnt'];
                            if ($invoice['status'] != 'canceled') { ?>
                                <div class="row">


                                    <div class="col-md-12 text-xs-right">
                                        <div class="btn-group mt-2">
                                            <button type="button" class="btn btn-primary btn-min-width dropdown-toggle"
                                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                        class="icon-print"></i> <?php echo $this->lang->line('Print Order') ?>
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                   href="<?php echo 'printstockreturn?id=' . $invoice['iid'] . '&token=' . $token.'&ref='.$ref; ?>"><?php echo $this->lang->line('Print') ?></a>
                                                <div class="dropdown-divider"></div>
                                                <a class="dropdown-item"
                                                   href="<?php echo 'printstockreturn?id=' . $invoice['iid'] . '&token=' . $token.'&ref='.$ref; ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="title-action ">


                                </div><?php } else {
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
                            <p class="text-muted"><?php echo $this->lang->line('From') ?></p>


                            <ul class="px-0 list-unstyled">
                                <?php

                                echo '<li class="text-bold-800">' . $loc['cname'] . '</li><li>' . $loc['address'] . '</li><li>' . $loc['city'] . ',</li><li>' . $loc['region'] . ',' . $loc['country'] . ' -  ' . $loc['postbox'] . '</li><li>' . $this->lang->line('Phone') . ' : ' . $loc['phone'] . '</li><li> ' . $this->lang->line('Email') . ' : ' . $loc['email'] ?>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-right mt-2">
                            <h2><?php
                                switch ($invoice['i_class']) {
                                    case 0 :
                                        $type_i = $this->lang->line('Stock Return');
                                        break;
                                    case 1 :
                                        $type_i = $this->lang->line('Stock Return');
                                        break;
                                    case 2 :
                                        $type_i = $this->lang->line('Credit Note');
                                        break;
                                }


                                echo $type_i ?> </h2>
                            <p class="pb-1"> <?php echo prefix(4) . $invoice['tid'] . '</p>
                            <p class="pb-1">' . $this->lang->line('Reference') . ':' . $invoice['refer'] . '</p>'; ?>
                            <ul class="px-0 list-unstyled">
                                <li><?php echo $this->lang->line('Gross Amount') ?></li>
                                <li class="lead text-bold-800"><?= amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) ?></li>
                            </ul>
                        </div>

                    </div>

                    <!--/ Invoice Company Details -->

                    <!-- Invoice Customer Details -->
                    <div id="invoice-customer-details" class="row pt-2">
                        <div class="col-sm-12 text-xs-center text-md-left">
                            <p class="text-muted"><?php echo $this->lang->line('To') ?></p>
                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <ul class="px-0 list-unstyled">


                                <li class="text-bold-800"><strong
                                            class="invoice_a"><?php echo $invoice['name'] . '</strong></li><li>' . $invoice['address'] . '</li><li>' . $invoice['city'] . ',' . $invoice['country'] . '</li><li>' . $this->lang->line('Phone') . ': ' . $invoice['phone'] . '</li><li>' . $this->lang->line('Email') . ': ' . $invoice['email']; ?>
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
                            <td>' . amountExchange($row['price'], $invoice['multi'], $invoice['loc']) . '</td>
                             <td>' . amountFormat_general($row['qty']) . $row['unit'] . '</td>
                            <td>' . amountExchange($row['totaltax'], $invoice['multi'], $invoice['loc']) . ' (' . amountFormat_s($row['tax']) . '%)</td>
                            <td>' . amountExchange($row['totaldiscount'], $invoice['multi'], $invoice['loc']) . ' (' . amountFormat_s($row['discount']) . $this->lang->line($invoice['format_discount']) . ')</td>
                            <td>' . amountExchange($row['subtotal'], $invoice['multi'], $invoice['loc']) . '</td>
                        </tr>';
                                        echo '<tr><td colspan=5>' . $row['product_des'] . '</td></tr>';
                                        $c++;
                                    } ?>

                                    </tbody>
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
                                            <td class="text-xs-right"> <?php echo amountExchange($sub_t, $invoice['multi'], $invoice['loc']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('TAX') ?></td>
                                            <td class="text-xs-right"><?php echo amountExchange($invoice['tax'], $invoice['multi'], $invoice['loc']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('Discount') ?></td>
                                            <td class="text-xs-right"><?php echo amountExchange($invoice['discount'], $invoice['multi'], $invoice['loc']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('Shipping') ?></td>
                                            <td class="text-xs-right"><?php echo amountExchange($invoice['shipping'], $invoice['multi'], $invoice['loc']) ?></td>
                                        </tr>
                                        <tr>
                                            <td class="text-bold-800"><?php echo $this->lang->line('Total') ?></td>
                                            <td class="text-bold-800 text-xs-right"> <?php echo amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) ?></td>
                                        </tr>

                                        <tr>
                                            <td><?php echo $this->lang->line('Payment Made'); ?></td>
                                            <td class="pink text-xs-right">
                                                (-) <?php echo ' <span id="paymade">' . amountExchange($invoice['pamnt'], $invoice['multi'], $invoice['loc']) ?></span></td>
                                        </tr>
                                        <tr class="bg-grey bg-lighten-4">
                                            <td class="text-bold-800"><?php echo $this->lang->line('Balance Due'); ?></td>
                                            <td class="text-bold-800 text-xs-right"> <?php $myp = '';

                                                if ($rming < 0) {
                                                    $rming = 0;

                                                }
                                                echo ' <span id="paydue">' . amountExchange($rming, $invoice['multi'], $invoice['loc']) . '</span></strong>'; ?></td>
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

                    <div id="invoice-footer"><p class="lead"><?php echo $this->lang->line('Transactions') ?>:</p>
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
                            <td>' . amountExchange($row['debit'], $invoice['multi'], $invoice['loc']) . '</td>
                            <td>' . amountExchange($row['credit'], $invoice['multi'], $invoice['loc']) . '</td>
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
                        <div class="row">
                            <?php if ($attach) { ?>

                                <table class="table table-striped">
                                    <thead>
                                    <tr>
                                        <th><?php echo $this->lang->line('Files') ?></th>


                                    </tr>
                                    </thead>
                                    <tbody id="activity">
                                    <?php foreach ($attach as $row) {

                                        echo '<tr><td><a href="' . base_url() . 'userfiles/attach/' . $row['col1'] . '"><i class="btn-info btn-lg icon-download"></i> ' . $row['col1'] . ' </a></td></tr>';
                                    } ?>

                                    </tbody>
                                </table>
                            <?php } ?>

                        </div>

                    </div>
                    <!--/ Invoice Footer -->

                </div>
            </section>
        </div>
    </div>
</div>




