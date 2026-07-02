<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FcmTokenController extends Controller
{
    public function store(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        auth()->user()->fcmTokens()->updateOrCreate(
            ['token' => $request->token],
            ['token' => $request->token]
        );

        return response()->json(['success' => true]);
    }
}