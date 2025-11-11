<?php

namespace App\Http\Middleware;

use App\Models\SystemLog;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LogUserActions
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        try {
            if (auth()->check()) {
                $routeName = $request->route()?->getName() ?? '';
                $path = $request->path();
                $method = $request->method();

                $isExport = str_contains($routeName, 'export.csv') || str_contains($path, '/export/csv');
                $isPrint = str_contains($routeName, 'export.print') || str_contains($path, '/export/print');

                $action = match (true) {
                    $isExport => 'Exportar CSV',
                    $isPrint => 'Imprimir',
                    $method === 'POST' => 'Criar',
                    $method === 'PUT' || $method === 'PATCH' => 'Atualizar',
                    $method === 'DELETE' => 'Excluir',
                    default => 'Acesso',
                };

                // Captura filtros (query string), removendo chaves sensíveis
                $filtersArray = $request->query();
                foreach (['_token','_method','password','password_confirmation'] as $key) {
                    if (array_key_exists($key, $filtersArray)) {
                        unset($filtersArray[$key]);
                    }
                }
                $filtersJson = empty($filtersArray) ? null : json_encode($filtersArray, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);

                SystemLog::create([
                    'user_id' => auth()->id(),
                    'action' => $action,
                    'page' => $routeName !== '' ? $routeName : $path,
                    'filters' => $filtersJson,
                    'is_export' => $isExport,
                    'is_print' => $isPrint,
                ]);
            }
        } catch (\Throwable $e) {
            // Não interrompe a requisição caso haja erro de log
        }

        return $response;
    }
}