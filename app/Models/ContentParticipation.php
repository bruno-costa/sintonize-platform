<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContentParticipation extends Model
{
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

    /**
     * Set the keys for a save update query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function setKeysForSaveQuery(\Illuminate\Database\Eloquent\Builder $query)
    {
        $keys = $this->getKeyName();
        if(!is_array($keys)){
            return parent::setKeysForSaveQuery($query);
        }

        foreach($keys as $keyName){
            $query->where($keyName, '=', $this->getKeyForSaveQuery($keyName));
        }

        return $query;
    }

    /**
     * Get the primary key value for a save query.
     *
     * @param mixed $keyName
     * @return mixed
     */
    protected function getKeyForSaveQuery($keyName = null)
    {
        if(is_null($keyName)){
            $keyName = $this->getKeyName();
        }

        if (isset($this->original[$keyName])) {
            return $this->original[$keyName];
        }

        return $this->getAttribute($keyName);
    }


    public function content()
    {
        return $this->belongsTo(Content::class);
    }

    public function appUser()
    {
        return $this->belongsTo(AppUser::class);
    }
}
