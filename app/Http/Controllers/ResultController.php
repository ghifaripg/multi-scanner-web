<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Comment;
use Illuminate\Support\Facades\Validator;

class ResultController extends Controller
{
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

    public function safe($scan_id)
    {
        $scan = $this->authorizeScanAccess($scan_id);
        if (!$scan instanceof \App\Models\Scan) return $scan;

        return view('result.safe', compact('scan_id'));
    }

    public function suspicious($scan_id)
    {
        $scan = $this->authorizeScanAccess($scan_id);
        if (!$scan instanceof \App\Models\Scan) return $scan;

        return view('result.suspicious', compact('scan_id'));
    }

    public function notsafe($scan_id)
    {
        $scan = $this->authorizeScanAccess($scan_id);
        if (!$scan instanceof \App\Models\Scan) return $scan;

        return view('result.notsafe', compact('scan_id'));
    }

    public function full($scan_id)
    {
        $scan = $this->authorizeScanAccess($scan_id);
        if (!$scan instanceof \App\Models\Scan) return $scan;

        $reportLines = explode("\n", $scan->full_report);
        $filename = $scan->scan_title;

        return view('result.fullreport', compact('reportLines', 'filename', 'scan'));
    }
}

