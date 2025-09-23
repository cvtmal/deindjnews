<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>DeinDJ Newsletter Dashboard</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles -->
    @vite(['resources/css/app.css'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] min-h-screen">
    <!-- Header -->
    <header class="border-b border-[#e3e3e0] dark:border-[#3E3E3A] bg-white dark:bg-[#161615]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center space-x-4">
                    <div class="bg-white dark:bg-gray-100 rounded px-2 py-1">
                        <img src="https://deindj.ch/wp-content/uploads/2022/02/DeinDJ-Logo-Dark-2.svg"
                             alt="DeinDJ Logo"
                             class="h-6 w-auto">
                    </div>
                    <h1 class="text-xl font-semibold">Newsletter Dashboard</h1>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Metrics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <!-- Total Subscribers -->
            <div class="bg-white dark:bg-[#161615] p-6 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Total Subscribers</p>
                        <p class="text-2xl font-semibold mt-1">{{ number_format($totalSubscribers) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-[#dbdbd7] dark:bg-[#3E3E3A] rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Sent -->
            <div class="bg-white dark:bg-[#161615] p-6 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Newsletters Sent</p>
                        <p class="text-2xl font-semibold mt-1">{{ number_format($sentCount) }}</p>
                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">{{ $sendRate }}% complete</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending -->
            <div class="bg-white dark:bg-[#161615] p-6 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Pending</p>
                        <p class="text-2xl font-semibold mt-1">{{ number_format($pendingCount) }}</p>
                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">Ready to send</p>
                    </div>
                    <div class="w-12 h-12 bg-yellow-100 dark:bg-yellow-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Unsubscribed -->
            <div class="bg-white dark:bg-[#161615] p-6 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">Unsubscribed</p>
                        <p class="text-2xl font-semibold mt-1">{{ number_format($unsubscribedCount) }}</p>
                        <p class="text-xs text-[#706f6c] dark:text-[#A1A09A] mt-1">{{ $unsubscribeRate }}% rate</p>
                    </div>
                    <div class="w-12 h-12 bg-red-100 dark:bg-red-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Click Statistics Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <!-- Click Rate -->
            <div class="bg-white dark:bg-[#161615] p-6 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
                <h2 class="text-lg font-semibold mb-4">Engagement Rate</h2>
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $clickRate }}%</p>
                        <p class="text-sm text-[#706f6c] dark:text-[#A1A09A] mt-1">{{ $clickedCount }} of {{ $sentCount }} recipients clicked</p>
                    </div>
                    <div class="w-16 h-16 bg-green-100 dark:bg-green-900/20 rounded-full flex items-center justify-center">
                        <svg class="w-8 h-8 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 15l-2 5L9 9l11 4-5 2z"></path>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Popular Links -->
            <div class="bg-white dark:bg-[#161615] p-6 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A]">
                <h2 class="text-lg font-semibold mb-4">Most Clicked Links</h2>
                @if($popularLinks->count() > 0)
                    <div class="space-y-3">
                        @foreach($popularLinks as $link)
                            <div class="flex items-center justify-between">
                                <div class="flex items-center space-x-2">
                                    <span class="text-sm font-medium">{{ $link->link }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <div class="w-24 bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                                        <div class="bg-blue-600 dark:bg-blue-500 h-2 rounded-full"
                                             style="width: {{ $clickedCount > 0 ? round(($link->clicks / $clickedCount) * 100) : 0 }}%"></div>
                                    </div>
                                    <span class="text-sm text-[#706f6c] dark:text-[#A1A09A] min-w-[40px] text-right">{{ $link->clicks }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-[#706f6c] dark:text-[#A1A09A]">No clicks recorded yet</p>
                @endif
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="bg-white dark:bg-[#161615] p-6 rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] mb-8">
            <h2 class="text-lg font-semibold mb-4">Sending Progress</h2>
            <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-4">
                <div class="bg-green-600 dark:bg-green-500 h-4 rounded-full" style="width: {{ $sendRate }}%"></div>
            </div>
            <div class="flex justify-between mt-2 text-sm text-[#706f6c] dark:text-[#A1A09A]">
                <span>{{ number_format($sentCount) }} sent</span>
                <span>{{ number_format($pendingCount) }} remaining</span>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="bg-white dark:bg-[#161615] rounded-lg border border-[#e3e3e0] dark:border-[#3E3E3A] overflow-hidden">
            <div class="px-6 py-4 border-b border-[#e3e3e0] dark:border-[#3E3E3A]">
                <h2 class="text-lg font-semibold">Recent Activity</h2>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 dark:bg-gray-900/50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">Name</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">Sent At</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">Last Click</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-[#706f6c] dark:text-[#A1A09A] uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#e3e3e0] dark:divide-[#3E3E3A]">
                        @forelse($recentActivity as $activity)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $activity->email }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">{{ $activity->name ?: '-' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                {{ $activity->sent_at->format('M d, Y H:i') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($activity->last_clicked_link)
                                    <div class="flex flex-col">
                                        <span class="font-medium text-green-600 dark:text-green-400">{{ $activity->last_clicked_link }}</span>
                                        @if($activity->last_clicked_at)
                                            <span class="text-xs text-[#706f6c] dark:text-[#A1A09A]">
                                                {{ \Carbon\Carbon::parse($activity->last_clicked_at)->diffForHumans() }}
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-[#706f6c] dark:text-[#A1A09A]">No clicks yet</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                @if($activity->unsubscribed_at)
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                        Unsubscribed
                                    </span>
                                @else
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                        Sent
                                    </span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-[#706f6c] dark:text-[#A1A09A]">
                                No newsletters sent yet
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>