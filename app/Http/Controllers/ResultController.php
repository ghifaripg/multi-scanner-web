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

        return view('result.fullreport', compact('reportLines', 'filename'));
    }

        public function storeComment(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'scan_id' => 'required|exists:scans,id',
            'comment' => 'required|string|max:1000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        // Check scan access
        $scan = $this->authorizeScanAccess($request->scan_id);
        if (!$scan instanceof \App\Models\Scan) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }

        // Create the comment
        try {
            $comment = Comment::create([
                'scan_id' => $request->scan_id,
                'user_id' => Auth::id() ?? 1,
                'comment' => $request->comment,
                'created_at' => now(),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Comment saved successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to save comment: ' . $e->getMessage()
            ], 500);
        }
    }
}

