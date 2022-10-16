<link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.13.1/jquery.validate.min.js"></script>
<script type="text/javascript"
        src="https://cdnjs.cloudflare.com/ajax/libs/jquery.payment/1.2.3/jquery.payment.min.js"></script>

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
                <div>
                    <form role="form" id="payment-form" class="row">
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

                                            echo $title . ' ' . $fee ?></h5><img class="bg-white round mt-1"
                                                                                 style="max-width:30rem;max-height:10rem"
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
                                        <label for="cardNumber"><?php echo $this->lang->line('Due Amount') ?></label>
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

                            <div class="row">
                                <div class="col">

                                    <div class="card-title mb-3">
                                        <img class="img-responsive pull-right"
                                             src="<?php echo base_url('assets/images/accepted_c22e0.png') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label for="cardNumber"><?php echo $this->lang->line('CARD NUMBER') ?></label>
                                        <div class="input-group">
                                            <input
                                                    type="tel"
                                                    class="form-control"
                                                    name="cardNumber"
                                                    placeholder="Valid Card Number"
                                                    autocomplete="cc-number"
                                                    required autofocus
                                            />
                                            <span class="input-group-addon"><i class="fa fa-credit-card"></i></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-7">
                                    <div class="form-group">
                                        <label for="cardExpiry"><span
                                                    class="hidden-xs"><?php echo $this->lang->line('EXPIRATION') ?></span><span
                                                    class="visible-xs-inline"><?php echo $this->lang->line('EXP') ?></span> <?php echo $this->lang->line('DATE') ?>
                                        </label>
                                        <input
                                                type="tel"
                                                class="form-control"
                                                name="cardExpiry"
                                                placeholder="MM / YY"
                                                autocomplete="cc-exp"
                                                required
                                        />
                                    </div>
                                </div>
                                <div class="col-5 col-md-5 pull-right">
                                    <div class="form-group">
                                        <label for="cardCVC"><?php echo $this->lang->line('CV CODE') ?></label>
                                        <input
                                                type="tel"
                                                class="form-control"
                                                name="cardCVC"
                                                placeholder="CVC"
                                                autocomplete="cc-csc"
                                                required
                                        />
                                    </div>
                                </div>
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
                                <div class="col">
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
            </div>
        </section>
        <section class="card">

            <div class="card-body bg-white"><img class="img-responsive pull-right"
                                                 src="<?php echo base_url('assets/images/ssl-seal.png') ?>"></div>
        </section>

    </div>
    <?php
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
            $('#payment-form').find('[type=submit]').html('Processing <span class="icon-refresh2 spinner" aria-hidden="true"></span>').prop('disabled', true);

            jQuery.ajax({

                url: '<?php echo base_url('billing/process_card') ?>',
                type: 'POST',
                data: $('#payment-form').serialize() + '&<?=$this->security->get_csrf_token_name(); ?>=<?=$this->security->get_csrf_hash(); ?>',
                dataType: 'json',
                success: function (data) {

                    if (data.status == 'Success') {
                        $('#payment-form').find('[type=submit]').html('Payment successful <span class="icon-check" aria-hidden="true"></span>').prop('disabled', true);
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                        var cok = '<?= $redirect_u ?>';
                        if (cok) window.location.replace(cok);
                    } else {
                        $('#payment-form').find('[type=submit]').html('<?php echo $this->lang->line('Paynow') ?>').prop('disabled', false);
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                    }

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

        /* Fancy restrictive input formatting via jQuery.payment library*/
        $('input[name=cardNumber]').payment('formatCardNumber');
        $('input[name=cardCVC]').payment('formatCardCVC');
        $('input[name=cardExpiry]').payment('formatCardExpiry');

        /* Form validation using Stripe client-side validation helpers */
        jQuery.validator.addMethod("cardNumber", function (value, element) {
            return this.optional(element) || Stripe.card.validateCardNumber(value);
        }, "Please specify a valid credit card number.");

        jQuery.validator.addMethod("cardExpiry", function (value, element) {
            /* Parsing month/year uses jQuery.payment library */
            value = $.payment.cardExpiryVal(value);
            return this.optional(element) || Stripe.card.validateExpiry(value.month, value.year);
        }, "Invalid expiration date.");

        jQuery.validator.addMethod("cardCVC", function (value, element) {
            return this.optional(element) || Stripe.card.validateCVC(value);
        }, "Invalid CVC.");

        validator = $form.validate({
            rules: {
                cardNumber: {
                    required: true,
                    cardNumber: true
                },
                cardExpiry: {
                    required: true,
                    cardExpiry: true
                },
                cardCVC: {
                    required: true,
                    cardCVC: true
                }
            },
            highlight: function (element) {
                $(element).closest('.form-control').removeClass('success').addClass('error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-control').removeClass('error').addClass('success');
            },
            errorPlacement: function (error, element) {
                $(element).closest('.form-group').append(error);
            }
        });

        paymentFormReady = function () {
            if ($form.find('[name=cardNumber]').hasClass("success") &&
                $form.find('[name=cardExpiry]').hasClass("success") &&
                $form.find('[name=cardCVC]').val().length > 1) {
                return true;
            } else {
                return false;
            }
        }

        $form.find('[type=submit]').prop('disabled', true);
        var readyInterval = setInterval(function () {
            if (paymentFormReady()) {
                $form.find('[type=submit]').prop('disabled', false);
                clearInterval(readyInterval);
            }
        }, 250);
    </script>