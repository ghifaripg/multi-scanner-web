<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\Scan;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

class EmailScannerController extends Controller
{
    public function showForm()
        {
            return view('scanner.emailscanner'); // Make sure this matches your actual view
        }

    public function submit(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|file|mimes:eml|max:10240' // Added max size (10MB)
        ]);

        try {
            $file = $request->file('email');
            $fastApiUrl = config('app.fastapi_url', 'http://127.0.0.1:8001');

            $response = Http::timeout(120) // Added timeout
                ->attach(
                    'file',
                    file_get_contents($file->getRealPath()),
                    $file->getClientOriginalName()
                )->post("{$fastApiUrl}/scan-email");

            if ($response->failed()) {
                Log::error('Email scan failed', [
                    'status' => $response->status(),
                    'response' => $response->body()
                ]);
                return back()->with('error', 'Scan failed: API returned ' . $response->status());
            }

            $data = $response->json();
            
            $scan = Scan::create([
                'user_id' => Auth::id() ?? 1, // Simplified null coalescing
                'scan_title' => $data['header_analysis']['From'] ?? 'Unknown Sender',
                'scan_type' => 'email',
                'scan_result' => $data['final_assessment']['status'],
                'full_report' => json_encode($data, JSON_PRETTY_PRINT),
            ]);

            Session::put('latest_scan_id', $scan->scan_id);

            return $this->routeToResult($data['final_assessment']['status'], $scan->scan_id);

        } catch (\Exception $e) {
            Log::error('Email scan exception', ['error' => $e->getMessage()]);
            return back()->with('error', 'Scan error: ' . $e->getMessage());
        }
    }

    protected function routeToResult(string $status, int $scanId)
    {
        return match ($status) {
            'Safe' => redirect()->route('result.safe', $scanId),
            'Suspicious (Review Needed)' => redirect()->route('result.suspicious', $scanId),
            default => redirect()->route('result.notsafe', $scanId),
        };
    }
}