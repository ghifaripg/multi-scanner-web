<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Scan Report PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { color: #F24822; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
        ul { padding-left: 20px; margin: 0; }
    </style>
</head>
<body>
    <h2>ThreatPeek - File Scan Report</h2>
    <p><strong>Filename:</strong> {{ $json['filename'] ?? '-' }}</p>
    <p><strong>Date:</strong> {{ $scan->created_at }}</p>
    <p><strong>Scan Result:</strong> {{ $scan->scan_result }}</p>

    <table>
        <tr><th>File Size</th><td>{{ number_format($json['file_size']) }} bytes</td></tr>
        <tr><th>File Type</th><td>{{ $json['file_type'] }}</td></tr>
        <tr><th>MD5</th><td>{{ $json['md5'] }}</td></tr>
        <tr><th>SHA-1</th><td>{{ $json['sha1'] }}</td></tr>
        <tr><th>SHA-256</th><td>{{ $json['sha256'] }}</td></tr>
        <tr><th>Entropy</th><td>{{ $json['entropy'] }}</td></tr>
        <tr><th>Non-ASCII Ratio</th><td>{{ $json['non_ascii_ratio'] }}</td></tr>
        <tr><th>Sandbox Detection</th><td>{{ $json['sandbox_detected'] ?? 'Not detected' }}</td></tr>
        <tr>
            <th>Embedded URLs/IPs</th>
            <td>
                @if (!empty($json['embedded_urls_ips']))
                    <ul>
                        @foreach ($json['embedded_urls_ips'] as $url)
                            <li>{{ $url }}</li>
                        @endforeach
                    </ul>
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <th>Suspicious API Calls</th>
            <td>
                @if (!empty($json['suspicious_api_calls']))
                    <ul>
                        @foreach ($json['suspicious_api_calls'] as $api)
                            <li>{{ $api }}</li>
                        @endforeach
                    </ul>
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <th>Sample Strings</th>
            <td>
                @if (!empty($json['strings_sample']))
                    <ul>
                        @foreach ($json['strings_sample'] as $string)
                            <li>{{ $string }}</li>
                        @endforeach
                    </ul>
                @else
                    -
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
