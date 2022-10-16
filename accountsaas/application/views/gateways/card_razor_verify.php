<?php

require(APPPATH . 'third_party/razorpay-php/Razorpay.php');

use Razorpay\Api\Api;
use Razorpay\Api\Errors\SignatureVerificationError;

$success = true;

$error = "Payment Failed";

if (empty($this->input->post('razorpay_payment_id', true)) === false) {
    $api = new Api($keyId, $keySecret);

    try {
        // Please note that the razorpay order ID must
        // come from a trusted source (session here, but
        // could be database or something else)
        $attributes = array(
            'razorpay_order_id' => $_SESSION['razorpay_order_id'],
            'razorpay_payment_id' => $this->input->post('razorpay_payment_id', true),
            'razorpay_signature' => $this->input->post('razorpay_signature', true)
        );

        $api->utility->verifyPaymentSignature($attributes);
    } catch (SignatureVerificationError $e) {
        $success = false;
        $error = 'Razorpay Error : ' . $e->getMessage();
    }
}

if ($success === true) {
    $html = "<p>Your payment was successful</p>
             <p>Payment ID: {$this->input->post('razorpay_payment_id', true)}</p>";
    $tid = $this->input->get('inv', true);
    $customer = $this->invocies->invoice_details($tid);
    $note = 'Card Payment for #' . $customer['tid'] . ' T#' . $this->input->post('razorpay_payment_id', true);
    $pmethod = 'Card';
    $amount_o = $customer['total'] - $customer['pamnt'];
    $surcharge = ($amount_o * $gateway_data['surcharge']) / 100;
    $amount_t = $amount_o + $surcharge;
    $validtoken = hash_hmac('ripemd160', $tid, $this->config->item('encryption_key'));
    if (number_format($amount_t, 2, '.', '')) {
        $amount = number_format($amount_o, 2, '.', '');
        if ($this->billing->paynow($customer['iid'], $amount, $note, $pmethod, $customer['loc'])) {

            redirect(base_url('billing/view?id=' . $tid . '&token=' . $validtoken));
        }
    }
} else {
    $html = "<p>Your payment failed</p>
             <p>{$error}</p>";
}

echo $html;
