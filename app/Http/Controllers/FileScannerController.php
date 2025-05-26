<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log;

class FileScannerController extends Controller
{
    public function index()
    {
        return view('scanner.filescanner');
    }

    public function scan(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:exe|max:51200', // 50MB max .exe
        ]);

        $path = $request->file('file')->store('uploads');
        $absolutePath = storage_path('app/' . $path);
        $scriptPath = base_path('backend_scanner/file_scanner/filescanner.py');

        if (!file_exists($absolutePath)) {
            Log::error("❌ File tidak ditemukan: " . $absolutePath);
            return back()->withErrors(['error' => 'Uploaded file not found.']);
        }

        if (!file_exists($scriptPath)) {
            Log::error("❌ Script Python tidak ditemukan: " . $scriptPath);
            return back()->withErrors(['error' => 'Scanner backend not found.']);
        }

        Log::info("⏳ Menjalankan scanner Python untuk file: " . $absolutePath);
        $process = new Process(["python3", $scriptPath, $absolutePath]);
        $process->run();

        if (!$process->isSuccessful()) {
            Log::error("❌ Scanning gagal: " . $process->getErrorOutput());
            return back()->withErrors(['error' => 'Scanning failed.']);
        }

        $output = explode("\n", trim($process->getOutput()));
        Log::info("✅ Scanning selesai untuk file: " . $absolutePath);

        // 🔎 Tentukan status berdasarkan string "STATUS: ..."
        $status = "safe";
        foreach ($output as $line) {
            if (strpos($line, "STATUS: NOT_SAFE") !== false) {
                $status = "not_safe";
                break;
            } elseif (strpos($line, "STATUS: SUSPICIOUS") !== false) {
                $status = "suspicious";
            }
        }

        $data = [
            'reportLines' => $output,
            'filename' => $request->file('file')->getClientOriginalName(),
        ];

        return match ($status) {
            'safe' => view('scanner.safe', $data),
            'suspicious' => view('scanner.suspicious', $data),
            default => view('scanner.notsafe', $data),
        };
    }

    public function downloadReport($filename)
    {
        $path = storage_path("reports/{$filename}.txt");

        if (!file_exists($path)) {
            return back()->withErrors(['error' => 'Report not found.']);
        }

        return response()->download($path);
    }
}
