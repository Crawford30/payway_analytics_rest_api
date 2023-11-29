<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{


    public function index(Request $request)
    {
        //==== Retrieve all transactions or based on some date parameters(which is optional)-which gives the history===
        //==If no paramter is defines, returns all the transactions

        $transactions = Transaction::when($request->has('start_date'), function ($query) use ($request) {
            return $query->where('tx_finish', '>=', $request->input('start_date'));
        })->when($request->has('end_date'), function ($query) use ($request) {
            return $query->where('tx_finish', '<=', $request->input('end_date'));
        })->get();

        return  response()->json($transactions, 200);
    }


    //====Get a single Transaction based on id====
    public function show($id)
    {
        $transaction = Transaction::find($id);

        if (!$transaction) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        return response()->json($transaction, 200);
    }


    public function getDashboardData()
    {
    //========Get dashbboard statistics data =======
        $dashboardData = [
            'total_deposits' => Transaction::where('type', 'Deposit')->sum('amount'),
            'total_withdrawals' => Transaction::where('type', 'Withdraw')->sum('amount'),
            'category_breakdown' => Transaction::select('category', \DB::raw('SUM(amount) as total_amount'))
                ->groupBy('category')
                ->orderBy('total_amount', 'desc')
                ->get(),
        ];

        return response()->json($dashboardData, 200);
    }
}
