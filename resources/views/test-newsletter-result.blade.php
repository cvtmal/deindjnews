<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Newsletter Result</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 40px;
            max-width: 600px;
            width: 100%;
        }

        h1 {
            color: #333;
            font-size: 28px;
            margin-bottom: 10px;
        }

        .subtitle {
            color: #666;
            margin-bottom: 30px;
            font-size: 14px;
        }

        .status-badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            margin-bottom: 30px;
        }

        .status-badge.success {
            background-color: #d4edda;
            color: #155724;
        }

        .status-badge.partial {
            background-color: #fff3cd;
            color: #856404;
        }

        .status-badge.info {
            background-color: #d1ecf1;
            color: #0c5460;
        }

        .results {
            margin-bottom: 30px;
        }

        .result-item {
            display: flex;
            align-items: center;
            padding: 15px;
            margin-bottom: 10px;
            background: #f8f9fa;
            border-radius: 8px;
            border-left: 4px solid;
        }

        .result-item.success {
            border-left-color: #28a745;
        }

        .result-item.danger {
            border-left-color: #dc3545;
        }

        .result-item.warning {
            border-left-color: #ffc107;
        }

        .result-item.secondary {
            border-left-color: #6c757d;
        }

        .result-symbol {
            font-size: 24px;
            margin-right: 15px;
            width: 30px;
            text-align: center;
        }

        .result-details {
            flex-grow: 1;
        }

        .result-email {
            font-weight: 600;
            color: #333;
            margin-bottom: 2px;
        }

        .result-status {
            font-size: 14px;
            color: #666;
        }

        .console-output {
            background: #1e1e1e;
            color: #d4d4d4;
            padding: 20px;
            border-radius: 8px;
            font-family: 'Courier New', monospace;
            font-size: 13px;
            line-height: 1.5;
            white-space: pre-wrap;
            word-wrap: break-word;
            margin-top: 30px;
            max-height: 400px;
            overflow-y: auto;
        }

        .console-output::-webkit-scrollbar {
            width: 8px;
        }

        .console-output::-webkit-scrollbar-track {
            background: #2e2e2e;
        }

        .console-output::-webkit-scrollbar-thumb {
            background: #555;
            border-radius: 4px;
        }

        .actions {
            display: flex;
            gap: 10px;
            margin-top: 30px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #667eea;
            color: white;
        }

        .btn-primary:hover {
            background: #5a67d8;
        }

        .btn-secondary {
            background: #e2e8f0;
            color: #4a5568;
        }

        .btn-secondary:hover {
            background: #cbd5e0;
        }

        .info-box {
            background: #f0f9ff;
            border: 1px solid #90cdf4;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 20px;
        }

        .info-box h3 {
            color: #1e40af;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .info-box p {
            color: #3b82f6;
            font-size: 14px;
            line-height: 1.5;
        }

        .toggle-output {
            background: none;
            border: none;
            color: #667eea;
            cursor: pointer;
            font-size: 14px;
            text-decoration: underline;
            margin-top: 20px;
        }

        .toggle-output:hover {
            color: #5a67d8;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Test Newsletter Result</h1>
        <p class="subtitle">{{ now()->format('F j, Y g:i A') }}</p>

        <div class="status-badge {{ $overallStatus }}">
            @if($overallStatus === 'success')
                All emails sent successfully
            @elseif($overallStatus === 'partial')
                Some emails sent
            @else
                No emails sent
            @endif
        </div>

        @if(empty($results))
            <div class="info-box">
                <h3>No Test Subscribers Found</h3>
                <p>Please create subscriber records for the test email addresses in the database before running this test.</p>
            </div>
        @else
            <div class="results">
                @foreach($results as $result)
                    <div class="result-item {{ $result['status_class'] }}">
                        <div class="result-symbol">{{ $result['symbol'] }}</div>
                        <div class="result-details">
                            <div class="result-email">{{ $result['email'] }}</div>
                            <div class="result-status">
                                @if($result['status'] === 'success')
                                    Successfully sent
                                @elseif($result['status'] === 'failed')
                                    Failed to send
                                @elseif($result['status'] === 'skipped')
                                    Already sent (skipped)
                                @elseif($result['status'] === 'missing')
                                    Not found in database
                                @else
                                    {{ ucfirst($result['status']) }}
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        <div class="actions">
            <a href="{{ route('newsletter.test') }}" class="btn btn-primary">Run Test Again</a>
            <a href="{{ route('dashboard') }}" class="btn btn-secondary">View Dashboard</a>
        </div>

        <button class="toggle-output" onclick="toggleOutput()">Toggle Console Output</button>

        <div class="console-output" id="console-output" style="display: none;">{{ $output }}</div>
    </div>

    <script>
        function toggleOutput() {
            const output = document.getElementById('console-output');
            if (output.style.display === 'none') {
                output.style.display = 'block';
            } else {
                output.style.display = 'none';
            }
        }
    </script>
</body>
</html>