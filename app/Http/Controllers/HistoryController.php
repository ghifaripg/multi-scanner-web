<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
}