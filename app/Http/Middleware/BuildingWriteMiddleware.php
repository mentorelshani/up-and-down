<?php

namespace App\Http\Middleware;

use Closure;

class BuildingWriteMiddleware
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

        $id = $request->all()['id'];
        $role_buildings = Auth::user()->role->role_buildings;

        foreach ($role_buildings as $role_building)
            if($role_building->building_id == $id && $role_building->write == true)
                return $next($request);

        return redirect('/home');
    }
}
