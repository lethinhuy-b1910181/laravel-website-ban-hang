<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;

class User
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        // Kiểm tra xem người dùng có phải là quản trị viên không
        if (!Auth::guard('customer')->check() ) {
         
            return redirect()->route('login'); // Hoặc thực hiện xử lý khác
        }

        // Nếu là quản trị viên, tiếp tục thực thi request
        return $next($request);
    }
}
