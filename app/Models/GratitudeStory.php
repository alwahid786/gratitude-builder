<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GratitudeStory extends Model
{
    protected $fillable = [
        'user_prompt',
        'generated_story',
        'title',
        'session_id',
        'user_id',
    ];

    // relationship to user
    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Unknown User',
            'email' => 'unknown@example.com'
        ]);
    }
}
