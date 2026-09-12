<?php

use App\Http\Controllers\ActivitiesController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CoreIdentityController;
use App\Http\Controllers\DonationController;
use App\Http\Controllers\DonationMethodController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\NoticeController;
use App\Models\Activity;
use App\Http\Controllers\ProfileController;
use App\Models\Notice;
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

Route::get('/about', function () {
    return Inertia::render('About');
})->name('about');

Route::get('/programs-and-services', function () {
    return Inertia::render('Programs',[
    ]);
})->name('programs');

 Route::get('/activities/{slug}', [HomeController::class, 'singleactivity'])->name('single.activity');

Route::get('/blog', function () {
    return Inertia::render('Blog');
})->name('blog');



Route::get('/user', function () {
    return Inertia::render('User/Profile');
})->name('user.profile');

 Route::get('/gallery', [GalleryController::class, 'gallery'])->name('gallery');
 Route::get('/blog', [BlogController::class, 'BlogPost'])->name('blog');


Route::get('/blog/{slug}', function ($slug) {
    return Inertia::render('Blog/Show', ['slug' => $slug]);
})->name('blog.show');

 Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

// Add these routes for CTA links
Route::get('/donate', function () {
    return Inertia::render('Donate');
})->name('donate');

Route::get('/volunteer', function () {
    return Inertia::render('Volunteer');
})->name('volunteer');

Route::get('/contact', function () {
    return Inertia::render('Contact');
})->name('contact');

Route::get('/events', function(){
    return Inertia::render('Event');
})->name('events');

Route::get('/get-involved', function(){
    return Inertia::render('Involved');
})->name('get-involved');

Route::post('/contact', [ContactController::class, 'contactsubmit'])->name('contact.submit');

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    Route::resource('activites', ActivitiesController::class);
    Route::resource('blogpost', BlogController::class);
    Route::resource('photos', GalleryController::class);
    Route::resource('notices', NoticeController::class);
    Route::resource('contactlist', ContactController::class);

    Route::get('/admin/home', [HomeController::class, 'homeadmin'])->name('home.admin');

    Route::post('/slide/update', [HomeController::class, 'update'])->name('slide.update');
    
    Route::resource('core-identities', CoreIdentityController::class);
    Route::resource('/features', FeatureController::class);


     // Donation Resource Routes (Main Section)
    Route::resource('donations', DonationController::class)->except(['index', 'create', 'store']);
    
    // Additional custom routes for donation
    Route::post('donations/{donation}/image', [DonationController::class, 'updateImage'])
        ->name('donations.update-image');
    
    // Donation Methods Resource Routes (Nested under donation)
    Route::resource('donations.methods', DonationMethodController::class)
        ->except(['show'])
        ->shallow(); 

    Route::patch('/donation/methods/{donationMethod}', [DonationMethodController::class, 'updateMethod'])->name('donations.methods.update');
    Route::delete('/donation/methods/{donationMethod}', [DonationMethodController::class, 'destroyMethod'])->name('donations.methods.destroy');

    
    // Bulk actions for donation methods
    Route::post('donation-methods/bulk-update', [DonationMethodController::class, 'bulkUpdate'])
        ->name('donation.methods.bulk-update');
    Route::post('donation-methods/reorder', [DonationMethodController::class, 'reorder'])
        ->name('donation.methods.reorder');


});

require __DIR__.'/auth.php';
