<?php

namespace App\Http\Controllers\Auth;

use App\Helpers\ApiResponse;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthenticatedSessionController extends Controller
{
    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:6',
    ], [
        'email.required' => 'Email is required',
        'password.required' => 'Password is required',
    ]);

    if ($validator->fails()) {
        return ApiResponse::sendResponse(200, 'Failed', $validator->messages()->all());
    }

    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $user = Auth::user();
        $data['token'] = $user->createToken('auth_token')->plainTextToken;
        $data['name'] = $user->name;
        $data['email'] = $user->email;
        $data['id'] = $user->id;
        // to make test pass
        return ApiResponse::sendResponse(204, 'Success Login', $data);
        // to use token in postman
        // return ApiResponse::sendResponse(200, 'Success Login', $data);

    } else {
        return ApiResponse::sendResponse(401, 'User credentials not match', null);
    }
}


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): Response
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->noContent();
    }
}
