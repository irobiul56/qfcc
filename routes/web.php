<?php

use App\Http\Controllers\EventController;
use App\Http\Controllers\DonationCampaignController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ProgramController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VolunteerController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\EventRegistrationController;
use App\Http\Controllers\VisionMissionController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SocialLinkController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/home', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', [VisionMissionController::class, 'about'])->name('about');

Route::get('/programs-and-services', [ProgramController::class, 'homeindex'])->name('programs');

Route::get('/activities/{slug}', [HomeController::class, 'singleactivity'])->name('single.activity');

Route::get('/blog', function () {
    return Inertia::render('Blog');
})->name('blog');



Route::get('/user', function () {
    return Inertia::render('User/Profile');
})->name('user.profile');


Route::get('/blog/{slug}', function ($slug) {
    return Inertia::render('Blog/Show', ['slug' => $slug]);
})->name('blog.show');

// Add these routes for CTA links

Route::get('/donate', [DonationCampaignController::class, 'create'])->name('donate');
Route::get('/donate/{campaign:slug}', [DonationCampaignController::class, 'show'])->name('donate.campaign');
Route::post('/donate/{campaign:slug}', [DonationCampaignController::class, 'donatestore'])->name('donate.store');

Route::get('/volunteer', function () {
    return Inertia::render('Volunteer');
})->name('volunteer');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

// Public contact form submission
Route::post('/contact', [ContactMessageController::class, 'store'])
    ->name('contact.store');


Route::get('/event', [EventController::class, 'create'])->name('event.create');
Route::post('/event/{event}/register', [EventRegistrationController::class, 'store'])
    ->name('event.register');
Route::get('/event/{event:slug}', [EventController::class, 'show'])->name('event.show');

Route::get('/get-involved', function(){
    return Inertia::render('Involved');
})->name('get-involved');

// Show the form
Route::get('/membership', [MembershipController::class, 'create'])
    ->name('membership.create');

// Store submission
Route::post('/membership', [MembershipController::class, 'store'])->name('membership.store');

Route::post('/membership/{membership}/payment', [MembershipController::class, 'confirmPayment'])
    ->name('membership.payment.confirm');

Route::get('/volunteer', [VolunteerController::class, 'create'])->name('volunteer.create');
Route::post('/volunteer', [VolunteerController::class, 'store'])->name('volunteer.store');


Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/admin/home', [HomeController::class, 'homeadmin'])->name('home.admin');

    Route::post('/slide/update', [HomeController::class, 'update'])->name('slide.update');
    
    // Program routes
    Route::resource('programs', ProgramController::class);

    // Toggle active status
    Route::patch('programs/{program}/toggle-status', [ProgramController::class, 'toggleStatus'])
        ->name('programs.toggle-status');


    Route::resource('events', EventController::class);

    // Toggle routes
    Route::patch('events/{event}/toggle-status', [EventController::class, 'toggleStatus'])
        ->name('events.toggle-status');

    Route::patch('events/{event}/toggle-featured', [EventController::class, 'toggleFeatured'])
        ->name('events.toggle-featured');

    // Resource route named "campaigns" (matches your sidebar)
    Route::resource('campaigns', DonationCampaignController::class);

    // Toggle routes
    Route::patch('campaigns/{campaign}/toggle-status', [DonationCampaignController::class, 'toggleStatus'])
        ->name('campaigns.toggle-status');

    Route::patch('campaigns/{campaign}/toggle-featured', [DonationCampaignController::class, 'toggleFeatured'])
        ->name('campaigns.toggle-featured');

    // Membership management routes
     Route::get('/admin/memberships', [MembershipController::class, 'index'])
        ->name('membership.index');

    Route::post('/admin/memberships/{membership}/approve', [MembershipController::class, 'approve'])
        ->name('membership.approve');

    Route::post('/admin/memberships/{membership}/reject', [MembershipController::class, 'reject'])
        ->name('membership.reject');

    Route::delete('/admin/memberships/{membership}', [MembershipController::class, 'destroy'])
        ->name('membership.destroy');

    // Volunteer management routes
    Route::get('/admin/volunteers', [VolunteerController::class, 'index'])->name('volunteer.index');
    Route::post('/admin/volunteers/{volunteer}/approve', [VolunteerController::class, 'approve'])->name('volunteer.approve');
    Route::post('/admin/volunteers/{volunteer}/reject', [VolunteerController::class, 'reject'])->name('volunteer.reject');
    Route::delete('/admin/volunteers/{volunteer}', [VolunteerController::class, 'destroy'])->name('volunteer.destroy');
    Route::post('/admin/volunteers/{volunteer}/restore', [VolunteerController::class, 'restore'])->name('volunteer.restore');
    
    // Contact message management routes
    Route::get('/admin/contact-messages', [ContactMessageController::class, 'index'])
        ->name('contact-messages.index');

    Route::post('/admin/contact-messages/{message}/read', [ContactMessageController::class, 'markRead'])
        ->name('contact-messages.read');

    Route::post('/admin/contact-messages/{message}/unread', [ContactMessageController::class, 'markUnread'])
        ->name('contact-messages.unread');

    Route::delete('/admin/contact-messages/{message}', [ContactMessageController::class, 'destroy'])
        ->name('contact-messages.destroy');

    // Event registration management routes
     Route::get('/admin/event-registrations', [EventRegistrationController::class, 'index'])
        ->name('event-registrations.index');

    Route::patch('/admin/event-registrations/{registration}/status', [EventRegistrationController::class, 'updateStatus'])
        ->name('event-registrations.update-status');

    Route::delete('/admin/event-registrations/{registration}', [EventRegistrationController::class, 'destroy'])
        ->name('event-registrations.destroy');

    Route::get('/admin/event-registrations/export', [EventRegistrationController::class, 'export'])
        ->name('event-registrations.export');

     Route::get('/donations', [DonationController::class, 'index'])
        ->name('donations.index');

    Route::get('/donations/export', [DonationController::class, 'export'])
        ->name('donations.export');

    Route::post('/transactions/{transaction}/verify', [DonationController::class, 'verify'])
        ->name('transactions.verify');

    Route::post('/transactions/{transaction}/refund', [DonationController::class, 'refund'])
        ->name('transactions.refund');

    Route::delete('/donations/{donation}', [DonationController::class, 'destroy'])
        ->name('donations.destroy');

    // Vision and Mission management routes
    Route::get('/visions-missions', [VisionMissionController::class, 'index'])
        ->name('visions-missions.index');

    Route::post('/visions-missions', [VisionMissionController::class, 'store'])
        ->name('visions-missions.store');

    Route::put('/visions-missions/{visionMission}', [VisionMissionController::class, 'update'])
        ->name('visions-missions.update');

    Route::post('/visions-missions/{visionMission}/toggle', [VisionMissionController::class, 'toggleActive'])
        ->name('visions-missions.toggle');

    Route::delete('/visions-missions/{visionMission}', [VisionMissionController::class, 'destroy'])
        ->name('visions-missions.destroy');
    
    // Social Link management routes
      Route::get('/social-links', [SocialLinkController::class, 'index'])
        ->name('social-links.index');

    Route::post('/social-links', [SocialLinkController::class, 'store'])
        ->name('social-links.store');

    Route::put('/social-links/{socialLink}', [SocialLinkController::class, 'update'])
        ->name('social-links.update');

    Route::post('/social-links/{socialLink}/toggle', [SocialLinkController::class, 'toggleActive'])
        ->name('social-links.toggle');

    Route::delete('/social-links/{socialLink}', [SocialLinkController::class, 'destroy'])
        ->name('social-links.destroy');
});

require __DIR__.'/auth.php';
