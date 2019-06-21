<?php

namespace App\Models;

use App\Models\Traits\MultiplePrimaryKeys;
use Illuminate\Database\Eloquent\Model;

class ContentParticipation extends Model
{
    use MultiplePrimaryKeys;

    public $incrementing = false;

    protected $primaryKey = ['app_user_id', 'content_id'];

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
