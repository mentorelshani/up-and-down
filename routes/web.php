<?php
use Illuminate\Database\Seeder;
use Illuminate\Http\Request;
use App\Models\Access_point; 
use App\Models\Address; 
use App\Models\Apartment; 
use App\Models\Building; 
use App\Models\Card; 
use App\Models\Card_access; 
use App\Models\Check_in; 
use App\Models\City; 
use App\Models\Client; 
use App\Models\Elevator; 
use App\Models\Entry; 
use App\Models\Invalid_check_in; 
use App\Models\Monitor; 
use App\Models\Payment; 
use App\Models\Product; 
use App\Models\Relay; 
use App\Models\Role_Access;
use App\Models\Role;
use App\Models\Version;  
use App\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::post('/getBuildings','BuildingController@getBuildings');
Route::get('/getExistingAddresses','BuildingController@getExistingAddresses');
Route::post('/getBuildings','BuildingController@getBuildings');
Route::post('/addBuilding','BuildingController@addBuilding');
Route::get('/getBuilding/{id}','BuildingController@getBuilding');
Route::post('/updateBuilding','BuildingController@updateBuilding');
Route::delete('/deleteBuilding/{id}','BuildingController@destroy');

Route::post('getEntries','EntryController@getEntries');
Route::post('addEntry','EntryController@addEntry');
Route::post('updateEntry','EntryController@updateEntry');
Route::delete('deleteEntry/{id}','EntryController@destroy');

Route::post('addApartment','ApartmentController@addApartment');

Route::post('addElevator','ElevatorController@addElevator');

Route::get('getVersions','VersionController@getVersions');

Route::post('addAccessPoint','AccessPointController@addAccessPoint');

Route::post('addRelays','RelayController@addRelays');

Route::get('test',function (){
    $a = User::find(3);
//    return Auth::user()->id;

//    return Building::find(2)->creator->id;
    return Building::get();
    return $a->buildings()->with('address')->get();

});


// LOGIN ROUTES
Route::get('login', ['as' => 'login', 'uses' => 'AuthController@showLoginForm']);
Route::post('login', ['as' => 'login.post', 'uses' => 'AuthController@authenticate']);
Route::get('logout', ['as' => 'logout', 'uses' => 'AuthController@logout']);






// ADMIN ROUTES
Route::group(['middleware' => ['auth']], function () {
    
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    });
    //Users
    Route::get('admin/api/users', 'UserController@index');
    Route::get('admin/api/users/{id}', 'UserController@show');
    Route::post('admin/api/users/post', 'UserController@store');
    Route::put('admin/api/users/update/{id}', 'UserController@update');
    Route::delete('admin/api/users/delete/{id}', 'UserController@destroy');
});



// Vue js route logic
Route::get('/{vue_capture?}', function () {
    $user = \Auth::user();
    if($user!= null){
        return redirect('admin/dashboard');
    }
    else{
        return redirect('login');
    }
})->where('vue_capture','[\/\w\.-]*');
// WEBSITE ROUTES
//Route::get('/{vue_capture?}', function () {
//    return view('index');
//})->where('vue_capture', '[\/\w\.-]*');
// Auth::ro