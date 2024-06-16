<?php

namespace App\Services\Models\User\Railway;

use App\Models\User\Railway\UserRailwayHubPublicity;

class UserRailwayHubPublicityAction
{
    public function __construct(private ?UserRailwayHubPublicity $publicity = null)
    {
    }

    public function getBaremeOfInvest(int|float $invest)
    {
        switch ($invest) {
            case $invest <= 10000: return 6;
            case $invest > 10000 && $invest <= 50000: return 7;
            case $invest > 50000 && $invest <= 100000: return 8;
            case $invest > 100000 && $invest <= 200000: return 9;
            case $invest > 200000 && $invest <= 500000: return 10;
            case $invest > 500000: return 15;
        }
    }

    public function getSlotOfInvest(int|float $invest)
    {
        switch ($invest) {
            case $invest <= 10000: return 5;
            case $invest > 10000 && $invest <= 50000: return 10;
            case $invest > 50000 && $invest <= 100000: return 15;
            case $invest > 100000 && $invest <= 200000: return 20;
            case $invest > 200000 && $invest <= 500000: return 25;
            case $invest > 500000: return 30;
        }
    }
}
