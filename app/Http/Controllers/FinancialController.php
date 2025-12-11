<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\User;

class FinancialController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/system/users",
     *     tags={"Users"},
     *     summary="Lista de usuarios del sistema financiero",
     *     security={{"BearerAuth":{}}},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de usuarios",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(property="id", type="integer", example=1),
     *                 @OA\Property(property="name", type="string", example="Juan Pérez"),
     *                 @OA\Property(property="email", type="string", example="juan@example.com")
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function listUsers()
    {
        return User::select('id', 'name', 'email', 'document_number', 'segment')->paginate(10);
    }

    /**
     * @OA\Get(
     *     path="/api/system/users/{id}",
     *     tags={"Users"},
     *     summary="Detalle de un usuario por ID",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Usuario encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function userDetail($id)
    {
        $user = User::with('financialProfile')->findOrFail($id);

        return $user;
    }

    /**
     * @OA\Get(
     *     path="/api/system/users/{id}/accounts",
     *     tags={"Accounts"},
     *     summary="Listar cuentas de un usuario",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de cuentas",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Account")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function userAccounts($id)
    {
        $user = User::findOrFail($id);

        return $user->accounts()->get();
    }

    /**
     * @OA\Get(
     *     path="/api/system/accounts/{accountId}/transactions",
     *     tags={"Accounts"},
     *     summary="Transacciones de una cuenta",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="accountId",
     *         in="path",
     *         required=true,
     *         description="ID de la cuenta",
     *         @OA\Schema(type="integer", example=10)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Lista de transacciones",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Transaction")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Cuenta no encontrada"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function accountTransactions($accountId)
    {
        $account = Account::findOrFail($accountId);

        return $account->transactions()
            ->orderByDesc('posted_at')
            ->limit(50)
            ->get();
    }

    /**
     * @OA\Get(
     *     path="/api/system/users/{id}/financial-summary",
     *     tags={"Summary"},
     *     summary="Resumen financiero de un usuario",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID del usuario",
     *         @OA\Schema(type="integer", example=1)
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Resumen financiero",
     *         @OA\JsonContent(ref="#/components/schemas/FinancialSummary")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Usuario no encontrado"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="No autorizado"
     *     )
     * )
     */
    public function userFinancialSummary($id)
    {
        $user = User::with(['financialProfile', 'accounts'])->findOrFail($id);

        $profile = $user->financialProfile;
        $accounts = $user->accounts;

        return [
            'user'      => $user->only(['id', 'name', 'email', 'document_number', 'segment']),
            'profile'   => $profile,
            'accounts'  => $accounts->map(function ($acc) {
                return [
                    'id'            => $acc->id,
                    'account_number'=> $acc->account_number,
                    'account_type'  => $acc->account_type,
                    'currency'      => $acc->currency,
                    'balance'       => $acc->balance,
                ];
            }),
        ];
    }
}
