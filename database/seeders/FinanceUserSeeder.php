<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\FinancialProfile;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class FinanceUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1) Usuario fijo de pruebas
        $user = User::firstOrCreate(
            ['email' => 'demo.finance@example.com'], // clave única
            [
                'name'     => 'Usuario Demo Finanzas',
                'password' => Hash::make('Demo1234!'), // contraseña conocida
            ]
        );

        // 2) Perfil financiero (ajusta al nombre real de tu modelo/tabla)
        if (class_exists(FinancialProfile::class)) {
            FinancialProfile::firstOrCreate(
                ['user_id' => $user->id],
                [
                    'risk_level'         => 'moderate',
                    'monthly_income'     => 5_000_000,
                    'monthly_expenses'   => 3_000_000,
                    'credit_score'       => 760,
                    'preferred_currency' => 'COP',
                ]
            );
        }

        // 3) Cuentas bancarias de este usuario
        if (class_exists(Account::class)) {
            $mainAccount = Account::firstOrCreate(
                [
                    'user_id'        => $user->id,
                    'account_number' => '000123456789',
                ],
                [
                    'account_type' => 'savings',
                    'currency'     => 'COP',
                    'balance'      => 3_500_000,
                ]
            );

            $creditCard = Account::firstOrCreate(
                [
                    'user_id'        => $user->id,
                    'account_number' => '411111******1111',
                ],
                [
                    'account_type' => 'credit_card',
                    'currency'     => 'COP',
                    'balance'      => -1_200_000,
                ]
            );

            // 4) Transacciones de ejemplo (si tienes modelo Transaction)
            if (class_exists(Transaction::class)) {
                Transaction::firstOrCreate(
                    [
                        'account_id'  => $mainAccount->id,
                        'description' => 'Nómina empresa Demo S.A.S',
                        'posted_at'   => now()->subDays(3),
                        'amount'      => 5_000_000,
                    ],
                    [
                        'category'  => 'income',
                        'direction' => 'credit',
                    ]
                );

                Transaction::firstOrCreate(
                    [
                        'account_id'  => $mainAccount->id,
                        'description' => 'Pago supermercado',
                        'posted_at'   => now()->subDays(2),
                        'amount'      => 350_000,
                    ],
                    [
                        'category'  => 'groceries',
                        'direction' => 'debit',
                    ]
                );

                Transaction::firstOrCreate(
                    [
                        'account_id'  => $creditCard->id,
                        'description' => 'Compra en tienda electrónica',
                        'posted_at'   => now()->subDays(5),
                        'amount'      => 800_000,
                    ],
                    [
                        'category'  => 'electronics',
                        'direction' => 'debit',
                    ]
                );
            }
        }
    }
}
