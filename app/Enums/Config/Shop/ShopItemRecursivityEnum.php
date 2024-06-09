<?php

namespace App\Enums\Config\Shop;

enum ShopItemRecursivityEnum: string
{
    case DAILY = 'daily';
    case WEEKLY = 'weekly';
    case MONTHLY = 'monthly';
    case YEARLY = 'yearly';
}
