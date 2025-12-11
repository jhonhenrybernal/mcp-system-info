<?php

namespace App\Mcp\Servers;

use App\Mcp\Tools\GetUserFinancialSummaryTool;
use App\Mcp\Tools\ListUserAccountsTool;
use App\Mcp\Tools\GetAccountTransactionsTool;
use Laravel\Mcp\Server;

class FinanceSystemServer extends Server
{
    protected string $name = 'Finance System Server';

    protected string $version = '0.0.1';

    protected string $instructions = <<<'MARKDOWN'
Eres un servidor MCP que expone información financiera ficticia para demos.
Usa los tools para obtener resúmenes financieros, listar cuentas y ver transacciones.
MARKDOWN;

    /**
     * Tools MCP disponibles.
     *
     * @var array<int, class-string<\Laravel\Mcp\Server\Tool>>
     */
    protected array $tools = [
        GetUserFinancialSummaryTool::class,
        ListUserAccountsTool::class,
        GetAccountTransactionsTool::class,
    ];

    protected array $resources = [
        //
    ];

    protected array $prompts = [
        //
    ];
}
