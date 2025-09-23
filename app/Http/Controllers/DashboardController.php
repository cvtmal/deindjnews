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

        // Get recent activity (last 10 sent newsletters)
        $recentActivity = Subscriber::whereNotNull('sent_at')
            ->orderBy('sent_at', 'desc')
            ->limit(20)
            ->get(['email', 'name', 'sent_at', 'unsubscribed_at']);

        // Get sending statistics by day for the last 7 days
        $dailyStats = Subscriber::whereNotNull('sent_at')
            ->where('sent_at', '>=', now()->subDays(7))
            ->selectRaw('DATE(sent_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return view('dashboard', compact(
            'totalSubscribers',
            'sentCount',
            'pendingCount',
            'unsubscribedCount',
            'sendRate',
            'unsubscribeRate',
            'recentActivity',
            'dailyStats'
        ));
    }
}
