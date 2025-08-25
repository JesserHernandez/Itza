<?php

namespace App\Http\Controllers;

use App\Models\LikeUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Requests\LikeUserRequest;
use App\Models\Product;
use App\Models\ResponseReview;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use SebastianBergmann\Type\TrueType;

class LikeUserController extends Controller
{
    public function index(Request $request): mixed
    {
        $likeUsers = LikeUser::paginate();
        return Inertia::render('LikeUser/Index', ['likeUsers' => $likeUsers, 'i' => ($request->input('page', 1) - 1) * $likeUsers->perPage()]);
    }
    public function create(): mixed
    {
        return Inertia::render('LikeUser/Create', ['likeUser' => new LikeUser() ]);
    }
    public function store(LikeUserRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['user_id'] = Auth::id();
        $this->toggleOrCreate($validated);
        return Redirect::route('like-users.index')->with('success', 'Reacción registrada correctamente.');
    }
    public function show($id): mixed
    {
        $likeUser = LikeUser::findOrFail($id);
        return Inertia::render('LikeUser/Show', ['likeUser' => $likeUser ]);
    }
    public function edit($id): mixed
    {
        $likeUser = LikeUser::findOrFail($id);
        return Inertia::render('LikeUser/Edit', ['likeUser' => $likeUser ]);
    }
    public function update(LikeUserRequest $request, LikeUser $likeUser): RedirectResponse
    {
        $likeUser->update($request->validated());
        return Redirect::route('like-users.index')->with('success', 'LikeUser updated successfully');
    }
    public function destroy($id): RedirectResponse
    {
        LikeUser::findOrFail($id)->delete();
        return Redirect::route('like-users.index')->with('success', 'LikeUser deleted successfully');
    }
    public function toggleOrCreate(array $validated): void
    {
        $existing = LikeUser::where([
            'user_id' => $validated['user_id'],
            'liked_id' => $validated['liked_id'],
            'liked_type' => $validated['liked_type'],
        ])->first();

        if ($existing) {
            $this->toggleReaction($existing, $validated);
        } else {
            $like = LikeUser::create($validated);
            $this->applyReaction($like);
        }
    }
    protected function toggleReaction(LikeUser $likeUser, array $validated): void
    {
        $target = $likeUser->liked;

        if ($likeUser->is_like === $validated['is_like']) {
            $likeUser->is_like = false;
            $likeUser->save();
            $target->decrement('like_count');
            return;
        }

        if ($likeUser->is_dis_like === $validated['is_dis_like']) {
            $likeUser->is_dis_like = false;
            $likeUser->save();
            $target->decrement('dis_like_count');
            return;
        }

        $likeUser->is_like = $validated['is_like'];
        $likeUser->is_dis_like = $validated['is_dis_like'];
        $likeUser->save();

        if ($validated['is_like']) {
            $target->increment('like_count');
        } elseif ($validated['is_dis_like']) {
            $target->increment('dis_like_count');
        }
    }

    protected function applyReaction(LikeUser $like): void
    {
        $target = $like->liked;

        if ($like->is_like) {
            $target->increment('like_count');
        } elseif ($like->is_dis_like) {
            $target->increment('dis_like_count');
        }
    }
}