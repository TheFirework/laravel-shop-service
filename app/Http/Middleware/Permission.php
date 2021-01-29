<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Cache;

class Permission
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $exclude = ['manage/auth/logout', 'manage/auth/me', 'manage/auth/menu', 'manage/auth/permmenu', 'manage/auth/refresh', 'manage/upload'];
        $path = $request->path();

        if (in_array($path, $exclude)) {
            return $next($request);
        }

        $user = auth('manage')->user();

        if ($user['role_id'] === 1) {
            return $next($request);
        }

        $premsKey = 'perms-' . $user['role_id'];
        $perms = Cache::get($premsKey);


        $collection = collect($perms)->filter(function ($item) use ($path) {
            return strpos($path, $item) !== false;
        });


        if ($collection->count() === 0) {
            return response()->json(['code' => 403, 'data' => [], 'message' => '无权限，请联系管理员']);
        }

        return $next($request);
    }
}
