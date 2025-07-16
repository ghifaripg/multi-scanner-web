<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>URL Scan Report</title>
    <p><strong>Scan Result:</strong> {{ $scan->scan_result }}</p>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { color: #F24822; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>URL Scan Report</h2>
    <p><strong>Date:</strong> {{ $scan->created_at }}</p>

    <table>
        @foreach ($json as $key => $value)
            <tr>
                <th>{{ ucfirst(str_replace('_', ' ', $key)) }}</th>
                <td>
                    @if (is_array($value))
                        {{ implode(', ', array_map('strval', $value)) }}
                    @else
                        {{ is_numeric($value) ? number_format($value, 4) : $value }}
                    @endif
                </td>
            </tr>
        @endforeach
    </table>
</body>
</html>
