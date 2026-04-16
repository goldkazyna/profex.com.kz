<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string|max:5000',
        ]);

        Mail::raw(
            "Имя: {$request->name}\nEmail: {$request->email}\n\nСообщение:\n{$request->message}",
            function ($mail) use ($request) {
                $mail->to('goldkazyna5@gmail.com')
                    ->subject("Profex — обращение от {$request->name}")
                    ->replyTo($request->email, $request->name);
            }
        );

        return back()->with('success', true);
    }
}
