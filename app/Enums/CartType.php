<?php

namespace App\Enums;

abstract class CartType
{
    const NewOrder 		= 'new_order';
    const WalletTopUp 	= 'wallet_top_up';
    const SubscriptionCart 	= 'subscription';
    const ServiceSubscription='service subscription';

}

