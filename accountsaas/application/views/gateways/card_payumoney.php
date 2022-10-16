<!-- If you're using Stripe for payments -->
<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<div class="app-content content container-fluid">
    <div class="content-wrapper">
        <div id="notify" class="alert alert-success" style="display:none;">
            <a href="#" class="close" data-dismiss="alert">&times;</a>

            <div class="message"></div>
        </div>
        <section class="card">
            <div class="card-header">
                <h4 class="card-title"><?php echo $this->lang->line('Secure Checkout Page') . ' (' . $this->lang->line('Invoice') ?>
                    #<?php echo $invoice['tid'] ?>)</h4>
            </div>
            <div class="card-body m-2">
                <div class="row">

                    <?php echo '<input type="hidden" class="form-control" name="id" value="' . $invoice['iid'] . '"/><input type="hidden" class="form-control" name="itype" value="' . $itype . '"/>
                <input type="hidden" class="form-control" name="token" value="' . $token . '"/>'; ?>
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col">
                                <div class="form-group text-xs-center">
                                    <h5><?php

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
                                        $surcharge = ($rming * $gateway['surcharge']) / 100;
                                        $rming = $rming + $surcharge;

                                        echo $title . ' ' . $fee;


                                        $MERCHANT_KEY = $gateway['key1'];
                                        $SALT = $gateway['key2'];
                                        // Merchant Key and Salt as provided by Payu.

                                        $PAYU_BASE_URL = "https://sandboxsecure.payu.in";        // For Sandbox Mode
                                        //$PAYU_BASE_URL = "https://secure.payu.in";			// For Production Mode

                                        $action = '';

                                        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
                                        $hash = '';
                                        if ($rming < 0) $rming = '0.00';

                                        $posted = array('key' => $MERCHANT_KEY, 'hash' => $hash, 'txnid' => $txnid, 'amount' => $rming, 'firstname' => $invoice['name'], 'email' => $invoice['email'], 'phone' => $invoice['phone'], 'productinfo' => 'Payment for invoice ' . $invoice['tid'],
                                            'surl' => base_url() . 'billing/secureprocess?inv=' . $invoice['iid'] . '&g=' . $cid,

                                            'furl' => base_url() . 'billing/secureprocess?inv=' . $invoice['iid'] . '&g=' . $cid,

                                            'curl' => base_url() . 'billing//card?id=' . $invoice['iid'] . '&itype=inv&token=' . $token,

                                            'service_provider' => 'payu_paisa', $this->security->get_csrf_token_name() => $this->security->get_csrf_hash());

                                        $formError = 0;


                                        // Hash Sequence
                                        $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
                                        if (empty($posted['hash']) && sizeof($posted) > 0) {
                                            if (
                                                empty($posted['key'])
                                                || empty($posted['txnid'])
                                                || empty($posted['amount'])
                                                || empty($posted['firstname'])
                                                || empty($posted['email'])
                                                || empty($posted['phone'])
                                                || empty($posted['productinfo'])
                                                || empty($posted['surl'])
                                                || empty($posted['furl'])
                                                || empty($posted['service_provider'])
                                            ) {
                                                $formError = 1;
                                            } else {
                                                //$posted['productinfo'] = json_encode(json_decode('[{"name":"tutionfee","description":"","value":"500","isRequired":"false"},{"name":"developmentfee","description":"monthly tution fee","value":"1500","isRequired":"false"}]'));
                                                $hashVarsSeq = explode('|', $hashSequence);
                                                $hash_string = '';
                                                foreach ($hashVarsSeq as $hash_var) {
                                                    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                                                    $hash_string .= '|';
                                                }

                                                $hash_string .= $SALT;


                                                $hash = strtolower(hash('sha512', $hash_string));
                                                $action = $PAYU_BASE_URL . '/_payment';
                                            }
                                        } elseif (!empty($posted['hash'])) {
                                            $hash = $posted['hash'];
                                            $action = $PAYU_BASE_URL . '/_payment';
                                        }

                                        ?></h5>
                                    <script>
                                        var hash = '<?php echo $hash ?>';

                                        function submitPayuForm() {
                                            if (hash == '') {
                                                return;
                                            }
                                            var payuForm = document.forms.payuForm;
                                            payuForm.submit();
                                        }
                                    </script>
                                    <img class="bg-white round mt-1" style="max-width:30rem;max-height:10rem"
                                         src="<?= base_url('assets/gateway_logo/' . $gid . '.png') ?>">
                                    <input type="hidden" class="form-control" name="gateway" value="<?= $cid ?>">

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
                                    <label for="cardNumber"><?php echo $this->lang->line('Total Amount') ?> &
                                        Fee</label>
                                    <input name="total_amount"
                                           value="<?php
                                           echo amountExchange($rming, $invoice['multi'], $invoice['loc']); ?>"
                                           type="text"
                                           class="form-control"


                                           readonly/>

                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 credit-card-box">


                        <section onload="submitPayuForm()">


                            <?php if ($formError) {
                                ?>

                                <span style="color:red">There has been an error or invoice is already paid.</span>
                                <br/>
                                <br/>
                            <?php } ?>
                            <form action="<?php echo $action; ?>" method="post" name="payuForm">
                                <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>"/>
                                <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
                                <input type="hidden" name="txnid" value="<?php echo $txnid ?>"/>
                                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
                                       value="<?= $this->security->get_csrf_hash(); ?>"/>
                                <input type="hidden" name="amount"
                                       value="<?php if ($rming > 0) echo $rming; else echo '0.00'; ?>"/>
                                <input type="hidden" name="firstname" id="firstname" value="<?= $invoice['name'] ?>"/>
                                <input type="hidden" name="email" id="email" value="<?= $invoice['email'] ?>"/>
                                <input type="hidden" name="productinfo"
                                       value="Payment for invoice <?= $invoice['tid'] ?>">
                                <input type="hidden" name="surl"
                                       value="<?= base_url() . 'billing/secureprocess?inv=' . $invoice['iid'] . '&g=' . $cid ?>"/>
                                <input type="hidden" name="furl"
                                       value="<?= base_url() . 'billing/secureprocess?inv=' . $invoice['iid'] . '&g=' . $cid ?>"/>
                                <input type="hidden" name="service_provider" value="payu_paisa" size="64"/>
                                <input type="hidden" name="curl"
                                       value="<?= base_url() . 'billing//card?id=' . $invoice['iid'] . '&itype=inv&token=' . $token ?>"/>

                                <?php if ($hash) { ?>
                                    <input type="submit" value="Pay Now" class="btn btn-lg btn-green"/>
                                <?php } ?>

                            </form>
                        </section>


                        <div class="form-group">

                            <?php if ($surcharge_t AND !$formError) echo '<br>' . $this->lang->line('Note: Payment Processing'); ?>

                        </div>
                        <div class="row" style="display:none;">
                            <div class="col">
                                <p class="payment-errors"></p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </section>
        <section class="card">

            <div class="card-body bg-white"><img class="img-responsive pull-right"
                                                 src="<?php echo base_url('assets/images/ssl-seal.png') ?>"></div>
        </section>

    </div>
