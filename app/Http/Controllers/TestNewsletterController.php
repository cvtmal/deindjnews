<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

class TestNewsletterController extends Controller
{
    public function sendTest()
    {
        // Run the test newsletter command
        $exitCode = Artisan::call('newsletter:send-test');

        // Get the output from the command
        $output = Artisan::output();

        // Parse the output to extract results
        $lines = explode("\n", $output);
        $results = [];
        $summary = false;

        foreach ($lines as $line) {
            // Check for the summary section
            if (str_contains($line, '--- Summary ---')) {
                $summary = true;
                continue;
            }

            // Extract results from summary
            if ($summary && trim($line) !== '') {
                if (preg_match('/([✓✗⊘?])\s+(.+):\s+(.+)/', $line, $matches)) {
                    $results[] = [
                        'symbol' => $matches[1],
                        'email' => $matches[2],
                        'status' => $matches[3],
                        'status_class' => match($matches[3]) {
                            'success' => 'success',
                            'failed' => 'danger',
                            'skipped' => 'warning',
                            'missing' => 'secondary',
                            default => 'info'
                        }
                    ];
                }
            }
        }

        // Determine overall status
        $hasSuccess = false;
        $hasFailed = false;
        foreach ($results as $result) {
            if ($result['status'] === 'success') {
                $hasSuccess = true;
            }
            if ($result['status'] === 'failed') {
                $hasFailed = true;
            }
        }

        $overallStatus = $hasSuccess ? 'success' : ($hasFailed ? 'partial' : 'info');

        return view('test-newsletter-result', [
            'results' => $results,
            'output' => $output,
            'exitCode' => $exitCode,
            'overallStatus' => $overallStatus,
        ]);
    }
}
