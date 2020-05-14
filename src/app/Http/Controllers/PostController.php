<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Post;
use Illuminate\Pipeline\Pipeline;
use App\QueryFilters\Active;
use App\QueryFilters\Sort;

class PostController extends Controller
{
    public function index(Request $request, $id=null){
    	
    	if ($id != null) {
    		$post = Post::find($id);
            return \Response::json($post,200);
    	}
        
    	$posts = app(Pipeline::class)
            ->send(Post::all())
            ->through([
                Active::class,
                Sort::class
            ])
            ->thenReturn();
        
        return \Response::json($posts,200);

    }

    public function create(Request $request){
    	
    	$input = $request->all();
    	
    	$post = new Post();
    	$post->first_name = $input['firstName'];
    	$post->last_name = $input['lastName'];
    	$post->save();

    	return \Response::json(['message' => 'Successfully saved item!'], 201);
    }

    public function update($id,Request $request){
    	
    	$input = $request->all();
    	$post = Post::find($id);

    	if (empty($post)) {
    		return \Response::json(['message' => 'Not found!'], 404);
    	}

    	$post->first_name = $input['firstName'];
    	$post->last_name = $input['lastName'];
    	$post->save();
    	
    	return \Response::json(['message' => 'Successfully updated item!'], 200);
    }

    public function delete($id){
    	
    	Post::where('id', $id)->delete();
    	
    	return \Response::json(['message' => 'Successfully deleted item!'], 200);
    }
}
