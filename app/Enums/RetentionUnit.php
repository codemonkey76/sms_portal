<?php

namespace App\Enums;

enum RetentionUnit: string
{
    case Days = 'days';
    case Weeks = 'weeks';
    case Months = 'months';
    case Years = 'years';
}
