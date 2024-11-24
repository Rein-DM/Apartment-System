<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use PDF;
use Carbon\Carbon;

class SalesReportController extends Controller
{
    public function generateSalesReport(Request $request)
    {
        // Get filter type (daily, weekly, monthly, yearly)
        $filter = $request->input('filter');

        // Initialize start and end dates based on filter
        switch ($filter) {
            case 'monthly':
                $startDate = now()->startOfMonth();
                $endDate = now()->endOfMonth();
                break;
            case 'yearly':
                $startDate = now()->startOfYear();
                $endDate = now()->endOfYear();
                break;
            default:
                // Handle custom date range if not using predefined filters
                $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : now()->startOfDay();
                $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : now()->endOfDay();
                break;
        }

        // Fetch the sales data, selecting the required fields
        $payments = Payment::whereBetween('created_at', [$startDate, $endDate])
            ->select('full_name', 'amount', 'created_at') // Select the fields you want
            ->get();

        // Calculate total revenue
        $totalRevenue = $payments->sum('amount');

        // Generate the PDF using the sales data and load the view
        $pdf = PDF::loadView('components.sales.report', compact('payments', 'totalRevenue', 'startDate', 'endDate'));

        // Return the PDF for download
        return $pdf->download('sales_report.pdf');
    }
}
