<?php

namespace App;

enum RegistrationSource: string
{
    case Self = 'self';
    case Admin = 'admin';
    case Staff = 'staff';
}
