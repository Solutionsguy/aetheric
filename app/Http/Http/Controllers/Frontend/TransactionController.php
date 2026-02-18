<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Carbon\Carbon;

class TransactionController extends Controller
{
    public function transactions()
    {
        $from_date = trim(@explode('-', request('daterange'))[0]);
        $to_date = trim(@explode('-', request('daterange'))[1]);

        $transactions = Transaction::where('user_id', auth()->id())
            ->search(request('trx'))
            ->when(request('daterange'), function ($query) use ($from_date, $to_date) {
                $query->whereDate('created_at', '>=', Carbon::parse($from_date)->format('Y-m-d'));
                $query->whereDate('created_at', '<=', Carbon::parse($to_date)->format('Y-m-d'));
            })
            ->when(request('type') && request('type') !== 'all', function ($query) {
                $query->where('type', request('type'));
            })
            ->latest()
            ->paginate(request('limit', 15))
            ->withQueryString();

        return view('frontend::user.transaction.index', compact('transactions'));
    }
}
