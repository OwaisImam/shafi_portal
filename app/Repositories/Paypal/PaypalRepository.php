<?php

namespace App\Repositories\Paypal;

use App\Helper\JsonResponse;
use App\Models\Order;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalRepository
{
    public $provider;
    public $paypalToken;

    public function init()
    {
        $this->provider = new PayPalClient();
        $this->provider->setApiCredentials(config('paypal'));
        $this->paypalToken = $this->provider->getAccessToken();
    }

    public function createOrder($order)
    {
        $data = [
            'intent' => 'CAPTURE',
            'purchase_units' => [
                [
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => $order->price,
                        'breakdown' => [
                            'item_total' => [
                                'currency_code' => 'USD',
                                'value' => $order->price,
                            ],
                        ],
                    ],
                    'items' => [
                        [
                            'name' => $order->design_name,
                            'quantity' => 1,
                            'unit_amount' => [
                                'currency_code' => 'USD',
                                'value' => $order->price,
                            ],
                        ],
                    ],
                    'custom_id' => $order->order_no,
                ],
            ],
            'payment_source' => [
                'paypal' => [
                    'experience_context' => [
                        'payment_method_preference' => 'IMMEDIATE_PAYMENT_REQUIRED',
                        'brand_name' => env('APP_NAME'),
                        'locale' => 'en-US',
                        'user_action' => 'PAY_NOW',
                        'return_url' => route('checkout.success', encrypt($order->id)),
                        'cancel_url' => route('checkout.cancel', encrypt($order->id)),
                    ],
                ],
            ],
        ];

        return $this->provider->createOrder($data);
    }

    public function processSuccessPayment($data)
    {
        try {

            DB::beginTransaction();
            $order = Order::where('order_no', $data['resource']['purchase_units'][0]['custom_id'])->first();

            if ($order) {
                $order->invoice->invoice->update([
                    'status' => 'paid',
                    'paypal_response' => json_encode($data),
                    'paypal_payment_id' => $data['resource']['id'],
                    'payment_method' => 'paypal',
                ]);

                $order->update([
                    'payment_method' => 'paypal',
                ]);
            }

            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e);

            return JsonResponse::fail('An error occured. ' . $e->getMessage() . ' on ' . $e->getFile() . ' ' . $e->getLine());
        }

    }
}
