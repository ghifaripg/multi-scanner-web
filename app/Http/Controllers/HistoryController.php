<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\Scan;
use App\Models\User;
use App\Models\Comment;

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
        $result = $scan->scan_result;

        return view('result.fullreport', compact('reportLines', 'filename', 'scan', 'result'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'scan_id' => 'required|exists:scans,id', // Changed from scan_id to id if that's your primary key
            'comment' => 'required|string|max:1000'
        ]);

        // Verify the scan belongs to the user
        $scan = Scan::where('id', $request->scan_id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        // Check if comment already exists for this user and scan
        $existingComment = Comment::where('scan_id', $request->scan_id)
            ->where('user_id', Auth::id())
            ->first();

        if ($existingComment) {
            // Instead of returning error, update the existing comment
            $existingComment->update(['comment' => $request->comment]);
            return response()->json(['message' => 'Comment updated successfully']);
        }

        // Create new comment if none exists
        $comment = Comment::create([
            'scan_id' => $request->scan_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment
        ]);

        return response()->json(['message' => 'Comment added successfully']);
    }

    public function check(Request $request)
    {
        $request->validate([
            'scan_id' => 'required|exists:scans,scan_id'
        ]);

        $comment = Comment::where('scan_id', $request->scan_id)
            ->where('user_id', Auth::id())
            ->first();

        return response()->json($comment);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string|max:1000'
        ]);

        $comment = Comment::where('id', $id)
            ->where('user_id', Auth::id())
            ->first();

        if (!$comment) {
            return response()->json(['message' => 'Comment not found or unauthorized'], 404);
        }

        $comment->update([
            'comment' => $request->comment
        ]);

        return response()->json(['message' => 'Comment updated successfully']);
    }
}
