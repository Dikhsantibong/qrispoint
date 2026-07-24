<?php

namespace App\Enums;

enum MerchantStatus: string
{
    case Baru = 'baru';
    case Mencoba = 'mencoba';
    case Hampir = 'hampir';
    case Rutin = 'rutin';

    public function label(): string
    {
        return match ($this) {
            self::Baru => 'Baru',
            self::Mencoba => 'Mencoba',
            self::Hampir => 'Hampir Rutin',
            self::Rutin => 'Rutin',
        };
    }
}
