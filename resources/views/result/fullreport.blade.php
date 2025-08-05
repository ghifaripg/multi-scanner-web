@extends('layouts.app')

@section('content')
    <div class="position-relative" style="min-height: 680px; max-width: 1440px; margin: 0 auto; padding: 40px 32px 120px;">

        {{-- Konten utama --}}
        <div class="text-start" style="max-width: 100%;">
            <h1 class="fw-bold mb-4" style="color: #F24822; font-size: 2.25rem;">
                Scan Report: {{ $filename ?? 'Unknown File' }} - {{ $result ?? 'Unknown Result' }}
            </h1>

            @if ($scan->scan_type === 'email' && isset($reportLines))
                @php
                    $json = json_decode(implode('', $reportLines), true);
                @endphp

                @if (is_array($json))
                    <div class="bg-light rounded p-4">
                        {{-- Classification --}}
                        @if (isset($json['classification']))
                            <h5 class="fw-bold">Classification</h5>
                            <table class="table table-bordered table-sm mb-4">
                                <tbody>
                                    <tr>
                                        <th>Label</th>
                                        <td>{{ $json['classification']['label'] ?? '-' }}</td>
                                    </tr>
                                    <tr>
                                        <th>Confidence</th>
                                        <td>{{ number_format($json['classification']['confidence'] ?? 0, 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif

                        {{-- Attachments --}}
                        @if (!empty($json['attachments']))
                            <h5 class="fw-bold">Attachments</h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>File</th>
                                            <th>Malicious</th>
                                            <th>Suspicious</th>
                                            <th>Harmless</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($json['attachments'] as $attachment)
                                            <tr>
                                                <td style="word-break: break-word;">{{ $attachment['file'] }}</td>
                                                <td>{{ $attachment['malicious'] }}</td>
                                                <td>{{ $attachment['suspicious'] }}</td>
                                                <td>{{ $attachment['harmless'] }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @endif

                        {{-- URLs --}}
                        @if (!empty($json['urls']))
                            <h5 class="fw-bold">URLs</h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>URL</th>
                                            <th>Result</th>
                                            <th>Model Prediction</th>
                                            <th>Confidence</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($json['urls'] as $urlData)
                                            <tr>
                                                <td style="word-break: break-all;">{{ $urlData['url'] }}</td>
                                                <td>{{ $urlData['result'] }}</td>
                                                <td>{{ $urlData['model_prediction'] }}</td>
                                                <td>{{ $urlData['confidence'] }}</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>
                        @endif

                        {{-- Header Analysis --}}
                        @if (!empty($json['header_analysis']))
                            <h5 class="fw-bold">Header Analysis</h5>

                            {{-- Authentication --}}
                            @if (!empty($json['header_analysis']['authentication']))
                                <h6>Authentication</h6>
                                <table class="table table-bordered table-sm mb-3">
                                    <tbody>
                                        @foreach ($json['header_analysis']['authentication'] as $key => $value)
                                            <tr>
                                                <th>{{ strtoupper($key) }}</th>
                                                <td>{{ $value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                            {{-- Domain Check --}}
                            @if (!empty($json['header_analysis']['domain_check']))
                                <h6>Domain Check</h6>
                                <table class="table table-bordered table-sm mb-3">
                                    <tbody>
                                        @foreach ($json['header_analysis']['domain_check'] as $key => $value)
                                            <tr>
                                                <th>{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                                <td>{{ $value ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif

                            {{-- Sender IP --}}
                            <p><strong>Sender IP:</strong> {{ $json['header_analysis']['sender_ip'] ?? '-' }}</p>

                            {{-- IP Reputation --}}
                            @if (!empty($json['header_analysis']['ip_reputation']))
                                <h6>IP Reputation</h6>
                                <table class="table table-bordered table-sm mb-4">
                                    <tbody>
                                        @foreach ($json['header_analysis']['ip_reputation'] as $key => $value)
                                            <tr>
                                                <th>{{ ucwords(str_replace('_', ' ', $key)) }}</th>
                                                <td>{{ is_bool($value) ? ($value ? 'Yes' : 'No') : $value }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @endif
                        @endif

                        {{-- Final Assessment --}}
                        @if (!empty($json['final_assessment']))
                            <h5 class="fw-bold">Final Assessment</h5>
                            <table class="table table-bordered table-sm">
                                <tbody>
                                    <tr>
                                        <th>Status</th>
                                        <td>{{ $json['final_assessment']['status'] }}</td>
                                    </tr>
                                    <tr>
                                        <th>Score</th>
                                        <td>{{ number_format($json['final_assessment']['score'], 2) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                    </div>
                @else
                    <pre class="bg-light rounded p-4" style="font-family: monospace; white-space: pre-wrap;">
                {{ implode('', $reportLines) }}
            </pre>
                @endif
            @elseif ($scan->scan_type === 'url' && isset($reportLines))
                @php
                    $json = json_decode(implode('', $reportLines), true);
                @endphp

                @if (is_array($json))
                    <div class="bg-light rounded p-4">
                        <h5>Scan Summary</h5>
                        <table class="table table-bordered table-sm mb-4">
                            <tbody>
                                @foreach (['Model Prediction', 'Confidence', 'WHOIS Safe', 'Reason'] as $key)
                                    @if (isset($json[$key]))
                                        <tr>
                                            <th style="white-space: normal;">{{ $key }}</th>
                                            <td>
                                                @if ($key === 'WHOIS Safe')
                                                    {{ $json[$key] ? 'Yes' : 'No' }}
                                                @else
                                                    {{ $json[$key] }}
                                                @endif
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach
                            </tbody>
                        </table>


                        @if (isset($json['Features']) && is_array($json['Features']))
                            <h5>Extracted Features</h5>
                            <div class="row">
                                @php
                                    $features = $json['Features'];
                                    $half = ceil(count($features) / 2);
                                    $chunks = array_chunk($features, $half, true);
                                @endphp

                                @foreach ($chunks as $chunk)
                                    <div class="col-md-6">
                                        <table class="table table-bordered table-sm mb-4">
                                            <tbody>
                                                @foreach ($chunk as $key => $value)
                                                    <tr>
                                                        <th style="white-space: normal;">{{ $key }}</th>
                                                        <td>
                                                            @if (is_numeric($value))
                                                                {{ rtrim(rtrim(number_format((float) $value, 6, '.', ''), '0'), '.') }}
                                                            @else
                                                                {{ $value }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                @else
                    <pre class="bg-light rounded p-4" style="font-family: monospace; white-space: pre-wrap;">
        {{ implode('', $reportLines) }}
        </pre>
                @endif
            @elseif ($scan->scan_type === 'file' && isset($reportLines))
                @php
                    $json = json_decode(implode('', $reportLines), true);
                    $features = $json['features'] ?? [];
                @endphp

                @if (is_array($json))
                    <div class="bg-light rounded p-4">
                        <h5 class="fw-bold">File Scan Report</h5>

                        <p><strong>Result:</strong> {{ $json['result'] ?? '-' }}</p>
                        <p><strong>Threat Score:</strong> {{ $json['threat_score'] ?? '-' }}</p>
                        <p><strong>Reason:</strong> {{ $json['reason'] ?? '-' }}</p>

                        <hr>

                        <table class="table table-bordered table-sm mb-4">
                            <tbody>
                                <tr>
                                    <th>Filename</th>
                                    <td>{{ $features['filename'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>File Size</th>
                                    <td>{{ number_format($features['file_size'] ?? 0) }} bytes</td>
                                </tr>
                                <tr>
                                    <th>File Type</th>
                                    <td>{{ $features['file_type'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>MD5</th>
                                    <td style="word-break: break-all;">{{ $features['md5'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>SHA-1</th>
                                    <td style="word-break: break-all;">{{ $features['sha1'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>SHA-256</th>
                                    <td style="word-break: break-all;">{{ $features['sha256'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Entropy</th>
                                    <td>{{ $features['entropy'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Non-ASCII Ratio</th>
                                    <td>{{ $features['non_ascii_ratio'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Sandbox Detection</th>
                                    <td>{{ $features['sandbox_detected'] ?? 'Not detected' }}</td>
                                </tr>
                                <tr>
                                    <th>Embedded URLs/IPs</th>
                                    <td>
                                        @if (!empty($features['embedded_urls_ips']))
                                            <ul class="mb-0">
                                                @foreach ($features['embedded_urls_ips'] as $url)
                                                    <li style="word-break: break-all;">{{ $url }}</li>
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
                                        @if (!empty($features['suspicious_api_calls']))
                                            <ul class="mb-0">
                                                @foreach ($features['suspicious_api_calls'] as $api)
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
                                        @if (!empty($features['strings_sample']))
                                            <ul class="mb-0" style="max-height: 200px; overflow-y: auto;">
                                                @foreach ($features['strings_sample'] as $string)
                                                    <li style="word-break: break-all;">{{ $string }}</li>
                                                @endforeach
                                            </ul>
                                        @else
                                            -
                                        @endif
                                    </td>
                                </tr>
                            </tbody>
                        </table>


                    </div>
                @else
                    <pre class="bg-light rounded p-4" style="font-family: monospace; white-space: pre-wrap;">
{{ implode('', $reportLines) }}
        </pre>
                @endif
            @else
                <p class="text-muted fs-5 mb-5">
                    No report available.
                </p>
            @endif
        </div>
        {{-- Tombol Back dan Download sejajar dengan navbar & footer --}}
        <div id="report-page-buttons" class="d-flex align-items-center justify-content-between w-100 px-3"
            style="max-width: 1440px; position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);">

            <!-- The buttons have NO position styles! -->
            <a href="{{ url()->previous() }}" class="btn-back btn-rounded d-flex align-items-center">
                <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left me-2">
                Back
            </a>

            <a href="{{ route('report.download', ['scan_id' => request()->route('scan_id')]) }}"
                class="btn-orange text-decoration-none">
                Download Report
            </a>
        </div>
    @endsection
