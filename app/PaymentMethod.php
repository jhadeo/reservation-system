<?php

namespace App;

enum PaymentMethod : string
{
    case Cash = 'cash';
    case Card = 'card';
    case EWallet = 'e-wallet'; 
}
