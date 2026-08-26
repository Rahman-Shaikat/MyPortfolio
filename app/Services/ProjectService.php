<?php

namespace App\Services;

use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class ProjectService
{
    /**
     * @return Collection<int, Project>
     */
    public function featuredProjects(int $limit = 3): Collection
    {
        return $this->activeProjectsQuery()
            ->limit($limit)
            ->get();
    }

    public function paginatedProjects(int $perPage = 3): LengthAwarePaginator
    {
        return $this->activeProjectsQuery()->paginate($perPage);
    }

    public function activeProjectCount(): int
    {
        return Project::query()->active()->count();
    }

    public function adminProjects(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return Project::query()
            ->when($search, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderBy('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function createProject(array $attributes, ?UploadedFile $previewImage = null): Project
    {
        $previewImagePath = $previewImage ? $this->storePreviewImage($previewImage) : null;

        if ($previewImagePath) {
            $attributes['preview_image'] = $previewImagePath;
        }

        try {
            return Project::query()->create($attributes);
        } catch (Throwable $exception) {
            $this->deletePreviewImage($previewImagePath);

            throw $exception;
        }
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function updateProject(Project $project, array $attributes, ?UploadedFile $previewImage = null): Project
    {
        $removePreviewImage = (bool) Arr::pull($attributes, 'remove_preview_image', false);
        $previousPreviewImagePath = $project->preview_image;
        $newPreviewImagePath = $previewImage ? $this->storePreviewImage($previewImage) : null;

        if ($newPreviewImagePath) {
            $attributes['preview_image'] = $newPreviewImagePath;
        } elseif ($removePreviewImage) {
            $attributes['preview_image'] = null;
        }

        try {
            $project->update($attributes);
        } catch (Throwable $exception) {
            $this->deletePreviewImage($newPreviewImagePath);

            throw $exception;
        }

        if (($newPreviewImagePath || $removePreviewImage) && $previousPreviewImagePath !== $newPreviewImagePath) {
            $this->deletePreviewImage($previousPreviewImagePath);
        }

        return $project->refresh();
    }

    public function deleteProject(Project $project): void
    {
        $previewImagePath = $project->preview_image;

        $project->delete();

        $this->deletePreviewImage($previewImagePath);
    }

    /**
     * @return Builder<Project>
     */
    private function activeProjectsQuery(): Builder
    {
        return Project::query()
            ->active()
            ->orderBy('sort_order')
            ->orderBy('id');
    }

    private function storePreviewImage(UploadedFile $previewImage): string
    {
        $path = $previewImage->store('projects', 'public');

        if (! $path) {
            throw new RuntimeException('The project preview image could not be stored.');
        }

        return $path;
    }

    private function deletePreviewImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
