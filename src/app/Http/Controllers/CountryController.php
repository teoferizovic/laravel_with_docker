<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Redis;

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
    	
    	$countries = DB::table('countries')->get();
	    return \Response::json($countries,200);
		
    }

    public function getCache() {

    	Redis::set("test","John Doe");
    	return \Response::json(Redis::get('test'), 200);
    	
    }
}
