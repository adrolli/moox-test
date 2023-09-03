<?php

namespace App\Http\Controllers;

use App\Models\Test;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\TestStoreRequest;
use App\Http\Requests\TestUpdateRequest;

class TestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $this->authorize('view-any', Test::class);

        $search = $request->get('search', '');

        $tests = Test::search($search)
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('app.tests.index', compact('tests', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): View
    {
        $this->authorize('create', Test::class);

        return view('app.tests.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TestStoreRequest $request): RedirectResponse
    {
        $this->authorize('create', Test::class);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $test = Test::create($validated);

        return redirect()
            ->route('tests.edit', $test)
            ->withSuccess(__('crud.common.created'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Test $test): View
    {
        $this->authorize('view', $test);

        return view('app.tests.show', compact('test'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request, Test $test): View
    {
        $this->authorize('update', $test);

        return view('app.tests.edit', compact('test'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        TestUpdateRequest $request,
        Test $test
    ): RedirectResponse {
        $this->authorize('update', $test);

        $validated = $request->validated();
        $validated['data'] = json_decode($validated['data'], true);

        $test->update($validated);

        return redirect()
            ->route('tests.edit', $test)
            ->withSuccess(__('crud.common.saved'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Test $test): RedirectResponse
    {
        $this->authorize('delete', $test);

        $test->delete();

        return redirect()
            ->route('tests.index')
            ->withSuccess(__('crud.common.removed'));
    }
}
