<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentParticipation extends Model
{
    protected $fillable = [
        'app_user_id',
        'content_id',
        'is_winner',
        'promotion_answer_array',
    ];

    protected $casts = [
        'is_winner' => 'bool',
        'promotion_answer_array' => 'array',
    ];


    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function appUser()
    {
        return $this->belongsTo(AppUser::class);
    }
}
