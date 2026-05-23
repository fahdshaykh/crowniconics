<?php

namespace App\Http\Controllers;

use Nnjeim\World\Models\City;
use Nnjeim\World\Models\State;

class LocationController extends Controller
{
    public function getStates($countryId)
    {
        $states = State::where('country_id', $countryId)->get();
        return response()->json($states);
    }

    public function getCities($stateId)
    {
        $cities = City::where('state_id', $stateId)->get();
        return response()->json($cities);
    }

    public function getCitiesByCountry($countryId)
    {
        $cities = City::where('country_id', $countryId)->get();
        return response()->json($cities);
    }
    
}
