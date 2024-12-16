<?php

namespace App\Enum;

enum ProductType: string
{
    case ARTWORK = 'artwork';
    case VINYL = 'vinyl';
    case MERCH = 'merch';
}
