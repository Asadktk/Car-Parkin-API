<?php

namespace App\Http\Controllers\Api\V1\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function show(Request $request){
        return response()->json($request->user()->only('name', 'email'));
    }

    public function update(Request $request){
        $ValidatedData = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'email', Rule::unique('users')->ignore(auth()->user())],
        ]);

        auth()->user()->update($ValidatedData);

        return response()->json($ValidatedData, Response::HTTP_ACCEPTED);
    }

}
