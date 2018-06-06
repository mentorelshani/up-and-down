<?php

namespace App\Http\Middleware;

use Closure;

class BuildingDeleteMiddleware
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
        $id = $request->route()->parameters()['id'];
        $role_buildings = \Auth::user()->role->role_buildings;

        foreach ($role_buildings as $role_building)
            if($role_building->building_id == $id && $role_building->read == true)
                return $next($request);

        return redirect('/home');
    }
}
