<?php

namespace App\Http\Controllers;

use App\Models\Airport;
use Illuminate\Http\Request;

class MescController extends Controller
{


    public function searchAirports()
    {
        $search_by = request('search');
        if($search_by){
            $results = ['results'=>Airport::findAirport($search_by)];
            return response()->json($results);
        }
    }
}
