<?php

namespace App\Http\Controllers;

use App\Http\Requests\addApartmentRequest;
use App\Http\Requests\updateApartmentRequest;
use Illuminate\Http\Request;
use App\Models\Apartment;
use App\Http\Services\ApartmentService;

class ApartmentController extends Controller
{
    private $apartmentService;

    public function __construct(ApartmentService $apartmentService){

        $this->apartmentService = $apartmentService;
    }

    public function getApartment($id){

        return Apartment::find($id);
    }

    public function getApartmentsByEntry($entry_id){

        return Apartment::where('entry_id',$entry_id)->get();
    }

    public function add(addApartmentRequest $request){

        $apartment = new Apartment();

        $this->apartmentService->add($request, $apartment);

        return $apartment;
    }

    public function update(updateApartmentRequest $request){

        $apartment = Apartment::find($request->id);

        $this->apartmentService->update($request, $apartment);

        return $apartment;
    }

    public function destroy($id){

        $a = Apartment::find($id);

        if ($a != null) {
            $a->delete();
            return "u fshi";
        }
        return "Nuk ekziston";
    }
}
