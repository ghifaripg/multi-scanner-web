<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Scan;

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

        // Send POST to FastAPI
        $response = Http::post('http://127.0.0.1:8001/predict', [ // adjust port if needed
            'url' => $url
        ]);

        if ($response->failed()) {
            return back()->with('error', 'Failed to scan the URL.');
        }

        $data = $response->json();

        // Save to DB only if user is logged in
        if (Auth::check()) {
            Scan::create([
                'user_id' => Auth::id(),
                'scan_title' => $url,
                'scan_type' => 'url',
                'scan_result' => $data['result'],
                'full_report' => json_encode($data['features'], JSON_PRETTY_PRINT),
            ]);
        }

        // Show result view or return back with result
        return back()->with([
            'result' => $data['result'],
            'confidence' => $data['confidence'] ?? null,
            'features' => $data['features'],
        ]);
    }
}
