<?php

namespace App\Mcp\Tools;

use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class GetUserFinancialSummaryTool extends Tool
{
    protected string $name = 'get-user-financial-summary';

    protected string $title = 'Obtener resumen financiero de usuario';

    protected string $description = 'Devuelve el resumen financiero (perfil, cuentas, totales) de un usuario por ID.';

    public function schema(JsonSchema $schema): array
    {
        return [
            'user_id' => $schema->integer()
                ->description('ID del usuario en la tabla users')
                ->required(),
        ];
    }

    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $user = User::with(['financialProfile', 'accounts.transactions'])
            ->findOrFail($validated['user_id']);

        $profile = $user->financialProfile;
        $accounts = $user->accounts;

        $summary = [
            'user' => [
                'id'      => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
                'segment' => $user->segment ?? null,
            ],
            'financial_profile' => [
                'monthly_income'   => $profile->monthly_income ?? null,
                'monthly_expenses' => $profile->monthly_expenses ?? null,
                'total_debt'       => $profile->total_debt ?? null,
                'credit_score'     => $profile->credit_score ?? null,
                'risk_level'       => $profile->risk_level ?? null,
            ],
            'accounts' => $accounts->map(function ($account) {
                return [
                    'id'       => $account->id,
                    'number'   => $account->account_number,
                    'type'     => $account->account_type,
                    'currency' => $account->currency,
                    'balance'  => $account->balance,
                ];
            })->toArray(),
        ];

        return Response::json($summary);
    }
}
