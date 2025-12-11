<?php

namespace App\Mcp\Tools;

use App\Models\User;
use Illuminate\Contracts\JsonSchema\JsonSchema;
use Laravel\Mcp\Request;
use Laravel\Mcp\Response;
use Laravel\Mcp\Server\Tool;

class ListUserAccountsTool extends Tool
{
    protected string $name = 'list-user-accounts';

    protected string $title = 'Listar cuentas de usuario';

    protected string $description = 'Devuelve la lista de cuentas asociadas a un usuario por su ID.';

    /**
     * Esquema de entrada que ve el LLM / cliente MCP.
     */
    public function schema(JsonSchema $schema): array
    {
        return [
            'user_id' => $schema->integer()
                ->description('ID del usuario en la tabla users')
                ->required(),
        ];
    }

    /**
     * Lógica del tool.
     */
    public function handle(Request $request): Response
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
        ]);

        $user = User::with('accounts')->findOrFail($validated['user_id']);

        $accounts = $user->accounts->map(function ($account) {
            return [
                'id'            => $account->id,
                'account_number'=> $account->account_number,
                'account_type'  => $account->account_type,
                'currency'      => $account->currency,
                'balance'       => $account->balance,
                'created_at'    => $account->created_at?->toIso8601String(),
            ];
        })->toArray();

        return Response::json([
            'user' => [
                'id'      => $user->id,
                'name'    => $user->name,
                'email'   => $user->email,
                'segment' => $user->segment ?? null,
            ],
            'accounts' => $accounts,
        ]);
    }
}
