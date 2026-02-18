<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = auth()->user();
        $transactions = Transaction::where('user_id', $user->id);

        $recentTransactions = $transactions->latest()->take(5)->get();

        $referral = $user->getReferrals()->first();

        $dataCount = [
            'total_transaction' => $transactions->count(),
            'total_deposit' => $user->totalDeposit(),
            'total_referral' => $referral?->relationships()->count() ?? 0,
            'total_tickets' => $user->ticket->count(),
            'total_withdraws' => $user->totalWithdraw(),
            'total_earnings' => $user->totalProfit(),
            'transactions' => $recentTransactions,
            'user' => $user,
        ];

        return view('frontend::user.dashboard', $dataCount);
    }
}
