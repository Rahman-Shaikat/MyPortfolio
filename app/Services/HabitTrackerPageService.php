<?php

namespace App\Services;

use App\Models\HabitTrackerPage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RuntimeException;
use Throwable;

class HabitTrackerPageService
{
    public function pageInfo(): HabitTrackerPage
    {
        return HabitTrackerPage::query()->find(1) ?? new HabitTrackerPage;
    }

    /** @param array<string, mixed> $attributes */
    public function save(array $attributes): void
    {
        $newPaths = [];
        $oldPaths = [];
        try {
            foreach (HabitTrackerPage::IMAGE_FIELDS as $field => $label) {
                $file = Arr::pull($attributes, $field);
                if ($file instanceof UploadedFile) {
                    $path = $file->store('habit-tracker', 'public');
                    if (! $path) {
                        throw new RuntimeException('The image could not be stored.');
                    }
                    $newPaths[$field] = $path;
                }
            }

            DB::transaction(function () use ($attributes, $newPaths, &$oldPaths): void {
                HabitTrackerPage::query()->firstOrCreate(['id' => 1]);
                $page = HabitTrackerPage::query()->lockForUpdate()->findOrFail(1);
                foreach (HabitTrackerPage::IMAGE_FIELDS as $field => $label) {
                    $remove = (bool) Arr::pull($attributes, 'remove_'.$field, false);
                    if (isset($newPaths[$field]) || $remove) {
                        if ($page->getAttribute($field)) {
                            $oldPaths[] = $page->getAttribute($field);
                        }
                        $attributes[$field] = $newPaths[$field] ?? null;
                    }
                }
                $page->fill($attributes)->save();
            });
        } catch (Throwable $exception) {
            Storage::disk('public')->delete(array_values($newPaths));
            throw $exception;
        }

        Storage::disk('public')->delete($oldPaths);
    }
}
