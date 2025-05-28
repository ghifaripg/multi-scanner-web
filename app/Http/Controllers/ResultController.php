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

        // Get latest 18 comments from scans with the same type and title
        $relatedComments = Comment::with(['user', 'scan'])
            ->whereHas('scan', function ($query) use ($scan) {
                $query->where('scan_type', $scan->scan_type)
                    ->where('scan_title', $scan->scan_title);
            })
            ->latest()
            ->take(18)
            ->get();

        return view('result.safe', [
            'scan_id' => $scan_id,
            'relatedComments' => $relatedComments
        ]);
    }

    public function suspicious($scan_id)
    {
        $scan = $this->authorizeScanAccess($scan_id);
        if (!$scan instanceof \App\Models\Scan) return $scan;

        // Get latest 18 comments from scans with the same type and title
        $relatedComments = Comment::with(['user', 'scan'])
            ->whereHas('scan', function ($query) use ($scan) {
                $query->where('scan_type', $scan->scan_type)
                    ->where('scan_title', $scan->scan_title);
            })
            ->latest()
            ->take(18)
            ->get();

        return view('result.suspicious', [
            'scan_id' => $scan_id,
            'relatedComments' => $relatedComments
        ]);
    }

    public function notsafe($scan_id)
    {
        $scan = $this->authorizeScanAccess($scan_id);
        if (!$scan instanceof \App\Models\Scan) return $scan;

        // Get latest 18 comments from scans with the same type and title
        $relatedComments = Comment::with(['user', 'scan'])
            ->whereHas('scan', function ($query) use ($scan) {
                $query->where('scan_type', $scan->scan_type)
                    ->where('scan_title', $scan->scan_title);
            })
            ->latest()
            ->take(18)
            ->get();

        return view('result.notsafe', [
            'scan_id' => $scan_id,
            'relatedComments' => $relatedComments
        ]);
    }

    public function full($scan_id)
    {
        $scan = $this->authorizeScanAccess($scan_id);
        if (!$scan instanceof \App\Models\Scan) return $scan;

        $reportLines = explode("\n", $scan->full_report);
        $filename = $scan->scan_title;
        $result = $scan->scan_result;

        return view('result.fullreport', compact('reportLines', 'filename', 'scan', 'result'));
    }
}

