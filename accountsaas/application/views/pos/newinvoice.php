<form method="post" id="data_form" class="content-body">
    <div class="sidebar-left sidebar-fixed bg-white">
        <div class="sidebar">
            <div class="sidebar-content ">
                <div class="card-body chat-fixed-search">

                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text" id="basic-addon1"><i class="ft-search"></i></span>
                        </div>
                        <input type="text" class="form-control" id="pos-customer-box"
                               placeholder="<?php echo $this->lang->line('Enter Customer Name'); ?>"
                               aria-describedby="button-addon2">
                        <div class="input-group-append" id="button-addon2">
                            <button class="btn btn-primary" type="button" data-toggle="modal"
                                    data-target="#Pos_addCustomer"> <?php echo $this->lang->line('Add') ?></button>
                        </div>
                    </div>
                    <div id="customer-box-result" class="col-md-12"></div>
                    <div id="customer" class="col-md-12 ml-3">
                        <div class="clientinfo">

                            <input type="hidden" name="customer_id" id="customer_id" value="16">
                            <div id="customer_name"><?php echo  $this->lang->line('Default'); ?>: <strong>نقدا  </strong></div>
                        </div>


                    </div>

                </div>
                <div>
                    <div class="users-list-padding media-list">

                        <br>
                        <div class="row bg-gradient-directional-purple white m-0 pt-1 pb-1">
                            <div class="col-6 ">
                                <i class="fa fa-briefcase"></i>
                                <?php echo $this->lang->line('Products') ?></th>
                            </div>
                            <div class="col-3">
                                <i class="fa fa-money"></i><?php echo $this->lang->line('Price') ?>
                            </div>
                            <div class="col-3">
                                <i
                                        class="fa fa-shopping-bag"></i> <?php echo $this->lang->line('Total') ?>
                            </div>
                        </div>
                        <div id="saman-pos2">
                            <div id="pos_items"></div>
                        </div>
                        <input type="hidden" name="total" class="form-control"
                               id="invoiceyoghtml" readonly="">
                        <hr class="mt-1">
                        <div class="row m-2">
                            <div class="col-3">
                                <strong> <?php echo $this->lang->line('Shipping') ?></strong>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control form-control-sm shipVal"
                                       onkeypress="return isNumber(event)"
                                       placeholder="Value"
                                       name="shipping" autocomplete="off"
                                       onkeyup="billUpyog()">
                            </div>
                            <div class="col-3">
                                ( <?php echo $this->lang->line('Tax') ?> <?= $this->config->item('currency'); ?>
                                <span id="ship_final">0</span> )
                            </div>
                        </div>


                        <div class="row m-2">
                            <div class="col-3">
                                <strong> <?php echo $this->lang->line('Total Tax') ?></strong>
                            </div>
                            <div class="col-3"><?php echo currency($this->aauth->get_user()->loc);
                                ?>
                                <span id="taxr" class="mr-1">0</span>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-3">
                                <strong> <?php echo $this->lang->line('Discount') .' '. $this->lang->line('Products'); ?></strong>
                            </div>
                            <div class="col-9"><?php echo currency($this->aauth->get_user()->loc);
                                ?>
                                <span id="discs"
                                      class="lightMode mr-1">0</span>
                            </div>
                        </div>
                        <div class="row m-2">
                            <div class="col-3">
                                <strong> <?php echo $this->lang->line('Extra') . ' ' . $this->lang->line('Discount') ?></strong>
                            </div>
                            <div class="col-3">
                                <input type="text" class="form-control form-control-sm discVal"
                                       onkeypress="return isNumber(event)"
                                       placeholder="Value" value="0"
                                       name="disc_val" autocomplete="off"
                                       onkeyup="billUpyog()">
                                <input type="hidden"
                                       name="after_disc" id="after_disc" value="0">
                            </div>
                            <div class="col-3">
                                ( <?= $this->config->item('currency'); ?>
                                <span id="disc_final">0</span> )
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="col-3">
                                <strong> <?php echo $this->lang->line('Total Discount'); ?></strong>
                            </div>
                            <div class="col-9"><?php echo currency($this->aauth->get_user()->loc);
                                ?>
                                <span id="total_final_discount" class="lightMode mr-1" > 0 </span>
                            </div>
                        </div>

                        <div class="row m-2">
                            <div class="col-3">
                                <strong> <?php echo $this->lang->line('Grand Total') ?></strong>
                            </div>
                            <div class="col-9"><?php echo currency($this->aauth->get_user()->loc);
                                ?>
                                <span class="font-medium-1 blue text-bold-600"
                                      id="bigtotal">0.00</span>
                            </div>
                        </div>


                        <hr>

                        <div class="m-1">

                            <ul class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a class="btn btn-outline-primary  mr-1 mb-1" id="base-tab1" data-toggle="tab"
                                       aria-controls="tab1" href="#tab1" role="tab" aria-selected="false"><i
                                                class="fa fa-trophy"></i>
                                        <?php echo $this->lang->line('Coupon') ?></a>
                                </li>
                                <li class="nav-item">
                                    <a class="btn btn-outline-secondary mr-1 mb-1" id="base-tab2" data-toggle="tab"
                                       aria-controls="tab2" href="#tab2" role="tab" aria-selected="false"><i
                                                class="icon-handbag"></i>
                                        <?php echo $this->lang->line('POS Settings') ?></a>
                                </li>
                                <!--<li class="nav-item">-->
                                <!--    <a class="btn btn-outline-danger  mr-1 mb-1" id="base-tab3" data-toggle="tab"-->
                                <!--       aria-controls="tab3" href="#tab3" role="tab" aria-selected="false"><i-->
                                <!--                class="fa fa-save"></i> <?php echo $this->lang->line('Draft') ?>(s)</a>-->
                                <!--</li>-->
                                <li class="nav-item">
                                    <a class="btn btn-outline-success mb-1" id="base-tab4" data-toggle="tab"
                                       aria-controls="tab4" href="#tab4" role="tab" aria-selected="false"><i
                                                class="fa fa-cogs"></i>
                                        <?php echo $this->lang->line('Invoice Properties') ?></a>
                                </li>
                            </ul>
                            <div class="tab-content px-1 pt-1">
                                <div class="tab-pane" id="tab1" role="tabpanel" aria-labelledby="base-tab1">
                                    <div class="input-group">

                                        <input type="text" class="form-control"
                                               id="coupon" name="coupon"><input type="hidden"
                                                                                name="coupon_amount"
                                                                                id="coupon_amount"
                                                                                value="0"><span
                                                class="input-group-addon round"> <button
                                                    class="apply_coupon btn btn-small btn-primary sub-btn"><?php echo $this->lang->line('Apply') ?></button></span>


                                    </div>
                                    <input type="hidden" class="text-info" name="i_coupon" id="i_coupon"
                                           value="">
                                    <span class="text-primary text-bold-600" id="r_coupon"></span>
                                </div>
                                <div class="tab-pane" id="tab2" role="tabpanel" aria-labelledby="base-tab2">
                                    <div class="row">
                                        <div class="col-4 blue text-xs-center"><?php echo $this->lang->line('Warehouse') ?>
                                            <select
                                                    id="v2_warehouses"
                                                    class="selectpicker form-control round teal">
                                                <?php echo $this->common->default_warehouse();
                                                echo '<option value="0">' . $this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
                                                    echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                                                } ?>

                                            </select></div>
                                        <div class="col-4 blue text-xs-center"><?php echo $this->lang->line('Tax') ?>
                                            <select class="form-control round"
                                                    onchange="changeTaxFormat(this.value)"
                                                    id="taxformat">
                                                <?php echo $taxlist; ?>
                                            </select></div>
                                        <div class="col-4 blue text-xs-center">  <?php echo $this->lang->line('Discount') ?>
                                            <select class="form-control round teal"
                                                    onchange="changeDiscountFormat(this.value)"
                                                    id="discountFormat">

                                                <?php echo $this->common->disclist() ?>
                                            </select></div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="tab3" role="tabpanel" aria-labelledby="base-tab3">
                                    <?php foreach ($draft_list as $rowd) {
                                        echo '<li class="indigo p-1"><a href="' . base_url() . 'pos_invoices/draft?id=' . $rowd['id'] . '"> #' . $rowd['tid'] . ' (' . $rowd['invoicedate'] . ')</a></li>';
                                    } ?>
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
                                                       value="<?php echo $lastinvoice + 1 ?>">
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
                                                       name="refer">
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
                                                       autocomplete="false">
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
                                                       autocomplete="false">
                                            </div>
                                        </div>
                                    </div>


                                    <div class="form-group row">
                                        <div class="col-sm-6">
                                            <?php echo $this->lang->line('Payment Terms') ?> <select
                                                    name="pterms"
                                                    class="selectpicker form-control"><?php foreach ($terms as $row) {
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
                                                <option value="0">Default</option>
                                                <?php foreach ($currency as $row) {
                                                    echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                                                } ?>

                                                </select><?php } ?>
                                        </div>
                                        <div class="col-sm-6">
                                            <label for="toAddInfo"
                                                   class="caption"><?php echo $this->lang->line('Invoice Note') ?></label>
                                            <textarea class="form-control" name="notes" rows="2"></textarea>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>

        </div>
    </div>
    <div class="content-right">
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <section class="chat-app-window">
                    <div class="row ">


                        <div class="col-sm-9">


                            <div class="position-relative has-icon-left">
                                <input type="text" class="form-control text-center round mousetrap"
                                       name="product_barcode"
                                       placeholder="Enter Product name, code or scan barcode" id="v22_search_bar"
                                       autocomplete="off" autofocus="autofocus">
                                <div class="form-control-position">
                                    <i class="icon-barcode2"></i>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3  grey text-xs-center"><select
                                    id="v2_categories"
                                    class="selectpicker form-control round teal">
                                <option value="0"><?php echo $this->lang->line('All') ?></option><?php
                                foreach ($cat as $row) {
                                    $cid = $row['id'];
                                    $title = $row['title'];
                                    echo "<option value='$cid'>$title</option>";
                                }
                                ?>
                            </select></div>


                    </div>
                    <hr class="white">


                    <div class="row m-0">
                        <div class="col-md-12 pt-0 " id="pos_item">
                            <!-- pos items -->
                        </div>
                    </div>
                </section>
                <section class="chat-app-form">
                    <div class="form-group text-center">
                        <!-- Button Group with Icons in different sizes -->
                        <div class="btn-group btn-group-lg" role="group">
                            <!--<button type="button" class="possubmit btn btn-warning"><i-->
                            <!--            class="fa fa-save"></i> <?php echo $this->lang->line('Draft') ?> </button>-->
                            <button type="button" class="btn btn-success possubmit3" data-type="6" data-toggle="modal"
                                    data-target="#basicPay"><i
                                        class="fa fa-money"></i> <?php echo $this->lang->line('Payment') ?>
                            </button> <?php

                            if ($enable_card['url']) { ?>
                                <!--<button type="button" class="btn btn-primary possubmit2" data-type="4"-->
                                <!--        data-toggle="modal" data-target="#cardPay"><i-->
                                <!--            class="fa fa-credit-card"></i> <?php echo $this->lang->line('Card') ?>-->
                                <!--</button>    -->
                            <?php } ?>


                        </div>
                        <a href="<?= base_url('stockreturn/create_client') ?>" class="red float-right"><i
                                    class="fa fa-reply-all"></i></a>
                    </div>


                </section>
            </div>
        </div>
    </div>
    <input type="hidden" value="pos_invoices/action" id="action-url">
    <input type="hidden" value="0" id="subttlform"
           name="subtotal">
    <input type="hidden" value="search" id="billtype">
    <input type="hidden" value="0" name="counter" id="ganak">
    <input type="hidden" value="0" id="custom_discount">
    <input type="hidden" value="<?php echo currency($this->aauth->get_user()->loc); ?>" name="currency">
    <input type="hidden" value="<?= $taxdetails['handle']; ?>" name="taxformat" id="tax_format">
    <input type="hidden" value="<?= $taxdetails['format']; ?>" name="tax_handle" id="tax_status">
    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">
    <input type="hidden" value="<?= $this->common->disc_status()['disc_format']; ?>" name="discountFormat"
           id="discount_format">
    <input type="hidden" value="<?= amountFormat_general($this->common->disc_status()['ship_rate']); ?>" name="shipRate"
           id="ship_rate">
    <input type="hidden" value="<?= $this->common->disc_status()['ship_tax']; ?>" name="ship_taxtype"
           id="ship_taxtype">
    <input type="hidden" value="0" name="ship_tax" id="ship_tax">
</form>
<audio id="beep" src="<?= assets_url() ?>assets/js/beep.wav" autoplay="false"></audio>

<div class="modal fade" id="Pos_addCustomer" role="dialog">
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
                    <p id="statusMsg"></p>
                    <input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">
                    <input type="hidden" name="location" id="location" value="<?php if($this->aauth->get_user()->loc != 0){echo $this->aauth->get_user()->loc;}else{ echo 0;}?>">
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
<div class="modal fade" id="cardPay" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content ">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title"><?php echo $this->lang->line('Make Payment') ?></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span>
                    <span class="sr-only"><?php echo $this->lang->line('Close') ?></span>

            </div>

            <!-- Modal Body -->
            <div class="modal-body ">
                <p id="statusMsg"></p>
                <form role="form" id="card_data">

                    <div class="row">
                        <div class="col-6">
                            <label for="cardNumber"><?php echo $this->lang->line('Payment Gateways') ?></label>
                            <select class="form-control" name="gateway"><?php
                                $surcharge_t = false;
                                foreach ($gateway as $row) {
                                    $cid = $row['id'];
                                    $title = $row['name'];
                                    if ($row['surcharge'] > 0) {
                                        $surcharge_t = true;
                                        $fee = '(<span class="gate_total"></span>+' . amountFormat_s($row['surcharge']) . ' %)';
                                    } else {
                                        $fee = '';
                                    }
                                    echo "<option value='$cid'>$title $fee</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-4"><br><img class="img-responsive pull-right"
                                                    src="<?php echo assets_url('assets/images/accepted_c22e0.png') ?>">
                        </div>
                    </div>


                    <div class="row mt-1">
                        <div class="col">
                            <button class="btn btn-success btn-lg"
                                    type="submit"
                                    id="pos_card_pay"
                                    data-type="2"><i
                                        class="fa fa-credit-card"></i> <?php echo $this->lang->line('Paynow') ?>
                            </button>
                        </div>
                    </div>
                    <div class="form-group">

                        <?php if ($surcharge_t) echo '<br>' . $this->lang->line('Note: Payment Processing'); ?>

                    </div>
                    <div class="row" style="display:none;">
                        <div class="col-xs-12">
                            <p class="payment-errors"></p>
                        </div>
                    </div>

                    <input type="hidden" value="pos_invoices/action" id="pos_action-url">
                </form>

                <!-- shipping -->


            </div>
            <!-- Modal Footer -->


        </div>
    </div>
</div>
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

                    <div class="text-center"><h1 id="b_total"></h1></div>
                    <div class="row">


                        <div class="col-6">
                            <div class="card-title">
                                <label for="cardNumber"><?php echo $this->lang->line('Amount') ?></label>
                                <div class="input-group">
                                    <input
                                            type="text"
                                            class="form-control  text-bold-600 blue-grey"
                                            name="p_amount"
                                            placeholder="Amount" onkeypress="return isNumber(event)"
                                            id="p_amount" onkeyup="update_pay_pos()"
                                    />
                                    <span class="input-group-addon"><i
                                                class="icon icon-cash"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-title">
                                <label for="cardNumber"><?php echo $this->lang->line('Payment Method') ?></label>
                                <select class="form-control" name="p_method" id="p_method" onchange="getSelectValue();">
                                    <option value='Cash'><?php echo $this->lang->line('Cash') ?></option>
                                    <option value='Card Swipe'><?php echo $this->lang->line('Card Swipe') ?></option>
                                    <option value='Bank'><?php echo $this->lang->line('OnAccount') ?></option>
                                    <option value='Cash Card'><?php echo $this->lang->line('CashCard') ?></option>

                                </select></div>
                        </div>


                    </div>

                    <div class="row" id="paid-amount" >
                        <div class="col-12"  >
                            <div class="form-group  text-bold-600 red">
                                <label for="amount"><?php echo $this->lang->line('Paid Money') ?>
                                </label>
                                <input type="text" class="form-control green" name="amount" id="balance1"
                                       onkeypress="return isNumber(event)"
                                       onkeyup="myFunction()"
                                       value="0.00"
                                       required>
                            </div>
                        </div>
                        <div class="col-6" >
                            <div class="form-group text-bold-600 text-g" ><?php echo $this->lang->line('Residual') ?>
                                <h1  id="refunded"></h1>
                            </div>
                        </div>
                    </div>
                    <div class="row" id="paid-cash-card-amount" >
                        <div class="col-12"  >
                            <div class="form-group  text-bold-600 red">
                                <label for="amount_cash"><?php echo $this->lang->line('Paid Cash') ?>
                                </label>
                                <input type="text" class="form-control green" name="amount_cash" id="amount_cash"
                                       onkeypress="return isNumber(event)"
                                       onkeyup="cashCard()"
                                       value="0.00"
                                       required>
                            </div>
                            <div class="form-group  text-bold-600 red">
                                <label for="amount_card"><?php echo $this->lang->line('Paid Card') ?>
                                </label>
                                <input type="text" class="form-control green" name="amount_card" id="amount_card"
                                       value="0.00"
                                       required>
                            </div>
                        </div>

                    </div>

                    <div class="row">
                        <div class="col-12" style="margin: 0px 20px 20px 0px;font-size: 16px;">
                            <input type="checkbox" class="custom-control-input" name="ex_report" id="ex_report"  />
                            <label class="custom-control-label"
                                   for="ex_report"><?php echo $this->lang->line('Kitchen Report') ?></label>
                        </div>
                        <hr/>

                        <div class="col-12">
                            <!--<button class="btn btn-success btn-lg btn-block mb-1"-->
                            <!--        type="submit"-->
                            <!--        id="pos_basic_pay" data-type="4"><i-->
                            <!--            class="fa fa-arrow-circle-o-right"></i> <?php echo $this->lang->line('Paynow') ?>-->
                            <!--</button>-->
                            <button class="btn btn-info btn-lg btn-block"
                                    type="submit"
                                    id="pos_basic_print" data-type="4"><i
                                        class="fa fa-print"></i> <?php echo $this->lang->line('Paynow') ?>
                                + <?php echo $this->lang->line('Print') ?></button>
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
                            <input type="number" class="form-control green" id="r_cash"
                                   value="0.00"
                                   readonly>
                        </div>
                    </div>
                    <div class="col-5 col-md-5 pull-right">
                        <div class="form-group text-bold-600 blue">
                            <label for="b_change blue"><?php echo $this->lang->line('Card') ?></label>
                            <input
                                    type="number"
                                    class="form-control blue"
                                    id="r_card" value="0" readonly>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <div class="form-group  text-bold-600 indigo">
                            <label for="amount"><?php echo $this->lang->line('OnAccount') ?>
                            </label>
                            <input type="number" class="form-control indigo" id="r_bank"
                                   value="0.00"
                                   readonly>
                        </div>
                    </div>
                    <!--<div class="col-5 col-md-5 pull-right">-->
                    <!--    <div class="form-group text-bold-600 red">-->
                    <!--        <label for="b_change"><?php echo $this->lang->line('Change') ?>(-)</label>-->
                    <!--        <input-->
                    <!--                type="number"-->
                    <!--                class="form-control red"-->
                    <!--                id="r_change" value="0" readonly>-->
                    <!--    </div>-->
                    <!--</div>-->
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
<div id="shortkeyboard" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">

                <h4 class="modal-title">ShortCuts</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <td>Alt+X</td>
                        <td>Focus to products search</td>
                    </tr>
                    <tr>
                        <td>Alt+C</td>
                        <td>Focus to customer search</td>
                    </tr>

                    <tr>
                        <td>Alt+S (twice)</td>
                        <td>PayNow + Thermal Print</td>
                    </tr>
                    <tr>
                        <td>Alt+Z</td>
                        <td>Make Card Payment</td>
                    </tr>
                    <tr>
                        <td>Alt+Q</td>
                        <td>Select First product</td>
                    </tr>
                    <tr>
                        <td>Alt+N</td>
                        <td>Create New Invoice</td>
                    </tr>


                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script type="text/javascript">
    function getSelectValue()
    {
        var selectedValue = document.getElementById("p_method").value;
        if(selectedValue=='Cash')
        {
            document.getElementById("paid-amount").style.display = "block";

        }

        else{
            document.getElementById("paid-amount").style.display = "none";

        }
        if(selectedValue=='Cash Card')
        {
            document.getElementById("paid-cash-card-amount").style.display = "block";

        }
        else
        {
            document.getElementById("paid-cash-card-amount").style.display = "none";
        }

    }
    getSelectValue();
    myFunction();
    cashCard();
    // document.getElementById("balance1").addEventListener("change", myFunction);

    function myFunction() {
        var paidAmount = document.getElementById("balance1").value;
        var refunded = document.getElementById("refunded").value;
        var roundoff = parseFloat(accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal)).toFixed(two_fixed);
        var total= accounting.formatNumber(roundoff);
        $('#refunded').html(paidAmount-total);

    }
    function cashCard() {
        var cashAmount = document.getElementById("amount_cash").value;
        var cardAmount = document.getElementById("amount_card");
        var roundoff = parseFloat(accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal)).toFixed(two_fixed);
        var total= accounting.formatNumber(roundoff);
//   $("input:amount_card").val(cashAmount-total);
        $('#amount_card').val(total-cashAmount);

    }

    $.ajax({
        url: baseurl + 'search_products/v2_pos_search',
        dataType: 'html',
        method: 'POST',
        data: 'cid=' + $('#v2_categories').val() + '&wid=' + $('#v2_warehouses option:selected').val() + '&' + crsf_token + '=' + crsf_hash,
        success: function (data) {
            $('#pos_item').html(data);
        }
    });

    function update_register() {
        $.ajax({
            url: baseurl + 'register/status',
            dataType: 'json',
            data: crsf_token + '=' + crsf_hash,
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
        $('#card_total').val(accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal));
    });

    $(".possubmit3").on("click", function (e) {
        e.preventDefault();
        var roundoff = parseFloat(accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal)).toFixed(two_fixed);

        <?php
        $round_off = $this->custom->api_config(4);
        if ($round_off['other'] == 'PHP_ROUND_HALF_UP') {
            echo ' roundoff=Math.ceil(roundoff);';
        } elseif ($round_off['other'] == 'PHP_ROUND_HALF_DOWN') {
            echo ' roundoff=Math.floor(roundoff);';
        }
        ?>
        $('#b_total').html(' <?= $this->config->item('currency'); ?> ' + accounting.formatNumber(roundoff));
        $('#p_amount').val(accounting.formatNumber(roundoff));

    });

    function update_pay_pos() {
        var am_pos = accounting.unformat($('#p_amount').val(), accounting.settings.number.decimal);
        var ttl_pos = accounting.unformat($('#invoiceyoghtml').val(), accounting.settings.number.decimal);
        <?php
        $round_off = $this->custom->api_config(4);
        if ($round_off['other'] == 'PHP_ROUND_HALF_UP') {
            echo ' ttl_pos=Math.ceil(ttl_pos);';
        } elseif ($round_off['other'] == 'PHP_ROUND_HALF_DOWN') {
            echo ' ttl_pos=Math.floor(ttl_pos);';
        }
        ?>

        var due = parseFloat(ttl_pos - am_pos).toFixed(two_fixed);

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
        $("html, body").animate({scrollTop: $('body').offset().top - 100}, 1000);
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
        $("html, body").animate({scrollTop: $('body').offset().top - 100}, 1000);
        var o_data = $("#data_form").serialize() + '&p_amount=' + accounting.unformat($('#p_amount').val(), accounting.settings.number.decimal) + '&p_method=' + $("#p_method option:selected").val() + '&type=' + $(this).attr('data-type') + '&account=' + $("#p_account option:selected").val();
        var action_url = $('#action-url').val();
        addObject(o_data, action_url);
        setTimeout(
            function () {
                update_register();
            }, 3000);
    });

    $('#pos_basic_print').on("click", function (e) {
        e.preventDefault();
        $('#basicPay').modal('toggle');
        $("#notify .message").html("<strong>Processing</strong>: .....");
        $("#notify").removeClass("alert-danger").addClass("alert-primary").fadeIn();
        $("html, body").animate({scrollTop: $('body').offset().top - 100}, 1000);
        var o_data = $("#data_form").serialize() + '&p_amount=' + accounting.unformat($('#p_amount').val(), accounting.settings.number.decimal) + '&p_method=' + $("#p_method option:selected").val()  + '&amount_cash=' + $('#amount_cash').val() + '&amount_card=' + $('#amount_card').val()  + '&type=' + $(this).attr('data-type') + '&printnow=1'+ '&account=' + $("#p_account option:selected").val() ;
        var action_url = $('#action-url').val();
        addObject2(o_data, action_url);
        setTimeout(
            function () {
                update_register();
            }, 3000);
    });

    function addObject2(action, action_url) {
        var errorNum = farmCheck();
        var $btn;
        if ($("#notify").length == 0) {
            $("#c_body").html('<div id="notify" class="alert" style="display:none;"><a href="#" class="close" data-dismiss="alert">&times;</a><div class="message"></div></div>');
        }
        if (errorNum > 0) {
            $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
            $("#notify .message").html("<strong>Error</strong>: It appears you have forgotten to complete something!");
            $("html, body").scrollTop($("body").offset().top);
        } else {
            jQuery.ajax({
                url: baseurl + action_url,
                type: 'POST',
                data: action + '&' + crsf_token + '=' + crsf_hash,
                dataType: 'json',
                success: function (data) {
                    if (data.status == "Success") {
                        var url = baseurl + "pos_invoices/thermal_pdf?id="+data.invoice_id;
                        if ($('#ex_report').is(":checked"))
                        {
                            url += "&report=1";
                        }else{
                            url += "&report=0";
                        }
                        printJS({
                            printable: url,
                            type: 'pdf',
                            onPrintDialogClose: () => window.location.replace(baseurl + "pos_invoices/create"),
                            onError: err => window.location.replace(baseurl + "pos_invoices/thermal_pdf?id="+data.invoice_id) // doesn't work
                        });

                       /* printJS({
                            printable: url,
                            type: 'pdf',
                            onLoadingEnd: () => setTimeout(function () {window.location.replace(baseurl + "pos_invoices/create");}, 3000),
                            onError: err => window.location.replace(baseurl + "pos_invoices/thermal_pdf?id="+data.invoice_id) // doesn't work
                        });*/

                        /*printJS(baseurl + "pos_invoices/thermal_pdf?id="+data.invoice_id);

                        setTimeout(
                        function () {
                            window.location.replace(baseurl + "pos_invoices/create");
                        }, 3000);*/

                        // window.location.replace(baseurl + "pos_invoices/thermal_pdf?id="+data.invoice_id);
                    }else {
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                        $("html, body").scrollTop($("body").offset().top);
                    }
                },
                error: function (data) {
                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                    $("#notify").removeClass("alert-success").addClass("alert-warning").fadeIn();
                    $("html, body").scrollTop($("body").offset().top);
                }
            });
        }
    }
</script>

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
            data: $('#payment-form').serialize() + '&' + crsf_token + '=' + crsf_hash,
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


    $('#v2_categories').change(function () {
        var whr = $('#v2_warehouses option:selected').val();
        var cat = $('#v2_categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/v2_pos_search',
            data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {

                $("#pos_item").html(data);

            }
        });
    });
    $('#v2_warehouses').change(function () {
        var whr = $('#v2_warehouses option:selected').val();
        var cat = $('#v2_categories option:selected').val();
        $.ajax({
            type: "POST",
            url: baseurl + 'search_products/v2_pos_search',
            data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
            beforeSend: function () {
                $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
            },
            success: function (data) {

                $("#pos_item").html(data);

            }
        });
    })
    $(document).ready(function () {

        Mousetrap.bind('alt+x', function () {
            $('#v2_search_bar').focus();
        });
        Mousetrap.bind('alt+c', function () {
            $('#pos-customer-box').focus();
        });

        Mousetrap.bind('alt+z', function () {
            $('.possubmit2').click();
        });
        Mousetrap.bind('alt+n', function () {
            window.location.href = "<?=base_url('pos_invoices/create') ?>";
        });
        Mousetrap.bind('alt+q', function () {
            $('#posp0').click();
            $('#v2_search_bar').val('');
        });
        Mousetrap.bind('alt+s', function () {
            if ($('#basicPay').hasClass('show')) {
                $('#pos_basic_print').click();
            } else {
                $('.possubmit3').click();
            }

        });



        function resetProducts(){
            $('#v22_search_bar').val('');
            $('#v22_search_bar').focus();
            var whr = $('#v2_warehouses option:selected').val();
            var cat = $('#v2_categories option:selected').val();
            $.ajax({
                type: "POST",
                url: baseurl + 'search_products/v2_pos_search',
                data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
                beforeSend: function () {
                    $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                },
                success: function (data) {
                    $("#pos_item").html(data);
                }
            });
        }


        $('#v22_search_bar').keyup(function () {

            var whr = $('#v2_warehouses option:selected').val();
            var cat = $('#v2_categories option:selected').val();
            var pname = $('#v22_search_bar').val();
            if(!$.isNumeric(pname)){
                $.ajax({
                    type: "POST",
                    url: baseurl + 'search_products/v2_pos_search',
                    data: 'name=' + $(this).val() + '&wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
                    beforeSend: function () {

                        $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                    },
                    success: function (data) {

                        $("#pos_item").html(data);

                    }
                });
            }


        });

        $('#v22_search_bar').keypress(function (event) {
            var pname = $('#v22_search_bar').val();
            if($.isNumeric(pname)){
                if(pname.length >= 5 && event.keyCode == 13){
                    var whr = $('#v2_warehouses option:selected').val();
                    var cat = $('#v2_categories option:selected').val();
                    $.ajax({
                        type: "POST",
                        url: baseurl + 'search_products/v2_pos_search',
                        data: 'name=' + pname + '&wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
                        beforeSend: function () {

                            $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                        },
                        success: function (data) {

                            $("#pos_item").html(data);
                            $('#posp0').click();
                            resetProducts();

                        }
                    });
                }

            }
            else{
                if (event.keyCode == 13) {
                    setTimeout(
                        function () {
                            $('#posp0').click();
                            $('#v22_search_bar').val('');
                            $('#v22_search_bar').focus();
                            var whr = $('#v2_warehouses option:selected').val();
                            var cat = $('#v2_categories option:selected').val();
                            $.ajax({
                                type: "POST",
                                url: baseurl + 'search_products/v2_pos_search',
                                data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
                                beforeSend: function () {
                                    $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                                },
                                success: function (data) {
                                    $("#pos_item").html(data);
                                }
                            });

                        }, 2000);
                }
            }

        });



        $('#v2_search_bar').keypress(function (event) {


            var pname = $('#v2_search_bar').val();
            if($.isNumeric(pname)){
                if(pname.length >= 5 && event.keyCode == 13){
                    setTimeout(
                        function () {
                            $('#posp0').click();
                            $('#v2_search_bar').val('');
                            $('#v2_search_bar').focus();
                            var whr = $('#v2_warehouses option:selected').val();
                            var cat = $('#v2_categories option:selected').val();
                            $.ajax({
                                type: "POST",
                                url: baseurl + 'search_products/v2_pos_search',
                                data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
                                beforeSend: function () {
                                    $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                                },
                                success: function (data) {
                                    $("#pos_item").html(data);
                                }
                            });
                        }, 2000);
                }

            }else{
                if (event.keyCode == 13) {
                    setTimeout(
                        function () {
                            $('#posp0').click();
                            $('#v2_search_bar').val('');
                            $('#v2_search_bar').focus();
                            var whr = $('#v2_warehouses option:selected').val();
                            var cat = $('#v2_categories option:selected').val();
                            $.ajax({
                                type: "POST",
                                url: baseurl + 'search_products/v2_pos_search',
                                data: 'wid=' + whr + '&cid=' + cat + '&' + crsf_token + '=' + crsf_hash,
                                beforeSend: function () {
                                    $("#customer-box").css("background", "#FFF url(" + baseurl + "assets/custom/load-ring.gif) no-repeat 165px");
                                },
                                success: function (data) {
                                    $("#pos_item").html(data);
                                }
                            });
                        }, 2000);
                }
            }

        });
    });
</script>