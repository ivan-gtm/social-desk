<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    /**
     * Process
     */
    public function process()
    {
        $Route = $this->getVariable("Route");
        $gateway = $Route->params->gateway;

        $PaymentGateway = \Payments\Gateway::choose($gateway);
        if ($PaymentGateway && method_exists($PaymentGateway, "webhook")) {
            try {
                $PaymentGateway->webhook();
            } catch (\Exception $e) {
                // Something is wrong
            }
        }
    }
}
