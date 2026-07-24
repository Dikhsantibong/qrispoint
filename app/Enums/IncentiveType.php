<?php

namespace App\Enums;

enum IncentiveType: string
{
    case FirstTx = 'first_tx';
    case Activation = 'activation';
}
