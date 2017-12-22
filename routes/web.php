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
Route::post('/addBuilding','BuildingController@add');
Route::get('/getBuilding/{id}','BuildingController@getBuilding');
Route::post('/updateBuilding','BuildingController@update');
Route::delete('/deleteBuilding/{id}','BuildingController@destroy');

Route::get('getEntry/{id}','EntryController@getEntry');
Route::post('getEntries','EntryController@getEntries');
Route::post('addEntry','EntryController@add');
Route::post('updateEntry','EntryController@update');
Route::delete('deleteEntry/{id}','EntryController@destroy');

Route::get('getElevators/{entry_id}','ElevatorController@getElevatorsByEntry');
Route::post('addElevator','ElevatorController@add');

Route::get('getVersions','VersionController@getVersions');

Route::post('addAccessPoint','AccessPointController@add');
Route::get('getAccessPoints/{entry_id}','AccessPointController@getAccessPointsByEntry');
Route::post('updateAccessPoint','AccessPointController@update');
Route::delete('/deleteAccessPoint/{id}','AccessPointController@destroy');

Route::get('getRelays/{access_point_id}','RelayController@getRelays');
Route::get('getRelay/{id}','RelayController@getRelay');
Route::post('addRelay','RelayController@add');
Route::post('updateRelay','RelayController@update');
Route::delete('deleteRelay/{id}','RelayController@destroy');

Route::get('getApartments/{entry_id}','ApartmentController@getApartmentsByEntry');
Route::post('addApartment','ApartmentController@add');

Route::get('getClient/{id}','ClientController@getClient');
Route::post('getClients','ClientController@getClients');
Route::get('getClients/{entry_id}','ClientController@getClientsByEntryId');
Route::post('addClient','ClientController@add');
Route::post('updateClient','ClientController@update');
Route::delete('deleteClient/{id}','ClientController@destroy');

Route::get('test',function (){

//    return Auth::user()->id;
//    return Building::find(2)->creator->id;
//    return Building::get();
//    return $a->buildings()->with('address')->get();

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