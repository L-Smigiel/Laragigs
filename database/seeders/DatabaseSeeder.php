<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Listing;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(5)->create();

        $user = User::factory()->create([
            'name' => 'John Doe',
            'email' => 'john@gmail.com'
        ]);
        
        Listing::factory(6)->create([
            'user_id' => $user->id
        ]);

        // Listing::create([
        //     'title' => 'Laravel Senior Developer',
        //     'tags' => 'laravel, javascript',
        //     'company' => 'Acme Corp',
        //     'location' => 'Boston, MA',
        //     'email' => 'email@email.com',
        //     'website' => 'https://www.acme.com',
        //     'description' => 'Blabl ablablablaBl ablabla blablaBlablablablablaBlab lablablablaBlabla blablabla'
        // ]);

        // Listing::create([
        //         'title' => 'Full-stack Developer',
        //         'tags' => 'Javascript, JS',
        //         'company' => 'Some Corp',
        //         'location' => 'New York, NY',
        //         'email' => 'email2@email.com',
        //         'website' => 'https://www.some.com',
        //         'description' => '2Blabl ablablablaBl ablabla blablaBlablablablablaBlab lablablablaBlabla blablabla'
        //     ]);

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
