<?php

namespace App\Mcp\Tools;

use App\Models\Account;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class GetAccountTransactionsTool extends Tool
{
    protected string $name = 'get-account-transactions';

    protected string $title = 'Obtener transacciones de una cuenta';

    protected string $description = 'Devuelve las últimas transacciones de una cuenta por ID.';

    /**
     * Esquema de entrada.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'account_id' => $schema->integer()
                ->description('ID de la cuenta en la tabla accounts')
                ->required(),

            'limit' => $schema->integer()
                ->description('Cantidad máxima de transacciones a devolver (por defecto 20)')
                ->default(20),
        ];
    }

    /**
     * Lógica del tool.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'account_id' => 'required|integer|exists:accounts,id',
            'limit'      => 'nullable|integer|min:1|max:100',
        ]);

        $account = Account::findOrFail($validated['account_id']);

        $limit = $validated['limit'] ?? 20;

        $transactions = $account->transactions()
            ->orderByDesc('posted_at')
            ->limit($limit)
            ->get()
            ->map(function ($tx) {
                return [
                    'id'          => $tx->id,
                    'posted_at'   => $tx->posted_at?->toIso8601String(),
                    'description' => $tx->description,
                    'category'    => $tx->category,
                    'direction'   => $tx->direction,
                    'amount'      => $tx->amount,
                ];
            })->toArray();

        return Response::json([
            'account' => [
                'id'            => $account->id,
                'account_number'=> $account->account_number,
                'account_type'  => $account->account_type,
                'currency'      => $account->currency,
                'balance'       => $account->balance,
            ],
            'transactions' => $transactions,
        ]);
    }
}
