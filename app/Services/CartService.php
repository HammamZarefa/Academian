<?php

namespace App\Services;

class CartService
{

    public function setCart(array $data, string $cartType)
    {
        session()->put('cart_type', $cartType);
        session()->put('cart', $data);
        session()->put('paid_amount', 0);
        session()->put('unique_identifier', null);
    }

    public function getCart()
    {
        return session()->get('cart');
    }

    public function getCartType()
    {
        return session()->get('cart_type');
    }

    public function getTotal()
    {
        if ($this->isEmpty()) {
            return 0;
        }

        return $this->getCart()['cart_total'];
    }

    public function isEmpty()
    {
        return (empty(session()->get('cart'))) ? TRUE : FALSE;
    }

    public function getCurrency()
    {
        $currencyCode = settings('currency_code');
        return ($currencyCode) ? $currencyCode : 'USD';
    }

    public function destroy()
    {
        session()->forget('cart');
        session()->forget('cart_type');
        session()->forget('paid_amount');
        session()->forget('unique_identifier');
    }

    public function setPaymentComplete($total, $uniqueStringToIdentifyPayment)
    {
        session()->put('paid_amount', $total);
        session()->put('unique_identifier', $uniqueStringToIdentifyPayment);
    }

    public function isPaymentComplete($tokenToIdentifyPayment)
    {
        if (session()->get('unique_identifier') == $tokenToIdentifyPayment) {
            return true;
        }
    }
}
