<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;

class DashboardController extends Controller
{
    public function index()
    {
        // Get total subscribers count
        $totalSubscribers = Subscriber::count();

        // Get sent newsletters count
        $sentCount = Subscriber::whereNotNull('sent_at')->count();

        // Get pending (unsent and not unsubscribed) count
        $pendingCount = Subscriber::whereNull('sent_at')
            ->whereNull('unsubscribed_at')
            ->count();

        // Get unsubscribed count
        $unsubscribedCount = Subscriber::whereNotNull('unsubscribed_at')->count();

        // Calculate rates
        $sendRate = $totalSubscribers > 0 ? round(($sentCount / $totalSubscribers) * 100, 1) : 0;
        $unsubscribeRate = $totalSubscribers > 0 ? round(($unsubscribedCount / $totalSubscribers) * 100, 1) : 0;

        // Get recent activity (all sent newsletters) including click data
        $recentActivity = Subscriber::whereNotNull('sent_at')
            ->orderBy('sent_at', 'desc')
            ->get(['email', 'name', 'sent_at', 'unsubscribed_at', 'last_clicked_link', 'last_clicked_at']);

        // Get click statistics
        $clickedCount = Subscriber::whereNotNull('last_clicked_at')->count();
        $clickRate = $sentCount > 0 ? round(($clickedCount / $sentCount) * 100, 1) : 0;

        // Get popular links (top 5)
        $popularLinks = Subscriber::whereNotNull('last_clicked_link')
            ->selectRaw('last_clicked_link as link, COUNT(*) as clicks')
            ->groupBy('last_clicked_link')
            ->orderBy('clicks', 'desc')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'totalSubscribers',
            'sentCount',
            'pendingCount',
            'unsubscribedCount',
            'sendRate',
            'unsubscribeRate',
            'recentActivity',
            'clickedCount',
            'clickRate',
            'popularLinks'
        ));
    }
}
