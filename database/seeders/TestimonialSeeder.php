<?php

// database/seeders/TestimonialSeeder.php
namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class TestimonialSeeder extends Seeder
{
    public function run()
    {
        // Clear existing testimonials
        Testimonial::truncate();

        // Create directory if it doesn't exist
        if (!Storage::exists('public/testimonials')) {
            Storage::makeDirectory('public/testimonials');
        }

        // Sample avatar images (you need to add these to your public/images folder)
        $avatars = [
            'avatar1.jpg',
            'avatar2.jpeg',
            'avatar3.jpg',
            'avatar4.jpg',
            'avatar5.jpg',
        ];

        // Copy sample avatars to storage
        foreach ($avatars as $avatar) {
            if (file_exists(public_path("images/{$avatar}"))) {
                Storage::putFileAs(
                    'public/testimonials',
                    new \Illuminate\Http\File(public_path("images/{$avatar}")),
                    $avatar
                );
            }
        }

        $testimonials = [
            [
                'name' => 'Sarah Johnson',
                'title' => 'Food Blogger',
                'comment' => 'The best dining experience I\'ve had this year! The flavors were incredible and the service was impeccable.',
                'rating' => 5,
                'avatar' => 'testimonials/avatar1.jpg',
                'approved' => true,
                'date' => now()->subDays(10),
            ],
            [
                'name' => 'Michael Chen',
                'title' => 'Regular Customer',
                'comment' => 'Consistently excellent food and atmosphere. My go-to place for special occasions.',
                'rating' => 5,
                'avatar' => 'testimonials/avatar2.jpg',
                'approved' => true,
                'date' => now()->subDays(25),
            ],
            [
                'name' => 'Emma Rodriguez',
                'title' => 'First-time Visitor',
                'comment' => 'The chef\'s special was amazing! Will definitely be coming back with friends.',
                'rating' => 4,
                'avatar' => 'testimonials/avatar3.jpg',
                'approved' => true,
                'date' => now()->subDays(5),
            ],
            [
                'name' => 'David Wilson',
                'title' => 'Food Critic',
                'comment' => 'A perfect blend of traditional flavors and modern presentation. Highly recommended!',
                'rating' => 5,
                'avatar' => 'testimonials/avatar4.jpg',
                'approved' => true,
                'date' => now()->subDays(15),
            ],
            [
                'name' => 'Olivia Smith',
                'title' => 'Local Resident',
                'comment' => 'Great neighborhood spot with fantastic food and friendly staff.',
                'rating' => 4,
                'avatar' => 'testimonials/avatar5.jpg',
                'approved' => true,
                'date' => now()->subDays(30),
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::create($testimonial);
        }
    }
}
