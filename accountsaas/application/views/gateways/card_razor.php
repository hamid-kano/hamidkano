<style type="text/css">
    .razorpay-payment-button {
        border-color: #37BC9B;
        background-color: #37BC9B;
        color: #FFFFFF;
        padding: 0.75rem 1.5rem;
        font-size: 1.75rem;
        border-radius: 0.27rem;
        display: inline-block;
        font-weight: bold;
        line-height: 2.75;
        text-align: center;
        white-space: nowrap;
        vertical-align: middle;
        cursor: pointer;
        user-select: none;
        border: 1px solid transparent;
        padding: 0.5rem 1rem;
        border-radius: 0.18rem;
        transition: all 0.2s ease-in-out;
    }
</style>
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
                                        if ($rming < 1) exit('Invoice already paid!');
                                        echo $title . ' ' . $fee;


                                        $keyId = $gateway['key1'];
                                        $keySecret = $gateway['key2'];
                                        $displayCurrency = $gateway['currency'];
                                        require(APPPATH . 'third_party/razorpay-php/Razorpay.php');


                                        use Razorpay\Api\Api;

                                        $api = new Api($keyId, $keySecret);

                                        //
                                        // We create an razorpay order using orders api
                                        // Docs: https://docs.razorpay.com/docs/orders
                                        //
                                        $orderData = [
                                            'receipt' => $invoice['iid'],
                                            'amount' => number_format($rming * 100, 0, '', ''),
                                            'currency' => 'INR',
                                            'payment_capture' => 1 // auto capture
                                        ];

                                        $razorpayOrder = $api->order->create($orderData);

                                        $razorpayOrderId = $razorpayOrder['id'];

                                        $_SESSION['razorpay_order_id'] = $razorpayOrderId;

                                        $displayAmount = $amount = $orderData['amount'];

                                        if ($displayCurrency !== 'INR') {
                                            $url = "https://api.fixer.io/latest?symbols=$displayCurrency&base=INR";
                                            $exchange = json_decode(file_get_contents($url), true);

                                            $displayAmount = $exchange['rates'][$displayCurrency] * $amount / 100;
                                        }

                                        $checkout = 'automatic';

                                        //if (isset($_GET['checkout']) and in_array($_GET['checkout'], ['automatic', 'manual'], true))
                                        //{
                                        //    $checkout = $_GET['checkout'];
                                        //}

                                        $data = [
                                            "key" => $keyId,
                                            "amount" => $amount,
                                            "name" => $invoice['name'],
                                            "description" => "Payment for INV#" . $invoice['tid'],
                                            "image" => "https://s29.postimg.org/r6dj1g85z/daft_punk.jpg",
                                            "prefill" => [
                                                "name" => $invoice['name'],
                                                "email" => $invoice['email'],
                                                "contact" => $invoice['phone'],
                                            ],
                                            "notes" => [
                                                "address" => $invoice['address'],
                                                "merchant_order_id" => 'INV#' . $invoice['tid'],
                                            ],
                                            "theme" => [
                                                "color" => "#F37254"
                                            ],
                                            "order_id" => $razorpayOrderId,
                                        ];

                                        if ($displayCurrency !== 'INR') {
                                            $data['display_currency'] = $displayCurrency;
                                            $data['display_amount'] = $displayAmount;
                                        }

                                        $json = json_encode($data);
                                        ?></h5>

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


                        <form action="secureprocess?inv=<?= $invoice['iid'] . '&g=' . $gateway['id'] ?>" method="POST">
                            <script
                                    src="https://checkout.razorpay.com/v1/checkout.js"
                                    data-key="<?php echo $data['key'] ?>"
                                    data-amount="<?php echo $data['amount'] ?>"
                                    data-currency="INR"
                                    data-name="<?php echo $data['name'] ?>"
                                    data-image="<?php echo $data['image'] ?>"
                                    data-description="<?php echo $data['description'] ?>"
                                    data-prefill.name="<?php echo $data['prefill']['name'] ?>"
                                    data-prefill.email="<?php echo $data['prefill']['email'] ?>"
                                    data-prefill.contact="<?php echo $data['prefill']['contact'] ?>"
                                    data-notes.shopping_order_id="<?= $invoice['iid'] ?>"
                                    data-order_id="<?php echo $data['order_id'] ?>"
                                <?php if ($displayCurrency !== 'INR') { ?> data-display_amount="<?php echo $data['display_amount'] ?>" <?php } ?>
                                <?php if ($displayCurrency !== 'INR') { ?> data-display_currency="<?php echo $data['display_currency'] ?>" <?php } ?>
                            >
                            </script>
                            <!-- Any extra fields to be submitted with the form but not sent to Razorpay -->
                            <input type="hidden" name="shopping_order_id" value="<?= $invoice['iid'] ?>">
                        </form>


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
