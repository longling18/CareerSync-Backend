<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ResultRequest;
use App\Models\Result;
use Illuminate\Http\Request;

class ResultController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\ResultRequest  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ResultRequest $request)
    {
        // Validate the request data
        $validatedData = $request->validated();

        // Get the user_id, dep_id, and course_id from the request
        $user_id = $validatedData['user_id'];
        $dep_id = $validatedData['dep_id'];
        $course_id = $validatedData['course_id'];

        // Create and save the Result with the specified values
        $result = Result::create([
            'user_id'   => $user_id,
            'dep_id'    => $dep_id,
            'course_id' => $course_id,
        ]);

        return response()->json(['message' => 'Result created successfully', 'data' => $result], 201);
    }

    public function index(Request $request)
    {
        $result = Result::select('users.first_name', 'users.last_name', 'department.dep_name', 'courses.course_name')
            ->join('users', 'result.user_id', '=', 'users.id')
            ->join('department', 'result.dep_id', '=', 'department.dep_id')
            ->join('courses', 'result.course_id', '=', 'courses.course_id');

        return $result->get();
    }
}
