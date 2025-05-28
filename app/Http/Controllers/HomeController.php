<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;

class HomeController extends Controller
{
    public function index()
    {
        $types = ['url', 'email', 'file'];
        $glimpseResults = collect();

        foreach ($types as $type) {
            $scans = Scan::where('scan_type', $type)
                ->whereHas('comments') // Only scans that have at least 1 comment
                ->with(['comments' => function($query) {
                    $query->latest()->limit(1); // Load only the latest comment
                }])
                ->inRandomOrder()
                ->limit(2)
                ->get();

            $glimpseResults = $glimpseResults->merge($scans);
        }

        if ($glimpseResults->count() < 6) {
            $additionalScans = Scan::whereNotIn('scan_id', $glimpseResults->pluck('scan_id'))
                ->whereHas('comments')
                ->with(['comments' => function($query) {
                    $query->latest()->limit(1);
                }])
                ->inRandomOrder()
                ->limit(6 - $glimpseResults->count())
                ->get();

            $glimpseResults = $glimpseResults->merge($additionalScans);
        }

        return view('dashboard.index', compact('glimpseResults'));
    }

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
