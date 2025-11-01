<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Report;
use App\Models\Branch;
use App\Models\ProductActivity;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $searchText   = $request->input('searchText');
        $branchId     = $request->input('branch_id');
        $activityType = $request->input('activity_type'); // matches Blade
        $month        = $request->input('month');
        $year         = $request->input('year');
        $fromDate     = $request->input('date_from');
        $toDate       = $request->input('date_to');

        // Dropdowns
        $branches   = Branch::pluck('name', 'id');
        $activities = ProductActivity::pluck('activity', 'id');

        // Available years
        $years = Report::selectRaw('YEAR(created_at) as year')
                        ->distinct()
                        ->orderBy('year', 'desc')
                        ->pluck('year');

        // Query with filters
        $reports = Report::with(['product', 'branch', 'activity', 'user'])
            ->search($searchText)
            ->filterBranch($branchId)
            ->filterActivity($activityType)
            ->filterMonthYear($month, $year)
            ->filterDateRange($fromDate, $toDate)
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('report', compact(
            'reports', 'branches', 'activities', 'years',
            'searchText', 'branchId', 'activityType', 'month', 'year', 'fromDate', 'toDate'
        ));
    }
}
