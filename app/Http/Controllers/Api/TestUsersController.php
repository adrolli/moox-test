<?php
namespace App\Http\Controllers\Api;

use App\Models\Test;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;

class TestUsersController extends Controller
{
    public function index(Request $request, Test $test): UserCollection
    {
        $this->authorize('view', $test);

        $search = $request->get('search', '');

        $users = $test
            ->users()
            ->search($search)
            ->latest()
            ->paginate();

        return new UserCollection($users);
    }

    public function store(Request $request, Test $test, User $user): Response
    {
        $this->authorize('update', $test);

        $test->users()->syncWithoutDetaching([$user->id]);

        return response()->noContent();
    }

    public function destroy(Request $request, Test $test, User $user): Response
    {
        $this->authorize('update', $test);

        $test->users()->detach($user);

        return response()->noContent();
    }
}
