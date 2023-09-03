<?php

namespace App\Http\Controllers\Api;

use App\Models\Test;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Resources\TestResource;
use App\Http\Controllers\Controller;
use App\Http\Resources\TestCollection;
use App\Http\Requests\TestStoreRequest;
use App\Http\Requests\TestUpdateRequest;

class TestController extends Controller
{
    public function index(Request $request): TestCollection
    {
        $this->authorize('view-any', Test::class);

        $search = $request->get('search', '');

        $tests = Test::search($search)
            ->latest()
            ->paginate();

        return new TestCollection($tests);
    }

    public function store(TestStoreRequest $request): TestResource
    {
        $this->authorize('create', Test::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $test = Test::create($validated);

        return new TestResource($test);
    }

    public function show(Request $request, Test $test): TestResource
    {
        $this->authorize('view', $test);

        return new TestResource($test);
    }

    public function update(TestUpdateRequest $request, Test $test): TestResource
    {
        $this->authorize('update', $test);

        $validated = $request->validated();

        $validated['data'] = json_decode($validated['data'], true);

        $test->update($validated);

        return new TestResource($test);
    }

    public function destroy(Request $request, Test $test): Response
    {
        $this->authorize('delete', $test);

        $test->delete();

        return response()->noContent();
    }
}
