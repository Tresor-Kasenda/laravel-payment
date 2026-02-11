<?php

namespace App\Services;

class PaymentOptions
{
    public static function countryCodes(): array
    {
        return [
            ['label' => 'République démocratique du Congo', 'value' => '+243'],
            ['label' => 'Ouganda', 'value' => '+256'],
            ['label' => 'Kenya', 'value' => '+254'],
        ];
    }

    public static function planOptions(): array
    {
        return [
            ['label' => 'Mensuel Premium', 'value' => 'Mensuel Premium', 'amount' => 3000],
            ['label' => 'Soutien durable', 'value' => 'Soutien durable', 'amount' => 4500],
            ['label' => 'Accès illimité', 'value' => 'Accès illimité', 'amount' => 7000],
        ];
    }
}
