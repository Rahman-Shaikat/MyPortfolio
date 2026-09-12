<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ReorderProjectsRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(private readonly ProjectService $projectService) {}

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value();

        return view('admin.projects.index', [
            'projects' => $this->projectService->adminProjects($search),
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.projects.create');
    }

    public function reorder(ReorderProjectsRequest $request): JsonResponse
    {
        $this->projectService->reorderProjects($request->validated('projects'));

        return response()->json(['message' => 'Project order saved.']);
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $this->projectService->createProject(
            $request->safe()->except(['preview_image']),
            $request->file('preview_image'),
        );

        return to_route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function edit(Project $project): View
    {
        return view('admin.projects.edit', ['project' => $project]);
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $this->projectService->updateProject(
            $project,
            $request->safe()->except(['preview_image']),
            $request->file('preview_image'),
        );

        return to_route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->projectService->deleteProject($project);

        return to_route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
