<script type="text/javascript" src="https://www.2checkout.com/checkout/api/2co.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
<script src="<?= assets_url() ?>assets/js/jquery.card.js"></script>
<style>
    .geocard-container {
        width: 100%;

        margin: 50px auto;
    }

    form {
        margin: 30px;
    }

    input {
        width: 200px;
        margin: 10px auto;
        display: block;
    }

</style>

<!-- If you're using Stripe for payments -->

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


                        <div class="geocard-container">
                            <div class="card-wrapper"></div>

                            <div class="form-container active">
                                <form id="payment-form" method="post">
                                    <input id="auth_token" name="auth_token" type="hidden" value="">
                                    <input type="hidden" class="form-control" name="gateway" value="<?= $cid ?>">
                                    <?php echo '<input type="hidden" class="form-control" name="id" value="' . $invoice['iid'] . '"/><input type="hidden" class="form-control" name="itype" value="' . $itype . '"/>
                <input type="hidden" class="form-control" name="token" value="' . $token . '"/>'; ?>
                                    <div>
                                        <label>
                                            <span>Card Number</span>
                                        </label>
                                        <input id="ccNo" name="number" class="form-control" type="tel" size="20"
                                               value="" autocomplete="off" required/>
                                    </div>
                                    <div>

                                        <div class="row">
                                            <div class="col-7 col-md-7">
                                                <div class="form-group">
                                                    <label for="cardExpiry"><span
                                                                class="hidden-xs"><?php echo $this->lang->line('EXPIRATION') ?></span><span
                                                                class="visible-xs-inline">  (MM/YYYY)</span> <?php echo $this->lang->line('DATE') ?>
                                                    </label>
                                                    <input
                                                            type="tel"
                                                            class="form-control"
                                                            name="expiry"
                                                            id="expiry_c"
                                                            placeholder="MM / YYYY"
                                                            autocomplete="cc-exp"
                                                            required
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-5 col-md-5 pull-right">
                                                <div class="form-group">
                                                    <label for="cardCVC"><?php echo $this->lang->line('CV CODE') ?></label>
                                                    <input id="cvv"
                                                           size="4" type="number"
                                                           class="form-control"
                                                           name="cvc"
                                                           placeholder="CVC"
                                                           autocomplete="cc-csc"
                                                           required
                                                    />
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                    <div class="form-group">
                                        <label for="amount"><?php echo $this->lang->line('Amount') ?>
                                        </label>
                                        <input type="number" class="form-control" name="amount"
                                               value="<?php if ($rming > 0) echo numberClean(amountExchange_s($rming, $invoice['multi'], $invoice['loc'])); else echo '0.00'; ?>"
                                               required/>
                                    </div>
                                    <button class="btn btn-success btn-lg btn-block"
                                            type="submit"><?php echo $this->lang->line('Paynow') ?></button>
                                </form>
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

                </div>
            </div>
        </section>
        <section class="card">

            <div class="card-body bg-white"><img class="img-responsive pull-right"
                                                 src="<?php echo base_url('assets/images/ssl-seal.png') ?>"></div>
        </section>

    </div>
    <script>
        new Card({
            form: document.querySelector('form'),
            container: '.card-wrapper',
            placeholders: {
                number: '•••• •••• •••• ••••',
                name: ' ',
                expiry: 'MM/YYYY',
                cvc: 'CV'
            }
        });
    </script>

    <script>
        // Called when token created successfully.
        var successCallback = function (data) {

            var myForm = document.getElementById('payment-form');
            // Set the token as the value for the token input
            myForm.auth_token.value = data.response.token.token;
            // IMPORTANT: Here we call `submit()` on the form element directly instead of using jQuery to prevent and infinite token request loop.
            var $form = $('#payment-form');

            $form.on('submit', payWithCard(event));


        };

        function payWithCard(e) {
            e.preventDefault();

            /* Visual feedback */


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
                    } else {
                        $('#payment-form').find('[type=submit]').html('<?php echo $this->lang->line('Paynow') ?>').prop('disabled', false);
                        $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                        $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                        $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                        var cok = '<?= $redirect_u ?>';
                        if (cok) window.location.replace(cok);
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


        // Called when token creation fails.
        var errorCallback = function (data) {
            if (data.errorCode === 200) {
                tokenRequest();
            } else {
                alert(data.errorMsg);
                $('#payment-form').find('[type=submit]').html('<?php echo $this->lang->line('Paynow') ?>').prop('disabled', false);
            }
        };

        var tokenRequest = function () {
            // Setup token request arguments
            var expiry_c = $("#expiry_c").val();

            var myear = expiry_c.split('/');

            var args = {
                sellerId: "<?=$gateway['extra']?>",
                publishableKey: "<?=$gateway['key1']?>",
                ccNo: $("#ccNo").val(),
                cvv: $("#cvv").val(),
                expMonth: myear[0],
                expYear: myear[1]
            };

            // Make the token request
            TCO.requestToken(successCallback, errorCallback, args);
        };

        $(function () {
            // Pull in the public encryption key for our environment
            TCO.loadPubKey('<?php if ($gateway['dev_mode']) {
                echo 'sandbox';
            } else {
                echo 'production';
            } ?>');

            $("#payment-form").submit(function (e) {
                $('#payment-form').find('[type=submit]').html('Processing <span class="icon-refresh2 spinner" aria-hidden="true"></span>').prop('disabled', true);
                // Call our token request function
                tokenRequest();

                // Prevent form from submitting

                return false;
            });
        });
    </script>