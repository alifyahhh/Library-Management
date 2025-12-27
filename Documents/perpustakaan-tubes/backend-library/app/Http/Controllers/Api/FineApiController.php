<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Fine;
use Illuminate\Http\Request;

class FineApiController extends Controller
{
    // GET /api/my-fines
    public function myFines(Request $request)
    {
        $user = $request->user();

        $fines = Fine::with(['borrowing.book'])
            ->whereHas('borrowing', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->orderByDesc('id')
            ->paginate(10);

        return response()->json([
            'success' => true,
            'message' => 'My fines',
            'data' => $fines,
        ]);
    }

    // POST /api/pay-fine/{fine}
    public function pay(Request $request, Fine $fine)
    {
        $user = $request->user();

        // pastikan denda ini milik user tersebut
        if ($fine->borrowing->user_id !== $user->id) {
            return response()->json([
                'success' => false,
                'message' => 'Forbidden: fine not yours',
            ], 403);
        }

        if ($fine->status === 'paid') {
            return response()->json([
                'success' => false,
                'message' => 'Fine already paid',
            ], 400);
        }

        $fine->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Fine paid',
            'data' => $fine,
        ]);
    }
}
