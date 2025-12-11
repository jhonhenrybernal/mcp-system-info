<?php

namespace App\Swagger;

/**
 * @OA\Info(
 *     title="MCP Finance System API",
 *     version="1.0.0",
 *     description="API demo financiera construida en Laravel 12, protegida con Sanctum y consumida por un servidor MCP."
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8002",
 *     description="Servidor local de desarrollo"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="Token",
 *     description="Token de Laravel Sanctum. Enviar como: Bearer {token}"
 * )
 *
 * @OA\Schema(
 *     schema="User",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="name", type="string", example="Juan Pérez"),
 *     @OA\Property(property="email", type="string", example="juan@example.com"),
 *     @OA\Property(property="created_at", type="string", format="date-time"),
 *     @OA\Property(property="updated_at", type="string", format="date-time")
 * )
 *
 * @OA\Schema(
 *     schema="Account",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=10),
 *     @OA\Property(property="user_id", type="integer", example=1),
 *     @OA\Property(property="account_number", type="string", example="1234567890"),
 *     @OA\Property(property="account_type", type="string", example="savings"),
 *     @OA\Property(property="currency", type="string", example="COP"),
 *     @OA\Property(property="balance", type="number", format="float", example=1500000.75)
 * )
 *
 * @OA\Schema(
 *     schema="Transaction",
 *     type="object",
 *     @OA\Property(property="id", type="integer", example=100),
 *     @OA\Property(property="account_id", type="integer", example=10),
 *     @OA\Property(property="posted_at", type="string", format="date-time", example="2025-02-01T09:30:00Z"),
 *     @OA\Property(property="description", type="string", example="Pago supermercado"),
 *     @OA\Property(property="category", type="string", example="groceries"),
 *     @OA\Property(property="direction", type="string", example="debit"),
 *     @OA\Property(property="amount", type="number", format="float", example=250000.00)
 * )
 *
 * @OA\Schema(
 *     schema="FinancialSummary",
 *     type="object",
 *     @OA\Property(property="user", ref="#/components/schemas/User"),
 *     @OA\Property(
 *         property="accounts",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Account")
 *     ),
 *     @OA\Property(
 *         property="totals",
 *         type="object",
 *         @OA\Property(property="total_balance", type="number", format="float", example=3500000.50),
 *         @OA\Property(property="total_income", type="number", format="float", example=5000000.00),
 *         @OA\Property(property="total_expense", type="number", format="float", example=1500000.50),
 *         @OA\Property(property="period", type="string", example="2025-01")
 *     )
 * )
 */
class OpenApi
{
    // Vacío: sólo se usa para agrupar anotaciones
}
