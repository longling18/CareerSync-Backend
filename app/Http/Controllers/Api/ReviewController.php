<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Http\Controllers\Controller;
use App\Models\Review;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $review = Review::select('review.review_id', 'users.first_name', 'review.comments')
            ->join('users', 'review.user_id', '=', 'users.id');

        /*if ($request->keyword) {
            $review->where(function ($query) use ($request) {
                $query->where('users.first_name', 'like', '%' . $request->keyword . '%')
                    ->orWhere('review.comments', 'like', '%' . $request->keyword . '%');
            });
        }*/

        return $review->get();
    }
    public function show(string $id)
    {
        return Review::findOrFail($id);
    }

    public function store(ReviewRequest $request)
    {
        $validated = $request->validated();

        $review = Review::create($validated);

        return $review;
    }

    public function destroy(string $id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted successfully']);
    }
}
