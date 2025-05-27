<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Scan;
use App\Models\User;

class HistoryController extends Controller
{
    public function history()
    {
        $user = Auth::user();
        $scans = $user->scans()->orderBy('created_at', 'desc')->get();
        return view('history.index', compact('scans'));
    }

    private function authorizeScanAccess($scan_id)
    {
        $expectedId = Session::get('latest_scan_id');

        if ((int)$scan_id !== (int)$expectedId) {
            if (request()->expectsJson()) {
                return false;
            }
            return redirect('/')->with('scan_error', 'You are not allowed to access this scan result.');
        }

        return Scan::findOrFail($scan_id);
    }

    public function full($scan_id)
{
    $scan = Scan::findOrFail($scan_id);
    
    // Basic authorization - ensure the scan belongs to the authenticated user
    if ($scan->user_id !== auth()->id()) {
        return redirect()->route('scan.history')
               ->with('error', 'You are not authorized to view this scan.');
    }

    $reportLines = explode("\n", $scan->full_report);
    $filename = $scan->scan_title;

    return view('result.fullreport', compact('reportLines', 'filename', 'scan'));
}
}