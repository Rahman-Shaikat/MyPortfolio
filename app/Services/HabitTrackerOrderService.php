<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Database\UniqueConstraintViolationException;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class HabitTrackerOrderService
{
    /** @param array<string, mixed> $data
     * @param  array<string, mixed>  $quote
     */
    public function submit(array $data, array $quote): Order
    {
        $hash = hash('sha256', $data['submission_token']);
        $payloadHash = hash('sha256', json_encode(Arr::only($data, [
            'name', 'phone', 'email', 'payment_method', 'payment_reference', 'bank_sender_name', 'bank_last_four',
        ])));
        if ($existing = Order::query()->where('submission_hash', $hash)->first()) {
            return $this->sameSubmission($existing, $payloadHash);
        }
        $path = null;
        try {
            $path = isset($data['screenshot']) ? $data['screenshot']->store('receipts', 'receipts') : null;

            return DB::transaction(function () use ($data, $quote, $hash, $payloadHash, $path): Order {
                $method = $quote['methods'][$data['payment_method']];
                $order = Order::query()->create([
                    'reference' => 'HT-'.Str::ulid(),
                    'submission_hash' => $hash,
                    'payload_hash' => $payloadHash,
                    ...Arr::only($data, ['name', 'phone', 'email']),
                ]);
                $order->detail()->create([
                    'product' => 'Habit Tracker for Windows', 'amount' => $quote['amount'], 'currency' => $quote['currency'],
                    'payment_method' => $data['payment_method'], 'payment_method_name' => $method['name'],
                    'payment_instructions' => $method['instructions'],
                    'payment_reference' => $data['payment_reference'],
                    'reference_fingerprint' => hash('sha256', $method['type'].'|'.Str::upper(preg_replace('/[^a-zA-Z0-9]/', '', $data['payment_reference']))),
                    'bank_sender_name' => $method['type'] === 'bank' ? ($data['bank_sender_name'] ?? null) : null,
                    'bank_last_four' => $method['type'] === 'bank' ? ($data['bank_last_four'] ?? null) : null,
                    'screenshot_path' => $path,
                ]);
                $order->statusHistory()->create(['to_status' => 'pending', 'actor' => 'Customer']);

                return $order;
            });
        } catch (Throwable $exception) {
            if ($path) {
                Storage::disk('receipts')->delete($path);
            }
            if ($exception instanceof UniqueConstraintViolationException && ($existing = Order::query()->where('submission_hash', $hash)->first())) {
                return $this->sameSubmission($existing, $payloadHash);
            }
            throw $exception;
        }
    }

    /** @param array<string, mixed> $data */
    public function updateStatus(Order $order, array $data): void
    {
        DB::transaction(function () use ($order, $data): void {
            $locked = Order::query()->lockForUpdate()->findOrFail($order->id);
            if ($locked->status === $data['status']) {
                return;
            }
            if ($locked->status !== $data['expected_status']) {
                throw ValidationException::withMessages(['status' => 'This order has changed. Refresh before updating its status.']);
            }
            $locked->statusHistory()->create([
                'from_status' => $locked->status, 'to_status' => $data['status'],
                'reason' => $data['reason'] ?? null, 'actor' => config('admin.email') ?: 'Admin',
            ]);
            $locked->update([
                'status' => $data['status'],
                'completed_at' => $data['status'] === 'completed' ? now() : null,
                'cancelled_at' => $data['status'] === 'cancelled' ? now() : null,
            ]);
        });
    }

    private function sameSubmission(Order $order, string $payloadHash): Order
    {
        if (! hash_equals($order->payload_hash, $payloadHash)) {
            throw ValidationException::withMessages(['submission_token' => 'This form was already submitted with different details. Reload to start a new submission.']);
        }

        return $order;
    }
}
