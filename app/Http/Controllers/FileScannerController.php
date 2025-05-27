<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Scan;
use Illuminate\Support\Facades\Auth;

class FileScannerController extends Controller
{
    public function index()
    {
        return view('scanner.filescanner');
    }

    public function scan(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:exe,pdf|max:51200', // 50MB max
        ]);

        try {
            $file = $request->file('file');
            $userId = Auth::check() ? Auth::id() : 0;

            // Send file to FastAPI
            $userId = Auth::check() ? Auth::id() : 0;
            $client = new \GuzzleHttp\Client();
            $response = $client->request('POST', 'http://127.0.0.1:8000/predict/file', [
                'multipart' => [
                    [
                        'name'     => 'file',
                        'contents' => fopen($file->getPathname(), 'r'),
                        'filename' => $file->getClientOriginalName(),
                    ],
                ],
            ]);

            $data = json_decode($response->getBody()->getContents(), true);

            // Save scan result
            $scan = Scan::create([
                'user_id' => $userId,
                'scan_title' => $file->getClientOriginalName(),
                'scan_type' => 'file',
                'scan_result' => $data['result'],
                'full_report' => json_encode($data['features'], JSON_PRETTY_PRINT),
            ]);

            return match ($data['result']) {
                'Safe' => redirect()->route('result.safe', ['scan_id' => $scan->id]),
                'Suspicious' => redirect()->route('result.suspicious', ['scan_id' => $scan->id]),
                default => redirect()->route('result.notsafe', ['scan_id' => $scan->id]),
            };
        } catch (\Exception $e) {
            Log::error("File scan error: " . $e->getMessage());
            return back()->with('error', 'File scanning failed. Please try again.');
        }
    }
}
