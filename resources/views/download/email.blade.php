<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email Scan Report</title>
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
    <h2>Email Scan Report</h2>
    <p><strong>Date:</strong> {{ $scan->created_at }}</p>

    @if (!empty($json['classification']))
        <h4>Classification</h4>
        <p>Label: {{ $json['classification']['label'] }}</p>
        <p>Confidence: {{ number_format($json['classification']['confidence'], 2) }}</p>
    @endif

    @if (!empty($json['urls']))
        <h4>URLs</h4>
        <table>
            <tr><th>URL</th><th>Obfuscated</th><th>Malicious</th><th>Suspicious</th><th>Harmless</th></tr>
            @foreach ($json['urls'] as $u)
                <tr>
                    <td>{{ $u['url'] }}</td>
                    <td>{{ $u['obfuscated'] ? 'Yes' : 'No' }}</td>
                    <td>{{ $u['malicious'] }}</td>
                    <td>{{ $u['suspicious'] }}</td>
                    <td>{{ $u['harmless'] }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    @if (!empty($json['final_assessment']))
        <h4>Final Assessment</h4>
        <p>Status: {{ $json['final_assessment']['status'] }}</p>
        <p>Score: {{ number_format($json['final_assessment']['score'], 2) }}</p>
    @endif
</body>
</html>
