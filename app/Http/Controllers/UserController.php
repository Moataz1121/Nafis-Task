<?php

namespace App\Http\Controllers;

use App\Helpers\ApiResponse;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    //
    public function index( Request $request)
    {
        //
        $user = Auth::user();
        if(!$user){
            return response()->json(['message' => 'User not authenticated'], 401);
        }
        $query = Task::whereHas('users', function ($query) use ($user) {
            $query->where('user_id', $user->id);
        });
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }
        if ($request->has('due_date')) {
            $query->whereDate('due_date', $request->input('due_date'));
        }
        $tasks = $query->get();
        return response()->json([
            'message' => 'Tasks retrieved successfully',
            'tasks' => TaskResource::collection($tasks),
        ]);
    }
}
