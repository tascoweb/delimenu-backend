<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Multitenancy\Models\Tenant;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserBelongsToTenant
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {

        $user = $request->user();
        $currentTenant = Tenant::current();
        if($currentTenant && $user && ($user->tenant_id !== $currentTenant->id)) {
            abort(403, 'Access denied');
        }
        return $next($request);
    }
}
