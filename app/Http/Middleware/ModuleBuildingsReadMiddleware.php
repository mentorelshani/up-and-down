<?php

namespace App\Http\Middleware;

use Closure;

class ModuleBuildingsReadMiddleware
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
        $role_modules = \Auth::user()->role->role_modules;

        foreach ($role_modules as $role_module)
            if($role_module->module->name== "Buildings" && $role_module->read == true)
                return $next($request);

        return redirect('/home');
    }
}
