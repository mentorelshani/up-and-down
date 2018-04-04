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
use App\Models\Role_buildings;
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

Route::get('/getExistingAddresses','CityController@getExistingAddresses');
Route::get('/getCities','CityController@getCities');
Route::get('/getCompanies','CityController@getCompanies');
Route::get('/getNeighborhoods','CityController@getNeighborhoods');

Route::get('/getAllBuildings','BuildingController@getAllBuildings');
Route::post('/getBuildings1','BuildingController@index'); // new
Route::post('/addBuilding','BuildingController@add');
Route::get('/getBuilding/{id}','BuildingController@getBuilding');
Route::post('/updateBuilding','BuildingController@update');
Route::delete('/deleteBuilding/{id}','BuildingController@destroy');

Route::get('/getEntry/{id}','EntryController@getEntry');
Route::get('/getEntries/{building_id}','EntryController@getEntriesByBuilding');
Route::post('/getEntries','EntryController@getEntries');
Route::post('/getEntries1','EntryController@index');// new
Route::post('/addEntry','EntryController@add');
Route::post('/updateEntry','EntryController@update');
Route::delete('/deleteEntry/{id}','EntryController@destroy');

Route::get('/getElevators/{entry_id}','ElevatorController@getElevatorsByEntry');
Route::get('/getElevator/{id}','ElevatorController@getElevator');
Route::post('/addElevator','ElevatorController@add');
Route::post('/updateElevator','ElevatorController@update');
Route::delete('/deleteElevator/{id}','ElevatorController@destroy');

Route::get('/getVersions','VersionController@getVersions');
Route::post('/addVersion','VersionController@add');

Route::get('/getAccessPoint/{id}','AccessPointController@getAccessPoint');
Route::post('/addAccessPoint','AccessPointController@add');
Route::get('/getAccessPoints/{entry_id}','AccessPointController@getAccessPointsByEntry');
Route::get('/getAccessPointsByElevator/{elevator_id}','AccessPointController@getAccessPointsByElevator');
Route::post('/updateAccessPoint','AccessPointController@update');
Route::delete('/deleteAccessPoint/{id}','AccessPointController@destroy');
Route::post('cloneAccessPoint/{id}','AccessPointController@cloneAccessPoint');

Route::get('/getRelays/{access_point_id}','RelayController@getRelays');
Route::get('/getRelaysByElevatorId/{elevator_id}','RelayController@getRelaysByElevatorId');
Route::get('/getRelay/{access_point_id}/{relay}','RelayController@findRelay');
Route::get('/getRelay/{id}','RelayController@getRelay');
Route::post('/addRelay','RelayController@add');
Route::post('/updateRelay','RelayController@update');
Route::delete('/deleteRelay/{id}','RelayController@destroy');
Route::get('/getRelays/{access_point_id}/{card_id}','RelayController@getRelaysOfAccessPointForCard');
Route::post('updateCardAccess','RelayController@updateCardAccess');

Route::get('/getApartment/{id}','ApartmentController@getApartment');
Route::get('/getApartments/{entry_id}','ApartmentController@getApartmentsByEntry');
Route::post('/addApartment','ApartmentController@add');
Route::post('/updateApartment','ApartmentController@update');
Route::delete('/deleteApartment/{id}','ApartmentController@destroy');

Route::get('/getClient/{id}','ClientController@getClient');
Route::post('/getClients','ClientController@getClients');
Route::post('/getClients/{entry_id}','ClientController@getClientsByEntryId');
Route::get('/getClients/{entry_id}','ClientController@getClientsByEntryId1');
Route::post('/addClient','ClientController@add');
Route::post('/updateClient','ClientController@update');
Route::delete('/deleteClient/{id}','ClientController@destroy');

Route::get('/getPayment/{id}','PaymentController@getPayment');
Route::get('/getPayments/{entry_id}','PaymentController@getPaymentsByEntryId');
Route::post('/addPayment','PaymentController@add');
Route::post('/updatePayment','PaymentController@update');
Route::delete('/deletePayment/{id}','PaymentController@destroy');

Route::post('/getCards/{entry_id}','CardController@getCardsByEntry');
Route::get('/getCardAccess/{id}','CardController@getCardAccess');
Route::post('/addCard','CardController@add');
Route::post('/updateCard','CardController@update');
Route::delete('/deleteCard/{id}','CardController@destroy');
Route::post('updateCardAccess','CardController@updateCardAccess');
Route::post('/giveAccessToCard','CardController@giveAccess');
Route::delete('/deleteAccessFromCard/','CardController@deleteAccess');
Route::delete('/deleteAllAccessesFromCard/{card_id}','CardController@deleteAllAccesses');

Route::post('/getCheckIns/{access_point_id}','CheckInController@getCheckIns');
Route::post('/getMonitors/{access_point_id}','MonitorController@getMonitors');

Route::get('getUsers','UserController@index');
Route::post('addUser','UserController@add');

Route::get('getRoles','RoleController@getRoles');
Route::get('getRole/{id}','RoleController@getRole');
Route::get('getRoleBuildings/{role_id}','RoleController@getAccesses');
Route::post('addRole','RoleController@addRole');
Route::post('updateRole','RoleController@updateRole');
Route::delete('deleteAccessFromRole/{role_access_id}','RoleController@deleteAccessFromRole');
Route::post('giveAccessToBuildings','RoleController@giveAccessToRole');

Route::get('auth/user', function (){ return User::whereId(Auth::user()->id)->with('role.role_buildings','role.role_modules')->first();});
Route::post('addUser','UserController@store');
Route::get('getNrOfTotalPackets/{imei}','ListenerController@getNrOfTotalPackets');

Route::get('test1','RoleController@asd');

Route::post('test',function (Request $request){

    return $request->name . $request->name . "asd";
});
Route::get('test',function (){


//
//    $payment = new Payment();
//    $payment->product_id = 1;
//    $payment->client_id = 1;
//    $payment->price = 20.31;
////            $payment->paid = false;
//    $payment->save();
//
//    return $payment;


    $a = ["triumf","mentor","edison","fjolla","elbaroza"];

    return $a[rand(0,3)];

    $user = User::whereId(2)->with(['role.role_accesses'])->first();

    return $user;

    return dd(Auth::user()->role);

    $user = Auth::user()->role;
    $user->role_id = 2;
    $user->save();

    $ra = new Role_buildings();
    $ra->role_id = 2;
    $ra->building_id = 2;
    $ra->permission = "E";
    $ra->save();

//    $user = new User();
//    $user->email = "asd@asd.com";
//    $user->username = "asd";
//    $user->password = bcrypt("admin");
//    $user->gender = "M";
//    $user->created_by = 2;
//    $user->save();
//
//    return;//',1)->nullable();
//    $table->date('birthday')->nullable();
//    $table->integer('role_id')->nullable();
//    $table->integer('created_by')->nullable();
//    $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
//    $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');

    return Building::find(2);

    $url = 'http://twitter.com/statuses/user_timeline/16387631.json';

    $opts = array('http'=>array('header' => "User-Agent:MyAgent/1.0\r\n"));
//Basically adding headers to the request
    $context = stream_context_create($opts);
    $html = file_get_contents($url,false,$context);
    $html = htmlspecialchars($html);
    dd($html);
    //rss link for the twitter timeline
//dumps the content, you can manipulate as you wish to

        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        dd($data);

    dd($_GET['localhost:8000/getEntry/3']);

    $request = \Illuminate\Http\Request::create('localhost:8000/test1', 'POST', ['param1' => 'value1', 'param2' => 'value2']);
//    $request = Request::create('test1', 'GET');
    return $request;

    return "done";

    $request = Request::create('localhost:8000/test1', 'POST', array('id'=> 23));

    return;

    $apartment = new Apartment();
    $apartment->door_number = 12;
    $entry = Entry::find(2);
    $entry->apartments()->save($apartment);
    return $entry->apartments;

    $access_point = Access_point::find(2);
    $version = Version::find(2);
    $elevator = Elevator::find(3);
    $version->access_points()->attach($elevator);
    return count($version->access_points);

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