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
            'category_breakdown' => $this->getCategoryBreakdown(),
            'daily_statistics' => $this->getDailyStatistics(),
        ];

        return response()->json($dashboardData, 200, [], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }





    public function getCategoryBreakdown()
    {
        //=======Get all transactions grouped by category and type =====
        $transactions = Transaction::selectRaw('category, type, SUM(amount) as total_amount')
            ->groupBy('category', 'type')
            ->get();

        //======Processing the data =========
        $categoryBreakdown = [];

        foreach ($transactions as $transaction) {
            $category = $transaction->category;
            $type = $transaction->type;
            $totalAmount = $transaction->total_amount;

            if (!isset($categoryBreakdown[$category])) {
                $categoryBreakdown[$category] = [
                    'category' => $category,
                    'withdrawal_amount' => 0,
                    'deposit_amount' => 0,
                ];
            }

            //======Assign the total amount to the corresponding type (Withdraw or Deposit)=======
            $categoryBreakdown[$category][$type == 'Withdraw' ? 'withdrawal_amount' : 'deposit_amount'] = $totalAmount;
        }

        //==========Convert the associative array to indexed array=======
        $categoryBreakdown = array_values($categoryBreakdown);

        return $categoryBreakdown;
    }





    public function getDailyStatistics()
    {
        //=======Get all transactions grouped by date ========
        $transactions = Transaction::selectRaw('DATE(tx_finish) as date, SUM(CASE WHEN type = "Deposit" THEN amount ELSE 0 END) as total_deposits, SUM(CASE WHEN type = "Withdraw" THEN amount ELSE 0 END) as total_withdrawals')
            ->groupBy('date')
            ->get();

        //======Processing the data =========
        $dailyStatistics = [];
        foreach ($transactions as $transaction) {
            $dailyStatistics[] = [
                'transaction_date' => $transaction->date,
                'total_deposits' => $transaction->total_deposits,
                'total_withdrawals' => ($transaction->total_withdrawals),
            ];
        }

        return $dailyStatistics;
    }
}
