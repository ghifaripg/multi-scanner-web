<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Scan;
use Illuminate\Support\Facades\Session;

class UrlScannerController extends Controller
{
    public function showScanner()
    {
        return view('scanner.urlscanner');
    }

    public function doScan(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
        ]);

        $url = $request->input('url');
        $response = Http::post('http://127.0.0.1:8001/predict', ['url' => $url]);

        if ($response->failed()) {
            return back()->with('error', 'Failed to scan the URL.');
        }

        $data = $response->json();
        $userId = Auth::check() ? Auth::id() : 0;

        $scan = Scan::create([
            'user_id' => $userId,
            'scan_title' => $url,
            'scan_type' => 'url',
            'scan_result' => $data['result'],
            'full_report' => json_encode($data['features'], JSON_PRETTY_PRINT),
        ]);

        $scanId = $scan->scan_id;

        // Save to session
        Session::put('latest_scan_id', $scanId);

        return match ($data['result']) {
            'Safe' => redirect()->route('result.safe', ['scan_id' => $scanId]),
            'Suspicious' => redirect()->route('result.suspicious', ['scan_id' => $scanId]),
            default => redirect()->route('result.notsafe', ['scan_id' => $scanId]),
        };
    }
}
