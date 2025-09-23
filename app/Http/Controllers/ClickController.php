<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class ClickController extends Controller
{
    public function track(Request $request)
    {
        $url = $request->query('url');
        $email = $request->query('email');

        if (! $url || ! $email) {
            return redirect('/');
        }

        // Find subscriber and update click information
        $subscriber = Subscriber::where('email', $email)->first();

        if ($subscriber) {
            // Extract link name from URL
            $linkName = $this->extractLinkName($url);

            $subscriber->last_clicked_link = $linkName;
            $subscriber->last_clicked_at = now();
            $subscriber->save();
        }

        // Validate URL is for deindj.ch
        if (! str_contains($url, 'deindj.ch')) {
            return redirect('/');
        }

        // Redirect to the target URL
        return redirect()->away($url);
    }

    private function extractLinkName($url)
    {
        $linkMap = [
            '/saxophonisten' => 'Saxophonisten',
            '/partybands' => 'Partybands',
            '/saenger' => 'Sänger',
            '/traurednerinnen' => 'Trauredner',
            '/hochzeitsfotografen' => 'Fotografen',
            '/djs' => 'DJs',
        ];

        foreach ($linkMap as $path => $name) {
            if (str_contains($url, $path)) {
                return $name;
            }
        }

        // Check if it's the homepage
        $parsed = parse_url($url);
        if (isset($parsed['host']) && $parsed['host'] === 'deindj.ch' && (! isset($parsed['path']) || $parsed['path'] === '/')) {
            return 'Homepage';
        }

        return 'Jetzt anfragen'; // Default for CTA buttons
    }
}
