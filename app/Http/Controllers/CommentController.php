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

        // Use ID 1 for guest (you can also use null if allowed)
        $userId = Auth::check() ? Auth::id() : 1;

        $comment = new Comment();
        $comment->scan_id = $request->scan_id;
        $comment->user_id = $userId;
        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['message' => 'Comment added successfully']);
    }
}
