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

                        {{-- URLs --}}
                        @if (!empty($json['urls']))
                            <h5 class="fw-bold">URLs</h5>
                            <div class="table-responsive mb-4">
                                <table class="table table-bordered table-sm">
                                    <thead class="table-light">
                                        <tr>
                                            <th>URL</th>
                                            <th>Obfuscated</th>
                                            <th>Malicious</th>
                                            <th>Suspicious</th>
                                            <th>Harmless</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($json['urls'] as $urlData)
                                            <tr>
                                                <td style="word-break: break-all;">{{ $urlData['url'] }}</td>
                                                <td>{{ $urlData['obfuscated'] ? 'Yes' : 'No' }}</td>
                                                <td>{{ $urlData['malicious'] }}</td>
                                                <td>{{ $urlData['suspicious'] }}</td>
                                                <td>{{ $urlData['harmless'] }}</td>
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
                        <div class="row">
                            @php
                                // Split into two chunks
                                $half = ceil(count($json) / 2);
                                $chunks = array_chunk($json, $half, true);
                            @endphp

                            @foreach ($chunks as $chunk)
                                <div class="col-md-6">
                                    <table class="table table-bordered table-sm mb-4">
                                        <tbody>
                                            @foreach ($chunk as $key => $value)
                                                <tr>
                                                    <th style="white-space: normal;">{{ $key }}</th>
                                                    <td>{{ is_numeric($value) ? number_format($value, 4) : $value }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @else
                    <pre class="bg-light rounded p-4" style="font-family: monospace; white-space: pre-wrap;">
                    {{ implode('', $reportLines) }}
                    </pre>
                @endif
            @elseif ($scan->scan_type === 'file' && isset($reportLines))
                @php
                    $json = json_decode(implode('', $reportLines), true);
                @endphp

                @if (is_array($json))
                    <div class="bg-light rounded p-4">
                        <h5 class="fw-bold">File Scan Report</h5>
                        <table class="table table-bordered table-sm mb-4">
                            <tbody>
                                <tr>
                                    <th>Filename</th>
                                    <td>{{ $json['filename'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>File Size</th>
                                    <td>{{ number_format($json['file_size'] ?? 0) }} bytes</td>
                                </tr>
                                <tr>
                                    <th>File Type</th>
                                    <td>{{ $json['file_type'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>MD5</th>
                                    <td style="word-break: break-all;">{{ $json['md5'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>SHA-1</th>
                                    <td style="word-break: break-all;">{{ $json['sha1'] ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>SHA-256</th>
                                    <td style="word-break: break-all;">{{ $json['sha256'] ?? '-' }}</td>
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
        <div class="d-flex align-items-center justify-content-between w-100 px-3"
            style="max-width: 1440px; position: absolute; bottom: 20px; left: 50%; transform: translateX(-50%);">

            {{-- Tombol Back - Sejajar dengan Logo ThreatPeek --}}
            <a href="{{ url()->previous() }}" class="btn-back btn-rounded d-flex align-items-center"
                style="position: absolute; bottom: 20px; left: 0; margin: 0 24px;">
                <img src="{{ asset('images/arrow-left.svg') }}" alt="Back" class="icon-left me-2">
                Back
            </a>

            {{-- Tombol Download - Sejajar dengan Sign In --}}
            <a href="#" class="btn-orange text-decoration-none"
                style="position: absolute; bottom: 20px; right: 0; margin: 0 24px;">
                Download Report
            </a>
        </div>
    @endsection
