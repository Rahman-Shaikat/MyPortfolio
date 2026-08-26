<?php

namespace App\Services;

use App\Models\Publication;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class PublicationService
{
    /**
     * @return Collection<int, Publication>
     */
    public function publishedPublications(): Collection
    {
        return $this->publishedPublicationsQuery()->get();
    }

    /**
     * @return Collection<int, Publication>
     */
    public function featuredPublications(int $limit = 3): Collection
    {
        return $this->publishedPublicationsQuery()->limit($limit)->get();
    }

    public function publishedPublicationBySlug(string $slug): Publication
    {
        return $this->publishedPublicationsQuery()->where('slug', $slug)->firstOrFail();
    }

    public function adminPublications(?string $search = null, int $perPage = 10): LengthAwarePaginator
    {
        return Publication::query()
            ->when($search, function (Builder $query, string $search): void {
                $query->where(function (Builder $query) use ($search): void {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('publisher', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            })
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->orderBy('id')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function publishedPublicationCount(): int
    {
        return Publication::query()->published()->count();
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function createPublication(array $attributes, ?UploadedFile $image = null): Publication
    {
        $imagePath = $image ? $this->storeImage($image) : null;

        if ($imagePath) {
            $attributes['image'] = $imagePath;
        }

        try {
            return Publication::query()->create($attributes);
        } catch (Throwable $exception) {
            $this->deleteImage($imagePath);

            throw $exception;
        }
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    public function updatePublication(Publication $publication, array $attributes, ?UploadedFile $image = null): Publication
    {
        $removeImage = (bool) Arr::pull($attributes, 'remove_image', false);
        $previousImagePath = $publication->image;
        $newImagePath = $image ? $this->storeImage($image) : null;

        if ($newImagePath) {
            $attributes['image'] = $newImagePath;
        } elseif ($removeImage) {
            $attributes['image'] = null;
        }

        try {
            $publication->update($attributes);
        } catch (Throwable $exception) {
            $this->deleteImage($newImagePath);

            throw $exception;
        }

        if (($newImagePath || $removeImage) && $previousImagePath !== $newImagePath) {
            $this->deleteImage($previousImagePath);
        }

        return $publication->refresh();
    }

    public function deletePublication(Publication $publication): void
    {
        $imagePath = $publication->image;

        $publication->delete();

        $this->deleteImage($imagePath);
    }

    /**
     * @return Builder<Publication>
     */
    private function publishedPublicationsQuery(): Builder
    {
        return Publication::query()
            ->published()
            ->orderBy('sort_order')
            ->orderByDesc('published_at')
            ->orderBy('id');
    }

    private function storeImage(UploadedFile $image): string
    {
        $path = $image->store('publications', 'public');

        if (! $path) {
            throw new RuntimeException('The publication image could not be stored.');
        }

        return $path;
    }

    private function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::disk('public')->delete($path);
        }
    }
}
