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
        $response = Http::post('http://52.221.203.241:8000/predict/url', ['url' => $url]);

        if ($response->failed()) {
            return back()->with('error', 'Failed to scan the URL.');
        }

        $data = $response->json();
        $userId = Auth::check() ? Auth::id() : 1;

        $scan = Scan::create([
            'user_id' => $userId,
            'scan_title' => $url,
            'scan_type' => 'url',
            'scan_result' => $data['result'],
            'full_report' => json_encode([
                'Model Prediction' => $data['model_prediction'] ?? null,
                'Confidence' => $data['confidence'] ?? null,
                'WHOIS Safe' => $data['whois_safe'] ?? null,
                'Features' => $data['features'] ?? null,
                'Reason' => $data['reason'] ?? null,
            ], JSON_PRETTY_PRINT),

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
