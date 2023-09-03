<?php
namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TestCollection;

class UserTestsController extends Controller
{
    public function index(Request $request, User $user): TestCollection
    {
        $this->authorize('view', $user);

        $search = $request->get('search', '');

        $tests = $user
            ->tests()
            ->search($search)
            ->latest()
            ->paginate();

        return new TestCollection($tests);
    }

    public function store(Request $request, User $user, Test $test): Response
    {
        $this->authorize('update', $user);

        $user->tests()->syncWithoutDetaching([$test->id]);

        return response()->noContent();
    }

    public function destroy(Request $request, User $user, Test $test): Response
    {
        $this->authorize('update', $user);

        $user->tests()->detach($test);

        return response()->noContent();
    }
}
