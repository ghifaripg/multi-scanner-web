<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Scan Report PDF</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { color: #F24822; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; vertical-align: top; }
        th { background-color: #eee; }
        ul { padding-left: 20px; margin: 0; }
    </style>
</head>
<body>
    <h2>ThreatPeek - File Scan Report</h2>

    <p><strong>Filename:</strong> {{ $json['features']['filename'] ?? '-' }}</p>
    <p><strong>Date:</strong> {{ $scan->created_at }}</p>
    <p><strong>Scan Result:</strong> {{ $json['result'] ?? $scan->scan_result }}</p>
    <p><strong>Threat Score:</strong> {{ $json['threat_score'] ?? '-' }}</p>
    <p><strong>Reason:</strong> {{ $json['reason'] ?? '-' }}</p>

    <table>
        <tr><th>File Size</th><td>{{ number_format($json['features']['file_size'] ?? 0) }} bytes</td></tr>
        <tr><th>File Type</th><td>{{ $json['features']['file_type'] ?? '-' }}</td></tr>
        <tr><th>MD5</th><td>{{ $json['features']['md5'] ?? '-' }}</td></tr>
        <tr><th>SHA-1</th><td>{{ $json['features']['sha1'] ?? '-' }}</td></tr>
        <tr><th>SHA-256</th><td>{{ $json['features']['sha256'] ?? '-' }}</td></tr>
        <tr><th>Entropy</th><td>{{ $json['features']['entropy'] ?? '-' }}</td></tr>
        <tr><th>Non-ASCII Ratio</th><td>{{ $json['features']['non_ascii_ratio'] ?? '-' }}</td></tr>
        <tr><th>Sandbox Detection</th><td>{{ $json['features']['sandbox_detected'] ?? 'Not detected' }}</td></tr>

        <tr>
            <th>Embedded URLs/IPs</th>
            <td>
                @if (!empty($json['features']['embedded_urls_ips']))
                    <ul>
                        @foreach ($json['features']['embedded_urls_ips'] as $url)
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
                @if (!empty($json['features']['suspicious_api_calls']))
                    <ul>
                        @foreach ($json['features']['suspicious_api_calls'] as $api)
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
                @if (!empty($json['features']['strings_sample']))
                    <ul>
                        @foreach ($json['features']['strings_sample'] as $string)
                            <li>{{ $string }}</li>
                        @endforeach
                    </ul>
                @else
                    -
                @endif
            </td>
        </tr>

        @if (!empty($json['indicators']))
            <tr>
                <th>Indicators</th>
                <td>
                    <ul>
                        @foreach ($json['indicators'] as $indicator)
                            <li>
                                <strong>{{ ucfirst($indicator['type']) }}:</strong>
                                @if (is_array($indicator['value']))
                                    <ul>
                                        @foreach ($indicator['value'] as $val)
                                            <li>{{ $val }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{ $indicator['value'] }}
                                @endif
                            </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        @endif

        @if (!empty($json['verdicts']))
            <tr>
                <th>Verdicts</th>
                <td>
                    <ul>
                        @foreach ($json['verdicts'] as $verdict)
                            <li>{{ $verdict }}</li>
                        @endforeach
                    </ul>
                </td>
            </tr>
        @endif
    </table>
</body>
</html>
