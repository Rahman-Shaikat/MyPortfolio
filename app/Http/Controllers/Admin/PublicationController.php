<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePublicationRequest;
use App\Http\Requests\UpdatePublicationRequest;
use App\Models\Publication;
use App\Services\PublicationService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PublicationController extends Controller
{
    public function __construct(private readonly PublicationService $publicationService) {}

    public function index(Request $request): View
    {
        $search = $request->string('search')->trim()->value();

        return view('admin.publications.index', [
            'publications' => $this->publicationService->adminPublications($search),
            'search' => $search,
        ]);
    }

    public function create(): View
    {
        return view('admin.publications.create');
    }

    public function store(StorePublicationRequest $request): RedirectResponse
    {
        $this->publicationService->createPublication(
            $request->safe()->except(['image']),
            $request->file('image'),
        );

        return to_route('admin.publications.index')
            ->with('success', 'Publication created successfully.');
    }

    public function edit(Publication $publication): View
    {
        return view('admin.publications.edit', ['publication' => $publication]);
    }

    public function update(UpdatePublicationRequest $request, Publication $publication): RedirectResponse
    {
        $this->publicationService->updatePublication(
            $publication,
            $request->safe()->except(['image']),
            $request->file('image'),
        );

        return to_route('admin.publications.index')
            ->with('success', 'Publication updated successfully.');
    }

    public function destroy(Publication $publication): RedirectResponse
    {
        $this->publicationService->deletePublication($publication);

        return to_route('admin.publications.index')
            ->with('success', 'Publication deleted successfully.');
    }
}
