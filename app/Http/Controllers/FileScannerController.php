<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Log; // Untuk debugging

class FileScannerController extends Controller
{
    public function index()
    {
        return view('scanner.filescanner'); // Halaman untuk upload file
    }

    public function scan(Request $request)
    {
        // Validasi file sebelum diproses
        $request->validate([
            'file' => 'required|file|mimes:exe|max:51200', // Hanya file .exe dengan ukuran max 50MB
        ]);

        // Simpan file sementara
        $path = $request->file('file')->store('uploads');
        $absolutePath = storage_path('app/' . $path);

        // Path ke skrip Python scanner
        $scriptPath = base_path('backend_scanner/file_scanner/filescanner.py');

        // Debug: Pastikan file dan script Python tersedia
        if (!file_exists($absolutePath)) {
            Log::error("❌ File yang di-scan tidak ditemukan: " . $absolutePath);
            return back()->withErrors(['error' => 'Uploaded file not found.']);
        }

        if (!file_exists($scriptPath)) {
            Log::error("❌ Python scanner script tidak ditemukan: " . $scriptPath);
            return back()->withErrors(['error' => 'Scanner backend not found.']);
        }

        // 🔹 Kirim file langsung ke Python scanner tanpa input manual!
        Log::info("⏳ Menjalankan scanner Python untuk file: " . $absolutePath);
        $process = new Process(["python3", $scriptPath, $absolutePath]); // Mengirim path file langsung
        $process->run();

        // Jika proses gagal, catat error dan kembali ke halaman upload
        if (!$process->isSuccessful()) {
            Log::error("❌ Scanning gagal: " . $process->getErrorOutput());
            return back()->withErrors(['error' => 'Scanning failed.']);
        }

        // Ambil output dari Python
        $output = explode("\n", trim($process->getOutput()));
        Log::info("✅ Scanning selesai untuk file: " . $absolutePath);
        
        // Tentukan status berdasarkan hasil scanning
        $status = "safe";
        foreach ($output as $line) {
            if (strpos($line, "Potential threat detected") !== false) {
                $status = "not_safe";
                break;
            } elseif (strpos($line, "Suspicious") !== false) {
                $status = "suspicious";
            }
        }

        // Kirim hasil scanning ke halaman utama result
        return view('scanner.result', [
            'reportLines' => $output,
            'filename' => $request->file('file')->getClientOriginalName(),
            'status' => $status
        ]);
    }

    public function downloadReport($filename)
    {
        // Path ke laporan hasil scanning
        $path = storage_path("reports/{$filename}.txt");

        if (!file_exists($path)) {
            return back()->withErrors(['error' => 'Report not found.']);
        }

        return response()->download($path);
    }
}