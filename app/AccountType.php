<?php

namespace App;

enum AccountType: string
{
    case Guest = "guest";
    case Admin = "admin";
    case Staff = "staff";
}
