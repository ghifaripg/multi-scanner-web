<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;

class HomeController extends Controller
{
    public function ajaxSearch(Request $request)
    {
        $searchTerm = $request->input('search');
        $scans = collect();

        if ($searchTerm) {
            $scans = Scan::query()
                ->whereIn('scan_type', ['email', 'url'])
                ->where(function($query) use ($searchTerm) {
                    $query->where('scan_title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('scan_type', 'like', '%' . $searchTerm . '%');
                })
                ->with('user')
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }

        return response()->json([
            'scans' => $scans,
            'searchTerm' => $searchTerm
        ]);
    }

    public function full($scan_id)
    {
    $scan = Scan::findOrFail($scan_id);

    // Basic authorization - ensure the scan belongs to the authenticated user
    // if ($scan->user_id !== auth()->id()) {
    //     return redirect()->route('scan.history')
    //            ->with('error', 'You are not authorized to view this scan.');
    //     }

    $reportLines = explode("\n", $scan->full_report);
    $filename = $scan->scan_title;
    $result = $scan->scan_result;

    return view('result.fullreport', compact('reportLines', 'filename', 'scan', 'result'));
    }
}
