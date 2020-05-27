<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Redis;
use Cache;

class CountryController extends Controller
{
    public function index() {
     	return view('countries.search');
    }

    public function fetch(Request $request) {

    	if($request->get('query')) {
		      
		      $query = $request->get('query');
		      
		      $data = DB::table('countries')
		        ->where('name', 'LIKE', "%{$query}%")
		        ->get();
		      $output = '<ul class="dropdown-menu" style="display:block; position:relative">';

		      foreach($data as $row) {
			       $output .= '
			       <li><a href="https://www.google.com" target="_blank">'.$row->name.'</a></li>
			       ';
		      }

		      $output .= '</ul>';
		      return $output;
     	} 

    }

    public function fetchAll(Request $request) {
    	
		$results = Cache::remember('countries', 360,function () {
		    return  DB::table('countries')->get();
		});
    	
	    return \Response::json($results,200);
		
    }

    public function getCache() {
    	//Cache::forget('countries');
    	Redis::set("test","John Doe");
    	//example of pipeline
    	Redis::pipeline(function ($pipe) {
		    for ($i = 0; $i < 2; $i++) {
		        $pipe->set("key:$i", $i);
		    }
		});
		
    	return \Response::json(Redis::get('test'), 200);
    	
    }
}
