<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>URL Scan Report</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }

        h2 {
            color: #F24822;
        }

        h5 {
            margin-top: 24px;
        }

        .container {
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 8px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 12px;
        }

        th,
        td {
            border: 1px solid #ccc;
            padding: 6px;
            text-align: left;
        }

        th {
            background-color: #eee;
            white-space: normal;
        }

        .column {
            width: 48%;
            display: inline-block;
            vertical-align: top;
            margin-right: 2%;
        }
    </style>
</head>

<body>
    <h2>URL Scan Report</h2>
    <p><strong>Scan Result:</strong> {{ $scan->scan_result }}</p>
    <p><strong>Date:</strong> {{ $scan->created_at }}</p>

    @php
        $json = json_decode($scan->full_report, true);
    @endphp

    @if (is_array($json))
        <div class="container">
            <h5>Scan Summary</h5>
            <table>
                <tbody>
                    <tr>
                        <th>Model Prediction</th>
                        <td>{{ $json['Model Prediction'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Confidence</th>
                        <td>{{ $json['Confidence'] ?? 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>WHOIS Safe</th>
                        <td>{{ isset($json['WHOIS Safe']) ? ($json['WHOIS Safe'] ? 'Yes' : 'No') : 'N/A' }}</td>
                    </tr>
                    <tr>
                        <th>Reason</th>
                        <td>{{ $json['Reason'] ?? 'N/A' }}</td>
                    </tr>
                </tbody>
            </table>

            @if (isset($json['Features']) && is_array($json['Features']))
                <h5>Extracted Features</h5>
                <h5>Extracted Features</h5>
                <table>
                    <tbody>
                        @php
                            $features = $json['Features'];
                            $keys = array_keys($features);
                            $total = count($keys);
                            $half = ceil($total / 2);
                        @endphp

                        @for ($i = 0; $i < $half; $i++)
                            <tr>
                                {{-- Left Column --}}
                                <th>{{ $keys[$i] }}</th>
                                <td>
                                    @php $value = $features[$keys[$i]]; @endphp
                                    {{ is_numeric($value) ? rtrim(rtrim(number_format((float) $value, 6, '.', ''), '0'), '.') : $value }}
                                </td>

                                {{-- Right Column --}}
                                @if (isset($keys[$i + $half]))
                                    <th>{{ $keys[$i + $half] }}</th>
                                    <td>
                                        @php $value = $features[$keys[$i + $half]]; @endphp
                                        {{ is_numeric($value) ? rtrim(rtrim(number_format((float) $value, 6, '.', ''), '0'), '.') : $value }}
                                    </td>
                                @else
                                    <th></th>
                                    <td></td>
                                @endif
                            </tr>
                        @endfor
                    </tbody>
                </table>

            @endif
        </div>
    @else
        <pre class="container" style="font-family: monospace; white-space: pre-wrap;">
{{ json_encode($json, JSON_PRETTY_PRINT) }}
        </pre>
    @endif
</body>

</html>
