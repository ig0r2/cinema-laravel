<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReviewController extends Controller
{
    /**
     * Show all reviews
     */
    public function index(Request $request): View
    {
        $user = $request->input('user');

        $reviews = Review::with('movie', 'user')
            ->when($user, function ($query, $user) {
                return $query->where('user_id', $user);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('admin.reviews.index', compact('reviews'));
    }

    /**
     * Delete the given review.
     */
    public function destroy(Review $review): RedirectResponse
    {
        $review->delete();

        return redirect()->back();
    }
}
