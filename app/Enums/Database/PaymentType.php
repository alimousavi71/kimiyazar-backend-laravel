<?php

namespace App\Enums\Database;

enum PaymentType: string
{
    case OnlineGateway = 'online_gateway';
    case BankDeposit = 'bank_deposit';
    case Wallet = 'wallet';
    case Pos = 'pos';
    case CashOnDelivery = 'cash_on_delivery';

    /**
     * Get all payment type values
     *
     * @return array
     */
    public static function values(): array
    {
        return array_map(fn($case) => $case->value, self::cases());
    }

    /**
     * Get human-readable label for the payment type
     *
     * @return string
     */
    public function label(): string
    {
        return match ($this) {
            self::OnlineGateway => 'Online Gateway',
            self::BankDeposit => 'Bank Deposit',
            self::Wallet => 'Wallet',
            self::Pos => 'POS',
            self::CashOnDelivery => 'Cash on Delivery',
        };
    }
}
