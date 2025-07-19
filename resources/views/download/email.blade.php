<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Email Scan Report</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2 { color: #F24822; }
        h4 { margin-top: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 8px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2>ThreatPeek - Email Scan Report</h2>
    <p><strong>Scan Result:</strong> {{ $scan->scan_result }}</p>
    <p><strong>Date:</strong> {{ $scan->created_at }}</p>

    {{-- Classification --}}
    @if (!empty($json['classification']))
        <h4>Classification</h4>
        <p>Label: {{ $json['classification']['label'] }}</p>
        <p>Confidence: {{ number_format($json['classification']['confidence'], 2) }}</p>
    @endif

    {{-- Attachments --}}
    @if (!empty($json['attachments']))
        <h4>Attachments</h4>
        <table>
            <tr><th>File</th><th>Malicious</th><th>Suspicious</th><th>Harmless</th></tr>
            @foreach ($json['attachments'] as $file)
                <tr>
                    <td>{{ $file['file'] }}</td>
                    <td>{{ $file['malicious'] }}</td>
                    <td>{{ $file['suspicious'] }}</td>
                    <td>{{ $file['harmless'] }}</td>
                </tr>
            @endforeach
        </table>
    @endif

    {{-- URLs --}}
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

    {{-- Header Analysis --}}
    @if (!empty($json['header_analysis']))
        <h4>Header Analysis</h4>

        @if (!empty($json['header_analysis']['authentication']))
            <p><strong>Authentication:</strong></p>
            <ul>
                <li>SPF: {{ $json['header_analysis']['authentication']['SPF'] ?? '-' }}</li>
                <li>DKIM: {{ $json['header_analysis']['authentication']['DKIM'] ?? '-' }}</li>
                <li>DMARC: {{ $json['header_analysis']['authentication']['DMARC'] ?? '-' }}</li>
            </ul>
        @endif

        @if (!empty($json['header_analysis']['domain_check']))
            <p><strong>Domain Check:</strong></p>
            <ul>
                <li>From Domain: {{ $json['header_analysis']['domain_check']['from_domain'] }}</li>
                <li>Return Domain: {{ $json['header_analysis']['domain_check']['return_domain'] }}</li>
                <li>Authenticated Domain: {{ $json['header_analysis']['domain_check']['auth_domain'] }}</li>
                <li>Mismatch Detected: {{ $json['header_analysis']['domain_check']['mismatch_detected'] ? 'Yes' : 'No' }}</li>
            </ul>
        @endif

        @if (!empty($json['header_analysis']['ip_reputation']))
            <p><strong>IP Reputation:</strong></p>
            <ul>
                <li>IP Address: {{ $json['header_analysis']['ip_reputation']['ipAddress'] }}</li>
                <li>Domain: {{ $json['header_analysis']['ip_reputation']['domain'] }}</li>
                <li>Country Code: {{ $json['header_analysis']['ip_reputation']['countryCode'] }}</li>
                <li>Abuse Confidence Score: {{ $json['header_analysis']['ip_reputation']['abuseConfidenceScore'] }}</li>
                <li>Whitelisted: {{ $json['header_analysis']['ip_reputation']['isWhitelisted'] ? 'Yes' : 'No' }}</li>
            </ul>
        @endif
    @endif

    {{-- Final Assessment --}}
    @if (!empty($json['final_assessment']))
        <h4>Final Assessment</h4>
        <p>Status: {{ $json['final_assessment']['status'] }}</p>
        <p>Score: {{ number_format($json['final_assessment']['score'], 2) }}</p>
    @endif

</body>
</html>
