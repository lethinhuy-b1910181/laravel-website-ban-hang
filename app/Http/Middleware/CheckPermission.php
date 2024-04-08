<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckPermission
{
    public function handle($request, Closure $next, ...$permissions)
    {
        $admin = Auth::guard('admin')->user();

        if ($admin && ($admin->hasPermission($permissions) || $admin->isSuperAdmin())) {
            return $next($request);
        }

        abort(403, 'Bạn không có quyền truy cập vào trang này.');
    }
}
