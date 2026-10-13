<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateHabitTrackerPageRequest;
use App\Services\HabitTrackerPageService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class HabitTrackerPageController extends Controller
{
    public function __construct(private readonly HabitTrackerPageService $pageService) {}

    public function edit(): View
    {
        return view('admin.habit-tracker.edit', ['pageInfo' => $this->pageService->pageInfo()]);
    }

    public function update(UpdateHabitTrackerPageRequest $request): RedirectResponse
    {
        $this->pageService->save($request->validated());

        return to_route('admin.habit-tracker.edit')->with('success', 'Habit Tracker page updated successfully.');
    }
}
