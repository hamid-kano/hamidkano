<section class="card">
    <div class="card-header">
        <h4 class="card-title  text-center"><?php echo $this->lang->line('Secure Checkout Page') . ' (' . $this->lang->line('Invoice') ?>
            #<?php echo $invoice['tid'] ?>)</h4>
    </div>
    <div class="card-body">
        <?php
        $attributes = array('class' => 'row justify-content-md-center', 'id' => 'login_form');
        echo form_open('billing/gateway_process', $attributes);
        ?>

        <?php echo '<input type="hidden" class="form-control" name="id" value="' . $invoice['iid'] . '"/><input type="hidden" class="form-control" name="itype" value="' . $itype . '"/>
                <input type="hidden" class="form-control" name="token" value="' . $token . '"/>'; ?>
        <div class="col-md-6">
            <div class="form-group text-center">
                <h5><?php
                    $csrf = array(
                        'name' => $this->security->get_csrf_token_name(),
                        'hash' => $this->security->get_csrf_hash()
                    );


                    $rming = $invoice['total'] - $invoice['pamnt'];
                    if ($itype == 'rinv' && $invoice['status'] == 'due') {
                        $rming = $invoice['total'];
                    }
                    $surcharge_t = false;
                    $row = $gateway;
                    $cid = $row['id'];
                    $title = $row['name'];
                    if ($row['surcharge'] > 0) {
                        $surcharge_t = true;
                        $fee = '( ' . amountExchange($rming, $invoice['multi'], $invoice['loc']) . '+' . amountFormat_s($row['surcharge']) . ' %)';
                    } else {
                        $fee = '';
                    }
                    echo $title . ' ' . $fee ?></h5><img class="bg-white round mt-1"
                                                         style="max-width:30rem;max-height:6rem"
                                                         src="<?= base_url('assets/gateway_logo/' . $gid . '.png') ?>">
                <input type="hidden" class="form-control" name="gateway" value="<?= $cid ?>"><input type="hidden"
                                                                                                    name="<?= $csrf['name']; ?>"
                                                                                                    value="<?= $csrf['hash']; ?>"/>
            </div>
            <div class="form-group">
                <label for="cardNumber"> <?php echo $this->lang->line('Invoice') ?>
                    #<?php echo $invoice['tid'] ?> <?php echo $this->lang->line('Total Amount') ?></label>
                <input name="total_amount"
                       value="<?php echo amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) ?>"
                       type="text"
                       class="form-control"


                       readonly/>

            </div>
            <div class="form-group">
                <label for="cardNumber"><?php echo $this->lang->line('Due Amount') ?></label>
                <input name="total_amount"
                       value="<?php
                       echo amountExchange($rming, $invoice['multi'], $invoice['loc']); ?>"
                       type="text"
                       class="form-control"
                       readonly/>
            </div>
            <div class="row">
                <div class="col">
                    <div class="form-group">
                        <label for="amount"><?php echo $this->lang->line('Amount') ?>
                        </label>
                        <input type="number" class="form-control" name="amount"
                               value="<?php if ($rming > 0) echo numberClean(amountExchange_s($rming, $invoice['multi'], $invoice['loc'])); else echo '0.00'; ?>"
                               required/>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <button class="btn btn-success btn-lg btn-block"
                            type="submit"><?php echo $this->lang->line('Paynow') ?></button>
                </div>
            </div>
            <div class="form-group">

                <?php if ($surcharge_t) echo '<br>' . $this->lang->line('Note: Payment Processing'); ?>

            </div>
            <div class="row" style="display:none;">
                <div class="col">
                    <p class="payment-errors"></p>
                </div>
            </div>
        </div>
        </form>
    </div>
</section>