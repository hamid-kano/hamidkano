<form method="post" id="data_form" class="content-body">
    <div class="row">
        <div class="col-md-6 card">
            <div class="input-group mt-1">
                <a href='#'
                   class="btn btn-primary  round "
                   data-toggle="modal"
                   data-target="#addCustomer">
                    <i class="fa fa-plus-circle"></i> <?php echo $this->lang->line('Add') ?>
                </a>
                <input type="text" class="form-control round mousetrap" name="cst"
                       id="pos-customer-box"
                       placeholder="<?php echo $this->lang->line('Enter Customer Name'); ?> "
                       autocomplete="off"/>
            </div>
            <div class="row ml-3">
                <div id="customer-box-result" class="col-md-12"></div>
                <div id="customer" class="col-md-12 ml-3">
                    <div class="clientinfo">
                        <input type="hidden" name="customer_id" id="customer_id"
                               value="<?= $invoice['csd'] ?>">
                        <div id="customer_name"><strong><?= $invoice['name'] ?></strong></div>
                    </div>
                </div>
            </div>
            <div id="saman-row-pos" class="rqw mt-1">
                <div class="col-md-12">
                    <table id="pos_list" class="table-responsive tfr pos_stripe">
                        <thead>
                        <tr class="item_header bg-gradient-directional-purple white">

                            <th width="10%"
                                class="text-center"><?php echo $this->lang->line('Quantity') ?></th>
                            <th width="20%"
                                class="text-center"><?php echo $this->lang->line('Rate') ?></th>
                            <th width="10%"
                                class="text-center"><?php echo $this->lang->line('Tax(%)') ?></th>

                            <th width="10%"
                                class="text-center"><?php echo $this->lang->line('Discount') ?></th>
                            <th width="10%" class="text-center">
                                <?php echo $this->lang->line('Amount') ?>
                            </th>
                            <th width="5%"
                                class="text-center"><?php echo $this->lang->line('Action') ?></th>
                        </tr>

                        </thead>
                        <tbody id="pos_items">
                        <?php $i = 0;
                        foreach ($products as $row) {
                            echo '<tr id="ppid-' . $i . '"><td colspan="7"><input type="text" class="form-control text-center" name="product_name[]" placeholder="Enter Product name or Code" id="productname-' . $i . '"  value="' . $row['product'] . '"></td></tr>';
                            echo '    <tr><td><input type="text" class="form-control p-mobile req amnt" name="product_qty[]" id="amount-' . $i . '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()" autocomplete="off" value="' . amountFormat_general($row['qty']) . '" ><input type="hidden" class="old_amnt" name="old_product_qty[]" value="' . amountFormat_general($row['qty']) . '" ></td> <td><input type="text" class="form-control p-mobile req prc" name="product_price[]" id="price-' . $i . '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()" autocomplete="off" value="' . amountExchange_s($row['price'], $invoice['multi'], $this->aauth->get_user()->loc) . '"></td><td> <input type="text" class="form-control p-mobile vat" name="product_tax[]" id="vat-' . $i . '" onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()" autocomplete="off" value="' . amountFormat_general($row['tax']) . '"></td>  <td><input type="text" class="form-control p-mobile discount pos_w" name="product_discount[]" onkeypress="return isNumber(event)" id="discount-' . $i . '" onkeyup="rowTotal(' . $i . '), billUpyog()" autocomplete="off" value="' . amountFormat_general($row['discount']) . '"></td> <td><span class="currenty">' . $this->config->item('currency') . '</span> <strong><span class="ttlText" id="result-' . $i . '">' . amountExchange_s($row['subtotal'], $invoice['multi'], $this->aauth->get_user()->loc) . '</span></strong></td> <td class="text-center"><button type="button" data-rowid="' . $i . '" class="btn btn-danger removeItem" title="Remove"> <i class="fa fa-minus-square"></i> </button> </td><input type="hidden" name="taxa[]" id="taxa-' . $i . '" value="' . amountExchange_s($row['totaltax'], $invoice['multi'], $this->aauth->get_user()->loc) . '"><input type="hidden" name="disca[]" id="disca-' . $i . '" value="' . amountExchange_s($row['totaldiscount'], $invoice['multi'], $this->aauth->get_user()->loc) . '"><input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' . $i . '" value="' . amountExchange_s($row['subtotal'], $invoice['multi'], $this->aauth->get_user()->loc) . '"> <input type="hidden" class="pdIn" name="pid[]" id="pid-' . $i . '" value="' . $row['pid'] . '"> <input type="hidden" name="unit[]" id="unit-' . $i . '" value="' . $row['unit'] . '"> <input type="hidden" name="hsn[]" id="hsn-' . $i . '" value="' . $row['code'] . '"> </tr>';
                            $i++;
                        } ?>
                        </tbody>
                    </table>
                    <br>
                    <hr>
                    <div class="row mt-1">
                        <div class="col-3"><input type="hidden" value="0" id="subttlform"
                                                  name="subtotal"
                                                  value="<?php echo amountExchange_s($invoice['subtotal'], $invoice['multi'], $this->aauth->get_user()->loc) ?>"><strong><?php echo $this->lang->line('Total Tax') ?></strong>
                        </div>
                        <div class="col-6"><span
                                    class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                            <span id="taxr"
                                  class="lightMode"><?php echo amountExchange_s($invoice['tax'], $invoice['multi'], $this->aauth->get_user()->loc) ?></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3">
                            <strong><?php echo $this->lang->line('Total Discount') ?></strong></div>
                        <div class="col-6"><span
                                    class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                            <span id="discs"
                                  class="lightMode"><?php echo amountExchange_s($invoice['discount'], $invoice['multi'], $this->aauth->get_user()->loc) ?></span>
                        </div>
                    </div>


                    <div class="row mt-1">


                        <div class="col-3">
                            <strong><?php echo $this->lang->line('Shipping') ?></strong></div>
                        <div class="col-6"><input type="text"
                                                  value="<?php if ($invoice['ship_tax_type'] == 'excl') {
                                                      $invoice['shipping'] = $invoice['shipping'] - $invoice['ship_tax'];
                                                  }
                                                  echo amountExchange_s($invoice['shipping'], $invoice['multi'], $this->aauth->get_user()->loc); ?>"
                                                  class="form-control shipVal"
                                                  onkeypress="return isNumber(event)"
                                                  placeholder="Value"
                                                  name="shipping" autocomplete="off"
                                                  onkeyup="billUpyog()">( <?= $this->lang->line('Tax') ?> <?= $this->config->item('currency'); ?>
                            <span id="ship_final"><?= amountExchange_s($invoice['ship_tax'], $invoice['multi'], $this->aauth->get_user()->loc) ?> </span>
                            )
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-3"><strong><?php echo $this->lang->line('Grand Total') ?>
                                (<span
                                        class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                        </div>
                        <div class="col-6"><input type="text"
                                                  value="<?= amountExchange_s($invoice['total'], $invoice['multi'], $this->aauth->get_user()->loc); ?>"
                                                  name="total" class="form-control"
                                                  id="invoiceyoghtml" readonly=""><input
                                    type="hidden"
                                    value="<?= amountExchange_s($invoice['total'], $invoice['multi'], $this->aauth->get_user()->loc); ?>"
                                    name="old_total" class="form-control"
                                    id="old_invoiceyoghtml" readonly=""></div>
                    </div>
                    <div class="row mt-1">
                        <div class="col-3">
                            <strong> <?php echo $this->lang->line('Extra') . ' ' . $this->lang->line('Discount') ?></strong>
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control form-control-sm discVal"
                                   onkeypress="return isNumber(event)"
                                   placeholder="Value"
                                   name="disc_val" autocomplete="off"
                                   onkeyup="billUpyog()"
                                   value="<?= amountExchange_s($invoice['discount_rate'], $invoice['multi'], $this->aauth->get_user()->loc); ?>">
                            <input type="hidden"
                                   name="after_disc" id="after_disc">
                        </div>
                        <div class="col-3">
                            ( <?= $this->config->item('currency'); ?>
                            <span id="disc_final">0</span> )
                        </div>
                    </div>
                </div>
            </div>
            <hr>
            <div class="row mt-2">
                <div class="col text-center">
                    <a href="#" class="possubmit3 btn btn-lg btn-success sub-btn" data-type="6"
                       data-toggle="modal"
                       data-target="#basicPay"><i
                                class="icon icon-cash"></i> <?php echo $this->lang->line('Update') ?>
                    </a>
                </div>
            </div>
            <hr>
            <ul class="nav nav-tabs" role="tablist">
                <li class="nav-item">
                    <a class="btn btn-outline-danger  mr-1 mb-1" id="base-tab1" data-toggle="tab" aria-controls="tab1"
                       href="#tab1" role="tab" aria-selected="false"><i
                                class="fa fa-trophy"></i>
                        <?php echo $this->lang->line('Coupon') ?></a>
                </li>

                <li class="nav-item">
                    <a class="btn btn-outline-success mb-1" id="base-tab4" data-toggle="tab" aria-controls="tab4"
                       href="#tab4" role="tab" aria-selected="false"><i class="fa fa-cogs"></i>
                        <?php echo $this->lang->line('Invoice Properties') ?></a>
                </li>
            </ul>
            <div class="tab-content px-1 pt-1">
                <div class="tab-pane" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                    <div class="col">
                        <div class="input-group">

                            <input type="text" class="form-control"
                                   id="coupon" name="coupon"><input type="hidden"
                                                                    name="coupon_amount"
                                                                    id="coupon_amount"
                                                                    value="0"><span
                                    class="input-group-addon round"> <button
                                        class="apply_coupon btn btn-small btn-primary sub-btn"><?php echo $this->lang->line('Apply') ?></button></span>

                        </div>
                    </div>
                    <div class="col">

                        <input type="hidden" class="text-info" name="i_coupon" id="i_coupon"
                               value="">
                        <span class="text-primary text-bold-600" id="r_coupon"></span>
                    </div>
                </div>

                <div class="tab-pane" id="tab4" role="tabpanel" aria-labelledby="base-tab4">
                    <div class="form-group row">
                        <div class="col-sm-3"><label for="invocieno"
                                                     class="caption"><?php echo $this->lang->line('Invoice Number') ?></label>

                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-file-text-o"
                                                                     aria-hidden="true"></span>
                                </div>
                                <input type="text" class="form-control" placeholder="Invoice #"
                                       name="invocieno" id="invocieno"
                                       value="<?php echo $invoice['tid']; ?>" readonly>
                                <input type="hidden" name="iid"
                                       value="<?php echo $invoice['iid']; ?>">
                                       
                                       <input type="hidden" name="ref"
                                       value="<?php echo $ref; ?>">
                            </div>
                        </div>
                        <div class="col-sm-3"><label for="invocieno"
                                                     class="caption"><?php echo $this->lang->line('Reference') ?></label>

                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                     aria-hidden="true"></span>
                                </div>
                                <input type="text" class="form-control"
                                       placeholder="Reference #"
                                       name="refer" value="<?php echo $invoice['refer'] ?>">
                            </div>
                        </div>


                        <div class="col-sm-3"><label for="invociedate"
                                                     class="caption"><?php echo $this->lang->line('Invoice Date'); ?></label>

                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-calendar4"
                                                                     aria-hidden="true"></span>
                                </div>
                                <input type="text" class="form-control required"
                                       placeholder="Billing Date" name="invoicedate"
                                       data-toggle="datepicker"
                                       autocomplete="false"
                                       value="<?php echo dateformat($invoice['invoicedate']) ?>">
                            </div>
                        </div>
                        <div class="col-sm-3"><label for="invocieduedate"
                                                     class="caption"><?php echo $this->lang->line('Invoice Due Date') ?></label>

                            <div class="input-group">
                                <div class="input-group-addon"><span class="icon-calendar-o"
                                                                     aria-hidden="true"></span>
                                </div>
                                <input type="text" class="form-control required" id="tsn_due"
                                       name="invocieduedate"
                                       placeholder="Due Date" data-toggle="datepicker"
                                       autocomplete="false"
                                       value="<?php echo dateformat($invoice['invoiceduedate']) ?>">
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-sm-6">
                            <?php echo $this->lang->line('Payment Terms') ?> <select
                                    name="pterms"
                                    class="selectpicker form-control"><?php

                                echo '<option value="' . $invoice['term'] . '">Do not change</option>';
                                foreach ($terms as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                } ?>

                            </select>
                            <?php if ($exchange['active'] == 1) {
                                echo $this->lang->line('Payment Currency client') ?>
                            <?php } ?>
                            <?php if ($exchange['active'] == 1) {
                                ?>
                                <select name="mcurrency"
                                        class="selectpicker form-control">

                                <?php
                                echo '<option value="' . $invoice['multi'] . '">Do not change</option><option value="0">None</option>';
                                foreach ($currency as $row) {
                                    echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                } ?>

                                </select><?php } ?>
                        </div>
                        <div class="col-sm-6">
                            <label for="toAddInfo"
                                   class="caption"><?php echo $this->lang->line('Invoice Note') ?></label>
                            <textarea class="form-control" name="notes"
                                      rows="2"><?php echo $invoice['notes'] ?></textarea>
                        </div>
                    </div>


                </div>
            </div>


        </div>


        <div class="col-md-6 card border-amber bg-lighten-1 bg-faded round pt-1">


            <div class="row">
                <div class="col-md-3 grey text-xs-center"><?php echo $this->lang->line('Warehouse') ?>
                    <select
                            id="warehouses"
                            class="selectpicker form-control round teal">
                        <?php echo $this->common->default_warehouse();
                        echo '<option value="0">' . $this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                        } ?>

                    </select></div>
                <div class="col-md-3  grey text-xs-center"><?php echo $this->lang->line('Categories') ?>
                    <select
                            id="categories"
                            class="selectpicker form-control round teal">
                        <option value="0"><?php echo $this->lang->line('All') ?></option><?php
                        foreach ($cat as $row) {
                            $cid = $row['id'];
                            $title = $row['title'];
                            echo "<option value='$cid'>$title</option>";
                        }
                        ?>
                    </select></div>
                <div class="col-md-3 grey text-xs-center"><?php echo $this->lang->line('Tax') ?>
                    <select class="form-control round teal"
                            onchange="changeTaxFormat(this.value)"
                            id="taxformat">
                        <?php echo $taxlist; ?>
                    </select></div>
                <div class="col-md-3 grey text-xs-center">  <?php echo $this->lang->line('Discount') ?>
                    <select class="form-control round teal"
                            onchange="changeDiscountFormat(this.value)"
                            id="discountFormat">
                        <?php echo '<option value="' . $invoice['format_discount'] . '">&raquo; ' . $invoice['format_discount'] . ' Discount</option>'; ?>
                        <?php echo $this->common->disclist() ?>
                    </select></div>

            </div>
            <hr class="white">
            <div class="form-group row">


                <div class="col-sm-1"></div>
                <div class="col-sm-10">
                    <input type="text" class="form-control text-center round" name="product_barcode"
                           placeholder="Enter Product name or Code" id="search_bar" autocomplete="off"
                           autofocus="autofocus">
                </div>
            </div>

            <div class="row">
                <div class="col-md-12 pt-1" id="pos_item">
                    <!-- pos items -->
                </div>
            </div>
        </div>


    </div>
    <br>


    </div>

    <input type="hidden" value="pos_invoices/editaction" id="action-url">
    <input type="hidden" value="search" id="billtype">
    <input type="hidden" value="<?= $i ?>" name="counter" id="ganak">
    <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">
    <input type="hidden" value="<?= $this->common->taxhandle_edit($invoice['taxstatus']) ?>" name="taxformat"
           id="tax_format">
    <input type="hidden" value="<?= $invoice['format_discount']; ?>" name="discountFormat" id="discount_format">
    <input type="hidden" value="<?= $invoice['taxstatus']; ?>" name="tax_handle" id="tax_status">
    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">

    <input type="hidden" value="<?php
    $tt = 0;
    if ($invoice['ship_tax_type'] == 'incl') $tt = @number_format(($invoice['shipping'] - $invoice['ship_tax']) / $invoice['shipping'], 2, '.', '');
    echo amountFormat_general(number_format((($invoice['ship_tax'] / $invoice['shipping']) * 100) + $tt, 3, '.', '')); ?>"
           name="shipRate" id="ship_rate">
    <input type="hidden" value="<?= $invoice['ship_tax_type']; ?>" name="ship_taxtype"
           id="ship_taxtype">
    <input type="hidden" value="<?= amountFormat_general($invoice['ship_tax']); ?>" name="ship_tax" id="ship_tax">


</form>


<div class="modal fade" id="addCustomer" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="product_action" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header bg-gradient-directional-blue white">
                    <i class="icon-user-plus"></i> <?php echo $this->lang->line('Add Customer') ?></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                    <h4 class="modal-title" id="myModalLabel">
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                    <div class="row">
                        <div class="col-sm-12">
                            <h5><?php echo $this->lang->line('Billing Address') ?></h5>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="name"><?php echo $this->lang->line('Name') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Name"
                                           class="form-control margin-bottom" id="mcustomer_name" name="name"
                                           required>
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="phone"><?php echo $this->lang->line('Phone') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Phone"
                                           class="form-control margin-bottom" name="phone" id="mcustomer_phone">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="email"><?php echo $this->lang->line('Email') ?></label>

                                <div class="col-sm-10">
                                    <input type="email" placeholder="Email"
                                           class="form-control margin-bottom" name="email"
                                           id="mcustomer_email">
                                </div>
                            </div>
                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="address"><?php echo $this->lang->line('Address') ?></label>

                                <div class="col-sm-10">
                                    <input type="text" placeholder="Address"
                                           class="form-control margin-bottom " name="address"
                                           id="mcustomer_address1">
                                </div>
                            </div>

                            <div class="form-group row">

                                <label class="col-sm-2 col-form-label"
                                       for="customergroup"><?php echo $this->lang->line('Group') ?></label>

                                <div class="col-sm-10">
                                    <select name="customergroup" class="form-control">
                                        <?php
                                        foreach ($customergrouplist as $row) {
                                            $cid = $row['id'];
                                            $title = $row['title'];
                                            echo "<option value='$cid'>$title</option>";
                                        }
                                        ?>
                                    </select>


                                </div>
                            </div>


                        </div>


                    </div>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default"
                            data-dismiss="modal"><?php echo $this->lang->line('Close') ?></button>
                    <input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="ADD"/ >
                </div>
            </form>
        </div>
    </div>
</div>
<!--card-->

<div class="modal fade" id="basicPay" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">
            <form method="post" id="basicpay_data" class="form-horizontal">
                <!-- Modal Header -->
                <div class="modal-header">

                    <h4 class="modal-title"><?php echo $this->lang->line('Make Payment') ?></h4>
                    <button type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                        <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                    </button>
                </div>

                <!-- Modal Body -->
                <div class="modal-body">
                    <p id="statusMsg"></p>

                    <form role="form" id="payment-form">
                        <div class="row">
                            <div class="col credit-card-box ">
                                <div class="text-xs-center"><h1 id="b_total"></h1></div>
                                <div class="row">
                                    <div class="col-8">
                                        <div class="card-title">
                                            <label for="cardNumber"><?php echo $this->lang->line('Amount') ?></label>
                                            <div class="input-group">
                                                <input
                                                        type="text" onkeypress="return isNumber(event)"
                                                        class="form-control  text-bold-600 blue-grey"
                                                        name="p_amount"
                                                        placeholder="Amount"
                                                        id="p_amount" onkeyup="update_pay_pos()"
                                                />
                                                <span class="input-group-addon"><i class="icon icon-cash"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="card-title">
                                            <label for="cardNumber"><?php echo $this->lang->line('Payment Method') ?></label>
                                            <select class="form-control" name="p_method" id="p_method">
                                                <option value='Cash'><?php echo $this->lang->line('Cash') ?></option>
                                                <option value='Card Swipe'><?php echo $this->lang->line('Card Swipe') ?></option>
                                                <option value='Bank'><?php echo $this->lang->line('Bank') ?></option>

                                            </select></div>
                                    </div>

                                </div>
                                <div class="form-group">

                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6">
                                <div class="form-group  text-bold-600 red">
                                    <label for="amount"><?php echo $this->lang->line('Balance Due') ?>
                                    </label>
                                    <input type="text" class="form-control red" name="amount" id="balance1"
                                           value="0.00" onkeypress="return isNumber(event)"
                                           required>
                                </div>
                            </div>
                            <div class="col-5 col-md-5 pull-right">
                                <div class="form-group text-bold-600 text-g">
                                    <label for="b_change"><?php echo $this->lang->line('Change') ?></label>
                                    <input
                                            type="text"
                                            class="form-control green" onkeypress="return isNumber(event)"
                                            name="b_change" id="change_p" value="0">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-success btn-lg btn-block"
                                        type="submit"
                                        id="pos_basic_pay" data-type="4"><i
                                            class="icon icon-arrow-circle-o-right"></i> <?php echo $this->lang->line('Paynow') ?>
                                </button>
                            </div>
                        </div>

                        <div class="row" style="display:none;">
                            <div class="col">
                                <p class="payment-errors"></p>
                            </div>
                        </div>


                    </form>

                    <!-- shipping -->


                </div>
                <!-- Modal Footer -->

            </form>
        </div>
    </div>
</div>

<div class="modal fade" id="register" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Your Register') ?></h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                </button>

            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div class="text-center m-1"><?php echo $this->lang->line('Active') ?> - <span id="r_date"></span></div>


                <div class="row">
                    <div class="col-6">
                        <div class="form-group  text-bold-600 green">
                            <label for="amount"><?php echo $this->lang->line('Cash') ?>
                                (<?= $this->config->item('currency'); ?>)
                            </label>
                            <input type="text" class="form-control green" id="r_cash"
                                   onkeypress="return isNumber(event)"
                                   value="0.00"
                                   readonly>
                        </div>
                    </div>
                    <div class="col-5 col-md-5 pull-right">
                        <div class="form-group text-bold-600 blue">
                            <label for="b_change blue"><?php echo $this->lang->line('Card') ?></label>
                            <input
                                    type="text"
                                    class="form-control blue" onkeypress="return isNumber(event)"
                                    id="r_card" value="0" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group  text-bold-600 indigo">
                            <label for="amount"><?php echo $this->lang->line('Bank') ?>
                            </label>
                            <input type="text" class="form-control indigo" id="r_bank"
                                   value="0.00"
                                   readonly>
                        </div>
                    </div>
                    <div class="col-5 col-md-5 pull-right">
                        <div class="form-group text-bold-600 red">
                            <label for="b_change"><?php echo $this->lang->line('Change') ?>(-)</label>
                            <input
                                    type="text"
                                    class="form-control red"
                                    id="r_change" value="0" readonly>
                        </div>
                    </div>
                </div>


                <div class="row" style="display:none;">
                    <div class="col-xs-12">
                        <p class="payment-errors"></p>
                    </div>
                </div>


                <!-- shipping -->


            </div>
            <!-- Modal Footer -->


        </div>
    </div>
</div>
<div class="modal fade" id="close_register" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Close') ?><?php echo $this->lang->line('Your Register') ?></h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <div class="row">
                    <div class="col-4"></div>
                    <div class="col-4">
                        <a href="<?= base_url() ?>/register/close" class="btn btn-danger btn-lg btn-block"
                           type="submit"
                        ><i class="icon icon-arrow-circle-o-right"></i> <?php echo $this->lang->line('Yes') ?></a>
                    </div>
                    <div class="col-4"></div>
                </div>

            </div>
            <!-- Modal Footer -->


        </div>
    </div>
</div>
<div class="modal fade" id="stock_alert" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header">

                <h4 class="modal-title"><?php echo $this->lang->line('Stock Alert') ?> !</h4>
                <button type="button" class="close" data-dismiss="modal">
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">

                <div class="row p-1">
                    <div class="alert alert-danger mb-2" role="alert">
                        <strong>Oh snap!</strong> <?php echo $this->lang->line('order or edit the stock') ?>
                    </div>
                </div>

            </div>
            <!-- Modal Footer -->


        </div>
    </div>
</div>
<script type="text/javascript">

    $.ajax({
        url: baseurl + 'search_products/pos_search',
        dataType: 'html',
        method: 'POST',
        data: 'cid=' + $('#categories').val() + '&wid=' + $('#warehouses option:selected').val() + '&' + crsf_token + '=' + crsf_hash,
        success: function (data) {
            $('#pos_item').html(data);
        }
    });

    function update_register() {
        $.ajax({
            url: baseurl + 'register/status',
            dataType: 'json',
            success: function (data) {
                $('#r_cash').val(data.cash);
                $('#r_card').val(data.card);
                $('#r_bank').val(data.bank);
                $('#r_change').val(data.change);
                $('#r_date').text(data.date);
            }
        });
    }

    update_register();
    $(".possubmit").on("click", function (e) {
        e.preventDefault();
        var o_data = $("#data_form").serialize() + '&type=' + $(this).attr('data-type');
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
    });

    $(".possubmit2").on("click", function (e) {
        e.preventDefault();
        var old_p = accounting.unformat($('#old_invoiceyoghtml').val(), accounting.settings.number.decimal);
        var new_p = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);
        var new_pay = (+new_p) - (+old_p);
        if (new_pay < 0) new_pay = 0;
        $('#card_total').val(new_pay);
    });

    $(".possubmit3").on("click", function (e) {
        e.preventDefault();
        var old_p = accounting.unformat($('#old_invoiceyoghtml').val(), accounting.settings.number.decimal);
        var new_p = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);
        var new_pay = (+new_p) - (+old_p);
        if (new_pay < 0) new_pay = 0;
        $('#b_total').html(accounting.formatNumber(new_pay));
        $('#p_amount').val(accounting.formatNumber(new_pay));

    });

    function update_pay_pos() {
        var am_pos = accounting.unformat($('#p_amount').val(), accounting.settings.number.decimal);


        var old_p = accounting.unformat($('#old_invoiceyoghtml').val(), accounting.settings.number.decimal);
        var new_p = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);
        var new_pay = (+new_p) - (+old_p);
        if (new_pay < 0) new_pay = 0;

        var due = parseFloat(new_pay - am_pos).toFixed(two_fixed);

        if (due >= 0) {
            $('#balance1').val(accounting.formatNumber(due));
            $('#change_p').val(0);
        } else {
            due = due * (-1)
            $('#balance1').val(0);
            $('#change_p').val(accounting.formatNumber(due));
        }

    }

    $('#pos_card_pay').on("click", function (e) {
        e.preventDefault();
        $('#cardPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({scrollTop: $('#notify').offset().top - 100}, 1000);
        var o_data = $("#data_form").serialize() + '&' + $("#card_data").serialize() + '&type=' + $(this).attr('data-type');
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
        update_register();
    });

    $('#pos_basic_pay').on("click", function (e) {
        e.preventDefault();
        $('#basicPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({scrollTop: $('#notify').offset().top - 100}, 1000);
        var o_data = $("#data_form").serialize() + '&p_amount=' + $("#p_amount").val() + '&p_method=' + $("#p_method option:selected").val() + '&type=' + $(this).attr('data-type');
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);

        setTimeout(
            function () {
                update_register();
            }, 3000);


    });
</script> <?php
/*
The MIT License (MIT)

Copyright (c) 2015 William Hilton

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE.
*/
?>
<!-- Vendor libraries -->
<script type="text/javascript">
    var $form = $('#payment-form');
    $form.on('submit', payWithCard);

    /* If you're using Stripe for payments */
    function payWithCard(e) {
        e.preventDefault();

        /* Visual feedback */
        $form.find('[type=submit]').html('Processing <i class="fa fa-spinner fa-pulse"></i>')
            .prop('disabled', true);

        jQuery.ajax({

            url: '<?php echo base_url('billing/process_card') ?>',
            type: 'POST',
            data: $('#payment-form').serialize(),
            dataType: 'json',
            success: function (data) {

                $form.find('[type=submit]').html('Payment successful <i class="fa fa-check"></i>').prop('disabled', true);
                $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

            },
            error: function () {
                $form.find('[type=submit]').html('There was a problem').removeClass('success').addClass('error');
                /* Show Stripe errors on the form */
                $form.find('.payment-errors').text('Try refreshing the page and trying again.');
                $form.find('.payment-errors').closest('.row').show();
                $form.find('[type=submit]').html('Error! <i class="fa fa-exclamation-circle"></i>')
                    .prop('disabled', true);
                $("#notify .message").html("<strong>Error</strong>: Please try again!");


            }

        });


    }

    window.onload = function () {
        billUpyog();
    };
</script>


