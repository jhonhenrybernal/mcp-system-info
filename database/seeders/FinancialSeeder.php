<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserFinancialProfile;
use App\Models\Account;
use App\Models\Transaction;
use Illuminate\Support\Str;


class FinancialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();

        foreach (range(1, 10) as $i) {
            $user = User::factory()->create([
                'name'            => $faker->name,
                'email'           => $faker->unique()->safeEmail,
                'document_number' => $faker->unique()->numerify('##########'),
                'segment'         => $faker->randomElement(['retail', 'pyme', 'corporate']),
                'date_of_birth'   => $faker->date(),
            ]);

            $income   = $faker->numberBetween(2_000, 15_000);
            $expenses = $faker->numberBetween(1_000, $income);
            $debt     = $faker->numberBetween(0, 50_000);

            UserFinancialProfile::create([
                'user_id'          => $user->id,
                'monthly_income'   => $income,
                'monthly_expenses' => $expenses,
                'total_debt'       => $debt,
                'credit_score'     => $faker->numberBetween(300, 900),
                'risk_level'       => $faker->randomElement(['low', 'medium', 'high']),
                'last_updated_at'  => now()->subDays(rand(0, 30)),
            ]);

            foreach (range(1, rand(1, 3)) as $j) {
                $account = Account::create([
                    'user_id'       => $user->id,
                    'account_number'=> strtoupper(Str::random(10)),
                    'account_type'  => $faker->randomElement(['checking', 'savings', 'credit-card', 'loan']),
                    'currency'      => 'USD',
                    'balance'       => $faker->randomFloat(2, -2000, 50000),
                ]);

                foreach (range(1, rand(10, 30)) as $k) {
                    $direction = $faker->randomElement(['debit', 'credit']);
                    $amount    = $faker->randomFloat(2, 5, 2000);

                    Transaction::create([
                        'account_id' => $account->id,
                        'posted_at'  => $faker->dateTimeBetween('-90 days', 'now'),
                        'description'=> $faker->sentence(3),
                        'category'   => $faker->randomElement([
                            'salary', 'rent', 'groceries', 'shopping', 'fees', 'transfer',
                        ]),
                        'direction'  => $direction,
                        'amount'     => $amount,
                    ]);
                }
            }
        }
    }
}
