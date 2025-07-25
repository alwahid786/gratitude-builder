<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Insert default story setting
        DB::table('admin_settings')->insert([
            'key' => 'default_story_title',
            'value' => 'Your Gratitude Story',
            'type' => 'text',
            'group' => 'general',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            [
                'name' => 'wahid',
                'email' => 'wahidforjob@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'william',
                'email' => 'william@gmail.com',
                'password' => Hash::make('12345678'),
                'role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
        DB::table('admin_settings')->insert([
            'key' => 'default_story_content',
            'value' => 'In a small town nestled between rolling hills, there lived a young girl named Lily. Despite facing hardships, Lily always found moments of joy in the simple things. One day, a fierce storm swept through the town, leaving homes damaged and spirits shaken. Lily\'s family lost everything they owned in the flood, but amidst the chaos, Lily found something unexpected - gratitude.<br><br>As the community rallied together to rebuild, Lily witnessed acts of kindness that filled her heart with warmth. Neighbors helped neighbors, strangers offered a helping hand, and hope glimmered in the darkest of times. Despite the loss, Lily felt a deep sense of gratitude for the love and support surrounding her.<br><br>With determination and resilience, Lily and her family slowly pieced their life back together. Every day, Lily found something new to be thankful for - a roof over their heads, a warm meal shared with loved ones, and the unwavering strength of her community.<br><br>One evening, as the sun dipped below the horizon, casting a golden glow over the town, Lily stood on the porch of their new home. Tears welled up in her eyes as she thought about the journey they had been on. She whispered a heartfelt thank you to the universe for the lessons learned, the friendships forged, and the unwavering faith that carried them through.<br><br>In that moment, Lily realized that gratitude was not just about being thankful for what you have, but about finding beauty in the midst of chaos, strength in vulnerability, and hope in the face of adversity. And as she looked out at the twinkling lights of the town, she knew that no matter what challenges lay ahead, gratitude would always light the way.',
            'type' => 'textarea',
            'group' => 'general',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('admin_settings')->where('key', 'default_story_title')->delete();
        DB::table('admin_settings')->where('key', 'default_story_content')->delete();
    }
};
