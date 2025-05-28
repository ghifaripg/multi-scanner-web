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
            $query = Scan::query()
                ->whereIn('scan_type', ['email', 'url'])
                ->where(function($query) use ($searchTerm) {
                    $query->where('scan_title', 'like', '%' . $searchTerm . '%')
                        ->orWhere('scan_type', 'like', '%' . $searchTerm . '%');
                })
                ->with('user')
                ->orderBy('created_at', 'desc');

            // Get all matching scans
            $allScans = $query->get();

            // ✅ Filter duplicates ONLY for 'url' type
            $uniqueScans = $allScans->filter(function ($scan, $key) use ($allScans) {
                if ($scan->scan_type !== 'url') return true; // keep all non-URL
                // Check if this is the first occurrence of this scan_title + scan_type
                return $allScans->where('scan_title', $scan->scan_title)
                                ->where('scan_type', $scan->scan_type)
                                ->keys()->first() === $key;
            });

            // Limit to 5 for display
            $scans = $uniqueScans->take(5);
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
