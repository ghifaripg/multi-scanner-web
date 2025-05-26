<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Scan;

class ResultController extends Controller
{
    private function authorizeScanAccess($scan_id)
    {
        $expectedId = Session::get('latest_scan_id');

        if ((int)$scan_id !== (int)$expectedId) {
            return redirect('/')->with('scan_error', 'You are not allowed to access this scan result.');
        }


        return Scan::findOrFail($scan_id);
    }

    public function safe($scan_id)
    {
        $scan = $this->authorizeScanAccess($scan_id);
        if (!$scan instanceof \App\Models\Scan) return $scan;

        return view('result.safe', compact('scan_id'));
    }

    public function suspicious($scan_id)
    {
        $scan = $this->authorizeScanAccess($scan_id);
        if (!$scan instanceof \App\Models\Scan) return $scan; // it's a redirect if unauthorized

        return view('result.suspicious', compact('scan_id'));
    }

    public function notsafe($scan_id)
    {
        $scan = $this->authorizeScanAccess($scan_id);
        if (!$scan instanceof \App\Models\Scan) return $scan; // it's a redirect if unauthorized

        return view('result.notsafe', compact('scan_id'));
    }

    public function full($scan_id)
    {
        $scan = $this->authorizeScanAccess($scan_id);
        if (!$scan instanceof \App\Models\Scan) return $scan; // redirect if unauthorized

        $reportLines = explode("\n", $scan->full_report);
        $filename = $scan->scan_title;

        return view('result.fullreport', compact('reportLines', 'filename'));
    }
}
