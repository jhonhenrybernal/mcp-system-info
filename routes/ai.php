<?php

use App\Mcp\Servers\FinanceSystemServer;
use Laravel\Mcp\Facades\Mcp;

Mcp::web('/mcp/finance-system', FinanceSystemServer::class)->middleware('auth:sanctum');
