<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // 执行动作（业务逻辑 写在前面就是前置操作）
        $session = request()->session()->get('userinfo');
        // dd($session);
        if (empty($session)) {
            echo "<script>alert('请登录');location='/admin/login'</script>";
        }
        return $next($request);
    }
}
