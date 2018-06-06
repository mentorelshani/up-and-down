<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function index(){
        return Module::get();
    }

    public function addModule(Request $request){

        $name = $request->name;

        $module = new Module();
        $module->name = $name;
        $module->url = str_replace(' ', '-',strtolower($name));
        $module->icon = $module->url;
        $module->save();

        return $module;
    }
}
