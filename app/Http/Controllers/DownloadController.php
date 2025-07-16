<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Scan;
use Barryvdh\DomPDF\Facade\Pdf;

class DownloadController extends Controller
{
    public function download($scan_id)
    {
        $scan = Scan::findOrFail($scan_id);
        $json = json_decode($scan->full_report, true);

        if (!is_array($json)) {
            abort(404, 'Invalid report data.');
        }

        $view = match ($scan->scan_type) {
            'file' => 'download.file',
            'email' => 'download.email',
            'url' => 'download.url',
            default => abort(404, 'Unsupported scan type.'),
        };

        $pdf = Pdf::loadView($view, [
            'scan' => $scan,
            'json' => $json
        ]);

        return $pdf->download("scan_report_{$scan->id}.pdf");
    }
}
