<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $fromDate = $request->input('from_date');
        $toDate = $request->input('to_date');

        // If from_date and to_date are not provided, set them to the first and last day of the current month
        if (!$fromDate || !$toDate) {
            $currentMonth = date('m');
            $currentYear = date('Y');
            $fromDate = date('Y-m-01', strtotime("$currentYear-$currentMonth-01"));
            $toDate = date('Y-m-t', strtotime("$currentYear-$currentMonth-01"));
        }

        $entries = Entry::whereBetween('date', [$fromDate, $toDate])->get();

        $debit = 0;
        $credit = 0;

        foreach ($entries as $entry) {
            switch ($entry->management_id) {
                case 0:
                    $credit += $entry->amount;
                    break;
                case 1:
                case 2:
                case 3:
                    $debit += $entry->amount;
                    break;
                case 4:
                    $credit += $entry->amount;
                    break;
                default:
                    // Do nothing or handle other cases
                    break;
            }
        }

        $total = $credit - $debit;

        return view('report', compact('entries', 'debit', 'credit', 'total'));
    }
}