<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendEmailMailable;
use App\Jobs\SendEmailJob;

class EmailController extends Controller
{
    public function create(Request $request) {
    	
    	$data = $request->validate([
            'body' => 'required'
        ]);

        SendEmailJob::dispatch($data['body'])->delay(now()->addSeconds(10));
        
        return \Response::json(['message' => 'Successfully sent message!'], 201);
    }
}
