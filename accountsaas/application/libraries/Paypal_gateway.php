<?php
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;


class Paypal_gateway
{
    var $enableSandbox;
    var $paypalConfig;
    function __construct($parameters)
    {
        $this ->enableSandbox = $parameters['sandbox'];
// PayPal settings. Change these to your account details and the relevant URLs
// for your site.
 $this->paypalConfig = [
    'client_id' => $parameters['client_id'],
    'client_secret' => $parameters['client_secret']
];
    }

    function getApiContext()
{
    require APPPATH.'third_party'.DIRECTORY_SEPARATOR.'paypal'.DIRECTORY_SEPARATOR.'autoload.php';
    $apiContext = new ApiContext(
        new OAuthTokenCredential($this->paypalConfig['client_id'], $this->paypalConfig['client_secret'])
    );

    $apiContext->setConfig([
        'mode' => $this->enableSandbox ? 'sandbox' : 'live'
    ]);

    return $apiContext;
}



}