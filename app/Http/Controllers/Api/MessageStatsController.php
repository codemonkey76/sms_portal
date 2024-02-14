<?php declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MessageStatsController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }


    public function __invoke(Request $request)
    {
        $validated = $request->validate([
            'customer' => 'required|exists:customers,id',
            'monthsAgo' => 'required|integer|min:1|max:12'
        ]);
        $customerId = $validated['customer'];
        $monthsAgo = $validated['monthsAgo'];

        $start = now()->subMonths($monthsAgo)->startOfMonth();
        $end = now()->subMonths($monthsAgo)->endOfMonth();

        $customer = Customer::find($customerId);
        $query = $customer->messages()->where('dateCreated', '>', $start)->where('dateCreated', '<', $end);

        $sum = $query->sum('numSegments');
        $count = $query->count();
        $monthName = $start->format('F');
        $year = $start->format('Y');

        return response()->json([
            'message' => "Message stats for customer: {$customer->name} for {$monthName} {$year}",
            'data' => [
                'sum' => intval($sum),
                'count' => $count
            ]
        ]);
    }

}

