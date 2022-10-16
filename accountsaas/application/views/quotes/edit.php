<div class="content-body">
<div class="card">
<div class="card-content">
<div id="notify" class="alert alert-success" style="display:none;">
<a href="#" class="close" data-dismiss="alert">&times;</a>

<div class="message"></div>
</div>
<div class="card-body">
<form method="post" id="data_form">
<div class="row">
    <div class="col-sm-6 cmp-pnl">
        <div id="customerpanel" class="inner-cmp-pnl">
            <div class="form-group row">
                <div class="fcol-sm-12">
                    <h3 class="title">
                        Bill To <a href='#' class="btn btn-primary btn-sm rounded"
                                   data-toggle="modal"
                                   data-target="#addCustomer">
                            Add Client
                        </a>
                </div>
            </div>
            <div class="form-group row">
                <div class="frmSearch col-sm-12"><label for="cst" class="caption">Search
                        Client</label>
                    <input type="text" class="form-control" name="cst" id="customer-box"
                           placeholder="Enter Customer Name or Mobile Number to search"
                           autocomplete="off"/>
                    <div id="customer-box-result"></div>
                </div>
            </div>
            <div id="customer">
                <div class="clientinfo">
                    Client Details
                    <hr>
                    <?php echo '  <input type="hidden" name="customer_id" id="customer_id" value="' . $invoice['csd'] . '">
            <div id="customer_name"><strong>' . $invoice['name'] . '</strong></div>
        </div>
        <div class="clientinfo">

            <div id="customer_address1"><strong>' . $invoice['address'] . '<br>' . $invoice['city'] . ',' . $invoice['country'] . '</strong></div>
        </div>

        <div class="clientinfo">

            <div type="text" id="customer_phone">Phone: <strong>' . $invoice['phone'] . '</strong><br>Email: <strong>' . $invoice['email'] . '</strong></div>
        </div>'; ?>
                    <hr>
                    <div id="customer_pass"></div><?php echo $this->lang->line('Warehouse') ?>
                    <select
                            id="s_warehouses"
                            class="selectpicker form-control">
                        <?php echo $this->common->default_warehouse();
                        echo '<option value="0">' . $this->lang->line('All') ?></option><?php foreach ($warehouse as $row) {
                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                        } ?>

                    </select>
                </div>


            </div>
        </div>
        <div class="col-sm-6 cmp-pnl">
            <div class="inner-cmp-pnl">


                <div class="form-group row">

                    <div class="col-sm-12"><h3 class="title">Quote Properties</h3></div>

                </div>
                <div class="form-group row">
                    <div class="col-sm-6"><label for="invocieno" class="caption">Quote
                            Number</label>

                        <div class="input-group">
                            <div class="input-group-addon"><span class="icon-file-text-o"
                                                                 aria-hidden="true"></span></div>
                            <input type="text" class="form-control" placeholder="Quote #"
                                   name="invocieno"
                                   value="<?php echo $invoice['tid']; ?>" readonly>
                        </div>
                    </div>
                    <div class="col-sm-6"><label for="invocieno" class="caption">Reference</label>

                        <div class="input-group">
                            <div class="input-group-addon"><span class="icon-bookmark-o"
                                                                 aria-hidden="true"></span></div>
                            <input type="text" class="form-control" placeholder="Reference #"
                                   name="refer"
                                   value="<?php echo $invoice['refer'] ?>">
                        </div>
                    </div>
                </div>
                <div class="form-group row">

                    <div class="col-sm-6"><label for="invociedate" class="caption">Quote
                            Date</label>

                        <div class="input-group">
                            <div class="input-group-addon"><span class="icon-calendar4"
                                                                 aria-hidden="true"></span></div>
                            <input type="text" class="form-control required editdate"
                                   placeholder="Billing Date" name="invoicedate"
                                   autocomplete="false"
                                   value="<?php echo $invoice['invoicedate'] ?>"> <input
                                    type="hidden"
                                    name="iid"
                                    value="<?php echo $invoice['iid']; ?>">

                                     <input
                                    type="hidden"
                                    name="ref"
                                    value="<?php echo $ref; ?>">
                        </div>
                    </div>
                    <div class="col-sm-6"><label for="invocieduedate" class="caption">Quote
                            Validity</label>

                        <div class="input-group">
                            <div class="input-group-addon"><span class="icon-calendar-o"
                                                                 aria-hidden="true"></span></div>
                            <input type="text" class="form-control required editdate"
                                   name="invocieduedate"
                                   placeholder="Validity Date" autocomplete="false"
                                   value="<?php echo $invoice['invoiceduedate'] ?>">
                        </div>
                    </div>
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="taxformat" class="caption">Tax</label>
                        <select class="form-control round" onchange="changeTaxFormat(this.value)"
                                id="taxformat">

                            <?php echo $taxlist; ?>
                        </select>
                    </div>
                    <div class="col-sm-6">

                        <div class="form-group">
                            <label for="discountFormat" class="caption">Discount</label>
                            <select class="form-control" onchange="changeDiscountFormat(this.value)"
                                    id="discountFormat">
                                <?php echo '<option value="' . $invoice['format_discount'] . '">' . $this->lang->line('Do not change') . '</option>'; ?>
                                <?php echo $this->common->disclist() ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-sm-12">
                        <label for="toAddInfo" class="caption">Quote Note</label>
                        <textarea class="form-control" name="notes"
                                  rows="2"><?php echo $invoice['notes'] ?></textarea></div>
                </div>

            </div>
        </div>

    </div>

    <div class="form-group row">
        <div class="col-sm-12">
            <label for="toAddInfo" class="caption">Proposal Message</label>
            <textarea class="summernote" name="propos" id="contents"
                      rows="2"><?php echo $invoice['proposal'] ?></textarea></div>
    </div>

    <div id="saman-row">
        <table class="table-responsive tfr my_stripe">
            <thead>

            <tr class="item_header bg-gradient-directional-blue white">
                <th width="30%" class="text-center">Item Name</th>
                <th width="8%" class="text-center">Quantity</th>
                <th width="10%" class="text-center">Rate</th>
                <th width="10%" class="text-center">Tax(%)</th>
                <th width="10%" class="text-center">Tax</th>
                <th width="7%" class="text-center">Discount</th>
                <th width="10%" class="text-center">
                    Amount(<?php echo $this->config->item('currency'); ?>)
                </th>
                <th width="5%" class="text-center">Action</th>
            </tr>
            </thead>
            <tbody>
            <?php $i = 0;
            foreach ($products as $row) {
                echo '<tr >
    <td><input type="text" class="form-control" name="product_name[]" placeholder="Enter Product name or Code"  value="' . $row['product'] . '">
    </td>
    <td><input type="text" class="form-control req amnt" name="product_qty[]" id="amount-' . $i . '"
               onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
               autocomplete="off" value="' . amountFormat_general($row['qty']) . '" ><input type="hidden" name="old_product_qty[]" value="' . amountFormat_general($row['qty']) . '" ></td>
    <td><input type="text" class="form-control req prc" name="product_price[]" id="price-' . $i . '"
               onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
               autocomplete="off" value="' . amountExchange_s($row['price'], $invoice['multi'], $this->aauth->get_user()->loc) . '"></td>
    <td> <input type="text" class="form-control vat" name="product_tax[]" id="vat-' . $i . '"
                onkeypress="return isNumber(event)" onkeyup="rowTotal(' . $i . '), billUpyog()"
                autocomplete="off"  value="' . amountFormat_general($row['tax']) . '"></td>
    <td class="text-center" id="texttaxa-' . $i . '">' . amountExchange_s($row['totaltax'], $invoice['multi'], $this->aauth->get_user()->loc) . '</td>
    <td><input type="text" class="form-control discount" name="product_discount[]"
               onkeypress="return isNumber(event)" id="discount-' . $i . '"
               onkeyup="rowTotal(' . $i . '), billUpyog()" autocomplete="off"  value="' . amountFormat_general($row['discount']) . '"></td>
    <td><span class="currenty">' . $this->config->item('currency') . '</span>
        <strong><span class="ttlText" id="result-' . $i . '">' . amountExchange_s($row['subtotal'], $invoice['multi'], $this->aauth->get_user()->loc) . '</span></strong></td>
    <td class="text-center">
<button type="button" data-rowid="' . $i . '" class="btn btn-danger removeProd" title="Remove"> <i class="fa fa-minus-square"></i> </button>
    </td>
    <input type="hidden" name="taxa[]" id="taxa-' . $i . '" value="' . amountExchange_s($row['totaltax'], $invoice['multi'], $this->aauth->get_user()->loc) . '">
    <input type="hidden" name="disca[]" id="disca-' . $i . '" value="' . amountExchange_s($row['totaldiscount'], $invoice['multi'], $this->aauth->get_user()->loc) . '">
    <input type="hidden" class="ttInput" name="product_subtotal[]" id="total-' . $i . '" value="' . amountExchange_s($row['subtotal'], $invoice['multi'], $this->aauth->get_user()->loc) . '">
    <input type="hidden" class="pdIn" name="pid[]" id="pid-' . $i . '" value="' . $row['pid'] . '">
     <input type="hidden" name="unit[]" id="unit-' . $i . '" value="' . $row['unit'] . '">  <input type="hidden" name="hsn[]" id="unit-' . $i . '" value="' . $row['code'] . '">
</tr><tr class="desc_p"><td colspan="8"><textarea id="dpid-' . $i . '" class="form-control" name="product_description[]" placeholder="Enter Product description" autocomplete="off">' . $row['product_des'] . '</textarea><br></td></tr>';
                $i++;
            } ?>
            <tr class="last-item-row sub_c">
                <td class="add-row">
                    <button type="button" class="btn btn-success" id="addproduct">
                        <i class="fa fa-plus-square"></i> Add Row
                    </button>
                </td>
                <td colspan="7"></td>
            </tr>

            <tr class="sub_c" style="display: table-row;">
                <td colspan="6" align="right"><strong>Total Tax</strong></td>
                <td align="left" colspan="2"><span
                            class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                    <span id="taxr"
                          class="lightMode"><?php echo amountExchange_s($invoice['tax'], $invoice['multi'], $this->aauth->get_user()->loc) ?></span>
                </td>
            </tr>
            <tr class="sub_c" style="display: table-row;">
                <td colspan="6" align="right"><strong>Total Discount</strong></td>
                <td align="left" colspan="2"><span
                            class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>
                    <span id="discs"
                          class="lightMode"><?php echo amountExchange_s($invoice['discount'], $invoice['multi'], $this->aauth->get_user()->loc) ?></span>
                </td>
            </tr>

            <tr class="sub_c" style="display: table-row;">
                <td colspan="6" align="right"><input type="hidden"
                                                     value="<?php echo amountExchange_s($invoice['subtotal'], $invoice['multi'], $this->aauth->get_user()->loc) ?>"
                                                     id="subttlform"
                                                     name="subtotal"><strong>Shipping</strong></td>
                <td align="left" colspan="2"><input type="text" class="form-control shipVal"
                                                    onkeypress="return isNumber(event)"
                                                    placeholder="Value"
                                                    name="shipping" autocomplete="off"
                                                    onkeyup="billUpyog()"
                                                    value="<?php if ($invoice['ship_tax_type'] == 'excl') {
                                                        $invoice['shipping'] = $invoice['shipping'] - $invoice['ship_tax'];
                                                    }
                                                    echo amountExchange_s($invoice['shipping'], $invoice['multi'], $this->aauth->get_user()->loc); ?>">( <?= $this->lang->line('Tax') ?> <?= $this->config->item('currency'); ?>
                    <span id="ship_final"><?= amountExchange_s($invoice['ship_tax'], $invoice['multi'], $this->aauth->get_user()->loc) ?> </span>
                    )
                </td>
            </tr>

            <tr class="sub_c" style="display: table-row;">
                <td colspan="2"><?php if ($exchange['active'] == 1){
                    echo $this->lang->line('Payment Currency client') . ' <small>' . $this->lang->line('based on live market') ?></small>
                    <select name="mcurrency"
                            class="selectpicker form-control">

                        <?php
                        echo '<option value="' . $invoice['multi'] . '">Do not change</option><option value="0">None</option>';
                        foreach ($currency as $row) {

                            echo '<option value="' . $row['id'] . '">' . $row['symbol'] . ' (' . $row['code'] . ')</option>';
                        } ?>

                    </select><?php } ?></td>
                <td colspan="4" align="right"><strong><?php echo $this->lang->line('Grand Total') ?>
                        (<span
                                class="currenty lightMode"><?php echo $this->config->item('currency'); ?></span>)</strong>
                </td>
                <td align="left" colspan="2"><input type="text" name="total" class="form-control"
                                                    id="invoiceyoghtml"
                                                    value="<?= amountExchange_s($invoice['total'], $invoice['multi'], $this->aauth->get_user()->loc); ?>"
                                                    readonly="">

                </td>
            </tr>
            <tr class="sub_c" style="display: table-row;">
                <td colspan="2">Payment Terms <select name="pterms"
                                                      class="selectpicker form-control"><?php echo '<option value="' . $invoice['termid'] . '">*' . $invoice['termtit'] . '</option>';
                        foreach ($terms as $row) {
                            echo '<option value="' . $row['id'] . '">' . $row['title'] . '</option>';
                        } ?>


                    </select>
                    <br>
                    <?php echo $this->lang->line('Custom Payment Terms') ?> 
                    <br>
                    <textarea class="summernote" name="text_terms"><?php echo $invoice['text_terms']; ?></textarea>
                    </td>
                <td align="right" colspan="6"><input type="submit" class="btn btn-success sub-btn"
                                                     value="Update Quote"
                                                     id="submit-data"
                                                     data-loading-text="Updating...">
                </td>
            </tr>


            </tbody>
        </table>
    </div>

    <input type="hidden" value="quote/editaction" id="action-url">
    <input type="hidden" value="search" id="billtype">
    <input type="hidden" value="<?php echo $i; ?>" name="counter" id="ganak">
    <input type="hidden" value="<?php echo $this->config->item('currency'); ?>" name="currency">

    <input type="hidden" value="<?= $this->common->taxhandle_edit($invoice['taxstatus']) ?>"
           name="taxformat" id="tax_format">
    <input type="hidden" value="<?= $invoice['format_discount']; ?>" name="discountFormat"
           id="discount_format">
    <input type="hidden" value="<?= $invoice['taxstatus']; ?>" name="tax_handle" id="tax_status">
    <input type="hidden" value="yes" name="applyDiscount" id="discount_handle">

    <input type="hidden" value="<?php
    $tt = 0;
    if ($invoice['ship_tax_type'] == 'incl'){ if(isset($invoice['shipping']) and !isset($invoice['ship_tax'])){ $tt = @number_format(($invoice['shipping'] - $invoice['ship_tax']) / $invoice['shipping'], 2, '.', '');}else{$tt=0;} }
    if(isset($invoice['shipping']) and !isset($invoice['ship_tax'])){
    echo amountFormat_general(number_format((($invoice['ship_tax'] / $invoice['shipping']) * 100) + $tt, 3, '.', '')); 
    }else{
        echo 0;
    }
    
    ?>"
           name="shipRate" id="ship_rate">
    <input type="hidden" value="<?= $invoice['ship_tax_type']; ?>" name="ship_taxtype"
           id="ship_taxtype">
    <input type="hidden" value="<?= amountFormat_general($invoice['ship_tax']); ?>" name="ship_tax"
           id="ship_tax">


</form>
</div>

</div>
</div>
</div>

<div class="modal fade" id="addCustomer" role="dialog">
<div class="modal-dialog">
<div class="modal-content">
<form method="post" id="product_action" class="form-horizontal">
<!-- Modal Header -->
<div class="modal-header">

<h4 class="modal-title" id="myModalLabel">Add Customer</h4>
<button type="button" class="close" data-dismiss="modal">
    <span aria-hidden="true">&times;</span>
    <span class="sr-only">Close</span>
</button>
</div>

<!-- Modal Body -->
<div class="modal-body">
<p id="statusMsg"></p><input type="hidden" name="mcustomer_id" id="mcustomer_id" value="0">


<div class="form-group row">

    <label class="col-sm-2 col-form-label" for="name">Name</label>

    <div class="col-sm-10">
        <input type="text" placeholder="Name"
               class="form-control margin-bottom" id="mcustomer_name" name="name" required>
    </div>
</div>

<div class="form-group row">

    <label class="col-sm-2 col-form-label" for="phone">Phone</label>

    <div class="col-sm-10">
        <input type="text" placeholder="Phone"
               class="form-control margin-bottom" name="phone" id="mcustomer_phone">
    </div>
</div>
<div class="form-group row">

    <label class="col-sm-2 col-form-label" for="email">Email</label>

    <div class="col-sm-10">
        <input type="email" placeholder="Email"
               class="form-control margin-bottom crequired" name="email" id="mcustomer_email">
    </div>
</div>
<div class="form-group row">

    <label class="col-sm-2 col-form-label" for="address">Address</label>

    <div class="col-sm-10">
        <input type="text" placeholder="Address"
               class="form-control margin-bottom " name="address" id="mcustomer_address1">
    </div>
</div>
<div class="form-group row">


    <div class="col-sm-6">
        <input type="text" placeholder="City"
               class="form-control margin-bottom" name="city" id="mcustomer_city">
    </div>
    <div class="col-sm-6">
        <input type="text" placeholder="Region"
               class="form-control margin-bottom" name="region">
    </div>

</div>

<div class="form-group row">


    <div class="col-sm-6">
        <input type="text" placeholder="Country"
               class="form-control margin-bottom" name="country" id="mcustomer_country">
    </div>
    <div class="col-sm-6">
        <input type="text" placeholder="PostBox"
               class="form-control margin-bottom" name="postbox">
    </div>
</div>

<div class="form-group row">

    <label class="col-sm-2 col-form-label" for="customergroup">Group</label>

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

<!-- Modal Footer -->
<div class="modal-footer">
<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
<input type="submit" id="mclient_add" class="btn btn-primary submitBtn" value="ADD"/>
</div>
</form>
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
});

</script>
<script type="text/javascript"> $('.editdate').datepicker({
autoHide: true,
format: '<?php echo $this->config->item('dformat2'); ?>'
});</script>