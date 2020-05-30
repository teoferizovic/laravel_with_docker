<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Mechanic;

class MechanicController extends Controller
{
     public function index(Request $request, $id=null){
     	//$mechanic = Mechanic::find(1)->carOwner;
     	$mechanics = Mechanic::with(['car.owner:id,name,car_id'])->get();
     	
     	//return Mechanic::all();
     	//return $mechanics->toArray();
     	//return response()->json(['message' => 'Not Found!'], 404);
     	return \Response::json($mechanics,200);
     }
}
