<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Version;

class VersionController extends Controller
{
    public function getVersions(){
        return Version::get();
    }
}
