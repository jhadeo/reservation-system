<?php

namespace App;

enum AccountType: string
{
    case Client = "client";
    case Admin = "admin";
    case Staff = "staff";
}
