<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class SuperAdminCheck
{
    public function handle($request, Closure $next)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin && $admin->isSuperAdmin()) {
            return $next($request);
        }

        abort(403, 'Bạn không có quyền truy cập vào trang này.');
    }
}
