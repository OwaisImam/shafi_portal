<?php

namespace App\Repositories\Stripe;

use App\Helper\JsonResponse;
use App\Models\Order;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\StripeClient;

class StripeRepository
{
    public $client;

    public function init()
    {
        if (env('STRIPE_MODE') == 'sandbox') {
            $this->client = new StripeClient(env('STRIPE_SANDBOX_SECRET'));
        } else {
            $this->client = new StripeClient(env('STRIPE_LIVE_SECRET'));
        }
    }

    public function createCustomer($data)
    {
        $address = [];

        if ($data->address) {
            $address['line1'] = $data->address;
        }

        if ($data->city) {
            $address['city'] = $data->city->name;
        }

        if ($data->postcode) {
            $address['postal_code'] = $data->postcode;
        }

        if ($data->country_id) {
            $address['country'] = $data->city->state->country->name;

        }

        $requestData = [
            'name' => $data->name,
            'email' => $data->email,
            'phone' => $data->phone,
            'address' => $address,
        ];

        $customer = $this->client->customers->create($requestData);

        if ($customer->id) {

            User::where('id', $data->id)->update(['stripe_customer_id' => $customer->id]);
        }

        return $customer;
    }

    public function getCustomerAllPaymentData($customerId)
    {
        $data = $this->client->customers->allPaymentMethods($customerId, ['type' => 'card']);

        $customerData = $this->getCustomerCompletDetail($customerId);

        $defaultPaymentMethodId = '';

        if ($data->data) {

            foreach ($data->data as $item) {

                if ($customerData->invoice_settings && $customerData->invoice_settings->default_payment_method) {

                    $defaultPaymentMethodId = $customerData->invoice_settings->default_payment_method;

                }

                $item['is_default'] = $defaultPaymentMethodId == $item['id'] ? true : false;

            }
        }

        return $data;

    }

    private function _setupPaymentMethodsInput($method, $employer)
    {

        $billings = [];

        if ($employer->email) {
            $billings['email'] = $employer->email;
        }

        if ($employer->address1) {
            $billings['address']['line1'] = $employer->address1;
        }

        if ($employer->address2) {
            $billings['address']['line2'] = $employer->address2;
        }

        if ($employer->city) {
            $billings['address']['city'] = $employer->city;
        }

        if ($employer->postcode) {
            $billings['address']['postal_code'] = $employer->postcode;
        }

        if ($employer->country_id) {
            $billings['address']['country'] = config('constants.vantage.country_abbr_stripe')[$employer->country_id];
        }

        if ($employer->name) {
            $billings['name'] = ($employer->name . ' - ' . $employer->decision_maker_first_name . ' ' . $employer->decision_maker_last_name);
        }

        if ($employer->mobile_number) {
            $billings['phone'] = $employer->mobile_number;
        }

        $methodData = [
            'type' => 'card',
            'card' => $method,
        ];

        if ($billings) {
            $methodData['billing_details'] = $billings;
        }

        return $methodData;
    }

    public function createCustomerPaymentMethod($method, $customerId, $employer, $attachToo = true)
    {
        $input = $this->_setupPaymentMethodsInput($method, $employer);

        $paymentMethod = $this->client->paymentMethods->create($input);

        if ($paymentMethod->id && $attachToo) {

            $this->client->paymentMethods->attach($paymentMethod->id, ['customer' => $customerId]);
        }

        return $paymentMethod;
    }

    public function updateCustomerPaymentMethod($method, $customerId, $paymentMethodId, $employer, $attachToo = true)
    {
        $input = $this->_setupPaymentMethodsInput($method, $employer);

        unset($input['type']);
        unset($input['number']);
        unset($input['cvc']);

        $paymentMethod = $this->client->paymentMethods->update($paymentMethodId, $input);

        if ($paymentMethod->id && $attachToo) {

            $this->client->paymentMethods->attach($paymentMethod->id, ['customer' => $customerId]);
        }

        return $paymentMethod;
    }

    public function deleteCustomerPaymentMethod($methodId)
    {
        return $this->client->paymentMethods->detach(
            $methodId,
            []
        );
    }

    private function _intentDescription($jobInstance)
    {
        $description = '';

        $description .= 'Job Post: ' . $jobInstance->title .
        ', Posted on: ' . date('d/m/Y', strtotime($jobInstance->created_at));

        return $description;
    }

    public function updateCustomerPaymentIntent($paymentIntentId, $intentData = [])
    {
        return $this->client->paymentIntents->update($paymentIntentId, $intentData);
    }

    public function getCustomersByEmail($emailAddress)
    {
        return $this->client->customers->all(['email' => $emailAddress]);
    }

    public function getCustomerCompletDetail($customerId)
    {
        return $this->client->customers->retrieve($customerId, []);
    }

    public function deleteAllCustomers()
    {
        $allCustomers = $this->client->customers->all(['limit' => 912]);

        foreach ($allCustomers as $customer) {
            $this->client->customers->delete($customer->id, []);
        }
    }

    public function getCheckoutSession($Id)
    {
        return $this->client->checkout->sessions->retrieve(
            $Id,
            []
        );
    }

    public function processSuccessPaymentIntent($intentData)
    {
        try {
            DB::beginTransaction();
            $order = Order::where('id', $intentData->metadata->orderNo)->first();

            if ($order) {
                $order->invoice->invoice->update([
                    'status' => 'paid',
                    'stripe_payment_intent' => $intentData->payment_intent,
                    'stripe_receipt_url' => $intentData->receipt_url,
                    'stripe_charge_id' => $intentData->id,
                    'payment_method' => 'stripe',
                ]);
                $order->update([
                    'payment_method' => 'stripe',
                ]);
            }
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e);

            return JsonResponse::fail('An error occured. ' . $e->getMessage() . ' on ' . $e->getFile() . ' ' . $e->getLine());
        }
    }

    public function processPaymentIntentFailed($intentData)
    {
        try {
            DB::beginTransaction();
            $order = Order::where('id', $intentData->metadata->orderNo)->first();

            if ($order) {
                $order->invoice->invoice->update([
                    'status' => 'failed',
                    'stripe_payment_intent' => $intentData->id,
                    'stripe_charge_id' => $intentData->latest_charge,
                    'failure_reason' => $intentData->last_payment_error->message,
                ]);
            }
            DB::commit();

        } catch (Exception $e) {
            DB::rollBack();
            Log::debug($e);

            return JsonResponse::fail('An error occured. ' . $e->getMessage() . ' on ' . $e->getFile() . ' ' . $e->getLine());
        }
    }

    public function fetchCustomer($customerID)
    {
        return $this->client->customers->retrieve($customerID, []);
    }

    public function createPrice($order)
    {
        $price = $this->client->prices->create([
            'currency' => 'usd',
            'unit_amount' => $order->invoice->invoice->getNetTotal() * 100,
            'nickname' => $order->getDesignName() . ' - ' . $order->getOrderNo(),
            'product_data' => [
                'name' => $order->getDesignName() . ' - ' . $order->getOrderNo(),
            ],
        ]);

        return $price->id;
    }

    public function createPaymentSession($orderRelease, $price)
    {
        $session = $this->client->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'customer_email' => $orderRelease->order->user->getEmail(),
            'line_items' => [
                [
                'price' => $price,
                'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'metadata' => [
                'orderNo' => $orderRelease->order->getId(),
                'orderReleaseId' => $orderRelease->getId(),
            ],
            'payment_intent_data' => [
                'metadata' =>  [
                    'orderNo' => $orderRelease->order->getId(),
                    'orderReleaseId' => $orderRelease->getId(),
                    ],
                'setup_future_usage' => 'off_session',
            ],
            'success_url' => route('checkout.success', encrypt($orderRelease->getOrderId())),
            'cancel_url' => route('checkout.cancel', encrypt($orderRelease->getOrderId())),
        ]);

        return $session;
    }

    public function createPaymentSessionFromCustomer($order, $price)
    {
        $session = $this->client->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'customer_email' => $order->user->getEmail(),
            'line_items' => [
                [
                    'price' => $price,
                    'quantity' => 1,
                ],
            ],
            'mode' => 'payment',
            'metadata' => [
                'orderNo' => $order->getId(),
            ],
            'payment_intent_data' => [
                'metadata' =>  [
                    'orderNo' => $order->getId(),
                    ],
                'setup_future_usage' => 'off_session',
            ],
            'success_url' => route('checkout.success', encrypt($order->getId())),
            'cancel_url' => route('checkout.cancel', encrypt($order->getId())),
        ]);

        return $session;
    }
}
