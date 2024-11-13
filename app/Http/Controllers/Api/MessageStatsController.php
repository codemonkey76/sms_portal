<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\MessageStatsRequest;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class MessageStatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function __invoke(MessageStatsRequest $request): JsonResponse
    {
        return $this->getStats($request);
    }

    public function getStats(MessageStatsRequest $request): JsonResponse
    {
        [$customer, $start, $end] = $this->extractValidatedData($request);
        $query = $customer->messages()->where('dateCreated', '>', $start)->where('dateCreated', '<', $end);

        $sum = $query->sum('numSegments');
        $count = $query->count();
        $monthName = $start->format('F');
        $year = $start->format('Y');

        return response()->json([
            'message' => "Message stats for customer: {$customer->name} for {$monthName} {$year}",
            'data' => [
                'sum' => intval($sum),
                'count' => $count,
            ],
        ]);
    }

    public function setImported(MessageStatsRequest $request): JsonResponse
    {
        [$customer, $start, $end] = $this->extractValidatedData($request);
        $customer->messages()
            ->where('dateCreated', '>', $start)
            ->where('dateCreated', '<', $end)
            ->chunk(100, fn($message) => $message->each(fn($message) => $message->update(['imported' => true])));

        return response()->json(['message' => 'Messages have been set to imported.'],200);
    }

    private function extractValidatedData(MessageStatsRequest $request): array
    {
        $validated = $request->validated();
        $customerId = $validated['customer'];
        $monthsAgo = $validated['monthsAgo'];

        $start = now()->subMonths($monthsAgo)->startOfMonth();
        $end = now()->subMonths($monthsAgo)->endOfMonth();

        $customer = Customer::find($customerId);

        return compact('customer', 'start', 'end');
    }
}
