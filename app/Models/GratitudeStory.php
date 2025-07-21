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
    ];
}
