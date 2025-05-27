<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Scan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'scan_id' => 'required|exists:scans,scan_id',
            'comment' => 'required|string|max:1000'
        ]);

        // Verify the scan belongs to the user
        $scan = Scan::where('scan_id', $request->scan_id)
                   ->where('user_id', Auth::id())
                   ->firstOrFail();

        $comment = new Comment();
        $comment->scan_id = $request->scan_id;
        $comment->user_id = Auth::id();
        $comment->content = $request->comment;
        $comment->save();

        return response()->json(['message' => 'Comment added successfully']);
    }
}