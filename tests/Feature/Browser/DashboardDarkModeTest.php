<?php

use App\Models\Subscriber;

it('can toggle dark mode on dashboard', function () {
    // Create some test data
    Subscriber::factory()->create([
        'email' => 'test@example.com',
        'sent_at' => now(),
    ]);

    $page = visit('/dashboard');

    // Check initial state (should be light mode by default)
    $page->assertScript('document.documentElement.className', 'light')
        ->assertVisible('svg.block.dark\\:hidden') // Moon icon visible in light mode
        ->assertNotVisible('svg.hidden.dark\\:block'); // Sun icon hidden in light mode

    // Click the toggle button
    $page->click('button[onclick="toggleTheme()"]');

    // Check that it switched to dark mode
    $page->assertScript('document.documentElement.className', 'dark')
        ->assertNotVisible('svg.block.dark\\:hidden') // Moon icon hidden in dark mode
        ->assertVisible('svg.hidden.dark\\:block'); // Sun icon visible in dark mode

    // Check localStorage was updated
    $page->assertScript('localStorage.getItem("theme")', 'dark');

    // Click toggle again to switch back
    $page->click('button[onclick="toggleTheme()"]');

    // Verify it's back to light mode
    $page->assertScript('document.documentElement.className', 'light')
        ->assertScript('localStorage.getItem("theme")', 'light');
});

it('remembers theme preference on page reload', function () {
    $page = visit('/dashboard');

    // Set to dark mode
    $page->click('button[onclick="toggleTheme()"]')
        ->assertScript('document.documentElement.className', 'dark');

    // Reload the page
    $page = visit('/dashboard');

    // Should still be in dark mode
    $page->assertScript('document.documentElement.className', 'dark');

    // Clean up - reset to light mode
    $page->script('localStorage.removeItem("theme")');
});
