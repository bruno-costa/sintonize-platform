<?php

namespace App\Models;

use App\Models\Traits\MultiplePrimaryKeys;
use Firebase\JWT\JWT;
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

    public function winCode()
    {
        if ($this->is_winner) {
            return JWT::encode(['u' => $this->app_user_id, 'c' => $this->content_id], env('APP_KEY'), 'HS256');
        }
        return null;
    }
}
