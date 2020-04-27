<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\InvoicePaid;
use App\User;

class NotificationController extends Controller
{
    public function create(Request $request) {


    	$data = $request->validate([
            'body' => 'required'
        ]);

    	$user = User::findOrFail("1");
        $user->notify(new InvoicePaid($data['body']));
    	
    	return \Response::json(['message' => 'Successfully create notification!'], 201);

    }

    public function read($id) {

    	$user = User::findOrFail($id);
    	$user->unreadNotifications->markAsRead();
    	return \Response::json(['message' => 'Successfully read all notifications!'], 200);
    }
}
