<style type="text/css">


    form {

        padding: 5rem !important;
        display: block;
    }

    label {
        height: 35px;
        position: relative;
        color: #8798AB;
        display: block;
        margin-top: 30px;
        margin-bottom: 20px;
    }

    label > span {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        font-weight: 300;
        line-height: 32px;
        color: #8798AB;
        border-bottom: 1px solid #586A82;
        transition: border-bottom-color 200ms ease-in-out;
        cursor: text;
        pointer-events: none;
    }

    label > span span {
        position: absolute;
        top: 0;
        left: 0;
        transform-origin: 0% 50%;
        transition: transform 200ms ease-in-out;
        cursor: text;
    }

    label .field.is-focused + span span,
    label .field:not(.is-empty) + span span {
        transform: scale(0.68) translateY(-36px);
        cursor: default;
    }

    label .field.is-focused + span {
        border-bottom-color: #34D08C;
    }

    .field {
        background: transparent;
        font-weight: 300;
        border: 0;
        color: white;
        outline: none;
        cursor: text;
        display: block;
        width: 100%;
        line-height: 32px;
        padding-bottom: 3px;
        transition: opacity 200ms ease-in-out;
    }

    .field::-webkit-input-placeholder {
        color: #8898AA;
    }

    .field::-moz-placeholder {
        color: #8898AA;
    }

    /* IE doesn't show placeholders when empty+focused */
    .field:-ms-input-placeholder {
        color: #424770;
    }

    .field.is-empty:not(.is-focused) {
        opacity: 0;
    }

    button {
        float: left;
        display: block;
        background: #34D08C;
        color: white;
        border-radius: 2px;
        border: 0;
        margin-top: 20px;
        font-size: 19px;
        font-weight: 400;
        width: 100%;
        height: 47px;
        line-height: 45px;
        outline: none;
    }

    button:focus {
        background: #24B47E;
    }

    button:active {
        background: #159570;
    }

    .outcome {
        float: left;
        width: 100%;
        padding-top: 8px;
        min-height: 20px;
        text-align: center;
    }

    .success, .error {
        display: none;
        font-size: 15px;
    }

    .success.visible, .error.visible {
        display: inline;
    }

    .error {
        color: #E4584C;
    }

    .success {
        color: #34D08C;
    }

    .success .token {
        font-weight: 500;
        font-size: 15px;
    }

    .ultimate.geopos {
        background-color: #525f7f;
    }

    .ultimate.geopos * {
        font-family: Quicksand, Open Sans, Segoe UI, sans-serif;
        font-size: 16px;
        font-weight: 600;
    }

    .ultimate.geopos .fieldset {
        margin: 0 15px 30px;
        padding: 0;
        border-style: none;
        display: -ms-flexbox;
        display: flex;
        -ms-flex-flow: row wrap;
        flex-flow: row wrap;
        -ms-flex-pack: justify;
        justify-content: space-between;
    }

    .ultimate.geopos .field {
        padding: 10px 20px 11px;
        background-color: #7488aa;
        border-radius: 20px;
        width: 100%;
    }

    .ultimate.geopos .field.half-width {
        width: calc(50% - (5px / 2));
    }

    .ultimate.geopos .field.third-width {
        width: calc(33% - (5px / 3));
    }

    .ultimate.geopos .field + .field {
        margin-top: 6px;
    }

    .ultimate.geopos .field.focus,
    .ultimate.geopos .field:focus {
        color: #424770;
        background-color: #f6f9fc;
    }

    .ultimate.geopos .field.invalid {
        background-color: #fa755a;
    }

    .ultimate.geopos .field.invalid.focus {
        background-color: #f6f9fc;
    }

    .ultimate.geopos .field.focus::-webkit-input-placeholder,
    .ultimate.geopos .field:focus::-webkit-input-placeholder {
        color: #cfd7df;
    }

    .ultimate.geopos .field.focus::-moz-placeholder,
    .ultimate.geopos .field:focus::-moz-placeholder {
        color: #cfd7df;
    }

    .ultimate.geopos .field.focus:-ms-input-placeholder,
    .ultimate.geopos .field:focus:-ms-input-placeholder {
        color: #cfd7df;
    }

    .ultimate.geopos input, .ultimate.geopos button {
        -webkit-appearance: none;
        -moz-appearance: none;
        appearance: none;
        outline: none;
        border-style: none;
    }

    .ultimate.geopos input {
        color: #fff;
    }

    .ultimate.geopos input::-webkit-input-placeholder {
        color: #9bacc8;
    }

    .ultimate.geopos input::-moz-placeholder {
        color: #9bacc8;
    }

    .ultimate.geopos input:-ms-input-placeholder {
        color: #9bacc8;
    }

    .ultimate.geopos button {
        display: block;
        width: calc(100% - 30px);
        height: 40px;
        margin: 0 15px;
        background-color: #fcd669;
        border-radius: 20px;
        color: #525f7f;
        font-weight: 600;
        text-transform: uppercase;
        cursor: pointer;
    }

    .ultimate.geopos button:active {
        background-color: #f5be58;
    }

    .ultimate.geopos .error svg .base {
        fill: #fa755a;
    }

    .ultimate.geopos .error svg .glyph {
        fill: #fff;
    }

    .ultimate.geopos .error .message {
        color: #fff;
    }

    .ultimate.geopos .success .icon .border {
        stroke: #fcd669;
    }

    .ultimate.geopos .success .icon .checkmark {
        stroke: #fff;
    }

    .ultimate.geopos .success .title {
        color: #fff;
    }

    .ultimate.geopos .success .message {
        color: #9cabc8;
    }

    .ultimate.geopos .success .reset path {
        fill: #fff;
    }
</style>
<?php
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
?>
<script type="text/javascript" src="https://js.stripe.com/v3/"></script>
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

                    <div class="col-md-6"><span class="display-block text-xs-center"><img class="bg-white round "
                                                                                          style="max-width:30rem;max-height:10rem"
                                                                                          src="<?= base_url('assets/gateway_logo/' . $gid . '.png') ?>"></span>
                        <div class="form-group">
                            <label for="cardNumber"> <?php echo $this->lang->line('Invoice') ?>
                                #<?php echo $invoice['tid'] ?> <?php echo $this->lang->line('Total Amount') ?>
                                <input name="total_amount"
                                       value="<?php echo amountExchange($invoice['total'], $invoice['multi'], $invoice['loc']) ?>"
                                       type="text"
                                       class="form-control"


                                       readonly/></label>

                        </div>
                        <div class="form-group">
                            <label for="cardNumber"><?php echo $this->lang->line('Due Amount') ?>
                                <input name="total_amount"
                                       value="<?php
                                       echo amountExchange($rming, $invoice['multi'], $invoice['loc']); ?>"
                                       type="text"
                                       class="form-control"


                                       readonly/>

                        </div>
                    </div>

                    <div id="p_form" class="col-md-6 ">


                        <div class="cell ultimate geopos round" id="ultimate-3">
                            <form id="payment_form">
                                <?= '<input type="hidden" class="form-control" name="id" value="' . $invoice['iid'] . '"/><input type="hidden" class="form-control" name="gateway" value="' . $gid . '"/><input type="hidden" class="form-control" name="itype" value="' . $itype . '"/>
                <input type="hidden" class="form-control" name="token" value="' . $token . '"/>'; ?>
                                <div class="white text-xs-center mb-2">  <?= $title . ' ' . $fee ?></div>
                                <div class="fieldset">

                                    <div id="geopos-card-number" class="field empty"></div>
                                    <div id="geopos-card-expiry" class="field empty third-width"></div>
                                    <div id="geopos-card-cvc" class="field empty third-width"></div>
                                    <div class="empty"><p
                                                class="mt-1 white  half-width"><?php echo $this->lang->line('Amount') ?></p>
                                        <input class="field half-width" type="number"
                                               placeholder="<?php echo $this->lang->line('Amount') ?>" required="yes"
                                               autocomplete="off"
                                               value="<?php if ($rming > 0) echo numberClean(amountExchange_s($rming, $invoice['multi'], $invoice['loc'])); else echo '0.00'; ?>"
                                               name="amount" step="0.01" min="0.01">
                                    </div>
                                </div>
                                <button type="submit" data-tid="elements_ultimates.form.pay_button"
                                        id="pay_btn"><?php echo $this->lang->line('Paynow') ?></button>
                                <div class="error" role="alert">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="17" height="17" viewBox="0 0 17 17">
                                        <path class="base" fill="#000"
                                              d="M8.5,17 C3.80557963,17 0,13.1944204 0,8.5 C0,3.80557963 3.80557963,0 8.5,0 C13.1944204,0 17,3.80557963 17,8.5 C17,13.1944204 13.1944204,17 8.5,17 Z"></path>
                                        <path class="glyph" fill="#FFF"
                                              d="M8.5,7.29791847 L6.12604076,4.92395924 C5.79409512,4.59201359 5.25590488,4.59201359 4.92395924,4.92395924 C4.59201359,5.25590488 4.59201359,5.79409512 4.92395924,6.12604076 L7.29791847,8.5 L4.92395924,10.8739592 C4.59201359,11.2059049 4.59201359,11.7440951 4.92395924,12.0760408 C5.25590488,12.4079864 5.79409512,12.4079864 6.12604076,12.0760408 L8.5,9.70208153 L10.8739592,12.0760408 C11.2059049,12.4079864 11.7440951,12.4079864 12.0760408,12.0760408 C12.4079864,11.7440951 12.4079864,11.2059049 12.0760408,10.8739592 L9.70208153,8.5 L12.0760408,6.12604076 C12.4079864,5.79409512 12.4079864,5.25590488 12.0760408,4.92395924 C11.7440951,4.59201359 11.2059049,4.59201359 10.8739592,4.92395924 L8.5,7.29791847 L8.5,7.29791847 Z"></path>
                                    </svg>
                                    <span class="message"></span></div>
                            </form>
                            <div class="success">
                                <div class="icon">
                                    <svg width="84px" height="84px" viewBox="0 0 84 84" version="1.1"
                                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <circle class="border" cx="42" cy="42" r="40" stroke-linecap="round"
                                                stroke-width="4" stroke="#000" fill="none"></circle>
                                        <path class="checkmark" stroke-linecap="round" stroke-linejoin="round"
                                              d="M23.375 42.5488281 36.8840688 56.0578969 64.891932 28.0500338"
                                              stroke-width="4" stroke="#000" fill="none"></path>
                                    </svg>
                                </div>
                                <h3 class="title" data-tid="elements_ultimates.success.title">Payment successful</h3>
                                <p class="message"><span data-tid="elements_ultimates.success.message">Thanks for trying Stripe Elements. No money was charged, but we generated a token: </span><span
                                            class="token">tok_189gMN2eZvKYlo2CwTBv9KKh</span></p>
                                <a class="reset" href="#">
                                    <svg width="32px" height="32px" viewBox="0 0 32 32" version="1.1"
                                         xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                        <path fill="#000000"
                                              d="M15,7.05492878 C10.5000495,7.55237307 7,11.3674463 7,16 C7,20.9705627 11.0294373,25 16,25 C20.9705627,25 25,20.9705627 25,16 C25,15.3627484 24.4834055,14.8461538 23.8461538,14.8461538 C23.2089022,14.8461538 22.6923077,15.3627484 22.6923077,16 C22.6923077,19.6960595 19.6960595,22.6923077 16,22.6923077 C12.3039405,22.6923077 9.30769231,19.6960595 9.30769231,16 C9.30769231,12.3039405 12.3039405,9.30769231 16,9.30769231 L16,12.0841673 C16,12.1800431 16.0275652,12.2738974 16.0794108,12.354546 C16.2287368,12.5868311 16.5380938,12.6540826 16.7703788,12.5047565 L22.3457501,8.92058924 L22.3457501,8.92058924 C22.4060014,8.88185624 22.4572275,8.83063012 22.4959605,8.7703788 C22.6452866,8.53809377 22.5780351,8.22873685 22.3457501,8.07941076 L22.3457501,8.07941076 L16.7703788,4.49524351 C16.6897301,4.44339794 16.5958758,4.41583275 16.5,4.41583275 C16.2238576,4.41583275 16,4.63969037 16,4.91583275 L16,7 L15,7 L15,7.05492878 Z M16,32 C7.163444,32 0,24.836556 0,16 C0,7.163444 7.163444,0 16,0 C24.836556,0 32,7.163444 32,16 C32,24.836556 24.836556,32 16,32 Z"></path>
                                    </svg>
                                </a>
                            </div>

                            <div class="caption  text-center">
                                <span data-tid="elements_ultimates.caption.no_charge"
                                      class="no-charge grey"><?php if ($surcharge_t) echo '<br>' . $this->lang->line('Note: Payment Processing'); ?></span>

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
        'use strict';

        var stripe = Stripe('<?=$row['key2']; ?>');

        function registerElements(elements, ultimateName) {
            var formClass = '.' + ultimateName;
            var ultimate = document.querySelector(formClass);

            var form = ultimate.querySelector('form');
            var resetButton = ultimate.querySelector('a.reset');
            var error = form.querySelector('.error');
            var errorMessage = error.querySelector('.message');

            function enableInputs() {
                Array.prototype.forEach.call(
                    form.querySelectorAll(
                        "input[type='text'], input[type='email'], input[type='tel']"
                    ),
                    function (input) {
                        input.removeAttribute('disabled');
                    }
                );
            }

            function disableInputs() {
                Array.prototype.forEach.call(
                    form.querySelectorAll(
                        "input[type='text'], input[type='email'], input[type='tel']"
                    ),
                    function (input) {
                        input.setAttribute('disabled', 'true');
                    }
                );
            }

            function triggerBrowserValidation() {
                // The only way to trigger HTML5 form validation UI is to fake a user submit
                // event.
                var submit = document.createElement('input');
                submit.type = 'submit';
                submit.style.display = 'none';
                form.appendChild(submit);
                submit.click();
                submit.remove();
            }

            // Listen for errors from each Element, and show error messages in the UI.
            var savedErrors = {};
            elements.forEach(function (element, idx) {
                element.on('change', function (event) {
                    if (event.error) {
                        error.classList.add('visible');
                        savedErrors[idx] = event.error.message;
                        errorMessage.innerText = event.error.message;
                    } else {
                        savedErrors[idx] = null;

                        // Loop over the saved errors and find the first one, if any.
                        var nextError = Object.keys(savedErrors)
                            .sort()
                            .reduce(function (maybeFoundError, key) {
                                return maybeFoundError || savedErrors[key];
                            }, null);

                        if (nextError) {
                            // Now that they've fixed the current error, show another one.
                            errorMessage.innerText = nextError;
                        } else {
                            // The user fixed the last error; no more errors.
                            error.classList.remove('visible');
                        }
                    }
                });
            });

            // Listen on the form's 'submit' handler...
            form.addEventListener('submit', function (e) {
                e.preventDefault();
                $('#payment_form').find('[type=submit]').html('Processing <span class="icon-refresh2 spinner" aria-hidden="true"></span>').prop('disabled', true);
                // Trigger HTML5 validation UI on the form if any of the inputs fail
                // validation.
                var plainInputsValid = true;
                Array.prototype.forEach.call(form.querySelectorAll('input'), function (
                    input
                ) {
                    if (input.checkValidity && !input.checkValidity()) {
                        plainInputsValid = false;
                        return;
                    }
                });
                if (!plainInputsValid) {
                    triggerBrowserValidation();
                    return;
                }

                // Show a loading screen...
                ultimate.classList.add('submitting');

                // Disable all inputs.
                disableInputs();

                // Gather additional customer data we may have collected in our form.
                var name = form.querySelector('#' + ultimateName + '-name');
                var address1 = form.querySelector('#' + ultimateName + '-address');
                var city = form.querySelector('#' + ultimateName + '-city');
                var state = form.querySelector('#' + ultimateName + '-state');
                var zip = form.querySelector('#' + ultimateName + '-zip');
                var additionalData = {
                    name: name ? name.value : undefined,
                    address_line1: address1 ? address1.value : undefined,
                    address_city: city ? city.value : undefined,
                    address_state: state ? state.value : undefined,
                    address_zip: zip ? zip.value : undefined,
                };

                // Use Stripe.js to create a token. We only need to pass in one Element
                // from the Element group in order to create a token. We can also pass
                // in the additional customer data we collected in our form.
                stripe.createToken(elements[0], additionalData).then(function (result) {
                    // Stop loading!
                    ultimate.classList.remove('submitting');

                    if (result.token) {
                        // If we received a token, show the token ID.
                        ultimate.querySelector('.token').innerText = result.token.id;

                        jQuery.ajax({

                            url: '<?php echo base_url('billing/process_card') ?>',
                            type: 'POST',
                            data: $('#payment_form').serialize() + '&stripeToken=' + result.token.id + '&<?=$this->security->get_csrf_token_name(); ?>=<?=$this->security->get_csrf_hash(); ?>',
                            dataType: 'json',
                            success: function (data) {
                                if (data.status == 'Success') {
                                    $('#payment_form').find('[type=submit]').html('Payment successful <span class="icon-check" aria-hidden="true"></span>').prop('disabled', true);
                                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                                    $("#notify").removeClass("alert-danger").addClass("alert-success").fadeIn();
                                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);

                                    var cok = '<?= $redirect_u ?>';
                                    if (cok) window.location.replace(cok);
                                } else {
                                    $('#payment_form').find('[type=submit]').html('<?php echo $this->lang->line('Paynow') ?>').prop('disabled', false);
                                    $("#notify .message").html("<strong>" + data.status + "</strong>: " + data.message);
                                    $("#notify").removeClass("alert-success").addClass("alert-danger").fadeIn();
                                    $("html, body").animate({scrollTop: $('#notify').offset().top}, 1000);
                                }

                            },
                            error: function () {
                                $('#payment_form').find('[type=submit]').html('There was a problem').removeClass('success').addClass('error');
                                /* Show Stripe errors on the form */
                                $('#payment_form').find('.payment-errors').text('Try refreshing the page and trying again.');
                                $('#payment_form').find('.payment-errors').closest('.row').show();
                                $('#payment_form').find('[type=submit]').html('Error! <i class="fa fa-exclamation-circle"></i>')
                                    .prop('disabled', true);
                                $("#notify .message").html("<strong>Error</strong>: Please try again!");


                            }

                        });
                        ultimate.classList.add('submitted');
                    } else {
                        // Otherwise, un-disable inputs.
                        enableInputs();
                    }
                });
            });

            resetButton.addEventListener('click', function (e) {
                e.preventDefault();
                // Resetting the form (instead of setting the value to `''` for each input)
                // helps us clear webkit autofill styles.
                form.reset();

                // Clear each Element.
                elements.forEach(function (element) {
                    element.clear();
                });

                // Reset error state as well.
                error.classList.remove('visible');

                // Resetting the form does not un-disable inputs, so we need to do it separately:
                enableInputs();
                ultimate.classList.remove('submitted');
            });
        }

        (function () {
            'use strict';

            var elements = stripe.elements({
                fonts: [
                    {
                        cssSrc: 'https://fonts.googleapis.com/css?family=Quicksand',
                    },
                ],
                // Stripe's ultimates are localized to specific languages, but if
                // you wish to have Elements automatically detect your user's locale,
                // use `locale: 'auto'` instead.
                locale: window.__ultimateLocale,
            });

            var elementStyles = {
                base: {
                    color: '#fff',
                    fontWeight: 600,
                    fontFamily: 'Quicksand, Open Sans, Segoe UI, sans-serif',
                    fontSize: '16px',
                    fontSmoothing: 'antialiased',

                    ':focus': {
                        color: '#424770',
                    },

                    '::placeholder': {
                        color: '#9BACC8',
                    },

                    ':focus::placeholder': {
                        color: '#CFD7DF',
                    },
                },
                invalid: {
                    color: '#fff',
                    ':focus': {
                        color: '#FA755A',
                    },
                    '::placeholder': {
                        color: '#FFCCA5',
                    },
                },
            };

            var elementClasses = {
                focus: 'focus',
                empty: 'empty',
                invalid: 'invalid',
            };

            var cardNumber = elements.create('cardNumber', {
                style: elementStyles,
                classes: elementClasses,
            });
            cardNumber.mount('#geopos-card-number');

            var cardExpiry = elements.create('cardExpiry', {
                style: elementStyles,
                classes: elementClasses,
            });
            cardExpiry.mount('#geopos-card-expiry');

            var cardCvc = elements.create('cardCvc', {
                style: elementStyles,
                classes: elementClasses,
            });
            cardCvc.mount('#geopos-card-cvc');

            registerElements([cardNumber, cardExpiry, cardCvc], 'geopos');
        })();

    </script>