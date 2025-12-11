<?php

namespace App\Http\Middleware;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class ApiAuthenticate extends Middleware
{
    /**
     * Nunca redireccionamos a login para APIs/MCP.
     */
    protected function redirectTo(Request $request): ?string
    {
        // Importante: devolvemos null para evitar redirects
        return null;
    }

    /**
     * Cuando la autenticación falla, SIEMPRE lanzamos excepción,
     * para que la maneje el handler y devuelva JSON 401.
     */
    protected function unauthenticated($request, array $guards)
    {
        throw new AuthenticationException(
            'Unauthenticated.', $guards
        );
    }
}
