<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>

        <div class="content-body">
            <section class="card">
                <div id="invoice-template" class="card-block">
                    <div class="row wrapper white-bg page-heading">

                        <div class="col-lg-12">
                            <?php
                            $validtoken = hash_hmac('ripemd160', 'q' . $invoice['iid'], $this->config->item('encryption_key'));


                            $link = '../../billing/printquote?id=' . $invoice['iid'] . '&token=' . $validtoken;
                            $linkp = '../../billing/print_rec?id=' . $invoice['iid'] . '&token=' . $validtoken;
                            ?>
                            <div class="title-action">







                                <div class="btn-group ">
                                    <button type="button" class="btn btn-success btn-min-width dropdown-toggle mb-1"
                                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                                class="icon-print"></i> <?php echo $this->lang->line('Print Quote') ?>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item"
                                           href="<?php echo $link ?>"><?php echo $this->lang->line('Print') ?></a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item"
                                           href="<?php echo $link ?>&d=1"><?php echo $this->lang->line('PDF Download') ?></a>

                                    </div>
                                </div>



                            </div>
                        </div>
                    </div>

                    <!-- Invoice Company Details -->
                    <div id="invoice-company-details" class="row mt-2">
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left"><p></p>
                            <img src="../../userfiles/company/<?php echo $this->config->item('logo') ?>"
                                 class="img-responsive p-1 m-b-2" style="max-height: 120px;">
                            <p class="text-muted"><?php echo $this->lang->line('From') ?></p>


                            <ul class="px-0 list-unstyled">
                                <?php echo '<li class="text-bold-800">' . $this->config->item('ctitle') . '</li><li>' .
                                    $this->config->item('address') . '</li><li>' . $this->config->item('city') . '</li><li>Phone: ' . $this->config->item('phone') . '</li><li> Email: ' . $this->config->item('email'); ?>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-right">
                            <h2><?php echo $this->lang->line('QUOTE') ?></h2>
                            <p class="pb-1"> <?php echo $this->config->item('prefix') . ' #' . $invoice['tid'] . '</p>
                            <p class="pb-1">Reference:' . $invoice['refer'] . '</p>'; ?>
                            <ul class="px-0 list-unstyled">
                                <li><?php echo $this->lang->line('Gross Amount') ?></li>
                                <li class="lead text-bold-600"><?php echo amountExchange($invoice['total'], $invoice['multi']) ?></li>
                            </ul>
                        </div>
                    </div>
                    <!--/ Invoice Company Details -->

                    <!-- Invoice Customer Details -->
                    <div id="invoice-customer-details" class="row pt-2">
                        <div class="col-sm-12 text-xs-center text-md-left">
                            <p class="text-muted"><?php echo $this->lang->line('Bill To') ?></p>
                        </div>
                        <div class="col-md-6 col-sm-12 text-xs-center text-md-left">
                            <ul class="px-0 list-unstyled">


                                <li class="text-bold-600"><a
                                          ><strong
                                                class="invoice_a"><?php echo $invoice['name'] . '</strong></a></li><li>' . $invoice['address'] . '</li><li>' . $invoice['city'] . ',' . $invoice['country'] . '</li><li>' . $this->lang->line('Phone') . ': ' . $invoice['phone'] . '</li><li>Email: ' . $invoice['email']; ?>
                                </li>
                            </ul>

                        </div>
                        <div class="offset-md-3 col-md-3 col-sm-12 text-xs-center text-md-left">
                            <?php echo '<p><span class="text-muted">' . $this->lang->line('Quote Date') . ' :</span> ' . dateformat($invoice['invoicedate']) . '</p> <p><span class="text-muted">' . $this->lang->line('Due Date') . ' :</span> ' . dateformat($invoice['invoiceduedate']) . '</p>  <p><span class="text-muted">' . $this->lang->line('Terms') . ' :</span> ' . $invoice['termtit'] . '</p>';
                            ?>
                        </div>
                    </div>
                    <!--/ Invoice Customer Details -->
                    <?php if ($invoice['proposal'] != '') {
                        echo '<div id="invoice-customer-details" class="row pt-2">
                        <div class="col-sm-12 text-xs-center text-md-left">';

                        echo '<h5>' . $this->lang->line('Proposal') . '</h5>';
                        echo '<p>' . $invoice['proposal'] . '</p>';


                        echo '   </div></div>';
                    } ?>
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
                                    foreach ($products as $row) {
 $sub_t += $row['price'] * $row['qty'];
                                        echo '<tr>
<th scope="row">' . $c . '</th>
                            <td>' . $row['product'] . '</td>
                           
                            <td>' . amountExchange($row['price'], $invoice['multi']) . '</td>
                             <td>' . $row['qty'] . '</td>
                            <td>' . amountExchange($row['totaltax'], $invoice['multi']) . ' (' . amountFormat_s($row['tax']) . '%)</td>
                            <td>' . amountExchange($row['totaldiscount'], $invoice['multi']) . ' (' . amountFormat($row['discount']) . '' . $invoice['format_discount'] . ')</td>
                            <td>' . amountExchange($row['subtotal'], $invoice['multi']) . '</td>
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
                                    <div class="col-md-8">

                                        <p class="lead"><?php echo $this->lang->line('Quote Status') ?>: <u><strong
                                                        id="pstatus"><?php echo $this->lang->line(ucwords($invoice['status'])) ?></strong></u>
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
                                            <td class="text-xs-right"> <?php echo amountExchange($sub_t, $invoice['multi']) ?></td>
                                        </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('TAX') ?></td>
                                            <td class="text-xs-right"><?php echo amountExchange($invoice['tax'], $invoice['multi']) ?></td>
                                        </tr>
                                         <tr>
                                        <td><?php echo $this->lang->line('Discount') ?></td>
                                        <td class="text-xs-right"><?php echo amountExchange($invoice['discount'], $invoice['multi']) ?></td>
                                    </tr>
                                        <tr>
                                            <td><?php echo $this->lang->line('Shipping') ?></td>
                                            <td class="text-xs-right"><?php echo amountExchange($invoice['shipping'], $invoice['multi']) ?></td>
                                        </tr>


                                        <tr class="bg-grey bg-lighten-4">
                                            <td class="text-bold-800"><?php echo $this->lang->line('Total') ?></td>
                                            <td class="text-bold-800 text-xs-right"> <?php

                                                echo ' <span id="paydue">' . amountExchange($invoice['total'], $invoice['multi']) . '</span></strong>'; ?></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="text-xs-center">
                                    <p><?php echo $this->lang->line('Authorized person') ?></p>
                                    <?php echo '<img src="../../userfiles/employee_sign/' . $employee['sign']. '" alt="signature" class="height-100"/>
                                    <h6>(' . $employee['name'] . ')</h6>
                                    <p class="text-muted">' . user_role($employee['roleid']) . '</p>'; ?>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Invoice Footer -->

                    <div id="invoice-footer">


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

                </div>
            </section>
        </div>
    </div>
</div>

